(function($){

	$(document).ready(function(){

		$('.ff-button-action-verify').click(function(){
			var data = {};
			data.action = 'verify';
			data.licenseKey = $('.ff-input-license-key').val();
			data.email = $('.ff-input-email').val();

			frslib.ajax.frameworkAdminScreenRequest(data, function(response){
				console.log( response );
				if( parseInt(response.status) == 1 ) {
					$('.ff-ajax-output-holder').html(response.html);
				}

			});

			return false;

		});


		$(document).on('click', '.ff-button-action-register', function(){
			var data = {};
			data.action = 'register';
			data.licenseKey = $('.ff-input-hidden-key').val();
			data.email = $('.ff-input-hidden-email').val();

			frslib.ajax.frameworkAdminScreenRequest(data, function(response){


				$('.ff-ajax-output-holder').html(response);
				if( parseInt(response.status) == 1 ) {

					$('.ff-ajax-output-holder').html(response.html);

				}

			});

			return false;
		});

        $('.ffb-clean-backend-cache').click(function(){
            localStorage.removeItem('freshbuilder_data');
            localStorage.removeItem('freshbuilder_version_hash');
        });

	});

})(jQuery);