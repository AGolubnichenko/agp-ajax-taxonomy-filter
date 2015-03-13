<?php

class Agp_Autoloader {

    /**
     * Class map
     * 
     * @var array 
     */
    private $classMap = array(
        __DIR__ => array(''),
    );
    
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
     * Constructor
     */
    public function __construct() {
        spl_autoload_register(array( $this, 'autoload' ));
    }
    
    /**
     * Class autoload
     * 
     * @param string $class
     */
    private function autoload($class) {
        if (!class_exists($class) && !empty($this->classMap)) {
            foreach ($this->classMap as $path => $value) {
                $maps = array();
                if (is_array($value)) {
                    $maps = $value;
                } else {
                    $maps[] = $value;
                }
                foreach ($maps as $map) {
                    $file = $path . '/' . $map .'/' . $class . '.class.php';
                    $file = str_replace('//', '/', $file);
                    $files = $this->rglob($file) ;
                    if (!empty($files) && is_array($files) && file_exists($files[0]) && is_file($files[0])) {
                        require_once $files[0];
                        return;
                    }                                    
                }
            }
        }        
    }
    
    /**
     * Recursive file search
     * 
     * @param string $pattern
     * @param int $flags
     * @return array
     */
    private function rglob($pattern, $flags = 0) {
        $files = glob($pattern, $flags); 
        foreach (glob(dirname($pattern).'/*', GLOB_ONLYDIR|GLOB_NOSORT) as $dir) {
            $files = array_merge($files, $this->rglob($dir.'/'.basename($pattern), $flags));
        }
        return $files;
    }      

    public function getClassMap() {
        return $this->classMap;
    }

    public function setClassMap($classMap) {
        if (is_array($classMap)) {
            $this->classMap = array_merge($this->classMap, $classMap);
        }
        
        return $this;
    }


}

Agp_Autoloader::instance();
