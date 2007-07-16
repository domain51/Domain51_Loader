<?php
/**
 * This file provides {@link Domain51_Loader}
 *
 * @package Domain51_Loader
 * @author Travis Swicegood <development@domain51.com>
 * @version Release: @@VERSION@@
 * @copyright 2007, Domain51
 * @license http://www.gnu.org/licenses/lgpl.html LGPL
 */

/**
 * Provides a simple mechanism for load classes that use the PEAR naming convention.
 *
 * This hooks into the spl_autoload functionality of PHP to add itself to the stack of
 * autoloaders that have already been defined.  By using Domain51_Loader::autoload(), errors are
 * surpressed allowing this loader to exist in a chain of loaders.
 *
 * @package Domain51_Loader
 * @author Travis Swicegood <development@domain51.com>
 * @version Release: @@VERSION@@
 * @copyright 2007, Domain51
 * @license http://www.gnu.org/licenses/lgpl.html LGPL
 * @since v0.1
 */
class Domain51_Loader
{
    private static $_instance = null;
    
    /**
     * Handle instantiation
     */
    public function __construct()
    {
        $include_path = explode(PATH_SEPARATOR, get_include_path());
        $path = realpath(dirname(dirname(__FILE__)));
        if (!in_array($path, $include_path)) {
            set_include_path(
                $path . PATH_SEPARATOR .
                get_include_path()
            );
        }
    }
    
    /**
     * Loads a class from within the include_path provided the class follows PEAR naming
     * conventions.
     *
     * @internal include_once is used to keep from halting the system while still insuring that no
     *           subsequent calls to an already included file are made.
     *
     * @param string $class_name Class to load
     */
    public function loadClass($class_name)
    {
        $file = str_replace('_', DIRECTORY_SEPARATOR, $class_name) . '.php';
        include_once $file;
    }
    
    
    /**
     * Returns a Singleton copy of this object
     *
     * @return Domain51_Loader
     */
    public static function getInstance()
    {
        if (!isset(self::$_instance)) {
            self::$_instance = new self();
        }
        
        return self::$_instance;
    }
    
    /**
     * Provides a static method into this class to handle autoloading of classes
     *
     * @internal This supresses error reporting of {@link loadClass()} to allow autoload() to
     *           continue along the change of registered autoload functions.
     * 
     * @param string $class_name Name of class to load
     */
    public static function autoload($class_name)
    {
        @self::getInstance()->loadClass($class_name);
    }
}

/**
 * Register with autoload stack
 * @ignore
 */
spl_autoload_register(array(
    'Domain51_Loader',
    'autoload'
));