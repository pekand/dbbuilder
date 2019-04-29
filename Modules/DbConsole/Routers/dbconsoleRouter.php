<?php

/*
	mysql console
*/

// render template dbconsole
$router->get("/admin/dbconsole", function($app){
	$database = $app->get('request')->get('database');
	$query = $app->get('request')->get('query');

	$result = null;
	if (!empty($query)) {
		$result = $app->get('dbconsole')->processQuery($database, $query);
	}
		
	return $app->get('template')->render(
		"dbconsole", 
		[
			'database' => $database,
			'query' => $query,
			'result' => json_encode($result, JSON_PRETTY_PRINT),
		]
	);
});

// execute query in database
$router->post("/admin/dbconsole/query", function($app){
	$database = $app->get('request')->post('database');
	$query = $app->get('request')->post('query');

	$result = null;
	if (!empty($query)) {
		$result = $app->get('dbconsole')->processQuery($database, $query);
	}
	
	header('Content-Type: application/json');
	return json_encode(['result' => json_encode($result, JSON_PRETTY_PRINT)]);
});


