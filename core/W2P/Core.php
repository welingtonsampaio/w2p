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
 * Classe responsavel por definicoes de view e layout
 * alem de imprimir o conteudo renderizado
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
class Core
{
	/**
	 * Conteudo gerado para aview
	 *
	 * @var String | PHP
	 */
	protected $content = null;
	/**
	 * Contem o nome do layout e ser renderizado
	 *
	 * @var String
	 */
	protected $layout = null;
	/**
	 * Contem a view a ser renderizada pelo sistema
	 *
	 * @var String
	 */
	protected $view = null;
	
	
	/**
	 * Renderiza a pagina final
	 *
	 * @since 1.1
	 */
	public function render() {
        $instance = W2P::getInstance();
		$instance->debug()->_debug_add_content ( "Executing all modules methods." );
        $instance->modules()->exec_all_functions();

        $instance->debug()->_debug_add_content ( "Generating rendering of the view: {$this->view}" );
		
		ob_start ();
		include_once (W2P_INCLUDE . $instance->configuration()->layout_path . '/views/' . $this->view . '.phtml');
		$this->content = ob_get_clean ();
		
		$instance->debug()->_debug_add_content ( "Content of the rendered view" );
		$instance->debug()->_debug_add_content ( "Adding to the project layout" );
		
		include (W2P_INCLUDE . $instance->configuration()->layout_path . '/' . $this->layout . '.phtml');
		
		$instance->debug()->_debug_add_content ( "Layout successfully mastered" );
		
		if ($instance->configuration()->debug)
			$instance->debug()->save_debug ( $instance->configuration()->debug_format );
	}

    /**
     * @throws Exception
     */
    public function renderByRoutes() {
        global $post;
        if ( empty($this->layout) ) $this->setLayout('default');
        if ( is_page() ) {
            if ( !empty($post->page_template) && $post->page_template== 'default' ) {
                $this->setView( W2P::getInstance()->route()->getRoute('page') );
                return $this->render();
            }
            else if ( W2P::getInstance()->route()->hasRoute('page') ) {
                $this->setView( W2P::getInstance()->route()->getRoute('page') );
                return $this->render();
            }else if ( !empty($post->page_template) ) {
            $this->setView( str_replace('.phtml', '',$post->page_template) );
            return $this->render();
            }
        }else if ( is_home() ) {
            $this->setView( 'home' );
            return $this->render();
        }elseif ( is_single() ) {
            $this->setView( 'single' );
            return $this->render();
        }elseif ( is_category() ) {
            $this->setView( 'category' );
            return $this->render();
        }else{
            $this->setView( '404' );
            return $this->render();
        }
        throw new Exception( __( 'Route not found.', 'w2p' ) );
    }
	/**
	 * Configura o layout da pagina
	 *
	 * @param $layout String
	 *       	 Contem o nome do arquivo de layout para
	 *       	 rederizacao da pagina
	 * @since 1.0
	 * @return W2P_Core
	 */
	public function setLayout($layout) {
		$this->layout = $layout;
		return $this;
	}
	/**
	 * Configura a view de dados e configuracoes
	 * para a renderizacao do layout
	 *
	 * @param $view String
	 *       	 Nome do arquivo view para o rederizamento
	 * @since 1.0
	 * @return W2P_Core
	 */
	public function setView($view) {
		$this->view = $view;
		return $this;
	}
}