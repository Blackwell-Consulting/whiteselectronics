//casper.test.begin('Start Survey button exists', 1, function suite(test) {
//
//  casper.start('http://whites-electronics.dev01.40digits.net/detector-selector/', function() {
//    test.assertExists('.js_detector-selector-start');
//  }).run(function() {
//    test.done();
//  })
//
//});

var answerOptions = [];

casper.options.waitTimeout = 10000;

casper.test.begin('Survey produces results', 3, function suite(test) {
  casper.start('http://whites-electronics.dev01.40digits.net/detector-selector/', function() {
    test.assertExists('.js_detector-selector-start');
  });

  casper.then(function() {
    this.click('.js_detector-selector-start');
  })
    .waitUntilVisible('.question-where', function() {
      var counter = this.getHTML('.question-counter .counter');
      this.test.assertEquals(counter, "1");
  }).then(function() {
    // get all options
    answerOptions = this.evaluate(function() {
      var returnValue = [];
      $('.js_detector-selector-form .js_question').each(function(idx) {
        returnValue[idx] = $(this).find('input[type="radio"]').length;
      });
      return returnValue;
    });

    this.test.assertEquals(answerOptions.length, 5);
  });

  casper.then(function() {
    // test combinations
    var q1i = 0;
    casper.repeat(answerOptions[0], function() {
      var q2i = 0;
      casper.repeat(answerOptions[1], function() {
        var q3i = 0;
        casper.repeat(answerOptions[2], function() {
          var q4i = 0;
          casper.repeat(answerOptions[3], function() {
            var q5i = 0;
            casper.repeat(answerOptions[4], function() {
              casper.test.comment('Testing Combination: ' + q1i + ',' + q2i + ',' + q3i + ',' + q4i + ',' + q5i);

              casper.reload(function() {
                this.click('.js_detector-selector-start');
              }).waitForSelector('.question-where.active', function() {
                var counter = this.getHTML('.question-counter .counter');
                this.test.assertEquals(counter, "1");
                this.click('.question-where div:nth-of-type(' + (q1i + 2) + ') label');
                this.click('.question-where .js_next');
              }).waitForSelector('.question-what', function() {
                var counter = this.getHTML('.question-counter .counter');
                this.test.assertEquals(counter, "2");
                this.click('.question-what div:nth-of-type(' + (q2i + 2) + ') label');
                this.click('.question-what .js_next');
              }).waitForSelector('.question-tech-savvy.active', function() {
                var counter = this.getHTML('.question-counter .counter');
                this.test.assertEquals(counter, "3");
                this.click('.question-tech-savvy div:nth-of-type(' + (q3i + 2) + ') label');
                this.click('.question-tech-savvy .js_next');
              }).waitForSelector('.question-frequency.active', function() {
                var counter = this.getHTML('.question-counter .counter');
                this.test.assertEquals(counter, "4");
                this.click('.question-frequency div:nth-of-type(' + (q4i + 2) + ') label');
                this.click('.question-frequency .js_next');
              }).waitForSelector('.question-appeal.active', function() {
                var counter = this.getHTML('.question-counter .counter');
                this.test.assertEquals(counter, "5");
                this.click('.question-appeal div:nth-of-type(' + (q5i + 2) + ') label');
                this.click('.question-appeal .js_finish');
              }).waitUntilVisible('.js_detector-selector-results-container', function() {
                casper.test.assertVisible('.js_personality-type.selected');
                casper.test.assertVisible('.js_detector-selector-result.selected');
                casper.test.assertElementCount('.js_detector-selector-result.selected', 6);
              });

              casper.then(function() { q5i++; });
            });

            casper.then(function() { q4i++; });
          });

          casper.then(function() { q3i++; });
        });

        casper.then(function() { q2i++; });
      });

      casper.then(function() { q1i++; });
    });
  });

  casper.run(function() {
    test.done();
  });
});