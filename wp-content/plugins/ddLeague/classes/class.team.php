<?php

class team
{
    public $id;
    public $owner;
    function __construct(){
        register_post_type('dd_team', array(
            'labels' => array(
                'name' => __( 'Teams' ),
                'singular_name' => __( 'Team' )
            ),
            'supports' => array( 'title', 'editor', 'thumbnail'),
            'public' => true,
            'has_archive' => true,
        ));
        add_action( 'add_meta_boxes', array($this,'add_meta_box'));
        add_action( 'save_post', array($this,'save'));
    }

    public function add_meta_box( $post ){
        add_meta_box(
            'team_meta_box'
            ,__( 'Team settings', 'ddLeague' )
            ,array( $this, 'render_meta_box_content' )
            ,'dd_team'
            ,'advanced'
            ,'high'
        );
        add_meta_box(
            'team_leagues_meta_box'
            ,__( 'League settings', 'ddLeague' )
            ,array( $this, 'render_meta_box_leagues_content' )
            ,'dd_team'
            ,'side'
            ,'high'
        );
    }

    public function render_meta_box_leagues_content( $post ){
        include (LEAGUE_DIR."/tpl/team_leagues_meta_box.php");
    }
    public function render_meta_box_content( $post ){
        include (LEAGUE_DIR."/tpl/team_setting_box.php");
    }

    public function save( $post_id ){

    }
}