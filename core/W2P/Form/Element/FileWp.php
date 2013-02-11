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
class W2P_Form_Element_FileWp extends W2P_Form_Element_Abstract
{
	/**
	 * Modelo de impressao do elemento
	 * @return string
	 */
	protected $_template = '
	<label for="filewp-{id}" class="filewp-{id}">{label}</label>
	<div class="form-search">
	<div class="input-append">
		<input type="text" class="span4 search-query" name="{name}" id="filewp-{id}"{value}{placeholder}{required}{autofocus}{attributes} />
		<button type="button" class="btn w2p-upload" data-target="filewp-{id}" data-postid="{postid}">Upload</button>
	</div>
	</div>';
	/**
	 * Tipo do elemento html
	 * @var string
	 */
	protected $_type = 'fileWp';
	/**
	 * Id de identificacao para o upload
	 * @var int
	 */
	protected $_postid = null;

	/**
	 * Retorna a referencia de identificacao 
	 * para upload do arquivo para o post
	 * determinado
	 * @return int
	 */
	public function getPostid()
	{
		return $this->_postid;
	}
	/**
	 * Configura o ID do post para armazenamento de
	 * referencia ao post correto
	 * @param int $postid
	 * @return W2P_Form_Element_RadioWp
	 */
	public function setPostid( $postid )
	{
		$this->_postid = $postid;
		return $this; 
	}
	/**
	 * Defined by W2P_Form_Element_Interface
	 * @return array
	 */
	public function toArray()
	{
		$element['type']		= $this->getType();
		$element['name']		= $this->getName();
		$element['id']			= $this->getId();
		$element['postid']		= $this->getPostid();
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
		$tpl = $this->getTemplate();
		return @preg_replace('/\{([^}]*)\}/e', '$data[\\1]', $tpl);
	}
}