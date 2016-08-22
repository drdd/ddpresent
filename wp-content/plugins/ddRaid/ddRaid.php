<?php
/*
Plugin Name: ddRaid
Plugin URI:
Description:
Version: 0.0.1
Author: DrDD
Author URI:
License: GPLv2 or later
Text Domain: ddRaid
*/

define('RAIDS_DIR', plugin_dir_path(__FILE__));
define('RAIDS_URL', plugin_dir_url(__FILE__));

spl_autoload_register('__RaidClassLoader');
function __RaidClassLoader( $className ) {
    $file =  __DIR__."\\classes\\class.$className.php";
    $widget=  __DIR__."\\widgets\\$className.php";
    if (file_exists($file))
        require_once($file );
    else
        if(file_exists($widget))
            require_once($widget );
}

add_action( 'init', 'ddRaid_init' );


function ddRaid_init()
{
    session_start();

    wp_register_script( "jquery-ui", RAIDS_URL.'/js/jquery-ui.min.js', array('jquery') );
    wp_register_script( "jquery-timepicker", RAIDS_URL.'/js/jquery.timepicker.min.js', array('jquery') );

    wp_enqueue_style('jquery-ui-css', RAIDS_URL.'/css/jquery-ui.min.css');
    wp_enqueue_style('jquery-timepicker-css', RAIDS_URL.'/css/jquery.timepicker.min.css');

    wp_localize_script( 'jquery-ui', 'myAjax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ), 'wnd'=>1));

    wp_enqueue_script( 'jquery-ui' );
    wp_enqueue_script( 'jquery-timepicker' );


    if(!isset($_SESSION['dd_server'])) $_SESSION['dd_server'] = 3;
    $Raid = new Raid();
    $ajaxController = new ajaxRaidController();
}
add_action("template_redirect", 'ddRaid_page_template');
function ddRaid_page_template( $page_template )
{
    global $wp,  $post, $wp_query;
    if ($wp->query_vars["pagename"] == 'dd_raid') {
   ///     $wp_query->is_404 = false;
     //   include(RAIDS_DIR . '/tpl/list_dd_raid.php');
      //  die();
    }

}