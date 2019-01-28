<?php

use Core\Config\Config;
use Core\Session\Session;
use Core\Db\Sqlite;
use Core\Db\MySQL;
use Core\Auth\Auth;
use Core\Auth\UserManager;
use Core\Template\Template;
use Core\Router\Request;

$services->add('db', function($app){
    $dbPath = ROOT_PATH . Config::$db;
    $db = new Sqlite();
    $db->open($dbPath);

    return $db;
});

$services->add('mysql', function($app) {
    $mysql = new MySQL("127.0.0.1", "root", "", "");
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
    $templatesPath = ROOT_PATH . Config::$templates;

    $template = new Template($templatesPath);

    return $template;
});

$services->add('request', function($app){
    $request = new Request();
    
    return $request;
});