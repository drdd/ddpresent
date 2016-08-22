<?php

/**
 * Created by IntelliJ IDEA.
 * User: NikolaiIvanko
 * Date: 11/27/2015
 * Time: 12:18 PM
 */
class Feeling
{
    // return 1= user+ posts- 2= user- 3= user+ post+
    static function isExamToday(){
        $user_ID = get_current_user_id();
        if($user_ID > 0){
            $today = getdate();
            $args = array(
                'author' => $user_ID,
                'post_type' => 'my_feeling',
                'date_query' => array(
                    array(
                        'year'  => $today['year'],
                        'month' => $today['mon'],
                        'day'   => $today['mday'],
                    ),
                ),
            );
            $todayPosts = new WP_Query( $args );
            if ($todayPosts->have_posts())
                return 1;
            return 3;
        }
        return 2;
    }
    function __construct(){}
    public function save( $post_id ){}

}