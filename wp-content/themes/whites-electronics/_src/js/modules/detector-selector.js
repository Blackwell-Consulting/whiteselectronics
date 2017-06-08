var $ = require('jquery');
var cookie = require('../lib/cookie');
var waitFor = require('waitFor');

waitFor('.js_detector-selector', function () {
  var $intro = $('.js_detector-selector-intro-container'),
      $start = $intro.find('.js_detector-selector-start'),
      $form = $('.js_detector-selector-form'),
      questionClass = '.js_question',
      $questions = $form.find(questionClass),
      $resultsContainer = $('.js_detector-selector-results-container'),
      $detectorResults = $resultsContainer.find('.js_detector-selector-results'),
      $detectors = $detectorResults.find('.js_detector-selector-result'),
      activeClass = 'active',
      counter = 1,
      $personalityTypeContainer = $('.js_personality-types'),
      $personalityTypes = $personalityTypeContainer.find('.js_personality-type'),
      noResultsClass = '.js_no-results',
      $adventurersContainer = $('.js_other-adventurers-container'),
      $adventurerType = $('.js_adventurer-type'),
      $baseAdventurerType = $('.js_base-adventurer-type'),
      $otherAdventurer = $('.js_other-adventurer'),
      levels = $personalityTypeContainer.data('levels'),
      detectorSelectorCookie = function() {
        if(!!icl_lang)
          return 'detector-selector-answers-' + icl_lang;

        return 'detector-selector-answers';
      },
      $questionsPriority = $questions.slice().filter(function () {
        return parseInt(this.getAttribute('data-priority')) > 0;
      }).sort(function (a, b) {
        return a.getAttribute('data-priority') - b.getAttribute('data-priority');
      });

  // hide the first previous button
  $questions.first().find('.js_prev')
    .removeClass('js_prev')
    .hide();

  // set the right class on the finish button
  $questions.last().find('.js_next')
    .removeClass('.js_next')
    .addClass('js_finish')
    .text('Finish');

  $start.on('click', function (e) {
    e.preventDefault();

    $('html, body').animate({ scrollTop: $('.detector-selector').offset().top });

    // hide intro and show form
    $intro.add($form).toggle();

    // set first question to active
    $questions.removeClass(activeClass)
      .eq(0)
      .addClass(activeClass);
  });

  $('.js_detector-selector-reset').on('click', function() {
    $.removeCookie(detectorSelectorCookie());
  });

  $form.find('.js_next').on('click', function (e) {
    e.preventDefault();

    $('html, body').animate({ scrollTop: $('.detector-selector').offset().top });

    if ($('.question.active').find('input').is(':checked')) {

      counter++;

      $('.counter').text(counter);

      $questions.filter('.' + activeClass)
        .removeClass(activeClass)
        .next()
        .addClass(activeClass);

      $('.alert-choose').removeClass('display');

    } else {
      $('.alert-choose').addClass('display');
    }
  });

  $form.find('.js_prev').on('click', function (e) {
    e.preventDefault();

    $('html, body').animate({ scrollTop: $('.detector-selector').offset().top });

    counter--;

    $('.counter').text(counter);

    $questions.filter('.' + activeClass)
      .removeClass(activeClass)
      .prev()
      .addClass(activeClass);

    $('.alert-choose').removeClass('display');
  });

  $form.find('.js_finish').on('click', function (e) {
    e.preventDefault();

    $('html, body').animate({ scrollTop: $('.detector-selector').offset().top });

    $('body').addClass('finished');

    $intro.hide();
    $form.hide();
    $resultsContainer.show();

    // store all answers in cookie so the results can be restored on page reload
    if(!$.cookie(detectorSelectorCookie())) {
      var answerIds = $questions
        .find('input[type="radio"]:checked')
        .map(function () {
          return this.getAttribute('data-answerid');
        })
        .get();

      $.cookie(detectorSelectorCookie(), answerIds.join(','));
    }

    showDetectorResults();
    showPersonalityProfile();
    showSimilarProfileAdventurers();
  });

  function getAnswerValues($questions) {
    var answers = [];

    $questions
      .find('input[type="radio"]:checked')
      .each(function() {
        answers.push(parseInt(this.value));
      });

    return answers;
  }

  function getFlags(answers) {
    var result = 0;

    $.each(answers, function() {
      result += this;
    });

    return result;
  }

  function showDetectorResults() {
    var answers = getAnswerValues($questionsPriority);

    // filter products bitwise
    $detectors.removeClass('selected');

    if ($detectors.length) {
      var $filteredResults = getFilteredDetectors(answers)
        .slice(0, 6);

      $filteredResults.addClass('selected');
      $detectors.not($filteredResults).remove();
    }
    else
    {
      $detectorResults.find(noResultsClass).show();
    }
  }

  // Product filtering
  function getFilteredDetectors(answers) {
    var $results = $();

    while (answers.length > 0 && $results.length === 0) {
      // get selected answer flags and filter detector results
      var flags = getFlags(answers);

      $results = $detectors.filter(function () {
        return (parseInt(this.getAttribute('data-flags')) & flags) === flags;
      });

      // remove lowest priority answer in case we get no results
      answers.pop();
    }

    return $results.length !== 0 ?
      $results :
      $detectors;
  }

  function showPersonalityProfile() {
    var levelAnswers = getAnswerValues($questions.filter('.' + detectorSelector.questionSlugs.techSavvy + ', .' + detectorSelector.questionSlugs.frequency));
    var selectedLevel = getFlags(levelAnswers);

    if (selectedLevel in levels) {
      var appealAnswers = getAnswerValues($questions.filter('.' + detectorSelector.questionSlugs.appeal));
      var appealFlags = getFlags(appealAnswers);

      $personalityTypes
        .removeClass('selected')
        .filter(function () {
          var $this = $(this);

          return $this.data('level') === levels[selectedLevel] &&
            (parseInt($this.data('type-flags')) & appealFlags) === appealFlags;
          })
        .addClass('selected');
    }
  }

  function showSimilarProfileAdventurers() {
    var $personalityProfile = $personalityTypes.filter('.selected').first(),
        type = $personalityProfile.data('type'),
        adventurers = $personalityProfile.data('adventurers');

    $adventurerType.text(type);
    $baseAdventurerType.text(type.substr(type.indexOf(' ') + 1));

    $.each(adventurers, function(i) {
      var $adventurer = $otherAdventurer.clone()
        .removeClass('js_other-adventurer');

      $adventurer.find('.js_other-adventurer-name')
        .text(this.name);
      $adventurer.find('.js_other-adventurer-link')
        .attr('href', this.url);
      $adventurer.find('.js_other-adventurer-image')
        .attr('src', this.image);

      $adventurer.insertAfter($otherAdventurer)
        .show();
    });

    $adventurersContainer.toggle(adventurers.length !== 0);
  }

  // restore filled form values from cookie
  $(function() {
    var answersString = $.cookie(detectorSelectorCookie());
    if(!!answersString) {
      var answerIds = answersString.split(',');

      $questions
        .find('input[type="radio"]')
        .prop('checked', false)
        .filter(function() {
          return $.inArray(this.getAttribute('data-answerid'), answerIds) !== -1;
        })
        .prop('checked', true);

      // trigger results
      $form.find('.js_finish').click();
    }
  });
});