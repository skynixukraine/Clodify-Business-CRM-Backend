

let LoginPage = (function(){

  let header,
    scrollY,
    heightP,
    navLink,
    navsohialLink,
    logo;

  let images;






// gg

  return{

    init: function(){

      header = Ember.$('.header__top-panel');
      heightP = Ember.$('.panel-fixed');
      navLink = Ember.$('.nav__link');
      navsohialLink = Ember.$('.nav-social__link');
      logo = Ember.$('.logo-desc');
      images =Ember.$(".nav-social__list img");

      Ember.$(document).scroll(function() {

        scrollY = Ember.$(document).scrollTop();

        if(scrollY > 100){

          logo.css({"display": "none"});
          header.addClass('fix-height');
          heightP.css({"background":"rgba(255,255,255,.3)"});
          navsohialLink.addClass('fix-height');
          navLink.addClass('nav__link-animMod');
          images.get(0).src = "../backend/assets/img/header/fb-active.png";
          images.get(1).src = "../backend/assets/img/header/Twitter-active.png";
          images.get(2).src = "../backend/assets/img/header/in-active.png";
          images.get(3).src = "../backend/assets/img/header/Instagram-active.png";



        }else{

          logo.css({"display": "block"});
          header.removeClass('fix-height');
          heightP.css({"background":"none"});
          navsohialLink.removeClass('fix-height');
          navLink.removeClass('nav__link-animMod');
          images.get(0).src = "../backend/assets/img/header/fb.png";
          images.get(1).src = "../backend/assets/img/header/Twitter.png";
          images.get(2).src = "../backend/assets/img/header/in.png";
          images.get(3).src = "../backend/assets/img/header/Instagram.png";

        }

      });





    }
  }



})();


$(function(){

  LoginPage.init();
  // hideTextScroll.init();
  Ember.$(".content-logo").animated("slideInDown");
  Ember.$(".content-title").animated("slideInUp");
  Ember.$(".section-1__title").animated("fadeIn");



    Ember.$(".section-1").waypoint(function () {
    Ember.$(".software-block__items").each(function (index) {
      let ths = $(this);
      setInterval(function () {
        ths.addClass("on");
      }, 200 * index);
    });
  },{
    offset: "30%"
  });


  var hideText = Ember.$('.header__content');

  Ember.$(window).scroll(function() {
    if(hideText){
      if ( Ember.$(window).scrollTop() > hideText.offset().top - 120) {
       hideText.css({"opacity": "0"});
        // if (!houseImg.attr('src')) {
        //   houseImg.attr('src', 'img/popularity/house-2.gif')
        // }
      }else{
        hideText.css({"opacity": "1"});
      }

    }
  });


});

