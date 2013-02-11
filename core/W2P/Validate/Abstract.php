<?php


abstract class W2P_Validate_Abstract implements W2P_Validate_Interface
{
	/**
	 * verdadeiro se houver algum erro 
	 * @var boolean
	 */
	protected $_isError = false;
	/**
	 * Mensagens de erro geradas
	 * @var array
	 */
	protected $_messages = array();
	/**
	 * Chave das mensagens de validacao
	 * @var array
	 */
	protected $_messageVariables = array();
	/**
	 * Valor a validar
	 * @var mixed
	 */
	protected $_value;
	
	/**
	 * Retorna true caso existe erro de validacao
	 * @return boolean
	 */
	public function isError()
	{
		return $this->_isError;
	}
	/**
	 * Retorna array com as mensagens de erro da validacao
	 *
	 * @return array
	 */
	public function getMessages()
	{
		return $this->_messages;
	}
	/**
	 * Retorna o valor a ser validado
	 * 
	 * @return mixed|boolean
	 */
	public function getValue()
	{
		return (null !== $this->_value) ? $this->_value : false;
	}
	/**
	 * Retorna um array com os nomes das variaveis usadas na
	 * construcao de mensagens de erro
	 *
	 * @return array
	 */
	public function getMessageVariables()
	{
		return $this->_messageVariables;
	}
	/**
	 * Adiciona mensagem de erro
	 * 
	 * @param string $messageVariable Nome da variavel de erro
	 * @param string $message Texto de erro
	 * @return void
	 */
	public function setMessage( $messageVariable, $message )
	{
		$this->_messages[$messageVariable] = $message;
	}
	/**
	 * Configura o valor a ser validado
	 * 
	 * @param mixed $value
	 * @return void
	 */
	public function setValue( $value )
	{
		$this->_value = $value;
	}
}
