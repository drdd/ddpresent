var ddreport = function($){
    var wndReport = {coin:0,or:0};

    var tmpJSON = '[{"pid":"1","size":"10","time":"7","price":"700","or":"3","profit":"4","info":{"pid":"1","name":"Small"}},' +
        '{"pid":"2","size":"30","time":"300","price":"1100","or":"5","profit":"4","info":{"pid":"2","name":"Medium"}},' +
        '{"pid":"3","size":"90","time":"3000","price":"7000","or":"25","profit":"3","info":{"pid":"3","name":"Big"}}]';
    var plantList = $.parseJSON(tmpJSON);

    plantList.forEach(function (item, i, arr) {
        wndReport["rpid"+item.pid] = 0;
        $('#rHarvest').append('<div><span>'+item.info.name+' </span>: <span id="rpid'+item.info.pid+'">0</span></div>');
    });

    return {
        toPlant: function (plant) {
           // console.log(plant.info.pid);
            plantList.forEach(function (item, i, arr) {
                if(item.pid == plant.info.pid){
                    wndReport.coin = wndReport.coin - item.price*1;
                    wndReport.or = wndReport.or + item.or*1;
                   $('#rCoin').html( wndReport.coin );
                   $('#rOr').html(wndReport.or);
                }
            });
        },
        toHarvest: function (plant) {
            plantList.forEach(function (item, i, arr) {
                if(item.pid == plant.info.pid){
                    wndReport["rpid"+item.pid] =  wndReport["rpid"+item.pid] + item.profit*1
                    $('#rpid'+item.pid ).html(wndReport["rpid"+item.pid]  );

                }
            });
        }
    }
}(jQuery);