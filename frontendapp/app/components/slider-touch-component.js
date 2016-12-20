import Ember from 'ember';
let slider = [
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
        nextSliderNode = element.find('.slider__pager_next'),
        paginationNode = element.find('.slider__pagination');


      let currentSlideIndex = 0,
        imagesCount = sliderItemNode.children().length,
        slideSize = sliderItemNode.outerWidth();

      this.prevSlide = function () {
        if (currentSlideIndex === 0) {
          currentSlideIndex = imagesCount - 1;
          return;
        }
        currentSlideIndex--;
      };

      this.nextSlide = function () {
        if (currentSlideIndex === imagesCount - 1) {
          currentSlideIndex = 0;
          return;
        }
        currentSlideIndex++;
      };


      this.__render = function () {
        sliderItemNode.css({"marginLeft": -(currentSlideIndex * slideSize)});
        paginationNode.find('.active').removeClass('active');
        let elem = paginationNode.children()[currentSlideIndex];

        $(elem).find('a').addClass('active');

      };
      prevSliderNode.on('click', function (e) {
        e.preventDefault();
        __self.prevSlide();
        __self.__render();
      });

      nextSliderNode.on('click', function (e) {
        e.preventDefault();
        __self.nextSlide();
        __self.__render();
      });
      paginationNode.on('click', function(e) {
        e.preventDefault();

        let link = e.target;

        if (link.tagName !== 'A') { return; }

        currentSlideIndex = +link.dataset['slider__item'];

        __self.__render();
      });

      let mousePageX,
        mouseMove,
        size,
        touchPageX,
        touchMove,
        touchSize;

      this.swipeSlider = function (item) {
        if (item > 60) {
          __self.nextSlide();
          __self.__render();
        }
        if (item < -60) {
          __self.prevSlide();
          __self.__render();
        }
      };
      sliderItemNode.on('touchstart mousedown', function (e) {
        e.preventDefault();
        if (e.type == "touchstart") {
          touchPageX = e.changedTouches[0].pageX;
        } else {
          mousePageX = e.pageX;
        }
        sliderItemNode.on('touchmove mousemove', function (e) {
          if (e.type == "touchmove") {
            touchMove = e.changedTouches[0].pageX;
          } else {
            mouseMove = e.pageX;
          }
        });
      });
      sliderItemNode.on('touchend mouseup', function (e) {
        if (e.type == "touchend") {
          touchSize = touchPageX - touchMove;
          if (touchSize == 0) {
            sliderItemNode.off('touchmove');
          } else {
            __self.swipeSlider(touchSize);
          }
        } else {
          size = mousePageX - mouseMove;
          if (size == 0) {
            sliderItemNode.off('mousemove');
          } else {
            __self.swipeSlider(size);
          }
        }

      });
    }

    let slider = new Slider();

  }
});
