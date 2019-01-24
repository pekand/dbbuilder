<?php 
namespace Core\Db;

use PDO;

class MySQL { 

    private $dbname = null;
    public $db = null; 
    
    public function __construct($servername = "127.0.0.1", $username = "root", $password = "", $dbname = "") {
        $this->open($servername, $username, $password, $dbname);
    }
    
    public function open($servername, $username, $password, $dbname) { 
        $this->dbname = $dbname;
        $this->db = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $username, $password);
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } 
    
    public function exec($query, $data = array()) { 
        $statement = $this->db->prepare($query);
        
        if(!empty($data)) {
            foreach ($data as $key => $value) {
                $statement->bindValue(':'.$key, $value);
            }
        }
        
        try {
            $result = $statement->execute();
        }catch(PDOException $e){
            throw new \Exception($e->getMessage());
        }

        if(!$result){
          throw new \Exception($this->db->lastErrorMsg());
        } 
        
        return $statement;
    } 
    
    public function get($query, $data = array()) { 
        $result =  $this->exec($query, $data);

        $data = array();
        while ($row = $result->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT)) {
            $data[] = $row;      
        }

        return $data;
    } 
    
    public function getValue($query, $data = array()) { 
        $value = $this->get($query, $data);

        while(is_array($value)) {
            $value = reset($value);
        }
        
        return $value;
    } 
              
    public function create($table) { 
        $query ="CREATE TABLE IF NOT EXISTS `$table` ( id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY );";

        $this->exec($query);
    } 
    
    public function addColumn($table, $name, $type, $mod = "") {     
        $this->exec("ALTER TABLE `{$table}` ADD COLUMN {$name} {$type} {$mod};");
    } 
    
    public function rename($table, $newName) {     
        $this->exec("RENAME TABLE `{$table}` TO `{$newName}`;");
    } 
    
    public function uid() 
    {
        return uniqid();
    }
    
    public function insert($table, $data = array()) { 
        
        $columnNames = implode(",", array_keys($data));
        $columnValues = implode(",", array_map(function($value) { return ':'.$value; }, array_keys($data)));

        $query ="INSERT INTO `$table` ( {$columnNames} ) VALUES ( {$columnValues} );";

        $this->exec($query, $data);    
        
        return $this->db->lastInsertId();
    } 
    
    public function update($table, $id, $data = array()) { 
        
        $columnValues = implode(",", array_map(function($value) { return $value.' = :'.$value; }, array_keys($data)));

        $data['id'] = $id;
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
        
        $data = [];
        $tables = $this->get("SELECT table_name FROM information_schema.tables where table_schema='".$this->dbname."'");
        foreach ($tables as $table) {;
            $data[] = $this->get("SHOW CREATE TABLE `".$table[0]."`");
        }
        return $data;
    } 
    
    public function dump($table) {     
        return $this->get("SELECT * FROM `{$table}`;");
    } 
    
    public function quote($text) {     
        return $this->db->quote($text);
    } 
    
    
} 
/*
try {
    $sql = new SQL();
    $sql->open();
    $sql->drop('test');
    $sql->drop('test2');
    $sql->create('test');
    $sql->addColumn('test', 'uid', 'text', 'not null default ""');
    var_dump($sql->insert('test', array('id' => "1", 'uid' => $sql->uid())));
    var_dump($sql->dump('test'));
    $sql->update('test', "1", array('uid' => $sql->uid()));
    var_dump($sql->dump('test'));
    $sql->delete('test', 1);
    var_dump($sql->dump('test'));
    var_dump($sql->schema());
    $sql->rename('test', 'test2');
    var_dump($sql->schema());
    $sql->drop('test');
    var_dump($sql->schema());
}
catch(PDOException $e)
{
    echo "Error: " . $e->getMessage();
}*/