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
 * @category   LiteCommerce
 * @package    XLite
 * @subpackage Controller
 * @author     Creative Development LLC <info@cdev.ru>
 * @copyright  Copyright (c) 2011 Creative Development LLC <info@cdev.ru>. All rights reserved
 * @license    http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link       http://www.litecommerce.com/
 * @see        ____file_see____
 * @since      1.0.0
 */

namespace XLite\Module\CDev\Demo\Controller\Admin;

/**
 * AddressBook
 *
 * @package XLite
 * @see     ____class_see____
 * @since   1.0.0
 */
class AddressBook extends \XLite\Controller\Admin\AddressBook implements \XLite\Base\IDecorator
{
    /**
     * Check if we need to forbid current action
     *
     * @return boolean
     * @access protected
     * @see    ____func_see____
     * @since  1.0.0
     */
    protected function checkForDemoController()
    {
        return parent::checkForDemoController() && \XLite::isAdminZone();
    }

    /**
     * URL to redirect if action is forbidden
     *
     * @return string
     * @access protected
     * @see    ____func_see____
     * @since  1.0.0
     */
    protected function getForbidInDemoModeRedirectURL()
    {
        return \XLite\Core\Converter::buildURL(
            'address_book', 
            '',
            $this->getProfile()->getProfileId()
            ? array('profile_id' => $this->getProfile()->getProfileId())
            : array()
        );
    }
}
