<?php

use Core\Db\SchemaBuilder;

$services->add('schemabuilder', function($app){
    $db = $app->get('db');
	$schemabuilder = new SchemaBuilder($db, "db/schema.json");
	
	return $schemabuilder;
});

