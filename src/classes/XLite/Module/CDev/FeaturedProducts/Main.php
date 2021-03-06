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
 * @subpackage ____sub_package____
 * @author     Creative Development LLC <info@cdev.ru>
 * @copyright  Copyright (c) 2011 Creative Development LLC <info@cdev.ru>. All rights reserved
 * @license    http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link       http://www.litecommerce.com/
 * @see        ____file_see____
 * @since      1.0.0
 */

namespace XLite\Module\CDev\FeaturedProducts;

/**
 * Featured Products module manager
 *
 * @package XLite
 * @see     ____class_see____
 * @since   1.0.0
 */
abstract class Main extends \XLite\Module\AModule
{
    /**
     * Author name
     *
     * @var    string
     * @access public
     * @see    ____func_see____
     * @since  1.0.0
     */
    public static function getAuthorName()
    {
        return 'Creative Development LLC';
    }

    const FEATURED_PRODUCTS_TABLE = 'xlite_featured_products';

    /**
     * Module version
     *
     * @var    string
     * @access public
     * @see    ____func_see____
     * @since  1.0.0
     */
    public static function getMinorVersion()
    {
        return '0';
    }

    /**
     * Module name
     *
     * @var    string
     * @access public
     * @see    ____func_see____
     * @since  1.0.0
     */
    public static function getModuleName()
    {
        return 'Featured Products';
    }

    /**
     * Module description
     *
     * @var    string
     * @access public
     * @see    ____func_see____
     * @since  1.0.0
     */
    public static function getDescription()
    {
        return 'This module enables featured products list';
    }

    /**
     * Determines if we need to show settings form link
     *
     * @return boolean
     * @access public
     * @see    ____func_see____
     * @since  1.0.0
     */
    public static function showSettingsForm()
    {
        return true;
    }

    /**
     * Get post-installation user notes
     *
     * @return string
     * @access public
     * @see    ____func_see____
     * @since  1.0.0
     */
    public static function getPostInstallationNotes()
    {
        return '<b>Tip:</b> To create featured products, '
            . 'go to <a href="admin.php?target=categories">Catalog > '
            . 'Categories</a> menu and add featured product in the bottom form.';
    }
}
