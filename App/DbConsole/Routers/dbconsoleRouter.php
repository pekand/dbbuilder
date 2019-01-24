<?php

use Core\Services\Services;
use DbConsole\DbConsole\DbConsole;

// render template dbconsole
$router->get("/admin/db/console", function(){
	
	$database = Services::Request()->get('database');
	$query = Services::Request()->get('query');

	$result = null;
	if (!empty($query)) {
		$result = (new DbConsole())->processQuery($database, $query);
	}
		
	return Services::Template()->render(
		"dbconsole", 
		[
			'database' => $database,
			'query' => $query,
			'result' => json_encode($result, JSON_PRETTY_PRINT),
		]
	);
});

// execute query in database
$router->post("/admin/db/console/query", function(){
	
	$database = Services::Request()->post('database');
	$query = Services::Request()->post('query');

	$result = null;
	if (!empty($query)) {
		$result = (new DbConsole())->processQuery($database, $query);
	}
	
	header('Content-Type: application/json');
	return json_encode(['result' => json_encode($result, JSON_PRETTY_PRINT)]);
});


