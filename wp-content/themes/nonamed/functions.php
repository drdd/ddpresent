<?php
add_theme_support('post-thumbnails');
add_action('after_setup_theme', 'remove_admin_bar');
function remove_admin_bar() {
    //if (!current_user_can('administrator') && !is_admin())
        show_admin_bar(false);
}

function nonamed_widgets_init() {

    register_sidebar( array(
        'name'          => 'Top sidebar',
        'id'            => 'sidebar_top',
        'before_widget' => '<div class="top-widget">',
        'after_widget'  => '</div>',
        'before_title'  => '<h2 class="rounded">',
        'after_title'   => '</h2>',
    ) );
    register_sidebar( array(
        'name'          => 'Left sidebar',
        'id'            => 'sidebar_left',
        'before_widget' => '<div class="left-widget">',
        'after_widget'  => '</div>',
        'before_title'  => '<h2 class="rounded">',
        'after_title'   => '</h2>',
    ) );
    register_sidebar( array(
        'name'          => 'Right sidebar',
        'id'            => 'sidebar_right',
        'before_widget' => '<div class="right-widget">',
        'after_widget'  => '</div>',
        'before_title'  => '<h2 class="rounded">',
        'after_title'   => '</h2>',
    ) );

}

function pirates_script_enqueuer() {

    wp_register_script( "pirates_ajax_script", get_template_directory_uri().'/js/menu-ajax.js', array('jquery') );
    wp_register_script( "breaking_script", get_template_directory_uri().'/js/breaking.js', array('jquery') );
    wp_register_script( "jquery-ui", get_template_directory_uri().'/js/jquery-ui.min.js', array('jquery') );
    wp_register_script( "jquery-timepicker", get_template_directory_uri().'/js/jquery.timepicker.min.js', array('jquery') );
    wp_register_script( "jquery-flip", get_template_directory_uri().'/js/flip.js', array('jquery') );



    wp_enqueue_style('jquery-ui-css', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.2/themes/smoothness/jquery-ui.css');
    wp_enqueue_style('jquery-timepicker-css', get_template_directory_uri().'/jquery.timepicker.min.css');
    if (isset($_REQUEST['hello']))
        $wmd = true;
    else
        $wmd = false;

    wp_localize_script( 'pirates_ajax_script', 'myAjax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ), 'wnd'=>$wmd));

    wp_enqueue_script( 'jquery' );
    wp_enqueue_script( 'jquery-ui' );
    wp_enqueue_script( 'jquery-timepicker' );
    wp_enqueue_script( 'jquery-flip' );
    wp_enqueue_script( 'pirates_ajax_script' );
    wp_enqueue_script( 'breaking_script' );


}
add_action( 'widgets_init', 'nonamed_widgets_init' );
add_action( 'init', 'pirates_script_enqueuer' );

register_nav_menus(
    array(
        'head_menu' => 'head_menu',
        'left_menu' => 'left_menu',
        'right_menu' => 'right_menu'
    )
);

function init_newspaper( $atts ){
    $r =  require_once ("tpl/sc-newspaper.php");
    return $r;
}
add_shortcode( 'newspaper', 'init_newspaper' );

class PiratesMenu_Walker extends Walker_Nav_Menu
{
    function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 )
    {
        $output .= "<a class='ajax-link' obj='".$item->object."' obj_id='".$item->object_id."' ><li>".$item->title."</li></a>";
    }
}
require_once('lib/ajaxController.php');
