var waitFor = require('waitFor');

waitFor('.woocommerce', function() {
  $('.product-information .title').on('click', function(event) {
  	$('.product-information .open').toggleClass('open');
    $(this).parent().toggleClass('open');
   });
});