--TEST--
Insure that spl_autoload_register() only adds to the stack of registered
callbacks once, regardless of how many times it is called.
--FILE--
<?php

require_once dirname(__FILE__) . '/_setup.inc';
spl_autoload_register('one');
spl_autoload_register('one');
spl_autoload_register('two');
spl_autoload_register('two');

spl_autoload_call('SomeObject');
?>
===DONE===
--EXPECT--
one: SomeObject
two: SomeObject
===DONE===