<?php
global $post;

$gameID =  get_the_id();

print_r( get_post_meta($gameID,'leagueID',true));
print_r( get_post_meta($gameID,'team1',true));
print_r( get_post_meta($gameID,'team2',true));
$args=array(
    'post_type' => 'dd_league',
    'post_status' => 'publish',
    'posts_per_page' => -1,
    'caller_get_posts'=> 1);

$my_query = null;
$lOptions = '';
$my_query = new WP_Query($args);
if( $my_query->have_posts() )
    while ($my_query->have_posts()) {
        $my_query->the_post();
        $lOptions.="<option value='".get_the_id()."'>".get_the_title()."</option>";
    }
wp_reset_query();

$args=array(
    'post_type' => 'dd_team',
    'post_status' => 'publish',
    'posts_per_page' => -1,
    'caller_get_posts'=> 1);

$my_query = null;
$t1Options = '';
$t2Options = '';
$my_query = new WP_Query($args);
if( $my_query->have_posts() )
    while ($my_query->have_posts()) {
        $my_query->the_post();
        $t1Options.="<option value='".get_the_id()."' ".(get_post_meta($gameID,'team1',true)==get_the_id()?'selected':'')." >".get_the_title()."</option>";
        $t2Options.="<option value='".get_the_id()."'".(get_post_meta($gameID,'team2',true)==get_the_id()?'selected':'')." >".get_the_title()."</option>";
    }
wp_reset_query();
?>
<div>
    <label for="league">Лига :</label>
    <select id="league" name="lid">
        <?php echo $lOptions;?>
    </select>
</div>
<div>
    <label for="gdate">Дата :</label>
    <input type="text" id="gdate" name="gdate" readonly value="<?php echo get_post_meta($gameID,'gameDate',true)?>"/>
</div>
<div>
    <p>Комманды:</p>
    <select id="tid1" name="tid1">
        <?php echo $t1Options;?>
    </select>
    &nbsp;VS&nbsp;
    <select id="tid2" name="tid2">
        <?php echo $t2Options;?>
    </select>
</div>
<div>
    <p>Результат:</p>
    <input type="number" value="<?php echo get_post_meta($gameID,'goaltid1',true)==''?0:get_post_meta($gameID,'goaltid1',true)?>" style="width: 40%" name="goaltid1">
    <input type="number" value="<?php echo get_post_meta($gameID,'goaltid2',true)==''?0:get_post_meta($gameID,'goaltid2',true)?>" name="goaltid2" style="width: 40%;float: right">
<script>
(function($) {
    $('#tid1, #tid2').click(function(){
        $('#title-prompt-text').remove();
        $('#title').val( $('#tid1 option:selected').text() +" VS " + $('#tid2 option:selected').text() ) ;
    });

    $('#gdate').datepicker ({ dateFormat: 'dd MM yy' });
}(jQuery));
</script>