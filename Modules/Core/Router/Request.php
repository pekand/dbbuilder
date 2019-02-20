<?php

namespace Core\Router;

class Request { 
	public function __construct() {
        
    }
    
    public function get($name) {
		if(isset($_GET[$name])) {
			return $_GET[$name];
		}
		
		return null;
	}
	
	public function post($name) {
		if(isset($_POST[$name])) {
			return $_POST[$name];
		}
		
		return null;
	}
	
	public function uri() {
		if (!empty($_SERVER['REQUEST_URI'])) {
			return  trim(strtok($_SERVER['REQUEST_URI'],'?')??"/");
		}
		return null;
	}
	
	public function method() {
		if (!empty($_SERVER['REQUEST_METHOD'])) {
			return  @$_SERVER['REQUEST_METHOD']??'GET'; 
		}
		return null;
	}
}