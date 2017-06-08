var waitFor = require('waitFor');
var ScrollTo = require('../lib/jquery-scrollto');

waitFor('.single-product', function() {
	$('a.link-to-reviews').on('click', function(event) {
		event.preventDefault();

		$('#reviews').ScrollTo({
    		duration: 900,
    		easing: 'linear',
    		offsetTop: 70,
   		});
	});

	$('.product-information .title').on('click', function(event) {
  		$(this).ScrollTo({
    		duration: 300,
    		easing: 'linear',
    		offsetTop: 60,
   		});
   	});
});