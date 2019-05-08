<?php

use Core\Router\JsonResponse;

// render template checker
$router->get("/checker", function($app){
	$query = $app->get('request')->get('url');
	
	$db = $app->get('db');

	$result = null;
	if (!empty($query)) {
		/*try {
			$result = $db->get($query);
		} catch (Exception $e) {
			$result = $e->getMessage();
		}*/
	}
		
	return $app->get('template')->render(
		"checker/checker", 
		[
			'url' => $query,
			'result' => json_encode($result, JSON_PRETTY_PRINT),
		]
	);
});

// execute query in database
$router->post("/checker", function($app){

	$query = $app->get('request')->post('query');

	$db = $app->get('db');

	$result = null;
	if (!empty($query)) {
		try {
			$result = $db->get($query);
		} catch (Exception $e) {
			$result = $e->getMessage();
		}
		
	}

	return new JsonResponse(['result' => json_encode($result, JSON_PRETTY_PRINT)]);
});


