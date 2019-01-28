<?php

$router->get("/admin/info/server", function($app){
	var_dump($_SERVER);
});

$router->get("/admin/info/phpinfo", function($app){
	phpinfo();
});

$router->get("/admin/info/routes", function($app){	
	$routes = $app->services->get('router')->getAllRoutes();
	
	var_dump($routes);
});
