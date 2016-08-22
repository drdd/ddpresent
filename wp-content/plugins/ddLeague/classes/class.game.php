<?php
class game
{
    public $teamList;
    public function __construct()
    {
        register_post_type('dd_game', array(
            'labels' => array(
                'name' => __('Games'),
                'singular_name' => __('Game')
            ),
            'show_ui' => true,
            'public' => true,
            'has_archive' => true,
        ));

        add_action('widgets_init', array($this, 'actWidgetsInit'));
        add_action('add_meta_boxes', array($this, 'add_meta_box'));
        add_action('save_post', array($this, 'save'));
    }

    public function actWidgetsInit()
    {
        // register_widget( 'League_Calendar_Widget' );
    }

    public function add_meta_box($post)
    {
        add_meta_box(
            'game_meta_box'
            , __('Game settings', 'ddLeague')
            , array($this, 'render_meta_box_content')
            , 'dd_game'
            , 'side'
            , 'high'
        );
    }

    public function render_meta_box_content($post)
    {
        include(LEAGUE_DIR . "/tpl/game_setting_box.php");
    }

    public function save($post_id)
    {
        if ( 'dd_game' != $_POST['post_type']) {
            return;
        }

        update_post_meta($post_id, 'gameDate', $_POST['gdate']);
        update_post_meta($post_id, 'leagueID',$_POST['lid'] );
        update_post_meta($post_id, 'team1',$_POST['tid1'] );
        update_post_meta($post_id, 'team2',$_POST['tid2'] );
        update_post_meta($post_id, 'goaltid1',$_POST['goaltid1'] );
        update_post_meta($post_id, 'goaltid2',$_POST['goaltid2'] );

    }
}


