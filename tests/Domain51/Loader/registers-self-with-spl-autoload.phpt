--TEST--
Domain51_Loader::autoload() is automatically registered with SPL's autoload registry
--FILE--
<?php
// BEGIN REMOVE
set_include_path(dirname(__FILE__) . '/../../../src/' . PATH_SEPARATOR .
                 get_include_path()
                 );
// END REMOVE

$before = spl_autoload_functions();
require_once 'Domain51/Loader.php';
$after = spl_autoload_functions();

assert('$before != $after');
assert('in_array(array("Domain51_Loader", "autoload"), $after)');

?>
===DONE===
--EXPECT--
===DONE===