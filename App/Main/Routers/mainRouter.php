<?php

use Core\Services\Services;

$app->router->get("/", function($app) {
	$page = $app->services->get('template');
	return $page->render("main", ['title' => 'Main']);
});

$app->router->get("*", function($app, $all) {
	return "not found";
});