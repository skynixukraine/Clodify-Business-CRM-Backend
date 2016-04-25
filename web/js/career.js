/**
 * Created by Vitaliy on 11.04.2016.
 */

var career = (function(){

    var BtnReadMore,
        elem,
        popupBox,
        popup,
        txtPopup,
        close,
        htmlPage;



    return{

        init: function(){

            BtnReadMore     = $('.read-more');
            popupBox        = $('.popup-box');
            popup           = popupBox.find('.popup-career');
            close           = popupBox.find('.close');
            htmlPage        = $(window);

            BtnReadMore.click(function(event) {

                event.preventDefault();
                elem        = $(this);
                txtPopup    = elem.closest("article").find(".txt").clone();
                popupBox.css('display', 'block');
                popup.find('.body').html(txtPopup);


                popup.css("top", htmlPage.scrollTop()+10);


                return false

            });
            close.click(function(event) {

                event.preventDefault();
                elem        = $(this);
                popup.find('.body').html("");
                popupBox.css('display', 'none');


                return false
            });

            
        }
    }
})();

addEventListener("load", career.init);


