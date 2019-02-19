<?php

$app->router->get("/", function($app) {
	return $app->services->get('template')->render("main", ['title' => 'Main']);
});

$app->router->get("*", function($app, $all) {
	return "not found";
});