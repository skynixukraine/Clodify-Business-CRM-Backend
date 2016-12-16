import Ember from 'ember';

let slides = {
  description: 'Skynix Ukraine is a software development company founded by the technical experts in the IT field with the ultimate customer satisfaction and innovative approach in mind.',
  img: 'assets/img/home-page/section-1/Logo.png'
};

export default Ember.Route.extend({
  model() {
    return {
      slides: slides
    }
  }
});
