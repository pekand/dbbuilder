<?php

namespace Core\Db;

class Sqlite {
    public $db = null;

    public function open($path) {
        $this->db = new \SQLite3($path);

        if(!$this->db){
          throw new Exception('db is not open');
        }

        $this->db->enableExceptions(true);
    }

    public function exec($query, $data = array()) {
        $statement = $this->db->prepare($query);

        if (empty($statement)) {
            return null;
        }

        if(!empty($data)) {
            foreach ($data as $key => $value) {
                $statement->bindValue(':'.$key, $value);
            }
        }

        $result = $statement->execute();

        if(!$result){
          throw new Exception($this->db->lastErrorMsg());
        }

        return $result;
    }

    public function get($query, $data = array()) {
        $result =  $this->exec($query, $data);

        if (empty($result)) {
            return null;
        }

        $data = array();
        while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
            $data[] = $row;
        }

        return $data;
    }

    public function create($table) {
        $query ="CREATE TABLE IF NOT EXISTS `$table` ( id integer PRIMARY KEY AUTOINCREMENT NOT NULL );";

        $this->exec($query);
    }

    public function addColumn($table, $name, $type, $mod = "") {
        $this->exec("ALTER TABLE `{$table}` ADD COLUMN {$name} {$type} {$mod};");
    }

    public function rename($table, $newName) {
        $this->exec("ALTER TABLE `{$table}` RENAME TO '{$newName}';");
    }

    public function uid()
    {
        return hash('sha256', time().mt_rand());
    }

    public function insert($table, $data = array()) {

        $columnNames = implode(",", array_keys($data));
        $columnValues = implode(",", array_map(function($value) { return ':'.$value; }, array_keys($data)));

        $query ="INSERT INTO `$table` ( {$columnNames} ) VALUES ( {$columnValues} );";

        $this->exec($query, $data);

        return $this->db->lastInsertRowID();
    }

    public function update($table, $id, $data = array()) {

        $columnValues = implode(",", array_map(function($value) { return $value.' = :'.$value; }, array_keys($data)));

        $query ="UPDATE `$table` SET {$columnValues} WHERE id=:id;";

        $this->exec($query, $data);
    }

    public function delete($table, $id) {
        $query = "DELETE FROM `$table` WHERE id=:id;";

        $this->exec($query, array('id' => $id));
    }

    public function drop($table) {
        $this->exec("DROP TABLE IF EXISTS `$table`;");
    }

    public function schema() {
        return $this->get("SELECT * FROM `sqlite_master` WHERE type='table';");
    }

    public function dump($table) {
        return $this->get("SELECT * FROM `{$table}`;");
    }

    public function list() {
        $tables = $this->get("SELECT name FROM sqlite_master WHERE type='table';");

        $data = [];
        foreach ($tables as $table) {
            $content = $this->get("SELECT * FROM ".$table['name']);
            $data[$table['name']] = $content;
        }
        return $data;
    }
}
