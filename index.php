<?php

use Core\App\App;


function dump($value)
{ 
	echo "<script>console.log(".json_encode($value, JSON_PRETTY_PRINT).");</script>";
}

define('ROOT_PATH', dirname(__FILE__));

require_once(ROOT_PATH."/autoloader.php");
require_once(ROOT_PATH.'/vendor/autoload.php');

$app = new App();
$app->init();