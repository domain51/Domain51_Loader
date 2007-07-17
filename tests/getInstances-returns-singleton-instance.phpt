--TEST--
Domain51_Loader can be used as a Singleton via getInstance()
--FILE--
<?php
// BEGIN REMOVE
set_include_path(dirname(__FILE__) . '/support/' . PATH_SEPARATOR .
                 dirname(__FILE__) . '/../src/' . PATH_SEPARATOR .
                 get_include_path()
                 );
// END REMOVE

require_once 'Domain51/Loader.php';
assert('Domain51_Loader::getInstance() instanceof Domain51_Loader');
assert('Domain51_Loader::getInstance() === Domain51_Loader::getInstance()');

?>
===DONE===
--EXPECT--
===DONE===