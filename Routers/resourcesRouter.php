<?php

$router->get("/Resources/*", function($path){

	echo ROOT_PATH.'/public/Resources/'.$path;
	if (!file_exists(ROOT_PATH.'/public/Resources/'.$path)) {
		return;
		echo file_get_contents(ROOT_PATH.'/public/Resources/'.$path);
	}
	
	header('Content-Type: text/javascript');


	return;
});

