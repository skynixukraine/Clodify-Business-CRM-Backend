import Ember from 'ember';

let description = 'Skynix Ukraine is a software development company founded by the';
let slides = [
  {
    title: '',
    description: '',
    img: ''
  }
];

export default Ember.Route.extend({
  model() {
    return {
      description: description,
      slides: slides
    }
  }
});
