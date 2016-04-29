/**
 * Created by Vitaliy on 15.04.2016.
 */

var Portfolio  = (function(){

    var htmlPage,
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
        dataImages,
        img = [],
        numImg = 0,
        viewport,
        timestop,
        stop = true,
        openProject,
        frontMask,
        canBePressed = true;

    function runPopap(el){

        frontMask.css('display', 'block' );
        img             = [];
        htmlHeight      = htmlPage.height();
        canBePressed = false;



        dataImages = el.find('a').attr('data-images');

        pars = dataImages.split(", ");

        for (var i in pars) {

            img[i] = new Image();
            img[i].src = '../images/' + pars[i];
            img[i].setAttribute('width', '690');
            img[i].setAttribute('height', '380');


        }
        txtPopap = el.find('.info-box-hidden');
        dataHref = el.find('a').attr('data-href');
        $(img).load(function() {

            frontMask.css('display', 'none' );
            headerPopap.html("");
            viewport.html("");
            infoBox.html("");
            bodyPopap.animate({opacity: 0},0);
            openProject =  el.data('data-project-number');

            headerPopap.html((el.find('h3')).html());
            viewport.html(img[0]);
            bodyPopap.animate({opacity: 1},500);
            //viewport.fadeIn(500);

            if(img.length > 1){

                stop = false;
                numImg = 0;
                demoslides();
            }

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
        });













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
            portfolio           = $('.portfolio-sample');
            btnRunPopap         = portfolio.find('a');
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

                event.preventDefault();

                el=$(event.target);

                el = el.closest('.portfolio-sample');

                runPopap(el);
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
console.log("dddddddddddffffffffffggggggggggg");
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

        }
    }

})();


$(function(){

    Portfolio.init();

});



