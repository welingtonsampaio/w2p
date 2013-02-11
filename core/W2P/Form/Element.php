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
 * @version		1.0
 * 
 * @category	W2P
 * @package		W2P_Form
 * @copyright	Copyright (c) 2012 Zaez Solução em Tecnologia Ltda - Welington Sampaio
 * @license		http://creativecommons.org/licenses/by-nd/3.0/  Creative Commons
 */

/**
 * @author		Welington Sampaio ( @link http://welington.zaez.net )
 * @version		1.0
 * 
 * @category	W2P
 * @package		W2P_Form
 * @since		1.0
 * @copyright	Copyright (c) 2012 Zaez Solução em Tecnologia Ltda - Welington Sampaio
 * @license		http://creativecommons.org/licenses/by-nd/3.0/  Creative Commons
 */
class W2P_Form_Element
{
	/**
	 * Atributos gerais do elemento
	 * @var array
	 */
	protected $_attributes = array();
	/**
	 * Se o elemento contem o autofocus
	 * @var boolean
	 */
	protected $_autoFocus = false;
	/**
	 * Erros encontrados para o elemento
	 * @var array
	 */
	protected $_errors = array();
	/**
	 * Filtros de valores do elemento
	 * @var array
	 */
	protected $_filters= array();
	/**
	 * ID de identificacao do elemento
	 * @var string
	 */
	protected $_id;
	/**
	 * Ignorar elemento nas validacoes
	 * @var bool
	 */
	protected $_ignore = false;
	/**
	 * Se existe erro no elemento
	 * @var bool
	 */
	protected $_isError = false;
	/**
	 * Conteudo da label do elemento
	 * @var string
	 */
	protected $_label;
	/**
	 * Conteudo da mascara
	 * @var string
	 */
	protected $_mask;
	/**
	 * Nome do elemento html
	 * @var string
	 */
	protected $_name;
	/**
	 * Ordem de posicionamento no form
	 * @var int
	 */
	protected $_order;
	/**
	 * @var string
	 */
	protected $_placeholder;
	/**
	 * Elemento requirido
	 * @var boolean
	 */
	protected $_required = false;
	/**
	 * Tipo doelemento html
	 * @var string
	 */
	protected $_type = 'text';
	/**
	 * Usar javascript para validações
	 * @var boolean
	 */
	protected $_useJs = false;
	/**
	 * Valor default do campo
	 * @var mixed
	 */
	protected $_value;
	/**
	 * Validações do elemento
	 * @var array
	 */
	protected $_validators = array();
	
	/**
	 * Constructor
	 *
	 * $spec may be:
	 * - string: name of element
	 * 
	 * @param  string $spec
	 * @param  array $options
	 * @return void
	 */
	public function __construct($spec, $options = null)
	{
		$this->setName($spec);
		$this->setId($spec);
		
		if( null !== $options ) {
			$this->setOptions($options);
		}
	}
	/**
     * Filter a name to only allow valid variable characters
     *
     * @param  string $value
     * @param  bool $allowBrackets
     * @return string
     */
    public function filterName($value, $allowBrackets = false)
    {
        $charset = '^a-zA-Z0-9_\x7f-\xff';
        if ($allowBrackets) {
            $charset .= '\[\]';
        }
        return preg_replace('/[' . $charset . ']/', '', (string) $value);
    }
    /**
     * Retorna o conteudo do attributo solicitado
     * @return string|false
     */
    public function getAttribute( $name )
    {
    	if ( !key_exists($name, $this->_attributes) )
    		return false;
    	return $this->_attributes[$name];
    }
    /**
     * Retorna todos os atributos configurados em
     * forma de matriz de dados
     * @return array
     */
    public function getAttributes()
    {
    	return $this->_attributes;
    }
    /**
     * Retorna se o elemento deve esta setado com
     * autofocus ou nao
     * @return boolean
     */
    public function getAutofocus()
    {
    	return $this->_autoFocus;
    }
    /**
     * Retorna um array com erros de validadores
     * encontrados, caso nao exista erro retorna
     * false
     * 
     * @return multitype:array|boolean
     */
    public function getErrors()
    {
    	if ( $this->_isError )
    		return $this->_errors;
    	return $this->_isError;
    }
    /**
     * Return element id
     *
     * @return string
     */
    public function getId()
    {
    	return $this->_id;
    }
    /**
     * Retorna se o campo deve ser ignorado ou nao
     *
     * @return boolean
     */
    public function getIgnore()
    {
    	return $this->_ignore;
    }
    /**
     * Retorna o valor do label
     * @return string
     */
    public function getLabel()
    {
    	return $this->_label;
    }
    /**
     * Retorna o valor do mascara de entrada de dados
     * @return string
     */
    public function getMask()
    {
    	return $this->_mask;
    }
    /**
     * Return element name
     * @return string
     */
    public function getName()
    {
    	return $this->_name;
    }
    /**
     * Retorna o valor do elemento nao aplicando
     * os filtros
     * @return mixed
     */
    public function getNonFilterValue()
    {
    	return $this->_value;
    }
    /**
     * Return the order of element
     * @return int
     */
    public function getOrder()
    {
    	return $this->_order;
    }
    /**
     * Return element Placeholder
     * @return string
     */
    public function getPlaceholder()
    {
    	return $this->_placeholder;
    }
    /**
     * Retorna o type do elemento
     * @return string
     */
    public function getType()
    {
    	return $this->_type;
    }
    /**
     * Retorna o valor do elemento aplicando
     * os filtros
     * @return mixed
     */
    public function getValue()
    {
    	return $this->applyFilters( $this->_value );
    }
    /**
     * Retorna se o elemento deve ser ignorado
     * @return boolean
     */
    public function isIgnored()
    {
    	return $this->_ignore;
    }
	/**
	 * Verifica se o elemento de formulario esta
	 * valido, aplicando todos os validadores 
	 * pre-cadastrados no elemento
	 * @return boolean
	 */
    public function isValid()
    {
    	$this->applyValidators();
    	return !$this->_isError;
    }
    /**
	 * Define se o elemento deve ser requerido pelo
	 * sistema ou nao
	 * @return W2P_Form_Element
	 */
    public function required( $required=true )
    {
    	$this->_required = (boolean) $required;
    	return $this;
    }
    /**
     * Define um atributo ao elemento do formulario
     * @param string $key
     * @param string $value
     * @return W2P_Form_Element
     */
    public function setAttribute($key, $value)
    {
    	$this->_attributes[$key] = $value;
    	return $this;
    }
    /**
     * Define se o elemento contera o atributo de
     * autofocus
     * @param boolean $autofocus
     * @return W2P_Form_Element
     */
    public function setAutofocus($autofocus=true)
    {
    	$this->_autoFocus = (boolean) $autofocus;
    	return $this;
    }
    /**
     * Adiciona filtros ao elemento
     * 
     * @param W2P_Filter_Abstract $filter
     * @return W2P_Form_Element
     */
    public function setFilter( W2P_Filter_Abstract $filter )
    {
    	$this->_filters[] = $filter;
    	return $this;
    }
    /**
     * Set element id
     *
     * @param  string $id
     * @throws W2P_Form_Exception
     * @return W2P_Form_Element
     */
    public function setId($id)
    {
    	$id = $this->filterName($id);
    	if ('' === $id)
    		throw new W2P_Form_Exception( sprintf( __('Invalid %s provided; must contain only valid variable characters and be non-empty', 'W2P' ), 'name') );
    	
    	$this->_id = $id;
    	return $this;
    }
    /**
     * Seta se o campo deve ser ignorado
     *
     * @param  boolean $ignore
     * @return W2P_Form_Element
     */
    public function setIgnore($ignore)
    {
    	$this->_ignore = (boolean) $ignore;
    	return $this;
    }
    /**
     * Seta o label do elemento
     *
     * @param  string $label
     * @return W2P_Form_Element
     */
    public function setLabel($label)
    {
    	$this->_label = (string) $label;
    	return $this;
    }
    /**
     * Seta a mascara de entrada de dados
     * deve estar habilitado a opcao de
     * utilizacao de JS
     * 
     * Eh utilizado o plugin do jQuery para implemetacao da mascara no elemento
     * @link http://digitalbush.com/projects/masked-input-plugin/#license
     *
     * @param  string $mask
     * @return W2P_Form_Element
     */
    public function setMask($mask)
    {
    	$this->_mask = (string) $mask;
    	W2P::getInstance()->javascript()->appendFile( 'vendor/jquery.maskedinput-1.3.min', null, false );
    	$this->useJs();
    	return $this;
    }
    /**
     * Set element name
     *
     * @param  string $name
     * @throws W2P_Form_Exception
     * @return W2P_Form_Element
     */
    public function setName($name)
    {
        $name = $this->filterName($name);
        if ('' === $name) 
            throw new W2P_Form_Exception( sprintf( __('Invalid %s provided; must contain only valid variable characters and be non-empty', 'W2P' ), 'name') );

        $this->_name = $name;
        return $this;
    }
	/**
	 * Set object state from options array
	 *
	 * @param  array $options
	 * @return W2P_Form_Element
	 */
	public function setOptions( array $options )
	{
		foreach ($options as $key => $value) {
			$method = 'set' . ucfirst($key);
		
			if (method_exists($this, $method)) {
				// Setter exists; use it
				$this->$method($value);
			} else {
				// Assume it's metadata
				$this->setAttribute($key, $value);
			}
		}
		return $this;
	}
    /**
     * Configura a order do elemento dentro de
     * formulario a serem improssos
     * 
     * @param  int $order
     * @return W2P_Form_Element
     */
    public function setOrder($order)
    {
    	$this->_order = (int) $order;
    	return $this;
    }
    /**
     * Configura o placeholder do elemento
     * 
     * @param  string $placeholder
     * @return W2P_Form_Element
     */
    public function setPlaceholder($placeholder)
    {
    	$this->_placeholder = (string) $placeholder;
    	return $this;
    }
    /**
     * Configura o tipo do elemento
     * 
     * @param  string $type
     * @return W2P_Form_Element
     */
    public function setType($type)
    {
    	$this->_type = (string) $type;
    	return $this;
    }
	/**
	 * Adiciona validadores ao elemento de formulario
	 * @param array|W2P_Validate_Abstract $validator
	 * @throws W2P_Form_Exception
	 * @return W2P_Form_Element
	 */
	public function setValidator( $validator )
	{
		if ( is_array($validator) ) {
			foreach ($validator as $v) {
				if ( $v instanceof W2P_Validate_Abstract ) {
					$this->_validators[] = $v;
				}
			}
		}else if ( $validator instanceof W2P_Validate_Abstract ) {
			$this->_validators[] = $validator;
		}else{
			throw new W2P_Form_Exception( __('Validator for inserting invalid','W2P') );
		}
		return $this;
	}
	/**
	 * Configura um novo valor para o objeto do elemento
	 * @param mixed $value
	 * @return W2P_Form_Element
	 */
	public function setValue( $value )
	{
		$this->_value = $value;
		return $this;
	}
	/**
	 * Define se este elemento requer os recursos de javascript
	 * para seu correto funcionamento
	 * 
	 * @param	boolean $use
	 * @return 	W2P_Form_Element
	 */
	public function useJs( $use=true )
	{
		$this->_useJs = (boolean) $use;
		return $this;
	}
	
	/**
	 * Adiciona um novo erro a coleção
	 * @param string $message
	 * @return void
	 */
	protected function addError( $message )
	{
		$this->_errors[] = array('name'=>$this->getName(), 'error'=>$message);
	}
	/**
	 * Aplica um filtro especifico para o retorno
	 * @param mixed $value
	 * @param W2P_Filter_Abstract $filter
	 * @return mixed
	 */
	protected function applyFilter( $value, W2P_Filter_Abstract $filter )
	{
		if ( $filter instanceof W2P_Filter_Abstract )
			$value = $filter->filter( $value );
		return $value;
	}
	/**
	 * Aplica todos os filtros pre configurados
	 * @param mixed $value
	 * @return mixed
	 */
	protected function applyFilters( $value )
	{
		if ( $this->_filters && is_array($this->_filters) )
		{
			foreach ( $this->_filters as $filter ) {
				if ( !is_array($value) ) {
					$value = $this->applyFilter( $value, $filter);
				}else{
					foreach ( $value as &$rValue ) {
						$rValue = $this->applyFilter( $rValue, $filter);
					}
				}
			}
		}
		return $value;
	}
	/**
	 * Aplica um validador especifico no retorno
	 * @param mixed $value
	 * @param W2P_Validate_Abstract $validate
	 * @return W2P_Validate_Abstract
	 */
	protected function applyValidator( W2P_Validate_Abstract $validator )
	{
		if ( $validator instanceof W2P_Validate_Abstract ) {
			$validator->setValue($this->getValue());
			$validator->isValid();
			return $validator;
		}
		return false;
	}
	/**
	 * Aplica todos os validadores pre configurados
	 * @return void
	 */
	protected function applyValidators()
	{
		$this->resetErros();
		if ( $this->_validators && is_array($this->_validators) ) {
			foreach ( $this->_validators as $validator ) {
				$v = $this->applyValidator($validator);
				if ( $v && $v->isError() ) {
					foreach ( $v->getMessages() as $erro ) {
						$this->addError( $erro );
					}
					$this->_isError = true;
				}
			}
		}
	}
	/**
	 * Reseta e limpa o estado atual da colecao de erros
	 * @return void
	 */
	protected function resetErros()
	{
		$this->_errors = array();
	}
}