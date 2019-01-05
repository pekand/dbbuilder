<?php

use Core\Services\Services;

$router->get("/", function(){
	$page = Services::Template();
	return $page->render("main", ['test' => 'aaa']);
});

$router->get("*", function(){
	return "not found";
});