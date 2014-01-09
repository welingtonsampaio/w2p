<?php

namespace W2P;
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
 * Classe responsavel por  tratar e adicionar arquivos
 * de javascripts no theme
 * 
 * @author Welington Sampaio ( @link http://welington.zaez.net )
 * @version 2.0
 * 
 * @category	W2P
 * @package		W2P
 * @since		2.0
 * @copyright	Copyright (c) 2012 Zaez Solução em Tecnologia Ltda - Welington Sampaio
 * @license		http://creativecommons.org/licenses/by-nd/3.0/  Creative Commons
 */
class Javascript
{

    const INCLUDE_COFFEE = "#= require ";

    protected $_configuration = array();

    function __construct() {
        $this->_configuration['js_file'] = W2P::getInstance()->configuration()->less_file_default;
        $this->_configuration['coffee_file'] = W2P::getInstance()->configuration()->coffee_file_default;
    }

    /**
     * Imprime os arquivos e configuracoes do css
     * no tema
     *
     * @since 1.0
     * @return W2P_Stylesheet
     */
    public function render() {
        $this->renderCoffeescript();
//        $this->renderJS();
    }

    /**
     * @param $content
     * @param $wrapper
     * @return array
     */
    private function catchFile($content, $wrapper) {
        $lines = explode("\n", $content);
        $files = array();
        foreach( $lines as $line) {
            if ( strpos($line, $wrapper) !== false ) {
                $files[] = str_replace([$wrapper, ' '], '', $line);
            }
        }
        return $files;
    }

    private function generateLink($href) {
        return '<script src="'.$href.'" type="text/javascript"></script>' . "\n";
    }

    /**
     * Renderisa o CSS a partir de um arquivo de
     * configuração SCSS, encontrado na
     * pasta %assets%/scss, seguir modelo da
     * documentação
     *
     * @since 1.0
     *
     * @throw Exception
     */
    public function renderCoffeescript($file='', $content_only=false)
    {
        // Inclui a biblioteca de compilação do sass
        Autoloader::includeLib('Init', 'CoffeeScript/');
        Autoloader::includeLib('Minifier', 'JShrink/');

        \CoffeeScript\Init::load();

        // \CoffeeScript\Compiler::compile($coffee);

        $dir = W2P_INCLUDE . W2P::getInstance()->configuration()->assets_path . DIRECTORY_SEPARATOR . 'coffeescript' . DIRECTORY_SEPARATOR;

        if (empty($file)) {
            $file = $dir . $this->_configuration['coffee_file'] . '.coffee';
        }

        if ( ! file_exists($file) ) throw new Exception(__('Arquivo padrao do W2P para CoffeeScript não foi encontrado', 'W2P'));

        $file_read = file_get_contents($file);

        if ( $content_only ) {
            return \CoffeeScript\Compiler::compile( $file_read );
        }

        $files = $this->catchFile($file_read, self::INCLUDE_COFFEE);
        $production_content = '';

        foreach( $files as $f )
        {
            $filename_under = str_replace(['/'],'_',$f);
            $cache_file = ($dir. 'cache' . DIRECTORY_SEPARATOR . $filename_under . '.js');
            $view_file = $dir . $f . '.coffee';

            $render = true;
            if ( file_exists($cache_file) )
            {
                $render = filemtime($view_file) > filemtime($cache_file);
            }

            if ( $render ) {
                touch($cache_file);
                $compiled_content = \CoffeeScript\Compiler::compile(file_get_contents($view_file ));
                file_put_contents( $cache_file, $compiled_content );
            }

            if( W2P::getInstance()->configuration()->env == 'development' ) {
                echo $this->generateLink(W2P_URL . W2P::getInstance()->configuration()->assets_path . '/coffeescript/cache/'.$filename_under.'.js');
            }else{
                $production_content .= file_get_contents($cache_file) . "\n";
            }
        }
        if( W2P::getInstance()->configuration()->env == 'production' ) {
            $md5 = md5($production_content);
            if (!file_exists($dir. 'cache' . DIRECTORY_SEPARATOR . $md5 . '.js'))
            {
                $js_min = \JShrink\Minifier::minify($production_content, array('flaggedComments' => false));
                file_put_contents( $dir. 'cache' . DIRECTORY_SEPARATOR . $md5 . '.js', $js_min );
            }
            echo $this->generateLink(W2P_URL . W2P::getInstance()->configuration()->assets_path . '/coffeescript/cache/'.$md5.'.js');
        }
    }
}
