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
            heightW = $('.wrap').outerHeight(true);//heightW = $('.wrap').height();
            nav = $('nav').height();

            if((heightW + nav)<heightH){

                header.css('box-shadow', 'none');

            }else{

                header.css('box-shadow', '0 2px 8px rgba(100, 192, 239, 0.37)');
            }



            console.log(".page ", heightW);
            console.log("window ",heightH);
            console.log("nav ",nav);




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
