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
class W2P_Validate_Alpha extends W2P_Validate_Abstract
{
	const INVALID		= 'alnumInvalid';
    const NOT_ALPHA		= 'notAlpha';
    const STRING_EMPTY	= 'alnumStringEmpty';
	
	/**
	 * É permitido espaços em branco
	 * @var boolean
	 */
	protected  $allowWhiteSpace;
	/**
	 * Filtro de alfanumericos
	 * @var W2P_Filter_Alnum
	 */
	protected static $_filter;
	/**
	 * Override
	 * Contém as variaveis de mensagens de erro
	 * @var array
	 */
	protected $_messageVariables = array(
		self::INVALID,
		self::NOT_ALPHA,
		self::STRING_EMPTY
	);
	
	/**
	 * The constructor
	 * 
	 * @param boolean $allowWhiteSpace
	 * @return void
	 */
	public function __construct( $allowWhiteSpace = false )
	{
		$this->allowWhiteSpace = (boolean) $allowWhiteSpace;
	}
	
	/**
	 * Defined by W2P_Filter_Interface
	 *
	 * @return boolean
	 */
	public function isValid($value=null)
	{
		$value = ( null === $value ) ? $this->_value : $value;
		if ( is_array($value) ) {
			foreach ( $value as $rValue ) {
				if ( !$this->isValid( $rValue ) )
					return false;
			}
			return true;
		}
		
		if ( '' === $value )
		{
			$this->setMessage(self::STRING_EMPTY, $this->getMessage(self::STRING_EMPTY, $value));
			$this->_isError = true;
			return false;
		}
		
		if ( null === self::$_filter )
		{
			/**
			 * @see W2P_Filter_Alpha
			 */
			self::$_filter = new W2P_Filter_Alpha();
		}
		
		self::$_filter->setAllowWhiteSpace( $this->allowWhiteSpace );
		
		if ( !is_string($value) )
		{
			$this->setMessage(self::INVALID, $this->getMessage(self::INVALID, $value));
			$this->_isError = true;
			return false;
		}
		
		if ($value != self::$_filter->filter($value)) {
			$this->setMessage(self::NOT_ALPHA, $this->getMessage(self::NOT_ALPHA, $value));
			$this->_isError = true;
			return false;
		}
		
		return true;
	}
	
	/**
	 * Defined by Zend_Filter_Interface
	 *
	 * @return boolean
	 */
	public function getMessage( $messageVariable, $value )
	{
		if ( !in_array($messageVariable, $this->_messageVariables) )
			throw new W2P_Validate_Exception( sprintf( __("There is registered message to: %s", 'W2P'), $messageVariable) );
		switch ( $messageVariable )
		{
			case self::INVALID		:
				return __("Invalid type given. String expected", 'W2P');
			case self::NOT_ALPHA	:
				return sprintf( __("'%s' contains non alphabetic characters", 'W2P'), $value );
			case self::STRING_EMPTY	:
				return sprintf( __("'%s' is an empty string", 'W2P'), $value );
		}
	}
}