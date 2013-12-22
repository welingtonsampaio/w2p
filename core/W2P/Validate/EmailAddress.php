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
 * @author		Welington Sampaio ( @link http://welington.zaez.net )
 * @version		1.0
 * 
 * @category	W2P
 * @package		W2P_Validate
 * @copyright	Copyright (c) 2012 Zaez Solução em Tecnologia Ltda - Welington Sampaio
 * @license		http://creativecommons.org/licenses/by-nd/3.0/  Creative Commons
 */

namespace W2P\Validate;

/**
 * @author		Welington Sampaio ( @link http://welington.zaez.net )
 * @version		1.0
 * 
 * @category	W2P
 * @package		W2P_Validate
 * @since		1.0
 * @copyright	Copyright (c) 2012 Zaez Solução em Tecnologia Ltda - Welington Sampaio
 * @license		http://creativecommons.org/licenses/by-nd/3.0/  Creative Commons
 */
class EmailAddress extends AbstractClass
{
	const INVALID			= 'emailAddressInvalid';
	const INVALID_FORMAT	= 'emailAddressInvalidFormat';
	
	/**
	 * Override
	 * Contém as variaveis de mensagens de erro
	 * @var array
	 */
	protected $_messageVariables = array(
			self::INVALID,
			self::INVALID_FORMAT
	);
	
	/**
	 * Defined by InterfaceClass
	 * 
	 * Conforms approximately to RFC2822
	 * @link http://www.hexillion.com/samples/#Regex Original pattern found here
	 *
     * @param $value String
     *
	 * @return boolean
	 */
	public function isValid( $value = null )
	{
		$value = ( null === $value ) ? $this->_value : $value;
		if ( is_array($value) ) {
			foreach ( $value as $rValue ) {
				if ( !$this->isValid( $rValue ) )
					return false;
			}
			return true;
		}
		
		if ( !is_string($value) )
		{
			$this->setMessage(self::INVALID, $this->getMessage(self::INVALID, $value));
			$this->_isError = true;
			return false;
		}
		
		if (function_exists('filter_var')) { //Introduced in PHP 5.2
			if(filter_var($value, FILTER_VALIDATE_EMAIL) === FALSE) {
				$this->setMessage(self::INVALID_FORMAT, $this->getMessage(self::INVALID_FORMAT, $value));
				$this->_isError = true;
				return false;
			}
		} else if( !preg_match('/^(?:[\w\!\#\$\%\&\'\*\+\-\/\=\?\^\`\{\|\}\~]+\.)*[\w\!\#\$\%\&\'\*\+\-\/\=\?\^\`\{\|\}\~]+@(?:(?:(?:[a-zA-Z0-9_](?:[a-zA-Z0-9_\-](?!\.)){0,61}[a-zA-Z0-9_-]?\.)+[a-zA-Z0-9_](?:[a-zA-Z0-9_\-](?!$)){0,61}[a-zA-Z0-9_]?)|(?:\[(?:(?:[01]?\d{1,2}|2[0-4]\d|25[0-5])\.){3}(?:[01]?\d{1,2}|2[0-4]\d|25[0-5])\]))$/', $value) ) {
			$this->setMessage(self::INVALID_FORMAT, $this->getMessage(self::INVALID_FORMAT, $value));
			$this->_isError = true;
			return false;
		}
		
		return true;
	}
	
	/**
	 * Defined by InterfaceClass
     *
     * @param $messageVariable
     * @param $value
     *
     * @throws Exception
	 *
	 * @return String
	 */
	public function getMessage( $messageVariable, $value )
	{
		if ( !in_array($messageVariable, $this->_messageVariables) )
			throw new Exception( sprintf( __("There is registered message to: %s", 'W2P'), $messageVariable) );
		switch ( $messageVariable )
		{
			case self::INVALID		:
				return __("Invalid type given. String expected", 'W2P');
			case self::INVALID_FORMAT	:
				return sprintf( __("'%s' is no valid email address in the basic format username@hostname", 'W2P'), $value );
		}
	}
}