<?php
/*
Plugin Name: ddSnake
Plugin URI:
Description:
Version: 0.0.1
Author: DrDD
Author URI:
License: GPLv2 or later
Text Domain:
*/

//[ddsnake]

function init_ddSnake( $atts ){
    wp_enqueue_script('fabric-script', plugins_url('fabric.min.js', __FILE__), array('jquery'), '1.0', true);
    wp_enqueue_script('ddsnake-script', plugins_url('ddsnake.js', __FILE__), array('jquery'), '1.0', true);
  //  wp_enqueue_style('my-styles', plugins_url('my.css', __FILE__));
    // код вывода шоткода
    include "snake.tpl.php";
}
add_shortcode( 'ddsnake', 'init_ddSnake' );

//[ddgarden]
function init_ddGarden( $atts ){
//    wp_enqueue_script('jquery-ui-script', "//code.jquery.com/ui/1.11.4/jquery-ui.js", array('jquery'), '1.0', true);
//    wp_enqueue_script('ocanvas-script', plugins_url('ocanvas-2.8.1.min.js', __FILE__), array('jquery'), '1.0', true);
//    wp_enqueue_script('ddgarden-script', plugins_url('ddgarden.js', __FILE__), array('jquery'), '1.0', true);
//    wp_enqueue_script('ddplants-script', plugins_url('ddplants.js', __FILE__), array('jquery'), '1.0', true);
//    wp_enqueue_script('ddcontrols-script', plugins_url('ddcontrols.js', __FILE__), array('jquery'), '1.0', true);
//    wp_enqueue_script('ddreport-script', plugins_url('ddreport.js', __FILE__), array('jquery'), '1.0', true);
//    wp_enqueue_style('jquery-ui-styles', "//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css");
//    //  wp_enqueue_style('my-styles', plugins_url('my.css', __FILE__));
//    // код вывода шоткода
    $r =  require_once ("garden.tpl.php");
    return $r;
}
add_shortcode( 'ddgarden', 'init_ddGarden' );