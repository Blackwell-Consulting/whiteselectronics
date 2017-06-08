var cookie = require('../lib/cookie');
var waitFor = require('waitFor');

waitFor('.home,.tax-product_cat,.search', function() {

	if( $.cookie('alert') === 'closed' ){
		$('.alert').css('display', 'none');
    }

    // Grab your button (based on your posted html)
    $('.dismiss').click(function( e ){

        // Do not perform default action when button is clicked
        e.preventDefault();

        /* If you just want the cookie for a session don't provide an expires
         Set the path as root, so the cookie will be valid across the whole site */
        $.cookie('alert', 'closed', { path: '/' });
        $('.alert').hide();

    });
});