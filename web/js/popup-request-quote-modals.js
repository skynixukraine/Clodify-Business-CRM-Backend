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
        required;



    function progress(step){

        htmlwidth = htmlPage.width();
        progressBar.css('width' , factor * step + '%');


        if(htmlwidth < 768){

            htmlPage.animate({scrollTop:0},500);

        }
    }






return{

    init: function(){
        htmlPage        = $('body, html');
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
        required        = formStep.find('[required]');

        required.attr('data-required', 'null');//The default fields is not filled
        formStep.hide().attr("aria-hidden", true);
        formStep.eq(0).show().attr("aria-hidden", false);

        if(htmlHeight < 900){

            bgForPopup.css('position', 'absolute');

        }else{

            bgForPopup.css('position', 'fixed');
        }


        for(var i=0; i < formStep.length; i++){

            formStep.eq(i).data("data-step", i);
        }

        $(".box-evaluation .en-btn").click(function (event) {//button open REQUEST A QUOTE

            event.preventDefault();

            bgForPopup.fadeIn(500);
            popup.fadeIn(1000);
            popup.slideDown(500);


            htmlPage.animate({scrollTop:0},500);

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

        $( "[required]" ).change(function() {

            $(this).attr('data-required', 'required');

            if($(this).attr('type') == "radio" || $(this).attr('type') == "checkbox"){

                $(this).closest(".step").find(".option-group input").attr('data-required', 'required');
            }

        });
        next.click(function(event){//button next formStep
            event.preventDefault();

            elem = bodyPopap.find("[aria-hidden=false]");
            required = elem.find("[data-required=null]");
            message.html("");
            console.log("step  ", step);


            if(required.length > 0){

                console.log("Please make a choose to go ahead");
                error.html("Please make a choose to go ahead");
                return false

            }else{

                error.html("");

            }


            if(step == 0){

                checkedElemStep = elem.find("input:checked");

                if(checkedElemStep.val().indexOf("Active site application") != 0 &&
                    checkedElemStep.val().indexOf("In development") != 0){

                    step = 2;
                    back.css('display' , 'block');
                    ariaHiddenElem();
                    return false
                }

            }
            if(step == 1){

                checkedElemStep = elem.find("input[name='services[]']:checked");

                if(required.length > 0 || checkedElemStep.length == 0){

                    console.log("Please make a choose to go ahead");
                    error.html("Please make a choose to go ahead");
                    return false

                }else{

                    error.html("");

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

                    step -= 1;
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
            required = elem.find("[data-required=null]");

            if(required.length > 0){

                console.log("Please make a choose to go ahead");
                error.html("Please make a choose to go ahead");
                return false

            }else{

                error.html("");

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
                        error.html("1Sorry, but we were not able to get your quote. Please check your information and try agian.");
                    }


                }
            });

            return false;
        });


    }
}



})();



addEventListener("load", requestQuoteModals.init);
