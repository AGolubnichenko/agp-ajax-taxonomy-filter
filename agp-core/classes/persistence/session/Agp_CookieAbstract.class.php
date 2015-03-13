<?php

class Agp_CookieAbstract {

    private $name;
    
    public function __construct() {
        $this->name = strtolower(get_class($this));
    }
    
    private function _setCookie ($key = NULL, $value = array()) {
        $cookie = $this->_getCookie();
        if (!empty($key)) {
            $cookie[$key] = $value;
        } else {
            $cookie = $value;
        }
        setcookie($this->name, serialize($cookie), 0, '/');                    
        $_COOKIE[$this->name] = serialize($cookie);
    }

    private function _getCookie ($key = NULL) {
        if (!empty($_COOKIE[$this->name])) {
            $cookie = unserialize(stripslashes($_COOKIE[$this->name]));
            if (!empty($cookie)) {
                if (!empty($key)) {
                    if (!empty($cookie[$key])) {
                        return $cookie[$key];    
                    }
                } else {
                    return $cookie;
                }                            
            }
        } else {
            return array();
        }
    }    
    
    public function add ($key, $id, $value) {
        $cookie = $this->_getCookie();
        $cookie[$key][$id] = $value;
        $this->_setCookie(NULL, $cookie);
    }
    
    public function set ($key, $value) {
        $this->_setCookie($key, $value);
    }    
    
    public function get($key) {
        return $this->_getCookie($key);
    }
    
    public function getAll() {
        return $this->_getCookie();
    }    
    
    public function reset($key = NULL) {
        $cookie = $this->_getCookie();        
        if (!empty($key)) {
            unset($cookie[$key]);                    
        } else {
            $cookie=array();
        }            
        $this->_setCookie(NULL, $cookie);
    }    
    
    public function exists($key) {
        $cookie = $this->_getCookie();                
        return (!empty($cookie[$key]));                    
    }
    
    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
        return $this;
    }
}