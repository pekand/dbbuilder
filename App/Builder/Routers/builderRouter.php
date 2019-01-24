<?php

use Core\Services\Services;
use Core\Db\SchemaBuilder;

// update database with schema
$router->get("/admin/db/builder", function() {
	echo "<pre>";
	$db = Services::Db();
	$schema = new SchemaBuilder($db, "db/schema.json");
	$schema->build();

	print_r($db->schema());
	print_r($db->list());		

	return "";
});

// query
$router->get("/admin/db/query", function() {
	echo "<pre>";
	$db = Services::Db();
	print_r($db->list());		
	print_r($db->schema());		
	print_r($db->definitions());
	

	return "";
});
