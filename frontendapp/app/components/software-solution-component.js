import Ember from 'ember';


export default Ember.Component.extend({
  // classNames: ['software-solution-component'],


  didRender(){
    let element = Ember.$(this.element);



    Ember.$(".section-4__title").animated("slideInDown");
    Ember.$(".section-4__subtitle").animated("slideInUp");
    Ember.$(".section-4__desc").animated("slideInUp");
    Ember.$(".section-4__subtitle-mod").animated("slideInUp");

// console.log("@@@", element.find(".solution__item"));


    element.waypoint(function () {
      element.find(".solution__item").each(function (index) {
        let ths = $(this);
        setInterval(function () {
          ths.addClass("on");
        }, 200 * index);
      });
    }, {
      offset: "50%"
    });

    Ember.$(".section-2__title").animated("slideInDown");


    element.find(".enhancement").waypoint(function () {
      element.find(".solution__item").each(function (index) {
        let ths = $(this);
        setInterval(function () {
          ths.addClass("on");
        }, 200 * index);
      })
    }, {
      offset: "50%"
    });
  }


});

