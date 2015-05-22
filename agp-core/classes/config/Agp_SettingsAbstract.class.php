<?php
/**
 * Settings page abstract class
 */
abstract class Agp_SettingsAbstract extends Agp_ConfigAbstract {
    
    /**
     * Current page
     * 
     * @var striqng 
     */
    private $page;
    
    /** 
     * Tabs
     * 
     * @var array
     */
    private $tabs;
    
    /**
     * Fields 
     * 
     * @var array
     */
    private $fields;
    
    /**
     * Field Sets
     * 
     * @var array
     */
    private $fieldSet;
    
    /**
     * Current plugin settings
     * 
     * @var array
     */
    private $settings;
    
    
    /**
     * Constructor
     */
    public function __construct( $data ) {    
        parent::__construct($data);
        
        if (!empty($this->getConfig()->admin->options->page)) {        
            $this->page = $this->getConfig()->admin->options->page;
        }
        
        if (!empty($this->getConfig()->admin->options->tabs)) {        
            $this->tabs = $this->objectToArray($this->getConfig()->admin->options->tabs);
        }            
        
        if (!empty($this->getConfig()->admin->options->fields)) {        
            $this->fields = $this->objectToArray($this->getConfig()->admin->options->fields);
        }                    
        
        if (!empty($this->getConfig()->admin->options->fieldSet)) {        
            $this->fieldSet = $this->objectToArray($this->getConfig()->admin->options->fieldSet);
        }                            
       
        $this->settings = $this->getOptions();
        
        add_action( 'admin_init', array( $this, 'registerSettings' ) );        
        add_action( 'admin_menu', array( $this, 'adminMenu' ) ); 
        add_action( 'admin_notices', array( $this, 'customAdminNotices' ) ); 
    }

    /**
     * Create menu
     */
    public function adminMenu() {
        if (!empty($this->getConfig()->admin->menu)) {
            foreach ($this->getConfig()->admin->menu as $menu_slug => $page) {
                
                add_menu_page( $page->page_title, $page->menu_title, $page->capability, $menu_slug, $page->function, $page->icon_url, $page->position);
                
                if (!empty($page->submenu)) {
                    foreach ($page->submenu as $submenu_slug => $subpage) {                    
                        add_submenu_page( $menu_slug, $subpage->page_title, $subpage->menu_title, $subpage->capability, $submenu_slug, $subpage->function );
                    }
                }

                if (!empty($page->hideInSubMenu)) {
                    remove_submenu_page( $menu_slug, $menu_slug );            
                }                
            }
        }
    }
    
    /**
     * Register settings
     * 
     * @global string $pagenow
     */
    public function registerSettings () {
        if ($this->getTabs()) {        
            foreach ($this->getTabs() as $key => $value) {
                $function = !empty($value['sanitize']) ? $value['sanitize'] : array($this, 'sanitizeSettings');
                register_setting( $key, $key, $function ); 
            }    
        }    
        
        global $pagenow;
        if($pagenow == 'admin.php' && !empty($_REQUEST['page']) && $_REQUEST['page'] == $this->page && !empty($_REQUEST['reset-settings'])) {
            $this->resetSettings();
            wp_redirect(add_query_arg(array('is-reset' => 'true'), remove_query_arg('reset-settings')));
        }
    }
    
    /**
     * Sanitixe settings
     * 
     * @param array $input
     * @return array
     */
    public function sanitizeSettings($input) {
        if (!empty($input) && is_array($input)) {
            foreach ($input as $key => $value) {
                $field = $this->getFieldByName($key);
                if (!empty($field['type'])) {
                    switch ($field['type']) {
                        case 'checkbox':
                            $input[$key] = !empty($value) ? 1 : 0;    
                            break;
                        case 'text':
                        case 'colorpicker':
                            $input[$key] = stripslashes(esc_attr(trim($value)));    
                            break;                        
                        case 'textarea':                            
                            $input[$key] = $value;    
                            break;                                                
                        default:
                            break;
                    }
                }
            }            
        }
        return $input;
    }
    
    /**
     * Get field settings by name
     * 
     * @param string $fieldName
     * @return array
     */
    public function getFieldByName ($fieldName) {
        foreach($this->fields as $tab => $settings) {
            if (!empty($settings['fields'][$fieldName])) {
                return $settings['fields'][$fieldName];    
            }
        }
    }
    
    /**
     * Reset settings to default values
     */
    public function resetSettings () {
        if ($this->getTabs()) {        
            foreach ($this->getTabs() as $key => $value) {
                delete_option($key);
            }    
        }         
    }
    
    /**
     * Gets saved or default options
     * 
     * @return array
     */
    public function getOptions() {
        $fields = $this->getFields();        
        
        $result = array();
        if ($this->getTabs()) {        
            foreach ($this->getTabs() as $k => $v) {
                if (!empty($fields[$k])) {
                    foreach ($fields[$k]['fields'] as $dk => $dv) {
                        $options = get_option( $k );
                        if (!empty($options)) {
                            if ( isset( $options[$dk] ) ) {
                                $result[$k][$dk] = $options[$dk];                                
                            } elseif ( isset ( $dv['default'] ) ) {
                                $result[$k][$dk] = $dv['default'];
                            }   
                        } else {
                            if ( isset ( $dv['default'] ) ) {
                                $result[$k][$dk] = $dv['default'];
                            }                               
                        }
                    }                    
                }
            }    
        } 
        return $result;
    }
    
    /**
     * Page getter
     * 
     * @return string
     */
    public function getPage() {
        return $this->page;
    }

    /**
     * Tabs getter
     * 
     * @return array
     */
    public function getTabs() {
        return $this->tabs;
    }

    /**
     * Fields getter
     * 
     * @param string $key
     * @return array
     */
    public function getFields($key = NULL) {
        if (!empty($key)) {
            if (!empty($this->fields[$key])) {
                return $this->fields[$key];
            }
        } else {
            return $this->fields;
        }                
    }

    /**
     * FielSet getter 
     * 
     * @param string $key
     * @return array
     */
    public function getFieldSet($key = NULL) {
        if (!empty($key)) {
            if (!empty($this->fieldSet[$key])) {
                return $this->fieldSet[$key];
            }
        } else {
            return $this->fieldSet;
        }                        
    }

    /**
     * Settings getter
     * 
     * @param string $key
     * @return array
     */
    public function getSettings($key = NULL) {
        if (!empty($key)) {
            if (!empty($this->settings[$key])) {
                return $this->settings[$key];
            }
        } else {
            return $this->settings;
        }        
    }
    
    /**
     * Custom Notices
     * 
     * @global string $pagenow
     */
    public function customAdminNotices() {

        global $pagenow;

        if ( $pagenow == 'admin.php' && isset($_REQUEST['is-reset']) && !isset($_REQUEST['settings-updated']) && $_REQUEST['page'] == $this->page) {
            $message = 'Settings reset to default values';
            echo '<div class="updated settings-error" id="setting-error-settings_updated"><p><strong>'.$message.'</strong></p></div>';            
        }
    }        

}