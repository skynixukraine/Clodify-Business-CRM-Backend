/**
 * Created by Vitaliy on 24.03.2016.
 */

var LoginPage = (function(){



    return{

        init: function(){

            var header = $('.box-header-menu'),
                scrollY;

            function correctionPage(){

                    var heightW = $('.wrap').height(),
                    heightH = $('html').height();

                if(heightW<heightH){

                    header.css('box-shadow', 'none');

                }else{

                    header.css('box-shadow', '0 2px 8px rgba(100, 192, 239, 0.37)');
                }

            }

            function headerScroll(){

                $(document).scroll(function() {

                    scrollY = $(document).scrollTop();

                    if(scrollY > 100){

                        header.addClass('fix-height');
                    }else{
                        header.removeClass('fix-height');
                    }

                });
            }
            headerScroll();

            correctionPage();

        }
    }



})();

$(function(){

    LoginPage.init();

});
