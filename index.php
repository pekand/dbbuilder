<?php

use Core\App\App;

define('ROOT_PATH', dirname(__FILE__));

require_once(ROOT_PATH."/autoloader.php");
require_once(ROOT_PATH.'/vendor/autoload.php');

$app = new App();
$app->init();