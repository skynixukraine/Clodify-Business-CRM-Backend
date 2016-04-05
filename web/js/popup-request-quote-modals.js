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
        quotes,
        select,
        parentElem,
        step1,
        checkedElemStep1;


    function progress(step){

        progressBar.css('width' , factor * step + '%');

    }


return{

    init: function(){

        bgForPopup      = $('#request-quote-modals');
        popup           = bgForPopup.find(".popup");
        progressBar     = $(".progress-bar");
        bodyPopap       = popup.find('.body-popap');
        elemStep        = bodyPopap.find('> div');
        back            = $(".back");
        next            =  $(".next");
        quotes          = $(".quotes");
        step1           = $('.step1 .option-group');




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

        next.click(function(event){//button next
            event.preventDefault();
            elem = bodyPopap.find("[aria-hidden=false]");
            step = elem.data('data-step') + 1;


            if(step == 1){//skip step 2

                checkedElemStep1 = step1.find(":checked");

                if(checkedElemStep1.val().indexOf("Active site/application") != 0 &&
                    checkedElemStep1.val().indexOf("In development") != 0){

                    step += 1;
                }

             }

            elemStep.eq(step).show().attr("aria-hidden", false);
            elem.hide() .attr("aria-hidden", true);
            back.css('display' , 'block');

            if(step == 5){

                next.css('display' , 'none');
                quotes.css('display' , 'block');
            }

            progress(step);

            return false;

        });
        back.click(function(event){//button back
            event.preventDefault();

            elem = bodyPopap.find("[aria-hidden=false]");
            step = elem.data('data-step') -1;


            if(step == 1){//skip step 2

                checkedElemStep1 = step1.find(":checked");

                if(checkedElemStep1.val().indexOf("Active site/application") != 0 &&
                    checkedElemStep1.val().indexOf("In development") != 0){

                    step -= 1;
                }

            }
            elemStep.eq(step).show().attr("aria-hidden", false);
            elem.hide() .attr("aria-hidden", true);

            if(step == 0){

                back.css('display' , 'none');
            }

            next.css('display' , 'block');
            quotes.css('display' , 'none');

            progress(step);

            return false;

        });
        quotes.click(function(event){//button 'GET MY QUOTES'
            event.preventDefault();

            return false;
        });

        $(".dropdown-menu li").click(function(event) {//dropdown selected

            event.preventDefault();
            var el = $(this),
                value = el.text();
            select = el.closest(".input-group-btn.select");
            parentElem = select.find(".dropdown-toggle");

            parentElem.html(value + '<span class="caret1">&or;</span>');
            parentElem.attr('value', value);


        });



    }
}






})();



addEventListener("load", requestQuoteModals.init);