var $ = require('jquery');
var magnificPopup = require('../lib/magnific-popup.min');
var waitFor = require('waitFor');

waitFor('.woocommerce-products-compare-compare-link', function () {

  var $compareBtn = $('.woocommerce-products-compare-compare-link, .woocommerce-products-compare-widget-compare-button'),
      $compareCheckBoxes = $('.woocommerce-products-compare-checkbox'),
      internalCount = 0;

  // only activate the compare products button if more than one product has been displayed
  $compareCheckBoxes.on('change', function(e) {
    if (!$(this).is(':checked')) {
      --internalCount;
      if (internalCount < 0)
        internalCount = 0;
    } else {
      ++internalCount;
    }

    showCompareButton();
  });

  // sync checkboxes from cookie
  $(function() {
    if(typeof $.wc_products_compare_frontend != 'undefined') {
      syncCheckboxes();
    }
    showCompareButton();
  });

  $compareBtn.magnificPopup({
    type: 'iframe',
    iframe: {
      markup: '<div class="mfp-iframe-scaler">'+
      '<div class="mfp-close"></div>'+
      '<iframe class="mfp-iframe" frameborder="0" allowfullscreen></iframe>'+
      '</div>',
      patterns: {
        whites: {
          src: window.config.baseUrl + '/products-compare'
        }
      },
      srcAction: 'iframe_src'
    },
    callbacks: {
      close: function() {
        // update checkboxes whenever modal closes to keep things in sync
        syncCheckboxes();
      }
    }
  });

  // modify magnificPopup to only open if there are products to compare
  $.magnificPopup.instance.open = function(data) {
    if(typeof $.wc_products_compare_frontend != 'undefined') {
      if(internalCount > 1) {
        $.magnificPopup.proto.open.call(this, data);
      }
    }
  }

  function syncCheckboxes() {
    var comparedProducts = $.wc_products_compare_frontend.getComparedProducts();
    if(comparedProducts) {
      internalCount = comparedProducts.length;
      $compareCheckBoxes.each(function() {
        var $this = $(this),
          productId = $this.data('product-id');
        $(this).prop('checked', $.inArray(productId.toString(), comparedProducts) >= 0);
      });
    }
  }

  function showCompareButton() {
    if(typeof $.wc_products_compare_frontend != 'undefined') {
      $compareBtn.parent().toggleClass('active', internalCount > 1);
    }
  }

});
