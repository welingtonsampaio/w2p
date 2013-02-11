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
interface W2P_Validate_Interface
{
	/**
	 * Retorna true se e somente se o valor atende aos
	 * requisitos de validacao
	 * 
	 * Se o valor nao passar na validacao, esse metodo
	 * retorna false, e o metodo getMessages() ira retornar
	 * um array de mensagens para explicar porque houve a
	 * falha na validacao.
	 * 
     * @return boolean
     * @throws W2P_Validate_Exception
     * 		Se a validacao de $value for impossivel
	 */
	public function isValid();
	
	/**
	 * Retorna uma matriz de mensagens que explicam por que
	 * o retorno foi false no metodo isValid(). As chaves
	 * do array sao identificadores de validacao mensagem de
	 * erro, e os valores da matriz são mensagens legiveis.
	 *
	 * Se isValid() nao foi chamado ou se o isValid() mais
	 * recente retornou true, então este método retorna um
	 * array vazio.
	 *
	 * @return array
	 */
	public function getMessages();
	
	/**
	 * Retorna uma string da mensagem que explica um erro
	 * traduzido para a linguagem configurada
	 * 
     * @return string
	 */
	public function getMessage($messageVariable, $value);
}