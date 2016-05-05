/**
 * Created by Vitaliy on 24.03.2016.
 */

var LoginPage = (function(){

    var header,
        scrollY,
        heightW,
        heightH,
        nav;


    return{

        init: function(){

            heightH = $(window).height();
            header = $('.box-header-menu');
            heightW = $('.page').outerHeight(true);//heightW = $('.wrap').height();


            if((heightW)<heightH){

                header.css('box-shadow', 'none');

            }else{

                header.css('box-shadow', '0 2px 8px rgba(100, 192, 239, 0.37)');
            }



            console.log(".page ", heightW);
            console.log("window ",heightH);





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
