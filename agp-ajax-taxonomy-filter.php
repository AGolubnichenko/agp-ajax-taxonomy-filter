<?php
/**
 * Plugin Name: AGP Ajax Taxonomy Filter
 * Plugin URI: https://github.com/AGolubnichenko/agp-ajax-taxonomy-filter 
 * Description: A plugin for WordPress that let you filter posts by taxonomies with AJAX
 * Version: 1.1.0
 * Author: Alexey Golubnichenko
 * Author URI: https://github.com/AGolubnichenko
 * License: GPL2
 * 
 * @package Atf
 * @category Core
 * @author Alexey Golubnichenko
 */
/*  Copyright 2015  Alexey Golubnichenko  (email : profosbox@gmail.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

if (!defined('ABSPATH')) {
    exit;
}

add_action('init', 'atf_output_buffer');
function atf_output_buffer() {
    ob_start();
}

if (file_exists(dirname(__FILE__) . '/agp-core/agp-core.php' )) {
    include_once (dirname(__FILE__) . '/agp-core/agp-core.php' );
} 

if (!class_exists('Agp_Autoloader')) {
    global $pagenow;
    if ( !empty($pagenow) && 'plugins.php' === $pagenow ) {
        add_action( 'admin_notices', 'atf_check_admin_notices', 0 );
    }

    function atf_check_admin_notices() {
        if (!class_exists('Agp_Autoloader')) {
            unset( $_GET['activate'] );
            $name = get_file_data( __FILE__, array ( 'Plugin Name' ), 'plugin' );
            printf(
                '<div class="error">
                    <p><i><a target="_blank" href="https://github.com/AGolubnichenko/agp-core" title="AGP Plugins Core">AGP Plugins Core</a></i> not installed</p>
                    <p><i>%1$s</i> has been deactivated.</p>
                </div>',
                $name[0]
            );
            deactivate_plugins( plugin_basename( __FILE__ ) );                
        }
    }    
}

add_action( 'plugins_loaded', 'atf_activate_plugin' );
function atf_activate_plugin() {
    if (class_exists('Agp_Autoloader') && !function_exists('Atf')) {
        $autoloader = Agp_Autoloader::instance();
        $autoloader->setClassMap(array(
            __DIR__ => array('classes', 'agp-core'),
        ));

        function Atf() {
            return Atf::instance();
        }    

        Atf();                
    }
}

atf_activate_plugin();
