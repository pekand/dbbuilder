<?php



// update database with schema
$router->get("/admin/db/builder", function($app) {
	echo "<pre>";
	$schema = $app->get('schemabuilder');
	$schema->build();

	$db = $app->get('db');
	print_r($db->schema());
	print_r($db->list());		

	return "";
});

// query
$router->get("/admin/db/query", function($app) {
	echo "<pre>";
	$db = $app->get('db');
	print_r($db->list());		
	print_r($db->schema());		
	print_r($db->definitions());

	return "";
});

$router->get("/admin/db/drop-all", function($app) {
	echo "<pre>";
	$db = $app->get('db');
	$tables = $db->tables();
	dump($tables);
	
	foreach($tables as $table) {
		$db->drop('users');
	}

	return "";
});
