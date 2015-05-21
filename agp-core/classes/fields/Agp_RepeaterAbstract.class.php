<?php

abstract class Agp_RepeaterAbstract extends Agp_Module {
    
    private $id;
    
    private $title;
    
    private $screen; 
    
    private $context;
    
    private $layoutTemplateAdminName = 'admin/fields/repeater/layout';
    
    private $headerTemplateAdminName = 'admin/fields/repeater/header';
    
    private $rowTemplateAdminName = 'admin/fields/repeater/row';
    
    public function __construct($baseDir) {
        parent::__construct($baseDir);

        add_action( 'wp_enqueue_scripts', array($this, 'enqueueScripts' ));                
        add_action( 'admin_enqueue_scripts', array($this, 'enqueueAdminScripts' ));                
        add_action( 'add_meta_boxes', array( $this, 'addMetaboxes' ) );        
        add_action( 'save_post', array( $this, 'saveMetaboxes' ), 1, 2);        
        
    }
    
    public function init( $id, $title, $screen, $context ) {
        $this->id = $id;
        $this->title = $title;
        $this->screen = $screen;
        $this->context = $context;
    }
    
    public function enqueueScripts () {
        wp_enqueue_script( 'agp-core-repeater', $this->getAssetUrl('repeater/js/main.js'), array('jquery') );                                                         
        wp_enqueue_style( 'agp-core-repeater-css', $this->getAssetUrl('repeater/css/style.css') );  
    }        
    
    public function enqueueAdminScripts () {
        wp_enqueue_script( 'agp-core-repeater', $this->getAssetUrl('repeater/js/admin.js'), array('jquery') );                                                         
        wp_enqueue_style( 'agp-core-repeater-css', $this->getAssetUrl('repeater/css/admin.css') );  
    }                
    
    
    public function getLayoutTemplateAdmin($params = NULL) {
        if (!empty($this->id)) {        
            return $this->getTemplate($this->layoutTemplateAdminName, $params );
        }
    }    
    
    public function getHeaderTemplateAdmin($params = NULL) {
        if (!empty($this->id)) {        
            return $this->getTemplate($this->headerTemplateAdminName, $params );
        }
    }        
    
    public function getRowTemplateAdmin($params = NULL) {
        if (!empty($this->id)) {        
            return $this->getTemplate($this->rowTemplateAdminName, $params );
        }
    }            
    
    public function addMetaboxes() {
        if (!empty($this->id)) {
            add_meta_box($this->id, $this->title, array($this, 'viewMetabox') , $this->screen, $this->context);    
        }
    }

    
    public function viewMetabox( $post ) {
        if (!empty($this->id)) {        
            echo '<input type="hidden" name="'.  $this->id.'_noncename" id="'.  $this->id.'_noncename" value="' . wp_create_nonce( basename(__FILE__) ) . '" />';
            echo $this->getLayoutTemplateAdmin(array('obj' => $this, 'post_id' => $post->ID) );
        }
    }

    public function saveMetaboxes( $post_id, $post ) {
        if (!empty($this->id)) {
            
            if ( empty( $_POST[$this->id . '_noncename'] ) 
                || !wp_verify_nonce( $_POST[$this->id . '_noncename'],  basename(__FILE__) )
                || !current_user_can( 'edit_post', $post->ID ) ) {
                return $post->ID;
            }

            $data = $_POST[$this->id . '_data'];
            if (isset($data[0])) {
                unset($data[0]);
            }

            $meta[$this->id . '_data'] = serialize($data);

            foreach ($meta as $key => $value) {
                if( $post->post_type == 'revision' ) return;

                if ( !$value ) {
                    delete_post_meta($post->ID, $key); 
                } else {
                    update_post_meta($post->ID, $key, $value);
                }
            }   
        }
    }
    
    public function getData($post_id) {
        $data = array();
        if (!empty($this->id)) {
            $data = get_post_meta($post_id, $this->id .'_data', true);

            if (is_serialized($data)) {
                $data = unserialize($data);
            }    
        }
        return $data;        
    }
    
    public function getMaxRow($post_id) {
        if (!empty($this->id)) {
            $data = $this->getData($post_id);
            if (!empty($data) && is_array($data)) {
                return max(array_keys($data));    
            } else {
                return 1;
            }
        }
    }
    
    public function getId() {
        return $this->id;
    }

    public function getTitle() {
        return $this->title;
    }

    public function getScreen() {
        return $this->screen;
    }

    public function getContext() {
        return $this->context;
    }
    
    public function getLayoutTemplateAdminName() {
        return $this->layoutTemplateAdminName;
    }

    public function getHeaderTemplateAdminName() {
        return $this->headerTemplateAdminName;
    }

    public function getRowTemplateAdminName() {
        return $this->rowTemplateAdminName;
    }

    public function setLayoutTemplateAdminName($layoutTemplateAdminName) {
        $this->layoutTemplateAdminName = $layoutTemplateAdminName;
        return $this;
    }

    public function setHeaderTemplateAdminName($headerTemplateAdminName) {
        $this->headerTemplateAdminName = $headerTemplateAdminName;
        return $this;
    }

    public function setRowTemplateAdminName($rowTemplateAdminName) {
        $this->rowTemplateAdminName = $rowTemplateAdminName;
        return $this;
    }

}