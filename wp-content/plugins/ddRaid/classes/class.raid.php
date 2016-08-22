<?php

/**
 * Created by IntelliJ IDEA.
 * User: NikolaiIvanko
 * Date: 11/27/2015
 * Time: 12:18 PM
 */
class Raid
{
    function __construct(){
        register_post_type('dd_raid', array(
            'labels' => array(
                'name' => __( 'Raids' ),
                'singular_name' => __( 'Raid' )
            ),
            'supports' => array( 'title','editor'),
            'public' => true,
            'has_archive' => true,
            'show_ui'           => true,
            'show_admin_column' => true,
            'rewrite' => array( 'slug' => 'dd_raid', 'with_front' => true ),
        ));

        $labels = array(
            'name'              => 'Шаблоны Рейдов',
            'singular_name'     => 'Шаблон Рейда',
            'search_items'      => 'Поиск Шаблона Рейда',
            'all_items'         => 'Все Шаблоны Рейдов',
            'edit_item'         => 'Изменить Шаблон Рейда',
            'update_item'       => 'Обновить Шаблон Рейда',
            'new_item_name'     => 'Новый Шаблон Рейда',
            'menu_name'         => 'Шаблоны рейда'
        );
        // register taxonomy
        register_taxonomy( 'dd_raid_tpl', 'dd_raid', array(
            'hierarchical' => false,
            'labels' => $labels,
            'query_var' => true,
            'show_admin_column' => true,
            'show_tagcloud' => true,
        ) );


        $servers = array(
            'name'              => 'Сервера и Фракции',
            'singular_name'     => 'Сервер и Фаракция',
            'search_items'      => 'Поиск Сервера или Фракции',
            'all_items'         => 'Все',
            'edit_item'         => 'Изменить Сервер или Фракцию',
            'update_item'       => 'Обновить Сервер или Фракции',
            'new_item_name'     => 'Новый Сервер или Фракция',
            'menu_name'         => 'Сервера и Фракции'
        );

        register_taxonomy( 'dd_servers', 'dd_raid', array(
            'hierarchical' => true,
            'depth'=>2,
            'labels' => $servers,
            'query_var' => true,
            'show_ui'           => true,
            'show_admin_column' => true,
            'show_tagcloud' => true,
            "rewrite" => true,
        ) );



        add_action( 'admin_menu', array($this,'dd_raid_tpl_remove_meta_box'));
        add_action( 'add_meta_boxes', array($this,'dd_raid_tpl_add_meta_box'));
        add_action( 'save_post', array($this,'save'));

    }

    function dd_raid_tpl_add_meta_box(){
        add_meta_box( 'dd_raid_tpl', 'Настройки рейда',array($this,'dd_raid_tpl_metabox'),'dd_raid' ,'side','high');
        add_meta_box( 'dd_raid_user', 'Участники рейда',array($this,'dd_raid_users_metabox'),'dd_raid' ,'advanced','core');
    }
    function dd_raid_tpl_metabox( $post ) {
        include(RAIDS_DIR . "/tpl/raid_box_tpl.php");
    }
    public function dd_raid_users_metabox( $post ){
        include (RAIDS_DIR."/tpl/raid_users.php");
    }
    function dd_raid_tpl_remove_meta_box(){ remove_meta_box('tagsdiv-dd_raid_tpl', 'dd_raid', 'normal');  remove_meta_box('dd_serversdiv', 'dd_raid', 'normal'); }

    public function save( $post_id ){

        if($_POST['post_type'] == 'dd_raid') {
            global $post,$wpdb;
            $fract_ids = array( $_POST['dd_raid_fract'] );
            $fract_ids = array_map('intval', $fract_ids);
            wp_set_object_terms($post_id, $fract_ids, 'dd_servers');

            $cat_ids = array( $_POST['dd_raid_tpl'] );
            $cat_ids = array_map('intval', $cat_ids);
            wp_set_object_terms($post_id, $cat_ids, 'dd_raid_tpl');

            $dd_raid_tpl = wp_get_post_terms($post_id, 'dd_raid_tpl', array("fields" => "all"));
            update_post_meta($post_id, 'rdate', $_POST['rdate']);
            update_post_meta($post_id, 'rtime', $_POST['rtime']);
            $title = $dd_raid_tpl[0]->name. " by " . get_the_author_meta('user_nicename',$post->post_author ) ;
            $where = array( 'ID' => $post_id );
            $wpdb->update( $wpdb->posts, array( 'post_title' => $title ), $where );

            update_post_meta($post_id, 'isFinish', $_POST['isFinish']=='on'?'checked':'');
            delete_post_meta( $post_id,'user_list_part' );
            update_post_meta($post_id, 'user_list_part', $_POST['part'],true);
        }

    }

}