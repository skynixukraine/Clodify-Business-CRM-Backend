/**
 * Created by Vitaliy on 11.04.2016.
 */

var career = (function(){

    var BtnReadMore,
        elem,
        popupBox,
        popup,
        txtPopup,
        close;

    /*var BtnReadMore,
        articleShow,
        htmlPage,
        elem;*/

    return{

        init: function(){

            BtnReadMore     = $('.read-more');
            popupBox        = $('.popup-box');
            popup           = popupBox.find('.popup-career');
            close           = popupBox.find('.close');

            BtnReadMore.click(function(event) {

                event.preventDefault();
                elem        = $(this);
                txtPopup    = elem.closest("article").find(".txt").clone();
                popupBox.css('display', 'block');
                popup.find('.body').html(txtPopup);
                popup.css('top', elem.closest("article").position().top);


console.log(elem.closest("article").position().top);

                return false

            });
            close.click(function(event) {

                event.preventDefault();
                elem        = $(this);
                popup.find('.body').html("");
                popupBox.css('display', 'none');


                return false
            });



            /*htmlPage        = $('body, html');
            BtnReadMore     = $('.read-more');




            BtnReadMore.click(function(event) {

                event.preventDefault();
                elem = $(this);
                articleShow = $('.show-text');

                if(articleShow.length != 0) {

                    articleShow.closest("article").animate({height: '225px'}, {
                        duration: 800
                    });
                    articleShow.removeClass('show-text');

                }

                elem.closest("article").animate({height: '100%'},{
                    duration: 800
                });

                elem.closest("article").addClass('show-text');

                setTimeout(scrolling, 900);

                function scrolling(){

                    htmlPage.animate({scrollTop: elem.closest("article").position().top},200);

                }

            });*/
            
        }
    }
})();

addEventListener("load", career.init);


