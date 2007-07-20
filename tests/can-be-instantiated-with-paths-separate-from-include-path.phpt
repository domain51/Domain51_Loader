--TEST--
Domain51_Loader can be instantiated with a string that differs from the currently
set include_path.  If such a string is provided, Domain51_Loader will assume that
is the location it should work from.
--FILE--
<?php
// BEGIN REMOVE
set_include_path(dirname(__FILE__) . '/../src/' . PATH_SEPARATOR .
                 get_include_path()
                 );
// END REMOVE

assert('!class_exists("Domain51_SomeOtherObject", false)');

require_once 'Domain51/Loader.php';

$loader = new Domain51_Loader(dirname(__FILE__) . '/support/non-standard');
$loader->loadClass('Domain51_SomeOtherObject');

assert('class_exists("Domain51_SomeOtherObject", false)');

?>
===DONE===
--EXPECT--
===DONE===