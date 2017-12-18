(function($){
	frslib.provide('frslib.options2');

	/**
	 * Printing our options
	 */
	frslib.options2.toScConvertor = frslib.options2.walker.extend({

		_printInContent: [],

		_newData : {},

		initialize: function() {
			this._newData = {};
			this._printInContent = [];
		},

		_cbSectionRepVariationBefore: function( item ) {
			if( this._getCurrentRouteValue() != null ) {
				this._setData( this._route, {} );
			}
		},

		_cbOption: function( item ) {
			if( item.userValue != null ) {

				if( this._getItemParam(item, 'print-in-content', false ) == true ) {
					var routeString = this._route.join(' ');
					this._printInContent.push({name: routeString, value: item.userValue});
				} else {
					this._setData( this._route, item.userValue );
				}
			}

			if( item.type == 'textarea' && this._getItemParam(item, 'can-be-richtext', true ) ) {

				var richtextString = this._route.join(' ') + '-is-richtext';
				var richtextRoute  = richtextString.split(' ');

				var richtextValue = this._getRouteValue( richtextRoute );

				if( richtextValue == null ) {
					richtextValue = 0;
				}
				this._setData( richtextRoute, richtextValue);
			}
		},

		_setData: function( route, value ) {
			var pointer = this._newData;

			var routeLength = route.length

			var counter = 0;
			for( var id in route ) {
				counter++;

				var key = route[id];

				if( pointer[key] == undefined ) {
					pointer[key] = {};
				}

				if( counter == routeLength ) {
					pointer[key] = value;
				} else {
					var swap = pointer[key];
					pointer = swap;
				}
			}
		},

		getDataWithoutPrintInContentParam: function() {
			return this._newData;
		},

		getDataPrintInContent: function() {
			return this._printInContent;
		},


	});

})(jQuery);
