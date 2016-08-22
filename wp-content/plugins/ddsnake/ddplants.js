(function($){

    var tmpJSON = '[{"pid":"1","size":"10","time":"5","price":"700","or":"3","profit":"4","info":{"pid":"1","name":"Small"}},' +
        '{"pid":"2","size":"30","time":"7","price":"1100","or":"5","profit":"4","info":{"pid":"2","name":"Medium"}},' +
        '{"pid":"3","size":"90","time":"10","price":"7000","or":"25","profit":"3","info":{"pid":"3","name":"Big"}}]';
    var plantList = $.parseJSON(tmpJSON);

    plantList.forEach(function (item, i, arr) {
        var btn = document.createElement('div');
        btn.className ="dd-btn";
        btn.title = item.info.name;
        btn.addEventListener("click",function(){
           ddmain.setCursor(item);
        });
        $('#panel').append(btn);
    });

   // $( document ).tooltip();
})(jQuery);
