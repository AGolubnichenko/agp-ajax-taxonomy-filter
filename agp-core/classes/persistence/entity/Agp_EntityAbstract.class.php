<?php

abstract class Agp_EntityAbstract {

    private $id;
    
    public function __construct($data, $default = array()) {
        if (is_object($data)) {
            $data = get_object_vars($data);    
        }
        
        if (is_array($data)) {
            $data = array_merge($default, $data);

            if (!empty($data) && (array_key_exists('ID', $data) || array_key_exists('id', $data)) ) {
                foreach ($data as $key => $value) {
                    if ($key == 'ID' || $key == 'id') {
                        $this->id = $value;
                    } else {
                        $setterName = 'set' . ucfirst($key);
                        if ( method_exists( $this, $setterName ) ) {
                            $this->$setterName($value);
                        }
                    }
                }
            }            
        }
    }
    
    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
        return $this;
    }
}
