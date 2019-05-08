<?php

// create private zone
$router->middleware("/zone", function($app) {
	
	$auth = $app->get('auth');
	
	if(!$auth->is('admin') || !$auth->is('zone_user')) {
		$username = $app->get('request')->post('username');
		$password = $app->get('request')->post('password');
			
		if (!empty($username)) {
			if($auth->login($username, $password)) {
				header("Location: ".$app->get('request')->uri());
				return null;
			}
		}
	}
		
	if(!$auth->is('admin') || !$auth->is('zone_user')) {
		return $app->get('template')->render("login", []);
	}
	
	return true;
});