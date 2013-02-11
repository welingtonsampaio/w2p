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
 * @subpackage	subpackage
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
class W2P_Validate_StringLength extends W2P_Validate_Abstract
{
	const INVALID	= 'stringLengthInvalid';
	const TOO_SHORT	= 'stringLengthTooShort';
	const TOO_LONG	= 'stringLengthTooLong';
	
	/**
	 * Numero maximo de caracters
	 * @var int
	 */
	protected $_max;
	/**
	 * Numero minimo de caracters
	 * @var int
	 */
	protected $_min;
	/**
	 * Override
	 * Contém as variaveis de mensagens de erro
	 * @var array
	 */
	protected $_messageVariables = array(
		self::INVALID,
		self::TOO_SHORT,
		self::TOO_LONG
	);
	
	/**
	 * The constructor
	 * 
	 * @param int $min
	 * @param int $max
	 * @return void
	 */
	public function __construct( $min, $max )
	{
		$this->_min = (int) $min;
		$this->_max = (int) $max;
	}
	
	/**
	 * Defined by W2P_Filter_Interface
	 *
	 * @return boolean
	 */
	public function isValid()
	{
		$value = $this->_value;
		if ( is_array($value) )
		{
			foreach ($value as $rValue)
			{
				$count = strlen($rValue);
				if ( null !== $this->_min ) {
					if ( $count < $this->_min ) {
						$this->setMessage(self::TOO_SHORT, $this->getMessage(self::TOO_SHORT, $rValue) );
						$this->_isError = true;
						return false;
					}
				}
				if ( null !== $this->_max ) {
					if ( $count > $this->_max ) {
						$this->setMessage(self::TOO_LONG, $this->getMessage(self::TOO_LONG, $rValue) );
						$this->_isError = true;
						return false;
					}
				}
			}
			return true;
		}
		if( is_string($value) )
		{
			$count = strlen($value);
			if ( null !== $this->_min ) {
				if ( $count < $this->_min ) {
					$this->setMessage(self::TOO_SHORT, $this->getMessage(self::TOO_SHORT, $value) );
					$this->_isError = true;
					return false;
				}
			}
			if ( null !== $this->_max ) {
				if ( $count > $this->_max ) {
					$this->setMessage(self::TOO_LONG, $this->getMessage(self::TOO_LONG, $value) );
					$this->_isError = true;
					return false;
				}
			}
			return true;
		}
		$this->setMessage(self::INVALID, $this->getMessage(self::INVALID, $this->getMessage(self::INVALID, $value) ) );
		return false;
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
			case self::TOO_SHORT	:
				return sprintf( __("'%s' is less than %s characters long", 'W2P'), $value, $this->_min );
			case self::TOO_LONG		:
				return sprintf( __("'%s' is more than %s characters long", 'W2P'), $value, $this->_max );
		}
	}
}