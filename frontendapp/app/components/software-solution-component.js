import Ember from 'ember';

let description = "Every software solution Skynix builds is:";
let solution = [
  {
    img: "/assets/img/home-page/section-2/software-icon-1.png",
    title: "SEO",
    desc: [
      {
        description: "• Our code always corresponds to the requirements of search engines."
      },
      {
        description: "• You will not need additional services to hone the code for the search bots."
      },
      {
        description: "• We do not use the techniques of “black” and “grey” SEO."
      }
    ]
  },
  {
    img: "/assets/img/home-page/section-2/software-icon-2.png",
    title: "Fast",
    desc: [
      {
        description: "• Under 3 seconds loading time"
      },
      {
        description: "• Smart browser caching"
      }
    ]
  },
  {
    img: "/assets/img/home-page/section-2/software-icon-3.png",
    title: "Smart browser caching",
    desc: [
      {
        description: "• Adaptation to every possible display size, from as little as 320px"
      },
      {
        description: "• Cross-browser Compatibility"
      },
      {
        description: "• Look equally advantageous on any device"
      },
      {
        description: "• Complete user-friendly functionality."
      }
    ]
  },
  {
    img: "/assets/img/home-page/section-2/software-icon-4.png",
    title: "Warrantied and Supported",
    desc: [
      {
        description: "• Standardized 6 months warranty on every solution we build."
      },
      {
        description: "• Free support and timely communication as a part of every after-sales package."
      },
      {
        description: "• When the warranty period is over we will still be there to help you."
      }
    ]
  },
  {
    img: "/assets/img/home-page/section-2/software-icon-5.png",
    title: "Cost-effective",
    desc: [
      {
        description: "• We’re from the 4th country in the world by a number of certified IT specialists."
      },
      {
        description: "• Ukrainian competence is proven globally."
      },
      {
        description: "• We benefit from the world’s most intensive education system, while low costs of living allow  us to keep our operation prices at their lowest."
      }
    ]
  },
  {
    img: "/assets/img/home-page/section-2/software-icon-6.png",
    title: "Made With Passion",
    desc: [
      {
        description: "• Individual approach to each client"
      },
      {
        description: "• Aiming at excellent results"
      },
      {
        description: "• The essence of innovation and experience"
      }
    ]
  },

];

export default Ember.Component.extend({
  classNames: ['software-solution-component'],
  model: {
    solution: solution,
    description: description,
  }
});

