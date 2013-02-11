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
class W2P_Filter_StringToLower extends W2P_Filter_Abstract
{
	/**
	 * Encoding for the input string
	 *
	 * @var string
	 */
	protected $_encoding = null;

	/**
	 * Constructor
	 *
	 * @param string|array $options OPTIONAL
	 */
	public function __construct($options = null)
	{
		if (!is_array($options)) {
			$options = func_get_args();
			$temp    = array();
			if (!empty($options)) {
				$temp['encoding'] = array_shift($options);
			}
			$options = $temp;
		}

		if (!array_key_exists('encoding', $options) && function_exists('mb_internal_encoding')) {
			$options['encoding'] = mb_internal_encoding();
		}

		if (array_key_exists('encoding', $options)) {
			$this->setEncoding($options['encoding']);
		}
	}

	/**
	 * Returns the set encoding
	 *
	 * @return string
	 */
	public function getEncoding()
	{
		return $this->_encoding;
	}

	/**
	 * Set the input encoding for the given string
	 *
	 * @param  string $encoding
	 * @return W2P_Filter_StringToLower Provides a fluent interface
	 * @throws W2P_Filter_Exception
	 */
	public function setEncoding($encoding = null)
	{
		if ($encoding !== null) {
			if (!function_exists('mb_strtolower')) {
				throw new W2P_Filter_Exception( __('mbstring is required for this feature', 'W2P') );
			}

			$encoding = (string) $encoding;
			if (!in_array(strtolower($encoding), array_map('strtolower', mb_list_encodings()))) {
				throw new W2P_Filter_Exception( sprintf( __("The given encoding '%s' is not supported by mbstring", 'W2P') , $encoding ) );
			}
		}

		$this->_encoding = $encoding;
		return $this;
	}

	/**
	 * Defined by W2P_Filter_Interface
	 *
	 * Returns the string $value, converting characters to lowercase as necessary
	 *
	 * @param  string $value
	 * @return string
	 */
	public function filter($value)
	{
		if ($this->_encoding !== null) {
			return mb_strtolower((string) $value, $this->_encoding);
		}

		return strtolower((string) $value);
	}
}
