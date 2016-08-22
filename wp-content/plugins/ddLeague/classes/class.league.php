<?php
class league{

    public function __construct()
    {
        register_post_type('dd_league', array(
            'labels' => array(
                'name' => __( 'Leagues' ),
                'singular_name' => __( 'League' )
            ),
            'supports' => array( 'title', 'editor', 'thumbnail'),
            'public' => true,
            'has_archive' => true,
        ));
        add_action("wp_ajax_ajaxController", array($this,'ajaxController'));
        add_action( 'widgets_init', array($this,'actWidgetsInit'));
        add_action( 'add_meta_boxes', array($this,'add_meta_box'));
        add_action( 'save_post', array($this,'save'));
    }

    public function ajaxController(){
        if (isset($_REQUEST['do'])) {
            $ID = (int) $_POST['pid'];
            $do = $_REQUEST['do'];
            switch ($do){
                case 'request_is_open':
                    update_post_meta($ID, 'request_is_open', get_post_meta($ID, 'request_is_open', true) == 'true' ? 'false' : 'true');
                    echo json_encode(array('request_is_open'=> get_post_meta($ID,'request_is_open',true )));
                break;
                case 'sing_league':
                    $lid =  (int) $_POST['lid'];
                    $tid =  (int) $_POST['tid'];
                    $res = 'false';
                    if( get_post_meta($lid, 'request_is_open', true) == 'true') {
                        $teamList = get_post_meta($lid, 'listWaitingTeams');
                        $teamList[0][] = $tid;
                        update_post_meta($lid, 'listWaitingTeams', $teamList[0]);
                        $res = 'true';
                    }
                    echo json_encode(array('result'=>$res));
                break;
                case 'active_team':
                    $res = 'true';
                    $lid =  (int) $_POST['lid'];
                    $tid =  (int) $_POST['tid'];
                    $newList = get_post_meta($lid, 'listWaitingTeams');
                    array_splice($newList[0], array_search($tid, $newList[0] ), 1);
                    update_post_meta($lid, 'listWaitingTeams', $newList[0]);
                    $teamList = get_post_meta($lid, 'listAllowTeams');
                    $teamList[0][] = $tid;
                    update_post_meta($lid, 'listAllowTeams', $teamList[0]);
                    $res = 'true';
                    echo json_encode(array('result'=>$res));
                    break;
            }
        }
        exit;
    }

    public function actWidgetsInit(){
        register_widget( 'League_Calendar_Widget' );
    }

    public function add_meta_box( $post ){
        add_meta_box(
            'league_meta_box'
            ,__( 'Teams list', 'ddLeague' )
            ,array( $this, 'render_meta_box_content' )
            ,'dd_league'
            ,'advanced'
            ,'high'
        );
    }

    public function render_meta_box_content( $post ){
        include (LEAGUE_DIR."/tpl/team_list_box.php");
    }

    public function save( $post_id ){

    }


}