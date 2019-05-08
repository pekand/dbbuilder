<?php

use Core\Db\SchemaBuilder;
use Core\Router\JsonResponse;

// list tables
$router->get("/admin/dbadmin/tables", function($app) {
    $db = $app->get('db');      

    return $app->get('template')->render(
		"dbadmin/tables", 
		[
			'tables' => $db->schema(),
		]
	);
});

// list table items
$router->get("/admin/dbadmin/table/:table", function($app, $table) {
    $db = $app->get('db');

    $data = $db->get("SELECT * FROM {$table};");

    return $app->get('template')->render(
		"dbadmin/table", 
		[
			'table' => $table,
			'data' => $data,
		]
	);
});

// create new table
$router->get("/admin/dbadmin/table/:tablename/create", function($app, $tablename) {
    $db = $app->get('db');

	$db->create($tablename);
});


// drop table
$router->get("/admin/dbadmin/table/:tablename/drop", function($app, $tablename) {
    $db = $app->get('db');
    $data = $db->drop($tablename);
});

// view column
$router->get("/admin/dbadmin/table/:table/edit/:uid", function($app, $table, $uid) {
    $db = $app->get('db');

    $data = $db->get("SELECT * FROM {$table} where uid = :uid;", ['uid'=>$uid]);
    
	if (isset($data[0])) {
		$data = $data[0];
	    unset($data['id']);
		unset($data['uid']);
	}

    return $app->get('template')->render(
		"dbadmin/edit", 
		[
			'table' => $table,
			'uid' => $uid ,
			'data' => $data,
		]
	);
});

// new column
$router->get("/admin/dbadmin/table/:table/new", function($app, $table) {
    $db = $app->get('db');

    $data = $db->tableColumns($table);

    unset($data['id']);
	unset($data['uid']);
	
	foreach($data as &$value) {
		$value = '';
	}

    return $app->get('template')->render(
		"dbadmin/edit", 
		[
			'table' => $table,
			'uid' => '' ,
			'data' => $data,
		]
	);
});

// proces login form
$router->post("/admin/dbadmin/table/:table/new", function($app, $table) {
	$db = $app->get('db');

	$uid = $db->insert($table, $_POST);	

	return new JsonResponse(['uid'=>$uid]);
});

// proces login form
$router->post("/admin/dbadmin/table/:table/update/:uid", function($app, $table, $uid) {
	$db = $app->get('db');

	$db->update($table, $uid, $_POST);	
});

// proces login form
$router->get("/admin/dbadmin/table/:table/remove/:uid", function($app, $table, $uid) {
	$db = $app->get('db');

	$db->delete($table, $uid);	
});


// proces login form
$router->get("/admin/dbadmin/schema", function($app) {
	$db = $app->get('db');
	$schema = $db->schema();
	
	return $app->get('template')->render(
		"dbadmin/schema", 
		[
			'schema' => $schema
		]
	);
});

// render template dbconsole
$router->get("/admin/dbadmin/console", function($app){
	$query = $app->get('request')->get('query');
	
	$db = $app->get('db');

	$result = null;
	if (!empty($query)) {
		try {
			$result = $db->get($query);
		} catch (Exception $e) {
			$result = $e->getMessage();
		}
	}
		
	return $app->get('template')->render(
		"dbadmin/console", 
		[
			'query' => $query,
			'result' => json_encode($result, JSON_PRETTY_PRINT),
		]
	);
});

// execute query in database
$router->post("/admin/dbadmin/console", function($app){

	$query = $app->get('request')->post('query');

	$db = $app->get('db');

	$result = null;
	if (!empty($query)) {
		try {
			$result = $db->get($query);
		} catch (Exception $e) {
			$result = $e->getMessage();
		}
		
	}

	return new JsonResponse(['result' => json_encode($result, JSON_PRETTY_PRINT)]);
});


