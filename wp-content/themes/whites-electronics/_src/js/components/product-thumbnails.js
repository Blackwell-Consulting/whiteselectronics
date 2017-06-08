var waitFor = require('waitFor');

waitFor('.single-product', function() {

	$('.thumbnails .video-thumbnail').click(function(e){
	  	e.preventDefault();

		$video_link =  $(this).attr('href');
		$('.image-bounding-box').css('display','none');
		$('.video-container').addClass('active').html('<iframe height="315" src="' + $video_link + '?rel=0?enablejsapi=1" frameborder="0" allowfullscreen></iframe>');
	});
});