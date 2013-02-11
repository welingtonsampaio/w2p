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
 * @version		2.0
 * 
 * @category	W2P
 * @package		W2P
 * @copyright	Copyright (c) 2012 Zaez Solução em Tecnologia Ltda - Welington Sampaio
 * @license		http://creativecommons.org/licenses/by-nd/3.0/  Creative Commons
 */

/**
 * Classe responsavel por criar novos objetos de Email/Form
 * 
 * @author		Welington Sampaio ( @link http://welington.zaez.net )
 * @version		2.0
 * 
 * @category	W2P
 * @package		W2P
 * @since		2.0
 * @copyright	Copyright (c) 2012 Zaez Solução em Tecnologia Ltda - Welington Sampaio
 * @license		http://creativecommons.org/licenses/by-nd/3.0/  Creative Commons
 */
class Wordwebpress_Email
{
	/**
	 * Create a new email form
	 * 
	 * @param string $formName
	 * @return Wordwebpress_Email_Email
	 */
	public function create( $formName )
	{
		return new Wordwebpress_Email_Email( $formName );
	}
}