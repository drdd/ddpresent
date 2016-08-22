<?php

$raidsTpl = get_terms( 'dd_raid_tpl', 'orderby=count&hide_empty=0' );

$dd_raid_tpl = wp_get_post_terms(get_the_ID(), 'dd_raid_tpl', array("fields" => "all"));
$dd_raid_fract = wp_get_post_terms(get_the_ID(), 'dd_servers', array("fields" => "all"));

$rdate = get_post_meta(get_the_ID(),'rdate',true);
$rtime = get_post_meta(get_the_ID(),'rtime',true);

$curTpl = $curFract= 0;
if(isset($dd_raid_tpl[0]))
    $curTpl = $dd_raid_tpl[0]->term_id;

if(isset($dd_raid_fract[0]))
    $curFract = $dd_raid_fract[0]->term_id;

$opt = "";
foreach ($raidsTpl as $item)
    if($item->term_id == $curTpl)
        $opt .= "<option selected value='".$item->term_id."'>".$item->name."</option>";
    else
        $opt .= "<option value='".$item->term_id."'>".$item->name."</option>";

$optSrv = "";
$servers = get_terms( 'dd_servers', 'orderby=count&hide_empty=0&parent=0' );
foreach ($servers as $item) {
    $optFrac = "";
    $frac = get_terms( 'dd_servers', 'orderby=count&hide_empty=0&parent='.$item->term_id );
    foreach ($frac as $row)
        if($row->term_id == $curFract)
            $optFrac .= "<option selected value='".$row->term_id."'>".$row->name."</option>";
        else
            $optFrac .= "<option value='".$row->term_id."'>".$row->name."</option>";

    $optSrv .= "<optgroup label = '" . $item->name . "'>" . $optFrac . "</optgroup>";
}

?>
<label>Сервер/Фракция</label>
<select name="dd_raid_fract" style="width: 100%; margin-bottom: 10px;">
<?php echo $optSrv;?>
</select>
<label>Шаблон рейда</label>
<select name="dd_raid_tpl" style="width: 100%; margin-bottom: 10px;">
    <?php echo $opt;?>
</select>
<div style="width: 100%;height: 35px;">
    <label for="gdate">Дата :</label>
    <input type="text" style="float:right"  id="rdate" name="rdate" readonly value="<?php echo $rdate;?>"/>
</div>
<div style="width: 100%;height: 35px;">
    <label for="gdate">Время :</label>
    <input type="text" style="float:right" id="rtime" name="rtime" readonly value="<?php echo $rtime?>"/>
</div>
<div style="clear: both"></div>
<script>
    jQuery(document).ready(function ($) {
        $('#dd_servers-adder').hide();
        if($('#post_type').val() === 'dd_raid'){
            $('#title').attr('disabled','disabled');
        }
        $('#rdate').datepicker ({ dateFormat: 'dd MM yy' });
        $('#rtime').timepicker({ timeFormat: 'HH:mm' });
    });
</script>

