<?php
$isFinish = get_post_meta(get_the_ID(),'isFinish',true);
$userList = get_post_meta(get_the_ID(),'user_list',false);
$user_list_part = get_post_meta(get_the_ID(),'user_list_part',true);
if($user_list_part=="") $user_list_part="[]";
$arr_user_list_part  = json_decode($user_list_part);

?>
<div><input type="checkbox" id="isFinish"  <?php echo $isFinish; ?> name="isFinish"> <label>Рейд завершен</label></div>
<div style="width: 100%;float: left">
    <h3>Хотели в рейд:</h3>
    <div class="want-raid"  >
        <?php
        if(count($userList[0]) > 0)
            foreach($userList[0] as $key=>$item){
                if(!in_array($key,$arr_user_list_part))
                    echo "<div align='center' uid='".$key."' class='user-in-list role-".$item['role']."'>".$item['name']."<div style='font-size:10px'>ГС: ".$item['gs']."</div></div>";
            }
        ?>
    </div>
</div>
<div  style="width: 100%;float: left">
    <h3>Были рейде:</h3>
    <div class="part-raid">
        <?php
        if(count($userList[0]) > 0)
            foreach($userList[0] as $key=>$item){
                if(in_array($key,$arr_user_list_part))
                    echo "<div align='center' uid='".$key."' class='user-in-list role-".$item['role']."'>".$item['name']."</div>";
            }
        ?>
    </div>
</div>
<div  style="clear: both"></div>
<input type="hidden" name="part" id="part" style="clear: both" value='<?php echo $user_list_part;?>'>
<script>
if(!Array.prototype.indexOf) {
    Array.prototype.indexOf = function(what, i) {
        i = i || 0;
        var L = this.length;
        while (i < L) {
            if(this[i] === what) return i;
            ++i;
        }
        return -1;
    };
}
Array.prototype.remove = function() {
    var what, a = arguments, L = a.length, ax;
    while (L && this.length) {
        what = a[--L];
        while ((ax = this.indexOf(what)) !== -1) {
            this.splice(ax, 1);
        }
    }
    return this;
};
jQuery(document).ready(function ($) {
    $('.user-in-list').click(function(){

        var inPart = JSON.parse($('#part').val());

        if( inPart.indexOf($(this).attr('uid'))> -1)
            inPart.remove($(this).attr('uid'));
        else
            inPart.push($(this).attr('uid'));

        $('#part').val(JSON.stringify(inPart));

        if( $(this).parent().attr('class') == 'part-raid'){
            $(this).appendTo(".want-raid");
        }else {
            $(this).appendTo(".part-raid");
        }
    });
});
</script>
<style>
    .user-in-list{cursor:pointer; font-size: 18px; overflow: hidden; margin: 2px; color: #fff; padding-top:5px; float: left;  width: 120px;height: 35px; border-radius: 2px; border: 1px solid darkslategray; }
    .role-dd{background-color:#CA2525;}
    .role-tank{background-color:#8BEF9F;}
    .role-heal{background-color: #FB8A9B;}
    .role-bard{background-color: #4C93BD;}
</style>