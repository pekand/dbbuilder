<?php

use Core\Db\SchemaBuilder;

// create test table
$router->get("/admin/db/test", function($app) {

    $db = $app->get('db');

    $db->drop('test');
    $db->create('test');
    $db->addColumn('test', 'uid', 'CHAR(32)', 'not null default ""');
    $db->addColumn('test', 'name', 'TEXT', '');
    $db->addColumn('test', 'surname', 'TEXT', '');
    $db->insert('test', ["uid"=>$db->uid(), "name" => "aaaaa", 'surname'=>'bbbb']);

    return "create table test";
});

// create test user in users table with user manager
$router->get("/admin/db/user", function($app) {
    $userManager = $app->get('userManager');
    $userManager->init();
    $userManager->create('test', '123');
    $user = $userManager->get('test');
    var_dump($user);
    
    //$userManager->remove('test');

    $db = $app->get('db');
    var_dump($db->list());
});

$router->get("/admin/db/users/drop", function($app) {
    $db = $app->get('db');
    $db->drop('users');
    $db->create('users');
    $db->addColumn('users', 'uid', 'CHAR(255)', 'not null default ""');
    $db->addColumn('users', 'username', 'CHAR(255)', '');
    $db->addColumn('users', 'password', 'CHAR(255)', '');
    $db->addColumn('users', 'roles', 'CHAR(255)', '');
    $db->addColumn('users', 'rights', 'CHAR(255)', '');
});

$router->get("/admin/db/user/add/root", function($app) {

    $db = $app->get('db');
       
    // create new user
    $app->get('auth')->createUser('root', 'password', ['admin'], ['all']);
});

$router->get("/admin/db/auth", function($app) {
    $session = $app->get('session');

    // drop and recreate users table
    $userManager = $app->get('userManager');
    $userManager->init();

    // create new user
    $auth = $app->get('auth');
    $auth->createUser('root', 'password', ['admin'], ['all']);

    // list table users
    $db = $app->get('db');
    var_dump($db->dump('users'));

    echo "<pre>";
    
    // displey session content
    print_r($session->list());
        
    // login as user root
    $auth->login('root', 'password');

    print_r($session->list());

    // logout user root
    $auth->logout();

    print_r($session->list());
});

// displey whole database content
$router->get("/admin/db/tables/schema/view", function($app) {
    echo "<pre>";
    $db = $app->get('db');      
    print_r($db->schema());     
});

$router->get("/admin/db/tables/definitions/view", function($app) {
    echo "<pre>";
    $db = $app->get('db');  
    print_r($db->definitions());
});

$router->get("/admin/db/tables/tablenames/view", function($app) {
    echo "<pre>";
    $db = $app->get('db');  
    print_r($db->tables());
});

// displey whole database content
$router->get("/admin/db/table/:tablename/list", function($app, $tablename) {
    echo "<pre>";
    $db = $app->get('db');
    $data = $db->get("SELECT * FROM {$tablename};");
    print_r($data);
});

$router->get("/admin/db/table/:tablename/drop", function($app, $tablename) {
    echo "<pre>";
    $db = $app->get('db');
    $data = $db->exec("DROP TABLE IF EXISTS {$tablename};");
    print_r("ok");
});

$router->get("/admin/db/table/:tablename/create", function($app, $tablename) {
    echo "<pre>";
    $db = $app->get('db');
    $db->exec("CREATE TABLE IF NOT EXISTS {$tablename} (id integer PRIMARY KEY);");
    print_r("ok");
});