<?php

class Atf extends Agp_Module {

    /**
     * Ajax Object
     * 
     * @var Atf_Ajax
     */
    private $ajax;
    
    /**
     * Session Object
     * 
     * @var Agp_Session
     */
    private $session;

    
    /**
     * Widget Repository
     * 
     * @var Atf_WidgetRepository
     */
    private $widgetRepository;        
    
    
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
    
    public function __construct() {
        parent::__construct(dirname(dirname(__FILE__)));

        $this->session = Agp_Session::instance();        
        $this->ajax = Atf_Ajax::instance();
        $this->widgetRepository = new Atf_WidgetRepository();
        
        add_shortcode( 'atf', array($this, 'doAtfShortcode') ); 
        add_action( 'pre_get_posts', array($this, 'preGetPosts' ) );        
        add_action( 'init', array($this, 'init' ), 999 );        
        add_action( 'wp_enqueue_scripts', array($this, 'enqueueScripts' ));                
        add_action( 'widgets_init', array($this, 'initWidgets' ));
    }
    
    public function init () {
        $this->widgetRepository->refreshRepository();
    }

    
    public function enqueueScripts () {
        wp_enqueue_script( 'atf', $this->getAssetUrl('js/main.js'), array('jquery') );                                                         
        wp_localize_script( 'atf', 'ajax_atf', array( 
            'base_url' => site_url(),         
            'ajax_url' => admin_url( 'admin-ajax.php' ), 
            'ajax_nonce' => wp_create_nonce('ajax_atf_nonce'),        
        ));  

        wp_enqueue_style('atf-css', $this->getAssetUrl('css/style.css'));                    
    }        
    
    public function initWidgets() {
        register_widget('Atf_TaxonomyWidget');
    }
    
    public function preGetPosts ($query) {
        $widgets = Atf()->getWidgetRepository()->getAll();
        if (!empty($widgets)) {
            foreach ($widgets as $widget) {
                $settings = $widget->getSettings();
                
                if  ($query->is_main_query()) {
                    $queried_object = $query->get_queried_object();
                    if (!empty($queried_object) && !empty($queried_object->term_id)) {
                        $widget->getTaxonomyRepository()->deleteActiveAll();                        
                        $entity = $widget->getTaxonomyRepository()->findById($queried_object->term_id);        
                        if (!empty($entity)) {
                            $widget->getTaxonomyRepository()->addActive($entity);
                        }                        
                    }
                } 
                
                if ($query->is_post_type_archive() && !$settings->getIs_ajax()) {
                    $widget->getTaxonomyRepository()->deleteActiveAll();
                }                            

                if ($query->is_post_type_archive($settings->getPost_type()) && $widget->getTaxonomyRepository()->getActiveCount() > 0) {
                    $ids=array();                
                    $activeList = $widget->getTaxonomyRepository()->getActiveAll();
                    if (!empty($activeList) && is_array($activeList)) {
                        foreach ($activeList as $entity) {
                            if (!empty($entity) && $entity->getTerm_id() > 0) {
                                $ids[] = $entity->getTerm_id();    
                            }                    
                        }                    
                    }

                    if (!empty($ids)) {
                        $taxquery = $query->get('tax_query');

                        if (empty($taxquery)) {
                            $taxquery = array();    
                        } else {
                            if (empty($taxquery['relation'])) {
                                $taxquery['relation'] = 'AND';
                            }    
                        }

                        $taxquery[] = array(
                            'taxonomy' => $settings->getTaxonomy(),
                            'field' => 'id',
                            'terms' => $ids,
                            'operator'=> 'IN'
                        );

                        $query->set( 'tax_query', $taxquery );    
                    }
                }                    
            }
        }
    }
    
    public function doAtfShortcode($atts) {
        if (!empty($atts['is_ajax'])) {
            $atts['is_ajax'] = ($atts['is_ajax'] == 'true' || $atts['is_ajax'] == 1) ? 1 : 0;
        }
        
        $atts = shortcode_atts( array(
            'taxonomy' => 'category',    
            'post_type' => 'post',
            'is_ajax' => 0,
            'is_multi_select' => 0,
            'content_selector' => '',
            'template' => 'atf',
        ), $atts );
        
        if (!empty($atts['taxonomy']) && !empty($atts['post_type'])) {
            //return $this->getTemplate($atts['template']);                
            //the_widget
        }
    }    

    public function getWidgetRepository() {
        return $this->widgetRepository;
    }

    public function setWidgetRepository(Atf_WidgetRepository $widgetRepository) {
        $this->widgetRepository = $widgetRepository;
        return $this;
    }
}