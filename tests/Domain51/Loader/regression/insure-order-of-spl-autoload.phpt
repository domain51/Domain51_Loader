--TEST--
Insure that the load order of the spl autoload has not changed from expected result
--FILE--
<?php

require_once dirname(__FILE__) . '/_setup.inc';

spl_autoload_register('one');
spl_autoload_register('two');
spl_autoload_call('SomeClass');

?>
===DONE===
--EXPECT--
one: SomeClass
two: SomeClass
===DONE===