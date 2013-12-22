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
 * @author Welington Sampaio ( @link http://welington.zaez.net )
 * @version 2.0
 * 
 * @category	W2P
 * @package		W2P
 * @subpackage	Admin
 * @copyright	Copyright (c) 2012 Zaez Solução em Tecnologia Ltda - Welington Sampaio
 * @license		http://creativecommons.org/licenses/by-nd/3.0/  Creative Commons
 */

namespace W2P\Admin;
use W2P\Form\Element;

/**
 * Classe responsavel por criar modulos na pagina
 * de administracao, esses modulos sao itens do menu
 * da pagina de administracao, que pode conter um ou
 * mais campos de texto, imagens etc, onde os mesmos
 * sao gravados no banco para poder ser usado na 
 * criacao do seu theme, utilize modulos apenas para 
 * configuracoes que vc deseja dar permisao para que 
 * o cliente tenha a possibilidade de modificar, caso 
 * contrario use a classe W2P_Configuration 
 * para armazenar dados que podem ser utilizados no 
 * theme
 * 
 * @example 
 * $module2 = new W2P_Admin_Module( 'Social Midia' );<br>
 * $module2->addItem('linkFacebook')->setLabel('Link for page of facebook');<br>
 * $module2->addItem('linkTwitter')->setLabel('Link for page of Twitter');
 * 
 * @author Welington Sampaio ( @link http://welington.zaez.net )
 * @version 1.0
 * 
 * @category	W2P
 * @package		W2P
 * @subpackage	Admin
 * @since		1.0
 * @copyright	Copyright (c) 2012 Zaez Solução em Tecnologia Ltda - Welington Sampaio
 * @license		http://creativecommons.org/licenses/by-nd/3.0/  Creative Commons
 */
class Module
{
	/**
	 * Identificacao do icone
	 * @var string
	 */
	protected $icone = 'icon-pencil';
	/**
	 * Matriz com dados dos itens
	 * @var array
	 */
	protected $itens = array();
	/**
	 * Nome do modulo, este deve ser unico
	 * @var string
	 */
	protected $name = null;
	/**
	 * @var array
	 */
	private $allIcons = array(
			'icon-glass', 'icon-music', 'icon-search', 'icon-envelope', 'icon-heart',
			'icon-star', 'icon-star-empty', 'icon-user', 'icon-film', 'icon-th-large',
			'icon-th', 'icon-th-list', 'icon-ok', 'icon-remove', 'icon-zoom-in',
			'icon-zoom-out', 'icon-off', 'icon-signal', 'icon-cog', 'icon-trash',
			'icon-home', 'icon-file', 'icon-time', 'icon-road', 'icon-download-alt',
			'icon-download', 'icon-upload', 'icon-inbox', 'icon-play-circle',
			'icon-repeat', 'icon-refresh', 'icon-list-alt', 'icon-lock', 'icon-flag',
			'icon-headphones', 'icon-volume-off', 'icon-volume-down', 'icon-volume-up',
			'icon-qrcode', 'icon-barcode', 'icon-tag', 'icon-tags', 'icon-book',
			'icon-bookmark', 'icon-print', 'icon-camera', 'icon-font', 'icon-bold',
			'icon-italic', 'icon-text-height', 'icon-text-width', 'icon-align-left',
			'icon-align-center', 'icon-align-right', 'icon-align-justify', 'icon-list',
			'icon-indent-left', 'icon-indent-right', 'icon-facetime-video',
			'icon-picture', 'icon-pencil', 'icon-map-marker', 'icon-adjust', 'icon-tint',
			'icon-edit', 'icon-share', 'icon-check', 'icon-move', 'icon-step-backward',
			'icon-fast-backward', 'icon-backward', 'icon-play', 'icon-pause', 'icon-stop',
			'icon-forward', 'icon-fast-forward', 'icon-step-forward', 'icon-eject',
			'icon-chevron-left', 'icon-chevron-right', 'icon-plus-sign', 'icon-minus-sign',
			'icon-remove-sign', 'icon-ok-sign', 'icon-question-sign', 'icon-info-sign',
			'icon-screenshot', 'icon-remove-circle', 'icon-ok-circle', 'icon-ban-circle',
			'icon-arrow-left', 'icon-arrow-right', 'icon-arrow-up', 'icon-arrow-down',
			'icon-share-alt', 'icon-resize-full', 'icon-resize-small', 'icon-plus',
			'icon-minus', 'icon-asterisk', 'icon-exclamation-sign', 'icon-gift',
			'icon-leaf', 'icon-fire', 'icon-eye-open', 'icon-eye-close',
			'icon-warning-sign', 'icon-plane', 'icon-calendar', 'icon-random',
			'icon-comment', 'icon-magnet', 'icon-chevron-up', 'icon-chevron-down',
			'icon-retweet', 'icon-shopping-cart', 'icon-folder-close', 'icon-folder-open',
			'icon-resize-vertical', 'icon-resize-horizontal', 'icon-hdd', 'icon-bullhorn',
			'icon-bell', 'icon-certificate', 'icon-thumbs-up', 'icon-thumbs-down',
			'icon-hand-right', 'icon-hand-left', 'icon-hand-up', 'icon-hand-down',
			'icon-circle-arrow-right', 'icon-circle-arrow-left', 'icon-circle-arrow-up',
			'icon-circle-arrow-down', 'icon-globe', 'icon-wrench', 'icon-tasks',
			'icon-filter', 'icon-briefcase', 'icon-fullscreen'
			);
	
	/**
	 * Metodo construtor, apenas
	 * configura o nome do modulo
	 * conforme o valor enviado
	 * 
	 * @param string $name
	 */
	public function __construct( $name )
	{
		$this->setName($name);
	}
	/**
	 * Adiciona um item ao modulo, os itens
	 * sao objetos W2P_Form_Element
	 * quem contem as informacoes necessarias
	 * para criacao do campo correspondente
	 * 
	 * @param \W2P\Form\Element $element
	 * 		Deve ser enviado um objeto do tipo W2P_Form_Element
	 * @throws Exception
	 * 		Caso o valor enviado por paramentro nao seja
	 * 		valido, e estourado uma exception
	 * @return Module\Item
	 */
	public function addItem( $element )
	{
		if ( $element instanceof Element ) {
			$this->itens[$element->getName()] = $element;
			return $this;
		}
		throw new Exception( __("Incorrect value for the parameter.", 'W2P') );
	}
	/**
	 * Recupera o item atraves do nome enviado
	 * @param string $name
	 * @throws Exception
	 * 		Caso nao exista um objeto com o nome enviado
	 * 		e estourado uma exception
	 * @return Item
	 */
	public function getItem( $name )
	{
		if ( key_exists($name, $this->itens) )
			return $this->itens[$name];
		throw new Exception( sprintf( __('Parameter "%s" of invalid item.', 'W2P'), $name ) );
	}
	/**
	 * Retorna a string com a identificacao
	 * do icone selecionado
	 * @return string
	 */
	public function getIcon()
	{
		return $this->icone;
	}
	/**
	 * Recupera o array completo de itens do modulo
	 * 
	 * @return array
	 */
	public function getItens()
	{
		return $this->itens;
	}
	/**
	 * Recupara o nome atual do modulo
	 * 
	 * @return string
	 */
	public function getName()
	{
		return $this->name;
	}
	/**
	 * Configura o icone do menu, consulte a lista
	 * completa no site do plugin bootstrap
	 * @see http://twitter.github.com/bootstrap/base-css.html#icons
	 * @param string $icon
	 * @return Module
	 */
	public function setIcon( $icon )
	{
		$this->icone = ( in_array($icon, $this->allIcons) ? $icon : 'icon-pencil');
		return $this;
	}
	/**
	 * Configuracao do nome de modulo
	 * 
	 * @param $name string
     *
     * @return Module
	 */
	public function setName( $name )
	{
		$this->name = $name;
		return $this;
	}
	
}