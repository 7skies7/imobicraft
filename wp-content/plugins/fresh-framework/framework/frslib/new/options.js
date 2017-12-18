(function($){
	frslib.provide('frslib.options2');

	/**
	 * Printing our options
	 */
	frslib.options2.options = Backbone.View.extend({

		_dataManager: null,

		_vent: null,

		_bindActions: function() {
			var self = this;
			$('#publish').click(function(){
				self.actionSubmittingPage();
				// return false;
			});
		},

		initialize: function( options) {
			// this._dataManager = options.dataManager;
			// this._vent = options.vent;
			this.$el = $('.ff-options-2-holder');

			this._bindActions();
		},

		actionSubmittingPage: function() {
			this.$el.each(function(){
				var optionsManager = $(this).data('ff-optionsManager');
				optionsManager.prepareFormForSaving();
			});
		},

		initOptionsWithoutBlocks: function() {
			var self = this;
			this.$el.filter('[data-has-block-inside="0"]').each(function(){
				self._initOneOptionSet( $(this) );
				$(this).trigger('afterInit');
				$(this).attr('data-has-been-init', 1);
				$(this).addClass('ff-options-2-holder__init');
				// console.log( $(this));
				// console.log( 'trigger after init');
			});
		},

		initOptionsWithBlocks: function() {
			var self = this;
			this.$el.filter('[data-has-block-inside="1"]').each(function(){
				self._initOneOptionSet( $(this) );
				$(this).trigger('afterInit');
				$(this).attr('data-has-been-init', 1);
				$(this).addClass('ff-options-2-holder__init');
			})
		},

		_initOneOptionSet: function( $optionsHolder)  {
			var settings = $optionsHolder.data('settings');

			var structure = this._getJSON($optionsHolder.find('.ff-options2-structure').val());
			var data = this._getJSON($optionsHolder.find('.ff-options2-data').val());

			var optionsManager = new frslib.options2.managerModal();
			optionsManager.setStructure( structure );
			optionsManager.setData( data );
			if( this._dataManager != null ) {
				optionsManager.setBlocks( this._dataManager.getBlockData() );
			}
			optionsManager.setPrefix( settings.prefix);
			var html = optionsManager.render();
			$optionsHolder.find('.ff-options2').html( html );
			$optionsHolder.data('ff-optionsManager', optionsManager);

			// console.log( html );



			$optionsHolder.on('ff-get-form-data', function( event, callback ){
				if( callback != undefined ) {
					var formContent = optionsManager.parseForm();
					callback( formContent );
				}
			});
		},

		_getJSON : function( data ) {
			var toReturn;
			try {
				toReturn = JSON.parse( data );
			} catch( e ) {
				toReturn = {};
			}

			return toReturn;
		}
	});



})(jQuery);

