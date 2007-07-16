--TEST--
Domain51_Loader::loadClass() loads a file based on the PEAR naming convention.  Example:
Domain51_SomePackage will translate into ...include_path.../Domain51/Loader.php.
--FILE--
<?php
// BEGIN REMOVE
set_include_path(dirname(__FILE__) . '/../../support/' . PATH_SEPARATOR .
                 dirname(__FILE__) . '/../../../src/' . PATH_SEPARATOR .
                 get_include_path()
                 );
// END REMOVE

require_once 'Domain51/Loader.php';

$loader = new Domain51_Loader();
assert('!class_exists("Domain51_SomeObject", false)');
$loader->loadClass('Domain51_SomeObject');
assert('class_exists("Domain51_SomeObject", false)');
?>
===DONE===
--EXPECT--
===DONE===