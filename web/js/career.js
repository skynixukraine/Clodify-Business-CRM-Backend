/**
 * Created by Vitaliy on 11.04.2016.
 */

var career = (function(){

    var BtnReadMore,
        articleShow,
        htmlPage,
        htmlwidth,
        elem,
        scrollRightPanel,
        rightPanel;

    return{

        init: function(){
            htmlPage        = $('body, html');
            BtnReadMore     = $('.read-more');
            rightPanel      = $(".right-panel");
            htmlwidth       = htmlPage.width();

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

            });

            $(document).scroll(function() {

                if(htmlwidth > 768){

                    console.log("ddddddd");
                    scrollRightPanel = $(document).scrollTop();

                    console.log(scrollRightPanel);
                    if(scrollRightPanel > 240){

                        rightPanel.addClass('fix-rightPanel');
                    }else{
                        rightPanel.removeClass('fix-rightPanel');
                    }
                }

            });


        }
    }
})();

addEventListener("load", career.init);


