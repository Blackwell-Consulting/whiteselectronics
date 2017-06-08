(function e(t,n,r){function s(o,u){if(!n[o]){if(!t[o]){var a=typeof require=="function"&&require;if(!u&&a)return a(o,!0);if(i)return i(o,!0);var f=new Error("Cannot find module '"+o+"'");throw f.code="MODULE_NOT_FOUND",f}var l=n[o]={exports:{}};t[o][0].call(l.exports,function(e){var n=t[o][1][e];return s(n?n:e)},l,l.exports,e,t,n,r)}return n[o].exports}var i=typeof require=="function"&&require;for(var o=0;o<r.length;o++)s(r[o]);return s})({1:[function(require,module,exports){
var warrantyRegistrationForm = function (formID) {
  var $form = $('#gform_' + formID),
    $serialNumberInput = $('#input_' + formID + '_1'),
    $modelInput = $('.model-field').find('input'),
    $serialNumberInputContainer = $serialNumberInput.parents('.ginput_container'),

    $readonly = $form.find('.readonly :input'),

    models = $form.data('available-models'),

    serialValidationStateMessage = {
      INVALID: 'Serial number is required.',
      INVALID_LENGTH: 'Serial number is not valid. Please try again or call 1-541-367-6121'
    },

    isErrorShowing = false;

  function validateInput(input) {
    if (input.length > 0 && input.length < 11)
      return serialValidationStateMessage.INVALID_LENGTH;

    return '';
  }

  function showValidationError(message) {
    $serialNumberInputContainer.after('<div class="gfield_description validation_message">' + message + '</div>');
  }

  function clearValidationMessages() {
    $serialNumberInputContainer.next('.gfield_description.validation_message').remove();
  }

  function matchModel(input) {
    var id = '';

    // Only start matching models between digits 5 - 8 (inclusive)
    if (input.length < 5) {
      $modelInput.val('');
      return;
    }

    id = input.substring(4, 8);

    // early termination if # of digits is less than 4
    if (id.length < 4) {
      $modelInput.val('');
      return;
    }

    if (typeof models[id] === 'undefined') {
      $modelInput.val('Other');
      return;
    }

    $modelInput.val(models[id]);
  }

  function onSerialNumberChange(event) {
    var input = event.currentTarget.value;
    var message = '';

    if ((message = validateInput(input)).length > 0) {
      if (isErrorShowing)
        return;

      showValidationError(message);
      isErrorShowing = true;
      return;
    } else {
      if (isErrorShowing) {
        clearValidationMessages();
        isErrorShowing = false;
      }
    }

    matchModel(input);
  }

  $serialNumberInput.blur(onSerialNumberChange);
  // $serialNumberInput.change(onSerialNumberChange).keyup(function () {
  //   $(this).change();
  // });
  

  $readonly.attr('readonly', 'readonly');

  if (($serialNumberInput.val()).length > 0) {
    $serialNumberInput.trigger('blur');
  }

};

/**
 * Used to only match specific forms on a page. We don't want this functionality bound to every form on the page.
 */
jQuery(document).bind('gform_post_render', function() {
  var $this = $(this),
    formID = parseInt($this.find('input[name="gform_submit"]').val()),
    validForms = [4, 12];

  if ($.inArray(formID, validForms) > -1)
    warrantyRegistrationForm(formID);
});


},{}]},{},[1]);
