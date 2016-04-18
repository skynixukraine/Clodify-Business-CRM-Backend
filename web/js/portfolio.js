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
        stop = true;

    function runPopap(el){

        headerPopap.html("");
        viewport.html("");
        infoBox.html("");
        img = [];
        bodyPopap.animate({opacity: 0},0);
        bodyPopap.animate({opacity: 1},500);



        headerPopap.html((el.find('h3')).html());
        dataImages = el.find('a').attr('data-images');
        pars = dataImages.split(", ");

        for (var i in pars) {

            img[i] = new Image();
            img[i].src = 'images/' + pars[i];

            img[i].setAttribute('width', '690');
            img[i].setAttribute('height', '380');

            //viewport.append("<img width=\"690\" height=\"380\"src="+ img[i] +">");

        }



        viewport.html(img[0]);
        //viewport.fadeIn(500);
        console.log('img.length ', img.length);
        if(img.length > 1){

            stop = false;
            numImg = 0;
            demoslides();


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

        txtPopap = el.find('.info-box-hidden');
        infoBox.html(txtPopap.clone());

        dataHref = el.find('a').attr('data-href');
        btnPopupVisit.attr('href', dataHref);


        htmlHeight      = htmlPage.height();
        bgForPopup.fadeIn(200);
        popup.fadeIn(300);
        popup.slideDown(200);



        if(htmlHeight > 900){

            popup.css("top", htmlPage.scrollTop()+(htmlHeight - 850)/2);

        }else{

            popup.css("top", htmlPage.scrollTop()+10);
        }

        if(htmlWidth > 768){

            viewport.css('width', portfolioImgBox.width() - (btnPrev.width() + btnNext.width() + 40));
        }else{

            viewport.css('width', 100 +"%");
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



            htmlPage.resize(widthPage);
            widthPage();


            btnRunPopap.click(function(event){

                event.preventDefault();

                el=$(event.target);

                el = el.closest('.portfolio-sample');

                runPopap(el);
                return false;

            });

            btnPrev.click(function(event) {

                event.preventDefault();
                stop = true;
                clearTimeout(timestop);


                el = portfolio.eq(elem);


                elem = elem - 1;

                if(elem < 0 ){

                    elem = portfolio.length - 1;
                }



                runPopap(el);

                return false;

            });
            btnNext.click(function(event) {

                event.preventDefault();
                clearTimeout(timestop);

                stop = true;
                //viewport.fadeOut();

                el = portfolio.eq(elem);


                elem = elem + 1;

                if(elem > (portfolio.length - 1) ){

                    elem = 0;
                }

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

addEventListener("load", Portfolio.init);


