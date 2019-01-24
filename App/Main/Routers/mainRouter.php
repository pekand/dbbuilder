<?php

use Core\Services\Services;

$router->get("/", function(){
	$page = Services::Template();
	return $page->render("main", ['title' => 'Main']);
});

$router->get("*", function(){
	return "not found";
});