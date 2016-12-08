/**
 * Created by Vitaliy on 28.04.2016.
 */

var skynixCanvas = (function(){

    var elem1,
        elem2,
        elem3,
        width,
        height,
        nextGameStep = (function(){//for cycle canvas
            return window.requestAnimationFrame    ||
                window.webkitRequestAnimationFrame ||
                window.mozRequestAnimationFrame    ||
                window.oRequestAnimationFrame      ||
                window.msRequestAnimationFrame     ||
                function(callback){
                    window.setTimeout(callback, 1000/60);//60 - FPS
                };
        })(),
        stop = false,
        canvas = false;

    function SizeCanvas (){//Size canvas

        stop = true;
        width = $('html').width();


        if(width > 480-17){

            height = 573;

        }else{

            height = 324;
        }

        if($(elem1).get(0).getContext){

            elem1.get(0).width  = width;
            elem1.get(0).height = height;
            elem2.get(0).width  = width;
            elem2.get(0).height = height;
            elem3.get(0).width  = width;
            elem3.get(0).height = height;
        }

        if((canvas == false) && (width > 480)){

            restart();
        }

    }
    function restart(){

        if(width > 480) {
            canvas = true;
            BuildCanvas(elem1, elem2, elem3, width, height);
        }else{
            canvas = false;
        }
    }
    function BuildCanvas(elem1, elem2, elem3, width , height){

        var ctx1 = elem1[0].getContext('2d'),
            ctx2 = elem2[0].getContext('2d'),
            ctx3 = elem3[0].getContext('2d'),

            pointFunction,//=>callback = (layer1(){} || layer2(){} || layer3(){})
            imgPoint = [],
            dt;//time adjustment

        ctx1.clearRect(0, 0, elem1.get(0).width, elem1.get(0).height);
        ctx2.clearRect(0, 0, elem2.get(0).width, elem2.get(0).height);
        ctx3.clearRect(0, 0, elem3.get(0).width, elem3.get(0).height);


        imgPoint[0] = new Image();
        imgPoint[1] = new Image();
        imgPoint[2] = new Image();
        imgPoint[0].src = "../img/point1.png";
        imgPoint[1].src = "../img/point2.png";
        imgPoint[2].src = "../img/point3.png";


        function Point(img, coordinates, poinSize, speed) {
            this.img = img;
            this.coordinates = coordinates;
            this.poinSize = poinSize;
            this.speed = speed;
        }
        if(width > 950){

            var point1 = new Point(imgPoint[0],
                [{x: 447, y: 0}, {x: 447, y: 66}, {x: 1534, y: 66}, {x: 1534, y: 255}],
                30,
                12);
            var point2 = new Point(imgPoint[1],
                [{x: 925, y: 465}, {x: 925, y: 520}, {x: 2000, y: 520}],
                16,
                10);
            var point3 = new Point(imgPoint[2],
                [{x: 694, y: 226}, {x: 694, y: 132}, {x: 814, y: 132}, {x: 814, y: 0}],
                14,
                6);
        }
        if(width <= 950 && width > 768){

            var point1 = new Point(imgPoint[0],
                [{x: 318, y: 0}, {x: 318, y: 36}, {x: 950, y: 36}],
                30,
                12);

            var point2 = new Point(imgPoint[1],
                [{x: 25, y: 544}, {x: 25, y: 157}, {x: 365, y: 157}, {x: 365, y: 113}, {x: 407, y: 113}, {x: 407, y: 0} ],
                16,
                10);
            var point3 = new Point(imgPoint[2],
                [{x: 796, y: 410}, {x: 796, y: 492}, {x: 950, y: 492}],
                14,
                6);

        }
        if(width <= 768 && width > 480){

            var point1 = new Point(imgPoint[0],
                [{x: 318, y: 0}, {x: 318, y: 66}, {x: 751, y: 66}],
                30,
                12);

            var point2 = new Point(imgPoint[1],
                [{x: 25, y: 560}, {x: 25, y: 187}, {x: 365, y: 187}, {x: 365, y: 142}, {x: 407, y: 142}, {x: 407, y: 0} ],
                16,
                10);
            var point3 = new Point(imgPoint[2],
                [{x: 0, y: 314}, {x: 26, y: 314}, {x: 26, y: 409}, {x: 227, y: 409}, {x: 228, y: 503},  {x: 347, y: 503},
                    {x: 347, y: 580}, {x: 479, y: 580}, {x: 479, y: 527}, {x: 563, y: 527}, {x: 563, y: 490}],
                14,
                6);

        }

        /* if(width < 480){

         var point1 = new Point(imgPoint[0],
         [{x: 93, y: 0}, {x: 93, y: 30}, {x: 480, y: 30}],
         30,
         12);

         var point2 = new Point(imgPoint[1],
         [{x: 114, y: 316}, {x: 114, y: 282}, {x: 39, y: 281}, {x: 38, y: 235}, {x: 12, y: 235}, {x: 12, y: 146}, {x: 103, y: 146}, {x: 103, y: 128}, {x: 103, y: 128}, {x: 135, y: 128}, {x: 135, y: 110}, {x: 152, y: 110}, {x: 152, y: 0} ],
         16,
         10);
         var point3 = new Point(imgPoint[2],
         [{x: 187, y: 280}, {x: 187, y: 302}, {x: 480, y: 302}],
         14,
         6);

         }*/

        Point.prototype.x = 0;
        Point.prototype.y = 0;
        Point.prototype.xclear = 0;
        Point.prototype.yclear = 0;
        Point.prototype.poinRoute = null;
        Point.prototype.alpha = 1;
        Point.prototype.rateAlpha = 0;
        Point.prototype.xyAlpha = 0;

        Point.prototype.animationController = function(layer){

            if((Math.abs(this.poinRoute) == 1) || (Math.abs(this.poinRoute) == this.coordinates.length - 1)){

                this.alphaParser(layer);
            }

        };
        Point.prototype.parser = function(layer){

            var length = this.coordinates.length,
                index;

            if(this.poinRoute == null){

                this.xclear = this.x;
                this.yclear = this.y;

                randomRoute(this);

            }else{

                this.xclear = this.x;
                this.yclear = this.y;
            }

            this.animationController(layer);

            if(this.poinRoute > 0){

                if((length - this.poinRoute) > 0){

                    index = this.poinRoute;
                }else{

                    index = length-1;
                }

                go(this);

                if(( Math.abs(this.x - this.coordinates[index].x) <= 1*this.speed * dt) &&
                    (Math.abs(this.y - this.coordinates[index].y) <= 1*this.speed * dt) &&
                    (length != this.poinRoute)){

                    this.x = this.coordinates[index].x;
                    this.y = this.coordinates[index].y;
                    this.poinRoute += 1;
                }


                if( Math.floor(this.x) == this.coordinates[index].x   &&
                    Math.floor(this.y) == this.coordinates[index].y   &&
                    length == this.poinRoute){

                    this.poinRoute = null;
                }

            }

            if(this.poinRoute < 0){

                if((length + this.poinRoute) > 0){

                    index = (length + this.poinRoute)-1;
                }else{

                    index = 0;
                }

                go(this);

                if(( Math.abs(this.x - this.coordinates[index].x) <= 1*this.speed * dt)&&
                    (Math.abs(this.y - this.coordinates[index].y) <= 1*this.speed * dt)){

                    this.x = this.coordinates[index].x;
                    this.y = this.coordinates[index].y;
                    this.poinRoute -= 1;

                }
                if( Math.floor(this.x) == this.coordinates[index].x  &&
                    Math.floor(this.y) == this.coordinates[index].y  &&
                    index == 0  ){

                    this.poinRoute = null;
                }
            }

            function go(obj){


                if(obj.y < obj.coordinates[index].y){

                    obj.y += obj.speed * dt;
                }
                if(obj.y > obj.coordinates[index].y){

                    obj.y -= obj.speed * dt;
                }
                if(obj.x < obj.coordinates[index].x){

                    obj.x += obj.speed * dt;
                }
                if(obj.x > obj.coordinates[index].x){

                    obj.x -= obj.speed * dt;
                }

            }

        };
        Point.prototype.alphaParser = function(layer){

            var length = this.coordinates.length,
                obj_xy = this.x + this.y;

            if(this.poinRoute == 1){

                if((Math.floor(this.x) == this.coordinates[0].x) &&
                    (Math.floor(this.y) == this.coordinates[0].y)){

                    this.alpha = 0;
                    stepAlpha(this, 1);

                }
                runAlpha(this, 1);
            }
            if(this.poinRoute == length-1){

                if((Math.floor(this.x) == this.coordinates[length - 2].x) &&
                    (Math.floor(this.y) == this.coordinates[length - 2].y)){

                    stepAlpha(this, length - 1);

                }
                runAlpha(this, length - 1);

            }
            if(this.poinRoute == -1){

                if((Math.floor(this.x) == this.coordinates[length - 1].x) &&
                    (Math.floor(this.y) == this.coordinates[length - 1].y)){

                    if(length > 2){

                        this.alpha = 0;
                        stepAlpha(this, length - 2);

                    }else{

                        obj.xyAlpha = 0;
                        obj.rateAlpha = 0;
                    }

                }
                runAlpha(this, length - 2);


            }
            if(this.poinRoute == -1 * length + 1){

                if((Math.floor(this.x) == this.coordinates[1].x) &&
                    (Math.floor(this.y) == this.coordinates[1].y)){

                    stepAlpha(this, 0);
                }

                runAlpha(this, 0);

            }

            function stepAlpha(obj, index){

                var coordinates_xy = obj.coordinates[index].x + obj.coordinates[index].y;

                if( obj_xy != coordinates_xy){

                    obj.xyAlpha = (coordinates_xy - obj_xy);

                    if(obj.xyAlpha >= 51*obj.speed * dt){

                        obj.xyAlpha = obj_xy + 50*obj.speed * dt;
                        obj.rateAlpha = 0.02*obj.speed * dt;

                    }
                    if(obj.xyAlpha <= -51*obj.speed * dt){

                        obj.xyAlpha = obj_xy - 50*obj.speed * dt;
                        obj.rateAlpha = 0.02*obj.speed * dt;

                    }
                    if((obj.xyAlpha < 51*obj.speed * dt) && (obj.xyAlpha > 0) ||
                        (obj.xyAlpha > -51*obj.speed * dt) && (obj.xyAlpha < 0)){

                        obj.rateAlpha = Math.abs(1/obj.xyAlpha)*obj.speed * dt;

                    }

                }else{
                    obj.xyAlpha = 0;
                    obj.rateAlpha = 0;
                }
            }
            function runAlpha(obj, index){


                var coordinates_xy = obj.coordinates[index].x + obj.coordinates[index].y;

                if(Math.abs(obj.poinRoute) == 1){

                    layer.globalAlpha = obj.alpha;

                    if((obj_xy < coordinates_xy) && (obj_xy <= obj.xyAlpha)){

                        obj.alpha = obj.alpha + obj.rateAlpha;

                    }
                    if((obj_xy > coordinates_xy) && (obj_xy >= obj.xyAlpha)){

                        obj.alpha = obj.alpha + obj.rateAlpha;
                    }
                    if(((obj_xy > coordinates_xy)   &&
                        (obj_xy < obj.xyAlpha))     ||
                        ((obj_xy < coordinates_xy)  &&
                        (obj_xy > obj.xyAlpha))){

                        obj.rateAlpha = 0;
                        obj.alpha = 0.9;

                    }
                }
                if(Math.abs(obj.poinRoute) == length-1){

                    layer.globalAlpha = obj.alpha;

                    if((obj_xy < coordinates_xy) && ((coordinates_xy - obj_xy) <= 50)){

                        obj.alpha = obj.alpha - obj.rateAlpha;
                    }

                    if((obj_xy > coordinates_xy) && ((obj_xy - coordinates_xy) <= 50)){

                        obj.alpha = obj.alpha - obj.rateAlpha;

                    }
                    if(Math.abs(coordinates_xy - obj_xy) <= 1*obj.speed * dt ){

                        obj.rateAlpha = 0;
                        obj.alpha = 0;
                    }
                }

            }

        };


        function buildCycle(){

            var now,//time adjustment
                lastTime = Date.now(),//time adjustment
                screenWidth;//Object point1 - point9



            /*It starts the cycle*/
            var engineStart = function(callback){
                pointFunction = callback;
                engineStep();

            };
            /*Create a loop using the selected function*/
            var engineStep = function(callback){

                pointFunction(); //run callback

                if(!stop){

                    nextGameStep(engineStep);

                }
                if(stop){

                    stop = false;
                    delete point1;
                    delete point2;
                    delete point3;
                    nextGameStep(restart);

                }

            };
            var setPointEngine = function(callback){

                pointFunction = callback;
            };

            var layer1 = function(){

                now = Date.now();
                dt = (now - lastTime) / 1000.0;//1px in 1second

                if(dt > 3){

                    dt = 1;
                    ctx1.clearRect(0, 0, width, height);
                }

                point1.parser(ctx1);


                if(width >= 950){

                    if(point1.poinRoute == null){


                        if(point1.poinRoute == 1){

                            //ctx1.save();
                            //ctx1.translate( 417, 0 );
                            //ctx1.scale(0.1, 0.1);

                        }else{

                            //ctx1.save();
                            //ctx1.translate( 1504, 255 );
                            //ctx1.scale(0.1, 0.1);
                        }

                    }
                    if(point1.poinRoute == 1){


                        if(point1.y < 20){

                            //ctx1.translate( -37, 0.1);
                            //ctx1.scale(1.04, 1.05);


                        }else{
                            //ctx1.restore();
                        }

                    }
                    if(point1.poinRoute == -1){


                        if(point1.y>235){


                            //ctx1.translate( 100,100);
                            // ctx1.scale(1.13, 1.13);


                        }else{
                            //ctx1.restore();
                        }

                    }


                }
                if(width < 950 && width > 480){}
                if(width < 480){}

                screenWidth = point1;


                render(ctx1, screenWidth,layer2, false);


            };
            var layer2 = function(){

                if(dt > 3){

                    dt = 1;
                    ctx2.clearRect(0, 0, width, height);
                }

                point2.parser(ctx2);

                if(width >= 950){}
                if(width < 950 && width > 480){}
                if(width < 480){}

                screenWidth = point2;

                render(ctx2, screenWidth, layer3, false);
            };
            var layer3 = function(){

                if(dt > 3){

                    dt = 1;
                    ctx3.clearRect(0, 0, width, height);

                }

                point3.parser(ctx3);

                if(width >= 950){}
                if(width < 950 && width > 480){}
                if(width < 480){}
                screenWidth = point3;
                render(ctx3, screenWidth, layer1, false);

            };

            function render(layer, obj, func, cleaningAllLayer) {


                var ctx = layer,
                    size = obj.poinSize,
                    double = size* 3;
                ctx.beginPath();

                if(cleaningAllLayer == true){

                    ctx.clearRect(0, 0, width, height);

                }

                ctx.clearRect(obj.xclear-size, obj.yclear-size, double, double);


                ctx.drawImage(obj.img, obj.x, obj.y);



                lastTime = now;
                setPointEngine(func);
            }

            engineStart(layer1);//run canvas

        }
        buildCycle();


        function randomRoute(obj){

            var r = Math.random(),
                coordinetesLength;

            if(obj.coordinates){

                if(r < 0.5){

                    coordinetesLength = obj.coordinates.length-1;
                    obj.poinRoute = -1;
                    obj.x = obj.coordinates[coordinetesLength].x;
                    obj.y = obj.coordinates[coordinetesLength].y;

                }else{

                    obj.poinRoute = +1;
                    obj.x = obj.coordinates[0].x;
                    obj.y = obj.coordinates[0].y;


                }
            }
        }



    }




    return{

        init: function(){

            elem1 = $('#canvas1');
            elem2 = $('#canvas2');
            elem3 = $('#canvas3');


            $( window ).resize(SizeCanvas);

            SizeCanvas ();


        }
    }

})();


$(function(){

    skynixCanvas.init();

});






