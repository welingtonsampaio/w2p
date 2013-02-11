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
 * @package		Admin
 * @subpackage	Module
 * @copyright	Copyright (c) 2012 Zaez Solução em Tecnologia Ltda - Welington Sampaio
 * @license		http://creativecommons.org/licenses/by-nd/3.0/  Creative Commons
 */

/**
 * Classe responsavel por criar itens para os modulos
 * os itens sao renderizados como campos na pagina de
 * administracao, atraves das informacoes previamente
 * enviadas para o objeto. A classe conta com sistema
 * de metodos encadeiados, facilitando assim a
 * configuracao do mesmo.
 * 
 * @example 
 * $item = new W2P_Admin_Module_Item( 'nome_unico' );<br>
 * $item->setType( 'text' )<br>
 *      ->setLabel( 'Entre com um texto' )<br>
 *      ->setDefaultValue( 'Texto inicial padrao' );
 * 
 * @author Welington Sampaio { @link http://welington.zaez.net/ }
 * @since 0.1
 */
class W2P_Admin_Module_Item
{
	/**
	 * Valor default para o item
	 * @var string
	 */
	protected $defaultValue = null;
	/**
	 * Texto da label do item
	 * @var string
	 */
	protected $label = null;
	/**
	 * Nome do item ( deve ser unico )
	 * @var string
	 */
	protected $name = null;
	/**
	 * Parametros adicionais ao item
	 * @var string
	 */
	protected $params = null;
	/**
	 * Tipo de renderizacao do item
	 * @var string
	 */
	protected $type = 'text';
	
	/**
	 * Metodo construtor, apenas configura o nome
	 * do campo, segundo o valor enviado
	 * 
	 * @param string $name
	 */
	public function __construct( $name )
	{
		$this->setName($name);
	}
	/**
	 * Recupara o valor atual do DefaultValue do item
	 * @return null|string
	 */
	public function getDefaultValue( )
	{
		return ( empty($this->defaultValue) ? null : $this->defaultValue );
	}
	/**
	 * Recupera o valor atual da label
	 * @return string
	 */
	public function getLabel( )
	{
		return $this->label;
	}
	/**
	 * Recupera o atual nome do item
	 * @return string
	 */
	public function getName( )
	{
		return $this->name;
	}
	/**
	 * Recupera os parametros atuais do item
	 * @return string
	 */
	public function getParams( )
	{
		return $this->params;
	}
	/**
	 * Recupera o tipo atual do item
	 * @return string
	 */
	public function getType( )
	{
		return $this->type;
	}
	/**
	 * Configura o novo valor para defaultValue
	 * @param string $defaultValue
	 * @return W2P_Admin_Module_Item
	 */
	public function setDefaultValue( $defaultValue )
	{
		$this->defaultValue = $defaultValue;
		return $this;
	}
	/**
	 * Configura o novo valor para o label
	 * @param string $label
	 * @return W2P_Admin_Module_Item
	 */
	public function setLabel( $label )
	{
		$this->label = $label;
		return $this;
	}
	/**
	 * Configura o novo valor para o nome
	 * @param string $name
	 * @return W2P_Admin_Module_Item
	 */
	public function setName( $name )
	{
		$this->name = $name;
		return $this;
	}
	/**
	 * Configura o novo valor para os paramentros
	 * @param string $params
	 * @return W2P_Admin_Module_Item
	 */
	public function setParams( $params )
	{
		$this->params = $params;
		return $this;
	}
	/**
	 * Configura o novo valor para o tipo
	 * @param string $type
	 * 		Options: text, textarea, radio, image
	 * @throws Exception
	 * 		Caso o tipo enviado seja invalido
	 * @return W2P_Admin_Module_Item
	 */
	public function setType( $type )
	{
		$types = array( 'text', 'textarea', 'radio', 'image' );
		if ( in_array($type, $types) )
		{
			$this->type = $type;
			return $this;
		}
		throw new Exception( sprintf( __('Parameter "%s" of invalid item.'), $type ) );
	}
	/**
	 * Recupera os dados do item renderizado
	 * como array
	 * @return array
	 */
	public function toArray()
	{
		$ar['name'] = $this->getName();
		$ar['type'] = $this->getType();
		$ar['params'] = $this->getParams();
		$ar['defaultValue'] = $this->getDefaultValue();
		$ar['label'] = $this->getLabel();
		return $ar;
	}
}