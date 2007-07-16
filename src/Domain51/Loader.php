<?php

class Domain51_Loader
{
    private static $_instance = null;
    
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
     * @param string $class_name Class to load
     */
    public function loadClass($class_name)
    {
        $file = str_replace('_', '/', $class_name) . '.php';
        require_once $file;
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
     * @param string $class_name Name of class to load
     */
    public static function autoload($class_name)
    {
        self::getInstance()->loadClass($class_name);
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