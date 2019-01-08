<?php

use Core\Services\Services;

$router->get("/admin/info/server", function(){
	var_dump($_SERVER);
});

$router->get("/admin/info/phpinfo", function(){
	phpinfo();
});

$router->get("/admin/info/routes", function(){
	global $router;
	$routes = $router->getAllRoutes();
	
	var_dump($routes);
});
