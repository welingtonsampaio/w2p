<?php
/**
 * 
 * LICENSE
 * 
 * This source file is subject to the Creative Commons license.
 * Available through the world-wide-web at this URL:
 * http://creativecommons.org/licenses/by-nd/3.0/.
 * If you did not receive a copy of the license and are unable
 * to obtain it through the world-wide-web, please send an email
 * to welington.sampaio@zaez.net so we can send you a copy immediately.
 * 
 *
 * @author Welington Sampaio ( @link http://welington.zaez.net )
 * @version 1.0
 * 
 * @category	W2P
 * @package		W2P_Filter
 * @copyright	Copyright (c) 2012 Zaez Solução em Tecnologia Ltda - Welington Sampaio
 * @license		http://creativecommons.org/licenses/by-nd/3.0/  Creative Commons
 */

/**
 * 
 * @author		Welington Sampaio ( @link http://welington.zaez.net )
 * @version		1.0
 * 
 * @category	W2P
 * @package		W2P_Filter
 * @since		1.0
 * @copyright	Copyright (c) 2012 Zaez Solução em Tecnologia Ltda - Welington Sampaio
 * @license		http://creativecommons.org/licenses/by-nd/3.0/  Creative Commons
 */
class W2P_Filter_HtmlEntities extends W2P_Filter_Abstract
{
	/**
	 * Corresponds to the second htmlentities() argument
	 *
	 * @var integer
	 */
	protected $_quoteStyle;
	
	/**
	 * Corresponds to the third htmlentities() argument
	 *
	 * @var string
	 */
	protected $_encoding;
	
	/**
	 * Corresponds to the forth htmlentities() argument
	 *
	 * @var unknown_type
	 */
	protected $_doubleQuote;
	
	/**
	 * Sets filter options
	 *
	 * @param  integer|array $quoteStyle
	 * @param  string  $charSet
	 * @return void
	 */
	public function __construct($options = array())
	{
		if (!is_array($options)) {
			$options = func_get_args();
			$temp['quotestyle'] = array_shift($options);
			if (!empty($options)) {
				$temp['charset'] = array_shift($options);
			}
	
			$options = $temp;
		}
	
		if (!isset($options['quotestyle'])) {
			$options['quotestyle'] = ENT_COMPAT;
		}
	
		if (!isset($options['encoding'])) {
			$options['encoding'] = 'UTF-8';
		}
		if (isset($options['charset'])) {
			$options['encoding'] = $options['charset'];
		}
	
		if (!isset($options['doublequote'])) {
			$options['doublequote'] = true;
		}
	
		$this->setQuoteStyle($options['quotestyle']);
		$this->setEncoding($options['encoding']);
		$this->setDoubleQuote($options['doublequote']);
	}
	
	/**
	 * Returns the quoteStyle option
	 *
	 * @return integer
	 */
	public function getQuoteStyle()
	{
		return $this->_quoteStyle;
	}
	
	/**
	 * Sets the quoteStyle option
	 *
	 * @param  integer $quoteStyle
	 * @return W2P_Filter_HtmlEntities Provides a fluent interface
	 */
	public function setQuoteStyle($quoteStyle)
	{
		$this->_quoteStyle = $quoteStyle;
		return $this;
	}
	
	
	/**
	 * Get encoding
	 *
	 * @return string
	 */
	public function getEncoding()
	{
		return $this->_encoding;
	}
	
	/**
	 * Set encoding
	 *
	 * @param  string $value
	 * @return W2P_Filter_HtmlEntities
	 */
	public function setEncoding($value)
	{
		$this->_encoding = (string) $value;
		return $this;
	}
	
	/**
	 * Returns the charSet option
	 *
	 * Proxies to {@link getEncoding()}
	 *
	 * @return string
	 */
	public function getCharSet()
	{
		return $this->getEncoding();
	}
	
	/**
	 * Sets the charSet option
	 *
	 * Proxies to {@link setEncoding()}
	 *
	 * @param  string $charSet
	 * @return W2P_Filter_HtmlEntities Provides a fluent interface
	 */
	public function setCharSet($charSet)
	{
		return $this->setEncoding($charSet);
	}
	
	/**
	 * Returns the doubleQuote option
	 *
	 * @return boolean
	 */
	public function getDoubleQuote()
	{
		return $this->_doubleQuote;
	}
	
	/**
	 * Sets the doubleQuote option
	 *
	 * @param boolean $doubleQuote
	 * @return W2P_Filter_HtmlEntities Provides a fluent interface
	 */
	public function setDoubleQuote($doubleQuote)
	{
		$this->_doubleQuote = (boolean) $doubleQuote;
		return $this;
	}
	
	/**
	 * Defined by W2P_Filter_Interface
	 *
	 * Returns the string $value, converting characters to their corresponding HTML entity
	 * equivalents where they exist
	 *
	 * @param  string $value
	 * @return string
	 */
	public function filter($value)
	{
		return htmlentities((string) $value, $this->getQuoteStyle(), $this->getEncoding(), $this->getDoubleQuote());
	}
}