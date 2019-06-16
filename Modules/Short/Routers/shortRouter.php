<?php

/*
	url shortener
*/

// render template dbconsole
$router->get("/short", function($app){
	$database = $app->get('request')->get('database');
	$query = $app->get('request')->get('query');

	$result = null;
	if (!empty($query)) {
		$result = $app->get('dbconsole')->processQuery($database, $query);
	}
		
	return $app->get('template')->render(
		"short", 
		[
			'database' => $database,
			'query' => $query,
			'result' => json_encode($result, JSON_PRETTY_PRINT),
		]
	);
});

// execute query in database
$router->post("/short/add", function($app){
	$url = $app->get('request')->post('url');
	
	$db = $app->get("db");
	
	$name = "";
	if (!empty($url)) {
		$name =  substr(hash('sha256', $url.time().mt_rand()), 0, 20);
		$url = $db->insert("urls", ['ctime' => date("Y-m-d h:i:s"),'counter'=>0,'name'=>$name,'body'=>$url]);
	}
	
	$db = $app->get("db");
	
	header('Content-Type: application/json');
	return json_encode(['name' => $name]);
});

// execute query in database
$router->get("/short/:name", function($app, $name) {	
	
	$db = $app->get("db");
	
	$url = null;
	if (!empty($name)) {
		$url = $db->get("select * from urls where name = :name", ['name'=>$name]);
	}
	
	if ($url != null) {
		$db->update("urls", $url[0]['uid'], ['counter'=>$url[0]['counter']+1]);
		header("Location: ".$url[0]['body']);
	}
	
	return null;
});

