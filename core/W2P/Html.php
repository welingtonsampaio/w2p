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
 * Classe responsavel por geracao de html e objetos
 * de visualizacao por usuarios finais
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
class W2P_Html
{
	
	/**
	 * Retorna a url da imagem solicitada, atraves
	 * da convencao que as imagens fiquem em
	 * %theme%/%assets_path%/images , caso nao exista
	 * retorna mensagem de erro
	 *
	 * @param $image String
	 * @since 1.0
	 * @return string
	 */
	public function get_image_url($image) {
		if (file_exists ( W2P_INCLUDE . W2P::getInstance()->configuration()->assets_path . "/images/{$image}" )) {
			W2P::getInstance()->debug()->_debug_add_content ( "Image: {$image} added successfully" );
			return W2P_URL . W2P::getInstance()->configuration()->assets_path . "/images/{$image}";
		}
		W2P::getInstance()->debug()->_debug_add_content ( "Error : Image {$image} not existent" );
		return sprintf( __('Image not existent: %s','W2P'), W2P_URL . W2P::getInstance()->configuration()->assets_path . "/images/{$image}" );
	}
	/**
	 * Retorna script para adicionar swf ao site
	 *
	 * @param $div String
	 *       	 , id do DIV para sera mantido swf
	 * @param $movie String
	 *       	 , url do swf a ser adicionado
	 * @param $width Number
	 *       	 , largura do movie
	 * @param $height Number
	 *       	 , altura do movie
	 * @param $vars String
	 *       	 , querystring de variaveis a
	 *       	 passar para o objeto de movie swf send adicionado
	 * @param $install String
	 *       	 , nome do instalador do flash
	 * @since 1.2
	 * @return string
	 */
	public function get_swf($div, $movie, $width, $height, $vars, $install = 'expressInstall.swf') {
		W2P::getInstance()->javascript()->append_swfobject();
		return '<script type="text/javascript" language="javascript">
		var versao = "10";
		var flashvars = {' . $vars . '};
		var parametros = {wmode:"transparent",allowFullScreen:true,allowScriptAccess:"always",quality:"high"};
		var attributes = {id: "flash' . uniqid () . '",name: "flash' . uniqid () . '"};
		swfobject.embedSWF("' . W2P_URL . W2P::getInstance()->configuration()->assets_path  . '/swf/' .$movie . '","' . $div . '",' . $width . ',' . $height . ',versao,"' . $install . '", flashvars, parametros, attributes);
		</script>
		';
	}
}