(function($){
	frslib.provide('frslib.options2');

	/**
	 * Printing our options
	 */
	frslib.options2.printer = frslib.options2.printerSections.extend({

        _printCustomData: false,

	 	getSectionData : function( query ) {
            console.log( query );
			var start = performance.now();
			if( query != undefined ) {
				this._query = query;
				this._callCallbacks = false;
			}
			var ignoreDataBackup = this._ignoreData;
			var printAllBackup = this._printAll;
			var cbQueryFoundBackup = this._cbQueryFound;


			this._ignoreData = true;
			this._printAll = true;

			var foundItem = null;
			this._cbQueryFound = function( item ){
				if( foundItem == null ) {
					// console.log( item );
					// foundItem = JSON.parse(JSON.stringify(item));
					foundItem = item;
				}
			};


			var startTime = performance.now();
			this._walkItem( this._structure );
			var endTime = performance.now();

			this._cbQueryFound = cbQueryFoundBackup;
			this._ignoreData = ignoreDataBackup;
			this._printAll = printAllBackup;

			var end = performance.now();
			console.log( 'Search for item: ' + (end - start ) );

			return foundItem;
		},

		getSectionChilds: function( query ) {
			var sectionData = this.getSectionData( query );

			var toReturn = [];

			for( var i in sectionData['childs'] ) {
				var oneChild = sectionData['childs'][i];

				var newChild = {};
				newChild.value = oneChild.id;
				newChild.name = this._getItemParam( oneChild, 'section-name', 'NOT SET NAME');

				toReturn.push( newChild );
			}

			return toReturn;
		},

		printNewPart: function( query, customData ) {
			var outputBackup = this._output;
			var ignoreDataBackup = this._ignoreData;
			var printAllBackup = this._printAll;
            var dataBackup = null;

			this._ignoreData = true;
			this._printAll = true;

            if( customData ) {
                dataBackup = frslib.clone( this._data );
                this._data = frslib.clone( customData );
                console.log( customData );
                this._ignoreData = false;
                this._printAll = false;
                this._printCustomData = true;
            }

			this._output = '';
			this.walk( query );
			var newOutput = this._output;

			this._ignoreData = ignoreDataBackup;
			this._printAll = printAllBackup;
			this._output = outputBackup;

            if( customData ) {
                this._data = dataBackup;
                this._printCustomData = false;
            }

			return newOutput;
		},

	});

})(jQuery);
