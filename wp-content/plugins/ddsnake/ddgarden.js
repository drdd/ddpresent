var ddmain = function($){
    var isCollised = false;
    var addNewplant = false;
    var pCursor = null;

    var canvas = canva = oCanvas.create({canvas: "#ddgarden",background: "#fff"});

    canvas.display.register("Plant", {shapeType: "radial"},
        function (canvas) {
        var origin = this.getOrigin(),
            x = this.abs_x - origin.x,
            y = this.abs_y - origin.y,
            strokeColor = this.strokeColor,
            radius = this.radius,
            timeAdd = this.timeAdd,
            time = this.time,
            text = this.text,
            isAdd = this.isAdd;
        this.tx = this.x;
        this.ty = this.y;

        var n = radius / 1;
        var alpha = Math.PI * 2 / n;
        var points = [];
        var i = -1;

        while (i < n){
            var theta = alpha * i;
            var theta2 = alpha * (i + 1);
            points.push({
                x: (Math.cos(theta) * radius) + x,
                y: (Math.sin(theta) * radius) + y,
                ex: (Math.cos(theta2) * radius) + x,
                ey: (Math.sin(theta2) * radius) + y });
            i += 2;
        }

        var leftTime = Math.round(this.time - ((new Date().getTime() - this.timeAdd)/1000));
        if(leftTime > 0) {
            var date = new Date(null);
            date.setSeconds(leftTime);
            var leftdays = date.toISOString().substr(8, 2) - 1;
            this.text = ((leftdays > 0) ? leftdays + " d " : "") + date.toISOString().substr(11, 8);
        }else {
                if(this.timeAdd != 0) {
                    this.text = "ready";
                    if(!this.isBind) {
                        this.bind("mouseenter", function () {
                            canva.mouse.cursor("pointer");
                        }).bind("mouseleave", function () {
                            canva.mouse.cursor("default");
                        }).bind("mouseup", function () {
                            ddreport.toHarvest(this);
                            canva.removeChild(this);
                        });
                        this.isBind = true
                    }

                }
        }

        canvas.beginPath();
        for (var p = 0; p < points.length; p++)
        {
            canvas.moveTo(points[p].x, points[p].y);
            canvas.lineTo(points[p].ex, points[p].ey);
            canvas.strokeStyle = strokeColor;

        }
        canvas.font="10px Georgia";
        canvas.textAlign="center";
        canvas.strokeText(this.text,origin.x,origin.y);
        canvas.stroke();

        canvas.closePath();
    });

    $( "#ddgarden" ).mouseover(function() {
            if(pCursor != null) {
                pCursor.isAdd = true;
            }
        }).mouseout(function() {
            if(pCursor != null) {
                pCursor.isAdd = false;
                canvas.removeChild(pCursor);
            }
        });

    canvas.setLoop(function () {
        if(addNewplant && pCursor != null ) {
            if (pCursor.isAdd)
                canvas.addChild(pCursor);
            pCursor.x = canvas.mouse.x;
            pCursor.y = canvas.mouse.y;
            if (pCursor.isAdd)
                detectCollision();

        }

    }).start();

    var BreakException= {};

    function detectCollision(){
        var cursor = {radius: pCursor.radius*1, x: canvas.mouse.x, y: canvas.mouse.y};
        if(cursor.x + cursor.radius > 500 || cursor.y + cursor.radius > 500 || cursor.x - cursor.radius < 0 || cursor.y - cursor.radius < 0){
            pCursor.strokeColor = "red";
            isCollised = true;
        }else{
            pCursor.strokeColor = "green";
            isCollised = false;
        }
        try {
            if (!isCollised)
                canvas.children.forEach(function (item, i, arr) {
                    if (item.timeAdd != 0) {
                        var circle2 = {radius: item.radius, x: item.x, y: item.y};
                        var dx = cursor.x - circle2.x;
                        var dy = cursor.y - circle2.y;
                        var distance = Math.sqrt(dx * dx + dy * dy);

                        if (distance < cursor.radius + circle2.radius) {
                            pCursor.strokeColor = "red";
                            isCollised = true;
                            throw BreakException;
                        } else {
                            pCursor.strokeColor = "green";
                            isCollised = false;
                        }
                    }
                });
        } catch(e) {
            if (e!==BreakException) throw e;
        }

    }

    return {
        setCursor: function (plant) {
            pCursor = new canvas.display.Plant({
                x: 0,
                y: 0,
                radius: plant.size*1,
                strokeColor: "green",
                text:'',
                time:plant.time,
                info:plant.info,
                timeAdd:0,
                isAdd: false
            });
            pCursor.bind("mouseup", function () {

                if (!isCollised && addNewplant) {
                    var addPlant = new canvas.display.Plant({
                        x: pCursor.x,
                        y: pCursor.y,
                        radius: pCursor.radius,
                        strokeColor: "green",
                        text:'',
                        time:pCursor.time,
                        info:pCursor.info,
                        timeAdd:new Date().getTime(),
                        isAdd: true,
                        isBind: false
                    });

                    canvas.removeChild(pCursor);
                    pCursor = null;
                    canvas.addChild(addPlant);
                    addNewplant = false;

                    ddreport.toPlant(addPlant);
                }
          //      console.log(canvas.children);
                canvas.redraw();
            });
            addNewplant = true;

        },
        saveStage: function(){
            return canvas.children;
        },
        restoreSatge: function(stage){
            stage.forEach(function (item, i, arr) {
                console.log(item);
                var addPlant = new canvas.display.Plant({
                    x: item.tx*1,
                    y: item.ty*1,
                    radius: item.radius,
                    strokeColor: "green",
                    text:'',
                    time:item.time,
                    info:item.info,
                    timeAdd:item.timeAdd,
                    isAdd: item.isAdd
                });
                canvas.addChild(addPlant);
            });

        }


    };
}(jQuery);
