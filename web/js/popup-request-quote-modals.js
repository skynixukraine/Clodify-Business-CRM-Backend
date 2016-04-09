/**
 * Created by Vitaliy on 01.04.2016.
 */

var requestQuoteModals = (function(){

    var htmlPage,
        htmlwidth,
        paddingPage,
        htmlHeight,
        popupHeight,
        bgForPopup,
        popup,
        bodyPopap,
        progressBar,
        factor = 100/ 5,
        step,
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
        frontMask;



    function progress(step){

        progressBar.css('width' , factor * step + '%');
        overflowPageY();
    }

    function overflowPageY(){

        htmlwidth = htmlPage.width();


        if(htmlwidth > 768){

            popupHeight     = popup.height();
            paddingPage     = popup.outerHeight();
            
            if((paddingPage) > htmlHeight){

                popup.css('height', htmlHeight - parseInt(popup.css('top'))-10);
                popup.css('overflow-y', 'scroll');

            }else{

                popup.css('overflow-y', 'auto');
                popup.css('height', 'auto');
            }

        }else{

            htmlPage.animate({scrollTop:0},500);
        }


    }


return{

    init: function(){
        htmlPage        = $('body,html');
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



        formStep.hide().attr("aria-hidden", true);
        formStep.eq(0).show().attr("aria-hidden", false);

        for(var i=0; i < formStep.length; i++){

            formStep.eq(i).data("data-step", i);
        }


        $(".box-evaluation .en-btn").click(function (event) {//button open REQUEST A QUOTE

            event.preventDefault();

            bgForPopup.fadeIn(500);
            popup.fadeIn(1000);
            //popup.slideDown(500);

            overflowPageY();

            htmlPage.animate({scrollTop:0},500);

            return false;

        });
        bgForPopup.find(".close").click(function () {// button close popup

            bgForPopup.fadeOut(1000);
            popup.fadeOut(1000);
            //popup.slideUp(500);

        });

        next.click(function(event){//button next formStep
            event.preventDefault();
            elem = bodyPopap.find("[aria-hidden=false]");
            step = elem.data('data-step') + 1;





            if(step == 2){


                checkedElemStep = elem.find("input[name='services[]']:checked");


                if(checkedElemStep.length == 0){

                    console.log("Please make a choose to go ahead");
                    popup.find('.answer-ajax-error').html("Please make a choose to go ahead");
                    step = 2;
                }else{
                    popup.find('.answer-ajax-error').html("");
                    ariaHiddenElem();
                }

            }
            if(step == 1){//skip step 2

                checkedElemStep = elem.find("input:checked");

                if(checkedElemStep.val().indexOf("Active site application") != 0 &&
                    checkedElemStep.val().indexOf("In development") != 0){

                    step += 1;
                    ariaHiddenElem();
                }

            }



            back.css('display' , 'block');

            if(step == 5){

                next.css('display' , 'none');
                quotes.css('display' , 'block');
            }
            if(step != 2){

                ariaHiddenElem();

            }
            function ariaHiddenElem(){

                formStep.eq(step).show().attr("aria-hidden", false);
                elem.hide() .attr("aria-hidden", true);
                progress(step);
            }





            return false;

        });
        back.click(function(event){//button back formStep
            event.preventDefault();


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
            popup.find('.answer-ajax-error').html("");
            frontMask.css('display', 'block' );
            params = popup.find('form').serializeArray();

            formData = new FormData();


            console.log("formData = ", formData);


/************
            for(var i = 0; i < dropdown.length; i++) {

                formData.push({
                    name: dropdown.eq(i).attr('name'),
                    value: dropdown.eq(i).val()
                });

            }
            if(files.value){

                formData.push(files);
            }else{

                formData.push({
                    name: "file",
                    value: ""
                });
            }
*************/
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
                        console.log("Thank You for your effort, Skynix team will process your request as soon as possible and get back to you with quotes.");
                        popup.find('form').css('display', 'none' );
                        popup.find('.answer-ajax').css('display', 'table-cell');


                    } else {

                        frontMask.css('display', 'none' );
                        console.log("Sorry, but we were not able to get your quote. Please check your information and try agian.");
                        popup.find('.answer-ajax-error').html("1Sorry, but we were not able to get your quote. Please check your information and try agian.");
                    }


                }
            });

            return false;
        });

        formStep.find("#file").change(function(e){//create an object with attached files

            file = event.target.files[0];


            return false;
        });

        /*$(".dropdown-menu li").click(function(event) {//dropdown selected

            event.preventDefault();
            var el = $(this),
                value = el.text();

            elem = el.closest(".input-group-btn.select").find(".dropdown-toggle");

            elem.html(value + '<span class="caret1">&or;</span>');
            elem.attr('value', value);


        });*/



    }
}



})();



addEventListener("load", requestQuoteModals.init);
