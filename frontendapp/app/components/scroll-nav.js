import Ember from 'ember';

export default Ember.Component.extend({

  // actions: {
  //
  //   scrollFunc: function () {
  //
  //     var header = Ember.$(".header__top-panel");
  //     console.log(header);
  //
  //     Ember.$(document).scroll(function () {
  //
  //
  //       let scrollY = Ember.$(document).scrollTop();
  //       console.log(scrollY);
  //
  //       if (scrollY > 100) {
  //         console.log(header);
  //
  //         header.addClass('fix-height');
  //
  //       } else {
  //         header.removeClass('fix-height');
  //       }
  //
  //     });
  //   }
  // }

  scroll() {
      let scrollY = Ember.$(document).scrollTop();
      var header = Ember.$(".header__top-panel");
      console.log(scrollY);

      if (scrollY > 100) {
        console.log(header);

        header.addClass('fix-height');

      } else {
        header.removeClass('fix-height');
      }
    }

});
