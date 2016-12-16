import Ember from 'ember';

export default Ember.Component.extend({
  classNames: ['header-component'],

  didRender() {

    // let element = Ember.$(this.element);


    Ember.$(document).scroll(function () {
      let scrollY = Ember.$(window).scrollTop();



      if (scrollY > 100) {
        Ember.$(".header-component").addClass("header-component_height");
        Ember.$(".nav-menu__title").addClass("nav-menu__title_color");
        Ember.$(".link-content__title").addClass("link-content__title_opacity");
        Ember.$(".nav-social__pic:eq(0)").attr('src', '/assets/img/home-page/section-1/fb-active.png');
        Ember.$(".nav-social__pic:eq(1)").attr('src', '/assets/img/home-page/section-1/Twitter-active.png');
        Ember.$(".nav-social__pic:eq(2)").attr('src', '/assets/img/home-page/section-1/in-active.png');
        Ember.$(".nav-social__pic:eq(3)").attr('src', '/assets/img/home-page/section-1/instagram-active.png');



      } else {

        Ember.$(".header-component").removeClass("header-component_height");
        Ember.$(".nav-menu__title").removeClass("nav-menu__title_color");
        Ember.$(".link-content__title").removeClass("link-content__title_opacity");
        Ember.$(".nav-social__pic:eq(0)").attr('src', '/assets/img/home-page/section-1/fb.png');
        Ember.$(".nav-social__pic:eq(1)").attr('src', '/assets/img/home-page/section-1/twitter.png');
        Ember.$(".nav-social__pic:eq(2)").attr('src', '/assets/img/home-page/section-1/linkedin.png');
        Ember.$(".nav-social__pic:eq(3)").attr('src', '/assets/img/home-page/section-1/instagram.png');

      }
    });
  }
});

