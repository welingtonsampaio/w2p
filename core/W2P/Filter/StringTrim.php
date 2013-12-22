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
class StringTrim extends AbstractClass
{
	/**
	 * List of characters provided to the trim() function
	 *
	 * If this is null, then trim() is called with no specific character list,
	 * and its default behavior will be invoked, trimming whitespace.
	 *
	 * @var string|null
	 */
	protected $_charList;
	
	/**
	 * Sets filter options
	 *
	 * @param  string|array $options
	 */
	public function __construct($options = null)
	{
		if (!is_array($options)) {
			$options          = func_get_args();
			$temp['charlist'] = array_shift($options);
			$options          = $temp;
		}
	
		if (array_key_exists('charlist', $options)) {
			$this->setCharList($options['charlist']);
		}
	}
	
	/**
	 * Returns the charList option
	 *
	 * @return string|null
	 */
	public function getCharList()
	{
		return $this->_charList;
	}
	
	/**
	 * Sets the charList option
	 *
	 * @param  string|null $charList
	 * @return StringTrim Provides a fluent interface
	 */
	public function setCharList($charList)
	{
		$this->_charList = $charList;
		return $this;
	}
	
	/**
	 * Defined by InterfaceClass
	 *
	 * Returns the string $value with characters stripped from the beginning and end
	 *
	 * @param  string $value
	 * @return string
	 */
	public function filter($value)
	{
		if (null === $this->_charList) {
			return $this->_unicodeTrim((string) $value);
		} else {
			return $this->_unicodeTrim((string) $value, $this->_charList);
		}
	}
	
	/**
	 * Unicode aware trim method
	 * Fixes a PHP problem
	 *
	 * @param string $value
	 * @param string $charlist
	 * @return string
	 */
	protected function _unicodeTrim($value, $charlist = '\\\\s')
	{
		$chars = preg_replace(
				array( '/[\^\-\]\\\]/S', '/\\\{4}/S', '/\//'),
				array( '\\\\\\0', '\\', '\/' ),
				$charlist
		);
	
		$pattern = '^[' . $chars . ']*|[' . $chars . ']*$';
		return preg_replace("/$pattern/sSD", '', $value);
	}
}