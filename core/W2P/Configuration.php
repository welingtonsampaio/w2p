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
 * Classe para request de configuracoes do theme 
 * e da pagina administrativa
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
class W2P_Configuration
{
	/**
	 * Contem as configuracoos do sistema, caminhos de
	 * pastas, localizacao de arquivos etc.
	 * @var array
	 */
	protected $_properties = array();
	/**
	 * Contem as propriedades privadas do sistema
	 * @var array
	 */
	protected $_protected = array('_properties', '_protected', 'version', 'system_autor', 'system_url', 'core_path', 'assets_path', 'helper_path', 'module_path', 'widget_path', 'layout_path', 'cache_path', 'lang_path', 'debug_path', 'debug_name');
	
	/**
	 * Metodo construtor
	 */
	public function __construct()
	{
		$this->cfn_system = $this->get_default_cnf();
	}
	/**
	 * Imprime o conteudo das configuracoes
	 * de forma a nao atrapalhar o visual da
	 * pagina
	 * @return void
	 */
	public function debugging($hide = true)
	{
		if ($hide) echo "<!--\n\n\n";
		echo "<pre>\n\n";
			print_r($this->_properties);
		echo "\n\n</pre>";
		if ($hide) echo "\n\n\n-->";
	}
	/**
	 * Retorna array com as configuracoes defaults do sitema
	 * 
	 * @since 2.0
	 * @return array
	 */
	protected function get_default_cnf()
	{
		global $w2p_configs;
		if ( isset( $w2p_configs ) )
		{
			if ( !is_array($w2p_configs) )
				$w2p_configs = array();
		}else{
			$w2p_configs = array();
		}
		$this->_properties = array(
				'version'				=> W2P_VERSION,
				'system_autor'			=> 'Welington Sampaio',
				'system_url'			=> 'http://w2p.zaez.net/',
				'core_path'				=> '/core',
				'assets_path'			=> '/assets',
				'helper_path'			=> '/helpers',
				'module_path'			=> '/modules',
				'widget_path'			=> '/widgets',
				'layout_path'			=> '/layouts',
				'cache_path'			=> '/cache',
				'lang_path'				=> '/lang',
				'debug'					=> 'false',
				'debug_path'			=> '/debug',
				'debug_name'			=> 'index.php',
				'debug_format'			=> 'html',
				'jquery_version'		=> '1.7.2',
				'jquery_online_version'	=> false,
				'sass_extension'		=> 'scss',
				'sass_file_default'		=> 'w2p',
				'compress_css_js'		=> false,
				'developer_link'		=> 'http://zaez.net',
				'developer_logo'		=> 'http://utilidades.zaez.net/logo.png'
				);
		foreach ($w2p_configs as $key => $value)
			$this->{$key} = $value;
	}
	/**
	 * Configura o que o thema tera support
	 * 
	 * @since 1.0
	 */
	private function set_theme_configs()
	{
		if ( $this->cfn_system['used_thumbnails'] )
			add_theme_support( 'post-thumbnails' );
	}
	/**
	 * Method magician responsible for capturing the value
	 * of the requested property
	 * 
	 * @param string $property
	 * @throws W2P_Exception
	 * @since 1.0
	 * @return mixed
	 */
	public function __get($property)
	{
		if ( key_exists($property, $this->_properties) )
			return $this->_properties[$property];
		// DEBUG caso nao exista a propriedade
		throw new W2P_Exception( sprintf(__('The property %s was not configured in the system.', 'W2P'), $property) );
		return false;
	}
	/**
	 * Magic set method responsible for the property values
	 * 
	 * @param string $property
	 * @param mixed $value
	 * @since 1.0
	 * @throws W2P_Exception
	 * @return boolean
	 */
	public function __set($property, $value)
	{
		$property = str_replace('__', '', $property);
		if ( in_array($property, $this->_protected) )
		{
			throw new W2P_Exception( sprintf(__('%s is a privately owned system, try again with another name.', 'W2P'), $property) );
			return false;
		}
		$this->_properties[$property] = $value;
		
		$this->set_theme_configs();
		
		return true;
	}
	/**
	 * Magic print method
	 */
	public function __toString()
	{
		$r = "<pre><br />\n";
		foreach ( $this->_properties as $key=>$item)
			$r .= "\t{$key} = {$item}\n";
		$r .= "</pre>\n";
		return $r;
	}
}