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
use W2P\Post\Custom;
use W2P\Post\Metas;

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
class Post
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
     * @return Custom
	 */
	public function addCustomPost( $name, $title, $titlePluralize )
	{
		return new Custom( $name, $title, $titlePluralize );
	}
	/**
	 * Add a new Custom Meta post in your theme
	 * 
	 * @param string $name
     * @param string $post_type
     * @param boolean $compact
	 * @return Metas
	 */
	public function addCustomMeta( $name, $post_type, $compact=true )
	{
		return new Metas($name, $post_type, $compact);
	}
}