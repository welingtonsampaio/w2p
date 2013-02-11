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

/**
 * Classe responsavel por gerar o html da
 * pagina de administracao
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
class W2P_Admin_Html
{
	public function __construct()
	{}
	/**
	 * Renderiza a pagina
	 */
	public function render()
	{
		include $this->getPath() . '_loading.php';
// 		include $this->getPath() . '_notices.php';
		include $this->getPath() . '_form.php';
	}
	/**
	 * Retorna o caminho da subpasta Html
	 * onde se encontram os arquivos
	 * @return string
	 */
	private function getPath()
	{
		return W2P_INCLUDE . 
				W2P::getInstance()->configuration()->core_path .
				DIRECTORY_SEPARATOR .
				'W2P' .
				DIRECTORY_SEPARATOR .
				'Admin' .
				DIRECTORY_SEPARATOR .
				'Html' .
				DIRECTORY_SEPARATOR;
	}
}