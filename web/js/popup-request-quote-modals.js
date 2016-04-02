/**
 * Created by Vitaliy on 01.04.2016.
 */

var requestQuoteModals = (function(){

    var popup,
        boxPopup,
        html,
        progressBar,
        step = "20%";

    function alignment(){

        var heightP = boxPopup.height() + parseFloat(boxPopup.css("padding-top")) + parseFloat(boxPopup.css("padding-bottom")),
            widthP = boxPopup.width() + parseFloat(boxPopup.css("padding-right"))*2,
            widthHtml = html.width(),
            heightHtml = html.height();

        if(widthHtml > 949){

            marginUp = 30;

        }else{

            marginUp = 0;
        }

        popup.css('height', heightHtml);
        boxPopup.css('top', (heightHtml - heightP)/2 + marginUp);
        boxPopup.css('left', (widthHtml - widthP)/2);

    }

    function progress(step){


        if(step == 0){

            progressBar.css('width' , '0');
        }
        if(step == 1){

            progressBar.css('width' , '20%');

        }
        if(step == 2){

            progressBar.css('width' , '40%');

        }
        if(step == 3){

            progressBar.css('width' , '60%');
        }
        if(step == 4){

            progressBar.css('width' , '80%');
        }
        if(step == 5){

            progressBar.css('width' , '100%');
        }


    }




return{

    init: function(){

        popup = $('#request-quote-modals');
        boxPopup = popup.find(".box-popup");
        html = $('html');
        progressBar = $(".progress-bar");



        $(window).resize(alignment);


        popup.find(".close").click(function () {

            popup.fadeOut(1000);
            boxPopup.slideUp(200);

        });

        $(".box-evaluation .en-btn").click(function () {//btn REQUEST A QUOTE


            popup.fadeIn(300);
            boxPopup.slideDown(1000);
            alignment();

        });

        var configureTabSelection = function() {

            var elemStep = $(".body-popap > div"),
                elem,
                back = $(".back"),
                next =  $(".next"),
                quotes = $(".quotes");

            elemStep.hide().attr("aria-hidden", true);
            elemStep.eq(0).show().attr("aria-hidden", false);

            for(var i=0; i < elemStep.length; i++){

                elemStep.eq(i).data("data-step", i);
            }

            next.click(function(event){
                event.preventDefault();

                elem = $("[aria-hidden=false]");
                step = elem.data('data-step') + 1;
                elemStep.eq(step).show().attr("aria-hidden", false);
                elem.hide() .attr("aria-hidden", true);
                back.css('display' , 'block');


                if(step == 5){

                    next.css('display' , 'none');
                    quotes.css('display' , 'block');
                }

                progress(step);

            });
            back.click(function(event){
                event.preventDefault();

                elem = $("[aria-hidden=false]");
                step = elem.data('data-step') -1;
                elemStep.eq(step).show().attr("aria-hidden", false);
                elem.hide() .attr("aria-hidden", true);

                if(step == 0){

                    back.css('display' , 'none');
                }

                    next.css('display' , 'block');
                    quotes.css('display' , 'none');

                progress(step);

            });
            quotes.click(function(event){
                event.preventDefault();
            });


        };
        configureTabSelection();

    }
}






})();



addEventListener("load", requestQuoteModals.init);