<?php
/*
Plugin Name: ddFeeling
Plugin URI:
Description:
Version: 0.0.1
Author: DrDD
Author URI:
License: GPLv2 or later
Text Domain: ddFeeling
*/

define('FL_DIR', plugin_dir_path(__FILE__));
define('FL_URL', plugin_dir_url(__FILE__));

spl_autoload_register('__classLoader');
function __classLoader( $className ) {
    $file =  __DIR__."\\classes\\class.$className.php";
    $widget=  __DIR__."\\widgets\\$className.php";
    if (file_exists($file))
        require_once($file );
    else
        if(file_exists($widget))
            require_once($widget );
}

add_action( 'init', '__init' );
function __init()
{
    add_thickbox();
    wp_register_script( "ddfeeling", FL_URL.'/js/ddfeeling.js', array('jquery') );
    wp_localize_script( 'ddfeeling', 'phpVars', array( 'isPopup' => Feeling::isExamToday()));
    wp_enqueue_style('thickbox.css', '/'.WPINC.'/js/thickbox/thickbox.css', null, '1.0');
    wp_enqueue_script( 'ddfeeling' );
}
function fl_content($content) {


    $content.= '<a onclick=" ddfeeling.doPopup(\'Отчет за '.date('m.d.Y', time()).'\')">View my inline content!</a>';
    return $content;

}

add_action( 'the_content', 'fl_content' );