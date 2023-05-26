<?php
/*

this will auto load classes when request within the code 

make sure the namespaces match the file directory structure

*/
spl_autoload_register(function ($class) {

    include 'code/' . $class . '.php';
});
