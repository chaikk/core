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

namespace XLite\Controller\Admin;

/**
 * Profile management controller
 *
 * @see   ____class_see____
 * @since 1.0.0
 */
class AddressBook extends \XLite\Controller\Admin\AAdmin
{
    /**
     * address
     *
     * @var   \XLite\Model\Address
     * @see   ____var_see____
     * @since 1.0.0
     */
    protected $address = null;


    /**
     * Return the current page title (for the content area)
     *
     * @return string
     * @see    ____func_see____
     * @since  1.0.0
     */
    public function getTitle()
    {
        return \XLite\Core\Request::getInstance()->widget ? $this->t('Address details') : $this->t('Edit profile');
    }

    /**
     * getAddress
     *
     * @return \XLite\Model\Address
     * @see    ____func_see____
     * @since  1.0.0
     */
    public function getAddress()
    {
        return $this->address = $this->getModelForm()->getModelObject();
    }

    /**
     * Get return URL
     *
     * @return string
     * @see    ____func_see____
     * @since  1.0.0
     */
    public function getReturnURL()
    {
        if (\XLite\Core\Request::getInstance()->action) {

            $profileId = \XLite\Core\Request::getInstance()->profile_id;

            if (!isset($profileId)) {

                $profileId = $this->getAddress()->getProfile()->getProfileId();

                if (\XLite\Core\Auth::getInstance()->getProfile()->getProfileId() === $profileId) {
                    unset($profileId);
                }
            }

            $params = isset($profileId) ? array('profile_id' => $profileId) : array();

            $url = $this->buildURL('address_book', '', $params);

        } else {
            $url = parent::getReturnURL();
        }

        return $url;
    }

    /**
     * Alias
     *
     * @return \XLite\Model\Profile
     * @see    ____func_see____
     * @since  1.0.0
     */
    protected function getProfile()
    {
        return $this->getModelForm()->getModelObject()->getProfile() ?: new \XLite\Model\Profile();
    }

    /**
     * Common method to determine current location
     *
     * @return string
     * @see    ____var_see____
     * @since  1.0.0
     */
    protected function getLocation()
    {
        return $this->getProfile()->getLogin();
    }

    /**
     * Add part to the location nodes list
     *
     * @return void
     * @see    ____func_see____
     * @since  1.0.0
     */
    protected function addBaseLocation()
    {
        parent::addBaseLocation();

        $this->addLocationNode($this->t('Search profiles'), $this->buildURL('users'));
    }

    /**
     * getModelFormClass
     *
     * @return string
     * @see    ____func_see____
     * @since  1.0.0
     */
    protected function getModelFormClass()
    {
        return '\XLite\View\Model\Address\Address';
    }

    /**
     * doActionSave
     *
     * @return void
     * @see    ____func_see____
     * @since  1.0.0
     */
    protected function doActionSave()
    {
        return $this->getModelForm()->performAction('update');
    }

    /**
     * doActionDelete
     *
     * @return void
     * @see    ____func_see____
     * @since  1.0.0
     */
    protected function doActionDelete()
    {
        $address = $this->getAddress();

        if (isset($address)) {
            \XLite\Core\Database::getEM()->remove($address);
            \XLite\Core\Database::getEM()->flush();

            \XLite\Core\TopMessage::addInfo(
                $this->t('Address has been deleted')
            );
        }
    }

    /**
     * doActionCancelDelete
     *
     * @return void
     * @see    ____func_see____
     * @since  1.0.0
     */
    protected function doActionCancelDelete()
    {
        // Do nothing, action is needed just for redirection back
    }
}
