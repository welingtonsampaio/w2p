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
 * Classe responsavel por manutencao, inclusao e
 * gerenciamento das helpers
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
class Helper
{
	/**
	 * Matriz com nomes das extensoes para
	 * a inportacao das helpers
	 * @var array
	 */
	protected $exts = array ('.php', '.phtml', '.html' );
	/**
	 * Verify current browser name and version
	 * @since 1.0
	 * @return array
	 */
	public function get_browser()
	{
		if (preg_match ( '|MSIE ([0-9].[0-9]{1,2})|', $_SERVER ['HTTP_USER_AGENT'], $matched )) {
			$browser_version = $matched[1];
			$browser = 'Internet Explorer';
		} elseif (preg_match ( '|Opera/([0-9].[0-9]{1,2})|', $_SERVER ['HTTP_USER_AGENT'], $matched )) {
			$browser_version = $matched [1];
			$browser = 'Opera';
		} elseif (preg_match ( '|Firefox/([0-9\.]+)|', $_SERVER ['HTTP_USER_AGENT'], $matched )) {
			$browser_version = $matched [1];
			$browser = 'Firefox';
		} elseif (preg_match ( '|Chrome/([0-9\.]+)|', $_SERVER ['HTTP_USER_AGENT'], $matched )) {
			$browser_version = $matched [1];
			$browser = 'Chrome';
		} elseif (preg_match ( '|Safari/([0-9\.]+)|', $_SERVER ['HTTP_USER_AGENT'], $matched )) {
			$browser_version = $matched [1];
			$browser = 'Safari';
		} else {
			$browser_version = '-';
			$browser = __('Unidentified', 'W2P');
		}
		return array('browser'=>$browser, 'version'=>$browser_version);
	}
	/**
	 * Inclui arquivo de helpers para auxiliar em tarefas comuns
	 * captura os arquivos a partir da pasta
	 * %layout_path%/%helper_path%, com as extensoes previamente
	 * definidas dentro do metodo
	 *
	 * @param $helper String
	 * @return boolean
	 */
	public function helper($helper) {
		foreach ( $this->exts as $ext ) {
			if (file_exists ( W2P_INCLUDE . W2P::getInstance()->configuration()->layout_path . W2P::getInstance()->configuration()->helper_path . '/' . $helper . $ext )) {
				include W2P_INCLUDE . W2P::getInstance()->configuration()->layout_path . W2P::getInstance()->configuration()->helper_path . '/' . $helper . $ext;
	
				W2P::getInstance()->debug()->_debug_add_content ( "File {$helper} successfully started, helpers path" );
				return true;
			}
		}
		$this->_debug_add_content ( "Error: File {$helper} not exist on helpers path", true );
		return false;
	}
	/**
	 * Verifica se a requisicao e feita por ajax
	 * @return boolean
	 */
	public function isAjax()
	{
		return (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');
	}
	
	
}