import Ember from 'ember';


export default Ember.Component.extend({
  // classNames: ['software-solution-component'],


  didRender(){
    let element = Ember.$(this.element);



    Ember.$(".section-business-solutions__title").animated("slideInDown");
    Ember.$(".section-business-solutions__subtitle").animated("slideInUp");
    Ember.$(".section-business-solutions__desc").animated("slideInUp");
    Ember.$(".section-business-solutions__subtitle-mod").animated("slideInUp");



    element.waypoint(function () {
      element.find(".solution__item").each(function (index) {
        let ths = Ember.$(this);
        setInterval(function () {
          ths.addClass("on");
        }, 200 * index);
      });
    }, {
      offset: "50%"
    });

    Ember.$(".section-software-solution__title").animated("slideInDown");


    element.find(".enhancement").waypoint(function () {
      element.find(".solution__item").each(function (index) {
        let ths = Ember.$(this);
        setInterval(function () {
          ths.addClass("on");
        }, 200 * index);
      });
    }, {
      offset: "50%"
    });
  }


});

