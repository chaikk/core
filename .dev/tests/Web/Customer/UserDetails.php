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
 * @package    Tests
 * @subpackage Web
 * @author     Creative Development LLC <info@cdev.ru> 
 * @copyright  Copyright (c) 2010 Creative Development LLC <info@cdev.ru>. All rights reserved
 * @license    http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @version    SVN: $Id$
 * @link       http://www.litecommerce.com/
 * @see        ____file_see____
 * @since      3.0.0
 */

require_once __DIR__ . '/ACustomer.php';

class XLite_Web_Customer_userDetails extends XLite_Web_Customer_ACustomer
{
    protected function login()
    {
        $this->open('user');

        $this->type('css=#edit-name', 'master');
        $this->type('css=#edit-pass', 'master');

        $this->submitAndWait('css=#user-login');

        $this->open('user/1/edit');
    }

    public function testUpdate()
    {
        $this->login();

        $email = 'rnd_tester' . time() . '@cdev.ru';

        // Change
        $this->type('css=#edit-pass-pass1', 'master');
        $this->type('css=#edit-pass-pass2', 'master');
        $this->typeKeys(
            'css=#edit-mail',
            $email
        );

        $this->clickAndWait('css=#edit-submit');

        $this->assertEquals(
            $email,
            $this->getJSExpression('$("#edit-mail").val()'),
            'check changed email'
        );
        $this->assertJqueryNotPresent('#status-messages ul li.error', 'check errors');

        // Revert
        $this->type('css=#edit-pass-pass1', 'master');
        $this->type('css=#edit-pass-pass2', 'master');
        $this->typeKeys(
            'css=#edit-mail',
            'rnd_tester@cdev.ru'
        );

        $this->clickAndWait('css=#edit-submit');
    }

    public function testPassword()
    {
        $this->login();

        // Check password strength
        $this->typeKeys(
            'css=#edit-pass-pass1',
            '123'
        );
        $this->waitForLocalCondition(
            '$("#edit-pass-pass1-wrapper .password-strength .error").html() == "Low"',
            3000,
            'check Low label'
        );

        $this->typeKeys(
            'css=#edit-pass-pass1',
            '123lakjsdhf'
        );
        $this->waitForLocalCondition(
            '$("#edit-pass-pass1-wrapper .password-strength .warning").html() == "Medium"',
            3000,
            'check Medium label'
        );

        $this->typeKeys(
            'css=#edit-pass-pass1',
            '123lakjsdhf(*&%A'
        );
        $this->waitForLocalCondition(
            '$("#edit-pass-pass1-wrapper .password-strength .ok").html() == "High"',
            3000,
            'check High label'
        );

        // Check password confirm
        $this->typeKeys(
            'css=#edit-pass-pass1',
            '123'
        );
        $this->typeKeys(
            'css=#edit-pass-pass2',
            '456'
        );
        $this->waitForLocalCondition(
            '$("#edit-pass-pass2-wrapper .password-confirm .error").html() == "No"',
            3000,
            'check No label'
        );

        $this->typeKeys(
            'css=#edit-pass-pass2',
            '123'
        );
        $this->waitForLocalCondition(
            '$("#edit-pass-pass2-wrapper .password-confirm .ok").html() == "Yes"',
            3000,
            'check Yes label'
        );

        // Submit wrong password
        $this->type('css=#edit-pass-pass1', 'master1');
        $this->type('css=#edit-pass-pass2', 'master2');

        $this->clickAndWait('css=#edit-submit');

        $this->assertJqueryPresent('#status-messages ul li.error', 'check errors');
    }
}