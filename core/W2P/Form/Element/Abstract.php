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
 * @package		W2P_Form
 * @subpackage	Element
 * @copyright	Copyright (c) 2012 Zaez Solução em Tecnologia Ltda - Welington Sampaio
 * @license		http://creativecommons.org/licenses/by-nd/3.0/  Creative Commons
 */

/**
 * @author		Welington Sampaio ( @link http://welington.zaez.net )
 * @version		1.0
 * 
 * @category	W2P
 * @package		W2P_Form
 * @subpackage	Element
 * @since		1.0
 * @copyright	Copyright (c) 2012 Zaez Solução em Tecnologia Ltda - Welington Sampaio
 * @license		http://creativecommons.org/licenses/by-nd/3.0/  Creative Commons
 */
abstract class W2P_Form_Element_Abstract
	extends W2P_Form_Element 
	implements W2P_Form_Element_Interface
{
	/**
	 * Modelo de impressao do elemento
	 * @var string
	 */
	protected $_template;
	
	/**
	 * Retorna a string contendo o modelo de 
	 * impressao do elemento
	 * @return string
	 */
	public function getTemplate()
	{
		return $this->_template; 
	}
	/**
	 * Seta um novo modelo de impressao do elemento
	 * @param string $template
	 * @return W2P_Form_Element_Abstract
	 */
	public function setTemplate( $template )
	{
		$this->_template = (string) $template;
		return $this;
	}
}