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

namespace Form\Element;

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
class Radio extends AbstractMultioptions
{
	/**
	 * Modelo de impressao do elemento
	 * @return string
	 */
	protected $_template = '{options}';
	/**
	 * Modelo de impressao da opcao do elemento
	 * @var string
	 */
	protected $_templateOption = '<label for="{oid}">{olabel}</label><input type="{type}" name="{oname}" id="{oid}" {ovalue}{required}{checked}{attributes} />';
	/**
	 * Tipo do elemento html
	 * @var string
	 */
	protected $_type = 'radio';
	
	
	/**
	 * Defined by W2P_Form_Element_Interface
	 * @return array
	 */
	public function toArray()
	{
		$element['type']		= $this->getType();
		$element['name']		= $this->getName();
		$element['id']			= $this->getId();
		$element['value']		= $this->getValue()			? ' value="'.$this->getValue().'"'				: '';
		$element['placeholder']	= $this->getPlaceholder()	? ' placeholder="'.$this->getPlaceholder().'"'	: '';
		$element['required']	= $this->_required			? ' required="required"'						: '';
		$element['autofocus']	= $this->getAutofocus()		? ' autofocus="autofocus"'						: '';
		$element['label']		= $this->getLabel()			? $this->getLabel()								: '';
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
		foreach ( $data['multioptions'] as $label=>$value )
		{
			$data['olabel']		= $label;
			$data['ovalue']		= ' value="'.$value.'"';
			$data['oid']		= uniqid($data['id']);
			$data['checked']	= ($data['ovalue'] == $data['value']) ? ' checked="true"' : '';
			$data['oname']		= $data['name'].'[]';
			
			$data['options'] .= @preg_replace('/\{([^}]*)\}/e', '$data[\\1]', $tplo);
		}
		if ( '' === $data['options'] )
		{
			$data['olabel']	= $data['label'];
			$data['ovalue']	= $data['value'];
			$data['oid']	= $data['id'];
			$data['options'] .= @preg_replace('/\{([^}]*)\}/e', '$data[\\1]', $tplo);
		}
		
		$tpl = $this->getTemplate();
		return @preg_replace('/\{([^}]*)\}/e', '$data[\\1]', $tpl);
	}
}