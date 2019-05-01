<?php

use Core\Db\SchemaBuilder;

// list tables
$router->get("/admin/dbadmin/tables", function($app) {
    $db = $app->get('db');      

    return $app->get('template')->render(
		"tables", 
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
		"table", 
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

    unset($data[0]['id']);
	unset($data[0]['uid']);

    return $app->get('template')->render(
		"edit", 
		[
			'table' => $table,
			'uid' => $uid ,
			'data' => $data[0] ,
		]
	);
});

// proces login form
$router->post("/admin/dbadmin/table/:table/new", function($app, $table, $uid) {
	$db = $app->get('db');

	$uid = $db->insert($table, $_POST);	

	echo $uid;
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

$router->get("/admin/test", function($app) {
    $db = $app->get('db');

	$db->insert('test', [
		'name' => 'xxx',
		'body' => 'yyy',
	]);
});

