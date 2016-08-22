<?php
get_header();

$monthes = array(
    1 => 'Янв', 2 => 'Фев', 3 => 'Мар', 4 => 'Апр',
    5 => 'Мая', 6 => 'Июн', 7 => 'Июл', 8 => 'Авг',
    9 => 'Сен', 10 => 'Окт', 11 => 'Ноя', 12 => 'Дек'
);
$time = time();
if(isset($_GET['date']) && !empty($_GET['date']))
    $time = strtotime($_GET['date']);

$dnext = date('y-m-d' ,strtotime('+1 weeks',$time));
$dprev = date('y-m-d' ,strtotime('-1 weeks',$time));

$optSrv = "";
$curFract=$_SESSION['dd_server'];
$servers = get_terms( 'dd_servers', 'orderby=count&hide_empty=0&parent=0' );
foreach ($servers as $item) {
    $optFrac = "";
    $frac = get_terms('dd_servers', 'orderby=count&hide_empty=0&parent=' . $item->term_id);
    foreach ($frac as $row)
        if ($row->term_id == $curFract)
            $optFrac .= "<option selected value='" . $row->term_id . "'>" . $row->name . "</option>";
        else
            $optFrac .= "<option value='" . $row->term_id . "'>" . $row->name . "</option>";

    $optSrv .= "<optgroup label = '" . $item->name . "'>" . $optFrac . "</optgroup>";
}
?>
    <div class="content-area" align="center" style="  height: 100%; width: 100%; padding: 20px;">
    <main id="main" class="site-main" align="center" role="main" >
    <div id="flipper">
        <div class="front">
            <div class="raid-calendar-nav">
                <a href="?date=<?php echo $dprev; ?>"><span> &lt;&lt; НАЗАД </span></a>
                <span>
                    <select id="ddserver" style="border: 0px;color: #156fd1; font-size:22px; "> <?php echo $optSrv;?></select>
                </span>
                <a href="?date=<?php echo $dnext?>"> <span> ВПЕРЕД &gt;&gt;</span></a>
            </div>
            <div class="raid-calendar" >
                <?php
                $day ="";
                for($i=-14;$i<14;$i++){

                    $dtmp = strtotime($i . ' days', $time);
                    if (strtotime(date('y-m-d', time())) <= $dtmp) $day = "hight";
                    $sdate = date('d', $dtmp) . " " . $monthes[date('n', $dtmp)];

                    $raid_array = get_posts(array('post_type' => 'dd_raid', 'meta_key' => 'rdate', 'post_status' => 'publish', 'posts_per_page' => -1, 'caller_get_posts' => 1, 'order' => 'DESC',
                            'meta_value' => date('d F Y', $dtmp), 'meta_type' => 'CHAR', 'meta_compare' => '=', 'orderby' => 'meta_value','tax_query' => array(
                                array(
                                    'taxonomy' => 'dd_servers',
                                    'field' => 'id',
                                    'terms' => $curFract
                                )
                            )
                        )
                    );
                    ?>
                    <div class="day <?php echo $day; ?>">
                        <div class="raids ">
                            <?php
                            foreach($raid_array as $raid){
                                echo '<div class="raid"><a href="#" class="a-raid" rid="'.$raid->ID.'"><div class="name">'.$raid->post_title.'</div><div class="time">'.get_post_meta($raid->ID,'rtime',true).'</div></a></div>';

                            }
                            ?>
                        </div>
                        <span style="z-index: 1;    display: block; "><?php echo $sdate;?></span>
                    </div>
                    <?php
                }
                ?>
            </div>
        </div>
        <div class="back">
            <div class="raid-calendar-nav">
                <a href="#" onclick="flipped()"><span> Назад к Календарю </span></a>
            </div>
            <div class="raid-info-ctn">
                <div class="raid-details">
                    <div style="float: left;width: 100%"><span style="float: left"> <h3 id="rname">Название рейда</h3></span>   <span  style="float: right"> <i id="rdate">Да.тт.аа Вре:мя</i></span></div>
                    <div style="float: left;width: 100%"><span style="float: left" id="rrl"> </span>   <span  style="float: right"> заявок на участие: <i id="rbids">50</i></span></div>
                    <div style="float: left;width: 790px; padding-top: 10px;  overflow: hidden;" align="justify"><span style=" padding-top:10px;padding-bottom: 10px " id="rcontent" >
                          Президент США Барак Обама на встрече с российским коллегой Владимиром Путиным в Париже выразил сожаление в связи с инцидентом с российским Су-24,
                          который был сбит турецкими ВВС. Об этом сообщил пресс-секретарь российского лидера Дмитрий Песков, пишет РИА Новости.По его словам, на встрече,
                          проведенной на полях конференции, посвященной изменению климата, в понедельник, 30 ноября, «в нюансах обсуждалась и Сирия,
                          Путин и Обама высказывались в пользу продвижения к началу политического урегулирования».
                        </span></div>
                </div>
                <div class="raid-user-info-ctn" style="float: right;width: 200px;  line-height: 1.1;">
                    <div class="raid-user-info">
                        <div>
                            <label for="aaname" >Имя в AA :</label>
                            <input type="text" name="aaname" id="aaname">
                        </div>
                        <div>
                            <label for="gs" >ГС :</label>
                            <input type="text" name="gs" id="gs">
                        </div>
                        <div>
                            <label for="klass">Класс :</label>
                            <select name="klass" id="klass">
                                <option value="dd">ДД</option>
                                <option value="tank">Танк</option>
                                <option value="heal">Лекарь</option>
                                <option value="bard">Бард</option>
                            </select>
                        </div>
                    </div>

                    <div class="raid-calendar-nav" style="width: 200px;margin-top: 5px; float: left" align="center" id="cntinraid">
                        <a href="javascript:void(0)" class="in-raid"><span>&nbsp;Хочу в рейд&nbsp;</span></a>
                    </div>

                    <div class="raid-user-list"> </div>
                </div>
            </div>
        </div>
    </div>
    </main><!-- .site-main -->
    </div><!-- .content-area -->
    <script>
        var rId=0;
        function flipped(){
            if(jQuery('.front').css('display') == 'none' ){
                jQuery('.back').hide();
                jQuery('.front').show();
            }else{
                jQuery('.back').show();
                jQuery('.front').hide()
            }
        }
        jQuery(document).ready(function ($) {
//            $("#flipper").flip({
//                trigger: 'manual'
//            });

            $('.in-raid').click(function(){
                if($('#aaname').val().trim() != "" && $('#gs').val().trim() != "") {
                    jQuery.ajax({
                        type: "post",
                        dataType: "json",
                        url: myAjax.ajaxurl,
                        data: {
                            action: "raidAction",
                            do: "inRaid",
                            rid: rId,
                            name: $('#aaname').val(),
                            gs: $('#gs').val(),
                            role: $('#klass').val()
                        },
                        success: function (response) {
                            if(response.type=='success') {
                                $('.raid-user-list').append("<div class='user-in-list role-"+response.userInfo.role+"'>"+response.userInfo.name+"</div>");
                            }else
                                alert('Что то не так)');
                        }
                    })
                }else
                    alert('Введите имя и ГС.')
            });

            $('.a-raid').click(function(){
                rId = $(this).attr('rid');
                jQuery.ajax({
                    type : "post",
                    dataType : "json",
                    url : myAjax.ajaxurl,
                    data : {action: "raidAction",do:"raidInfo",rid:  $(this).attr('rid')},
                    success: function(response) {
                        if(response.raidInfo.isFinish == 'checked'){
                            $('.raid-user-info').hide();
                            $('#cntinraid').hide();
                        }else{
                            $('.raid-user-info').show();
                            $('#cntinraid').show();
                        }
                        $('.raid-user-list').html('');
                        $('#rname').html(response.raidInfo.title);
                        $('#rdate').html(response.raidInfo.rdate +" "+response.raidInfo.rtime );
                        $('#rrl').html("Рейд лидер: "+response.raidInfo.rl);
                        $('#rbids').html(response.raidInfo.bids);
                        $('#rcontent').html(response.raidInfo.content);
                        for(var key in response.userList) {
                            var value = response.userList[key];
                            $('.raid-user-list').append("<div class='user-in-list role-"+value.role+"'>"+value.name+"</div>");
                        }
                        flipped();
                      //  $("#flipper").flip('toggle');

                    }
                })
            });
            $('#ddserver').change(function(){

                jQuery.ajax({
                    type: "post",
                    dataType: "json",
                    url: myAjax.ajaxurl,
                    data: {
                        action: "raidAction",
                        do: "changeDdServer",
                        dd_server:$(this).val()
                    },
                    success: function (response) {
                        document.location.reload(true);
                    }
                })
            });

            $('#klass').change(function(){
                switch ($(this).val()){
                    case'dd':   $('.raid-user-info').css('background-color','#CA2525'); break;
                    case'tank': $('.raid-user-info').css('background-color','#8BEF9F'); break;
                    case'heal': $('.raid-user-info').css('background-color','#FB8A9B'); break;
                    case'bard': $('.raid-user-info').css('background-color','#4C93BD'); break;
                }

            });
        });
    </script>
    <style>
        @media screen and (max-width: 1400px) {
            .raid-info-ctn{
                margin-left: 0px !important;
            }
            .raid-user-info-ctn{
                float: left  !important;
                width: 100%;
            }
        }
        .back{
            display: none;
        }
        .raid-info-ctn{
           
            float: left;
            padding: 20px;
            margin-left: 20%;
            align-content: center;
        }
        .raid-details{
            padding: 15px;
            float: left;
            width:820px;
        }
        .raid-user-info{
            width: 185px;
            border: 1px solid grey;
            border-radius: 10px;
            padding: 10px;
            float: left;
            background-color: #CA2525;
        }
        .raid-user-info label{
            font-size: 16px;
        }
        .raid-user-info input{
            width: 150px;
            height: 25px;
            line-height: 1;
        }
        .raid-user-info select{
            width: 150px;
        }
        .raid-calendar{
            width: 100%;
        }
        .raid-calendar-nav{
            font-size: 22px;

        }
        .raid-calendar-nav span{
            color: #156fd1;
            border: 1px solid  #71afd1;
            border-radius: 20px;
            padding: 10px;
            display: inline-block;
        }
        .raid-calendar .hight{
            color: #156fd1 !important;
        }
        .raid-calendar .day{
            margin: 5px;
            float: left;
            font-size: 70px;
            color: #71afd1;
            min-height: 130px;
            width: 256px;
            border: 1px solid  #71afd1;
            border-radius: 25px;
        }
        .day .raids{
            padding-top: 10px;
            max-width: 215px;
            min-width:150px;
            position: absolute;
            padding-left: 20px;
            width: inherit;
            max-height: 95px;
            overflow-y: hidden;
            z-index: 2;
        }
        .day .raid{
            float: left;
            width: 100%;
            font-size: 17px;
            color: #131310;
        }
        .day .raid .name{
            float: left;
            text-decoration: underline;
        }
        .day .raid .time{
            float: right;
        }
        .raid a{
            color:#131310;
        }
        .raid a:hover{
            color:indianred;
            text-decoration: none;
        }
        .user-in-list{overflow: hidden; margin: 2px; color: #fff; padding-top:5px;  float:left; width: 90px;height: 25px; border-radius: 2px; border: 1px solid darkslategray; }
        .role-dd{background-color:#CA2525;}
        .role-tank{background-color:#8BEF9F;}
        .role-heal{background-color: #FB8A9B;}
        .role-bard{background-color: #4C93BD;}
    </style>

<?php get_footer(); ?>