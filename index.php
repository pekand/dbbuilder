<?php

use Core\Router\Router;
use Core\Services\Services;

define('ROOT_PATH', dirname(__FILE__));
chdir(ROOT_PATH);

require_once("autoloader.php");

$router = new Router();

foreach (glob('./Routers/*Router.php') as $routerFile) {
    include $routerFile;
}

$router->execute();
