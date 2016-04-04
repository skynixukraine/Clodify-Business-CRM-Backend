/**
 * Created by Vitaliy on 01.04.2016.
 */

var requestQuoteModals = (function(){

    var bgForPopup,
        popup,
        progressBar,
        step,
        factor = 100/ 5,
        bodyPopap,
        elemStep,
        elem,
        back,
        next,
        quotes;



    function progress(step){

        progressBar.css('width' , factor * step + '%');

    }


return{

    init: function(){

        bgForPopup = $('#request-quote-modals');
        popup = bgForPopup.find(".popup");
        progressBar = $(".progress-bar");
        bodyPopap = popup.find('.body-popap');
        elemStep = bodyPopap.find('> div');
        back = $(".back");
        next =  $(".next");
        quotes = $(".quotes");




        bgForPopup.find(".close").click(function () {

            bgForPopup.fadeOut(1000);
            popup.slideUp(200);

        });

        $(".box-evaluation .en-btn").click(function () {//btn REQUEST A QUOTE

            event.preventDefault();
            bgForPopup.fadeIn(300);
            popup.slideDown(1000);
            alignment();
            return false;

        });



        elemStep.hide().attr("aria-hidden", true);
        elemStep.eq(0).show().attr("aria-hidden", false);

        for(var i=0; i < elemStep.length; i++){

            elemStep.eq(i).data("data-step", i);
        }

        next.click(function(event){
            event.preventDefault();

            elem = bodyPopap.find("[aria-hidden=false]");
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

            elem = bodyPopap.find("[aria-hidden=false]");
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

    }
}






})();



addEventListener("load", requestQuoteModals.init);