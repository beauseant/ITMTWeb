<?php

class Database extends SQLite3 {
    private $db;

    public function __construct($dbPath) {
        //check if the database file exists and create a new if not        
        if(is_file($dbPath)){
	    // connecting the dat abase
	    //$conn = new PDO('sqlite:'. $pathdb);        
            $this->db = new SQLite3($dbPath);
        }else {
            //create a new database
            $this->db = new SQLite3($dbPath);
        }
        $this -> db->enableExceptions( true );
    }

    public function fetchQuery ($query) {
        try {
            $result = $this->db->query($query);
            $data = [];
            while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
                $data[] = $row;
            }
        } catch (Exception $e) {
            $data = [];
        }
            return $data;
        
    }

    public function validUser ($login, $password) {
        $data = $this-> fetchQuery ('SELECT * FROM logins WHERE email = "'.$login.'"');
        // decrypt hashlib.sha256 (password)
        $password = hash('sha256', $password);

        if (count($data) == 0) {
            return false;
        }
        return $data[0]['password'] == $password;
    }


    public function createTable($tableName, $columns) {
        $query = "CREATE TABLE IF NOT EXISTS $tableName ($columns)";
        $this->db->exec($query);
    }

    public function insertData($tableName, $data) {
        $columns = implode(", ", array_keys($data));
        $values = "'" . implode("', '", array_values($data)) . "'";
        $query = "INSERT INTO $tableName ($columns) VALUES ($values)";
        $this->db->exec($query);
    }

    public function selectData($tableName, $condition = "") {
        $query = "SELECT * FROM $tableName";
        if (!empty($condition)) {
            $query .= " WHERE $condition";
        }
        $result = $this->db->query($query);
        $data = [];
        while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
            $data[] = $row;
        }
        return $data;
    }

    public function close() {
        $this->db->close();
    }
}


?>