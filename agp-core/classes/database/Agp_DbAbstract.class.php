<?php

abstract class Agp_DbAbstract {
    
    abstract public function connect(); 
    
    abstract public function disconnect();     
    
    abstract public function query($sql);
    
    public function execSql($sql) {
        $errNo = $this->connect();
        if ( $errNo == 0) {
            $result = $this->query($sql);
            $this->disconnect();
            return $result;
        } else {
            $this->disconnect();
            throw new Agp_DbConnectException('Cannot establish connection to database.', $errNo);
        }
    }
}
