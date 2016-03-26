/**
 * Created by Vitaliy on 24.03.2016.
 */

var LoginPage = (function(){



    return{

        init: function(){

            function correctionPage(){

                var header = $('.box-header-menu'),
                    heightW = $('.wrap').height(),
                    heightH = $('html').height();

                if(heightW<heightH){

                    header.css('box-shadow', 'none');

                }else{

                    header.css('box-shadow', '0 2px 8px rgba(100, 192, 239, 0.37)');
                }

            }

            correctionPage();

        }
    }



})();

$(function(){

    LoginPage.init();

});
