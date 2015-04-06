<?php

abstract class Agp_Module {
    /**
     * Base module directory
     * 
     * @var string
     */
    private $baseDir;
    
    /**
     * Default template directory
     * 
     * @var string 
     */
    private $defaultTemplateDir;
    
    /**
     * Current template directory
     * 
     * @var string 
     */
    private $templateDir;
    
    
    /**
     * Module name
     * 
     * @var string 
     */
    private $moduleName;
    
    
    /**
     * Default assets directory
     * 
     * @var string
     */
    private $defaultAssetDir;
    
    /**
     * Current assets directory
     * 
     * @var string 
     */
    private $assetDir;
    
    
    /**
     * Constructor
     */
    public function __construct($baseDir) {
        $this->baseDir = $baseDir;
        $this->moduleName = basename( $this->baseDir );        
        $this->defaultTemplateDir = $this->baseDir . '/templates';
        $this->defaultAssetDir = $this->baseDir . '/assets';
        $this->templateDir = get_stylesheet_directory() . '/templates/'. $this->moduleName;
        $this->assetDir = $this->templateDir . '/assets';
    }

    /**
     * Gets template content
     * 
     * @param string $name
     * @param string|array $params
     * @return string
     */
    public function getTemplate($name, $params = NULL) {
        ob_start();
        $template = $this->templateDir . '/' . $name . '.php';
        $defaultTemplate = $this->defaultTemplateDir . '/' . $name . '.php';
        if ( file_exists($template) && is_file($template) ) {
            include ($template);
        } elseif (file_exists($defaultTemplate) && is_file($defaultTemplate) ) {
            include ($defaultTemplate);
        }
        $result = ob_get_clean();
        return $result;
    }    

    /**
     * Get asset Url
     * 
     * @param string $name
     * @return string
     */
    public function getAssetUrl($name = NULL) {
        $resultPath = $this->baseDir;
        
        if (empty($name)) {
            if (file_exists($this->assetDir) && is_dir($this->assetDir)) {
                $resultPath = $this->assetDir;        
            } elseif (file_exists($this->defaultAssetDir) && is_dir($this->defaultAssetDir)) {
                $resultPath = $this->defaultAssetDir;        
            }
        } else {
            $asset = $this->assetDir . '/' . $name;
            $defaultAsset = $this->defaultAssetDir . '/' . $name;            
            if ( file_exists($asset) && is_file($asset) ) {
                $resultPath = $asset;
            } elseif ( file_exists($defaultAsset) && is_file($defaultAsset) ) {
                $resultPath = $defaultAsset;
            }
        }
        
        return $this->toUrl($resultPath);
    }
    
    /**
     * Gets debug information
     * 
     * @param all $var
     */
    static public function debug ($var, $echo = true) {
        if (!$echo) {
            ob_start();
        }
        print_r('<pre>');
        print_r($var);
        print_r('</pre>');
        if (!$echo) {
            $result = ob_get_clean();
            return $result;
        }        
    }

    /**
     * Gets url for the specified file path
     * 
     * @param string $file
     * @return string
     */    
    public function toUrl($file = '') {
        // Get correct URL and path to wp-content
        $content_url = untrailingslashit( dirname( dirname( get_stylesheet_directory_uri() ) ) );
        $content_dir = untrailingslashit( dirname( dirname( get_stylesheet_directory() ) ) );    

        // Fix path on Windows
        $file = str_replace( '\\', '/', $file );
        $content_dir = str_replace( '\\', '/', $content_dir );
        return str_replace( $content_dir, $content_url, $file );            
    }
    
    /**
     * Gets curent URL
     * 
     * @global type $wp
     * @return type
     */
    public function getCurrentUrl() {
        global $wp;
        return add_query_arg( $_SERVER['QUERY_STRING'], '', home_url( $wp->request ) );         
    }    
    
    /**
     * Gets base URL
     * 
     * @return type
     */
    public function getBaseUrl() {
        return $this->toUrl($this->baseDir);
    }
    
    /**
     * Getters and Setters
     */ 

    public function getBaseDir() {
        return $this->baseDir;
    }

    public function getDefaultTemplateDir() {
        return $this->defaultTemplateDir;
    }

    public function getTemplateDir() {
        return $this->templateDir;
    }

    public function getModuleName() {
        return $this->moduleName;
    }

    public function setBaseDir($baseDir) {
        $this->baseDir = $baseDir;
        return $this;
    }

    public function setDefaultTemplateDir($defaultTemplateDir) {
        $this->defaultTemplateDir = $defaultTemplateDir;
        return $this;
    }

    public function setTemplateDir($templateDir) {
        $this->templateDir = $templateDir;
        return $this;
    }

    public function setModuleName($moduleName) {
        $this->moduleName = $moduleName;
        return $this;
    }

    public function getDefaultAssetDir() {
        return $this->defaultAssetDir;
    }

    public function getAssetDir() {
        return $this->assetDir;
    }

    public function setDefaultAssetDir($defaultAssetDir) {
        $this->defaultAssetDir = $defaultAssetDir;
        return $this;
    }

    public function setAssetDir($assetDir) {
        $this->assetDir = $assetDir;
        return $this;
    }
}
