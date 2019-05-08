<?php

// create private zone
$router->middleware("/admin", function($app){
	
	$auth = $app->get('auth');
	
	if(!$auth->is('admin')) {
		$username = $app->get('request')->post('username');
		$password = $app->get('request')->post('password');
			
		if (!empty($username)) {
			if($auth->login($username, $password)) {
				header("Location: ".$app->get('request')->uri());
				return null;
			}
		}
	}
		
	if(!$auth->is('admin')) {
		return $app->get('template')->render("login", []);
	}
	
	return true;
});

// displey login page
$router->get("/login", function($app){
	$page = $app->get('template');
	return $page->render("login", []);
});

// proces login form
$router->post("/login", function($app){
	$username = $app->get('router')->post('username');
	$password = $app->get('router')->post('password');
		
	$auth = $app->get('auth');	
	if(!$auth->login($username, $password)) {
		$page = $app->get('template');
		return $page->render("login", []);
	}
	
	header("Location: /");
	return ;
});

// logout user
$router->get("/logout", function($app){	
	$auth = $app->get('auth');
	$auth->logout();
	return json_encode(['ok']);
});