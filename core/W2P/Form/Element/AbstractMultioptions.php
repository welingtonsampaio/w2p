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
abstract class W2P_Form_Element_AbstractMultioptions extends W2P_Form_Element_Abstract
{
	/**
	 * Opcoes de valores do elemento
	 * @var array
	 */
	protected $_multioptions = array();
	/**
	 * Modelo de impressao da opcao do elemento
	 * @var string
	 */
	protected $_templateOption;
	
	/**
	 * Adiciona uma nova opcao de valor no elemento
	 * @param string $label
	 * @param string $value
	 * @return W2P_Form_Element_AbstractMultioptions
	 */
	public function addMultioption( $label, $value )
	{
		$this->_multioptions[$label] = $value;
		return $this;
	}
	/**
	 * Retorna a matriz com os dados de
	 * valores do elemento.
	 * @return array
	 */
	public function getMultioptions()
	{
		return $this->_multioptions;
	}
	/**
	 * Retorna a string contendo o modelo de
	 * impressao da opcao do elemento
	 * @return string
	 */
	public function getTemplateOptions()
	{
		return $this->_templateOption;
	}
	/**
	 * Define os valores do elemento
	 * @example
	 * 		$options = array(<br>
	 * 		'label' => 'value',<br>
	 * 		'Masculino' => 'M'<br>
	 * 		);
	 * @param array $options
	 * @return W2P_Form_Element_AbstractMultioptions
	 */
	public function setMultioptions( array $options )
	{
		$this->_multioptions = (array) $options;
		return $this;
	}
	/**
	 * Seta um novo modelo de impressao da
	 * opcao do elemento
	 * @param string $template
	 * @return W2P_Form_Element_AbstractMultioptions
	 */
	public function setTemplateOptions( $template )
	{
		$this->_templateOption = (string) $template;
		return $this;
	}
}