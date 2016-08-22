<?php
class ajaxController
{
    public function __construct()
    {
        add_action("wp_ajax_menuAction", array('ajaxController','menuAction'));
        add_action("wp_ajax_nopriv_menuAction", array('ajaxController','menuAction'));
        add_action("wp_ajax_sendInvite", array('ajaxController','sendInvite'));
        add_action("wp_ajax_nopriv_sendInvite", array('ajaxController','sendInvite'));
    }

    public static function sendInvite(){
        $headers[] = 'Content-Type: text/html; charset=UTF-8';
        $headers[] = 'From: Море Бурь <noname@seastorms.website>';
        $invite_key = md5(substr(str_shuffle("abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!?"), 0, rand(5, 12)));

        if(isset($_REQUEST['email'])) {
            $email = $_REQUEST['email'];
            $user = get_user_by('email', $email);
            if($user !== false){
                $user_id = $user->ID;
                update_user_meta($user_id, 'srtime', time());
                update_user_meta($user_id, 'invite_key', $invite_key);
                wp_mail($email, "Добро пожаловать $user->display_name!", "текст для копирования http://noname/wp-login.php?invite_key=" . $invite_key . " \n<a href='http://noname/wp-login.php?invite_key=" . $invite_key . "' target='_blank'>Вход</a>", $headers, '');
            }else {
                $user_id = get_current_user_id();
                $u = new WP_User($user_id);
                $u->set_role('sailor');
                wp_update_user(array('ID' => $user_id,'user_email'=>$email ,'display_name' => "Матрос"));
                update_user_meta($user_id, 'aaname', "Матрос");
               // update_user_meta($user_id, 'user_email', $email);
                update_user_meta($user_id, 'srtime', time());
                update_user_meta($user_id, 'invite_key', $invite_key);

                wp_mail($email, "Добро пожаловать! Теперь ты не Бродяга.", "текст для копирования http://noname/wp-login.php?invite_key=" . $invite_key . " \n<a href='http://noname/wp-login.php?invite_key=" . $invite_key . "' target='_blank'>Вход</a>", $headers, '');
            }
            echo json_encode(array('type' => 'success', 'text' => 'Приглашение отправлено на '.$email.'. Следуйте инструкции в письме а это окно лучше закрыть.'));
        }else
            json_encode(array('type' => 'error', 'text' => ''));
        exit;
    }

    public static function menuAction(){
        $pId = (int)$_REQUEST["obj_id"];
        $post = get_post($pId);
        $countWnd = 1;
        $content = array();
        switch($_REQUEST["obj"]){
            case 'page': $content = array(array('allowCSS'=>'newspaper','className'=>'single-wnd','html'=>do_shortcode( $post->post_content ))); break;
            case 'post': $content = array(array('className'=>'single-wnd','html'=> $post->post_content )); break;
            case 'category':
                $args = array(
                    'posts_per_page'   => 10,
                    'offset'           => 0,
                    'category'         => $pId,
                    'category_name'    => '',
                    'orderby'          => 'date',
                    'order'            => 'DESC',
                    'include'          => '',
                    'exclude'          => '',
                    'meta_key'         => '',
                    'meta_value'       => '',
                    'post_type'        => 'post',
                    'post_mime_type'   => '',
                    'post_parent'      => '',
                    'author'	   => '',
                    'post_status'      => 'publish',
                    'suppress_filters' => true
                );
                $posts_array = get_posts( $args );

                $content =   array(array('className'=>'category-list','list'=>$posts_array),array('className'=>'category-item','html'=> $post->post_content ));
                $countWnd = 2;
                break;
            case 'dd_league':
                $list = array();
                $team_array = get_posts( array('post_type'=>'dd_team', 'post_status' => 'publish', 'posts_per_page' => -1, 'caller_get_posts'=> 1) );

                $result = array();
                foreach ($team_array as $row){
                    $game_array = get_posts( array('post_type'=>'dd_game','meta_key' => 'gameDate','post_status' => 'publish','posts_per_page' => -1, 'caller_get_posts'=> 1,'order' => 'DESC',
                            'meta_value' => date('d MM Y'),'meta_type'=> 'NUMERIC','meta_compare'=> '<','orderby'=> 'meta_value',
                            'meta_query'  => array(
                                'relation'  => 'OR',
                                array(
                                    'key'     => 'team1',
                                    'value'   => $row->ID,
                                    'compare' => '=')
                                ,
                                array(
                                    'key'     => 'team2',
                                    'value'   => $row->ID,
                                    'compare' => '=')
                                ),
                            )
                    );

                    $result[] = array('name'=>$row->post_title,'gcount'=>count($game_array),'shore'=>'6','win'=>'2','lose'=>'0','draw'=>'0');
                }

                $content =   array(array('className'=>'category-list','list'=>$result),array('className'=>'team-item','html'=> "dd_league" ));
                $countWnd = 2;
                break;
        }

//        print_r($postType);
//do_shortcode( '[ddgarden]' )

        if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            echo json_encode(array('type'=>'success','countWnd'=>$countWnd,'contents'=>$content));
//            echo json_encode(array('type'=>'success','countWnd'=>3,'contents'=>array(
//                    array('className'=>'category-list','html'=>'tese </br> tAdAm!'),
//                    array('className'=>'category-item','html'=>'tese </br> tAdAm! 2</br> tAdAm! 2</br> tAdAm! 2'),
//                    array('className'=>'single-wnd','html'=>'tese </br> tAdAm 123!')
//                )
//                )
//            );
            exit;
        }
        else {
            header("Location: ".$_SERVER["HTTP_REFERER"]);
        }

    }
}
new ajaxController();