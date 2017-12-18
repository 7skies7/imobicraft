/**
 * Created by thomas on 17.8.16.
 */
(function($) {

	frslib.provide('frslib.options.standard');
/**********************************************************************************************************************/
/* INIT HIDING BOX
/**********************************************************************************************************************/
	/*----------------------------------------------------------*/
	/* INIT TABS
	 /*----------------------------------------------------------*/
	/**
	 * Tabs in the modal window
	 * @param $options
	 */
	frslib.options.standard.initHidingBox = function( $options ) {


		$options.find('.ff-hiding-box-normal').each(function(){

			var $hidingBox = $(this);

			var optionName = $hidingBox.attr('data-option-name');
			var optionValue = $hidingBox.attr('data-option-value').split(',');

			var optionOperator = $hidingBox.attr('data-option-operator');

			var $parent = $hidingBox.closest('.ff-repeatable-content, .ff-options, .ff-hiding-box-normal-parent');



			var $actionInput = $parent.find('.ff-opt-' + optionName + ':first');

			var compareHidingBox = function(){

				var actionInputValue;

				if( $actionInput.attr('type') == 'checkbox' ) {
					actionInputValue = $actionInput.prop('checked');

					if( actionInputValue ) {
						actionInputValue = 'checked';
					} else {
						actionInputValue = 'unchecked';
					}

				} else {
					actionInputValue = $actionInput.val();
				}


				if( optionOperator == 'equal' ) {
					if( optionValue.indexOf(actionInputValue) != -1  ) {
						$hidingBox.stop(true, false).show(500);
					} else {
						$hidingBox.stop(true, false).hide(500);
					}
				}
				else {
					if( optionValue.indexOf(actionInputValue) == -1 ) {
						$hidingBox.stop(true, false).show(500);
					} else {
						$hidingBox.stop(true, false).hide(500);
					}
				}
			};

			compareHidingBox();

			$actionInput.on('change', function( e ){
				e.stopPropagation();
				compareHidingBox();

			});

		});


	};
	frslib.callbacks.addCallback( 'initOneOptionSet', frslib.options.standard.initHidingBox );
	frslib.callbacks.addCallback( 'options-section-inserted', frslib.options.standard.initHidingBox );

})(jQuery);