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
class XLite_Controller_Customer_Captcha extends XLite_Controller_Customer_Abstract
{
    public $params = array('target', 'id');
    
    function handleRequest()
    {
        $captcha = new XLite_Model_CaptchaGenerator();
        $length = ((int) $this->getComplex('config.Captcha.captcha_length') > 0) ? (int) $this->getComplex('config.Captcha.captcha_length') : 5;
        $code = $captcha->generateCode($length);

        $this->session->set("captcha_".$this->get('id'), $code);

        $im = $captcha->generate($code);

        header("Content-type:image/png");
        imagepng($im);
        imagedestroy($im);
    }
}