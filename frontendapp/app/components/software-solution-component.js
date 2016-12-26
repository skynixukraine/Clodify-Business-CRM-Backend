import Ember from 'ember';


export default Ember.Component.extend({
  classNames: ['software-solution-component'],


  didRender(){
    let element = Ember.$(this.element);

    element.waypoint(function () {
      element.find(".item").each(function (index) {
        let ths = Ember.$(this);
        setInterval(function () {
          ths.addClass("on");
        }, 200 * index);
      });
    }, {
      offset: "50%"
    });


    element.find(".enhancement").waypoint(function () {
      element.find(".item").each(function (index) {
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

