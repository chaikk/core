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

namespace XLite\Module\CDev\DrupalConnector\Drupal;

/**
 * ADrupal
 *
 * @package XLite
 * @see     ____class_see____
 * @since   1.0.0
 */
abstract class ADrupal extends \XLite\Base\Singleton
{
    /**
     * Initialized handler instance
     *
     * @var    \XLite\Module\CDev\DrupalConnector\Handler
     * @access protected
     * @see    ____var_see____
     * @since  1.0.0
     */
    protected $handler;

    /**
     * Already registered resources
     *
     * @var    array
     * @access protected
     * @see    ____var_see____
     * @since  1.0.0
     */
    protected static $registeredResources = array('js' => array(), 'css' => array());

    /**
     * Resources weight counter
     *
     * @var    integer
     * @access protected
     * @see    ____var_see____
     * @since  1.0.0
     */
    protected static $resourcesCounter = 0;

    // ------------------------------ Application layer -

    /**
     * Return instance of current CMS connector
     *
     * @return \XLite\Module\CDev\DrupalConnector\Handler
     * @access protected
     * @see    ____func_see____
     * @since  1.0.0
     */
    protected function getHandler()
    {
        if (!isset($this->handler)) {
            $this->handler = \XLite\Module\CDev\DrupalConnector\Handler::getInstance();
            $this->handler->init();
        }

        return $this->handler;
    }

    /**
     * Execute a controller action
     *
     * @param string $target Controller target
     * @param string $action Action to perform
     * @param array  $data   Request data
     *
     * @return void
     * @access protected
     * @see    ____func_see____
     * @since  1.0.0
     */
    protected function runController($target, $action = null, array $data = array())
    {
        $data = array('target' => $target, 'action' => $action) + $data;

        $this->getHandler()->mapRequest(array(\XLite\Core\CMSConnector::NO_REDIRECT => true) + $data);
        $this->getHandler()->runController(md5(serialize($data)));
    }


    // ------------------------------ Resources (CSS and JS) -

    /**
     * Get resources (from list) which are not already registered
     *
     * @param string $type  Resource type ("js" or "css")
     * @param array  $files Resource files
     *
     * @return array
     * @access protected
     * @see    ____func_see____
     i* @since  1.0.0
     */
    protected function getUniqueResources($type, array $files)
    {
        static::$registeredResources[$type] = array_merge(static::$registeredResources[$type], $files);

        return $files;
    }



    /**
     * Get JS scope
     *
     * @param string $file Resource file path
     *
     * @return string
     * @access protected
     * @see    ____func_see____
     * @since  1.0.0
     */
    protected function getJSScope($file)
    {
        return preg_match('/.skins.common.js./Ss', $file) ? 'header' : 'footer';
    }

    /**
     * Get file unique basename
     *
     * @param string $file Resource file path
     *
     * @return string
     * @access protected
     * @see    ____func_see____
     * @since  1.0.0
     */
    protected function getResourceBasename($file)
    {
        return preg_replace('/\.(css|js)$/Ss', '.' . uniqid() . '.$1', basename($file));
    }

    /**
     * Get resource description in Drupal format
     *
     * @param array $file Resource file info
     *
     * @return void
     * @access protected
     * @see    ____func_see____
     * @since  1.0.0
     */
    protected function getResourceInfoCommon(array $file)
    {
        return array(
            'type'     => 'file',
            'basename' => $this->getResourceBasename($file['file']),
            'weight'   => isset($file['weight']) ? $file['weight'] : static::$resourcesCounter++,
        );
    }

    /**
     * Get resource description in Drupal format
     *
     * @param array $file Resource file info
     *
     * @return void
     * @access protected
     * @see    ____func_see____
     * @since  1.0.0
     */
    protected function getResourceInfoJS(array $file)
    {
        $scope = $this->getJSScope($file['file']);

        return array(
            'scope' => $scope,
            'defer' => $scope == 'footer',
        );
    }

    /**
     * Get resource description in Drupal format
     *
     * @param array $file Resource file info
     *
     * @return void
     * @access protected
     * @see    ____func_see____
     * @since  1.0.0
     */
    protected function getResourceInfoCSS(array $file)
    {
        return array(
            'group' => CSS_DEFAULT,
            'media' => isset($file['media']) ? $file['media'] : 'all',
        );
    }

    /**
     * Get resource description in Drupal format
     *
     * @param string $type Resource type ("js" or "css")
     * @param array  $file Resource file info
     *
     * @return void
     * @access protected
     * @see    ____func_see____
     * @since  1.0.0
     */
    protected function getResourceInfo($type, array $file)
    {
        return $this->getResourceInfoCommon($file) + $this->{__FUNCTION__ . strtoupper($type)}($file);
    }

    /**
     * Register single resource
     *
     * @param string $type Resource type ("js" or "css")
     * @param array  $file Resource file info
     *
     * @return mixed
     * @access protected
     * @see    ____func_see____
     * @since  1.0.0
     */
    protected function registerResource($type, array $file)
    {
        return call_user_func_array('drupal_add_' . $type, array($file['file'], $this->getResourceInfo($type, $file)));
    }

    /**
     * Register LC widget resources
     *
     * @param \XLite\View\AView $widget LC widget to get resources list
     *
     * @return void
     * @access protected
     * @see    ____func_see____
     * @since  1.0.0
     */
    protected function registerResources(\XLite\View\AView $widget)
    {
        foreach ($widget->getRegisteredResources() as $type => $files) {
            foreach ($this->getUniqueResources($type, $files) as $file) {
                $this->registerResource($type, $file);
            }
        }
    }
}
