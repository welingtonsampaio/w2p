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

namespace W2P;

/**
 * Classe responsavel por gerar area administrativa
 * 
 * @example $admin = $system->admin();<br>
 * $module1 = new Admin\Module( W2P_APPNAME );<br>
 * $module2 = new Admin\Module( 'Redes Sociais' );<br>
 * $module2->addItem('linkFacebook')->setLabel('Link for page of facebook');<br>
 * $module2->addItem('linkTwitter')->setLabel('Link for page of Twitter');<br>
 * $admin->addModule($module1);<br>
 * $admin->addModule($module2);<br>
 * $admin->addThemeAdmin();
 * 
 * @author Welington Sampaio ( @link http://welington.zaez.net )
 * @version 1.0
 * 
 * @category	W2P
 * @package		W2P
 * @since		1.0
 * @copyright	Copyright (c) 2012 Zaez Solução em Tecnologia Ltda - Welington Sampaio
 * @license		http://creativecommons.org/licenses/by-nd/3.0/  Creative Commons
 */
class Admin
{
	/**
	 * Contem se eh para gerar campo de
	 * manutencao ou nao
	 * @var boolean
	 */
	protected $_noUsedMaintenance = false;
	/**
	 * Contem se eh para gerar campo de
	 * Key Analytics ou nao
	 * @var boolean
	 */
	protected $_noUsedKeyAnlytics = false;
	/**
	 * Matriz de objetos Admin\Module
	 * @var array
	 */
	protected $_modules = array();
	/**
	 * Nome da pagina de administracao
	 * @var string
	 */
	protected $name = 'W2P Theme options';
	
	/**
	 * Adiciona um modulo a pagina de administracao
	 * os modulos sao responsaveis por um item no meu da
	 * pagina de administracao, e cada modulo por conter
	 * campos personalizados que podera ser resgatado
	 * posteriormente pelo objeto W2P_Configuration
	 *
	 * @param Admin\Module|string $param
	 * @return Admin\Module
	 */
	public function addModule( $param )
	{
		if ( is_string($param) ) {
			$this->_modules[$param] = new Admin\Module($param);
			return $this->_modules[$param];
		} elseif ( $param instanceof Admin\Module ) {
			$this->_modules[ $param->getName() ] = $param;
			return $param;
		}
		throw new Exception( __("Incorrect value for the parameter.",'W2P') );
	}
	/**
	 * Diz ao theme que ele tera suporte ao recurso
	 * de administracao gerado pelo w2p
	 */
	public function addThemeAdmin()
	{
		$defaultModule = $this->getModule( W2P_APPNAME , true );
		// Configura o modok manutencao caso exista no path de modulos
		if ( $this->_noUsedMaintenance !== true )
		{
			if ( W2P::getInstance()->modules()->exists_module('maintenance') === true )
			{
				$modeMaintenance = new Form\Element\RadioWp('modeMaintenance');
				$modeMaintenance->setLabel(__('Mode maintenance ( active / deactive )', 'W2P'));
				$defaultModule->addItem($modeMaintenance);
			}
		}
		
		if ( $this->_noUsedKeyAnlytics !== true )
		{
			$keyAnalytics = new Form\Element\Text('keyAnalytics');
			$keyAnalytics->setLabel( __('Enter the Google Key Analytics for integration in system', 'W2P') );
			$defaultModule->addItem($keyAnalytics);
		}
			
		// Grava os dados padr�es no banco de dados
		$options = (get_option('w2p_theme_options_'.W2P_APPNAME) ? get_option('w2p_theme_options_'.W2P_APPNAME) : '');
		if (empty($options)){
			$ar = array();
			foreach ( $this->_modules as $module )
			{
				/** @var $module Admin\Module */
				foreach ( $module->getItens() as $item )
				{
                    /** @var $item Form\Element */
					$dv = $item->getValue();
					$ar[ $item->getName() ] = $dv;					
					$ar[ $item->getName() ] = ( $item->getType() == 'radioWp'		? 0 : $ar[ $item->getName() ] );
				}
			}
			$options = serialize($ar);
			add_option('w2p_theme_options_'.W2P_APPNAME, $options);
		}
		$d = unserialize( $options );
		if ( is_array( $d ) )
			foreach ($d as $key=>$value)
				W2P::getInstance()->configuration()->{$key} = $value;
		
		add_action('admin_enqueue_scripts', array( &$this, 'admin_head' ) );
		add_action('admin_menu', array( &$this, 'admin_menu' ) );
		add_action('admin_init', array( &$this, 'save_data' ) );
	}
	/**
	 * Metodo responsavel por adicionar os stylesheet e
	 * javascripts no head da pagina de admin
	 * @see WP_Styles::add(), WP_Styles::enqueue()
	 * @see WP_Scripts::enqueue(), WP_Scripts::add()
	 */
	public function admin_head()
	{
		// Styles
		wp_enqueue_style('thickbox');
		echo '<link rel="stylesheet" type="text/css" href="' .W2P_URL . W2P::getInstance()->configuration()->assets_path . '/css/bootstrap.w2p.min.css'. '" />';
		$style = W2P::getInstance()->stylesheet()->renderSass('w2p.scss', W2P_COREPATH.'/assets/scss/', true);
		wp_register_style('w2p', $style);
		wp_enqueue_style('w2p');
		
		// Scripts
		wp_enqueue_script('media-upload');
		wp_enqueue_script('thickbox');
		wp_register_script('w2p', W2P_ASSETSPATH . 'javascripts/script.js', array('jquery','media-upload','thickbox'));
		wp_enqueue_script('w2p');
		wp_register_script('bootstrap', W2P_URL . W2P::getInstance()->configuration()->assets_path . '/javascripts/bootstrap.min.js', array('jquery'));
		wp_enqueue_script('bootstrap');
	}
	/**
	 * Action responsavel por adicionar o suporte no
	 * admin { @link http://codex.wordpress.org/Function_Reference/add_theme_page }
	 */
	public function admin_menu()
	{
		add_theme_page ( $this->name, $this->name, 'edit_themes', basename ( __FILE__ ), array( &$this, 'w2p_theme_admin' ) );
	}
	/**
	 * Retona o array de modulos criados
	 * @return array
	 */
	public function getAllModules( )
	{
		return $this->_modules;
	}
	/**
	 * Recupera o modulo solicitado caso nao exista
	 * se habilitado o paramentro $forceCreate ele
	 * cria o modulo e o retorna
	 * 
	 * @see W2P_Admin::addModule()
     *
     * @param string $name
     * @param boolean $forceCreate
     *
     * @throws Exception
     *
	 * @return Admin\Module
	 */
	public function getModule( $name, $forceCreate = false )
	{
		if ( key_exists($name, $this->_modules) )
			return $this->_modules[$name];
		if ( $forceCreate )
			return $this->addModule($name);
		throw new Exception( __("Name of invalid module.", 'W2P') );
	}
	/**
	 * Desabilita a opcao de Key Analytics na
	 * area administrativa do w2p
	 */
	public function noUsedKeyAnlytics()
	{
		$this->_noUsedKeyAnlytics = true;
	}
	/**
	 * Desabilita a opcao de modo manutencao na
	 * area administrativa do w2p
	 */
	public function noUsedMaintenance()
	{
		$this->_noUsedMaintenance = true;
	}
	/**
	 * Action responsavel por gravar os dados
	 * da pagina de administracao, esta action
	 * interfere os processos e imprime um JSON
	 * para informar o javascript a situacao final
	 * da gravacao 
	 */
	public function save_data()
	{
		if ( !isset ( $_REQUEST ['w2p_theme_gravar'] ))
			return false;
		
		$options = unserialize( get_option('w2p_theme_options_'.W2P_APPNAME) );
		$newOptions = $options;
		
		foreach ( $this->_modules as $module )
		{
			$module instanceof Admin\Module;
			if ( $_POST['w2p_theme_gravar'] == md5( $module->getName() ) )
			{
				foreach ( $module->getItens() as $item )
				{
					$item instanceof Form\Element;
					$newOptions[ $item->getName() ] = $_POST[ $item->getName() ];
				}
			}
		}
		
		if ( $newOptions != $options )
		{
			update_option ( 'w2p_theme_options_'.W2P_APPNAME , serialize ( $newOptions ) );
			$data = array('status'=>'ok', 'message'=>__('Updated options successfully!', 'W2P') );
		}else{
			$data = array('status'=>'info', 'message' => __('It brings up to date a content to bring up to date successfully.', 'W2P'), 'content' => $options );
		}
		
		header("Content-type: application/json");
		echo json_encode($data);
		
		exit();
	}
	/**
	 * Metodo responsavel por gerar o html da pagina
	 * de administracao
	 */
	public function w2p_theme_admin()
	{
		$html = new Admin\Html();
		$html->render();
	}
}