<?php

class Agp_SingleSelectRepository extends Agp_RepositoryAbstract {

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
        $activeEntity = $this->getActive();                
        if (empty($activeEntity)) {
            $this->setActive($this->getFirst());
        }                    
    }    
    
    public function setActive (Agp_EntityAbstract $entity) {
        if (!empty($entity)) {
            $activeEntity = $this->getActive();        
            if (empty($activeEntity) || $activeEntity->getId() != $entity->getId()) {
                $this->resetActive();
                $this->getSession()->set($this->name, $entity->getId());                    
                $this->init();                
            }                
        }
    }
    
    public function getActive () {
        $id = $this->getSession()->get($this->name);
        if (!empty($id)) {
            return $this->findById($id);
        }            
    }
    
    public function resetActive () {
        $activeEntity = $this->getActive();        
        if (!empty($activeEntity)) {        
            $this->getSession()->reset($this->name);                
        }            
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
