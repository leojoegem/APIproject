<?php

//Method Auto Load
function classAutoLoad($classname) {
    $directories = ["classes", "content", "forms", "processes", "global", "menus"];

    foreach ($directories as $dir) {
        $filename = dirname(__FILE__) . DIRECTORY_SEPARATOR . $dir . DIRECTORY_SEPARATOR . $classname . ".php";

        if (file_exists($filename) && is_readable($filename)) {
            require_once($filename);
            return; // Stop further iterations after finding the file
        }
    }
}

// Register the autoload function
spl_autoload_register('classAutoLoad');

//Creating an instance of a class
$ObjLayout = new layout();
$ObjContent = new contents();
