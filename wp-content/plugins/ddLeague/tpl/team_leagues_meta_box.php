<?php

$args=array(
    'post_type' => 'dd_league',
    'post_status' => 'publish',
    'posts_per_page' => -1,
    'caller_get_posts'=> 1);

$my_query = null;
$my_query = new WP_Query($args);
if( $my_query->have_posts() ) {
    while ($my_query->have_posts()) {
        $my_query->the_post();
        if(get_post_meta(get_the_id(),'request_is_open',true)=='true')
            $row = "<p id='lid".get_the_id()."'>" . get_the_title() . " <input type='button' value='Заявка на участие' lid='".get_the_id()."' class='sing_league'></p>";
        else
            $row = "<p id='lid".get_the_id()."'>" . get_the_title() . " - Прием заявок Закрыт.</p>";
        $listAllowTeams = get_post_meta(get_the_id(), 'listAllowTeams');
        if(count($listAllowTeams[0]) > 0)
            if (in_array($post->ID, $listAllowTeams[0]))
                $row = "<p>" . get_the_title() . " - Комманда в турнире</p>";

        $listWaitingTeams = get_post_meta(get_the_id(), 'listWaitingTeams');
        if(count($listWaitingTeams[0]) > 0)
            if (in_array($post->ID, $listWaitingTeams[0]))
                $row = "<p>" . get_the_title() . " -  Комманда ждет подтверждения.</p>";

        echo $row;
    }
}
wp_reset_query();
?>
<script>
   jQuery('.sing_league').click(function(){
       var lid =jQuery(this).attr('lid');
       var tid = jQuery('#post_ID').val();
       jQuery(this).remove();
       jQuery.ajax({
           type : "post",
           dataType : "json",
           url : myAjax.ajaxurl,
           data : {action: "ajaxController", do : "sing_league", lid: lid, tid: tid },
           success: function(response) {
               jQuery('#lid'+lid).append(' -  Комманда ждет подтверждения.');
           }
       })
   });
</script>


