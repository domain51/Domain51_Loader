--TEST--
If Domain51_Loader::loadClass() is called, it will throw an exception if the class does not exist
--FILE--
<?php
// BEGIN REMOVE
set_include_path(dirname(__FILE__) . '/support/' . PATH_SEPARATOR .
                 dirname(__FILE__) . '/../src/' . PATH_SEPARATOR .
                 get_include_path()
                 );
// END REMOVE

require_once 'Domain51/Loader.php';
try {
    Domain51_Loader::loadClass('SomeUnknownClass');
    trigger_error('exception not caught');
} catch (Domain51_Loader_UnknownClassException $e) {
    assert('$e->getMessage() == "Unable to locate class SomeUnknownClass"');
}

?>
===DONE===
--EXPECT--
===DONE===