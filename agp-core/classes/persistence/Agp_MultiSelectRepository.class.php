<?php

class Agp_MultiSelectRepository extends Agp_RepositoryAbstract {

    /**
     * Object Name
     * 
     * @var string
     */
    private $name;

    /**
     * Session Object
     * 
     * @var Agp_Session
     */
    private $session;
    
    public function __construct($data = NULL) {
        $this->name = strtolower(get_class($this));                
        $this->session = Agp_Session::instance(); 

        parent::__construct($data);
    }
    
    public function init () {
//        if ($this->getActiveCount() == 0) {
//            $this->addActive($this->getFirst());
//        }                    
    }    
    
    public function addActive (Agp_EntityAbstract $entity) {
        if (!empty($entity)) {
            $this->addActiveById($entity->getId());            
        }        
    }

    public function addActiveById ($id) {
        if (isset($id)) {
            if (!$this->isActiveById($id)) {
                $this->getSession()->add($this->name, $id, $id);                   
            }            
        }        
    }    
    
    public function addActiveAll () {
        $data = $this->getAll();
        if (!empty($data) && is_array($data)) {
            foreach ($data as $entity) {
                $this->addActive($entity);
            }
        }
    }            

    public function deleteActive (Agp_EntityAbstract $entity) {
        if (!empty($entity)) {        
            $this->deleteActiveById($entity->getId());
        }
    }
    
    public function deleteActiveById ($id) {
        $activeList = $this->getSession()->get($this->name);
        if (!empty($activeList) && is_array($activeList) && array_key_exists($id, $activeList)) {        
            unset($activeList[$id]);
            $activeList = $this->getSession()->set($this->name, $activeList);
        }        
    }    
    
    public function deleteActiveAll () {
        $data = $this->getAll();
        if (!empty($data) && is_array($data)) {
            foreach ($data as $entity) {
                $this->deleteActive($entity);
            }
        }
    }                

    public function toggleActive (Agp_EntityAbstract $entity) {
        if (!empty($entity)) {
            $this->toggleActiveById($entity->getId());
        }
    }    

    public function toggleActiveById ($id) {
        if (isset($id)) {
            if ($this->isActiveById($id)) {
                $this->deleteActiveById($id);
            } else {
                $this->addActiveById($id);
            }                
        }
    }        
    
    public function toggleActiveAll () {
        $data = $this->getAll();
        if (!empty($data) && is_array($data)) {
            foreach ($data as $entity) {
                $this->toggleActive($entity);
            }
        }        
    }
    
    public function getActiveAll () {
        $activeList = $this->getSession()->get($this->name);
        $result = array();
        if (!empty($activeList) && is_array($activeList)) {
            foreach($activeList as $key => $value) {
               $result[$key] = $this->findById($key);
            }
            return $result;            
        }
    }    
    
    public function getActiveById ($id) {
        $activeList = $this->getSession()->get($this->name);
        if (!empty($activeList) && is_array($activeList) && array_key_exists($id, $activeList)) {        
            return $this->findById($id);
        }
    }        
    
    public function getActiveCount() {
        return count($this->getActiveAll());
    }
    
    public function isActive (Agp_EntityAbstract $entity) {
        if (!empty($entity)) {
            return $this->isActiveById($entity->getId());        
        }        
    }            
    
    public function isActiveById ($id) {
        $entity = $this->getActiveById($id);
        return !empty($entity);
    }                
    
    /**
     * Getters and Setters
     */ 
    
    public function getName() {
        return $this->name;
    }

    public function getSession() {
        return $this->session;
    }

    public function setName($name) {
        $this->name = $name;
        return $this;
    }

    public function setSession(Agp_Session $session) {
        $this->session = $session;
        return $this;
    }
    
}
