<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * LiteCommerce
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to licensing@litecommerce.com so we can send you a copy immediately.
 *
 * PHP version 5.3.0
 *
 * @category  LiteCommerce
 * @author    Creative Development LLC <info@cdev.ru>
 * @copyright Copyright (c) 2011 Creative Development LLC <info@cdev.ru>. All rights reserved
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      http://www.litecommerce.com/
 * @see       ____file_see____
 * @since     1.0.0
 */

namespace XLite\Controller\Customer;

/**
 * \XLite\Controller\Customer\Cart
 *
 * @see   ____class_see____
 * @since 1.0.0
 */
class Cart extends \XLite\Controller\Customer\ACustomer
{
    /**
     * Initialize controller
     *
     * @return void
     * @see    ____func_see____
     * @since  1.0.0
     */
    public function init()
    {
        parent::init();

        $this->checkItemsAmount();
    }

    /**
     * Get page title
     *
     * @return string
     * @see    ____func_see____
     * @since  1.0.0
     */
    public function getTitle()
    {
        return $this->getCart()->isEmpty()
            ? $this->t('Your shopping bag is empty')
            : $this->t('Your shopping bag - X items', array('count' => $this->getCart()->countQuantity()));
    }

    /**
     * isSecure
     * TODO: check if this method is used
     *
     * @return void
     * @see    ____func_see____
     * @since  1.0.0
     */
    public function isSecure()
    {
        return $this->is('HTTPS') ? true : parent::isSecure();
    }


    /**
     * Common method to determine current location
     *
     * @return string
     * @see    ____func_see____
     * @since  1.0.0
     */
    protected function getLocation()
    {
        return $this->getTitle();
    }

    /**
     * Return current product Id
     *
     * @return integer
     * @see    ____func_see____
     * @since  1.0.0
     */
    protected function getProductId()
    {
        return intval(\XLite\Core\Request::getInstance()->product_id);
    }

    /**
     * Return product amount
     *
     * @return integer
     * @see    ____func_see____
     * @since  1.0.0
     */
    protected function getAmount()
    {
        return intval(\XLite\Core\Request::getInstance()->amount);
    }

    /**
     * Alias
     *
     * @return \XLite\Model\Product
     * @see    ____func_see____
     * @since  1.0.0
     */
    protected function getProduct()
    {
        return \XLite\Core\Database::getRepo('XLite\Model\Product')->find($this->getProductId());
    }

    /**
     * Get available amount for the product
     *
     * @param \XLite\Model\Product $product Product to add
     *
     * @return integer
     * @see    ____func_see____
     * @since  1.0.0
     */
    protected function getProductAvailableAmount(\XLite\Model\Product $product)
    {
        return $product->getInventory()->getAvailableAmount();
    }

    /**
     * Get total inventory amount for the product
     *
     * @param \XLite\Model\Product $product Product to check
     *
     * @return integer
     * @see    ____func_see____
     * @since  1.0.0
     */
    protected function getProductAmount(\XLite\Model\Product $product)
    {
        return $product->getInventory()->getAmount();
    }

    /**
     * Check if the requested amount is available for the product
     *
     * @param \XLite\Model\Product $product Product to add
     * @param integer              $amount  Amount to check OPTIONAL
     *
     * @return integer
     * @see    ____func_see____
     * @since  1.0.0
     */
    protected function checkAmount(\XLite\Model\Product $product, $amount = null)
    {
        return !$product->getInventory()->getEnabled();
    }

    /**
     * Check product amount before add it to the cart
     *
     * @param \XLite\Model\Product $product Product to add
     *
     * @return boolean
     * @see    ____func_see____
     * @since  1.0.0
     */
    protected function checkAmountToAdd(\XLite\Model\Product $product)
    {
        return $this->checkAmount($product)
            || $this->getProductAvailableAmount($product) >= $this->getAmount();
    }

    /**
     * Check amount for all cart items
     *
     * @return void
     * @see    ____func_see____
     * @since  1.0.0
     */
    protected function checkItemsAmount()
    {
        foreach ($this->getCart()->getItemsWithWrongAmounts() as $item) {
            $product = $item->getProduct();
            $this->processInvalidAmountError($product, $this->getProductAmount($product));
        }
    }

    /**
     * Correct product amount
     *
     * @param \XLite\Model\Product $product Product to add
     *
     * @return integer
     * @see    ____func_see____
     * @since  1.0.0
     */
    protected function correctAmount(\XLite\Model\Product $product)
    {
        $amount = $this->getAmount();

        if (!$this->checkAmountToAdd($product)) {
            $amount = $this->getProductAvailableAmount($product);
            $this->processInvalidAmountError($product, $this->getProductAvailableAmount($product));
        }

        return $amount;
    }

    /**
     * Get (and create) current cart item
     *
     * @param \XLite\Model\Product $product Product to add
     *
     * @return void
     * @see    ____func_see____
     * @since  1.0.0
     */
    protected function getCurrentItem(\XLite\Model\Product $product)
    {
        $item = new \XLite\Model\OrderItem();

        $item->setProduct($product);
        $item->setAmount($this->correctAmount($product));

        return $item;
    }

    /**
     * Add product to the cart
     *
     * @return boolean
     * @see    ____func_see____
     * @since  1.0.0
     */
    protected function addCurrentItem()
    {
        return ($product = $this->getProduct()) && $this->getCart()->addItem($this->getCurrentItem($product));
    }

    /**
     * Show message about wrong product amount
     *
     * @param \XLite\Model\Product $product Product to process
     * @param integer              $amount  Available amount
     *
     * @return void
     * @see    ____func_see____
     * @since  1.0.0
     */
    protected function processInvalidAmountError(\XLite\Model\Product $product, $amount)
    {
        \XLite\Core\TopMessage::addWarning(
            'Only ' . $amount . ' items are available for the "' . $product->getName() . '" product'
        );
    }

    /**
     * Process 'Add item' error
     *
     * @return void
     * @see    ____func_see____
     * @since  1.0.0
     */
    protected function processAddItemError()
    {
        if (\XLite\Model\Cart::NOT_VALID_ERROR == $this->getCart()->getAddItemError()) {
            \XLite\Core\TopMessage::addError('Product has not been added to cart');
        }
    }

    /**
     * Process 'Add item' success
     *
     * @return void
     * @see    ____func_see____
     * @since  1.0.0
     */
    protected function processAddItemSuccess()
    {
        \XLite\Core\TopMessage::addInfo('Product has been added to the cart');
    }

    /**
     * URL to return after product is added
     *
     * @return string
     * @see    ____func_see____
     * @since  1.0.0
     */
    protected function getURLToReturn()
    {
        $url = \XLite\Core\Session::getInstance()->productListURL;

        if (!$url) {
            $url = empty($_SERVER['HTTP_REFERER'])
                ? $this->buildURL('product', '', array('product_id' => $this->getProductId()))
                : $_SERVER['HTTP_REFERER'];
        }

        return $url;
    }

    /**
     * URL to return after product is added
     *
     * @return string
     * @see    ____func_see____
     * @since  1.0.0
     */
    protected function setURLToReturn()
    {
        \XLite\Core\Session::getInstance()->continueURL = $this->getURLToReturn();

        if (\XLite\Core\Config::getInstance()->General->redirect_to_cart) {

            // Hard redirect to cart
            $this->setReturnURL($this->buildURL('cart'));

            $this->setHardRedirect();

        } else {

            $this->setReturnURL($this->getURLToReturn());
        }
    }

    /**
     * Add product to cart
     *
     * @return boolean
     * @see    ____func_see____
     * @since  1.0.0
     */
    protected function doActionAdd()
    {
        // Add product to the cart and set a top message (if needed)
        $this->addCurrentItem() ? $this->processAddItemSuccess() : $this->processAddItemError();

        // Update cart
        $this->updateCart();

        // Set return URL
        $this->setURLToReturn();
    }


    // TODO: refactoring

    /**
     * 'delete' action
     *
     * @return void
     * @see    ____func_see____
     * @since  1.0.0
     */
    protected function doActionDelete()
    {
        $item = $this->getCart()->getItemByItemId(\XLite\Core\Request::getInstance()->cart_id);

        if ($item) {
            $this->getCart()->getItems()->removeElement($item);
            \XLite\Core\Database::getEM()->remove($item);
            $this->updateCart();

            \XLite\Core\TopMessage::addInfo('Item has been deleted from cart');

        } else {
            $this->valid = false;
            \XLite\Core\TopMessage::addError(
                'Item has not been deleted from cart'
            );
        }
    }

    /**
     * Update cart
     *
     * @return void
     * @see    ____func_see____
     * @since  1.0.0
     */
    protected function doActionUpdate()
    {
        // Update quantity
        $cartId = \XLite\Core\Request::getInstance()->cart_id;
        $amount = \XLite\Core\Request::getInstance()->amount;
        if (!is_array($amount)) {
            $amount = isset(\XLite\Core\Request::getInstance()->cart_id)
                ? array($cartId => $amount)
                : array();

        } elseif (isset($cartId)) {
            $amount = isset($amount[$cartId])
                ? array($cartId => $amount[$cartId])
                : array();
        }

        $result = false;

        foreach ($amount as $id => $quantity) {
            $item = $this->getCart()->getItemByItemId($id);
            if ($item) {
                $item->setAmount($quantity);
                $result = true;
            }
        }

        // Update shipping method
        if (isset(\XLite\Core\Request::getInstance()->shipping)) {
            $this->getCart()->setShippingId(\XLite\Core\Request::getInstance()->shipping);
            $result = true;
        }

        if ($result) {
            $this->updateCart();
        }
    }

    /**
     * 'checkout' action
     *
     * @return void
     * @see    ____func_see____
     * @since  1.0.0
     */
    protected function doActionCheckout()
    {
        $this->doActionUpdate();

        // switch to checkout dialog
        $this->setReturnURL($this->buildURL('checkout'));
    }

    /**
     * Clear cart
     *
     * @return void
     * @see    ____func_see____
     * @since  1.0.0
     */
    protected function doActionClear()
    {
        if (!$this->getCart()->isEmpty()) {
            foreach ($this->getCart()->getItems() as $item) {
                \XLite\Core\Database::getEM()->remove($item);
            }
            $this->getCart()->getItems()->clear();

            $this->updateCart();
        }

        \XLite\Core\TopMessage::addInfo('Item has been deleted from cart');
        $this->setReturnUrl($this->buildURL('cart'));
    }

}
