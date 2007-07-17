--TEST--
If __autoload() function exists and has been registered with SPL autoload,
Domain51/Loader.php will not re-register it.
--FILE--
<?php
// BEGIN REMOVE
set_include_path(dirname(__FILE__) . '/../../support/' . PATH_SEPARATOR .
                 dirname(__FILE__) . '/../../../src/' . PATH_SEPARATOR .
                 get_include_path()
                 );
// END REMOVE

require_once dirname(__FILE__) . '/__autoload.func';
spl_autoload_register('__autoload');
require_once 'Domain51/Loader.php';

$obj = new Domain51_SomeObject();

$callbacks = spl_autoload_functions();
assert('in_array(array("Domain51_Loader", "autoload"), $callbacks)');
assert('in_array("__autoload", $callbacks)');

?>
===DONE===
--EXPECT--
__autoload(Domain51_SomeObject)
===DONE===