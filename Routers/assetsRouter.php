<?php

$router->get("/assets/*", function($path){
    $filepath = ROOT_PATH.'/public/assets/'.$path;
    
    if (!file_exists(ROOT_PATH.'/public/assets/'.$path)) {
    	return;
    }
    
    $ext = strtolower(pathinfo($filepath, PATHINFO_EXTENSION));
    switch ($ext) {
        case 'js':
            header('Content-Type: text/javascript');
            break;
        case 'css':
            header("Content-Type: text/css"); 
            header("X-Content-Type-Options: nosniff");
            break;
        case 'jpg':
            header("Content-Type: image/jpeg");
			header("Content-Length: " . filesize($filepath));
            break;
        case 'png':
            header("Content-Type: image/png");
			header("Content-Length: " . filesize($filepath));
            break;
        case 'ico':
            header("Content-Type: image/ico");
			header("Content-Length: " . filesize($filepath));
            break;
    }
    
    echo file_get_contents($filepath);

    return;
});

