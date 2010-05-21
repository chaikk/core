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
 * @copyright  Copyright (c) 2010 Creative Development LLC <info@cdev.ru>. All rights reserved
 * @license    http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @version    SVN: $Id$
 * @link       http://www.litecommerce.com/
 * @see        ____file_see____
 * @since      3.0.0
 */

/**
 * ____description____
 * 
 * @package XLite
 * @see     ____class_see____
 * @since   3.0.0
 */
class XLite_Controller_Customer_Login extends XLite_Controller_Customer_Abstract
{
    /**
     * Common method to determine current location 
     * 
     * @return string
     * @access protected
     * @since  3.0.0
     */
    protected function getLocation()
    {
        return 'Authentication';
    }

    /**
     * Perform some actions before redirect
     *
     * @param mixed $action performed action
     *
     * @return void
     * @access protected
     * @since  3.0.0
     */
    protected function actionPostprocess($action)
    {
        parent::actionPostprocess($action);

        if ('login' == $action) {
            $this->redirectFromLogin();
        }
    }

    /**
     * Return URL to redirect from login
     * 
     * @return string
     * @access protected
     * @since  3.0.0
     */
    protected function getRedirectFromLoginURL()
    {
        return null;
    }


    /**
     * Perform some actions after the "login" action
     * 
     * @return void
     * @access public
     * @since  3.0.0
     */
    public function redirectFromLogin()
    {
        $url = $this->getRedirectFromLoginURL();

        if (isset($url)) {
            XLite_Core_CMSConnector::isCMSStarted() ? XLite_Core_Operator::getInstance()->redirect($url) : $this->setReturnUrl($url);
        }
    }



    public $params = array('target', "mode");

    protected $profile = null;

    function action_login()
    {
        $this->profile = $this->auth->login(XLite_Core_Request::getInstance()->login, XLite_Core_Request::getInstance()->password);

        if ($this->profile === ACCESS_DENIED) {
            $this->set('valid', false);
            return;
        }

        $this->set('returnUrl', XLite_Core_Request::getInstance()->returnUrl);

        if (!$this->get('returnUrl')) {
            $cart = XLite_Model_Cart::getInstance();
            $url = $this->getComplex('xlite.script');
            if (!$cart->get('empty')) {
                $url .= "?target=cart";
            }

            $this->set('returnUrl', $url);
        }

        $cart = XLite_Model_Cart::getInstance();
        $cart->set('profile_id', $this->profile->get('profile_id'));

        $this->recalcCart();
    }

    function getShopUrl($url, $secure = false, $pure_url = false)
    {
        $add = (strpos($url, '?') ? '&' : '?') . 'feed='.$this->get('action');
        return parent::getShopUrl($url . $add, $secure);
    }

    function action_logoff()
    {
        $this->auth->logoff();
        $this->returnUrl = $this->getComplex('xlite.script');
        if (!$this->getCart()->get('empty')) {
        	if ($this->config->getComplex('Security.logoff_clear_cart') == "Y") {
            	$this->getCart()->delete();
        	} else {
                $this->recalcCart();
        	}
        }
    }

    function getSecure()
    {
        if ($this->get('action') == "login") {
            return $this->getComplex('config.Security.customer_security');
        }
        return false;
    }
}