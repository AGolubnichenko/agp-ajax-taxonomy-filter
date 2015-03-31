<?php

abstract class Agp_AjaxAbstract {
    
    /**
     * Constructor
     */
    public function __construct() {
        foreach (get_class_methods($this) as $action) {
            if ( !in_array($action, array('__construct', 'request', 'response' )) ) {
                add_action( "wp_ajax_$action" , array($this, 'request') );
                add_action( "wp_ajax_nopriv_$action", array($this, 'request'));
            }
        }        
    }
    
    /**
     * Request
     */
    public function request() {
        if (check_ajax_referer('ajax_atf_nonce', 'nonce', false)) {
            $data = $_POST;
            $action = $data['action'];
            if ( method_exists($this, $action) ) {
                $this->response($this->$action($data));
            }
        } else {
            http_response_code(500);
            die();
        }
    }
    
    /**
     * Response
     * 
     * @param array|object|string $data
     */
    public function response ($data) {
        if (is_array($data)) {
            echo json_encode($data);
        } elseif (is_object($data)) {
            echo json_encode(get_object_vars($data));    
        } else {
            echo $data;    
        }
        die();
    }
}
