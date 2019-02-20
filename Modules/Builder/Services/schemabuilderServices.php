<?php

use Builder\SchemaBuilder\SchemaBuilder;

$services->add('schemabuilder', function($app){
    $schemapath = $app->get('config')->get('schemabuilder.schemapath');
    $db = $app->get('db');
	$schemabuilder = new SchemaBuilder($db, $schemapath);
	
	return $schemabuilder;
});

