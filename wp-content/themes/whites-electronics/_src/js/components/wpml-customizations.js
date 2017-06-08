/**
 * Overriding the the languages list to add gb for en-GB language from browsers to support redirects for UK
 * Created by bbierman on 8/3/16.
 */
var waitFor = require('waitFor');
var originalWPMLBrowserRedirect = new WPMLBrowserRedirect();

WPMLBrowserRedirect.prototype.oldGetBrowserLanguage = originalWPMLBrowserRedirect.getBrowserLanguage;
WPMLBrowserRedirect.prototype.addUKLanguage = function(languages, callback) {
  var ukIndex = languages.indexOf('en-GB');
  if(ukIndex !== -1) {
    languages.splice(ukIndex, 0, 'gb');
  }
  callback(languages);
};

// override the wpmlbrowserredirect object's instance method
WPMLBrowserRedirect = function() {
  var instance = originalWPMLBrowserRedirect;
  instance.getBrowserLanguage = function (success) {
    this.oldGetBrowserLanguage(function(languages) {
      instance.addUKLanguage(languages, success);
    });
  };

  return instance;
};

waitFor('#lang_sel', function () {
  var $languageLinks = $('#lang_sel a');
  var cookieName = '_icl_visitor_lang_js';

  $languageLinks.on('click', function (e) {
    var $parentElement = $(this).parent('li');
    var languageClass = $parentElement.attr('class');

    if (typeof languageClass === 'undefined')
      return true;

    if (!$.cookie(cookieName)) {
      var firstLocationOfHyphen = languageClass.indexOf('-') + 1;
      var language = languageClass.substr(firstLocationOfHyphen, languageClass.length);
      $.cookie(cookieName, language);
    }

    return true;
  });
});
