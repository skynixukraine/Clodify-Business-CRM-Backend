import Ember from 'ember';

let routes = [
  {
    link: 'index',
    title: 'Services'
  },
  {
    link: 'people',
    title: 'People'
  },
  {
    link: 'blog',
    title: 'Blog'
  },
  {
    link: 'contacts',
    title: 'Contacts'
  }
];

let socials = [
  {
    img: '/assets/img/home-page/section-1/fb.png',
    link: 'https://www.facebook.com/skynix.solutions/'
  },
  {
    img: '/assets/img/home-page/section-1/twitter.png',
    link: 'https://twitter.com/skynixukraine'
  },
  {
    img: '/assets/img/home-page/section-1/linkedin.png',
    link: 'https://www.linkedin.com/company/skynix'
  },
  {
    img: '/assets/img/home-page/section-1/Instagram.png',
    link: 'https://www.instagram.com/skynixukraine/'
  }
];

export default Ember.Controller.extend({
  model: {
    routes: routes,
    socials: socials
  }
});
