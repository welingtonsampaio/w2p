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
 * Classe responsavel por manutencao e gerenciamento
 * dosmodulos do w2p
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
class Modules
{
	public function __construct()
	{
		$this->require_modules();
	}
	/**
	 * Retorna a pasta do modulo pedido
	 * 
	 * @param string $name      	
	 * @since 1.0
	 * @return string
	 */
	public function get_path($name)
	{
		if (is_dir ( W2P_INCLUDE . W2P::getInstance()->configuration()->core_path . W2P::getInstance()->configuration()->module_path . '/' . $name )) {
			return W2P_URL . W2P::getInstance()->configuration()->core_path . W2P::getInstance()->configuration()->module_path . '/' . $name;
		} else {
			W2P::getInstance()->debug()->_debug_add_content ( "Error: Path {$name} not existent on module_path, get_module_path", true );
			return false;
		}
	}
	/**
	 * Retorna a pasta de inclusao do modulo pedido
	 *
	 * @param string $name
	 * @since 1.0
	 * @return string|boolean
	 */
	public function get_include_path($name)
	{
		$dir = W2P_INCLUDE . W2P::getInstance()->configuration()->core_path . W2P::getInstance()->configuration()->module_path . '/' . $name;
		if (is_dir ( $dir ))
			return $dir;
		W2P::getInstance()->debug()->_debug_add_content ( "Error: Path {$name} not existent on module_path, get_module_include_path", true );
		return false;
	}
	/**
	 * Verifica se existe um determinado modulo
	 * @param string $name
	 * @return boolean
	 */
	public function exists_module( $name )
	{
		$dir = W2P_INCLUDE . W2P::getInstance()->configuration()->core_path . W2P::getInstance()->configuration()->module_path;
		return ( file_exists( $dir . DIRECTORY_SEPARATOR . $name . '.php' ) );
	}
	/**
	 * Return all name of the modules existents
	 * @return array
	 */
	public function get_all()
	{
		$dir = W2P_INCLUDE . W2P::getInstance()->configuration()->core_path . W2P::getInstance()->configuration()->module_path;
		$ar = array();
		if (is_dir ( $dir )) {
			$objects = scandir ( $dir );
			foreach ( $objects as $object ) {
				if ($object != "." && $object != "..") {
					if (filetype ( $dir . "/" . $object ) != "dir")
					{
						$ar[] = str_replace('.php', '', $object);
					}
				}
			}
		}
		return $ar;
	}
	/**
	 * Executa as funcoes dos modulos
	 */
	public function exec_all_functions()
	{
		foreach ( $this->get_all() as $module )
		{
			if ( function_exists($module) )
			{
				call_user_func($module);
			}
		}
	}
	/**
	 * Adiciona os modulos no sistema
	 *
	 * @since 1.0
	 * @return boolean
	 */
	private function require_modules() {
		$dir = W2P_INCLUDE . W2P::getInstance()->configuration()->core_path . W2P::getInstance()->configuration()->module_path;
		if (is_dir ( $dir )) {
			$objects = scandir ( $dir );
			foreach ( $objects as $object ) {
				if ($object != "." && $object != "..") {
					if (filetype ( $dir . "/" . $object ) != "dir")
					{
						require_once ($dir . "/" . $object);
					}
				}
			}
			W2P::getInstance()->debug()->_debug_add_content ( "Modules loaded successfully" );
			return true;
		} else
			return false;
	}
}