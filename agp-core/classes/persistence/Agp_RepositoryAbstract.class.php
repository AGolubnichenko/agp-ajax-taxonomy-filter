<?php

abstract class Agp_RepositoryAbstract {
    private $data;
    
    public $entityClass = '';    
    
    public function __construct($data = NULL) {
        $this->refresh($data);
    }
   
    abstract public function init();

    public function refresh($data = NULL) {
        $this->deleteAll();        
        if ($this->entityClass && !empty($data) && is_array($data)) {
            foreach ($data as $value) {
                $this->add(new $this->entityClass($value));
            }                    
            $this->init();
        }        
    }

    
    public function add(Agp_EntityAbstract $entity) {
        if (!isset($this->data[$entity->getId()])) {
            $this->data[$entity->getId()] = $entity;    
        }
    }
    
    public function delete($id) {
        if (isset($this->data[$id])) {
            unset($this->data[$id]);
        }
    }        
    
    public function deleteAll() {
        unset($this->data);
        $this->data = array();
    }            
    
    public function findById ($id) {
        return $result = &$this->data[$id];
    }
    
    public function getAll () {
        return $result = &$this->data;
    }

    public function getFirst () {
        if (!empty($this->data)) {
            $data = &$this->data;
            return $result = reset($data);    
        }
    }    
    
    public function getCount () {
        return count($this->data);
    }    
}
