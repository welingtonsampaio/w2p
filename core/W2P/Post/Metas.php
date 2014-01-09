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
 * @subpackage	Post
 * @copyright	Copyright (c) 2012 Zaez Solução em Tecnologia Ltda - Welington Sampaio
 * @license		http://creativecommons.org/licenses/by-nd/3.0/  Creative Commons
 */

namespace W2P\Post;
use W2P\Form\Element;
use W2P\W2P;

/**
 * Classe responsavel por gerar modelos de metas
 * para os diversos tipos de posts e paginas, elas
 * contem informacoes adicionais as contidas nos 
 * sistemas convencionais, como: campos personalizados,
 * sistemas de envio de mensagens e mais... para melhor
 * conpreensao veja a documentacao oficial do wordpress
 * { @link http://codex.wordpress.org }
 * 
 * @author Welington Sampaio ( @link http://welington.zaez.net )
 * @version 1.0
 * 
 * @category	W2P
 * @package		W2P
 * @subpackage	Post
 * @since		1.0
 * @copyright	Copyright (c) 2012 Zaez Solução em Tecnologia Ltda - Welington Sampaio
 * @license		http://creativecommons.org/licenses/by-nd/3.0/  Creative Commons
 */
class Metas
{
    /**
     * Guarda os dados da meta requerida e
     * solicitada ao banco, esta cache
     * funciona apenas no tempo de execução
     * deste processo
     *
     * @var array
     */
    public static $_cached = array();
    /**
     * Matriz contendo todos os itens
     * para criacao dos campos personalizados
     *
     * @var array
     */
    protected $_itens = array();
    /**
     * Define se a meta deve ser gravada
     * em um unico campo do banco de
     * dados
     *
     * @var boolean
     */
    protected $compact = null;
	/**
	 * Nome do custom meta, este deve
	 * ser unico
	 * 
	 * @var string
	 */
	protected $name = null;
	/**
	 * Tipo do post que contera esta
	 * custom meta
	 * 
	 * @var string
	 */
	protected $type = null;
	
	/**
	 * Metodo construtor, configura o nome
	 * e o post_type do objeto
	 * 
	 * @param $name string
	 * @param $post_type string
     * @param $compact boolean
     *  Informe se a meta deve ser gravado em um unico campo do banco de dados.
     *  Padrao true
	 */
	public function __construct( $name , $post_type, $compact=true )
	{
		$this->name    = $name;
        $this->type    = $post_type;
        $this->compact = (boolean) $compact;
	}
	/**
	 * Create a new field in your post meta
	 *
     * @version 2.0
     *
	 * @param $item Element
	 * @throws Exception
	 * 		Caso o item enviado nao seja um Element
	 * @return Metas
	 */
	public function addItem( $item )
	{
		if ( $item instanceof Element )
		{
			$this->_itens[$item->getName()] = $item;
			return $this;
		}
		throw new Exception( sprintf( __('Invalid element for %s.', 'W2P'), $item ) );
	}
	/**
	 * Responsible for include the generate the post meta
	 */
	public function generate()
	{
		add_action ( "admin_init", array( &$this , "w2p_generate" ) );
		add_action ( 'save_post', array( &$this , "w2p_save_meta" ) );
	}
	/**
	 * Generated the form html
	 * @return boolean
	 */
	public function generateHtml()
	{
        // Styles
        wp_enqueue_style('thickbox');
        echo '<link rel="stylesheet" type="text/css" href="' .W2P_URL . W2P::getInstance()->configuration()->assets_path . '/css/bootstrap.w2p.min.css'. '" />';
        $style = W2P::getInstance()->stylesheet()->renderSass( W2P_COREPATH.'/assets/scss/w2p.scss', true);
        $md5 = md5($style);
        if (!file_exists(W2P_COREPATH.'/assets/scss/cache/'.$md5.'.css'))
            file_put_contents(W2P_COREPATH.'/assets/scss/cache/'.$md5.'.css', $style);
        wp_register_style('w2p', W2P_URL . W2P::getInstance()->configuration()->core_path . '/assets/scss/cache/'.$md5.'.css');
        wp_enqueue_style('w2p');

        // Scripts
        wp_enqueue_script('media-upload');
        wp_enqueue_script('thickbox');
        wp_register_script('mimetypes', W2P_ASSETSPATH . 'javascripts/mimetype.js');
        wp_register_script('w2p', W2P_ASSETSPATH . 'javascripts/script.js', array('jquery','media-upload','thickbox'));
        wp_enqueue_script('w2p');
        wp_enqueue_script('mimetypes');
        wp_register_script('bootstrap', W2P_URL . W2P::getInstance()->configuration()->assets_path . '/javascripts/bootstrap.min.js', array('jquery'));
        wp_enqueue_script('bootstrap');
		
		
		return include $this->getPath() . '_form.php';
	}
	/**
	 * Recupa no banco os dados da meta do post
	 * indicado
	 * 
	 * @param $post_id integer
	 * @param $meta_name string|array
     *
	 * @return array|mixin
	 */
	public static function get_meta_by_post( $post_id, $meta_name )
	{
        if ( !is_array($meta_name) )
        {
            if ( !empty(self::$_cached[$post_id][$meta_name]) ) return self::$_cached[$post_id][$meta_name];
            $meta_content = get_post_meta($post_id, $meta_name)[0];
            self::$_cached[$post_id][$meta_name] = $meta_content;
        }else{
            if ( !empty(self::$_cached[$post_id][$meta_name[0]][$meta_name[1]]) )
                return self::$_cached[$post_id][$meta_name[0]][$meta_name[1]];
            $meta_content = get_post_meta($post_id, $meta_name[0]);
            $meta_content = unserialize( base64_decode( $meta_content[0] ) );
            self::$_cached[$post_id][$meta_name[0]] = $meta_content;
            $meta_content = $meta_content[$meta_name[1]];
        }
        return $meta_content;
	}

    public function meta_name_for($item) {
        if ( $this->compact )
            return array( $this->name, $item->getName() );
        else
            return $this->name . ' - ' . $item->getName();
    }
	/**
	 * Generate the post meta
	 */
	public function w2p_generate()
	{
		add_meta_box("{$this->name}_meta", $this->name, array( &$this, 'generateHtml' ), $this->type, "normal", "high");
	}
	/**
	 * Action responsavel por salvar os dados no banco
	 * @param integer $post_id
     * @return Integer se salvamento automatico
	 */
	public function w2p_save_meta( $post_id )
	{
		global $post;
		
		if (defined ( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE)
			return $post_id;
		
		if ( isset($_POST['custom-post']) )
		{
			if ( $_POST['custom-post'] == md5($this->name) )
			{
				$dados = array();
                if ( $this->compact )
                {
                    foreach ( $this->_itens as $item )
                    {
                        /** @var $item Element */
                        $item->setValue( ( isset($_POST[ $item->getName() ])	? $_POST[ $item->getName() ]	: '' ) );
                        $dados[ $item->getName() ] = $item->getValue();
                    }
                    update_post_meta ( $post->ID, $this->name , base64_encode( serialize($dados) ) );
                }else{
                    foreach ( $this->_itens as $item )
                    {
                        /** @var $item Element */
                        $item->setValue( ( isset($_POST[ $item->getName() ])	? $_POST[ $item->getName() ]	: '' ) );
                        update_post_meta ( $post->ID, $this->name . " - " . $item->getName() , $item->getValue() );
                    }
                }



			}
		}
	}
	/**
	 * Return the path children files
	 */
	private function getPath()
	{
		return W2P_INCLUDE .
				W2P::getInstance()->configuration()->core_path .
				DIRECTORY_SEPARATOR .
				'W2P' .
				DIRECTORY_SEPARATOR .
				'Post' .
				DIRECTORY_SEPARATOR .
				'Metas' .
				DIRECTORY_SEPARATOR;
	}
}