<?php

namespace Core\Router;

class Response { 
	$data = "";
	public function __construct($data) {
        $this->$data = $data;
    }
    
    public function render() {
    	echo $this->$data;
    }
}