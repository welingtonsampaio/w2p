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
 * @version 0.1.0
 * 
 * @category	W2P
 * @package		W2P
 * @copyright	Copyright (c) 2012 Zaez Solução em Tecnologia Ltda - Welington Sampaio
 * @license		http://creativecommons.org/licenses/by-nd/3.0/  Creative Commons
 */

/**
 * Classe responsavel por inclusoes de classes automaticamente
 * 
 * @example E.g. "W2P_Core" --> "W2P/Core.php"
 * 
 * @author Welington Sampaio ( @link http://welington.zaez.net )
 * @version 0.3
 * 
 * @category	W2P
 * @package		W2P
 * @since		0.3
 * @copyright	Copyright (c) 2012 Zaez Solução em Tecnologia Ltda - Welington Sampaio
 * @license		http://creativecommons.org/licenses/by-nd/3.0/  Creative Commons
 */
class W2P_Autoloader
{
    /**
     * Constructor
     *
     * @return void
     */
    public function __construct()
    {
        spl_autoload_register(array($this, 'autoload'));
    }

    /**
     * Autoloads a class
     *
     * This method aims to load files and classes as soon as possible, so no additional
     * checks occur - e.g. whether or not the file exists nor whether or not the class
     * exists in the file.
     *
     * @param string $class
     * @return bool
     */
    public function autoload($class)
    {
        // E.g. "W2P_Core" --> "W2P/Core.php"
        $filename = str_replace(array('_', '\\'), DIRECTORY_SEPARATOR, $class) . '.php';
        
        if ( file_exists( W2P_COREPATH . DIRECTORY_SEPARATOR . $filename ) )
        	$isLoaded = include_once W2P_COREPATH . DIRECTORY_SEPARATOR . $filename;
        return (false !== $isLoaded);
    }
    
    /**
     * Include the file on the especify library
     * @param string $class
     * @param string $lib
     * @return bool
     */
    public static function includeLib( $class, $lib = '') {
    	// E.g. "W2P_Core" --> "W2P/Core.php"
    	$filename = str_replace(array('_', '\\'), DIRECTORY_SEPARATOR, $class) . '.php';
		
    	if ( file_exists( W2P_COREPATH . DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR . $lib . $filename ) )
    		$isLoaded = include_once W2P_COREPATH . DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR . $lib . $filename;
    	return (false !== $isLoaded);
    }
}