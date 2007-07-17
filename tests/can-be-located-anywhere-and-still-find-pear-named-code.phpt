--TEST--
Domain51_Loader can be located in any Domain51/ direcotry within the file system and still be able
to properly find classes that follow PEAR naming conventions located near it without an
include_path set.
--FILE--
<?php
// BEGIN REMOVE
set_include_path(dirname(__FILE__) . '/../src/' . PATH_SEPARATOR .
                 get_include_path()
                 );
// END REMOVE

$include_paths = explode(PATH_SEPARATOR, get_include_path());
$filepath = false;
foreach ($include_paths as $include_path) {
    if (file_exists("{$include_path}/Domain51/Loader.php")) {
        $filepath = "{$include_path}/Domain51/Loader.php";
        break;
    }
}
if ($filepath === false) {
    trigger_error('unable to load Domain51/Loader.php in include_path');
}

$path = dirname(__FILE__) . '/support';
copy($filepath, "{$path}/Domain51/Loader.php");

require_once "{$path}/Domain51/Loader.php";
$object = new Domain51_SomeObject();
?>
===DONE===
--CLEAN--
<?php @unlink(dirname(__FILE__) . '/support/Domain51/Loader.php'); ?>
--EXPECT--
===DONE===