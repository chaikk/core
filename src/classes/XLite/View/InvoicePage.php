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

namespace XLite\View;

/**
 * Invoice widget
 *
 * @see   ____class_see____
 * @since 1.0.0
 *
 * @ListChild (list="center")
 */
class InvoicePage extends \XLite\View\Dialog
{
    /**
     * Order (cache)
     *
     * @var   \XLite\Model\Order
     * @see   ____var_see____
     * @since 1.0.0
     */
    protected $order;

    /**
     * Return list of targets allowed for this widget
     *
     * @return array
     * @see    ____func_see____
     * @since  1.0.0
     */
    public static function getAllowedTargets()
    {
        $result = parent::getAllowedTargets();
        $result[] = 'invoice';

        return $result;
    }

    /**
     * Get order
     *
     * @return \XLite\Model\Order
     * @see    ____func_see____
     * @since  1.0.0
     */
    public function getOrder()
    {
        if (!isset($this->order)) {
            $this->order = \XLite\Core\Database::getRepo('XLite\Model\Order')
                ->find(\XLite\Core\Request::getInstance()->order_id);
        }

        return $this->order;
    }

    /**
     * Check widget visibility
     *
     * @return boolean
     * @see    ____func_see____
     * @since  1.0.0
     */
    protected function isVisible()
    {
        return parent::isVisible() && $this->getOrder();
    }

    /**
     * Return title
     *
     * @return string
     * @see    ____func_see____
     * @since  1.0.0
     */
    protected function getHead()
    {
        return 'Order #' . $this->getOrder()->getOrderId();
    }

    /**
     * Return templates directory name
     *
     * @return string
     * @see    ____func_see____
     * @since  1.0.0
     */
    protected function getDir()
    {
        return 'order' . LC_DS . 'invoice';
    }

    /**
     * Return file name for the center part template
     *
     * @return string
     * @see    ____func_see____
     * @since  1.0.0
     */
    protected function getBody()
    {
        return $this->getDir() . LC_DS . 'page.tpl';
    }
}
