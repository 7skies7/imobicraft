(function($){
	frslib.provide('frslib.options2');

	frslib.options2.dataHolder = {};


    frslib.messages.addListener(function (message) {
        if (message.command == "globalStylesChange" ) {

            var newGlobalStyles = frslib.clone( message.globalStyles);
            frslib.options2.dataHolder.allGlobalStyles = newGlobalStyles;
        }
    });

	/**
	 * Printing our options
	 */
	frslib.options2.dataManager = Backbone.View.extend({




		_ongoingRequests : [],


		getSelectHtmlFromArray: function( dataArray, selectedValue ) {

			var html = '';

			for( var i in dataArray ) {
				var oneOption = dataArray[i];
				var selected = '';

				if( selectedValue instanceof Array) {
					if( selectedValue.indexOf( oneOption['value'] ) != -1 ) {
						selected = ' selected="selected" ';
					}
				} else {
					if( selectedValue == oneOption['value'] )  {
						selected = ' selected="selected" ';
					}
				}



				html += '<option value="' + oneOption['value'] + '" ' + selected +'>';
				html += oneOption['name'];
				html += '</option>';
			}

			return html;
		},
		
		getSidebars: function( callback ) {
			if( frslib.options2.dataHolder.sidebars == undefined ) {
				this._ajaxOptionsRequest('getSidebars', {}, function( response ){
					var sidebars = response.sidebars;
					if( sidebars == null ) {
						sidebars = {};
					}

					frslib.options2.dataHolder.sidebars = sidebars;

					callback( sidebars );
				});
			} else {
				callback( frslib.options2.dataHolder.sidebars );
			}
		},

		getElementGlobalStyles: function( callback ) {
			if( frslib.options2.dataHolder.elementGlobalStyles == undefined ) {
                if( $('.ffb-builder-globalstyles').length > 0 ) {
                    var globalStylesJSON = $('.ffb-builder-globalstyles').val();

                    var globalStyles = null;
                    try {
                        globalStyles = JSON.parse( globalStylesJSON );
                    }  catch (e ){
                        globalStyles = null;
                    }
                    if( globalStyles != null ) {
                        frslib.options2.dataHolder.elementGlobalStyles = globalStyles;
                        callback(globalStyles);
                    }

                }

                if( frslib.options2.dataHolder.elementGlobalStyles == undefined ) {
                    this._ajaxOptionsRequest('getElementGlobalStyles', {}, function (response) {
                        var globalStyles = response.globalStyles;
                        if (globalStyles == null) {
                            globalStyles = {};
                        }

                        frslib.options2.dataHolder.elementGlobalStyles = globalStyles;

                        callback(globalStyles);
                    });
                }


			} else {
				callback( frslib.options2.dataHolder.elementGlobalStyles );
			}
		},

		saveElementGlobalStyles: function( callback ) {
			this._ajaxOptionsRequest('setElementGlobalStyles', { globalStyles: frslib.options2.dataHolder.elementGlobalStyles }, function( response ){
				console.log( response );
			});
		},

		elementGlobalStyleExists: function( elementId, elementVariation ) {
			var globalStyles = new frslib.options2.dataHolder();
			globalStyles.setData( frslib.options2.dataHolder.elementGlobalStyles );

			var newRoute = [];
			newRoute.push(elementId);
			newRoute.push(elementVariation);
			newRoute.push('name');

			var result =  globalStyles.getArray( newRoute.join(' '), null );
			if( result == null ) {
				return false;
			} else {
				return true;
			}
		},

		getElementGlobalStyle: function( elementId, elementVariation, styleRoute, systemTabId ) {
			styleRoute = styleRoute.split(' ').join('_');

			var globalStyles = new frslib.options2.dataHolder();
			globalStyles.setData( frslib.options2.dataHolder.elementGlobalStyles );

			var newRoute = [];
			newRoute.push(elementId);
			newRoute.push(elementVariation);
			newRoute.push(styleRoute);
			newRoute.push(systemTabId);

			newRoute = newRoute.join(' ');

			var result = globalStyles.getArray( newRoute);
			var toReturn = {};
			if( result == null ) {
				return toReturn;
			} else {
				toReturn[ systemTabId ] = result;
				return toReturn;
			}

		},

		setElementGlobalStyle: function( elementId, elementVariation, styleRoute, systemTabId, data ) {
			styleRoute = styleRoute.split(' ').join('_');

			var globalStyles = new frslib.options2.dataHolder();
			globalStyles.setData( frslib.options2.dataHolder.elementGlobalStyles );

			var newRoute = [];
			newRoute.push(elementId);
			newRoute.push(elementVariation);
			newRoute.push(styleRoute);
			newRoute.push(systemTabId);

			if( data == undefined ) {
				globalStyles.unset(newRoute.join(' '));
			} else {
				globalStyles.set( newRoute.join(' '), data);
			}
			
			//
			// var globalStyles = frslib.options2.dataHolder.elementGlobalStyles;
			//
			// if( globalStyles == undefined ) {
			// 	globalStyles = {};
			//
			//
			// }
			// if( globalStyles[ elementId ] == undefined ) { globalStyles[elementId] ={}; }
			// if( globalStyles[ elementId ][ elementVariation ] == undefined ) { globalStyles[elementId][ elementVariation ] ={}; }
			//
			// if( globalStyles[ elementId ][ elementVariation ][ styleRoute ] == undefined ) { globalStyles[elementId][ elementVariation ][styleRoute ] ={}; }
			//
			// if( data == undefined ) {
			// 	delete globalStyles[ elementId ][ elementVariation ][ styleRoute ][ systemTabId ];
			//
			// 	if( globalStyles[ elementId ][ elementVariation ][ styleRoute ] == undefined || globalStyles[ elementId ][ elementVariation ][ styleRoute ].length == 0  ) {
			// 		delete globalStyles[ elementId ][ elementVariation ][ styleRoute ];
			// 	}
			//
			// } else {
			// 	globalStyles[ elementId ][ elementVariation ][ styleRoute ][ systemTabId ] = data;
			// }
			//
			//
			// frslib.options2.dataHolder.elementGlobalStyles = globalStyles;
		},

        getAllGlobalStyles: function( callback ) {
            if( frslib.options2.dataHolder.allGlobalStyles == undefined ) {
                this._ajaxOptionsRequest( 'getAllGlobalStyles', {}, function ( response ) {
                    if( response.status == 1 ) {
                        var allGlobalStyles = response.allGlobalStyles;

                        //console.log( allGlobalStyles );

                        //var fontsJSON = response.fonts;
                        //var fonts = JSON.parse( fontsJSON );

                        // console.log( fonts );

                        //var fontsArray = [];
                        //fonts.items.forEach(function( entry ){
                        //    var newFont = {};
                        //    newFont.name = entry.family;
                        //    newFont.value = "'" + entry.family + "'";
                        //    fontsArray.push( newFont)
                        //});
                        //
                        frslib.options2.dataHolder.allGlobalStyles = allGlobalStyles;

                        callback( allGlobalStyles );
                    }
                });
            } else {
                callback( frslib.options2.dataHolder.allGlobalStyles );
            }
          //if( )
        },

		getAllGoogleFonts: function( callback ) {

			if( frslib.options2.dataHolder.allGoogleFonts == undefined ) {

				this._ajaxOptionsRequest( 'getAllGoogleFonts', {}, function ( response ) {
					if( response.status == 1 ) {
						var fontsJSON = response.fonts;
						var fonts = JSON.parse( fontsJSON );

						// console.log( fonts );

						var fontsArray = [];
						fonts.items.forEach(function( entry ){
							var newFont = {};
							newFont.name = entry.family;
							newFont.value = "'" + entry.family + "'";
							fontsArray.push( newFont)
						});

						frslib.options2.dataHolder.allGoogleFonts = fontsArray;

						callback( fontsArray );
					}
				});
			} else {
				callback( frslib.options2.dataHolder.allGoogleFonts );
			}
		},

        getAvailableACFGroups: function( callback ) {
            if( frslib.options2.dataHolder.acf == undefined ) {
                this._ajaxOptionsRequest( 'getAllAcfGroups', {}, function ( response ) {
                    if( response.status == 1 ) {
                        var allAcfGroups = response.allAcfGroups;
                        var allAcfFields = response.allFields;
                        //console.log( 'received');

                        //console.log( response );

                        //var fontsJSON = response.fonts;
                        //var fonts = JSON.parse( fontsJSON );

                        // console.log( fonts );

                        //var fontsArray = [];
                        //fonts.items.forEach(function( entry ){
                        //    var newFont = {};
                        //    newFont.name = entry.family;
                        //    newFont.value = "'" + entry.family + "'";
                        //    fontsArray.push( newFont)
                        //});
                        //
                        frslib.options2.dataHolder.acf = {};
                        frslib.options2.dataHolder.acf.groups = allAcfGroups;
                        frslib.options2.dataHolder.acf.fields = allAcfFields;
                        callback( frslib.options2.dataHolder.acf );
                    }
                });
            } else {
                callback( frslib.options2.dataHolder.acf );
            }
        },

		getAvailableGoogleFonts: function( callback ) {
			if( frslib.options2.dataHolder.googleFonts == undefined ) {
				frslib.ajax.frameworkRequest('theme-get-available-google-fonts', null, null, function( response ) {
					var fontsArray;
					try {
						fontsArray = JSON.parse( response );
					} catch(e) {
						fontsArray = [];
					}


					var toReturn = [];

					for( var i in fontsArray ) {
						var oneFont = fontsArray[ i ];



						// var font = {};
						// font.name = oneFont;
						// font.value = oneFont;
						//
						toReturn.push( oneFont );
					}

					frslib.options.themebuilder.availableGoogleFonts = toReturn;
					callback( toReturn );
				});
			} else {
				callback( frslib.options2.dataHolder.googleFonts );
			}
		},

		getColorLibrary: function(callback) {
			// if( frslib.options2.dataHolder.colorLibrar )
		},

		getPostsByType: function( postType, callback ) {
			frslib.provide('frslib.options2.dataHolder.posts');
			if( frslib.options2.dataHolder.posts[ postType ] == undefined ) {

				this._ajaxOptionsRequest( 'getPostByType', {postType: postType}, function( response) {
					if( response.status == 1 ) {
						frslib.options2.dataHolder.posts[ postType ] = response.posts;
						callback( response.posts );
					}
				});

			} else {
				callback( frslib.options2.dataHolder.posts[ postType ] );
			}
		},

		getTaxonomiesByType: function( taxType, callback ) {
			frslib.provide('frslib.options2.dataHolder.tax');

			if( frslib.options2.dataHolder.tax[ taxType ] == undefined ) {

				this._ajaxOptionsRequest( 'getTaxonomiesByType', {taxType: taxType}, function( response) {
					// console.log( response );
					if( response.status == 1 ) {
						frslib.options2.dataHolder.tax[ taxType ] = response.tax;
						callback( response.tax );
					}
				});

			} else {
				callback( frslib.options2.dataHolder.tax[ taxType ] );
			}
		},

		getRevolutionSliders: function( callback ) {
			// frslib.provide('frslib.options2.dataHolder.tax');

			if( frslib.options2.dataHolder.revo == undefined ) {
				this._ajaxOptionsRequest( 'getRevolutionSlider', {}, function( response) {
					// console.log( response );
					if( response.status == 1 ) {
						frslib.options2.dataHolder.revo = response.revolutionSliders;
						callback( response.revolutionSliders );
					}
				});
			} else {
				callback( frslib.options2.dataHolder.revo );
			}
		},

		_ajaxOptionsRequest: function( action, data, callback ) {
			var self = this;
			if( this._ongoingRequests[ action ] == undefined || this._ongoingRequests[ action ] == null ) {
				this._ongoingRequests[ action ] = [];

			}

			this._ongoingRequests[ action ].push( callback );
			frslib.ajax.frameworkRequest('ffOptionsPrinter2', {action:action}, data, function( response ) {

				for( var i in self._ongoingRequests[ action ] ) {
					var oneCallback = self._ongoingRequests[ action ][ i ];
					oneCallback.call( this, response );
				}

				self._ongoingRequests[ action ] = null;
			});


		},

		/*----------------------------------------------------------*/
		/* FUNCTIONS
		 /*----------------------------------------------------------*/
		initialize: function() {



			this.getElementGlobalStyles(function(styles){
                //console.log('aaa');
				 //console.log( styles );

			});
			// alert('dataMan');
			// this._optionsPrinter = new frslib.options2.printer();
			// this._formParser = new frslib.options2.formParser();
			// init Potential Inherited childrens
			// this._initChildren();
		},

	});

	frslib.options2.dataManager.saveColorLibrary = function() {
		var data = {};
		data.colorLibrary = window.frs_theme_color_library;
		frslib.ajax.frameworkRequest('ffThemeBuilderColorLibrary', {action:'save'}, data, function( response ) {
			console.log( response );
		});
	};

	$(document).ready(function(){

		$('#publish').on('click', function(){

			frslib.options2.dataManager.saveColorLibrary();

		});

	});


    dataManager = new frslib.options2.dataManager();
    dataManager.getAvailableACFGroups(function(){});


})(jQuery);

