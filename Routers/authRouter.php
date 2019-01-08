<?php

use Core\Services\Services;

// create private zone
$router->middleware("/admin", function(){
	$auth = Services::Auth();
	
	if(!$auth->is('admin')) {
		$username = Services::Request()->post('username');
		$password = Services::Request()->post('password');
			
		if (!empty($username)) {
			if($auth->login($username, $password)) {
				header("Location: ".Services::Request()->uri());
				return null;
			}
		}
	}
		
	if(!$auth->is('admin')) {
		$page = Services::Template();
		return $page->render("login", []);
	}
	
	return true;
});

// displey login page
$router->get("/login", function(){
	$page = Services::Template();
	return $page->render("login", []);
});

// proces login form
$router->post("/login", function(){
	
	$username = Services::Request()->post('username');
	$password = Services::Request()->post('password');
		
	$auth = Services::Auth();	
	if(!$auth->login($username, $password)) {
		$page = Services::Template();
		return $page->render("login", []);
	}
	
	header("Location: /");
	return ;
});

// logout user
$router->get("/logout", function(){
	$auth = Services::Auth();
	$auth->logout();
	return json_encode(['ok']);
});