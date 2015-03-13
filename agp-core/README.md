# AGP Plugins Core

Collection of a base classes for custom WordPress plugins

# Installation

1. Download a copy of the plugin
2. Upload "agp-core" to the "/wp-content/plugins/" directory
3. Activate the plugin through the "Plugins" menu in WordPress

# Include in a plugin / theme

1. Download a copy of the plugin
2. Copy the plugin to your theme / plugin
3. Include the main plugin file

# Create new module

Initialize autoloader

    $autoloader = Agp_Autoloader::instance();
    $autoloader->setClassMap(array(
        __DIR__ => array('myClassFolder'),
    ));

Create new module ‘myClassFolder/myModule.class.php’

    <?php
    class myModule extends Agp_Module 
    {
        ...
    }

Enjoy!



