var waitFor = require('waitFor');

waitFor('.home', function() {
  $('.latest-finds .slider').slick({
    slidesToShow: 1,
  	slidesToScroll: 1,
  	autoplay: true,
  	autoplaySpeed: 4000,
  	prevArrow: '<button type="button" class="slick-prev"></button>',
  	nextArrow: '<button type="button" class="slick-next"></button>',
  	dots: true,
    swipeToSlide: true
  });

  $('.how-to .slider').slick({
    slidesToShow: 1,
  	slidesToScroll: 1,
  	autoplay: true,
  	autoplaySpeed: 4000,
  	prevArrow: '<button type="button" class="slick-prev"></button>',
  	nextArrow: '<button type="button" class="slick-next"></button>',
    dots: true,
  	swipeToSlide: true
  });
});

waitFor('.single-adventurers', function() {
  $('.slider').slick({
    slidesToShow: 1,
    slidesToScroll: 1,
    autoplay: true,
    autoplaySpeed: 4000,
    dots: true,
    fade: true,
    arrows: false,
    swipeToSlide: true
  });
});

waitFor('.single-find', function() {
  $('.slider').slick({
    slidesToShow: 1,
    slidesToScroll: 1,
    autoplay: true,
    autoplaySpeed: 4000,
    prevArrow: '<button type="button" class="slick-prev"></button>',
    nextArrow: '<button type="button" class="slick-next"></button>',
    dots: true,
    fade: true,
    arrows: true,
    swipeToSlide: true
  });
});


waitFor('.single-product', function() {

  $('.commentlist').slick({
      slidesToShow: 1,
      slidesToScroll: 1,
      autoplay: false,
      dots: false,
      prevArrow: '<button type="button" class="back-button">Back</button>',
      nextArrow: '<button type="button" class="next-button">Next</button>',
      swipeToSlide: true,
      adaptiveHeight: true
  });

  $('.commentlist').on('afterChange', function(event, slick, currentSlide, nextSlide){
      var $status = $('.comment-number')
          text    = 'Review ' + (slick.currentSlide + 1) + '/' + (slick.slideCount);

      $status.text(text);
  });
});