jQuery(document).ready(function($){

	$('.ff-replace-url-button').click(function(){

		var $oldUrl = $('.ff-old-url');
		var $newUrl = $('.ff-new-url');

		var oldUrl = $oldUrl.val();
		var newUrl = $newUrl.val();

		// console.log( oldUrl.length );
		var canContinue = true;
		if( oldUrl.length == 0 ) {
			canContinue = false;
		}

		if( newUrl.length == 0 ) {
			canContinue = false;
		}

		console.log( canContinue, oldUrl.length );

		if( canContinue == false ) {
			$.freshfaceAlertBox('Old URL or New URL cannot be empty');

			return false;
		} else {
			return confirm('This script will be doing irrevirsible changes in your database. We strongly recommend you to backup it!');
		}

	});


});