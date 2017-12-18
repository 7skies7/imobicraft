(function($){
	frslib.provide('frslib.options2');

	/**
	 * Basic class for walking our options
	 */
	frslib.options2.walker = Backbone.View.extend({
	/*----------------------------------------------------------*/
	/* CALLBACKS
	/*----------------------------------------------------------*/
		_cbOption: function( item ) {},
		_cbElement: function( item ) {},

		_cbSectionNormalBefore: function( item ) {},
		_cbSectionNormalAfter: function( item ) {},

		_cbSectionRepVariableBefore: function( item ) {},
		_cbSectionRepVariableAfter: function( item ) {},

		_cbSectionRepVariationBefore: function( item ) {},
		_cbSectionRepVariationAfter: function( item ) {},

		_cbSectionRepVariableEmptyStart: function( item ) {},
		_cbSectionRepVariableEmptyEnd: function( item ) {},

		_cbQueryFound: function( item ){},
	/*----------------------------------------------------------*/
	/* DATA
	/*----------------------------------------------------------*/
		/**
		 * User Input
		 */
		_data: null,

		/**
		 * options structure
		 */
		_structure: null,

		_metaData: [],

		/**
		 *
		 * @param blockHash
		 * @private
		 */
		_blocks : null,

		_currentWalkedItem: null,

	/*----------------------------------------------------------*/
	/* PROPERTIES
	/*----------------------------------------------------------*/

		/**
		 * Ignore the data parameters and print only the default data
		 */
		_ignoreData: false,

		/**
		 * Force to print everything, ignore hide default and can be empty
		 */
		_printAll: false,
	/*----------------------------------------------------------*/
	/* USEFUL VARIABLES
	/*----------------------------------------------------------*/

		/**
		 * route which contains only ID's, without repeatable stuff
		 */
		_cleanRoute: [],

		_route: [],

		_sectionRoute: [],

		_query: null,

		_queryValueRoute: [],

		_callCallbacks: true,
	/*----------------------------------------------------------*/
	/* FUNCTIONS
	/*----------------------------------------------------------*/

		setMetaDataAll: function( metaData ) {
			this._metaData = metaData;
		},

		setMetaData: function( name, value ) {
			this._metaData[ name ] = value;
		},

		getMetaData: function( name, defaultValue ) {
			if( this._metaData[name] == undefined ) {
				return defaultValue;
			} else {
				return this._metaData[name];
			}
		},

		/**
		 * Go trough whole options
		 */
		walk: function( query ) {
			if( query != undefined ) {
				this._query = query;
				this._callCallbacks = false;
			}


			var startTime = performance.now();
			this._walkItem( this._structure );
			var endTime = performance.now();

			// console.log('Walking options: ' + (endTime - startTime));
		},

		/**
		 *
		 * @param item
		 * @private
		 */
		_walkItem: function( item ) {
			if( item == null || item == undefined ) {
				console.log( 'ITEM NULL', this._route );
				return false;
			}

			this._currentWalkedItem = item;
			// this._addRoute( item.id );

			switch( item.overall_type ) {
				case 'option':
						this._walkOption( item );
					break;

				case 'element':
						this._walkElement( item );
					break;

				case 'section':

					/**
					 * If its block, then its stored somewhere else, to avoid duplication
					 */
					if( this._getItemParam(item, 'is-block') ) {
						var blockUniqueHash = this._getItemParam( item, 'unique-hash');
						var blockItem = this._blocks[ blockUniqueHash ];

						this._setItemParam( blockItem, 'block-unique-hash', blockUniqueHash);

						this._walkSection( blockItem );
					} else {
						this._walkSection( item );
					}

					break;

				case 'reference':
						console.log('TODO');
					break;
			}
		},

		_walkOption : function( item ) {
			this._addRoute( item.id );

			item.userValue =  this._getCurrentRouteValue();

			// fill it with default value
			if( item.userValue == null ) {
				item.value = item.defaultValue;
			} else {
				item.value = item.userValue;
			}

			this._cbOption(item);
			this._removeRoute( item.id );
		},

		_walkElement: function( item ) {
			this._cbElement(item);
		},

		_walkSection: function( item ) {
			if( item == null ) {
				// console.log( this._route );
				return;
			}
			switch( item.type ) {
				case 'normal':
				case 'section':
					this._walkSectionNormal( item );
					break;

				case 'repeatable_variable':
					this._walkSectionRepeatableVariable( item );
					break;

				case 'repeatable_variation':
					this._walkSectionRepeatableVariation( item )
					break;
			}
		},

		_walkSectionNormal: function( item ) {
			this._addRoute( item.id );

			this._cbSectionNormalBefore(item);

			for( var id in item.childs ) {
				var child = item.childs[ id ];

				this._walkItem( child );
			}

			this._cbSectionNormalAfter(item);

			this._removeRoute( item.id );
		},

		_walkSectionRepeatableVariable: function( item ) {
			this._addRoute( item.id );
			var repeatableItems = this._getCurrentRouteValue();
			var canBeEmpty = this._getItemParam( item, 'can-be-empty', false)

			this._cbSectionRepVariableBefore(item);

			if( canBeEmpty ) {
				this._cbSectionRepVariableEmptyStart(item);
			}

			if ( this._ignoreData == false && repeatableItems != null ) {
				for( var oneItemNameWithNumber in repeatableItems ) {

					var splitedNames = oneItemNameWithNumber.split('-|-');
					var sectionID = splitedNames[0];
					var sectionName = splitedNames[1];

					var newChild = this._findChildById( item, sectionName );

					this._addRoute( oneItemNameWithNumber, true );

					this._walkSection( newChild );

					this._removeRoute( oneItemNameWithNumber, true );

				}
			}
			// print default values without data
			else if( this._ignoreData != false ) {
				// console.log( item );
				for( var childNumber in item.childs ) {
					var child = item.childs[ childNumber ];
					var childId = child.id;
					var childIdWithNumber = childNumber + '-|-' + childId;

					// not print when hiding default
					if( this._getItemParam( child, 'hide-default') && this._printAll == false ) {
						continue;
					}

					this._addRoute( childIdWithNumber, true );

					this._walkSection( child );

					this._removeRoute( childIdWithNumber, true );
				}
			}

			if( canBeEmpty ) {
				this._cbSectionRepVariableEmptyEnd(item);
			}


			this._cbSectionRepVariableAfter(item);
			this._removeRoute( item.id );
		},

		_walkSectionRepeatableVariation: function( item ) {
			this._addRoute( item.id );

			var hideDefault = this._getItemParam(item, 'hide-default', false);

			// console.log( hideDefault, this._printAll )
			// if( !(hideDefault && this._printAll == false && this._getCurrentRouteValue() = ) ) {
				this._cbSectionRepVariationBefore(item);
				for( var id in item.childs ) {
					var child = item.childs[ id ];
					this._walkItem( child );
				}
				this._cbSectionRepVariationAfter(item);
			// }


			this._removeRoute();
		},

	/*----------------------------------------------------------*/
	/* ROUTES
	/*----------------------------------------------------------*/
		_compareWithQueryAndEnablePrinting: function() {

			if( this._query == null ) {
				return;
			}
			var cleanRouteString = this._cleanRoute.join(' ');

			// console.log( cleanRouteString )

			if( cleanRouteString.indexOf( this._query ) != -1 ) {

				/**
				 * We have to avoid valse positive for this query
				 * o gen content
				 * o gen content-bg-color
				 *
				 * so this is test against it
				 *
				 */

				var cleanRouteWithoutQuery = cleanRouteString.replace( this._query, '' );

				if( cleanRouteWithoutQuery.length == 0 || cleanRouteWithoutQuery.charAt(0) == ' ') {
					this._callCallbacks = true;
				} else {
					this._callCallbacks = false;
				}
			} else {
				this._callCallbacks = false;
			}
		},

		_addRoute : function( id, isRepeatableVariationInfo ) {
			this._route.push( id );

			if( isRepeatableVariationInfo != true ) {
				this._cleanRoute.push( id );
			}

			this._compareWithQueryAndEnablePrinting();

			if( this._callCallbacks ) {
				this._queryValueRoute.push( id );
				this._cbQueryFound( this._currentWalkedItem );
			}
		},

		_removeRoute: function(id, isRepeatableVariationInfo ) {
			this._route.pop();

			if( isRepeatableVariationInfo != true ) {
				this._cleanRoute.pop();
			}

			if( this._callCallbacks ) {
				this._queryValueRoute.pop();
			}

			this._compareWithQueryAndEnablePrinting();


		},

		_getRouteValue: function( route ) {
			var currentDataHolder = this._data;

			for( var key in route ) {
				var name = route[ key ];

				if( currentDataHolder == undefined ) {
					return null;
				}

				currentDataHolder = currentDataHolder[ name ];
			}

			return currentDataHolder;
		},

		_getCurrentRouteValue: function() {
			if( this._queryValueRoute.length > 0 && this._printCustomData != true) {
				return this._getRouteValue( this._queryValueRoute );
			} else {
				return this._getRouteValue( this._route );
			}
		},

		_getCurrentRoute: function() {
			if( this._queryValueRoute.length > 0 ) {
				return this._queryValueRoute;
			} else {
				return this._route;
			}
		},

		_getCurrentRouteLevel: function() {
			return this._route.length;
		},

		_findChildById : function( itemContainingChilds, id ) {
			var childToReturn = null;

			for( var childId in itemContainingChilds.childs ) {

				if( itemContainingChilds.childs[ childId][ 'id' ] == id ) {
					childToReturn = itemContainingChilds.childs[ childId ];
					break;
				}

			}

			return childToReturn;
		},
	/*----------------------------------------------------------*/
	/* GETTERS AND SETTERS
	/*----------------------------------------------------------*/
		setData: function( data ) {
			this._data = this._makeSureItsJSON( data );
		},

		getData: function(data ) {
			return this._data;
		},

		setStructure: function( structure ) {
			this._structure = this._makeSureItsJSON( structure );
		},

		getStructure: function() {
			return this._structure;
		},

		setBlocks: function( blocks ) {
			this._blocks = blocks;
		},

		getBlocks: function() {
			return this._blocks;
		},

		setIgnoreData: function( value ) {
			this._ignoreData = value;
		},

		_makeSureItsJSON : function( data ) {
			if( typeof data == 'string' ) {
				try {
					data = JSON.parse( data );
				} catch (e ) {
					data = null;
				}

			}

			return data;
		},

		_getItemParam : function ( item, param, defaultValue ) {
			if( item == null ) {
				return null;
			}
			if( item.params == undefined || item.params == null ) {
				if( defaultValue != undefined) {
					return defaultValue;
				} else {
					return null;
				}
			}
			if( item.params[param] != undefined &&  item.params[param] != null ) {

				if( typeof item.params[param] == 'string' || typeof item.params[param] == 'number' ) {
					return item.params[param];
				} else {
					return item.params[param][0];
				}

			} else {
				if( defaultValue != undefined) {
					return defaultValue;
				} else {
					return null;
				}
			}
		},

		_setItemParam:function( item, name, value ) {
            if( item == undefined ) {
                return;
            }
			if( item.params == undefined || item.params == null ) {
				item.params = [];
			}

			if( item.params[ name] == undefined ) {
				item.params[ name ] = [];
			}

			item.params[name] . push( value );
		},

		_getItemParamArray : function( item, param ) {
		if( item.params == undefined || item.params == null ) {
			return null;
		}
		if( item.params[param] != undefined && item.params[param] != null ) {
			return item.params[param];
		} else {
			return null;
		}
	}

	});

})(jQuery);
