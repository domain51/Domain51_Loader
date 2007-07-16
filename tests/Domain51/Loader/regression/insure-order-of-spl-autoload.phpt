--TEST--
Insure that the load order of the spl autoload has not changed from expected result
--FILE--
<?php
set_include_path('');

function one($class_name)
{
    echo "one: $class_name\n";
}

function two($class_name)
{
    echo "two: $class_name\n";
}

spl_autoload_register('one');
spl_autoload_register('two');
spl_autoload_call('SomeClass');

?>
===DONE===
--EXPECT--
one: SomeClass
two: SomeClass
===DONE===