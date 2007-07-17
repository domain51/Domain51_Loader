--TEST--
Domain51_Loader can be located in any Domain51/ direcotry within the file system and still be able
to properly find classes that follow PEAR naming conventions located near it without an
include_path set.
--FILE--
<?php
set_include_path('');

$path = dirname(__FILE__) . '/support';
copy(dirname(__FILE__) . '/../src/Domain51/Loader.php', "{$path}/Domain51/Loader.php");

require_once "{$path}/Domain51/Loader.php";
$object = new Domain51_SomeObject();
?>
===DONE===
--CLEAN--
<?php @unlink(dirname(__FILE__) . '/support/Domain51/Loader.php'); ?>
--EXPECT--
===DONE===