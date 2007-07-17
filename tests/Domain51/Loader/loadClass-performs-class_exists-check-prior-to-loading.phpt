--TEST--
Domain51_Loader::loadClass() performs a class_exists() check prior to loading
to insure that the class its trying to load doesn't already exist.  If the
already exists, it will return null, otherwise a successful loadClass() will
return true.
--FILE--
<?php
// BEGIN REMOVE
set_include_path(dirname(__FILE__) . '/../../support/' . PATH_SEPARATOR .
                 dirname(__FILE__) . '/../../../src/' . PATH_SEPARATOR .
                 get_include_path()
                 );
// END REMOVE

require_once 'Domain51/Loader.php';
assert('!class_exists("Domain51_SomeObject", false)');
$result = Domain51_Loader::loadClass('Domain51_SomeObject');
assert('$result == true');
assert('class_exists("Domain51_SomeObject", false)');

unset($result);
$result = Domain51_Loader::loadClass('Domain51_SomeObject');
assert('is_null($result)');

?>
===DONE===
--EXPECT--
===DONE===