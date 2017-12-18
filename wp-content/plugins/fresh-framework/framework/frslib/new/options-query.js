(function($){
	frslib.provide('frslib.options2');

	/**
	 * Printing our options
	 */
	frslib.options2.query = Backbone.View.extend({
		_data : null,

		_structure: null,

		_currentPath : '',

		get : function( queryString ) {
			if( queryString == undefined) {
				queryString = '';
			}

			var result = this.getWithoutComparation( queryString );

			return result;
		},

		set: function( path, value ) {
			var queryRoute = path.split(' ');
			var pointer = this._data;
			var queryCount = queryRoute.length;

			for( var key in queryRoute ) {
				var oneRoute = queryRoute[ key ];

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
			// var resultType = typeof pointer;
		},

		getWithoutComparation: function( queryString, returnAsArrayButNotQuery ) {
			if( queryString == undefined ) {
				return null;
			}

			if( returnAsArrayButNotQuery == undefined ) {
				returnAsArrayButNotQuery = false;
			}

			if( this._data == null ) {
				return null;
			}

			if( this._currentPath != '' ) {
				if( queryString != '' ) {
					queryString = this._currentPath + ' ' + queryString;
				} else {
					queryString = this._currentPath;
				}
			}

			var queryRoute = queryString.split(' ');

			var pointer = this._data;

			for( var key in queryRoute ) {
				var oneRoute = queryRoute[ key ];

				if( pointer[ oneRoute ] != undefined ) {
					pointer = pointer[ oneRoute ];
				} else {
					return null;
				}
			}

			var resultType = typeof pointer;

			if( resultType == 'string' || resultType == 'number' || returnAsArrayButNotQuery ) {
				return pointer;
			} else {
				return this.getNewQuery( queryString );
			}
		},

		getWithoutComparationDefault: function( query, defaultValue) {
			if( defaultValue == undefined ) {
				defaultValue = null;
			}

			var value = this.getWithoutComparation( query );

			if( value != null ) {
				return value;
			} else {
				return defaultValue;
			}
		},

		exists: function( query ) {
			return this.queryExists( query );
		},

		queryExists: function( query ) {
			var value = this.getWithoutComparationDefault( query, null );
			if( value == null ) {
				return false;
			} else {
				return true;
			}
		},

		getMustBeQuery: function( query ) {
			if( this.exists( query ) ) {
				return this.get(query);
			} else {
				return this.get();
			}
		},

		getNewQuery: function( queryString ) {
			var newQuery = new frslib.options2.query();

			newQuery.setPath( queryString );
			newQuery.setData( this._data );
			newQuery.setStructure( this._structure );

			return newQuery;
		},

		each: function( callback ) {
			var queryToTraverse = this.get();

			var pureDataArray = queryToTraverse.getWithoutComparation('', true);

			for( var key in pureDataArray ) {
				var splitted = key.split('-|-');
				var id = splitted[0];
				var sectionType = splitted[1];

				var newQueryString = key + ' ' + sectionType;

				var newQuery = queryToTraverse.getWithoutComparation( newQueryString );

				if( newQuery == null ) {
					newQuery = this;
				}

				callback.call(this, newQuery, sectionType, id );
			}
		},

		_delete: function( path ) {

			var queryRoute = path.split(' ');
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
			return  _.size( this.getWithoutComparation( path, true) );
		},

		unset: function( path ) {
			var queryRoute = path.split(' ');
			var routeSize = queryRoute.length;

			this._delete( path );

			// console.log( routeSize );

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

		setStructure: function( structure ) {
			this._structure = structure;
		},

		getData: function() {
			return this._data;
		},

		setPath: function( path ) {
			this._currentPath = path;
		}
	});

})(jQuery);

