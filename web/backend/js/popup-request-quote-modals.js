/**
 * Created by Vitaliy on 01.04.2016.
 */

var requestQuoteModals = (function(){

    var htmlPage,
        htmlwidth,
        htmlHeight,
        bgForPopup,
        popup,
        bodyPopap,
        progressBar,
        factor = 100/ 5,
        step = 0,
        formStep,
        elem,
        checkedElemStep,
        back,
        next,
        quotes,
        dropdown,
        formData,
        params,
        files,
        file,
        frontMask,
        message,
        error,
        hasErrors;




    function progress(step){

        htmlwidth = htmlPage.width();
        progressBar.css('width' , factor * step + '%');

    }

    function validateForm(elem){

        hasErrors = false;
        error.html("");

        elem.find("input, select, textarea").each(function(){

            var el = $(this),
                tag = el.get(0).tagName,
                tagType;

            if(tag == 'INPUT'){

                tagType = el.eq(0).attr('type');

                if ( tagType == 'checkbox' && elem.find('[name=\'' + el.prop('name') + '\']:checked').length == 0 ) {

                    error.html("Please make a choose to go ahead");
                    hasErrors = true;
                    return false;

                } else if ( tagType == 'radio' && elem.find('[name=\'' + el.prop('name') + '\']:checked').length == 0 ) {

                    error.html("Please make a choose to go ahead");
                    hasErrors = true;
                    return false;
                }else if(el.prop('type') != 'file' && el.context.validity.valid == false && tagType != 'checkbox' ){

                    error.html("Please make a choose to go ahead");
                    hasErrors = true;
                    return false
                }



            }else if ( el.prop('type') != 'file' && !el.val()){


                error.html("Please make a choose to go ahead");
                hasErrors = true;
                return false;
            }





        });
    }

    return{

        init: function(){
            htmlPage        = $(window);
            bgForPopup      = $('#request-quote-modals');
            popup           = bgForPopup.find(".popup");
            progressBar     = $(".progress-bar");
            bodyPopap       = popup.find('.body-popap');
            formStep        = bodyPopap.find('> div');
            dropdown        = formStep.find("[data-toggle=dropdown]");
            back            = $(".back");
            next            = $(".next");
            quotes          = $(".quotes");
            frontMask       = bgForPopup.find('.front-mask');
            htmlHeight      = htmlPage.height();
            message         = popup.find('.message');
            error           = popup.find('.answer-ajax-error');


            formStep.hide().attr("aria-hidden", true);
            formStep.eq(0).show().attr("aria-hidden", false);

            for(var i=0; i < formStep.length; i++){

                formStep.eq(i).data("data-step", i);
            }







            $(".box-evaluation .en-btn").click(function (event) {//button open REQUEST A QUOTE

                event.preventDefault();

                bgForPopup.fadeIn(200);
                popup.fadeIn(300);
                popup.slideDown(200);

                popup.css("top", htmlPage.scrollTop()+10);


                return false;

            });

            bgForPopup.find(".close").click(function () {// button close popup

                bgForPopup.fadeOut(1000);
                popup.fadeOut(1000);
                popup.slideUp(500);

            });

            formStep.find("#file").change(function(e){//create an object with attached files

                file = event.target.files[0];
                message.html("The attachment has been successfully attached!");

                return false;
            });

            next.click(function(event){//button next formStep
                event.preventDefault();

                elem = bodyPopap.find("[aria-hidden=false]");

                validateForm(elem);

                if(hasErrors){

                    return false
                }

                if(step == 0){

                    checkedElemStep = elem.find("input:checked");

                    //skip step 2
                    if(checkedElemStep.val().indexOf("Active site application") != 0 &&
                        checkedElemStep.val().indexOf("In development") != 0){

                        step = 2;
                        back.css('display' , 'block');
                        ariaHiddenElem();
                        return false
                    }

                }
                if(step == 1){

                    //skip step 3
                    checkedElemStep = formStep.eq(0).find(":checked");
                    if(checkedElemStep.val().indexOf("Active site application") == 0 ||
                        checkedElemStep.val().indexOf("In development") == 0){

                        step = 3;
                        ariaHiddenElem();
                        return false

                    }
                }

                step = elem.data('data-step') + 1;
                back.css('display' , 'block');

                if(step == 5){

                    next.css('display' , 'none');
                    quotes.css('display' , 'block');
                }

                ariaHiddenElem();

                function ariaHiddenElem(){

                    formStep.eq(step).show().attr("aria-hidden", false);
                    elem.hide() .attr("aria-hidden", true);
                    progress(step);
                }

                return false;

            });

            back.click(function(event){//button back formStep
                event.preventDefault();

                message.html("");
                popup.find('.answer-ajax-error').html("");
                elem = bodyPopap.find("[aria-hidden=false]");
                step = elem.data('data-step') -1;

                if(step == 1){//skip step 2

                    checkedElemStep = formStep.eq(0).find(":checked");

                    if(checkedElemStep.val().indexOf("Active site application") != 0 &&
                        checkedElemStep.val().indexOf("In development") != 0){

                        step = 0;

                    }

                }
                console.log("step = " + step);
                if(step == 2){//skip step 3

                    if(checkedElemStep.val().indexOf("Active site application") == 0 ||
                        checkedElemStep.val().indexOf("In development") == 0){

                        step = 1;

                    }
                }

                formStep.eq(step).show().attr("aria-hidden", false);
                elem.hide() .attr("aria-hidden", true);

                if(step == 0){

                    back.css('display' , 'none');
                }
                console.log(step);

                if(step == 4) {
                    next.css('display', 'block');
                    quotes.css('display', 'none');
                }

                progress(step);


                return false;

            });


            quotes.click(function(event){//button 'GET MY QUOTES'

                event.preventDefault();

                elem = bodyPopap.find("[aria-hidden=false]");
                validateForm(elem);

                console.log(hasErrors);
                if(hasErrors){

                    return false
                }

                frontMask.css('display', 'block' );
                params = popup.find('form').serializeArray();

                formData = new FormData();


                for (var i = 0; i < params.length; i++) {
                    formData.append( params[i]['name'], params[i]['value']);
                }
                if ( file ) {
                    formData.append( 'file', file );
                }

                $.ajax({
                    url : popup.find('form').attr("action"),
                    type : 'POST',
                    data : formData,
                    processData: false,
                    contentType: false,
                    dataType: 'json',
                    success : function(data) {

                        if (data.success) {

                            frontMask.css('display', 'none' );
                            popup.find('form').css('display', 'none' );
                            popup.find('.answer-ajax').css('display', 'table-cell');


                        } else {

                            frontMask.css('display', 'none' );
                            error.html("Sorry, but we were not able to get your quote. Please check your information and try agian.");
                        }

                    }
                });

                return false;
            });


        }
    }


})();

$(function(){

    requestQuoteModals.init();

});

