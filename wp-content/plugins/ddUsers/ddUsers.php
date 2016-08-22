<?php
/*
Plugin Name: ddUsers
Plugin URI:
Description: add custom users
Version: 0.0.1
Author: DrDD
Author URI:
License: GPLv2 or later
Text Domain:
*/
function ddLUser_init()
{
    if(isset($_REQUEST['invite_key']) || isset($_REQUEST['loggedout'])) return;

    $uIP = ddUserIP();
    $curentUser = wp_get_current_user();
    if ($curentUser->ID == 0) {
        $userroamers = get_users(array('role' => 'roamer', 'meta_key' => 'ip', 'meta_value' => $uIP));
        if (count($userroamers) == 0) {
            $userdata = array(
                'user_login' => 'usern' . time().rand(0,1000),
                'user_url' => "",
                'user_pass' => NULL,
                'display_name' => __('Roamer'),
                'role' => 'roamer'
            );

            $user_id = wp_insert_user($userdata);
            add_user_meta($user_id, 'aaname', 'Бродяга');
            add_user_meta($user_id, 'gs', '3000');
            add_user_meta($user_id, 'coin', '100');
            add_user_meta($user_id, 'ip', $uIP);
            add_user_meta($user_id, 'srtime', '');
            add_user_meta($user_id, 'invite_key', '');

        } else
            $user_id = $userroamers[0]->ID;

        $user = get_user_by('id', $user_id);
        if ($user) {
            wp_set_current_user($user_id, $user->user_login);
            wp_set_auth_cookie($user_id);
            do_action('wp_login', $user->user_login);
        }
        // $curentUser = wp_get_current_user();
    }
}
function login_badge(){
    if(isset($_REQUEST['invite_key'])){
        $users = get_users(array('role' => 'sailor', 'meta_key' => 'invite_key', 'meta_value' => $_REQUEST['invite_key']));
        if(count($users) > 0) {

            $user_id= $users[0]->ID;
            //$srtime =  get_user_meta($user_id,'srtime')[0];
           // if( $srtime +3 > time()) {
                $user = get_user_by('id', $user_id);
                wp_set_current_user($user_id, $user->user_login);
                wp_set_auth_cookie($user_id);
                do_action('wp_login', $user->user_login);
                wp_redirect('/?hello');
           // }else {
           // }
        }
    }
}
add_action( 'login_init', 'login_badge' );
add_action( 'init', 'ddLUser_init' );

add_role('roamer',__('Roamer'),array('read' => true));
add_role('sailor',__('Sailor'),array('read' => true));

function ddUserIP()
{
    foreach (array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR') as $key)
    {

        if (array_key_exists($key, $_SERVER) === true)
        {
            foreach (array_map('trim', explode(',', $_SERVER[$key])) as $ip)
            {

                // if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) !== false)
                //  {
                return $ip;
                // }
            }
        }
    }
}


