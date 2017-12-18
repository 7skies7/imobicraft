(function($){
	frslib.provide('window.ffbuilder');

	window.ffbuilder.DataManager = Backbone.DeepModel.extend({
		_vent: null,

		_elementModels: [],

		_blockData: null,

		_blockCallbacks: null,

		_menuItems: null,

		_colorLibrary: null,

		_predefinedElements: null,

		_sections: null,

		_globalStyles: null,

		_saveAjaxCounter: 0,




		/*----------------------------------------------------------*/
		/* SMALL
		 /*----------------------------------------------------------*/

		_bindActions: function() {
			this.listenTo( this._vent, this._vent.a.startLoadingData, this._loadData);
			this.listenTo( this._vent, this._vent.a.getElementViewFromSelector, this.createElementViewFromElement);
		},

		initialize: function( options ) {
			this._vent = options.vent;
			this._bindActions();
		},


		getGlobalStylesDataHolder: function() {
			var data = this.getGlobalStyles();
			var dataHolder = new frslib.options2.dataHolder();
			dataHolder.setData( frslib.options2.dataHolder.elementGlobalStyles );
			// var query = new frslib.options2.query();
			// query.setData( data );
			return dataHolder;
		},

		getPredefinedElement: function( elementName)  {
			return this._predefinedElements[ elementName ];
		},

		getGlobalStyles: function() {
			return frslib.options2.dataHolder.elementGlobalStyles;
		},

		/*----------------------------------------------------------*/
		/* ELEMENT FACTORIES
		 /*----------------------------------------------------------*/
		createElementViewFromElement: function( $element ) {
			if( $element.hasClass('ffb-canvas') ) {
				var elementId = $element.attr('data-element-id');
			} else {
				if( !$element.hasClass('ffb-element') && $element.attr('data-element-id') != '' ) {
					$element = $element.parents('.ffb-element:first');
				}
				var elementId = $element.attr('data-element-id');
			}

			var view = this.createElementViewFromId( elementId );
			view.$el = $element;

			return view;
		},

		getSectionContentFromData: function( sectionData, callback ) {
			// console.log('delam TO ');
			this.themeBuilderAjax( 'getSectionContentFromSectionData', {sectionData: sectionData}, function(response){
				if( response.status == 1 ) {
					callback( response.section_data );
				}
				// 	var sectionDataObject = JSON.parse( response.section_data );
				// 	callback( sectionDataObject );
				// }
			});
		},

		createElementViewFromId: function( elementId ) {
			var view = new window.ffbuilder.ElementView({
				model: this._createElementModelFromId( elementId ),
				vent: this._vent,
				elementModels: this._elementModels,
				currentElementId: elementId,
				blockData: this._blockData,
				blockCallbacks: this._blockCallbacks,
				menuItems: this._menuItems,
				globalStyles: this.getGlobalStylesDataHolder()
			});

			return view;
		},

		saveAjax: function( shortcodesContent ) {
			this._saveAjaxCounter++;
			var data = {};
			data.content = shortcodesContent;
			data.postId = $('#post_ID').val();
			data.colorLibrary = window.frs_theme_color_library;
			data.globalStyles = frslib.options2.dataHolder.elementGlobalStyles;
			data.saveAjaxCounter = this._saveAjaxCounter;
			var self = this;
			this.themeBuilderAjax( 'saveAjax', data, function(response){
				console.log(  response );
				self._vent.f.savedByAjax();
			});
		},

		saveAjaxDefaultElement: function( elementId, defaultData ) {
			var data = {};
			data.elementId = elementId;
			data.defaultData = defaultData;

			data.defaultData = JSON.stringify( data.defaultData );
			var self = this;
			this.themeBuilderAjax('saveAjaxDefaultElement', data, function( response) {
				console.log( response );
				self._vent.f.addNotification( 'info', 'Default element data saved');
			});
		},

		_createElementModelFromId: function( elementId ) {
			var model = this._elementModels[ elementId ];

			var modelCopy = {};
			if( model != undefined ) {
				modelCopy = model.clone();
			}
			return modelCopy;
		},


		_loadData_processData: function( data ) {
            //var plain = JSON.stringify(data);
            ////var deflate = new Zlib.RawDeflate(plain);
            ////var compressed = deflate.compress();
            //
            //var compressed = pako.deflate( plain, { to: 'string' });
            //
            //localStorage.setItem('freshbuilder_data', compressed);

			var self = this;
			/*----------------------------------------------------------*/
			/* MENU ITEMS
			 /*----------------------------------------------------------*/
			// information about all menu items in the "Add" section
			self._menuItems = data.menuItems;

			/*----------------------------------------------------------*/
			/* ELEMENTS DATA
			 /*----------------------------------------------------------*/
			var elementsData = data.elements;

            //console.log( JSON.stringify(data.elements).length * 8);



			var key = null;
			for( key in elementsData ) {
				var oneElement = elementsData[ key ];
				var elementModel = new window.ffbuilder.ElementModel();

				for( var attr in oneElement ) {
					elementModel.set( attr, oneElement[attr]);
				}

				elementModel.set('optionsStructure', JSON.parse( elementModel.get('optionsStructure') ) );
				elementModel.processFunctions();

				self._elementModels[ key ] = elementModel;
			}

			/*----------------------------------------------------------*/
			/* BLOCKS DATA
			 /*----------------------------------------------------------*/
			var blocksDataUnpacked = data.blocks;
			var blocksData = {};
			for( key in blocksDataUnpacked ) {
				blocksData[ key ] = JSON.parse(blocksDataUnpacked[ key ]);
			}

			var blocksCallbacksModel = Backbone.DeepModel.extend({
				render: function( blockName, query, params ) {
					return this.get(blockName)(query, params);
				}
			});
			self._blockCallbacks = new blocksCallbacksModel();

			$.each( data.blocks_functions, function(key, value){
				var f = null; // temporary function holder
				eval('f = ' + value );
				self._blockCallbacks.set(key, f);
			});


			/*----------------------------------------------------------*/
			/* COLOR LIBRARY
			 /*----------------------------------------------------------*/
			// self._colorLibrary = data.color_library;
			// window.frslib.colorLibrary = self._colorLibrary;

			self._blockData = blocksData;

            this._sections = data.sections;

			// self._globalStyles = data.global_styles;


			// console.log( data.sections );

			// self.vent.trigger(self.vent.a.elementsDataLoaded);

			/*----------------------------------------------------------*/
			/* PREDEFINED ELEMENTS
			 /*----------------------------------------------------------*/
			self._predefinedElements = data.predefined_elements;


			this._vent.f.dataLoaded();
		},

		_numberOfRequests : 0,


		_dataHolder : null,


		_errorCounter: 0,

		_loadDataHash: null,

		_loadData_getHash: function() {
			if( this._loadDataHash == null ) {
				var number = new Date().getTime() -  new Date('2016-01-01').getTime();

				this._loadDataHash = number.toString(32);
			}

			return this._loadDataHash;
		},

		_loadData_loadElements: function( callback, position ) {
			console.log( '- one request called');
			var self = this;
			this.themeBuilderAjax( 'getElementsData', {action:'loadElements', position: position, currentLoadHash: this._loadData_getHash() }, function( response ){
				console.log( '- one request responded');
				var data = {};
				try {
					data = JSON.parse( response );

					$('.ffb-builder-loader-status').html( data.builder_message);

					if( self._dataHolder == null ) {
						self._dataHolder = data;

					} else {

						var justOldElements = frslib.clone( self._dataHolder.elements );
						self._dataHolder = data;
						Object.assign( justOldElements, self._dataHolder.elements);

						self._dataHolder.elements = justOldElements;

						// console.log( self._dataHolder );
						// Object.assign( self._dataHolder.elements, data.elements);
					}

					callback.call(self,  data );

				} catch ( e ) {
					console.log(' ERROR ');
					console.log( response);

					self._errorCounter++;
					if( self._errorCounter > 10 ) {
						this._dataManager.deleteBackendBuilderCache(function( response ){
							$.freshfaceAlertBox('There is a problem with loading FreshBuilder. <br> Your page will be refreshed. Please be patient then, the Fresh Builder cache needs to be rebuilt. <br> If this does not help and you see this message more than 4x, plase open a ticket here with your WP login <a target="_blank" href="http://support.freshface.net/forums/forum/community-forums/ark/" style="color:white !important;">HERE</a>', function(){
								location.reload();
							});
						});
					} else {
						self._loadData_loadElements.call(self, callback, position );

					}
				}

			});


		},

		_loadData_saveProcessedElements: function( elements ) {
			// var elementsJSON = JSON.stringify( elements );
			// console.log( 'saving');
			// this.themeBuilderAjax( 'getElementsData', {action:'saveCachedElements', cachedElements: elements}, function( response ){
			// 	console.log('saved');
			// 	console.log( response );
			//
			// });
		},


		_loadData_loadElementsCalback: function( data ) {
			if( data.should_continue == 0 ) {
				var self=  this;
				this._loadData_saveProcessedElements.call(this, self._dataHolder );
				this.themeBuilderAjax( 'getElementsData', {action:'loadRest'}, function( response ){
					var data = JSON.parse( response );
					Object.assign( self._dataHolder, data );
					console.log( self._dataHolder );


                    //var text = JSON.stringify(data);
                    ////var deflate = new Zlib.RawDeflate(plain);
                    ////var compressed = deflate.compress();
                    //

                    try {


                        var jsonString = JSON.stringify(self._dataHolder);
                        var compressed = pako.deflate(jsonString, {to: 'string'});
                        localStorage.setItem('freshbuilder_data', compressed);

                        var currentVersionHash = $('.ffb-builder-version-hash').html();
                        var storageVersionHash = localStorage.setItem('freshbuilder_version_hash', currentVersionHash);

                    } catch (e) {

                    }

					self._loadData_processData.call(self, self._dataHolder );
				});

			} else {
				this._loadData_loadElements(this._loadData_loadElementsCalback, data.should_continue);
			}
		},

		_loadData: function( param) {
            //data =
            //freshbuilder_data
            //

            var enableFreshBuilderCache = $('.ffb-builder-jscache').attr('data-builder-jscache'); //'ffb-builder-jscache" data-builder-js-cache'
            //console.log( enableFreshBuilderCache );
            enableFreshBuilderCache = parseInt( enableFreshBuilderCache );

            var storageVersionHash = localStorage.getItem('freshbuilder_version_hash');
            var currentVersionHash = $('.ffb-builder-version-hash').html();

            if( storageVersionHash != currentVersionHash ) {
                localStorage.removeItem('freshbuilder_data');
            }

            var dataCompressed = localStorage.getItem('freshbuilder_data');
            var loadedFromCache = false;
            try {
                if (enableFreshBuilderCache && dataCompressed) {
                    var dataUncompressed = pako.inflate(dataCompressed, {to: 'string'});
                    var data = JSON.parse(dataUncompressed);
                    data.color_library = JSON.parse($('.ffb-builder-color-lib').html());
                    this._loadData_processData.call(this, data);
                    loadedFromCache = true;
                }
            } catch (e ) {
                loadedFromCache = false;
            }

            if( loadedFromCache == false ) {
                var dataFull = null;
                this._loadData_loadElements(this._loadData_loadElementsCalback, 0);

                setTimeout(function(){
                    $('.ffb-builder-loader-info').css('opacity',0).css('display', 'block').animate({opacity:1}, 1000);
                }, 60*1000);
            }

		},

		deleteBackendBuilderCache: function(callback) {
			this.themeBuilderAjax( 'deleteBuilderCache', {}, callback);
		},



		themeBuilderAjax: function( action, data, callback ) {
			data.builderSettings = this._vent.settings;
			// console.log( 'data');
			frslib.ajax.frameworkRequest('ffThemeBuilder', {action:action}, data, function( response ) {
				callback( response );
			});
		},

		metaboxAjax: function( action, data, callback ) {
			data.action = action;
			var specification = {};
			specification.metaboxClass = 'ffMetaBoxThemeBuilder';
			frslib.ajax.frameworkRequest( 'ffMetaBoxManager', specification, data, function( response ) {
				callback( response );
			});
		},

		getBlockData: function() {
			return this._blockData;
		}

	});


})(jQuery);





















/**
 * Created by thomas on 20.9.16.
 */

