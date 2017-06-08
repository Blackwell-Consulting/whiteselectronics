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

