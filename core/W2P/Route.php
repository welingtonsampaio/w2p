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
 * Classe responsável pelo tratamento de rotas do wordpress
 *
 * @author Welington Sampaio ( @link http://welington.zaez.net )
 * @version 1.0
 *
 * @category	W2P
 * @package		W2p
 * @since		1.0
 * @copyright	Copyright (c) 2012 Zaez Solução em Tecnologia Ltda - Welington Sampaio
 * @license		http://creativecommons.org/licenses/by-nd/3.0/  Creative Commons
 */
class Route
{

    protected $_routes = array();
    protected $_templates = array();

    /**
     * Adiciona uma nova rota as configurações
     * do tema do Wordpress
     *
     * @param $name
     *  Nome de identificação dado a rota
     * @param $view_file
     *  Nome do arquivo que será requisitado
     * @param $is_template
     *  Informa se a rota é um template
     * @return Route
     */
    public function add_route($name, $view_file=null, $is_template=false) {
        $down_name = strtolower($name);
        if ( empty($view_file) ){ $view_file = sanitize_title($name); }
        $this->_routes[$down_name] = array( 'name' => $name, 'view' => $view_file);
        if ((boolean) $is_template){ $this->_templates[] = array( 'name' => $name, 'view' => $view_file.".phtml"); }
        return $this;
    }

    public function getRoute($name) {
        return $this->_routes[$name]['view'];
    }

    /**
     * Verifica se existe a rota informada na coleção
     * de rotas do sistema W2P
     *
     * @param $name
     *  Nome da chave da rota a ser pesquisada
     * @return bool
     */
    public function hasRoute($name) {
        return array_key_exists($name, $this->_routes);
    }

    /**
     * Salva no cache do wordpress as
     * configurações de templates
     */
    public function save_cache() {
        $cache_hash = md5(get_template_directory());
        wp_cache_add(  'page_templates-' . $cache_hash, $this->generate_templates(), 'themes', (60*60*24) );
    }

    /**
     * @return array
     */
    protected function generate_templates() {
        $templates = array();
        foreach( $this->_templates as $route ) $templates[$route['view']] = $route['name'];
        return $templates;
    }

}
