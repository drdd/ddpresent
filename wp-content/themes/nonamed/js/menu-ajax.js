(function($){
    $(document).ready(function() {
        if( myAjax.wnd)
            Controll.showSite();
        $(".ajax-link").on('click', function (e) {
            obj_id = jQuery(this).attr("obj_id");
            obj = jQuery(this).attr("obj");

            jQuery.ajax({
                type : "post",
                dataType : "json",
                url : myAjax.ajaxurl,
                data : {action: "menuAction", obj_id : obj_id, obj: obj},
                success: function(response) {
                    if(response.type == "success") {
                        Controll.wnd().create(response.countWnd);
                        if(response.contents.length > 0 )
                            $.each(response.contents, function(index, item){
                                if("html" in item )
                                    Controll.wnd().fillContent(item.className, item.html);
                                if("list" in item )
                                    Controll.wnd().renderContent(item.className, item.list);
                                if("allowCSS" in item)
                                    Controll.wnd().allowCSS(item.allowCSS);
                            });

                        Controll.showSite();
                    }
                    else {
                        console.log(response);
                    }

                }
            })
        });
    });

})(jQuery);

