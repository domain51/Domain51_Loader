<?php
/**
 * This file provides {@link Domain51_Loader}
 *
 * @package Domain51_Loader
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
 * @version Release: @@VERSION@@
 * @copyright 2007, Travis Swicegood, PEAR Group
 * @license http://www.gnu.org/licenses/lgpl.html LGPL
 * @since v0.1
 */
class Domain51_Loader
{
    private static $_instance = null;
    private $_filename = '';
    private $_paths = null;
    private $_temp_paths = null;
    
    /**
     * Handle instantiation
     *
     * This is provided to allow use of the Domain51_Loader class within another object
     * without having to rely concretely on this class.
     *
     * @param string $include_path
     *     If provided, this series of paths will function as the include_path for all subsequent
     *     calls to {@link loadClass()} and {@link loadClassWithoutCheck()}.  If null, the current
     *     get_include_path() is assumed.
     *
     * @see Domain51_Loader::getInstance()
     */
    public function __construct($include_path = null)
    {
        $custom_path = !is_null($include_path);
        $include_path = explode(
            PATH_SEPARATOR,
            $custom_path ? $include_path : get_include_path() 
        );
        
        
        $path = realpath(dirname(dirname(__FILE__)));
        if (!in_array($path, $include_path)) {
            if ($custom_path) {
                $this->_paths = $path . PATH_SEPARATOR . implode(PATH_SEPARATOR, $include_path);
            } else {
                set_include_path(
                    $path . PATH_SEPARATOR .
                    implode(PATH_SEPARATOR, $include_path)
                );
            }
        }
    }
    
    /**
     * Loads a class from within the include_path provided the class follows PEAR naming
     * conventions.
     *
     * This provides no check to see if the class requested is already loaded or if the class was
     * successfully loaded.  If that functionality is required, use the static
     * {@link Domain51_Loader::loadClass()} method.
     *
     * This method should rarely be used directly, but is provided as a public method for those
     * requiring it.  This method must be invoked on an instance of Domain51_Loader, either directly
     * instantiated, or through {@link Domain51_Loader::getInstance()}.
     *
     * @internal include_once is used to keep from halting the system while still insuring that no
     *           subsequent calls to an already included file are made.  This allows a developer
     *           to surpress the error message in cases where it is warranted (such as the SPL
     *           autoload registry).
     *
     * @param string $class_name Class to load
     */
    public function loadClassWithoutCheck($class_name)
    {
        // if a custom include_path was provided at instantiation, use it temporarily
        if (isset($this->_paths)) {
            $this->_temp_paths = get_include_path();
            set_include_path($this->_paths);
        }
        
        $this->_filename = str_replace('_', DIRECTORY_SEPARATOR, $class_name) . '.php';
        unset($class_name);
        include_once $this->_filename;
        
        // revert the custom include_path, if used
        if (isset($this->_paths)) {
            set_include_path($this->_temp_paths);
        }
    }
    
    /**
     * Static utility method for loading a class and checking to insure it was loaded
     *
     *
     * @param string $class_name Class to load
     *
     * @return true|null  Returns true if the class was successfully loaded, or null if the class
     *                    already exists.
     *
     * @throws Domain51_Loader_UnknownClassException if the class is not located
     *
     * @see Domain51_Loader::getInstance(), Domain51_Loader::loadClassWithoutCheck()
     */
    public function loadClass($class_name)
    {
        if (class_exists($class_name, false)) {
            return null;
        }
        
        if (isset($this) && $this instanceof Domain51_Loader) {
            $this->loadClassWithoutCheck($class_name);
        } else {
            @self::getInstance()->loadClassWithoutCheck($class_name);
        }
        
        if (!class_exists($class_name, false)) {
            throw new Domain51_Loader_UnknownClassException(
                "Unable to locate class {$class_name}"
            );
        }
        
        return true;
    }
    
    /**
     * Returns a Singleton copy of this object
     *
     * Note that getInstance() assumes you will be using the include_path to search for classes.
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
        @self::getInstance()->loadClassWithoutCheck($class_name);
    }
}

/**
 * The exception thrown by {@link Domain51_Loader::loadClass()} when a class is not found.
 */
class Domain51_Loader_UnknownClassException extends Exception { }

/**
 * If __autoload() exists add it to the list of registered callbacks in front of
 * Domain51_Loader::autoload().
 *
 * @internal Note that this currently relies on spl_autoload_register() to only take one instance
 *           of any given callback.  This is the current behavior, and is tested in
 *           tests/regression.
 *
 * @ignore
 */
if (function_exists('__autoload')) {
    spl_autoload_register('__autoload');
}

/**
 * Register with autoload stack
 * @ignore
 */
spl_autoload_register(array(
    'Domain51_Loader',
    'autoload'
));
