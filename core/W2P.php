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
 * @copyright	Copyright (c) 2012 Zaez Solu��o em Tecnologia Ltda - Welington Sampaio
 * @license		http://creativecommons.org/licenses/by-nd/3.0/  Creative Commons
 */

define('W2P_VERSION', '2.0');

defined( 'W2P_APPNAME' )
	|| define( 'W2P_APPNAME' , 'W2P_default_theme' );

defined ( 'W2P_ASSETSPATH' )
	|| define( 'W2P_ASSETSPATH' , W2P_URL.DIRECTORY_SEPARATOR.'core/assets/' );

defined ( 'W2P_COREPATH' )
	|| define( 'W2P_COREPATH' , realpath(dirname(__FILE__) . '/') );

require_once W2P_COREPATH . '/W2P/Autoloader.php';
require_once W2P_COREPATH . '/W2P/Core.php';

/**
 * Classe responsavel por recuperar todos os modulos
 * do sistema w2p.
 * 
 * @example
 * $system = W2P::getInstance();
 * $system->html()->image('name.ext');
 * $system->configuration()->version;
 * 
 * @author Welington Sampaio ( @link http://welington.zaez.net )
 * @version 1.0
 * 
 * @category	W2P
 * @since		1.0
 * @copyright	Copyright (c) 2012 Zaez Solu��o em Tecnologia Ltda - Welington Sampaio
 * @license		http://creativecommons.org/licenses/by-nd/3.0/  Creative Commons
 */
class W2P extends W2P_Core
{
	/**
	 * Instancia unica do objeto
	 * 
	 * @var W2P
	 */
	public static $_w2p = null;
	/**#@+
	 * Referencias dos objetos
	 * 
	 * @var mixed
	 */
	protected $__admin = null;
	protected $__configuration = null;
	protected $__debug = null;
	protected $__email = null;
	protected $__helper = null;
	protected $__html = null;
	protected $__javascript = null;
	protected $__language = null;
	protected $__modules = null;
	protected $__post = null;
	protected $__stylesheet = null;
	/**#@-*/
	
	public function __construct()
	{
		new W2P_Autoloader();
	}
	/**
	 * Retorna o objeto propriamente dito
	 *
	 * @version 1.0
	 * @return W2P
	 */
	public static function getInstance() {
		if (W2P::$_w2p instanceof W2P)
			return W2P::$_w2p;
		W2P::$_w2p = new W2P ();
		
		W2P::$_w2p->configuration();
		W2P::$_w2p->admin()->addThemeAdmin();
		W2P::$_w2p->modules();
		W2P::$_w2p->language();
		W2P::$_w2p->debug();
		return W2P::$_w2p;
	}
	/**
	 * Retorna o objeto admin
	 * @version 1.0
	 * @see W2P_Admin()
	 * @return W2P_Admin
	 */
	public function admin()
	{
		if ( !$this->__admin )
			$this->__admin = new W2P_Admin();
		return $this->__admin;
	}
	/**
	 * Retorna o objeto configuration
	 * @version 1.0
	 * @return W2P_Configuration
	 */
	public function configuration()
	{
		if ( !$this->__configuration )
			$this->__configuration = new W2P_Configuration();
		return $this->__configuration;
	}
	/**
	 * Retorna o objeto debug
	 * @version 1.0
	 * @return W2P_Debug
	 */
	public function debug()
	{
		if ( !$this->__debug )
			$this->__debug = new W2P_Debug();
		return $this->__debug;
	}
	/**
	 * Retorna o objeto email
	 * @version 1.0
	 * @return W2P_Email
	 */
	public function email()
	{
		if ( !$this->__email )
			$this->__email = new W2P_Email();
		return $this->__email;
	}
	/**
	 * Retorna o objeto helper
	 * @version 1.0
	 * @return W2P_Helper
	 */
	public function helper()
	{
		if ( !$this->__helper )
			$this->__helper = new W2P_Helper();
		return $this->__helper;
	}
	/**
	 * Retorna o objeto html
	 * @version 1.0
	 * @return W2P_Html
	 */
	public function html()
	{
		if ( !$this->__html )
			$this->__html = new W2P_Html();
		return $this->__html;
	}
	/**
	 * Retorna o objeto javascript
	 * @version 1.0
	 * @return W2P_Javascript
	 */
	public function javascript()
	{
		if ( !$this->__javascript)
			$this->__javascript = new W2P_Javascript();
		return $this->__javascript;
	}
	/**
	 * Retorna o objeto language
	 * @version 1.0
	 * @return W2P_Language
	 */
	public function language()
	{
		if ( !$this->__language )
			$this->__language = new W2P_Language();
		return $this->__language;
	}
	/**
	 * Retorna o objeto modules
	 * @version 1.0
	 * @return W2P_Modules
	 */
	public function modules()
	{
		if ( !$this->__modules )
			$this->__modules = new W2P_Modules();
		return $this->__modules;
	}
	/**
	 * Retorna o objeto post
	 * @version 1.0
	 * @return W2P_Post
	 */
	public function post()
	{
		if ( !$this->__post )
			$this->__post = new W2P_Post();
		return $this->__post;
	}
	/**
	 * Retorna o objeto stylesheet
	 * @version 1.0
	 * @return W2P_Stylesheet
	 */
	public function stylesheet()
	{
		if ( !$this->__stylesheet )
			$this->__stylesheet = new W2P_Stylesheet();
		return $this->__stylesheet;
	}
}