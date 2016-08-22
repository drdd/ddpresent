var ddfeeling =(function($){

    return  {
        doPopup: function (caption) {
            if (phpVars.isPopup == 3) {
                var url = "http://noname/wp-content/plugins/ddFeeling/js/blank.html?KeepThis=true&width=400&height=300";
                tb_show(caption, url);
            }
        }
    }

    $(document).ready(function() {

    });
})(jQuery);
