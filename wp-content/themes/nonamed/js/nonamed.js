var Controll = function($){
    $(document).ready(function(){
        $(".ftextleft").animate({"color": '#FFF'}, 500);
        $(".ftextright").animate({"color": '#FFF'}, 500);
        $(".slidebtnleft,.slidebtntop,.slidebtnright").on( "click", function() {
            if($('.sidebar-left').css('left') !== "0px") {
                Controll.hideSite();
            }else {
                Controll.showSite();
            }
        });

    });

    function validateEmail(email) {
        var re = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;
        return re.test(email);
    }

    return {
        wnd: function(){
            return {
                create: function(count){
                    var tpl = '<div align="center"><div class="category-list"></div><div class="category-item"></div></div>';
                    switch (count) {
                        case 1: tpl =  '<div align="center"><div class="single-wnd"></div></div>'; break;
                        case 2: break;
                        case 3: tpl = '<div align="center" ><div class="category-list" style="margin-bottom:40px;"></div><div class="category-item" style="margin-bottom:20px;"></div></div><div align="center" ><div class="single-wnd" ></div></div>'; break;
                    }
                    $('#primary').html(tpl);
                },
                fillContent: function(block,html){
                    $('.'+block).html(html);
                },
                renderContent: function(block,obj){
                    // alert(obj);
                    $('.category-list').append('<div style="margin: 5px;float: left;width: 100%"><div style="width: 30%;float: left">Команда</div><div style="float: left;width: 10%">сыграно</div><div style="float: left;width: 10%">Очков</div><div style="float: left;width: 10%">побед</div><div style="float: left;width: 10%">ничьи</div><div style="float: left;width: 10%">поражений</div></div>');
                    $.get("http://noname/wp-content/themes/nonamed/tpl/team-item.html", function(data, textStatus, XMLHttpRequest){
                        var markup = data;
                        $.template( "itemRowTemplate", markup );
                        $.tmpl( "itemRowTemplate", obj ).appendTo( "."+block );
                    });
                },
                allowCSS: function(key){
                    switch (key){
                        case 'newspaper':
                            $('body').addClass('newspaper-background');
                        break;
                    }
                }

            }
        },
        hideSite: function () {
            $('.sidebar-left').animate({"left": "0px"}, "slow");
            $('.sidebar-top').animate({"top": "0px"}, "slow");
            $('.sidebar-right').animate({"right": "0px"}, "slow");
            $(".ftextleft").animate({"color": '#FFF'}, 500);
            $(".ftextright").animate({"color": '#FFF'}, 500);
            $(".user-info").toggle('slow');
            $(".user-login").toggle('slow');
        },
        showSite: function () {
            $('.sidebar-top').animate({"top": "-245px"}, "slow");
            $('.sidebar-left').animate({"left": "-50%"}, "slow");
            $('.sidebar-right').animate({"right": "-50%"}, "slow");
            $(".ftextright").animate({"color": '#000'}, 500);
            $(".ftextleft").animate({"color": '#000'}, 500);

            $(".user-info").toggle('slow');
            $(".user-login").toggle('slow');
        },
        userSendInv: function(){
            $('#userEmail').css('border-color','#FFD700');
            if (validateEmail($('#userEmail').val())){
                jQuery.ajax({
                    type : "post",
                    dataType : "json",
                    url : myAjax.ajaxurl,
                    data : {action: "sendInvite", email : $('#userEmail').val()},
                    success: function(response) {
                        if(response.type == "success") {
                            $('.user-login').html(response.text);
                        }
                        if(response.type=="error")
                            alert('Ошибка отправки почты\nпопробуй еще раз.');

                    }
                })
            }else{
                if (!confirm('ВВЕДИ СВОЙ E-MAIL!\nСделаеш?')){
                    alert("В поле слева от кнопки\nвведи адрес своей электронной почты!");
                }
                $('#userEmail').css('border-color','red');
            }
        }
    }



}(jQuery);