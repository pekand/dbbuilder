<?php

use Core\Services\Services;

$router->get("/debug/server", function(){
	var_dump($_SERVER);
});

$router->get("/debug/phpinfo", function(){
	phpinfo();
});

$router->get("/debug/test/:id/abc/:test/*", function($id, $test){
	return "xxx".$id.$test;
});

$router->get("/debug/abc/*", function($rest){
	return "all".$rest;
});

