<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Request
 *  
 * @category  Litecommerce
 * @package   Core
 * @author    Creative Development LLC <info@cdev.ru> 
 * @copyright Copyright (c) 2009 Creative Development LLC <info@cdev.ru>. All rights reserved
 * @license   http://www.qtmsoft.com/xpayments_eula.html X-Payments license agreement
 * @version   SVN: $Id$
 * @link      http://www.qtmsoft.com/
 * @see       ____file_see____
 * @since     3.0.0 EE
 */

/**
 * Request
 *                         
 * @package    Core
 * @since      3.0                   
 */
class XLite_Core_Request extends XLite_Base implements XLite_Base_ISingleton
{
	/**
	 * Request data 
	 * 
	 * @var    array
	 * @access protected
	 * @see    ____var_see____
	 * @since  3.0.0
	 */
	protected $data = array();


    /**
     * Strip possible SQL injections
     * TODO - improve or remove (if the PDO will be used) this function
     * 
     * @param string $value value to check
     *  
     * @return string
     * @access protected
     * @since  3.0.0 EE
     */
    protected function stripSQLinjection($value)
    {
        // (UNION SELECT) case
        if (false !== strpos(strtolower($value), 'union')) {
            $value = preg_replace('/union([\s\(\)]|((?:\/\*).*(?:\*\/))|(?:union|select|all|distinct))+select/i', ' ', $value);
        }

        // (BENCHMARK) case
        if (false !== strpos(strtolower($value), 'benchmark(')) {
            $value = preg_replace('/benchmark\(/i', ' ', $value);
        }

        return $value;
    }

    /**
     * Sanitize single value
     * 
     * @param string $value value to sanitize
     *  
     * @return string
     * @access protected
     * @since  3.0.0 EE
     */
    protected function sanitizeSingle($value)
    {
        return strip_tags($this->stripSQLinjection($value));
    }

    /**
     * Sanitize passed data 
     * 
     * @param mixed $data data to sanitize
     *  
     * @return mixed
     * @access protected
     * @since  3.0.0 EE
     */
    protected function sanitize($data)
    {
        return is_array($data) ? array_map(array($this, __FUNCTION__), $data) : $this->sanitizeSingle($data);
    }

    /**
     * Wrapper for sanitize()
     *
     * @param mixed $data data to sanitize
     *
     * @return mixed
     * @access protected
     * @since  3.0.0 EE
     */
    protected function prepare($data)
    {
        return XLite::getInstance()->adminZone ? $data : $this->sanitize($data);
    }

    /**
     * Constructor
     * 
     * @return void
     * @access protected
     * @see    ____func_see____
     * @since  3.0.0 EE
     */
    protected function __construct()
    {
		$this->mapRequest();
    }


    /**
     * Method to access the singleton 
     * 
     * @return XLite_Core_CMSConnector
     * @access public
     * @since  3.0
     */
    public static function getInstance()
    {
        return self::_getInstance(__CLASS__);
    }

    /**
     * Map request data
     * 
     * @param array $data custom data (optional)
     *  
     * @return void
     * @access public
     * @since  3.0.0 EE
     */
	public function mapRequest(array $data = array())
	{
        // TODO - in PHP 5.3 it's should be replaced by the "array_replace_recursive()" function
        $this->data = $this->prepare(empty($data) ? $_REQUEST : $data + $this->data);
	}

    /**
     * Return all data 
     * 
     * @return array
     * @access public
     * @since  3.0.0 EE
     */
    public function getData()
    {
        return $this->data;
    }

	/**
	 * Getter
	 * 
	 * @param string $name property name
	 *  
	 * @return mixed
	 * @access public
	 * @see    ____func_see____
	 * @since  3.0.0
	 */
	public function __get($name)
	{
		return isset($this->data[$name]) ? $this->data[$name] : null;
	}
    
    /**
     * Setter 
     * 
     * @param string $name  property name
     * @param mixed  $value property value
     *  
     * @return void
     * @access public
     * @since  3.0.0 EE
     */
    public function __set($name, $value)
    {
        $this->data[$name] = $this->prepare($value);
    }

    /**
     * Check property accessability
     *
     * @param string $name property name
     *
     * @return bool
     * @access public
     * @since  3.0.0 EE
     */
    public function __isset($name)
    {
        return isset($this->data[$name]);
    }
}
