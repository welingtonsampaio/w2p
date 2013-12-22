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

namespace W2P\Filter;

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
class Alpha extends AbstractClass
{
	/**
	 * Whether to allow white space characters; off by default
	 *
	 * @var boolean
	 */
	public $allowWhiteSpace;
	
	/**
	 * Is PCRE is compiled with UTF-8 and Unicode support
	 *
	 * @var mixed
	 **/
	protected static $_unicodeEnabled;
	/**
	 * 
	 * @param $allowWhiteSpace boolean
	 */
	public function __construct( $allowWhiteSpace = false )
	{
		$this->allowWhiteSpace = (boolean) $allowWhiteSpace;
		
		if (null === self::$_unicodeEnabled)
		{
			self::$_unicodeEnabled = (@preg_match('/\pL/u', 'a')) ? true : false;
		}
	}
	/**
	 * Defined by W2P_Filter_Interface
     *
     * Returns the string $value, removing all but alphabetic and digit characters
     *
     * @param  string $value
     * @return string
	 */
	public function filter( $value )
	{
		$whiteSpace = $this->allowWhiteSpace ? '\s' : '';
		
		if (!self::$_unicodeEnabled)
			$pattern = '/[^a-zA-Z' . $whiteSpace . ']/';
		else
			$pattern = '/[^a-zA-Z'  . $whiteSpace . ']/u';
		
		return preg_replace($pattern, '', (string) $value);
	}
	/**
	 * Returns the allowWhiteSpace option
	 *
	 * @return boolean
	 */
	public function getAllowWhiteSpace()
	{
		return $this->allowWhiteSpace;
	}
	/**
	 * Sets the allowWhiteSpace option
	 *
	 * @param boolean $allowWhiteSpace
	 * @return Alnum Provides a fluent interface
	 */
	public function setAllowWhiteSpace($allowWhiteSpace)
	{
		$this->allowWhiteSpace = (boolean) $allowWhiteSpace;
		return $this;
	}
	
}