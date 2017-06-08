var waitFor = require('waitFor');

waitFor('.woocommerce', function() {
	$filter = $('.filters');
  	if ( $filter.find('.chosen').length != 0 ) {
  		$filter.find('.chosen').parents('.filters').addClass('selected');
  	}
});