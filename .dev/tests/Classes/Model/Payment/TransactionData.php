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
 * @subpackage Classes
 * @author     Creative Development LLC <info@cdev.ru> 
 * @copyright  Copyright (c) 2010 Creative Development LLC <info@cdev.ru>. All rights reserved
 * @license    http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @version    SVN: $Id$
 * @link       http://www.litecommerce.com/
 * @see        ____file_see____
 * @since      3.0.0
 */

class XLite_Tests_Model_Payment_TransactionData extends XLite_Tests_TestCase
{
    protected $testMethod = array(
        'service_name' => 'test',
        'class'        => 'Model\Payment\Processor\Offline',
        'orderby'      => 100,
        'enabled'      => false,
        'name'         => 'Test',
        'description'  => 'Description',
    );

    public function testCreate()
    {
        $order = $this->getTestOrder();

        $t = $order->getPaymentTransactions()->get(0);

        $this->assertTrue(0 < $t->getData()->get(0)->getDataId(), 'check record id');
        $this->assertEquals(2, count($t->getData()), 'check data length');

        $r = $t->getData()->get(0);
        $this->assertEquals('r1', $r->getName(), 'check name');
        $this->assertEquals('Record 1', $r->getLabel(), 'check label');
        $this->assertEquals('1', $r->getValue(), 'check value');
        $this->assertEquals($t, $r->getTransaction(), 'check transaction');

        $r = $t->getData()->get(1);
        $this->assertEquals('r2', $r->getName(), 'check name #2');
        $this->assertEquals('Record 2', $r->getLabel(), 'check label #2');
        $this->assertEquals('2', $r->getValue(), 'check value #2');
        $this->assertEquals($t, $r->getTransaction(), 'check transaction #2');
    }

    public function testUpdate()
    {
        $order = $this->getTestOrder();

        $t = $order->getPaymentTransactions()->get(0);
        $r = $t->getData()->get(0);

        $r->setName('r0');
        $r->setLabel('Record 0');
        $r->setValue('0');
        $r->setAccessLevel($r::ACCESS_CUSTOMER);

        \XLite\Core\Database::getEM()->persist($t);
        \XLite\Core\Database::getEM()->flush();

        $r = \XLite\Core\Database::getRepo('XLite\Model\Payment\TransactionData')
            ->find($r->getDataId());

        $this->assertEquals('r0', $r->getName(), 'check name');
        $this->assertEquals('Record 0', $r->getLabel(), 'check label');
        $this->assertEquals('0', $r->getValue(), 'check value');
        $this->assertEquals($r::ACCESS_CUSTOMER, $r->getAccessLevel(), 'check access level');
    }

    public function testDelete()
    {
        $order = $this->getTestOrder();

        $t = $order->getPaymentTransactions()->get(0);
        $r = $t->getData()->get(0);

        $id = $r->getDataId();
        $t->getData()->removeElement($r);

        \XLite\Core\Database::getEM()->remove($r);
        \XLite\Core\Database::getEM()->flush();

        $r = \XLite\Core\Database::getRepo('XLite\Model\Payment\TransactionData')
            ->find($id);

        $this->assertNull($r, 'check removed record');
    }

    public function testIsAvailable()
    {
       $order = $this->getTestOrder();

        $t = $order->getPaymentTransactions()->get(0);
        $r = $t->getData()->get(0);

        if (\XLite::isAdminZone()) {

            $r->setAccessLevel($r::ACCESS_ADMIN);
            $this->assertTrue($r->isAvailable(), 'check admin access');

            $r->setAccessLevel($r::ACCESS_CUSTOMER);
            $this->assertTrue($r->isAvailable(), 'check admin access #2');

        } else {

            $r->setAccessLevel($r::ACCESS_ADMIN);
            $this->assertFalse($r->isAvailable(), 'check customer access');

            $r->setAccessLevel($r::ACCESS_CUSTOMER);
            $this->assertTrue($r->isAvailable(), 'check customer access #2');

        }
    }

    protected function getTestMethod()
    {
        $method = new \XLite\Model\Payment\Method();

        $method->map($this->testMethod);

        $s = new \XLite\Model\Payment\MethodSetting();

        $s->setName('t1');
        $s->setValue('1');

        $method->addSettings($s);
        $s->setPaymentMethod($method);

        $s = new \XLite\Model\Payment\MethodSetting();

        $s->setName('t2');
        $s->setValue('2');

        $method->addSettings($s);
        $s->setPaymentMethod($method);

        \XLite\Core\Database::getEM()->persist($method);
        \XLite\Core\Database::getEM()->flush();

        return $method;
    }

    protected function getProduct()
    {
        return \XLite\Core\Database::getRepo('XLite\Model\Product')->findOneByEnabled(true);
    }

    protected function getTestOrder()
    {
        $order = new \XLite\Model\Order();

        $profile = new \XLite\Model\Profile();
        $list = $profile->findAll();
        $profile = array_shift($list);
        unset($list);

        $order->setCurrency(\XLite\Core\Database::getRepo('XLite\Model\Currency')->find(840));
        $order->setProfileId(0);

        \XLite\Core\Database::getEM()->persist($order);
        \XLite\Core\Database::getEM()->flush();

        $item = new \XLite\Model\OrderItem();

        $item->setProduct($this->getProduct());
        $item->setAmount(1);
        $item->setPrice($this->getProduct()->getPrice());

        $order->addItem($item);

        \XLite\Core\Database::getEM()->persist($order);
        \XLite\Core\Database::getEM()->flush();

        $order->setProfileCopy($profile);
        $order->calculate();

        $order->setPaymentMethod($this->getTestMethod());

        $t = $order->getPaymentTransactions()->get(0);

        $r = new \XLite\Model\Payment\TransactionData();

        $r->setName('r1');
        $r->setLabel('Record 1');
        $r->setValue(1);

        $t->addData($r);
        $r->setTransaction($t);

        $r = new \XLite\Model\Payment\TransactionData();

        $r->setName('r2');
        $r->setLabel('Record 2');
        $r->setValue(2);

        $t->addData($r);
        $r->setTransaction($t);

        \XLite\Core\Database::getEM()->persist($order);
        \XLite\Core\Database::getEM()->flush();

        return $order;
    }
}