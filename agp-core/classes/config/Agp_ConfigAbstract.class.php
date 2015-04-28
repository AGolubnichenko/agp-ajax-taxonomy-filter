<?php

abstract class Agp_ConfigAbstract {

    protected $data;
    
    /**
     * Constructor
     */
    public function __construct( array $data ) {    
        $this->data = $data;
    }
    
    /**
     * Convert an array into a stdClass()
     * 
     * @param   array   $array  The array we want to convert
     * 
     * @return  object
     */
    protected function arrayToObject($array) {
        
        // First we convert the array to a json string
        $json = json_encode($array);

        // The we convert the json string to a stdClass()
        $object = json_decode($json);

        return $object;
    }


    /**
     * Convert a object to an array
     * 
     * @param   object  $object The object we want to convert
     * 
     * @return  array
     */
    protected function objectToArray($object) {
        
        // First we convert the object into a json string
        $json = json_encode($object);

        // Then we convert the json string to an array
        $array = json_decode($json, true);

        return $array;
    }    
 
    
    public function applyData (array $data) {
        
        $this->data = array_merge($this->data, $data);
    }
    
    public function getConfig() {
        
        return $this->arrayToObject($this->data);
    }
   
}