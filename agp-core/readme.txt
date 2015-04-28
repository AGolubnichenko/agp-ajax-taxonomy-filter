Collection of a base classes for custom WordPress plugins

== Description ==

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

== Installation ==

Download a copy of the plugin
Upload "agp-core" to the "/wp-content/plugins/" directory
Activate the plugin through the "Plugins" menu in WordPress

or 

Download a copy of the plugin
Copy the plugin to your theme / plugin
Include the main plugin file