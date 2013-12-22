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
class Regex extends AbstractClass
{
	const INVALID	= 'regexInvalid';
    const NOT_MATCH	= 'regexNotMatch';
    const ERROROUS	= 'regexErrorous';
	
    /**
     * Regular expression pattern
     *
     * @var string
     */
    protected $_pattern;
	/**
	 * Override
	 * Contém as variaveis de mensagens de erro
	 * @var array
	 */
	protected $_messageVariables = array(
		self::INVALID,
		self::NOT_MATCH,
		self::ERROROUS
	);
	
	/**
	 * The constructor
	 *
	 * @param $pattern String
     *  is a regular expression
	 */
	public function __construct( $pattern )
	{
		$this->setPattern($pattern);
	}
	
	/**
	 * Defined by InterfaceClass
     *
     * @param $value String
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
		
		if ( !is_string($value) && !is_int($value) && !is_float($value) )
		{
			$this->setMessage(self::INVALID, $this->getMessage(self::INVALID, $value));
			$this->_isError = true;
			return false;
		}
		
		$status = @preg_match($this->_pattern, $value);
		if (false === $status)
		{
			$this->setMessage(self::ERROROUS, $this->getMessage(self::ERROROUS, null) );
			$this->_isError = true;
			return false;
		}
		
		if (!$status) {
			$this->setMessage(self::NOT_MATCH, $this->getMessage(self::NOT_MATCH, $value));
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
	 * @return string
	 */
	public function getMessage( $messageVariable, $value )
	{
		if ( !in_array($messageVariable, $this->_messageVariables) )
			throw new Exception( sprintf( __("There is registered message to: %s", 'W2P'), $messageVariable) );
		switch ( $messageVariable )
		{
			case self::INVALID		:
				return __("Invalid type given. String, integer or float expected", 'W2P');
			case self::NOT_MATCH	:
				return sprintf( __("'%s' does not match against pattern %s", 'W2P'), $value, $this->_pattern );
			case self::ERROROUS		:
				return sprintf( __("There was an internal error while using the pattern '%s'", 'W2P'), $this->_pattern );
		}
	}
	
	/**
	 * Returns the pattern option
	 *
	 * @return string
	 */
	public function getPattern()
	{
		return $this->_pattern;
	}
	
	/**
	 * Sets the pattern option
	 *
	 * @param  string $pattern
	 * @throws Exception if there is a fatal error in pattern matching
	 * @return Regex Provides a fluent interface
	 */
	public function setPattern($pattern)
	{
		$this->_pattern = (string) $pattern;
		$status         = @preg_match($this->_pattern, "Test");
	
		if (false === $status) 
			throw new Exception( $this->getMessage(self::ERROROUS, null) );
	
		return $this;
	}
}