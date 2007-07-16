--TEST--
If Domain51_Loader::autoload does not find the expected file, it will gracefully ignore it to allow
other autoloaders that have been loaded to load it.
--FILE--
<?php
// BEGIN REMOVE
set_include_path(dirname(__FILE__) . '/../../../src/' . PATH_SEPARATOR .
                 get_include_path()
                 );
// END REMOVE

require_once 'Domain51/Loader.php';

// register secondary
function test_autoload($class_name) {
    require_once dirname(__FILE__) . '/../../support/non-standard/Domain51/SomeOtherObject.php';
}
spl_autoload_register('test_autoload');

assert('!class_exists("Domain51_SomeOtherObject", false)');
$object = new Domain51_SomeOtherObject();
?>
===DONE===
--EXPECT--
===DONE===