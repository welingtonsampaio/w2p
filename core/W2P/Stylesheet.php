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
 * Classe responsavel por  tratar e adicionar arquivos
 * de stylesheet/less no theme
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
class Stylesheet
{
	const INCLUDE_SASS   = "//= require ";
    const INCLUDE_LESS   = "//= require ";

    protected $_configuration = array();

	function __construct() {
        $this->_configuration['sass_file'] = W2P::getInstance()->configuration()->sass_file_default;
        $this->_configuration['less_file'] = W2P::getInstance()->configuration()->less_file_default;
	}

	/**
	 * Imprime os arquivos e configuracoes do css
	 * no tema
	 *
	 * @since 1.0
	 * @return W2P_Stylesheet
	 */
	public function render() {
        $this->renderSass();
        $this->renderLess();
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

    private function generateLink($href, $media='all') {
        return '<link href="'.$href.'" />' . "\n";
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
    public function renderSass($file='', $content_only=false)
    {
        // Inclui a biblioteca de compilação do sass
        Autoloader::includeLib('scss.inc', 'scssphp/');
        Autoloader::includeLib('cssmin', 'minify/');

        $scss = new \scssc();
        if (W2P::getInstance()->configuration()->env == 'production')
            $scss->setFormatter("scss_formatter_compressed");

        $scss_dir = W2P_INCLUDE . W2P::getInstance()->configuration()->assets_path . DIRECTORY_SEPARATOR . 'scss' . DIRECTORY_SEPARATOR;

        if (empty($file)) {
            $file = $scss_dir . $this->_configuration['sass_file'] . '.scss';
        }

        if ( ! file_exists($file) ) throw new Exception(__('Arquivo padrao do W2P para SCSS não foi encontrado', 'W2P'));

        $scss->setImportPaths(dirname($file));

        $file_read = file_get_contents($file);

        if ( $content_only ) {
            return $scss->compile( $file_read );
        }

        $files = $this->catchFile($file_read, self::INCLUDE_SASS);
        $production_content = '';

        foreach( $files as $f )
        {
            $scss->setImportPaths([dirname($scss_dir . $f . '.scss')]);
            $filename_under = str_replace(['/'],'_',$f);
            $cache_file = ($scss_dir. 'cache' . DIRECTORY_SEPARATOR . $filename_under . '.css');

            $render = true;
            if ( file_exists($cache_file) )
            {
                $render = filemtime($scss_dir . $f . '.scss') > filemtime($cache_file);
            }

            if ( $render ) {
                touch($cache_file);
                $compiled_content = $scss->compile(file_get_contents($scss_dir . $f . '.scss' ));
                file_put_contents( $cache_file, $compiled_content );
            }

            if( W2P::getInstance()->configuration()->env == 'development' ) {
                echo $this->generateLink(W2P_URL . W2P::getInstance()->configuration()->assets_path . '/scss/cache/'.$filename_under.'.css');
            }else{
                $production_content .= file_get_contents($cache_file);
            }
        }
        if( W2P::getInstance()->configuration()->env == 'production' ) {
            $md5 = md5($production_content);
            if (!file_exists($scss_dir. 'cache' . DIRECTORY_SEPARATOR . $md5 . '.css'))
            {
                $result = \CssMin::minify($production_content, array
                (
                    "ImportImports"                 => false,
                    "RemoveComments"                => true,
                    "RemoveEmptyRulesets"           => true,
                    "RemoveEmptyAtBlocks"           => true,
                    "ConvertLevel3AtKeyframes"      => false,
                    "ConvertLevel3Properties"       => false,
                    "Variables"                     => true,
                    "RemoveLastDelarationSemiColon" => true
                ));
                file_put_contents( $scss_dir. 'cache' . DIRECTORY_SEPARATOR . $md5 . '.css', $result );
            }
            echo $this->generateLink(W2P_URL . W2P::getInstance()->configuration()->assets_path . '/scss/cache/'.$md5.'.css');
        }
    }

    /**
     * Renderisa o CSS a partir de um arquivo de
     * configuração SASS ou SCSS, encontrado na
     * pasta %assets%/scss, seguir modelo da
     * documentação
     *
     * @since 1.0
     * @return W2P_Stylesheet
     */
    private function renderLess($file='', $content_only=false)
    {
        // Inclui a biblioteca de compilação do sass
        Autoloader::includeLib('lessc.inc', 'lessphp/');
        Autoloader::includeLib('cssmin', 'minify/');

        $less = new \lessc();
        if (W2P::getInstance()->configuration()->env == 'production')
            $less->setFormatter("compressed");

        $less_dir = W2P_INCLUDE . W2P::getInstance()->configuration()->assets_path . DIRECTORY_SEPARATOR . 'less' . DIRECTORY_SEPARATOR;

        if (empty($file)) {
            $file = $less_dir . $this->_configuration['less_file'] . '.less';
        }

        if ( ! file_exists($file) ) throw new Exception(__('Arquivo padrao do W2P para LESS não foi encontrado', 'W2P'));

        $less->setImportDir(dirname($file));

        $file_read = file_get_contents($file);

        if ( $content_only ) {
            return $less->compile( $file_read );
        }

        $files = $this->catchFile($file_read, self::INCLUDE_LESS);

        $production_content = '';

        foreach( $files as $f )
        {
            $less->setImportDir([dirname($less_dir . $f . '.less')]);
            $filename_under = str_replace(['/'],'_',$f);
            $cache_file = ($less_dir. 'cache' . DIRECTORY_SEPARATOR . $filename_under . '.css');

            $render = true;
            if ( file_exists($cache_file) )
            {
                $render = filemtime($less_dir . $f . '.less') > filemtime($cache_file);
            }

            if ( $render ) {
                touch($cache_file);
                $compiled_content = $less->compile(file_get_contents($less_dir . $f . '.less' ));
                file_put_contents( $cache_file, $compiled_content );
            }

            if( W2P::getInstance()->configuration()->env == 'development' ) {
                echo $this->generateLink(W2P_URL . W2P::getInstance()->configuration()->assets_path . '/less/cache/'.$filename_under.'.css');
            }else{
                $production_content .= file_get_contents($cache_file);
            }
        }
        if( W2P::getInstance()->configuration()->env == 'production' ) {
            $md5 = md5($production_content);
            if (!file_exists($less_dir. 'cache' . DIRECTORY_SEPARATOR . $md5 . '.css'))
            {
                $result = \CssMin::minify($production_content, array
                (
                    "ImportImports"                 => false,
                    "RemoveComments"                => true,
                    "RemoveEmptyRulesets"           => true,
                    "RemoveEmptyAtBlocks"           => true,
                    "ConvertLevel3AtKeyframes"      => false,
                    "ConvertLevel3Properties"       => false,
                    "Variables"                     => true,
                    "RemoveLastDelarationSemiColon" => true
                ));
                file_put_contents( $less_dir. 'cache' . DIRECTORY_SEPARATOR . $md5 . '.css', $result );
            }
            echo $this->generateLink(W2P_URL . W2P::getInstance()->configuration()->assets_path . '/less/cache/'.$md5.'.css');
        }
    }

	/**
	 * Gera um cache de css compactado de uma query enviada
	 * conforme as configuracoes das pastas
	 *
	 * @param string $query
	 *       	 Nomes dos arquivos css separados por ,
	 * @since 1.1
	 * @return boolean
	 */
	private function generateCssMin($query) {

	}

}
