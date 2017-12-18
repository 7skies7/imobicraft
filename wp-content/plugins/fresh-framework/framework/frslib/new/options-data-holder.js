(function($){
	frslib.provide('frslib.options2');

	/**
	 * Printing our options
	 */
	frslib.options2.dataHolder = Backbone.View.extend({
		_data : null,
 
		_meta : null,

		_path: null,

/**********************************************************************************************************************/
/* CIG
/**********************************************************************************************************************/
		createNewDataHolder: function( query ) {
			var newDataHolder = new frslib.options2.dataHolder();
			newDataHolder.setData( this._data );


			var newQuery = '';
			if( this._path != null ) {
				newQuery = this._path;
			}

			if( query != undefined ) {
				if( newQuery == '' ) {
					newQuery = query;
				} else {
					newQuery = newQuery + ' ' + query;
				}
			}
			newDataHolder.setPath( newQuery );

			return newDataHolder;
		},

/**********************************************************************************************************************/
/* GETTING
/**********************************************************************************************************************/
		getArray: function( query, defaultValue ) {
			return this._get( query, defaultValue );
		},

		get: function( query, defaultValue ) {
			var parsedQuery = this._parseQuery( query );
			var result =this._get( parsedQuery, defaultValue );

			if( result != null && typeof result == 'object' ) {
				var dataHolder = this.createNewDataHolder( query );

				// dataHolder.setPath( query );
				// dataHolder.setData( this._data );

				return dataHolder;
			} else {
				return result;
			}
		},

		_makeSureQueryIsArray: function( query ) {
			var queryArray = query;
			if( typeof query == 'string' ) {
				queryArray = query.split(' ');
			}

			return queryArray;
		},

		_get: function( query, defaultValue ) {
			if( defaultValue == undefined ) {
				defaultValue = null;
			}

			var queryArray = this._makeSureQueryIsArray(query);

			if( this._data == null ) {
				return null;
			}

			var pointer = this._data;

			for( var key in queryArray ) {
				var onePathPart = queryArray[ key ];

				if( pointer[ onePathPart ] != undefined ) {
					pointer = pointer[ onePathPart ];
				} else {
					return defaultValue;
				}
			}

			return pointer;
		},

		_parseQuery: function( query ) {
			if( query == null && this._path == null ) {
				return null;
			} else if( query == null && this._path != null ) {
				return this._path.split(' ');
			} else if( query != null && this._path == null ) {
				return query.split(' ');
			} else if( query != null && this._path != null ) {
				var newPath = this._path + ' ' + query;
				return newPath.split(' ');
			}
		},


		set: function( query, value ) {
			var queryArray = this._parseQuery( query );

			var pointer = this._data;
			var queryCount = queryArray.length;

			for( var key in queryArray ) {
				var oneRoute = queryArray[ key ];

				if( pointer[oneRoute] == undefined ) {
					pointer[oneRoute] = {};
				}

				if( (parseInt( key ) + 1) ==  queryCount ) {
					pointer[ oneRoute ] = value;
				}

				if( typeof pointer[ oneRoute ] == 'object' ) {
					pointer = pointer[ oneRoute ];
				}
			}
		},



		each: function( callback ) {
			var path = this._parseQuery();

			var objectToTraverse = this._get(path);

			for( var key in objectToTraverse ) {
				var newData = this.get(key);
				callback( newData, key);
			}
		},

		_delete: function( path ) {
			var queryRoute = path;
			if( typeof path == 'string' ) {
				queryRoute = path.split(' ');
			}

			var pointer = this._data;
			var numberOfPaths = queryRoute.length;

			for( var key in queryRoute ) {
				var oneRoute = queryRoute[ key ];
				if( ( parseInt(key) +1) == numberOfPaths ) {
					delete pointer[ oneRoute ];
					return true;
				}
				if( pointer[ oneRoute ] != undefined ) {
					pointer = pointer[ oneRoute ];
				} else {
					return null;
				}
			}
		},

		getNumberOfElementsInPath: function( path ) {
			return  _.size( this._get( path ) );
		},

		unset: function( query ) {
			var queryRoute = this._parseQuery( query );
			var routeSize = queryRoute.length;

			this._delete( queryRoute );

			for( var i = routeSize-1; i >= 0; i-- ) {
				var newPath = [];

				for( var x = 0; x <= i; x++ ) {
					newPath.push( queryRoute[ x ] );
				}

				var newPathString = newPath.join(' ');

				if( this.getNumberOfElementsInPath( newPathString ) == 0 ) {
					this._delete( newPathString );
				}

			}
		},


		/*----------------------------------------------------------*/
		/* SMALL
		 /*----------------------------------------------------------*/
		setData: function( data ) {
			this._data = data;
		},


		getData: function() {
			return this._data;
		},

		setPath: function( path ) {
			this._path = path;
		},
	});

})(jQuery);

