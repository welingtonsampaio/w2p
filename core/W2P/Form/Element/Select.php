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

namespace W2P\Form\Element;

/**
 * Define the element text input
 * 
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
class Select extends AbstractMultioptions
{
	/**
	 * Modelo de impressao do elemento
	 * @return string
	 */
	protected $_template = '<label for="{id}">{label}</label><select name="{name}" id="{id}"{required}{attributes}>{options}</select>';
	/**
	 * Modelo de impressao da opcao do elemento
	 * @var string
	 */
	protected $_templateOption = '<option value="{ovalue}"{selected}>{olabel}</option>';
	/**
	 * Tipo do elemento html
	 * @var string
	 */
	protected $_type = 'select';
	
	
	/**
	 * Defined by W2P_Form_Element_Interface
	 * @return array
	 */
	public function toArray()
	{
		$element['type']		= $this->getType();
		$element['name']		= $this->getName();
		$element['id']			= $this->getId();
		$element['value']		= $this->getValue()	? $this->getValue()			: '';
		$element['required']	= $this->_required	? ' required="required"'	: '';
		$element['label']		= $this->getLabel()	? $this->getLabel()			: '';
		$element['attributes']	= '';
		if ( $this->getAttributes() )
		{
			foreach ( $this->getAttributes() as $key=>$attr )
				$element['attributes'] .= ' '.$key.'="'.$attr.'"';
		}
		return $element;
	}
	/**
	 * Defined by W2P_Form_Element_Interface
	 * @return string
	 */
	public function __toString()
	{
		$data = $this->toArray();
		$data['multioptions'] = $this->getMultioptions();
		$data['options'] = '';
		
		$tplo = $this->getTemplateOptions();
		foreach ( $data['multioptions'] as $value=>$label )
		{
			$data['olabel']		= $label;
			$data['ovalue']		= $value;
			$data['selected']	= ($data['ovalue'] == $data['value']) ? ' selected="selected"' : '';
			
			$data['options'] .= @preg_replace('/\{([^}]*)\}/e', '$data[\\1]', $tplo);
		}
		
		$tpl = $this->getTemplate();
		return @preg_replace('/\{([^}]*)\}/e', '$data[\\1]', $tpl);
	}
}