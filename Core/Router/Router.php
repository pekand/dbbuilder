<?php

namespace Core\Router;

class Router {
    private $routes = [];
    private $middlewares = [];
    
    private $uri = null;
    private $method = '';
    
    public function __construct($uri=null, $method=null) {
        $this->uri = $uri;
        $this->method = $method;
        if(empty($uri)) {
            $this->uri = trim(strtok(@$_SERVER['REQUEST_URI'],'?')??"/");
        }
        
        if(empty($method)) {
            $this->method=@$_SERVER['REQUEST_METHOD']??'GET'; 
        }
    }
    
    public function route($uri, $callback=null, $method='GET') {
        
        $route = [
            'uri' => trim($uri),
            'callback' => $callback,
            'method' => $method
        ];

        $this->routes[] = $route;
    }
    
    public function middleware($uri, $callback=null, $method='GET') {
        
        $middleware = [
            'uri' => trim($uri),
            'callback' => $callback,
            'method' => $method
        ];

        $this->middlewares[] = $middleware;
    }

    public function display($content) {

        if(is_object($content) && method_exists($content, 'render')) {
            echo $content->render();
        }

        echo $content;        
    }
    
    public function get($uri, $callback=null) {
        $this->route($uri, $callback, 'GET');    
    }

    public function post($uri, $callback=null) {
        $this->route($uri, $callback, 'POST');
    }
    
    public function put($uri, $callback=null) {
        $this->route($uri, $callback, 'PUT');
    }
    
    public function delete($uri, $callback=null) {
        $this->route($uri, $callback, 'DELETE');
    }

    public function getAllRoutes() { 
        $routes = [];
        
        foreach ($this->routes as &$route) {
           $routes[] = $route['uri'];
        }
        
        return $routes;
    }
    
    public function execute() { 
        
        usort($this->middlewares,  function ($a, $b) {
            return strcmp($a['uri'], $b['uri']);
        });
        
        $result = false;
        foreach ($this->middlewares as $middleware) {
            if ($middleware['uri'] == substr( $this->uri, 0, strlen($middleware['uri']))) {
                $result = call_user_func_array($middleware['callback'], []);
                if ($result !== true) {
                    $this->display($result);
                    return;
                }
            }
        }

        // move default to bottom
        foreach ($this->routes as &$route) {
           $route['uri'] = str_replace('*','~',$route['uri']);
        }
        
        usort($this->routes,  function ($a, $b) {
            return strcmp($a['uri'], $b['uri']);
        });

        foreach ($this->routes as &$route) {
           $route['uri'] = str_replace('~','*',$route['uri']);
        }

        foreach ($this->routes as $route) {
            if ($this->method != $route['method']) continue;
            $uri_pattern = str_replace('/', '\/', $route['uri']);
            $uri_pattern = str_replace('*', '(.*)', $uri_pattern);
            $uri_pattern = preg_replace("/:([^:\/\\\\]+)/", "([^\/]+)", $uri_pattern);
            $uri_pattern = '/^'.$uri_pattern.'\/?$/';
            if(preg_match($uri_pattern, $this->uri, $matches) !== 0) {
                unset($matches[0]);
                $response = call_user_func_array($route['callback'], $matches);
                $this->display($response);
                break;
            }
        }        
    }
}
