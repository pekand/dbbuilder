<?php

namespace Core\Router;

class Router {
    private $app = null;
    private $routes = [];
    private $middlewares = [];
    
    private $uri = null;
    private $method = '';
    
    public $urlparams = [];
    
    public function __construct($app) {
        $this->app = $app;
        $this->uri = $this->app->services->get('request')->uri();
        $this->method = $this->app->services->get('request')->method();
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
            return;
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
    
    public function load() {
        $app = $this->app;
        $router = $this->app->router;
        $services = $this->app->services;

        foreach (array_filter(glob(ROOT_PATH . '/Modules/*'), 'is_dir') as $module) {
            $path = $module . '/Routers/*Router.php';

            foreach (glob($path) as $routerFile) {
                include $routerFile;
            }
        }        
    }
    
    public function execute($method = null, $uri = null) { 
        global $services;
        
        if(empty($method)) {
            $method =  $this->method;
        }
        
        if(empty($uri)) {
            $uri =  $this->uri;
        }
        
        usort($this->middlewares,  function ($a, $b) {
            return strcmp($a['uri'], $b['uri']);
        });
        
        $result = false;
        foreach ($this->middlewares as $middleware) {
            if ($middleware['uri'] == substr($uri, 0, strlen($middleware['uri']))) {
                $result = call_user_func_array($middleware['callback'], [$this->app]);
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
            if ($method != $route['method']) continue;
            $uri_pattern = str_replace('/', '\/', $route['uri']);
            $uri_pattern = str_replace('*', '(.*)', $uri_pattern);
            $uri_pattern = preg_replace("/:([^:\/\\\\]+)/", "([^\/]+)", $uri_pattern);
            $uri_pattern = '/^'.$uri_pattern.'\/?$/';
            if(preg_match($uri_pattern, $uri, $matches) !== 0) {
                unset($matches[0]);
                $this->urlparams = $matches;
                $response = call_user_func_array($route['callback'], array_merge([$this->app],$matches));
                $this->display($response);
                break;
            }
        }        
    }
}
