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
 * @subpackage	Element
 * @copyright	Copyright (c) 2012 Zaez Solução em Tecnologia Ltda - Welington Sampaio
 * @license		http://creativecommons.org/licenses/by-nd/3.0/  Creative Commons
 */

namespace W2P\Form\Element;
use W2P\Form\Element;

/**
 * Define the element rich text editor wordpress
 *
 * @author		Welington Sampaio ( @link http://welington.zaez.net )
 * @version		1.0
 *
 * @category	W2P
 * @package		W2P_Form
 * @subpackage	Element
 * @since		1.0
 * @copyright	Copyright (c) 2012 Zaez Solução em Tecnologia Ltda - Welington Sampaio
 * @license		http://creativecommons.org/licenses/by-nd/3.0/  Creative Commons
 */
class WpEditor extends AbstractClass
{
    /**
     * Modelo de impressao do elemento
     * @return string
     */
    protected $_template = '<span class="label">{label}</span>{richtext}';

    /**
     * Retorna o valor do elemento aplicando
     * os filtros
     * @return string
     */
    public function getValue($flag=false) {
        if ($flag)
            return (string) htmlspecialchars_decode(htmlspecialchars_decode($this->_value));
        else
            return (string) $this->_value;
    }
    /**
     * Configura um novo valor para o objeto do elemento
     * @param mixed $value
     * @return Element
     */
    public function setValue($value) {
        $this->_value = htmlspecialchars($value);
        return $this;
    }

    /**
     * Defined by W2P_Form_Element_Interface
     * @return array
     */
    public function toArray()
    {
        ob_start();
        wp_editor( $this->getValue(true), $this->getName(), [
            'textarea_rows' => 5
        ] );
        $richtext = ob_get_clean ();
        return array(
            'label' => $this->getLabel()    ? $this->getLabel() : '',
            'richtext' => $richtext
        );
    }

    /**
     * Defined by W2P_Form_Element_Interface
     * @return string
     */
    public function __toString()
    {
        $data = $this->toArray();
        $tpl = $this->getTemplate();
        return @preg_replace('/\{([^}]*)\}/e', '$data[\\1]', $tpl);
    }
}