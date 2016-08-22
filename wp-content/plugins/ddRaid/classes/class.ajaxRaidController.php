<?php
class ajaxRaidController
{
    public function __construct()
    {
        add_action("wp_ajax_raidAction", array('ajaxRaidController', 'raidAction'));
        add_action("wp_ajax_nopriv_raidAction", array('ajaxRaidController', 'raidAction'));
    }
    public function raidAction(){
        switch ($_REQUEST['do']){
            case 'changeDdServer':
                $_SESSION['dd_server'] = $_REQUEST['dd_server'];
                break;
            case 'inRaid':
                $rid = (int)$_REQUEST['rid'];
                $hash = md5(strtolower($_REQUEST['name']));
                $userList = get_post_meta($rid,'user_list',false);
                if (isset($userList[0][$hash])){
                    echo json_encode(array('type' => 'error'));
                    exit;
                }
                $userList[0][$hash] = array('id'=>'0','name'=>$_REQUEST['name'],'gs'=>$_REQUEST['gs'],'role'=>$_REQUEST['role']);
                update_post_meta($rid, 'user_list', $userList[0],false);
               // delete_post_meta( $rid,'user_list' );
                echo json_encode(array('type' => 'success', 'userInfo' => array('name'=>$_REQUEST['name'],'role'=>$_REQUEST['role'])));
                break;
            case 'raidInfo':
                if(isset($_REQUEST['rid'])) {
                    $rid = (int)$_REQUEST['rid'];
                    $post = get_post($rid);
                    $userList = get_post_meta($rid,'user_list',false);
                    $hashList = get_post_meta($rid,'user_list_part',true);
                    if($hashList=="") $hashList="[]";
                    $hashListArr  = json_decode($hashList);
                    $isFinish = get_post_meta($rid,'isFinish',true);
                    $rdate = get_post_meta($rid,'rdate',true);
                    if(strtotime(date('y-m-d', time())) > strtotime($rdate)) $isFinish = 'checked';

                    if($isFinish == 'checked') {
                        $tmp = array();
                        if(count($userList[0]) > 0)
                            foreach ($userList[0] as $key => $val)
                                if (in_array($key, $hashListArr))
                                    $tmp[$key]=$val;
                        $userList[0] = $tmp;
                    }

                    $returnObj = array('isFinish'=>$isFinish,
                                        'title'=>$post->post_title,
                                        'content'=>$post->post_content,
                                        'rdate'=>get_post_meta($rid,'rdate',true),
                                        'rtime'=>get_post_meta($rid,'rtime',true),
                                        'rl'=> get_the_author_meta('user_nicename',$post->post_author ),
                                        'bids'=>'37');
                    echo json_encode(array('type' => 'success', 'raidInfo' => $returnObj,'userList'=>$userList[0]));
                }

                break;
        }
        exit;
    }
}