<?php

//importing content from an external file
require_once 'classes/layout.php';
require_once 'content/layout.php';

//creating an instance of a class
$ObjLayout = new layout();
$ObjContent = new contents();

//calling a method from a class/invoking a method

$ObjLayout->heading();
$ObjContent->index_content();
$ObjLayout->footer();

