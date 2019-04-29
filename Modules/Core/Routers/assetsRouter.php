<?php

// render assets file
$router->get("/assets/*", function($app, $path){   
    $found = false;
    foreach (array_filter(glob(ROOT_PATH . '/Modules/*'), 'is_dir') as $module) {
        $assetsPath = $module . '/Assets/';
        $filepath = $assetsPath.$path;

        if (!file_exists($filepath)) {
            continue;
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
            default:
                header('HTTP/1.0 404 Not Found');
                die('not found');
        }

        $found = true;
        echo file_get_contents($filepath);
    }

    
    if (!$found) {
    	header('HTTP/1.0 404 Not Found');
        die('not found');
    }
});
