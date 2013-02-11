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
class W2P_Stylesheet 
{
	const INCLUDE_SASS = " *= require ";
	
	/**
	 * Contem os nome e conteudo dos arquivos
	 * a serem renderizados na pagina
	 *
	 * @var array
	 */
	protected $_css = array ('style' => array (), 'error' => array (), 'archy' => array (), 'rack' => array (), 'vendor' => array (), 'less'=>array(), 'rackless'=>array() );
	
	/**
	 * 
	 */
	protected $_sassConfiguration = array(
			'cache' => FALSE,
			'debug' => false
		);
	
	function __construct() {
		$this->_sassConfiguration['style'] = W2P::getInstance()->configuration()->compress_css_js ? 'compressed' : 'nested';
		$this->_sassConfiguration['syntax'] = W2P::getInstance()->configuration()->sass_extension;
	} 
	
	/**
	 * Adiciona o css a colecao para posteriormente no theme
	 * ser rederizado como tal, seguindo a convencao que todos
	 * os stylesheets estarao na pasta %theme%/%assets_path%/css
	 * caso nao exista o stylesheet ele retorna um comentario
	 * de erro ao html
	 *
	 * @param string $name
	 *       	 Nome do arquivo css
	 * @param string $rack
	 *       	 Expressao para rack de css em navegadores
	 * @since 1.3
	 * @deprecated 2.0 Using Sass files
	 * @return W2P_Stylesheet
	 */
	public function appendCssFile($name, $rack = null, $vendor = false) {
		if (file_exists ( W2P_INCLUDE . W2P::getInstance()->configuration()->assets_path . '/css/' . $name . '.css' )) {
			if ($rack) :
				$this->_css ['rack'] [$rack] [$name] = $name;
				W2P::getInstance()->debug()->_debug_add_content ( "File: {$name}.css add on css container (rack)" );
			elseif ( $vendor ) :
				$this->_css ['vendor'] [$name] = $name;
				W2P::getInstance()->debug()->_debug_add_content ( "File: {$name}.css add on css container ( vendor )" );
			else :
				$this->_css ['archy'] [$name] = $name;
				W2P::getInstance()->debug()->_debug_add_content ( "File: {$name}.css add on css container" );
			endif;
			return $this;
		}
		$this->_css ['error'] [$name] = $name;
		W2P::getInstance()->debug()->_debug_add_content ( "File: {$name}.css not existent", true );
		return $this;
	}
	/**
	 * Adiciona o css a ser rederizado pelo theme
	 *
	 * @param string $stylesheet       	
	 * @since 1.0
	 * @deprecated 2.0
	 * @return W2P_Stylesheet
	 */
	public function appendStyle($stylesheet) {
		$this->_css ['style'] [] = $stylesheet;
		return $this;
	}
	
	/**
	 * Imprime os arquivos e configuracoes do css
	 * no tema
	 *
	 * @since 1.0
	 * @deprecated 2.0
	 * @return W2P_Stylesheet
	 */
	public function renderCss() {
		if (sizeof ( $this->_css ['vendor'] )) {
			sort ( $this->_css ['vendor'] );
			foreach ( $this->_css ['vendor'] as $key => $item ) {
				W2P::getInstance()->debug()->_debug_add_content ( "File ( {$item} ).css initalizing successfully ( vendor )" );
				echo "<link type=\"text/css\" rel=\"stylesheet\" href=\"" . W2P_URL . W2P::getInstance()->configuration()->assets_path . '/css/' . $item . '.css" />' . "\n";
			}
		}
		if ( W2P::getInstance()->configuration()->compress_css_js ) {
			W2P::getInstance()->debug()->_debug_add_content ( "Starting the rendering of css" );
			$query = '';
			if (sizeof ( $this->_css ['archy'] )) {
				$i = 0;
				sort ( $this->_css ['archy'] );
				foreach ( $this->_css ['archy'] as $key => $item ) {
					$query .= ($i > 0 ? ',' : '') . $item;
					$i ++;
				}
				if ( $this->generateCssMin( $query ) )
					W2P::getInstance()->debug()->_debug_add_content ( "File ( {$query} ).css generated successfully" );
				else
					W2P::getInstance()->debug()->_debug_add_content ( "File ( {$query} ).css reloaded successfully" );
				echo "<link type=\"text/css\" rel=\"stylesheet\" href=\"" . W2P_URL . W2P::getInstance()->configuration()->assets_path . W2P::getInstance()->configuration()->cache_path . '/_css_' . md5 ( $query ) . '.css" />' . "\n";
			}
			
			if (sizeof ( $this->_css ['rack'] )) {
				foreach ( $this->_css ['rack'] as $key => $item ) {
					$query = '';
					$i = 0;
					foreach ( $item as $kkey => $iitem ) {
						$query .= ($i > 0 ? ',' : '') . $iitem;
						$i ++;
					}
					
					if ($this->generateCssMin ( $query ))
						W2P::getInstance()->debug()->_debug_add_content ( "File ( {$query} ).css generated successfully (rack)" );
					else
						W2P::getInstance()->debug()->_debug_add_content ( "File ( {$query} ).css reloaded successfully (rack)" );
					echo "<!--[{$key}]><link type=\"text/css\" rel=\"stylesheet\" href=\"" . W2P_URL . W2P::getInstance()->configuration()->assets_path . W2P::getInstance()->configuration()->cache_path . '/_css_' . md5 ( $query ) . '.css" /><![endif]-->' . "\n";
				}
			}
		} else {
			W2P::getInstance()->debug()->_debug_add_content ( "Not rendering of css" );
			
			if (sizeof ( $this->_css ['archy'] )) {
				sort ( $this->_css ['archy'] );
				foreach ( $this->_css ['archy'] as $key => $item ) {
					W2P::getInstance()->debug()->_debug_add_content ( "File ( {$item} ).css initalizing successfully" );
					echo "<link type=\"text/css\" rel=\"stylesheet\" href=\"" . W2P_URL . W2P::getInstance()->configuration()->assets_path . '/css/' . $item . '.css" />' . "\n";
				}
			}
			
			if (sizeof ( $this->_css ['rack'] )) {
				foreach ( $this->_css ['rack'] as $key => $item ) {
					foreach ( $item as $kkey => $iitem ) {
						W2P::getInstance()->debug()->_debug_add_content ( "File ( {$iitem} ).css initializing successfully (rack)" );
						echo "<!--[{$key}]><link type=\"text/css\" rel=\"stylesheet\" href=\"" . W2P_URL . W2P::getInstance()->configuration()->assets_path . '/css/' . $iitem . '.css" /><![endif]-->' . "\n";
					}
				}
			}
		}
		if (sizeof ( $this->_css ['style'] )) {
			echo "<style type=\"text/css\">\n";
			foreach ( $this->_css ['style'] as $key => $item )
				echo $item;
			echo "\n</style>";
			W2P::getInstance()->debug()->_debug_add_content ( "Style added successfully on layout" );
		}
		if (sizeof ( $this->_css ['error'] )) {
			foreach ( $this->_css ['error'] as $key => $item )
				echo "\n<!-- scrips_css: " . W2P_URL . W2P::getInstance()->configuration()->assets_path . '/css/' . $item . '.css INEXISTENTE -->';
		}
		return $this;
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
	public function renderSass($file=null, $path=null, $isAdmin=false)
	{
		// Inclui a biblioteca de compilação do sass
		W2P_Autoloader::includeLib('SassParser', 'phpsass/');
		
		// Definições de variaveis
		$archy = array();
		$currentMode = ( 
				W2P::getInstance()->configuration()->compress_css_js ==
				file_get_contents(W2P_INCLUDE . W2P::getInstance()->configuration()->assets_path . '/cache/control/sass_mode')
				? false
				: true
			);
		$ext = W2P::getInstance()->configuration()->sass_extension;
		$file = ($file ? $file : W2P_INCLUDE . W2P::getInstance()->configuration()->assets_path . '/scss/'.
				W2P::getInstance()->configuration()->sass_file_default.'.'.
				$ext);
		$path = ($path ? $path : W2P_INCLUDE . W2P::getInstance()->configuration()->assets_path . '/scss/');
		$rack = array();
		$sass = new SassParser($this->_sassConfiguration);
		
		// Reescreve o modo utilizado atualmente
		file_put_contents(W2P_INCLUDE . W2P::getInstance()->configuration()->assets_path . '/cache/control/sass_mode', W2P::getInstance()->configuration()->compress_css_js );
		
		// Pega o conteudo do arquivo principal de configuração do sass
		$lines = file($path . $file,
				FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
		
		// Percorre as linhas de configurações para adicionar os arquivos sass
		foreach ( $lines as $key=>&$line )
		{
			// verifica se a linha atual é um arquivo de adição
			if ( strpos($line, self::INCLUDE_SASS) !== false )
			{
				// Retira o INCLUDE_SASS da linha atual
				$line = str_replace(self::INCLUDE_SASS, '', $line);
				// Verifica se a linha atual é um Rack para IE, com a existencia do ","
				if ( strpos($line, ',') !== false )
					// Se verdade Adiciona a linha como Rack IE
					list($rack[$key]['file'],$rack[$key]['rack']) = explode(',', $line);
				else 
					// Se falso Adiciona a linha como sass comum
					$archy[$key]['file'] = $line;
			}
		}
		
		// Reorganiza os arquivos no array
		sort($archy);
		// Percorre todos as linhas no array com os arquivo a adicionar
		foreach ($archy as $_file)
			// Adiciona o conteudo do arquivo sass
			$contentFiles .= file_get_contents( $path . $_file['file'].'.'.$ext )."\n";
		
		// Verifica se existe o arquivo finaly.scss e se o mesmo é identico ao atual
		$generate = true;
		if ( file_exists(W2P_INCLUDE . W2P::getInstance()->configuration()->assets_path . '/scss/cache/finaly.'.$ext) )
			if ( $contentFiles == file_get_contents( W2P_INCLUDE . W2P::getInstance()->configuration()->assets_path . '/scss/cache/finaly.'.$ext) )
				$generate = false;
		
		// Verifica se foi criado um novo arquivo finaly.scss ou se foi modificado o modo de compressao
		if ( $generate || $currentMode ) {
			// Sobreescreve o arquivo finaly.scss
			file_put_contents(W2P_INCLUDE . W2P::getInstance()->configuration()->assets_path . '/scss/cache/'.
					($isAdmin?md5($file):'finaly').'.'.$ext, $contentFiles);
			// Compila o arquivo finaly.scss em Css
			$parse = $sass->toCss(W2P_INCLUDE . W2P::getInstance()->configuration()->assets_path . '/scss/cache/'.
					($isAdmin?md5($file):'finaly').'.'.$ext, true);
			// Sobreescreve o arquivo style.css com o novo conteudo
			file_put_contents(W2P_INCLUDE . W2P::getInstance()->configuration()->assets_path . '/css/'.
					($isAdmin?md5($file):'style').'.css', $parse);
		}
		if (!$isAdmin)
			// Imprime o conteudo do css renderisado a partir do arquivo sass
			echo "<link type=\"text/css\" rel=\"stylesheet\" href=\"" . W2P_URL . W2P::getInstance()->configuration()->assets_path . '/css/style.css" />' . "\n";
		else 
			return W2P_URL . W2P::getInstance()->configuration()->assets_path . '/css/'.md5($file).'.css';
		
		foreach ( $rack as $_rack )
		{
			// Adiciona o conteudo do arquivo sass
			$contentFiles = file_get_contents( W2P_INCLUDE . W2P::getInstance()->configuration()->assets_path . '/scss/'.$_rack['file'].'.'.$ext )."\n";
			// Verifica se existe o arquivo rack e se o mesmo é identico ao atual
			$generate = true;
			if ( file_exists(W2P_INCLUDE . W2P::getInstance()->configuration()->assets_path . '/scss/cache/rack_'.md5($_rack['rack']).'.'.$ext) )
				if ( $contentFiles == file_get_contents( W2P_INCLUDE . W2P::getInstance()->configuration()->assets_path . '/scss/cache/rack_'.md5($_rack['rack']).'.'.$ext) )
					$generate = false;
			// Verifica se foi criado um novo arquivo rack.scss ou se foi modificado o modo de compressao
			if ( $generate || $currentMode ) {
				// Sobreescreve o arquivo rack.scss
				file_put_contents(W2P_INCLUDE . W2P::getInstance()->configuration()->assets_path . '/scss/cache/rack_'.md5($_rack['rack']).'.'.$ext, $contentFiles);
				// Compila o arquivo rack.scss em Css
				$parse = $sass->toCss(W2P_INCLUDE . W2P::getInstance()->configuration()->assets_path . '/scss/cache/rack_'.md5($_rack['rack']).'.'.$ext, true);
				// Sobreescreve o arquivo rack.css com o novo conteudo
				file_put_contents(W2P_INCLUDE . W2P::getInstance()->configuration()->assets_path . '/css/rack_'.md5($_rack['rack']).'.css', $parse);
			}
			// Imprime o conteudo do css renderisado a partir do arquivo sass
			echo "<!--[{$_rack['rack']}]><link type=\"text/css\" rel=\"stylesheet\" href=\"" . W2P_URL . W2P::getInstance()->configuration()->assets_path . '/css/rack_' . md5($_rack['rack']) . '.css" /><![endif]-->' . "\n";
		}
		return $this;
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
		$content = '';
		$root = W2P_INCLUDE . W2P::getInstance()->configuration()->assets_path . '/css/';
		$files = explode ( ',', $query );
		if (sizeof ( $files ))
			foreach ( $files as $file )
				$content .= file_get_contents ( $root . $file . '.css' );
		$content = str_replace ( ': ', ':', str_replace ( ';}', '}', str_replace ( '; ', ';', str_replace ( ' }', '}', str_replace ( ' {', '{', str_replace ( '{ ', '{', str_replace ( array ("\r\n", "\r", "\n", "\t" ), "", preg_replace ( '!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $content ) ) ) ) ) ) ) );
		;
		if (! file_exists ( W2P_INCLUDE . W2P::getInstance()->configuration()->assets_path . W2P::getInstance()->configuration()->cache_path . '/_css_' . md5 ( $query ) . '.css' )) :
			file_put_contents ( W2P_INCLUDE . W2P::getInstance()->configuration()->assets_path . W2P::getInstance()->configuration()->cache_path . '/_css_' . md5 ( $query ) . '.css', $content );
		 elseif ($content != file_get_contents ( W2P_INCLUDE . W2P::getInstance()->configuration()->assets_path . W2P::getInstance()->configuration()->cache_path . '/_css_' . md5 ( $query ) . '.css' )) :
			file_put_contents ( W2P_INCLUDE . W2P::getInstance()->configuration()->assets_path . W2P::getInstance()->configuration()->cache_path . '/_css_' . md5 ( $query ) . '.css', $content );
		 else :
			return false;
		endif;
		return true;
	}
}
