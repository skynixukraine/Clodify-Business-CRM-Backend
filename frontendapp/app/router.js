import Ember from 'ember';
import config from './config/environment';

const Router = Ember.Router.extend({
  location: config.locationType,
  rootURL: config.rootURL
});

Router.map(function() {
  this.route('contacts');
  this.route('blog');
  this.route('people');
  this.route('services');
});

Ember.$.fn.animated = function(inEffect) {
  Ember.$(this).each(function() {
    let ths = Ember.$(this);
    ths.css("opacity", "0").addClass("animated").waypoint(function(dir) {
      if (dir === "down") {
        ths.addClass(inEffect).css("opacity", "1");
      }
    }, {
      offset: "90%"
    });

  });
};

export default Router;

