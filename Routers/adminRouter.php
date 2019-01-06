<?php

use Core\Services\Services;
use Core\Db\SchemaBuilder;

$router->get("/admin/db/test", function(){
	$db = Services::Db();
	$db->drop('temp');
	
	

	//$db->drop('test');
	//$db->create('test');
	//$db->addColumn('test', 'uid', 'CHAR(32)', 'not null default ""');
	//$db->addColumn('test', 'name', 'TEXT', '');
	//$db->addColumn('test', 'surname', 'TEXT', '');
	//$db->insert('test', ["uid"=>$db->uid(), "name" => "aaaaa", 'surname'=>'bbbb']);

	return "create database";
});

$router->get("/admin/db/user", function(){
	$userManager = Services::UserManager();
	$userManager->init();
	$userManager->create('test', '123');
	$user = $userManager->get('test');
	var_dump($user);
	
	//$userManager->remove('test');

	$db = Services::Db();
	var_dump($db->list());
});

$router->get("/admin/db/auth", function() {
	$session = Services::Session();

	$userManager = Services::UserManager();
	$userManager->init();

	$auth = Services::Auth();
	$auth->createUser('root', 'password');

	$db = Services::Db();
	//var_dump($db->dump('users'));

	echo "<pre>";
	print_r($session->list());

	$auth->login('root', 'password');

	print_r($session->list());

	$auth->logout();

	print_r($session->list());
});

$router->get("/admin/db/list", function() {
	echo "<pre>";
	$db = Services::Db();
	print_r($db->list());
});

$router->get("/admin/db/console", function(){
	$page = Services::Template();
	return $page->render("dbconsole", ['test' => 'aaa']);
});

$router->post("/admin/db/console/query", function(){
	$query = @$_POST['query'];
	$db = Services::Db();

	$result = null;

	try {
		$result = $db->get($query);
	} catch (Exception $e) {
		var_dump($e);
	}

	header('Content-Type: application/json');
	return json_encode(["test"=>$result]);
});

$router->get("/admin/db/builder", function() {
	echo "<pre>";
	$db = Services::Db();
	$schema = new SchemaBuilder($db, "db/schema.json");
	$schema->build();

	print_r($db->list());

	return "";
});
