<?php

use Core\App\App;


function dump($value)
{ 
	header("Content-Type: text/html");
	//header('debuginfo: '.json_encode($value));
	echo "<script>console.log(".json_encode($value, JSON_PRETTY_PRINT).");</script>";
}

set_error_handler(function($errno, $errstr, $errfile, $errline ){
    dump([$errno, $errstr, $errfile, $errline]);
});

define('ROOT_PATH', dirname(__FILE__));

require_once(ROOT_PATH."/autoloader.php");
require_once(ROOT_PATH.'/vendor/autoload.php');

$app = new App();
$app->init();