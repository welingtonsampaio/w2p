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
 * @package		W2P_Form
 * @copyright	Copyright (c) 2012 Zaez Solução em Tecnologia Ltda - Welington Sampaio
 * @license		http://creativecommons.org/licenses/by-nd/3.0/  Creative Commons
 */

namespace W2P\Form;

/* Classe de auxilio para envio de emails padrao do wordpress */
require_once( ABSPATH . WPINC . '/class-smtp.php' );
require_once( ABSPATH . WPINC . '/class-phpmailer.php');

/**
 * @author		Welington Sampaio ( @link http://welington.zaez.net )
 * @version		1.0
 * 
 * @category	W2P
 * @namespace   W2P\Form
 * @since		1.0
 * @copyright	Copyright (c) 2012 Zaez Soluções em Tecnologia Ltda - Welington Sampaio
 * @license		http://creativecommons.org/licenses/by-nd/3.0/  Creative Commons
 */
class Form
{
	const VERSION	= '1.0';
	const ENCTYPE_APPLICATION	= 'application/x-www-form-urlencoded';
	const ENCTYPE_MULTIPART		= 'multipart/form-data';
	const ENCTYPE_TEXT			= 'text/plain';
	const METHOD_POST	= 'post';
	const METHOD_GET	= 'get';
	
	protected $_action = null;
	protected $_elements = array();
	protected $_enctype = self::ENCTYPE_APPLICATION;
	protected $_errors = array();
	protected $_id = null;
	/**
	 * Objeto de envios de emails
	 * @var PHPMailer
	 */
	protected $_mail = null;
	/**
	 * Metodo de envio do formulario
	 * @var string
	 */
	protected $_method = self::METHOD_POST;
	/**
	 * Nome do formulario em questao
	 * @var string
	 */
	protected $_name = null;
	/**
	 * Modelo de template para a impressao do
	 * elemento do form
	 * @var string
	 */
	protected $_templateElement = '<div>{element}</div>';
	/**
	 * Modelo de template para a impressao dos
	 * erros de preenchimento do form
	 * @var string
	 */
	protected $_templateError = '<ul class="error">{elements}</ul>';
	/**
	 * Modelo de template para a impressao dos
	 * erros de preenchimento do form
	 * @var string
	 */
	protected $_templateErrorElements = '<li>{name} {error}</li>';
	/**
	 * Modelo de template para a impressao do form
	 * @var string
	 */
	protected $_templateForm = '<div id="form">{success}{errors}<form id="{id}" name="{name}" action="{action}" method="{method}"  enctype="{enctype}">{tosend}{captcha}{elements}<span id="loading"></span></form></div>';
	/**
	 * Mensagem de confirmacao do envio
	 * @var string
	 */
	protected $_userMEssageConfirm = null;
	/**
	 * Email do cliente que ira receber por Copia Oculta
	 * @var array
	 */
	protected $bco = array();
	/**
	 * Nome para saudacao do cliente
	 * @var string
	 */
	protected $client = null;
	/**
	 * Mensagem de confirmacao do envio do email
	 * @var string
	 */
	protected $confirm_message = null;
	/**
	 * Data de envio
	 * @var string
	 */
	protected $datetime = null;
	/**
	 * Link do desenvolverdor do sistema
	 * @var string
	 */
	protected $developer_link = null;
	/**
	 * Url da logo de desenvolvedor do sistema
	 * @var string
	 */
	protected $developer_logo = null;
	/**
	 * Da onde parte o email
	 * @var string
	 */
	protected $from = null;
	/**
	 * IP do usuario que envio o email
	 * @var string
	 */
	protected $ipaddress = null;
	/**
	 * Conteudo da mensagem
	 * @var string
	 */
	protected $message = null;
	/**
	 * Saudacao de comprimento
	 * @var string
	 */
	protected $salutation = null;
	/**
	 * Assunto do email
	 * @var string
	 */
	protected $subject = null;
	/**
	 * Email do cliente que ira receber
	 * @var array
	 */
	protected $to = array();
	
	/**
	 * Metodo construtor
	 * @param string $form_name, nome unico para o formulario
	 * @return void
	 */
	public function __construct( $form_name )
	{
		$this->_name = (string) $form_name;
		 
		// Configura obj PHPMailer
		$this->_mail = new PHPMailer();
		 
		// Configuracao
		$this->setClient( \W2P::getInstance()->configuration()->email_name );
		$this->setFrom( \W2P::getInstance()->configuration()->email_from );
		
		
		// Dados de desenvolvedor
		$this->developer_link	= \W2P::getInstance()->configuration()->developer_link;
		$this->developer_logo	= \W2P::getInstance()->configuration()->developer_logo;
	
		// Dados do Cliente
		$this->ipaddress  = $_SERVER['REMOTE_ADDR'];
		$this->datetime   = date( __('Y-m-d \a\t H:i:s', 'W2P') );
	}
	/**
	 * Adiciona elemento de entrado no formulario
	 * @param Element $element
	 * @return Form $this
	 */
	public function addElement( Element $element )
	{
		if ( !($element instanceof Element ) )
			throw new Exception( __('The element sent is invalid, must be sent one element \W2P\Form\Element', 'W2P') );
		$this->_elements[] = $element;
		return $this;
	}
	/**
	 * Adiciona uma colecao de elementos de entrada
	 * no formulario, atraves de uma matriz
	 * @param array $elements
	 * @return Form $this
	 */
	public function addElements( array $elements )
	{
		if ( !is_array($elements) )
			throw new Exception( __('The element sent is invalid, must be sent one element Array', 'W2P') );
		foreach ($elements as $element)
		{
			if ( !($element instanceof Element ) )
				throw new Exception( __('The element sent is invalid, must be sent one element \W2P\Form\Element', 'W2P') );
			$this->_elements[] = $element;
		}
		return $this;
	}
	/**
	 * Adiciona email a ser enviado em oculto Bco
	 * @param string $bco
	 * @return Form $this
	 */
	public function addBco( $bco )
	{
		$this->validateEmail($bco);
		$this->bco[] = $bco;
		return $this;
	}
	/**
	 * Adiciona email a ser enviado
	 * @param string $to
	 * @return Form $this
	 */
	public function addTo( $to )
	{
		$this->validateEmail($to);
		$this->to[] = $to;
		return $this;
	}
	
	public function getAction()
	{
		return $this->_action;
	}
	
	public function getClient()
	{
		return ( !empty($this->client) ) ? $this->client : '';
	}
	
	public function getEnctype()
	{
		return $this->_enctype;
	}
	
	public function getErrors()
	{
		if ( $this->_errors )
			return $this->_errors;
		return false;
	}
	
	public function getFrom()
	{
		return $this->from;
	}
	
	public function getId()
	{
		return $this->_id;
	}
	/**
	 * Return the message in really state
	 * @return string
	 */
	public function getMessage()
	{
		return $this->message;
	}
	
	public function getName()
	{
		return $this->_name;
	}
	/**
	 * Retorna o metodo atual do objeto
	 * @return string
	 */
	public function getMethod()
	{
		return $this->_method;
	}
	
	public function getSalutation()
	{
		return ( !empty($this->salutation) ) ? $this->salutation : '';
	}
	
	public function getSubject()
	{
		return ( !empty($this->subject) ) ? $this->subject : '';
	}
	
	public function getTemplateElement()
	{
		return $this->_templateElement;
	}
	
	public function getTemplateError()
	{
		return $this->_templateError;
	}
	
	public function getTemplateErrorElements()
	{
		return $this->_templateErrorElements;
	}
	
	public function getTemplateForm()
	{
		return $this->_templateForm;
	}
	
	public function getValues()
	{
		$return = array();
		foreach ( $this->_elements as $element )
		{
			$element instanceof Element\AbstractClass;
			if ( !$element->isIgnored() )
			{
				$return[$element->getName()] = $element->getValue();
			}
		}
		return $return;
	}
	/**
	 * Percorre os elementos do formulario aplicando
	 * os validadores
	 * @return boolean
	 */
	public function isValid()
	{
		$return = false;
		if ( !( $this->getFormValue('w2p_required_name') ) )
		{
			$return = true;
			foreach ( $this->_elements as $element )
			{
				$element instanceof Element\AbstractClass;
				if ( !$element->isValid() )
				{
					$this->addError( $element->getErrors() );
					$return = false;
				}
			}
		}else{
			$this->addError(array( 'name'=>'', 'error'=> __( 'This system is locked against filling of automatic robots.', 'W2P') ));
		}
		return $return;
	}
	
	public function populate( array $data )
	{
		if ( !is_array($data) ) {
			throw new Exception( __('Invalid type given. Array expected.', 'W2P') );
		}
		foreach ( $data as $key=>$value )
		{
			foreach ( $this->_elements as $element )
			{
				$element instanceof Element\AbstractClass;
				if ( $key == $element->getName() )
				{
					$element->setValue($value);
				}
			}
		}
	}
	/**
	 * Enviar email simples
	 * @param string $to
	 */
	public function sendMail()
	{
		if ( $this->isToSend() )
		{
			if ( $this->isValid() )
			{
				$this->newEmail();
				foreach ( $this->to as $to )
				{
					$this->send( $to );
				}
				$this->printSuccess();
			}else if ( \W2P::getInstance()->helper()->isAjax() ) {
				echo json_encode( array( 'result' => 'error', 'error' => __('Fields filled invalid.', 'W2P') ) );
				exit();
			}
		}
	}
	
	public function setAction( $action )
	{
		$this->_action = (string) $action;
		return $this;
	}
	
	public function setClient( $client )
	{
		$this->client = (string) $client;
		return $this;
	}
	/**
	 * Configura a mensagem de confirmacao de envio que
	 * seja mostrada ao usuario
	 * @param string $message
	 * @return Form $this
	 */
	public function setConfirmMessage( $message )
	{
		$this->confirm_message = $message;
		return $this;
	}
	/**
	 * Configura o enctype do formulario a ser enviado
	 * @param string $message
	 * @return Form $this
	 */
	public function setEnctype( $enctype )
	{
		$this->_enctype = (string) $enctype;
		return $this;
	}
	
	public function setFrom( $from )
	{
		$this->validateEmail( $from );
		$this->from = $from;
		return $this;
	}
	
	public function setId( $id )
	{
		$this->_id = (string) $id;
		return $this;
	}
	
	public function setName( $name )
	{
		$this->_name = (string) $name;
		return $this;
	}
	/**
	 * Configura o metodo do formulario a ser enviado
	 * @param string $message
	 * @return Form $this
	 */
	public function setMethod( $method )
	{
		$this->_method = (string) $method;
		return $this;
	}
	
	public function setSalutation( $hour )
	{
		if($hour >= 12 && $hour<18)
			$this->salutation = __('Good afternoon', 'W2P');
		else if ($hour >= 0 && $hour <12 )
			$this->salutation = __('Good morning', 'W2P');
		else
			$this->salutation = __('Good night', 'W2P');
		return $this;
	}
	/**
	 * Configura o assunto da mensagem
	 * @param string $subject
	 * @return Form $this
	 */
	public function setSubject( $subject )
	{
		$this->subject = $subject;
		return $this;
	}
	
	public function setTemplateElement( $template )
	{
		$this->_templateElement = (string) $template;
		return $this;
	}
	
	public function setTemplateError( $template )
	{
		$this->_templateError = (string) $template;
		return $this;
	}
	
	public function setTemplateErrorElements( $template )
	{
		$this->_templateErrorElements = (string) $template;
		return $this;
	}
	
	public function setTemplateForm( $template )
	{
		$this->_templateForm = (string) $template;
		return $this;
	}
	/**
	 * Imprime mensagem de sucesso no envio, formato json caso
	 * a requisicao seja em ajax ou informa o form a mensagem
	 * de confirmacao de envio
	 */
	public function printSuccess()
	{
		if ( \W2P::getInstance()->helper()->isAjax() )
		{
			echo json_encode( array( 'result' => 'ok', 'message' => $this->confirm_message ) );
			exit();
		}else
			$this->_confirm_message = $this->confirm_message;
	}
	
	/* PRIVATE FUNCTIONS */
	
	private function addError( array $error )
	{
		if ( key_exists('name', $error) && key_exists('error', $error) )
		{
			$this->_errors[] = $error;
			return true;
		}
		if ( is_array($error) )
		{
			foreach ($error as $e)
			{
				$r = $this->addError($e);
			}
			return $r;
		}
		return false;
	}
	/**
	 * Adiciona os campos do formulario no corpo da mensagem
	 * @param string $var
	 * @param string $label
	 * @return string
	 */
	private function conteudo($var,$label)
	{
		$value = $this->getFormValue($var);
		if ( $value && !empty( $value ) )
			return "<tr><td width=\"160\" class=\"label\">{$label}</td><td width=\"496\">{$value}</td></tr>";
		else
			return '';
	}
	/**
	 * Verifica se o conteudo do campo esta enviado ou
	 * conforme o metodo setado no form
	 * @param string $name
	 * @return mixed
	 */
	private function getFormValue( $name )
	{
		if( self::METHOD_POST == $this->_method )
		{
			if ( !isset( $_POST[$name] ) || empty( $_POST[$name] ) )
				return false;
			return $_POST[$name];
		}else{
			if ( !isset( $_GET[$name] ) || empty( $_GET[$name] ) )
				return false;
			return $_GET[$name];
		}
	}
	/**
	 * Varifica se o formulario esta correto para envio
	 * @return boolean
	 */
	private function isToSend()
	{
		if ( $this->_name == $this->getFormValue('W2P_'.$this->_name) )
			return true;
		return false;
	}
	/**
	 * Configuracao de email simples
	 * deve estar configurado previamente
	 * os fields
	 * @see add_field
	 */
	private function newEmail()
	{
		// Inicio da mensagem
		$this->setMessageInit();

	 	// Adiciona os campos no form
	 	foreach ( $this->_elements as $item )
	 	{
	 		if ( 'file' != $item->getType() && !$item->isIgnored() )
	 			$this->message .= $this->conteudo($item->getName(), $item->getLabel());
	 	}

	 	// Final da mensagem
	 	$this->setMessageFinal();
	}
	/**
	 * Imprime mensagem de erro no formato json caso
 	 * a requisicao seja em ajax ou informa o form a mensagem
 	 * de erro no envio
 	 * @param string $msg
 	 */
 	private function printError( $msg )
 	{
	 	if ( \W2P::getInstance()->helper()->isAjax() )
	 	{
		 	echo json_encode( array( 'result' => 'error', 'error' => $msg ) );
		 	exit();
	 	}else
	 		$this->addError(array('name'=>'','error'=> $msg));
	}
	/**
	 * Envia mensagem com/sem attachments
	 * @param string $to, email a ser enviado
	 * @since 1.0
	 */
	private function send( $to )
	{
		try {
			$this->_mail->SetFrom ( $this->from, utf8_decode( __('Contact from site', 'W2P') ) );
			$this->_mail->Subject = utf8_decode ( $this->getSubject() );
			$this->_mail->MsgHTML ( utf8_decode ( $this->getMessage() ) );
			$this->_mail->AddAddress ( $to , $this->client );
			
// 			if ( $this->bco )
// 			{
// 				foreach ( $this->bco as $bco )
// 					$this->_mail->AddBCC($bco);
// 				$this->bco = array();
// 			}
			// Configuracoes do Attachment
			foreach ( $this->_elements as $item )
			{
				if ( 'file' == $item->getType() )
					$this->_mail->AddAttachment ( $_FILES[ $item->getName() ]['tmp_name'], $_FILES[ $item->getName() ]['name'] );
			}

			$this->_mail->send();
		} catch (phpmailerException $e) {
			$this->printError($e->errorMessage());
		} catch (Exception $e){
			$this->printError($e->getMessage());
		}
	}
	/**
	 * Adiciona o rodape ao conteudo da mensagem
	 * com suas devidas configuracoes
	 */
	private function setMessageFinal()
	{
		$this->message .= "
		<tr><td colspan=\"2\" class=\"rodape\">
		<a href=\"{$this->developer_link}\"><img src=\"{$this->developer_logo}\" border=\"0\" /></a></td></tr></table>
		<br />".sprintf( __("This message was sent from IP: %s in %s", 'W2P') , $this->ipaddress , $this->datetime)."</td>
		</tr></table>";
	}
	/**
	 * Seta o Inicio da mensagem com as devidas configuracoes
	 */
	private function setMessageInit()
	{
		$this->message = "
		<style type=\"text/css\">
		table {font-family:\"Courier New\", Courier, monospace;background: #ecf1f5;font-size: 12px;color: #444;}
		table table {font-family: \"Lucida Grande\", \"Lucida Sans Unicode\", sans-serif;border: none;font-size: 14px;}
		table table td{border-bottom:1px dashed; border-bottom-color:#d6dde4; background-color:#fff;vertical-align:top;font-size:12px;}
		table table td.topo,table table td.rodape {background-color: #aaa;color: white;font-weight:bold;border:none;font-size:15px;}
		table table td.rodape{background-color: #d6dde4;font-size: 12px;text-align:right;}
		table table td.label {background:#D6DDE4;color: #222;border-bottom:none !important;}
		</style>
		<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"15\"><tr><td align=\"center\" valign=\"middle\">
		<table width=\"680\" border=\"0\" cellspacing=\"0\" cellpadding=\"12\">
		<tr>
		<td colspan=\"2\" class=\"topo\">{$this->getSalutation()} {$this->getClient()}!<br />".__('You have received a new message from', 'W2P')." {$this->getName()}.</td>
		</tr>";
	}
	
	private function toArray()
	{
		$data['action']		= $this->getAction();
		$data['enctype']	= $this->getEnctype();
		$data['method']		= $this->getMethod();
		$data['name']		= $this->getName();
		$data['id']			= $this->getId();
		return $data;
	}
	
	private function validateEmail( $email )
	{
		$validator = new \W2P\Validate\EmailAddress();
		$validator->setValue($email);
		if ( !$validator->isValid() )
		{
			$e = (array_values( $validator->getMessages() ));
			throw new Exception( $e[0] );
		}
		return $email;
	}
	
	public function __toString()
	{
		$form = '';
		$elements = '';
		
		foreach ( $this->_elements as $element )
		{
			$element instanceof Element;
			$e['element'] = $element;
			$elements .= @preg_replace('/\{([^}]*)\}/e', '$e[\\1]', $this->getTemplateElement() );
		}
		
		$data = $this->toArray();
		$data['elements'] = $elements;
		
		$errors['elements'] = '';
		if ( $this->getErrors() )
		{
			foreach ( $this->getErrors() as $error )
			{
				$errors['elements'] .= @preg_replace('/\{([^}]*)\}/e', '$error[\\1]', $this->getTemplateErrorElements() );
			} 
		}
		
		$data['errors'] = @preg_replace('/\{([^}]*)\}/e', '$errors[\\1]', $this->getTemplateError() );
		$data['tosend'] = new Element\Hidden('W2P_'.$this->getName(),array('value'=>$this->getName()));
		$data['captcha'] = new Element\Hidden('w2p_required_name');
		
		$form = @preg_replace('/\{([^}]*)\}/e', '$data[\\1]', $this->getTemplateForm() );
		
		return $form;
	}
}