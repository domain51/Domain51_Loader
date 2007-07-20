--TEST--
If Domain51_Loader is instantiated using the include_path (as is default for
autoload), all changes to the include_path while it is running will be
detected.
--FILE--
<?php
// BEGIN REMOVE
set_include_path(dirname(__FILE__) . '/../src/' . PATH_SEPARATOR .
                 get_include_path()
                 );
// END REMOVE

require_once 'Domain51/Loader.php';

assert('!class_exists("Domain51_SomeOtherObject", true)');

set_include_path(
    dirname(__FILE__) . '/support/non-standard' . PATH_SEPARATOR .
    get_include_path()
);

$include_path_prior = get_include_path();
assert('class_exists("Domain51_SomeOtherObject", true)');

assert('$include_path_prior == get_include_path()');

?>
===DONE===
--EXPECT--
===DONE===
--TEST--
If Domain51_Loader is instantiated using the include_path (as is default for
autoload), all changes to the include_path while it is running will be
detected.
--FILE--
<?php
// BEGIN REMOVE
set_include_path(dirname(__FILE__) . '/../src/' . PATH_SEPARATOR .
                 get_include_path()
                 );
// END REMOVE

require_once 'Domain51/Loader.php';

assert('!class_exists("Domain51_SomeOtherObject", true)');

set_include_path(
    dirname(__FILE__) . '/support/non-standard' . PATH_SEPARATOR .
    get_include_path()
);

$include_path_prior = get_include_path();
assert('class_exists("Domain51_SomeOtherObject", true)');

assert('$include_path_prior == get_include_path()');

?>
===DONE===
--EXPECT--
===DONE===
