<?php

namespace Core\Router;

class JsonResponse { 
	
	private $data = null;
	
	public function __construct($data) {
        $this->data = $data;
    }
    
    public function render() {
    	header('Content-type: application/json');
		echo json_encode($this->data);
    }
}