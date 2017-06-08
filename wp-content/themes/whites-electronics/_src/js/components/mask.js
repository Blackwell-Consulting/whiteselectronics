var waitFor = require('waitFor');
var mask = require('../lib/jquery-masked-input');

waitFor('.page-template-repair-status', function() {
	$("#we_phone_number").mask("(999) 999-9999");
});

waitFor('.woocommerce-checkout', function() {
	$("#billing_phone").mask("(999) 999-9999");
});