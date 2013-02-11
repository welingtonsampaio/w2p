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
 * Classe responsavel por geracao e configuracoes
 * de tudo relacionado a posts
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
class W2P_Post
{
	/**
	 * Add a new Custom post in your theme
	 *
	 * @param string $name
	 * 				Name of the custom post
	 * @param string $title
	 * 				Name of the Custom post, that will
	 * 				appear in display menu
	 * @param string $titlePluralize
	 * 				Name of the Custom post, that will
	 * 				appear in the local pluralized
	 */
	public function addCustomPost( $name, $title, $titlePluralize )
	{
		return new W2P_Post_Custom( $name, $title, $titlePluralize );
	}
	/**
	 * Add a new Custom Meta post in your theme
	 * 
	 * @param string $name
	 * @param string $post_type
	 * @return W2P_Post_Metas
	 */
	public function addCustomMeta( $name, $post_type )
	{
		return new W2P_Post_Metas($name, $post_type);
	}
}