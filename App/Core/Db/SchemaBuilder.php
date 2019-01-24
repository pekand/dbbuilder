<?php

namespace Core\Db;

/**
 * 
 */
class SchemaBuilder
{

	private $db = null;

	public function __construct($db, $filePath)
	{
		$this->db = $db;
		$this->filePath = $filePath;	
	}

	private function buildTable($tableName, $columns)
	{
		$query = "CREATE TABLE ".$tableName."(";

			$i = count($columns);
			foreach ($columns as $columnName => $value) {
				$query .= $value['name']." ".$value['type'];
				if (isset($value['primary']) && $value['primary'] == 1) {
					$query .= " PRIMARY KEY";
				}
				if (isset($value['notnull']) && $value['notnull'] == 1) {
					$query .= " NOT NULL";
				}
				if(--$i>0)$query .= ", ";
			}

			$query .= ");\n";

		return $query;
	}

	 public function buildAddColumnQuery($tableName, $column) {  

	 	$type = $column['type'];

	 	$primary = "";
	 	if (isset($column['primary']) && $column['primary'] == 1) {
			$primary = " PRIMARY KEY";
		}

		$notnull = "";
		if (isset($value['notnull']) && $value['notnull'] == 1) {
			$notnull .= " NOT NULL";
		}

        $query =  "ALTER TABLE `{$tableName}` ADD COLUMN ".$column['name']." {$type} {$primary} {$notnull};";
        return $query;
    } 

	private function buildCopyQuery($sourceTable, $destinationTable, $columnNames){
		$columnsList = implode ( "," , $columnNames );
		$query = "INSERT INTO {$destinationTable} ({$columnsList}) SELECT {$columnsList} FROM {$sourceTable};\n";
		return $query;
	}

	private function buildRemoveQuery($tableName){
		$query = "DROP TABLE {$tableName};\n";
		return $query;
	}

	private function buildRenameQuery($sourceTable, $destinationTable){
		$query = "ALTER TABLE {$sourceTable} RENAME TO {$destinationTable};\n";
		return $query;
	}

	public function build()
	{
		$query = [];

		$json = file_get_contents($this->filePath);
		$schemaRaw = json_decode($json, true);

		// reorder keys
		$schema = [];
		foreach ($schemaRaw['tables'] as $table) {
			$schema[$table['name']] = [];

			foreach ($table['columns'] as $column) {
				$schema[$table['name']][$column['name']] = $column;
			}
		}

		// get curent table names
		$currentTables = $this->db->get("SELECT name FROM sqlite_master WHERE type='table' and name!='sqlite_sequence';");

		// create list of current tables
		$oldTables = []; // tables in database
		foreach ($currentTables as $value) {
			$oldTables[] = $value['name'];
		}

		// create list of new tables
		$newTables = []; // tables in new schema
		foreach ($schema as $name => $value) {
				$newTables[] = $name;
		}

		$createTables = [];
		foreach ($newTables as $name) {
			if (!in_array($name, $oldTables)) {
				$createTables[] = $name;
			}
		}

		// create list of remove tables
		$removeTables = [];
		foreach ($oldTables as $name) {
			if (!in_array($name, $newTables)) {
				$removeTables[] = $name;
			}
		}

		foreach ($removeTables as $name) {
			$query[] = "/* Removing table {$name} */".$this->buildRemoveQuery($name);
		}

		foreach ($createTables as $name) {
			$query[] = "/* Creating table {$name} */".$this->buildTable($name, $schema[$name]);
		}

		// tables (can be modified)
		$sameTables = array_intersect($oldTables, $newTables);

		// create list of new columns
		$tempCounter = 0;
		$newColumns = [];
		$removeColumns = [];
		foreach ($sameTables as $name) {

			// get table structure
			$structureRaw = $this->db->get("PRAGMA table_info('".$name."') ");

			$structure = [];
			foreach ($structureRaw as $column) {
				$structure[$column['name']] = $column;
			}

			// get old columns from database
			$oldColumns = [];
			foreach ($structure as $column) {
				$oldColumns[] = $column['name'];
			}

			// get columns from file 
			$newColumns = [];
			foreach ($schema[$name] as $column) {
				$newColumns[] = $column['name'];
			}

			// get columns from file 
			$sameColumns = array_intersect($oldColumns, $newColumns);

			$removeColumns = [];
			foreach ($oldColumns as $columnName) {
				if (!in_array($columnName, $newColumns)) {
					$removeColumns[] = $columnName;
				}
			}

			$createColumns = [];
			foreach ($newColumns as $columnName) {
				if (!in_array($columnName, $oldColumns)) {
					$createColumns[] = $columnName;
				}
			}

			$updateColumns = [];
			foreach ($sameColumns as $columnName) {
				$canUpdate = false;

				if (@$structure[$columnName]['type'] != @$schema[$name][$columnName]['type']) {
					$canUpdate = true;
				}

				$left = (isset($schema[$name][$columnName]['notnull']) && $schema[$name][$columnName]['notnull'] == 1)? 1 : 0;
				$right = (isset($structure[$columnName]['notnull']) && $structure[$columnName]['notnull'] == 1)? 1 : 0;
				if ($left != $right) {
					$canUpdate = true;
				}

				if($canUpdate) {
					$updateColumns[] = $columnName;
				}
			}

			if(!empty($createColumns)) {
				foreach ($createColumns as $column) {
					$query[] = "/* New column {$column} */\n".$this->buildAddColumnQuery($name, $schema[$name][$column]); 
				}
			}

			// nothing to do continue
			if(empty($removeColumns) && empty($updateColumns)) {
				continue;
			}

			$queryCopy = "/* Update table {$name} */\n";
			foreach ($removeColumns as $value) {
				$queryCopy .=  "/* Missing column {$value} */\n";
			}

			foreach ($updateColumns as $value) {
				$queryCopy .= "/* Updated column {$value} */\n";
			}

			$tempTableName = "temp_".(++$tempCounter);
			//create temporary table
			$query[] = $queryCopy.$this->buildTable($tempTableName, $schema[$name]);
			//copy data
			$query[] = $this->buildCopyQuery($name, $tempTableName, $sameColumns);
			//remove old table
			$query[] = $this->buildRemoveQuery($name);
			//rename temporary table
			$query[] = $this->buildRenameQuery($tempTableName, $name);
		}

		foreach ($query as $command) {
			var_dump($command);
			$this->db->exec($command);
		}
		
	}
}