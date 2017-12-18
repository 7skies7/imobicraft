(function($) {
	$(document).ready(function(){
	////////////////////////////////////////////////////////////////////////////
	// DELETE CACHE BUTTON
	////////////////////////////////////////////////////////////////////////////
		var $deleteCacheButton = $('#ff_delete_cache');
		var $cacheNumberOfFiles = $('.cache_number_of_files');
		$deleteCacheButton.click( function() {
			$('.ff_delete_cache_spinner').css('display', 'inline-block');
			
			freshlib.ajax({action:'delete_cache'}, function( response ) {
				$('.ff_delete_cache_spinner').css('display', 'none');
				$cacheNumberOfFiles.html(' 0 ');
			});
			return false;
		});
		
		
		
	////////////////////////////////////////////////////////////////////////////
	// ENABLE EXCLUSION
	////////////////////////////////////////////////////////////////////////////		
	var $enableExclusion = $('.ff-enable-exclusion');
		
	$enableExclusion.change(function() {
	
		if( $(this).attr('checked') == 'checked') {
			$('.ff-exclusion').css('opacity', 0).css('display','block');
			$('tr.ff-exclusion').css('display','table-row');
			$('.ff-exclusion').animate({opacity:1}, function() {
					
			});
		} else {		
			$('.ff-exclusion').animate({opacity:0}, function() {
				$(this).css('opacity', 0).css('display','none');
			});
		}
	});

	////////////////////////////////////////////////////////////////////////////
	// FLUSH DATA
	////////////////////////////////////////////////////////////////////////////
	var $flushDataButton = $('#ff_flush_data');
	
	$flushDataButton.click( function() {
		$('.ff_flush_data_spinner').css('display', 'inline-block');
		
		freshlib.ajax({action:'flush_data'}, function( response ) {
			$('.ff_flush_data_spinner').css('display', 'none');
			$('table.ff-exclusion').find('fieldset').html(' ');
			//$cacheNumberOfFiles.html(' 0 ');
		});
		
		return false;
	});
	
	////////////////////////////////////////////////////////////////////////////
	// REFRESH
	////////////////////////////////////////////////////////////////////////////
	var $refreshDataButton = $('#ff_refresh_data');
	
	$refreshDataButton.click( function() {
		$('.ff_refresh_data_spinner').css('display', 'inline-block');
		
		freshlib.ajax({action:'refresh_data'}, function( response ) {
			$('.ff_refresh_data_spinner').css('display', 'none');
			//alert( response );
			
			$('table.ff-exclusion').remove();
			$('p.submit').before(response);
			//$('table.ff-exclusion').find('fieldset').html(' ');
			//$cacheNumberOfFiles.html(' 0 ');
		});
		
		return false;
	});

	
	
	
	
	
	});
})(jQuery);