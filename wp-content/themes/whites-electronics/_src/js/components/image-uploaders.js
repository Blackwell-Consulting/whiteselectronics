$(function() {
  var $fileUploadContainer = $('.file-uploads');

  function addAnother ($container) {
    var $uploadableContainer = $container.find('.uploadable-container'),
        $first = $uploadableContainer.children(':first');

    $upload = $first.clone();
    $uploadableContainer.append($upload);
  }

  // Setup bindings
  $fileUploadContainer.each(function () {
    $this = $(this);
    $addAnotherBtn = $this.find('.add-another');
    $addAnotherBtn.on('click', function () {
      addAnother($this)
    });
  });
});
