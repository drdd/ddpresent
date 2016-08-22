<?php
/*
Plugin Name: ddLeague
Plugin URI:
Description:
Version: 0.0.1
Author: DrDD
Author URI:
License: GPLv2 or later
Text Domain: ddLeague
*/
define('LEAGUE_DIR', plugin_dir_path(__FILE__));

spl_autoload_register('__LeagueClassLoader');
function __LeagueClassLoader( $className ) {
    $file =  __DIR__."\\classes\\class.$className.php";
    $widget=  __DIR__."\\widgets\\$className.php";
    if (file_exists($file))
        require_once($file );
    else
        if(file_exists($widget))
            require_once($widget );
}

add_action( 'init', 'ddLeague_init' );


function ddLeague_init()
{
    $League = new league();
    $Team = new team();
    $Game= new game();
}