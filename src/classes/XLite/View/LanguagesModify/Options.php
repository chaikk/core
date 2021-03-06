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

namespace XLite\View\LanguagesModify;

/**
 * Language options dialog
 *
 * @see   ____class_see____
 * @since 1.0.0
 */
class Options extends \XLite\View\AView
{
    /**
     * Widget parameters
     */
    const PARAM_LNG_ID = 'lng_id';


    /**
     * Language (cache)
     *
     * @var   \XLite\Model\Language
     * @see   ____var_see____
     * @since 1.0.0
     */
    protected $editLanguage = null;


    /**
     * Get language
     *
     * @return \XLite\Model\Language|boolean
     * @see    ____func_see____
     * @since  1.0.0
     */
    public function getEditLanguage()
    {
        if (!isset($this->label)) {
            if ($this->getParam(self::PARAM_LNG_ID)) {
                $this->editLanguage = \XLite\Core\Database::getRepo('\XLite\Model\Language')
                    ->find($this->getParam(self::PARAM_LNG_ID));

            } else {
                $this->editLanguage = false;
            }
        }

        return $this->editLanguage;
    }

    /**
     * Get default language (English)
     *
     * @return \XLite\Model\Language
     * @see    ____func_see____
     * @since  1.0.0
     */
    public function getDefaultLanguage()
    {
        return \XLite\Core\Database::getRepo('\XLite\Model\Language')->getDefaultLanguage();
    }

    /**
     * Get default language for customer zone
     *
     * @return \XLite\Model\Language
     * @see    ____func_see____
     * @since  1.0.0
     */
    public function getInterfaceLanguage()
    {
        return \XLite\Core\Config::getInstance()->General->defaultLanguage;
    }

    /**
     * Get language translation
     *
     * @param \XLite\Model\Language $language Translation language
     *
     * @return string
     * @see    ____func_see____
     * @since  1.0.0
     */
    public function getTranslation(\XLite\Model\Language $language)
    {
        return strval($this->getEditLanguage()->getTranslation($language->code)->name);
    }

    /**
     * Check - can language disabled / enabled or not
     *
     * @return boolean
     * @see    ____func_see____
     * @since  1.0.0
     */
    public function canSwitch()
    {
        return $this->getInterfaceLanguage()->code != $this->getEditLanguage()->code;
    }

    /**
     * Check - can language deleted or not
     *
     * @return boolean
     * @see    ____func_see____
     * @since  1.0.0
     */
    public function canDelete()
    {
        return $this->canSwitch()
            && $this->getEditLanguage()->code != $this->getDefaultLanguage()->code;
    }

    /**
     * Get wwicther block class
     *
     * @return string
     * @see    ____func_see____
     * @since  1.0.0
     */
    public function getSwictherClass()
    {
        $classes = array('switcher');

        if (!$this->canSwitch()) {
            $classes[] = 'switcher-default';

        } elseif ($this->getEditLanguage()->enabled) {
            $classes[] = 'switcher-enabled';

        } else {
            $classes[] = 'switcher-disabled';
        }

        return implode(' ', $classes);
    }


    /**
     * Return widget default template
     *
     * @return string
     * @see    ____func_see____
     * @since  1.0.0
     */
    protected function getDefaultTemplate()
    {
        return 'languages/options.tpl';
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

        $this->widgetParams += array(
            self::PARAM_LNG_ID => new \XLite\Model\WidgetParam\Int(
                'Language id', \XLite\Core\Request::getInstance()->{self::PARAM_LNG_ID}
            ),
        );
    }

    /**
     * Check if widget is visible
     *
     * @return boolean
     * @see    ____func_see____
     * @since  1.0.0
     */
    protected function isVisible()
    {
        return parent::isVisible()
            && $this->getEditLanguage();
    }
}
