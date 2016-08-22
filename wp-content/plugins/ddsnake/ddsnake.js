(function($){

    window.onkeydown = function(e) {
        switch (e.keyCode) {
            case 38: case 87: if (way!='b') way = 't'; return;
            case 37: case 65: if (way!='r') way = 'l'; return;
            case 39: case 68: if (way!='l') way = 'r'; return;
            case 40: case 83: if (way!='t') way = 'b'; return;
        }
    };

    var way = 't';//t l b r
    var bf = new fabric.Canvas('ddgarden', {
        renderOnAddRemove: false,
        selection: false
    });

    var itemSize  = 5;

    var circle1 = new fabric.Circle({
        radius: itemSize,
        fill: 'red',
        top: 250,
        left: 250,
    });
    var circle2 = new fabric.Circle({
        radius: itemSize,
        fill: 'green',
        top: 260,
        left: 250,
    });
    var circle3 = new fabric.Circle({
        radius: itemSize,
        fill: 'blue',
        top: 270,
        left: 250,
    });

    //var group = new fabric.Group([ circle1, circle2, circle3 ], {
    //    left: 200,
    //    top: 400
    //});

    bf.add(circle1);
    bf.add(circle2);
    bf.add(circle3);
    bf.add(new fabric.Circle({radius: 10, fill: 'blue', top: 30,  left: 200  }));
    //bf.setActiveObject(bf.item(0));
    //bf.setActiveObject(bf.item(0));
    //bf.add(new fabric.Circle({top:100,left:100,radius:itemSize ,fill:'blue'}));
    bf.item(0).selectable = false;
    var tPoint = new fabric.Point(200,30);
    bf.on('mouse:move', function (options) {
        tPoint = bf.getPointer(options.e);
       // tPoint.y= e.layerY;
       // tPoint.x= e.layerX;
    });

    function animate() {

        var step = 10;
        var variants = [
            new fabric.Point(bf.item(0).left, bf.item(0).top+step),
            new fabric.Point(bf.item(0).left+step, bf.item(0).top),
            new fabric.Point(bf.item(0).left+step, bf.item(0).top+step),
            new fabric.Point(bf.item(0).left-step, bf.item(0).top+step),
            new fabric.Point(bf.item(0).left-step, bf.item(0).top-step),
            new fabric.Point(bf.item(0).left+step, bf.item(0).top-step),
            new fabric.Point(bf.item(0).left-step, bf.item(0).top),
            new fabric.Point(bf.item(0).left, bf.item(0).top-step),
        ];
        var dTmp = 10000;
        var item = -1;
        for (var i=0;i<variants.length;i++){
            var dx = tPoint.x - variants[i].x;
            var dy = tPoint.y - variants[i].y;
            var d = Math.abs( Math.sqrt(dx*dx + dy*dy));
            if (d < dTmp) {
                dTmp = d;
                item=i;
            }
        }

        //var line1 = new fabric.Line([start.x, bf.item(0)._objects[0].top, end.x, end.y], {
        //    stroke: '#000000',
        //    strokeWidth: 6
        //});
        //
        bf.item(2).left = bf.item(1).left;
        bf.item(1).left = bf.item(0).left;
        bf.item(2).top = bf.item(1).top;
        bf.item(1).top = bf.item(0).top;

        if(item > 0){
            bf.item(0).top = variants[item].y;
            bf.item(0).left = variants[item].x;
        }




//
////            console.log(obj.top+ " " +   obj._objects[0].top);
//
//        if ( bf.item(0)._objects[0].top + 420 < 0 ||  bf.item(0)._objects[0].left + 210 < 0 ||  bf.item(0)._objects[0].left + 210 > 500 ||  bf.item(0)._objects[0].top + 420 > 500) {
//            bf.remove( bf.item(0));
//            clearInterval(myGame);
//            return false;
//        }
//
        bf.renderAll();
    };
    var myGame =  setInterval(animate,100);


})(jQuery);
