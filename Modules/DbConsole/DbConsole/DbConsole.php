<?php

namespace DbConsole\DbConsole;

class DbConsole { 
	private $app = null;
    
    public function __construct($app) {
        $this->app = $app;
    }
    
	public function processQuery($databaseName, $query){
		$db = $this->app->get('mysql');
		
		if(!empty($databaseName))
		{
			$db->use($databaseName);
		}

		$result = null;
		$error = null;
		try {
			$result = $db->get($query);
		} catch (\Exception $e) {
			$error= $e->getMessage();
		}
		
		return ["result"=>$result, 'error' => $error];
	}
}