<?php

// create test table
$router->get("/admin/temp/clear", function($app) {
	$temp = $app->get('temp');

	$temp->set('abc', '123');

	dump($temp->get('abc'));

	$temp->clear();

	return "done";
});
