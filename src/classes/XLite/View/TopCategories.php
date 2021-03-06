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
 * Sidebar categories list
 *
 * @see   ____class_see____
 * @since 1.0.0
 *
 * @ListChild (list="sidebar.first", zone="customer", weight="100")
 */
class TopCategories extends \XLite\View\SideBarBox
{
    /**
     * Widget parameter names
     */
    const PARAM_DISPLAY_MODE = 'displayMode';
    const PARAM_ROOT_ID      = 'rootId';
    const PARAM_IS_SUBTREE   = 'is_subtree';

    /**
     * Allowed display modes
     */
    const DISPLAY_MODE_LIST = 'list';
    const DISPLAY_MODE_TREE = 'tree';
    const DISPLAY_MODE_PATH = 'path';


    /**
     * Display modes (template directories)
     *
     * @var   array
     * @see   ____var_see____
     * @since 1.0.0
     */
    protected $displayModes = array(
        self::DISPLAY_MODE_LIST => 'List',
        self::DISPLAY_MODE_TREE => 'Tree',
        self::DISPLAY_MODE_PATH => 'Path',
    );

    /**
     * Current category path id list
     *
     * @var   array
     * @see   ____var_see____
     * @since 1.0.0
     */
    protected $pathIds;


    /**
     * Display item CSS class name as HTML attribute
     *
     * @param integer               $index    Item number
     * @param integer               $count    Items count
     * @param \XLite\Model\Category $category Current category
     *
     * @return string
     * @see    ____func_see____
     * @since  1.0.0
     */
    public function displayItemClass($index, $count, \XLite\Model\Category $category)
    {
        $className = $this->assembleItemClassName($index, $count, $category);

        return $className ? ' class="' . $className . '"' : '';
    }

    /**
     * Display item link class name as HTML attribute
     *
     * @param integer               $i        Item number
     * @param integer               $count    Items count
     * @param \XLite\Model\Category $category Current category
     *
     * @return string
     * @see    ____func_see____
     * @since  1.0.0
     */
    public function displayLinkClass($i, $count, \XLite\Model\Category $category)
    {
        $className = $this->assembleLinkClassName($i, $count, $category);

        return $className ? ' class="' . $className . '"' : '';
    }

    /**
     * Display item children container class as HTML attribute
     *
     * @param integer           $i      Item number
     * @param integer           $count  Items count
     * @param \XLite\View\AView $widget Current category
     *
     * @return string
     * @see    ____func_see____
     * @since  1.0.0
     */
    public function displayListItemClass($i, $count, \XLite\View\AView $widget)
    {
        $className = $this->assembleListItemClassName($i, $count, $widget);

        return $className ? ' class="' . $className . '"' : '';
    }

    /**
     * Get widge title
     *
     * @return string
     * @see    ____func_see____
     * @since  1.0.0
     */
    protected function getHead()
    {
        return 'Categories';
    }

    /**
     * Get widget templates directory
     *
     * @return string
     * @see    ____func_see____
     * @since  1.0.0
     */
    protected function getDir()
    {
        return 'categories/' . $this->getParam(self::PARAM_DISPLAY_MODE);
    }

    /**
     * Return subcategories list
     *
     * @param integer $categoryId Category id OPTIONAL
     *
     * @return array
     * @see    ____func_see____
     * @since  1.0.0
     */
    protected function getCategories($categoryId = null)
    {
        $category = \XLite\Core\Database::getRepo('\XLite\Model\Category')->getCategory(
            $categoryId ?: $this->getParam(self::PARAM_ROOT_ID)
        );

        return $category ? $category->getSubcategories() : array();
    }

    /**
     * ID of the default root category
     *
     * @return integer
     * @see    ____func_see____
     * @since  1.0.0
     */
    protected function getDefaultCategoryId()
    {
        return $this->getRootCategoryId();
    }

    /**
     * Define widget parameters
     *
     * @return void
     * @see    ____func_see____
     * @since  1.0.0
     */
    protected function defineWidgetParams()
    {
        parent::defineWidgetParams();

        $rootId = $this->getDefaultCategoryId();

        $this->widgetParams += array(
            self::PARAM_DISPLAY_MODE => new \XLite\Model\WidgetParam\Set(
                'Display mode', 'list', true, $this->displayModes
            ),
            self::PARAM_ROOT_ID => new \XLite\Model\WidgetParam\ObjectId\Category(
                'Parent category ID (leave "' . $rootId . '" for root categories list)', $rootId, true, true
            ),
            self::PARAM_IS_SUBTREE => new \XLite\Model\WidgetParam\Bool(
                'Is subtree', false, false
            ),
        );
    }

    /**
     * Checks whether it is a subtree
     *
     * @return boolean
     * @see    ____func_see____
     * @since  1.0.0
     */
    protected function isSubtree()
    {
        return $this->getParam(self::PARAM_IS_SUBTREE) !== false;
    }

    /**
     * Check if category included into active trail or not
     *
     * @param \XLite\Model\Category $category Category
     *
     * @return boolean
     * @see    ____func_see____
     * @since  1.0.0
     */
    protected function isActiveTrail(\XLite\Model\Category $category)
    {
        if (!isset($this->pathIds)) {

            $this->pathIds = array();

            $categoriesPath = \XLite\Core\Database::getRepo('\XLite\Model\Category')
                ->getCategoryPath($this->getCategoryId());

            if (is_array($categoriesPath)) {

                foreach ($categoriesPath as $category) {

                    $this->pathIds[] = $category->getCategoryId();

                }

            }

        }

        return in_array($category->getCategoryId(), $this->pathIds);
    }

    /**
     * Assemble item CSS class name
     *
     * @param integer               $index    Item number
     * @param integer               $count    Items count
     * @param \XLite\Model\Category $category Current category
     *
     * @return string
     * @see    ____func_see____
     * @since  1.0.0
     */
    protected function assembleItemClassName($index, $count, \XLite\Model\Category $category)
    {
        $classes = array();

        $active = $this->isActiveTrail($category);

        if (!$category->hasSubcategories()) {
            $classes[] = 'leaf';

        } elseif (self::DISPLAY_MODE_LIST != $this->getParam(self::PARAM_DISPLAY_MODE)) {
            $classes[] = $active ? 'expanded' : 'collapsed';
        }

        if (0 == $index) {
            $classes[] = 'first';
        }

        $listParam = array(
            'rootId'     => $this->getParam('rootId'),
            'is_subtree' => $this->getParam('is_subtree'),
        );
        if (
            ($count - 1) == $index
            && $this->isViewListVisible('topCategories.children', $listParam)
        ) {
            $classes[] = 'last';
        }

        if ($active) {
            $classes[] = 'active-trail';
        }

        return implode(' ', $classes);
    }

    /**
     * Assemble list item link class name
     *
     * @param integer               $i        Item number
     * @param integer               $count    Items count
     * @param \XLite\Model\Category $category Current category
     *
     * @return string
     * @see    ____func_see____
     * @since  1.0.0
     */
    protected function assembleLinkClassName($i, $count, \XLite\Model\Category $category)
    {
        return \XLite\Core\Request::getInstance()->category_id == $category->getCategoryId()
            ? 'active'
            : '';
    }

    /**
     * Assemble item children container class name
     *
     * @param integer           $i      Item number
     * @param integer           $count  Items count
     * @param \XLite\View\AView $widget Current category FIXME! this variable is not used
     *
     * @return string
     * @see    ____func_see____
     * @since  1.0.0
     */
    protected function assembleListItemClassName($i, $count, \XLite\View\AView $widget)
    {
        $classes = array('leaf');

        if (($count - 1) == $i) {
            $classes[] = 'last';
        }

        return implode(' ', $classes);
    }
}
