<?php

namespace Core\Router;

class Router {
	private $routes = [];
	
	private $uri = null;
	private $method = '';
	
	public function __construct($uri=null, $method=null) {
		$this->uri = $uri;
		$this->method = $method;
		if(empty($uri)) {
			$this->uri = strtok(@$_SERVER['REQUEST_URI'],'?')??"/";
		}
		
		if(empty($method)) {
			$this->method=@$_SERVER['REQUEST_METHOD']??'GET'; 
		}
	}
	public function route($uri, $callback=null, $method='GET') {
		$this->routes[] = [
			'uri' => $uri,
			'callback' => $callback,
			'method' => $method
		];
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
	
	public function execute() { 
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
