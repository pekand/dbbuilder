<?php

use Core\Session\Session;
use Core\Db\Sqlite;
use Core\Db\MySQL;
use Core\Auth\Auth;
use Core\Auth\UserManager;
use Core\Template\Template;
use Core\Router\Request;
use Core\Temp\Temp;

$services->add('config', function($app){   
    return $app->config;
});

$services->add('request', function($app){
    $request = new Request();
    
    return $request;
});

$services->add('db', function($app){
    $dbPath = $app->get('config')->get('dbPath');
    
    $db = new Sqlite();
    $db->open($dbPath);

    return $db;
});

$services->add('mysql', function($app) {
    $config = $app->get('config');
    $mysql = new MySQL(
        $config->get('mysql.host'), 
        $config->get('mysql.username'), 
        $config->get('mysql.password'), 
        $config->get('mysql.dbname')
    );
    return $mysql;
});

$services->add('session', function($app){
    $session = new Session();

    return $session;
});

$services->add('userManager', function($app){
    $db = $app->services->get('db');
    $userManager = new UserManager($db);

    return $userManager;
});

$services->add('auth', function($app){
    $session = $app->services->get('session');
    $userManager = $app->services->get('userManager');
    $auth = new Auth($session, $userManager);

    return $auth;
});

$services->add('template', function($app){
    $templatesPath = $app->get('config')->get('templatesPath');

    $template = new Template($app, $templatesPath);

    return $template;
});

//
$services->add('temp', function($app){
    $tempPath = $app->get('config')->get('tempPath');
    dump($tempPath);
    $temp = new Temp($app, $tempPath);
    
    return $temp;
});
