=== AGP Plugins Core ===
Contributors: Alexey Golubnichenko
Tags: agp, custom, plugin, theme, classes
Requires at least: 3.5.0
Tested up to: 4.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Stable tag: trunk

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