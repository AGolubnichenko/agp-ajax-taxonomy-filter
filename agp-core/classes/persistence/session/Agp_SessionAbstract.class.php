<?php

class Agp_SessionAbstract {

    private $name;
    
    public function __construct() {
        if (!session_id()) {
            session_start();        
        }                                    

        $this->name = strtolower(get_class($this));
        
    }
    
    public function add ($key, $id, $value) {
        $data = array();
        if (!empty($_SESSION[$this->name][$key])) {
            $data = $_SESSION[$this->name][$key];
            if (is_serialized($data)) {
                $data = unserialize($data);
        }
        }
            
        $data[$id] = $value;
        $_SESSION[$this->name][$key] = serialize($data);            
    }
    
    public function set ($key, $value) {
        $_SESSION[$this->name][$key] = serialize($value);            
    }    
    
    public function get($key) {
        if (!empty($_SESSION[$this->name][$key])) {
            if (is_serialized($_SESSION[$this->name][$key])) {
                $res = unserialize($_SESSION[$this->name][$key]);
            } else {
                $res = $_SESSION[$this->name][$key];    
            }
            return $res;
        }
    }
    
    public function getAll() {
        $res = array();
        if (!empty($_SESSION[$this->name])) {        
            foreach ($_SESSION[$this->name] as $key => $value) {
                $res[$key] = $this->get($key);    
                
            }
            return $res;
        }
    }        
    
    public function reset($key = NULL) {
        if (!empty($key)) {
            unset($_SESSION[$this->name][$key]);                    
        } else {
            unset($_SESSION[$this->name]);
        }            
    }    
    
    public function exists($key) {
        return (!empty($_SESSION[$this->name][$key]));                    
    }
    
    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
        return $this;
    }
}