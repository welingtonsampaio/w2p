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
 * @copyright	Copyright (c) 2012 Zaez Solução em Tecnologia Ltda - Welington Sampaio
 * @license		http://creativecommons.org/licenses/by-nd/3.0/  Creative Commons
 */

/**
 * Classe responsavel por geracao custom post.
 * Custom post sao modelos de posts com nomes,
 * criacao e forma de renderizacao customizadas
 * para melhor conpreensao veja a documentacao
 * oficial do wordpress { @link http://codex.wordpress.org }
 * 
 * @author Welington Sampaio ( @link http://welington.zaez.net )
 * @version 1.0
 * 
 * @category	W2P
 * @package		W2P
 * @subpackage	Post
 * @since		1.0
 * @copyright	Copyright (c) 2012 Zaez Solução em Tecnologia Ltda - Welington Sampaio
 * @license		http://creativecommons.org/licenses/by-nd/3.0/  Creative Commons
 */
class W2P_Post_Custom
{
	/**
	 * Nome do novo tipo de post
	 * 
	 * @var string
	 */
	protected $name = null;
	/**
	 * Ojetos para a criacao dos 
	 * labels do Cutom post 
	 * 
	 * @var array
	 */
	protected $labels = array();
	/**
	 * Objeto para a configuracao do
	 * Custom post
	 * 
	 * @var array
	 */
	protected $args = array();
	
	/**
	 * The construct method
	 * 
	 * @param string $name
	 * 		Name of the custom post
	 * @param string $title
	 * 		Name of the Custom post, that will 
	 * 		appear in display menu
	 * @param string $titlePluralize
	 * 		Name of the Custom post, that will
	 * 		appear in the local pluralized 
	 */
	public function __construct( $name = 'custom_post', $title = 'Custom Post', $titlePluralize = 'Custom Posts' )
	{
		$this->name = $name;
		
		$this->labels['name']				= sprintf('%s' , $title);
		$this->labels['singular_name']	 	= sprintf('%s' , $title);
		$this->labels['add_new'] 			= sprintf( __('Add %s', 'W2P') , $title);
		$this->labels['add_new_item']		= sprintf( __('Add anew %s', 'W2P') , $title);
		$this->labels['edit_item']			= sprintf( __('Edit %s', 'W2P') , $title);
		$this->labels['new_item']			= sprintf( __('New %s', 'W2P') , $title);
		$this->labels['view_item']			= sprintf( '%s' , $title);
		$this->labels['search_items']		= sprintf( __('Search %s', 'W2P') , $titlePluralize);
		$this->labels['not_found']			= sprintf( __('No found %s', 'W2P' ) , $title);
		$this->labels['not_found_in_trash']	= sprintf( __('No %s found in the trash', 'W2P' ) , $title);
		$this->labels['parent_item_colon']	= '';
		
		$this->args['public']				= true;
		$this->args['publicly_queryable']	= true;
		$this->args['show_ui']				= true;
		$this->args['query_var']			= true;
		$this->args['rewrite']				= true;
		$this->args['capability_type']		= 'post';
		$this->args['hierarchical']			= false;
		$this->args['menu_position']		= null;
		$this->args['supports']				= array ('title', 'editor', 'thumbnail', 'revisions', 'excerpt' );
	}
	/**
	 * Setting a value of label
	 * see the documentation @link http://codex.wordpress.org/Function_Reference/register_post_type
	 * 
	 * @param string $name
	 * 				Options: name, singular_name, add_new, add_new_item, edit_item, new_item, 
						view_item, search_items, not_found, not_found_in_trash, parent_item_colon
	 * @param string $value
	 * @return W2P_Post_Custom
	 * @throws W2P_Exception
	 */
	public function setLabel( $name , $value )
	{
		$array = array('name','singular_name','add_new','add_new_item','edit_item','new_item',
						'view_item','search_items','not_found','not_found_in_trash','parent_item_colon');
		if ( in_array($name, $array) )
		{
			$this->labels[$name] = $value;
			return $this;
		}
		throw new W2P_Exception( sprintf( __('Invalid name "%s" for %s.', 'W2P'), $name, 'the label' ) );
	}
	/**
	 * Setting the argument for create a new custom post
	 * see the documentation @link http://codex.wordpress.org/Function_Reference/register_post_type
	 * 
	 * @param string $name
	 * 				Options: public, publicly_queryable, show_ui, query_var, rewrite, 
						capability_type, hierarchical, menu_position, supports
	 * @param mixed $value
	 * @return W2P_Post_Custom
	 * @throws W2P_Exception
	 */
	public function setArgument( $name , $value )
	{
		$array = array('public','publicly_queryable','show_ui','query_var','rewrite',
						'capability_type','hierarchical','menu_position','supports');
		if ( in_array($name, $array) )
		{
			$this->args[$name] = $value;
			return $this;
		}
		throw new W2P_Exception( sprintf( __('Invalid name "%s" for %s.', 'W2P'), $name, 'argument' ) );
	}
	/**
	 * Genarate custom post
	 */
	public function generate()
	{
		$this->args['labels'] 			= $this->labels;
		register_post_type ( $this->name, $this->args );
	}
}