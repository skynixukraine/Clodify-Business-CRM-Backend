/**
 * Created by Vitaliy on 24.03.2016.
 */

var LoginPage = (function(){

    var header,
        scrollY,
        heightP,
        windowH;


    return{

        init: function(){

            windowH = $(window).height();
            heightP = $('.page').outerHeight(true);
            header = $('.box-header-menu');

            if(heightP < (windowH/1.4)){

                header.css('box-shadow', 'none');

            }else{

                header.css('box-shadow', '0 2px 8px rgba(100, 192, 239, 0.37)');
            }

            $(document).scroll(function() {

                scrollY = $(document).scrollTop();

                if(scrollY > 100){

                    header.addClass('fix-height');

                }else{

                    header.removeClass('fix-height');
                }

            });





        }
    }



})();

$(function(){

    LoginPage.init();



});
