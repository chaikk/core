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
 * @version   GIT: $Id$
 * @link      http://www.litecommerce.com/
 * @see       ____file_see____
 * @since     1.0.0
 */

namespace XLite\Model;

/**
 * Module
 * 
 * @see   ____class_see____
 * @since 1.0.0
 *
 * @Entity (repositoryClass="\XLite\Model\Repo\Module")
 * @Table  (name="modules",
 *      uniqueConstraints={
 *          @UniqueConstraint (name="moduleVersion", columns={"author","name","majorVersion","minorVersion"}),
 *          @UniqueConstraint (name="moduleInstalled", columns={"author","name","installed"})
 *      },
 *      indexes={
 *          @Index (name="enabled", columns={"enabled"}),
 *          @Index (name="date", columns={"date"}),
 *          @Index (name="downloads", columns={"downloads"}),
 *          @Index (name="rating", columns={"rating"})
 *      }
 * )
 * @HasLifecycleCallbacks
 */
class Module extends \XLite\Model\AEntity
{
    /**
     * Module ID
     * 
     * @var   integer
     * @see   ____var_see____
     * @since 1.0.0
     *
     * @Id
     * @GeneratedValue (strategy="AUTO")
     * @Column         (type="integer")
     */
    protected $moduleID;

    /**
     * Name 
     * 
     * @var   string
     * @see   ____var_see____
     * @since 1.0.0
     *
     * @Column (type="string", length="64")
     */
    protected $name;

    /**
     * Author 
     * 
     * @var   string
     * @see   ____var_see____
     * @since 1.0.0
     *
     * @Column (type="string", length="64")
     */
    protected $author;

    /**
     * Public identifier
     *
     * @var   string
     * @see   ____var_see____
     * @since 1.0.0
     *
     * @Column (type="string", length="32")
     */
    protected $marketplaceID = '';

    /**
     * Enabled 
     * 
     * @var   boolean
     * @see   ____var_see____
     * @since 1.0.0
     *
     * @Column (type="boolean")
     */
    protected $enabled = false;

    /**
     * Installed status
     * 
     * @var   boolean
     * @see   ____var_see____
     * @since 1.0.0
     *
     * @Column (type="boolean")
     */
    protected $installed = false;

    /**
     * Module data dump (YAML or SQL) installed status
     *
     * TODO: check if it's really needed
     *
     * @var   boolean
     * @see   ____var_see____
     * @since 1.0.0
     *
     * @Column (type="boolean")
     */
    protected $dataInstalled = false;

    /**
     * Order creation timestamp
     * 
     * @var   integer
     * @see   ____var_see____
     * @since 1.0.0
     *
     * @Column (type="integer")
     */
    protected $date = 0;

    /**
     * Rating
     *
     * @var   string
     * @see   ____var_see____
     * @since 1.0.0
     *
     * @Column (type="integer")
     */
    protected $rating = 0;

    /**
     * Votes
     *
     * @var   integer
     * @see   ____var_see____
     * @since 1.0.0
     *
     * @Column (type="integer")
     */
    protected $votes = 0;

    /**
     * Downloads
     *
     * @var   integer
     * @see   ____var_see____
     * @since 1.0.0
     *
     * @Column (type="integer")
     */
    protected $downloads = 0;

    /**
     * Price
     *
     * @var   float
     * @see   ____var_see____
     * @since 1.0.0
     *
     * @Column (type="decimal", precision=14, scale=2)
     */
    protected $price = 0.00;

    /**
     * Currency code
     *
     * @var   string
     * @see   ____var_see____
     * @since 1.0.0
     *
     * @Column (type="string", length=3)
     */
    protected $currency = 'USD';

    /**
     * Major version
     *
     * @var   string
     * @see   ____var_see____
     * @since 1.0.0
     *
     * @Column (type="string", length=8)
     */
    protected $majorVersion;

    /**
     * Minor version
     *
     * @var   string
     * @see   ____var_see____
     * @since 1.0.0
     *
     * @Column (type="string", length=8)
     */
    protected $minorVersion;

    /**
     * Revision date
     *
     * @var   integer
     * @see   ____var_see____
     * @since 1.0.0
     *
     * @Column (type="integer")
     */
    protected $revisionDate = 0;

    /**
     * Module name
     *
     * @var   string
     * @see   ____var_see____
     * @since 1.0.0
     *
     * @Column (type="string", length=255)
     */
    protected $moduleName;

    /**
     * Author name
     *
     * @var   string
     * @see   ____var_see____
     * @since 1.0.0
     *
     * @Column (type="string", length=255)
     */
    protected $authorName;

    /**
     * Description
     *
     * @var   string
     * @see   ____var_see____
     * @since 1.0.0
     *
     * @Column (type="text")
     */
    protected $description = '';

    /**
     * Icon URL
     *
     * @var   string
     * @see   ____var_see____
     * @since 1.0.0
     *
     * @Column (type="string", length=255)
     */
    protected $iconURL = '';

    /**
     * Icon URL
     *
     * @var   string
     * @see   ____var_see____
     * @since 1.0.0
     *
     * @Column (type="string", length=255)
     */
    protected $pageURL = '';

    /**
     * Icon URL
     *
     * @var   string
     * @see   ____var_see____
     * @since 1.0.0
     *
     * @Column (type="string", length=255)
     */
    protected $authorPageURL = '';

    /**
     * Module dependencies
     * 
     * @var   array
     * @see   ____var_see____
     * @since 1.0.0
     *
     * @Column (type="array")
     */
    protected $dependencies = array();


    // {{{ Routines to access methods of (non)installed modules

    /**
     * Getter
     *
     * @return string
     * @see    ____func_see____
     * @since  1.0.0
     */
    public function getMajorVersion()
    {
        // Do not replace the first argument by the
        // magic constant "__FUNCTION__": their are the same "accidentally"
        return $this->callModuleMethod('getMajorVersion', $this->majorVersion);
    }

    /**
     * Getter
     * 
     * @return string
     * @see    ____func_see____
     * @since  1.0.0
     */
    public function getMinorVersion()
    {
        // Do not replace the first argument by the 
        // magic constant "__FUNCTION__": their are the same "accidentally"
        return $this->callModuleMethod('getMinorVersion', $this->minorVersion);
    }

    /**
     * Getter
     * 
     * @return string
     * @see    ____func_see____
     * @since  1.0.0
     */
    public function getModuleName()
    {
        // Do not replace the first argument by the
        // magic constant "__FUNCTION__": their are the same "accidentally"
        return $this->callModuleMethod('getModuleName', $this->moduleName);
    }

    /**
     * Getter
     * 
     * @return string
     * @see    ____func_see____
     * @since  1.0.0
     */
    public function getAuthorName()
    {
        // Do not replace the first argument by the
        // magic constant "__FUNCTION__": their are the same "accidentally"
        return $this->callModuleMethod('getAuthorName', $this->authorName);
    }

    /**
     * Getter
     * 
     * @return string
     * @see    ____func_see____
     * @since  1.0.0
     */
    public function getDescription()
    {
        // Do not replace the first argument by the
        // magic constant "__FUNCTION__": their are the same "accidentally"
        return $this->callModuleMethod('getDescription', $this->description);
    }

    /**
     * Getter
     * 
     * @return string
     * @see    ____func_see____
     * @since  1.0.0
     */
    public function getIconURL()
    {
        // Do not replace the first argument by the
        // magic constant "__FUNCTION__": their are the same "accidentally"
        return $this->callModuleMethod('getIconURL', $this->iconURL);
    }

    /**
     * Getter
     * 
     * @return string
     * @see    ____func_see____
     * @since  1.0.0
     */
    public function getPageURL()
    {
        // Do not replace the first argument by the
        // magic constant "__FUNCTION__": their are the same "accidentally"
        return $this->callModuleMethod('getPageURL', $this->pageURL);
    }

    /**
     * Getter
     * 
     * @return string
     * @see    ____func_see____
     * @since  1.0.0
     */
    public function getAuthorPageURL()
    {
        // Do not replace the first argument by the
        // magic constant "__FUNCTION__": their are the same "accidentally"
        return $this->callModuleMethod('getAuthorPageURL', $this->authorPageURL);
    }

    /**
     * Getter
     * 
     * @return array
     * @see    ____func_see____
     * @since  1.0.0
     */
    public function getDependencies()
    {
        // Do not replace the first argument by the
        // magic constant "__FUNCTION__": their are the same "accidentally"
        return $this->callModuleMethod('getDependencies', $this->dependencies);
    }

    /**
     * Method to call functions from module main classes
     * 
     * @param string $method Method to call
     * @param mixed  $result Method return value for the current class (model) OPTIONAL
     * @param array  $args   Call arguments OPTIONAL
     *  
     * @return mixed
     * @see    ____func_see____
     * @since  1.0.0
     */
    public function callModuleMethod($method, $result = null, array $args = array())
    {
        return $this->checkModuleMainClass() 
            ? call_user_func_array(array($this->getMainClass(), $method), $args) 
            : $result;
    }

    /**
     * Check if we can call method from the module main class
     * 
     * @return boolean
     * @see    ____func_see____
     * @since  1.0.0
     */
    protected function checkModuleMainClass()
    {
        return $this->getInstalled() && \Includes\Utils\Operator::checkIfClassExists($this->getMainClass());
    }

    /**
     * Return main class name for current module
     * 
     * @return string
     * @see    ____func_see____
     * @since  1.0.0
     */
    protected function getMainClass()
    {
        return '\XLite\Module\\' . $this->getActualName() . '\Main';
    }

    // }}}

    // {{{ Some common getters and setters

    /**
     * Compose module actual name
     *
     * @return string
     * @see    ____func_see____
     * @since  1.0.0
     */
    public function getActualName()
    {
        return \Includes\Decorator\Utils\ModulesManager::getActualName($this->getAuthor(), $this->getName());
    }

    /**
     * Return module full version
     * 
     * @return string
     * @see    ____func_see____
     * @since  1.0.0
     */
    public function getVersion()
    {
        return \Includes\Utils\Converter::composeVersion($this->getMajorVersion(), $this->getMinorVersion());
    }

    /**
     * Check if module has a custom icon
     * 
     * @return boolean
     * @see    ____func_see____
     * @since  1.0.0
     */
    public function hasIcon()
    {
        return (bool) $this->getIconURL();
    }

    /**
     * Return link to settings form
     *
     * @return string
     * @see    ____func_see____
     * @since  1.0.0
     */
    public function getSettingsForm()
    {
        return $this->callModuleMethod('getSettingsForm')
            ?: \XLite\Core\Converter::buildURL('module', '', array('moduleId' => $this->getModuleId()), 'admin.php');
    }

    /**
     * Get list of dependent modules as Doctrine entities
     * 
     * @return array
     * @see    ____func_see____
     * @since  1.0.0
     */
    public function getDependentModules()
    {
        $result = array();

        foreach ($this->getDependencies() as $class) {
            $result[$class] = $this->getRepository()
                ->findOneBy(array_combine(array('author', 'name'), explode('\\', $class)));
        }

        return array_filter($result);
    }

    /**
     * Check if the module is free
     *
     * @return boolean
     * @see    ____func_see____
     * @since  1.0.0
     */
    public function isFree()
    {
        return 0 >= $this->getPrice();
    }

    /**
     * Check if module is already purchased
     *
     * TODO: add code here
     * 
     * @return boolean
     * @see    ____func_see____
     * @since  1.0.0
     */
    public function isPurchased()
    {
        return true;
    }

    /**
     * Get module root directory
     *
     * @return string
     * @see    ____func_see____
     * @since  1.0.0
     */
    public function getRootDirectory()
    {
        return LC_MODULES_DIR . $this->getPath() . LC_DS;
    }

    /**
     * Return relative module path
     *
     * @return string
     * @see    ____func_see____
     * @since  1.0.0
     */
    public function getPath()
    {
        return str_replace('\\', LC_DS, $this->getActualName());
    }

    // }}}
}
