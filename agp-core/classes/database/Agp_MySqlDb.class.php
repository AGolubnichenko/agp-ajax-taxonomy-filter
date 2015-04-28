<?php

class Agp_MySqlDb extends Agp_DbAbstract {
    
    private $db;

    private $host;
    
    private $database;
    
    private $user;
    
    private $password;

    public function __construct($host, $database, $user, $password) {
        $this->host=$host;
        $this->database=$database;
        $this->user=$user;
        $this->password=$password;
    }   
    
    public function connect() {
        $this->db = @new mysqli($this->host, $this->user, $this->password, $this->database);        
        return $this->db->connect_errno;
    }    
    
    public function disconnect() {
        if (isset($this->db)) {
            @$this->db->close();
            $this->db = NULL;
        }
    }    

    public function query($sql) {
        $queryResult = $this->db->query($sql);
        
        $result = array();                            
        if ($queryResult) {
            while($row = $queryResult->fetch_assoc()) {
                $result[] = $row;
            }                
            $queryResult->close();
        }

        return $result;
    }
    
    public function getDb() {
        return $this->db;
    }

    public function getHost() {
        return $this->host;
    }

    public function getDatabase() {
        return $this->database;
    }

    public function getUser() {
        return $this->user;
    }

    public function getPassword() {
        return $this->password;
    }
}
