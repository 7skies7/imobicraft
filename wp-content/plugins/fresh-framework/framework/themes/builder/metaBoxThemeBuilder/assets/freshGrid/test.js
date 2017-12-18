

(function($){

	"use strict"; // Start of use strict

	// DOCUMENT READY

	$(document).ready(function(){

		// REMOVE LATER - START

		// $('div[class|="col"]').each(function(){
		// 	var randomColor = Math.floor(Math.random()*16777215).toString(16);
		// 	$(this).css('background', '#' + randomColor);
		// });

		$('.stretch').each(function(){
			$(this).append('<div class="sizer"></div><div class="sizer2">');
			$('.sizer').css({
				'background': 'red',
				'width': '80px',
				'height': '80px',
				'margin': '0 auto',
				'opacity': '0.5'
			})
			$('.sizer2').css({
				'background': 'blue',
				'width': '80px',
				'height': '80px',
				'margin': '0 auto',
				'opacity': '0.5'
			})
		});

		$('.sizer').on('click', function(){
			if ( 80 == $(this).outerHeight() ){
				$(this).animate({
					'height': '400px'
				});
			} else {
				$(this).animate({
					'height': '80px'
				});				
			}
		});

		$('.sizer2').on('click', function(){
			if ( 80 == $(this).outerHeight() ){
				$(this).css({
					'height': '200px'
				});
			} else {
				$(this).css({
					'height': '80px'
				});				
			}
		});

		$('.sizer').on('contextmenu', function(){
			if ( 80 == $('.sizer').outerHeight() ){
				$('.sizer').animate({
					'height': '400px'
				});
			} else {
				$('.sizer').animate({
					'height': '80px'
				});				
			}
			return false;
		});

		$('.sizer2').on('contextmenu', function(){
			if ( 80 == $('.sizer2').outerHeight() ){
				$('.sizer2').css({
					'height': '200px'
				});
			} else {
				$('.sizer2').css({
					'height': '80px'
				});				
			}
			return false;
		});

		// REMOVE LATER - END
	});


})(jQuery);