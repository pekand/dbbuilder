<?php

namespace DbConsole\DbConsole;

use Core\Db\MySQL;

class DbConsole { 
	public function processQuery($database, $query){
		$db = new MySQL("127.0.0.1", "root", "", $database);

		$result = null;
		$error = null;
		try {
			$result = $db->get($query);
		} catch (Exception $e) {
			$error= $e->getMessage();
		}
		
		return ["result"=>$result, 'error' => $error];
	}
}