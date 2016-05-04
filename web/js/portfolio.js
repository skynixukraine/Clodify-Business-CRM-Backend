/**
 * Created by Vitaliy on 15.04.2016.
 */

var Portfolio  = (function(){

    var htmlPage,
        body,
        htmlHeight,
        htmlWidth,
        portfolio = [],
        bgForPopup,
        popup,
        bodyPopap,
        headerPopap,
        portfolioImgBox,
        btnRunPopap,
        btnPrev,
        btnNext,
        infoBox,
        txtPopap,
        btnPopupVisit,
        el,
        elem = 0,
        pars,
        dataHref,
        dataImages = [],
        img = [],
        numImg = 0,
        viewport,
        timestop,
        stop = true,
        openProject,
        frontMask,
        canBePressed = true,
        portfolioPage;

    function runPopap(el){



        htmlHeight      = htmlPage.height();
        canBePressed = false;


        txtPopap = el.find('.info-box-hidden');
        dataHref = el.find('a').attr('data-href');
        openProject =  el.data('data-project-number');

        headerPopap.html("");
        viewport.html("");
        infoBox.html("");
        bodyPopap.animate({opacity: 0},0);


        headerPopap.html((el.find('h3')).html());
        viewport.html(img[openProject]);
        bodyPopap.animate({opacity: 1},500);
        //viewport.fadeIn(500);

        /*if(img.length > 1){

         stop = false;
         numImg = 0;
         demoslides();
         }*/

        infoBox.html(txtPopap.clone());


        if(dataHref){

            btnPopupVisit.css('display', "block");
            btnPopupVisit.attr('href', dataHref);

        }else{

            btnPopupVisit.css('display', 'none');
        }



        bgForPopup.fadeIn(200);
        popup.fadeIn(300);
        popup.slideDown(200);


        if(htmlHeight > 900){

            popup.css('top', htmlPage.scrollTop()+(htmlHeight - 850)/2);

        }else{

            popup.css('top', htmlPage.scrollTop()+10);
        }

        if(htmlWidth > 768){

            viewport.css('width', portfolioImgBox.width() - (btnPrev.width() + btnNext.width() + 40));
        }else{

            viewport.css('width', 100 +"%");
        }

        setTimeout(canBePressedRun, 500);

        function canBePressedRun(){

            canBePressed = true;
        }











        function demoslides(){

            viewport.animate({opacity: 0.5},0);
            viewport.find("img").replaceWith(img[numImg]);
            viewport.animate({opacity: 1},500);

            numImg++;

            if (numImg == img.length){

                numImg = 0;
            }

            if(stop != true ) {

                timestop = setTimeout(demoslides, 5000);

            }

        }
        return false
    }

   function widthPage(){
       htmlWidth = htmlPage.width();
   }

    return{

        init: function(){
            htmlPage            = $(window);
            body                =$("body, html");
            portfolioPage       =$('#portfolio');
            portfolio           = $('.portfolio-sample');
            btnRunPopap         = portfolio.find('[data-images]');
            bgForPopup          = $('#view_portfolio');
            popup               = bgForPopup.find('.popup');
            headerPopap         = popup.find('.header-popap');
            bodyPopap           = popup.find('.body-popap');
            portfolioImgBox     = bodyPopap.find('.slider_portfolio');
            viewport            = bodyPopap.find('.viewport');
            infoBox             = bodyPopap.find('.info-box');

            btnPrev             = portfolioImgBox.find('.prev');
            btnNext             = portfolioImgBox.find('.next');
            btnPopupVisit       = popup.find('.read-more');
            frontMask           = bgForPopup.find('.front-mask');



            htmlPage.resize(widthPage);
            widthPage();



            for(var i=0; i < portfolio.length; i++){

                portfolio.eq(i).data("data-project-number", i);
            }


            btnRunPopap.click(function(event){

                var index = 0;
                event.preventDefault();
                el=$(event.target);
                el = el.closest('.portfolio-sample');



                if(img.length == 0){

                    frontMask.css('display', 'block' );
                    for (var i = 0;  i < btnRunPopap.length; i++) {

                        dataImages.push(btnRunPopap.eq(i).attr('data-images'));
                        pars = dataImages[i].split(", ");

                        for (var ii in pars) {

                            img[index] = new Image();
                            img[index].src = '../images/' + pars[ii];
                            img[index].setAttribute('width', '690');
                            img[index].setAttribute('height', '380');
                            index +=1;

                        }

                    }

                    $(img).eq(img.length-1).one("load", function() {

                        frontMask.css('display', 'none' );
                        runPopap(el);
                    });
                    dataImages.length = 0;


                }else{

                    runPopap(el);
                }


                return false;

            });

            btnPrev.click(function(event) {

                event.preventDefault();

                if(!canBePressed){

                    return false;
                }
                stop = true;
                clearTimeout(timestop);


                elem = openProject - 1;

                if(elem < 0 ){

                    elem = portfolio.length - 1;
                }

                el = portfolio.eq(elem);

                runPopap(el);

                return false;

            });
            btnNext.click(function(event) {

                event.preventDefault();

                if(canBePressed == false){

                    return false;
                }

                clearTimeout(timestop);

                stop = true;
                //viewport.fadeOut();

                elem = openProject + 1;

                if(elem > (portfolio.length - 1) ){

                    elem = 0;
                }

                el = portfolio.eq(elem);


                runPopap(el);

                return false;

            });

            bgForPopup.find(".close").click(function (event) {// button close popup

                event.preventDefault();
                clearTimeout(timestop);
                bgForPopup.fadeOut(200);
                popup.fadeOut(300);
                popup.slideUp(200);

                return false;

            });

            htmlPage.on("hashchange", function() {

                if(location.href.indexOf("#portfolio") > 0){

                    body.animate({scrollTop: 0}, 0);
                    body.animate({scrollTop: portfolioPage.position().top - 80},600);
                }

                return false;
            });
            if(location.href.indexOf("#portfolio") > 0){

                body.animate({scrollTop: portfolioPage.position().top - 80},600);

            }


        }
    }

})();


$(function(){

    Portfolio.init();

});



