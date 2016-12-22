import Ember from 'ember';


export default Ember.Component.extend({
  // classNames: ['slider-touch-component'],

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

        Ember.$(elem).find('a').addClass('active');

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
        if (e.type === "touchstart") {
          touchPageX = e.changedTouches[0].pageX;
        } else {
          mousePageX = e.pageX;
        }
        sliderItemNode.on('touchmove mousemove', function (e) {
          if (e.type === "touchmove") {
            touchMove = e.changedTouches[0].pageX;
          } else {
            mouseMove = e.pageX;
          }
        });
      });
      sliderItemNode.on('touchend mouseup', function (e) {
        if (e.type === "touchend") {
          touchSize = touchPageX - touchMove;
          if (touchSize === 0) {
            sliderItemNode.off('touchmove');
          } else {
            __self.swipeSlider(touchSize);
          }
        } else {
          size = mousePageX - mouseMove;
          if (size === 0) {
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
