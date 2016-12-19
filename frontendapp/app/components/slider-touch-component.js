import Ember from 'ember';
let slider = [
  {
    img: "/assets/img/home-page/section-3/slide-1.png",
    title: "",
    description: "0At Skynix we understand that a company website, whether it’s an enterprise portal or an online store, is a reflection of a brand, and 9 times out of 10 visitors make their decision on whether they are going to trust the establishment based on its look, feel and functionality."
  },
  {
    img: "/assets/img/home-page/section-3/slide-1.png",
    title: "",
    description: "1At Skynix we understand that a company website, whether it’s an enterprise portal or an online store, is a reflection of a brand, and 9 times out of 10 visitors make their decision on whether they are going to trust the establishment based on its look, feel and functionality."
  },
  {
    img: "/assets/img/home-page/section-3/slide-1.png",
    title: "",
    description: "2At Skynix we understand that a company website, whether it’s an enterprise portal or an online store, is a reflection of a brand, and 9 times out of 10 visitors make their decision on whether they are going to trust the establishment based on its look, feel and functionality."
  },
];

export default Ember.Component.extend({
  classNames: ['slider-touch-component'],
  model: {
    slider: slider,
  },
  didRender(){
    let element = Ember.$(this.element);

    function Slider() {
      let __self = this;

      let sliderItemNode = element.find(".slider__list"),
        prevSliderNode = element.find('.slider__pager_previous'),
        nextSliderNode = element.find('.slider__pager_next');

      let currentSlideIndex = 0,
        imagesCount = sliderItemNode.children().length,
        slideSize = sliderItemNode.outerWidth();
      console.log(imagesCount);

      this.prevSlide = function () {
        if (currentSlideIndex === 0) {
          currentSlideIndex = imagesCount - 1;
          return;
        }
        currentSlideIndex--;
        console.log(currentSlideIndex);
      };

      this.nextSlide = function () {
        if (currentSlideIndex === imagesCount - 1) {
          currentSlideIndex = 0;
          return;
        }
        currentSlideIndex++;
        console.log(currentSlideIndex);
      };

      this.__render = function () {

        sliderItemNode.css({"marginLeft": -(currentSlideIndex * slideSize)});



      };
      prevSliderNode.on('click', function(e) {

        e.preventDefault();
        __self.prevSlide();
        __self.__render();
      });

      nextSliderNode.on('click',function(e) {
        e.preventDefault();
        __self.nextSlide();
        __self.__render();
      });
      Ember.$(document).on("pagecreate",function(){
        sliderItemNode.on('swipeLeft',function () {
          console.log("####");
        });
      });


    }

    window.slider= new Slider();
  }
});
