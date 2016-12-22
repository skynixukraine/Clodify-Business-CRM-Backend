import Ember from 'ember';

let headerTitle = {
  description: 'Skynix Ukraine is a software development company founded by the technical experts in the IT field with the ultimate customer satisfaction and innovative approach in mind.',
  img: 'assets/img/home-page/section-1/Logo.png'
};

let solution =
  {
    desc_solution:  "Every software solution Skynix builds is:",
    solution: [
      {
        img: "/assets/img/home-page/section-2/software-icon-1.png",
        title: "SEO",
        desc: ["• Our code always corresponds to the requirements of search engines.",
          "• You will not need additional services to hone the code for the search bots.",
          "• We do not use the techniques of “black” and “grey” SEO."]
      },
      {
        img: "/assets/img/home-page/section-2/software-icon-2.png",
        title: "Fast",
        desc: ["• Under 3 seconds loading time",
          "• Smart browser caching"]
      },
      {
        img: "/assets/img/home-page/section-2/software-icon-3.png",
        title: "Responsive UI / UX",
        desc: ["• Adaptation to every possible display size, from as little as 320px",
          "• Cross-browser Compatibility",
          "• Look equally advantageous on any device",
          "• Complete user-friendly functionality."]
      },
      {
        img: "/assets/img/home-page/section-2/software-icon-4.png",
        title: "Warrantied and Supported",
        desc: ["• Standardized 6 months warranty on every solution we build.",
          "• Free support and timely communication as a part of every after-sales package.",
          "• When the warranty period is over we will still be there to help you."]
      },
      {
        img: "/assets/img/home-page/section-2/software-icon-5.png",
        title: "Cost-effective",
        desc: ["• We’re from the 4th country in the world by a number of certified IT specialists.",
          "• Ukrainian competence is proven globally.",
          "• We benefit from the world’s most intensive education system, while low costs of living allow  us to keep our operation prices at their lowest."]
      },
      {
        img: "/assets/img/home-page/section-2/software-icon-6.png",
        title: "Made With Passion",
        desc: ["• Individual approach to each client",
          "• Aiming at excellent results",
          "• The essence of innovation and experience",]
      }
    ],
    desc_enhancement: "Who do we serve?",
    enhancement: [
      {
        img: "/assets/img/home-page/section-4/pic-1.png",
        title: "Startup",
        desc: ["Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore"],
        link: "Request a Quote копія"
      },
      {
        img: "/assets/img/home-page/section-4/pic-2.png",
        title: "eCommerce",
        desc: ["Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore"],
        link: "Request a Quote копія"
      },
      {
        img: "/assets/img/home-page/section-4/pic-3.png",
        title: "Enterprise",
        desc: ["Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore"],
        link: "Request a Quote копія"
      },
      {
        img: "/assets/img/home-page/section-4/pic-4.png",
        title: "Non-profit & Government",
        desc: ["Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore"],
        link: "Request a Quote копія"
      }
    ]
  };
let sliderSection_3 = [
  {
    img: "/assets/img/home-page/section-3/slide-1.png",
    title: "",
    description: "At Skynix we understand that a company website, whether it’s an enterprise portal or an online store, is a reflection of a brand, and 9 times out of 10 visitors make their decision on whether they are going to trust the establishment based on its look, feel and functionality."
  },
  {
    img: "/assets/img/home-page/section-3/slide-1.png",
    title: "",
    description: "It only takes a few seconds to convert your casual bypasser into a potential customer or to lose them forever. With a badly optimised site, most of this time you risk to have them spending on simply loading the page. The primary objective of every software solution Skynix creates is to win every nanosecond there is, and to enable you make that first impression develop into loyalty."
  },
  {
    img: "/assets/img/home-page/section-3/slide-1.png",
    title: "",
    description: "In a modern world, however, having a practical, fast and sophisticated public-facing website or app isn’t enough in the long run, this is why we back our every IT solution up with a stable, reliable yet scalable architecture, and ensure the optimum security and support is in place for you not to worry about losing your entire business overnight to a single attack."
  },
];
let sliderSection_5 = [
  {
    img: "/assets/img/home-page/section-5/pic-1.png",
    title: "David Martin",
    description: "I have always enjoyed a pleasant and productive working relationship with Oleksii, the tech leader of Skynix. " +
    "I have worked with him on numerous projects from dynamic websites to responsive, fault tolerant and user friendly mobile applications. During every project Oleksii took the time to understand exactly what was required from the end goal down to the finest detail. " +
    " As a result Oleksii provided accurate estimations of time and resources to achieve the required goals.  During every project his performance exceeded my expectations. " +
    " Oleksii embraced my ideas and nurtured the projects as if they were his own. Admittedly I initially had reservations about working with an overseas, non english speaking developer."
  },
  {
    img: "/assets/img/home-page/section-5/pic-1.png",
    title: "David Martin",
    description: "I have always enjoyed a pleasant and productive working relationship with Oleksii, the tech leader of Skynix. " +
    "I have worked with him on numerous projects from dynamic websites to responsive, fault tolerant and user friendly mobile applications. During every project Oleksii took the time to understand exactly what was required from the end goal down to the finest detail. " +
    " As a result Oleksii provided accurate estimations of time and resources to achieve the required goals.  During every project his performance exceeded my expectations. " +
    " Oleksii embraced my ideas and nurtured the projects as if they were his own. Admittedly I initially had reservations about working with an overseas, non english speaking developer."

  },
  {
    img: "/assets/img/home-page/section-5/pic-1.png",
    title: "David Martin",
    description: "I have always enjoyed a pleasant and productive working relationship with Oleksii, the tech leader of Skynix. " +
    "I have worked with him on numerous projects from dynamic websites to responsive, fault tolerant and user friendly mobile applications. During every project Oleksii took the time to understand exactly what was required from the end goal down to the finest detail. " +
    " As a result Oleksii provided accurate estimations of time and resources to achieve the required goals.  During every project his performance exceeded my expectations. " +
    " Oleksii embraced my ideas and nurtured the projects as if they were his own. Admittedly I initially had reservations about working with an overseas, non english speaking developer."

  }
];
export default Ember.Route.extend({
  model() {
    return {
      headerTitle: headerTitle,
      solution: solution,
      sliderSection_3: sliderSection_3,
      sliderSection_5: sliderSection_5
    };
  },
});

