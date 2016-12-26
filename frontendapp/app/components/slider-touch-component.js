import Ember from 'ember';


export default Ember.Component.extend({
  classNames: ['slider-touch-component'],

  didRender(){
    let element = Ember.$(this.element);


    let $slider = element.find(".slider"),
      diff = 0,
      curSlide = 0,
      numOfSlides = element.find(".slide").length-1,
      animating = false,
      animTime = 500,
      autoSlideTimeout,
      autoSlideDelay = 6000,
      $pagination = element.find(".slider-pagi");

    function createBullets() {
      for (let i = 0; i < numOfSlides+1; i++) {
        let $li = $("<li class='slider-pagi__elem'></li>");
        $li.addClass("slider-pagi__elem-"+i).data("page", i);
        if (!i) $li.addClass("active");
        $pagination.append($li);
      }
    };
    function slideChild() {
      for (let i = 0; i < numOfSlides+1; i++) {
        let elem = element.find('.slide');
        $(elem[i]).css({'left': i*100 + '%'});
      }
    }

    createBullets();

    slideChild();

    function manageControls() {
      $(".slider-control").removeClass("inactive");
      if (!curSlide) $(".slider-control.left").addClass("inactive");
      if (curSlide === numOfSlides) $(".slider-control.right").addClass("inactive");
    };

    function autoSlide() {
      autoSlideTimeout = setTimeout(function() {
        curSlide++;
        if (curSlide > numOfSlides) curSlide = 0;
        changeSlides();
      }, autoSlideDelay);
    };

    // autoSlide();

    function changeSlides(instant) {
      if (!instant) {
        animating = true;
        // manageControls();
        $slider.addClass("animating");
        $slider.css("top");
        $(".slide").removeClass("active");
        $(".slide-"+curSlide).addClass("active");
        setTimeout(function() {
          $slider.removeClass("animating");
          animating = false;
        }, animTime);
      }
      window.clearTimeout(autoSlideTimeout);
      element.find(".slider-pagi__elem").removeClass("active");
      element.find(".slider-pagi__elem-"+curSlide).addClass("active");
      $slider.css("transform", "translate3d("+ -curSlide*100 +"%,0,0)");
      diff = 0;
      // autoSlide();
    }

    function navigateLeft() {
      if (animating) return;
      if (curSlide > 0) curSlide--;
      changeSlides();
    }

    function navigateRight() {
      if (animating) return;
      if (curSlide < numOfSlides) curSlide++;
      changeSlides();
    }

    element.on("mousedown touchstart", ".slider", function(e) {
      e.preventDefault();
      if (animating) return;
      window.clearTimeout(autoSlideTimeout);

      let startX = e.pageX || e.originalEvent.touches[0].pageX,
        winW = element.find(".slider-container").width();

      diff = 0;

      element.on("mousemove touchmove", function(e) {
        let x = e.pageX || e.originalEvent.touches[0].pageX;
        diff = (startX - x) / winW * 70;
        if ((!curSlide && diff < 0) || (curSlide === numOfSlides && diff > 0)) diff /= 2;
        $slider.css("transform", "translate3d("+ (-curSlide*100 - diff) +"%,0,0)");

      });
    });

    element.on("mouseup touchend", function(e) {
      element.off("mousemove touchmove");
      if (animating) return;

      if (!diff) {
        changeSlides(true);
        return;
      }
      if (diff > -8 && diff < 8) {
        changeSlides();
        return;
      }
      if (diff <= -8) {
        navigateLeft();
      }
      if (diff >= 8) {
        navigateRight();
      }
    });

    element.on("click", ".slider-control", function() {
      if ($(this).hasClass("left")) {
        navigateLeft();
      } else {
        navigateRight();
      }
    });


    element.on("click", ".slider-pagi__elem", function() {
      curSlide = $(this).data("page");
      changeSlides();
    });
  }
});
