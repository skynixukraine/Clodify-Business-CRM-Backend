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
        elemChecked = [],
        checkedElemStep,


        formData;



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
        next            = $(".next");
        quotes          = $(".quotes");
        formData = new FormData();


        bgForPopup.find(".close").click(function () {

            bgForPopup.fadeOut(1000);
            popup.fadeOut(1000);
            popup.slideUp(500);

        });

        $(".box-evaluation .en-btn").click(function () {//btn REQUEST A QUOTE

            event.preventDefault();
            bgForPopup.fadeIn(500);
            popup.fadeIn(1000);
            popup.slideDown(500);



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


            if(step == 1){

                checkedElemStep = elem.find("input:checked");

                if(checkedElemStep.val().indexOf("Active site application") != 0 &&//skip step 2
                    checkedElemStep.val().indexOf("In development") != 0){

                    step += 1;
                }


                formData.append('website_state', checkedElemStep.val());

                console.log(formData);
                console.log(checkedElemStep.val());
             }
            if(step == 2){


                checkedElemStep = elem.find("input:checked");


                for(var i=0; i < checkedElemStep.length; i++){

                    elemChecked.push( checkedElemStep.eq(i).val());
                }

                formData.append('platform', elem.find("[name]").eq(0).val());
                formData.append('services', elemChecked);


            }
            if(step == 3){

                formData.append('backend_platform',  elem.find("[name]").eq(0).val());
                formData.append('frontend_platform', elem.find("[name]").eq(1).val());

            }
            if(step == 4){

                formData.append('when_start',  elem.find("[name]").eq(0).val());
                formData.append('budget',      elem.find("[name]").eq(1).val());
            }
            if(step == 5){

                formData.append('description', elem.find("[name]").eq(0).val());
                formData.append('file',        elem.find("[name]").eq(1).val());

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

            if(step == 1){

                checkedElemStep = elemStep.eq(0).find(":checked");

                if(checkedElemStep.val().indexOf("Active site application") != 0 &&//skip step 2
                    checkedElemStep.val().indexOf("In development") != 0){

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
            elem = bodyPopap.find("[aria-hidden=false]");
            step = elem.data('data-step') + 1;

            json = {step: step, name: elem.find("[name]").eq(0).val(), email: elem.find("[name]").eq(1).val(), company: elem.find("[name]").eq(2).val(), country: elem.find("[name]").eq(3).val()};


            formData.append('name', elem.find("[name]").eq(0).val());
            formData.append('email', elem.find("[name]").eq(1).val());
            formData.append('company', elem.find("[name]").eq(2).val());
            formData.append('country', elem.find("[name]").eq(3).val());

            console.log(formData);


            $.ajax({
                url : popup.find('form').attr("action"),
                type : 'POST',
                data : formData,
                processData: false,
                contentType: false,
                success : function(data) {
                    console.log(data);
                    alert(data);
                }
            });

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
