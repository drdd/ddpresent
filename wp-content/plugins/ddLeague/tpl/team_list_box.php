<?php
$isOpen = get_post_meta(get_the_ID(),'request_is_open',true);

$listAllowTeams = get_post_meta(get_the_ID(),'listAllowTeams');
$listWaitingTeams  =  get_post_meta(get_the_ID(),'listWaitingTeams');

?>
<div class="team-list-box">
    <h3 >Прием заявок :
<?php echo ($isOpen == "true")?'<span id="requestBtn" style="cursor: pointer" class="green">ОТКРЫТ</span>':'<span id="requestBtn" style="cursor: pointer" class="red">ЗАКРЫТ</span>'; ?>
    </h3>
    <div style="clear: both">
        <h4>Заявки на участие:</h4>
        <?php
        for($i=0;$i<count($listWaitingTeams[0]);$i++){
            $team = get_post($listWaitingTeams[0][$i]);
            echo "<div class='list-waiting-team' id='tid".$team->ID."' align='center'><input value='Принять заявку' type='button' tid='".$team->ID."' class='accept-team'><h5 style='width: 100%;' align='center'>".$team->post_title."</h5>".get_the_post_thumbnail( $team->ID, 'thumbnail' )."</div>";
        }
        ?>
    </div>
    <div style="clear: both" id="teamlist">
        <h4>Команды:</h4>
        <?php
        for($i=0;$i<count($listAllowTeams[0]);$i++){
            $team = get_post($listAllowTeams[0][$i]);
            echo "<div class='list-waiting-team' align='center'><h5 style='width: 100%;' align='center'>".$team->post_title."</h5>".get_the_post_thumbnail( $team->ID, 'thumbnail' )."</div>";
        }
        ?>
    </div>
    <div style="clear: both"></div>
</div>
<style>
    .team-list-box h5{
        font-weight: bold;
        font-size: 16px;
    }
    .red{ color:red; }
    .green{ color:green; }
    .list-waiting-team{float: left; padding: 5px;}
</style>
<script>
jQuery(document).ready(function(){

    jQuery('.accept-team').click( function() {
        var tid=jQuery(this).attr('tid');
        var lid = jQuery('#post_ID').val();
        jQuery(this).remove();
        jQuery.ajax({
            type : "post",
            dataType : "json",
            url : myAjax.ajaxurl,
            data : {action: "ajaxController", do : "active_team", tid:tid, lid:lid},
            success: function(response) {

                jQuery('#teamlist').append(jQuery('#tid'+tid));
            }
        })

    });

    jQuery('#requestBtn').click( function(){
        jQuery.ajax({
            type : "post",
            dataType : "json",
            url : myAjax.ajaxurl,
            data : {action: "ajaxController", do : "request_is_open", pid: jQuery('#post_ID').val()},
            success: function(response) {
               if(response.request_is_open=='true'){
                jQuery('#requestBtn').html("ОТКРЫТ");
                jQuery('#requestBtn').removeClass('red');
                jQuery('#requestBtn').addClass('green');
               }else{
                jQuery('#requestBtn').html("ЗАКРЫТ");
                jQuery('#requestBtn').removeClass('green');
                jQuery('#requestBtn').addClass('red');
               }
            }
        })
    });
});
</script>