<?php

use Core\Services\Services;

/*$router->post("/login", function(){
	return json_encode(['ok']);
});*/

// displey login page
$router->get("/login", function(){
	$page = Services::Template();
	return $page->render("login", []);
});

// proces login form
$router->post("/login", function(){
	$page = Services::Template();
	return $page->render("login", []);
});

// logout user
$router->get("/logout", function(){
	$auth = Services::Auth();
	$auth->logout();
	return json_encode(['ok']);
});