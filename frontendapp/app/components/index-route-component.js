import Ember from 'ember';

export default Ember.Component.extend({

  didRender(){

    let element = Ember.$(this.element);

    element.find(".title-pic").animated("slideInDown");
    element.find(".title-desc").animated("slideInUp");
    element.find(".section-software-solution .title").animated("slideInDown");
    element.find(".section-business-solutions .content-subtitle").animated("slideInUp");
    element.find(".section-business-solutions .content-desc").animated("slideInUp");
    element.find(".section-business-solutions .content-subtitle-mod").animated("slideInUp");
    element.find(".section-business-solutions .content-title").animated("slideInDown");
    element.find(".section-business-solutions .content-title").animated("anim");
    element.find(".slide__img").animated("slideInLeft");
    element.find(".slide__text").animated("slideInRight");




    Ember.$(document).scroll(function () {
      let scrollY = Ember.$(window).scrollTop();


      let headerP = Ember.$('.header-component').height() + 160;

      if(scrollY >= headerP){
        element.find(".section-header .title").addClass("opacity");
      }else{
        element.find(".section-header .title").removeClass("opacity");
      }


    });

  }
});
