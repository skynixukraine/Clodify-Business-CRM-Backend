/**
 * Created by Vitaliy on 15.04.2016.
 */

var Portfolio  = (function(){

    var htmlPage,
        htmlHeight,
        runPopap,
        bgForPopup,
        popup;

    return{

        init: function(){
            htmlPage        = $(window);
            runPopap        = $('.portfolio-sample a');
            bgForPopup  = $('#view_portfolio');
            popup           = bgForPopup.find(".popup");

            jQuery('#slider_portfolio').tinycarousel();

            runPopap.click(function(event){

                event.preventDefault();

                htmlHeight      = htmlPage.height();
                bgForPopup.fadeIn(200);
                popup.fadeIn(300);
                popup.slideDown(200);

                if(htmlHeight > 900){

                    popup.css("top", htmlPage.scrollTop()+(htmlHeight - 850)/2);

                }else{

                    popup.css("top", htmlPage.scrollTop()+10);
                }

                return false;

            });

            bgForPopup.find(".close").click(function () {// button close popup

                bgForPopup.fadeOut(200);
                popup.fadeOut(300);
                popup.slideUp(200);

            });

        }
    }

})();

addEventListener("load", Portfolio.init);


