<?php

use Core\Services\Services;

$router->post("/login", function(){
	return json_encode(['ok']);
});

$router->get("/logout", function(){
	$auth = Services::Auth();
	$auth->logout();
	return json_encode(['ok']);
});