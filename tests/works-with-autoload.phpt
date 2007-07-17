--TEST--
If Domain51_Loader has been required, then declaring a class will trigger the autoload to load it.
--FILE--
<?php
// BEGIN REMOVE
set_include_path(dirname(__FILE__) . '/support/' . PATH_SEPARATOR .
                 dirname(__FILE__) . '/../src/' . PATH_SEPARATOR .
                 get_include_path()
                 );
// END REMOVE

require_once 'Domain51/Loader.php';
assert('!class_exists("Domain51_SomeObject", false)');

$object = new Domain51_SomeObject();

?>
===DONE===
--EXPECT--
===DONE===