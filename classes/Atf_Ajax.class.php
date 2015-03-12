<?php

class Atf_Ajax extends Agp_AjaxAbstract {
    /**
     * The single instance of the class 
     * 
     * @var object
     */
    protected static $_instance = null;    
    
	/**
	 * Main Instance
	 *
     * @return object
	 */
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}    
    
	/**
	 * Cloning is forbidden.
	 */
	public function __clone() {
	}

	/**
	 * Unserializing instances of this class is forbidden.
	 */
	public function __wakeup() {
    }        
    
    /**
     * setActiveTerm Action
     */
    public function setActiveTerm($data) {
        $term_id = $data['term_id'];
        $id = $data['name'];
        $widget = Atf()->getWidgetRepository()->findById($id);
        if (!empty($widget)) {
            $entity = $widget->getTaxonomyRepository()->findById($term_id);
            if (!empty($entity)) {
                $settings = $widget->getSettings();    
                if ($settings->getIs_multi_select()) {
                    $widget->getTaxonomyRepository()->toggleActive($entity);    
                } else {
                    $widget->getTaxonomyRepository()->deleteActiveAll();
                    $widget->getTaxonomyRepository()->addActive($entity);    
                }
            }            
        }
    }
}
