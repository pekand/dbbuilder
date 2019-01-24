<?php

use Core\Router\Router;

define('ROOT_PATH', dirname(__FILE__));
chdir(ROOT_PATH);

require_once("autoloader.php");

$router = new Router();
$router->load();
$router->execute();
