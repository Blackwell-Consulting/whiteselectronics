$(function() {
  $('#nav-icon').on('click', function(event) {
    $(this).toggleClass('open');
    $('header').toggleClass('open');
    $('html').toggleClass('no-scroll');
  });

  $('#search-icon').on('click', function(event) {
    $('#search-box').addClass('show');
    $('.nav-header').addClass('search-open');
    setTimeout(function() {
      $('.search-field').focus();
    }, 400);
    $('html').toggleClass('no-scroll');
  });

  $('#close-search').on('click', function(event) {
    $('#search-box').toggleClass('show');
    $('html').toggleClass('no-scroll');
    setTimeout(function() {
      $('.nav-header').removeClass('search-open');
    }, 400);
  });

  $('#show-more span').on('click', function(event) {
    $('.more-nav').toggleClass('show');
    $('#show-more').toggleClass('show');
  });
});

