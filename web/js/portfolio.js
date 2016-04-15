/**
 * Created by Vitaliy on 15.04.2016.
 */

var Portfolio  = (function(){

    var htmlPage,
        htmlHeight,
        runPopap,
        bgForPopup,
        popup,
        infoBox,
        txtPopap,
        btnPopupVisit,
        el,
        elem,
        dataHref,
        dataImages,
        img = [],
        overview;

    return{

        init: function(){
            htmlPage        = $(window);
            runPopap        = $('.portfolio-sample a');
            bgForPopup      = $('#view_portfolio');
            popup           = bgForPopup.find(".popup");
            infoBox         = popup.find(".info-box");
            btnPopupVisit   = popup.find(".read-more");

                overview = popup.find(".overview");



            runPopap.click(function(event){

                event.preventDefault();

                /*********create popup************/
                infoBox.html("");
                el=$(event.target);
                elem = el.closest(".portfolio-sample").find(".info-box-hidden");
                dataImages = el.closest("a").attr('data-images');
                dataHref = el.closest("a").attr('data-href');
                txtPopap = elem.clone();
                btnPopupVisit.attr('href', dataHref);

                var ss = dataImages.split(", ");
                for (var i in ss) {

                    img[i] = new Image().src = 'images/' + ss[i];

                    overview.append("<li><img width=\"1080\" height=\"1920\"src="+ img[i] +"></li>");

                }
                infoBox.html(txtPopap);

                jQuery('#slider_portfolio').tinycarousel();
                /*********End create popup************/






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


