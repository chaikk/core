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

namespace XLite\Module\CDev\DrupalConnector\Controller\Console;

/**
 * Cron
 *
 * @see   ____class_see____
 * @since 1.0.0
 */
class Cron extends \XLite\Controller\Console\Cron implements \XLite\Base\IDecorator
{
    /**
     * Run tasks processor direct, without check access
     *
     * @return void
     * @see    ____func_see____
     * @since  1.0.0
     */
    public function runTasksDirect()
    {
        $this->doNoAction();
    }
}
