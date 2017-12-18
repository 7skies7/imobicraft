(function($){

	frslib.provide('window.ffbuilder');

	window.ffbuilder.App = Backbone.View.extend({
		/*----------------------------------------------------------*/
		/* OBJECTS
		 /*----------------------------------------------------------*/
		_vent: null,

		_dataManager: null,

		_notificationManager: null,

		_canvas: null,

		_modal: null,

		_currentElementView: null,

		_options: null,



		/*----------------------------------------------------------*/
		/* VARIABLES
		/*----------------------------------------------------------*/
		_settings: null,

		_bindActions: function() {
			this.listenTo( this._vent, this._vent.a.editElement, this._actionEditElement );
			this.listenTo( this._vent, this._vent.a.canvasChanged, this._actionCanvasChanged);
			this.listenTo( this._vent, this._vent.a.addElement, this._actionAddElement);
			this.listenTo( this._vent, this._vent.a.saveAjax, this._actionSaveAjax );
			this.listenTo( this._vent, this._vent.a.savedByAjax, this._actionSavedByAjax );


			this.listenTo( this._vent, this._vent.a.dataLoaded, this._actionDataLoaded );

			var self = this;
			$('#publish').click(function(){
				self._actionCanvasChanged();
			});
		},

		initialize: function( opt ) {
			this._options = opt.options;//new frslib.options2.options({vent: this._vent, dataManager: this._dataManager});
			this._notificationManager = opt.notificationManager;

			if( ff_fw_video_recording == true ) {
				 $('html').addClass('ffbvr');

			}
		},

		initializeBuilder: function(){
			this.$el = $('.ffb-builder');
			this._loadDataSettings();

            this._initClasses();
            this._bindActions();
            this._vent.f.startLoadingData();

		},

		_loadDataSettings: function() {
			var settingsJSON = this.$el.find('.ffb-settings-holder').val();
			this._settings = JSON.parse( settingsJSON );
		},

		_initClasses: function() {
			this._vent = this._getVent();
			this._dataManager = new ffbuilder.DataManager({ vent:this._vent});
			this._notificationManager.injectVent( this._vent);
			this._canvas = new ffbuilder.Canvas({ vent: this._vent });
			this._modal = new ffbuilder.Modal({vent: this._vent});

            this._vent.f.classesInitialised();

			this._options._vent = this._vent;

			this._initOptionsWithoutBlocks();
		},

		_initOptionsWithoutBlocks: function() {
			// this._options.initOptionsWithoutBlocks();
		},

		_actionDataLoaded: function() {
			this._options._dataManager = this._dataManager;
			this._options.initOptionsWithBlocks();
			this._modal._sections = this._dataManager._sections;

            // console.log( 'pica');


			$('.ffb-builder-wrapper').addClass('ffb-builder-loaded');
			$('body').trigger('ff-builder-loaded');
			// this._options.setBlockData( this._dataManager._blockData );
			// var blockData = this._dataManager._blockData;
			// frslib.options2.optionsInstance = new frslib.options2.options({ blockData: blockData });
		},

		/*----------------------------------------------------------*/
		/* ACTION EDIT ELEMENT
		 /*----------------------------------------------------------*/
		_actionEditElement: function( $element ) {
			this._currentElementView = this._dataManager.createElementViewFromElement( $element );
			try {
				this._modal.renderEditElement( this._currentElementView );
			} catch ( e ) {
				console.log( e );
				this._dataManager.deleteBackendBuilderCache(function( response ){
					$.freshfaceAlertBox('There is a problem with loading FreshBuilder. <br> Your page will be refreshed. Please be patient then, the Fresh Builder cache needs to be rebuilt. <br> If this does not help and you see this message more than twice, plase open a ticket here with your WP login <a target="_blank" href="http://support.freshface.net/forums/forum/community-forums/ark/" style="color:white !important;">HERE</a>', function(){
						location.reload();
					});
				});
			}
		},

		_actionAddElement: function( $element, callback, triggerSectionTab, predefinedSectionName ) {
			if( predefinedSectionName != undefined ) {
				var sectionData  =this._dataManager.getPredefinedElement( predefinedSectionName );

				callback( 'predefined_section', sectionData );
				return;
			}

			this._currentElementView = this._dataManager.createElementViewFromElement( $element );
			this._modal.renderAddElement( this._currentElementView, callback );

			if( triggerSectionTab == true ) {
				this._modal.triggerSectionTab();
			}
		},

		_actionCanvasChanged: function() {
			var shortcodesString = this._canvas.convertToShortcodes();
			this._setBuilderContent( shortcodesString );
		},

		_actionSaveAjax: function() {
			this._vent.f.addNotification('info', 'Saving...');
			if( ($('#publish').size() > 0 && $('#publish').attr('name') == 'save') || $('#publish').size() == 0 ) {
				try {
					var shortcodesString = this._canvas.convertToShortcodes();

					this._dataManager.saveAjax( shortcodesString );


					$('body').trigger('ff-builder-saving-ajax');
				} catch (e) {
					console.log( e );
					this._dataManager.deleteBackendBuilderCache(function( response ){
						$.freshfaceAlertBox('There is a problem with loading FreshBuilder. <br> Your page will be refreshed. Please be patient then, the Fresh Builder cache needs to be rebuilt. <br> If this does not help and you see this message more than twice, plase open a ticket here with your WP login <a target="_blank" href="http://support.freshface.net/forums/forum/community-forums/ark/" style="color:white !important;">HERE</a>', function(){
							location.reload();
						});
					});
				}


			} else {
				$('#publish').trigger('click');
			}
		},

		_actionSaveAjaxDefaultElementData: function( elementId, data ) {
			this._dataManager.saveAjaxDefaultElement( elementId, data );
		},

		_actionSavedByAjax: function() {
			console.log( this._settings );
			if( this._settings.broadcastRefreshAfterSave != 0 ) {
				frslib.messages.broadcast({'command' : 'refresh', 'post_id': $('#post_ID').val() });
                frslib.messages.broadcast({ 'command' : 'colorLibraryChange', 'colorLibrary': window.frs_theme_color_library});
			} else {
				$('body').trigger('ff-builder-saved-ajax');
			}
		},



		_setBuilderContent: function( content ) {
			if( this._settings.saveAsPost ) {
				$('#content-html').click();

				//$('.wp-editor-area').val(content);
				var activeEditor = tinyMCE.get('content');
				if( activeEditor ==undefined ) {
                    if( $('.wp-editor-area').size() > 1 ) {
                        $('#content').val( content );
                    } else {
                        $('.wp-editor-area').val( content );
                    }

				} else {
					activeEditor.setContent(content);
				}
			} else {
				this.$el.find('.ffb-data-holder').val( content );
			}

		},

		_getVent: function() {
			var self = this;
			var vent = _.extend({}, Backbone.Events);

			vent.settings = this._settings;

			vent.a = {};
			vent.a.classesInitialised = 'classesInitialised';
			vent.a.dataLoaded = 'dataLoaded';
			vent.a.editElement = 'editElement';
			vent.a.addElement = 'addElement';

			vent.a.getElementViewFromSelector = 'getElementViewFromSelector';
			vent.a.canvasChanged = 'canvasChanged';
			vent.a.saveAjax = 'saveAjax';
			vent.a.savedByAjax = 'savedbyAjax';
			vent.a.elementCopied ='elementCopied';
			vent.a.elementPasted = 'elementPasted';
			vent.a.getSectionContentFromData = 'getSectionContentFromData';
            vent.a.startLoadingData = 'startLoadingData';

			vent.f = {};

            vent.f.startLoadingData = function() {
                vent.trigger( vent.a.startLoadingData );
            };

			vent.f.classesInitialised  = function() {
				vent.trigger( vent.a.classesInitialised );
			};

			vent.f.elementCopied = function() {
				vent.trigger( vent.a.elementCopied );
			};

			vent.f.elementPasted = function() {
				vent.trigger( vent.a.elementPasted );
			};

			vent.f.addElement = function( $element, callback, triggerSectionTab, predefinedElementName ) {
				vent.trigger( vent.a.addElement, $element, callback, triggerSectionTab, predefinedElementName );
			};

			vent.f.saveAjax = function() {
				vent.trigger( vent.a.saveAjax );
			};

			vent.f.saveAjaxDefaultElementData = function( elementId, defaultData ) {
				self._actionSaveAjaxDefaultElementData( elementId, defaultData );
			};

			vent.f.savedByAjax = function() {
				vent.trigger( vent.a.savedByAjax );
			};

			vent.f.dataLoaded = function() {
				vent.trigger( vent.a.dataLoaded );
			};

			vent.f.editElement = function( $element ) {
				vent.trigger( vent.a.editElement, $element );
			};

			vent.f.getElementViewFromSelector = function( $element ) {
				return self._dataManager.createElementViewFromElement( $element );
			};

			vent.f.addNotification = function( type, text ) {
				return self._notificationManager.addNotification( type, text);
			};

			vent.f.getElementViewFromId = function( elementId ) {
				return self._dataManager.createElementViewFromId( elementId );
			};

			vent.f.getSectionContentFromData = function( sectionData, callback ) {
				return self._dataManager.getSectionContentFromData( sectionData, callback );
			}

			vent.f.canvasChanged = function () {
				vent.trigger( vent.a.canvasChanged );
			};

			vent.f.log = function( data ) {
				console.log( data );
			};

			vent.on('all', function( name ){
				console.log( name );
			});

			return vent;
		},

	});



	// alert('classs');

	return;


	window.ffbuilder.App = Backbone.View.extend({
		/**********************************************************************************************************************/
		/* INIT
		 /**********************************************************************************************************************/
		xrayMode: 'off',
		blockDraggableOverlay: 'off',

		/*----------------------------------------------------------*/
		/* BINDING ACTIONS
		 /*----------------------------------------------------------*/
		bindActions: function() {
			var self = this;



			$(document).bind('keydown', 'a x r e v b', function( event ){

				event.builderOrigin = 'window';
				self.vent.trigger( self.vent.a.keydown, event );
			});

			// context menu located in iframe sending us messages here
			$('body').on('iframe-contextMenu', function( event, data ){
				switch( data.action ) {
					case 'delete':
						self.vent.trigger( self.vent.a.contextMenu_delete, data);
						break;

					case 'duplicate':
						self.vent.trigger( self.vent.a.contextMenu_duplicate, data);
						break;
				}
			});


			this.vent.listenTo( this.vent, this.vent.a.keydown, function( event ){
				switch( event.keyCode ) {


					// "a"
					case 65:
						self.vent.f.toggleBlockDraggableOverlay();
						break;

					case 66:
						self.vent.f.toggleBoxModelMode();
						break;
					// "x"
					case 88:
						self.vent.f.toggleXrayMode();
						break;

					// "r"
					case 82:
						self.vent.f.toggleCanvasBreakpoint('next');
						break;

					// "e"
					case 69:
						self.vent.f.toggleCanvasBreakpoint('prev');
						break;

					// "v"
					case 86:
						$('.fftm-canvas__editor-mode--toggle').click();
						break;
				}
			});


			this.listenTo( this.vent, this.vent.a.xrayMode_on, this.xrayModeOn);
			this.listenTo( this.vent, this.vent.a.xrayMode_off, this.xrayModeOff);

			this.listenTo( this.vent, this.vent.a.toggleBlockDraggableOverlay_on, this.addNewBlockOverlayOn);
			this.listenTo( this.vent, this.vent.a.toggleBlockDraggableOverlay_off, this.addNewBlockOverlayOff);

			this.listenTo( this.vent, this.vent.a.toggleBlockDraggableOverlay_on, this.boxModelModeOn);
			this.listenTo( this.vent, this.vent.a.toggleBlockDraggableOverlay_off, this.boxModelModeOff);

			this.listenTo( this.vent, this.vent.a.loader_canvas_on, this.loaderCanvasOn);
			this.listenTo( this.vent, this.vent.a.loader_canvas_off, this.loaderCanvasOff);
		},

		/*----------------------------------------------------------*/
		/* INIT
		 /*----------------------------------------------------------*/
		initialize: function() {
			this.vent = this._getVent();
			window.vent = this.vent;
			this.blockManager = new builder.BlockManager({ vent:this.vent });
			this.dataManager = new builder.DataManager({vent:this.vent});
			this.ajaxManager = new builder.AjaxManager({vent:this.vent});
			this.notificationManager = new builder.NotificationManager({vent:this.vent});
			this.revisionManager = new builder.RevisionManager({vent:this.vent});
			this.vent.o.dataManager = this.dataManager;

			this.vent.o.ajaxManager = this.ajaxManager;



			this.iframeView = new builder.IframeView({ vent:this.vent, blockManager:this.blockManager });
			this.editorView = new builder.EditorView({ vent:this.vent, blockManager:this.blockManager });
			this.bindActions();

		},
		/**********************************************************************************************************************/
		/* CONTENT
		 /**********************************************************************************************************************/
		/*----------------------------------------------------------*/
		/* LOADER
		 /*----------------------------------------------------------*/
		// canvas
		loaderCanvasOn: function() {
			//.fftm-canvas__show-loader--canvas
			$(document).find('html').addClass('fftm-canvas__show-loader--canvas');
		},

		loaderCanvasOff: function() {
			//.fftm-canvas__show-loader--canvas
			$(document).find('html').removeClass('fftm-canvas__show-loader--canvas');
		},


		/*----------------------------------------------------------*/
		/* ADD BLOCK OVERLAY
		 /*----------------------------------------------------------*/
		addNewBlockOverlayOn: function() {
			var self = this;
			self.vent.d.blockDraggableOverlayAnimating = true;

			$(document).find('html').removeClass('fftm-canvas__add-new-block-overlay--off fftm-canvas__add-new-block-overlay--anim-exit--ended').addClass('fftm-canvas__add-new-block-overlay--on fftm-canvas__add-new-block-overlay--anim-enter');
			setTimeout(function() {
				$(document).find('html').removeClass('fftm-canvas__add-new-block-overlay--anim-enter').addClass('fftm-canvas__add-new-block-overlay--anim-enter--ended');
				self.vent.d.blockDraggableOverlayAnimating = false;
			}, 157 );

		},

		addNewBlockOverlayOff: function() {
			var self = this;
			self.vent.d.blockDraggableOverlayAnimating = true;
			$(document).find('html').removeClass('fftm-canvas__add-new-block-overlay--on fftm-canvas__add-new-block-overlay--anim-enter--ended').addClass('fftm-canvas__add-new-block-overlay--off fftm-canvas__add-new-block-overlay--anim-exit');
			setTimeout(function() {
				self.vent.d.blockDraggableOverlayAnimating = false;
				$(document).find('html').removeClass('fftm-canvas__add-new-block-overlay--anim-exit').addClass('fftm-canvas__add-new-block-overlay--anim-exit--ended');
			}, 157 );
		},

		/*----------------------------------------------------------*/
		/* XRAY MODE
		 /*----------------------------------------------------------*/

		xrayModeOn : function() {
			var self = this;
			self.vent.d.xrayModeAnimating = true;
			$(document).find('html').removeClass('fftm-canvas__xray-mode--off fftm-canvas__xray-mode--anim-exit--ended').addClass('fftm-canvas__xray-mode--on fftm-canvas__xray-mode--anim-enter');
			setTimeout(function() {
				$(document).find('html').removeClass('fftm-canvas__xray-mode--anim-enter').addClass('fftm-canvas__xray-mode--anim-enter--ended');
				self.vent.d.xrayModeAnimating = false;
			}, 157 );
			//this.enableSortable();
		},

		//

		xrayModeOff : function() {
			var self = this;
			self.vent.d.xrayModeAnimating = true;
			$(document).find('html').removeClass('fftm-canvas__xray-mode--on fftm-canvas__xray-mode--anim-enter--ended').addClass('fftm-canvas__xray-mode--off fftm-canvas__xray-mode--anim-exit');
			setTimeout(function() {
				self.vent.d.xrayModeAnimating = false;
				$(document).find('html').removeClass('fftm-canvas__xray-mode--anim-exit').addClass('fftm-canvas__xray-mode--anim-exit--ended');
			}, 157 );
			//this.disableSortable();
		},

		/*----------------------------------------------------------*/
		/* BOX MODEL MODE
		 /*----------------------------------------------------------*/
		boxModelModeOn: function() {
			$(document).find('html')
				.removeClass('fftm-canvas__box-model-mode--off')
				.addClass('fftm-canvas__box-model-mode--on');
		},

		boxModelModeOff: function(){
			$(document).find('html')
				.removeClass('fftm-canvas__box-model-mode--off')
				.addClass('fftm-canvas__box-model-mode--on')
		},
		/*----------------------------------------------------------*/
		/* ALL ACTIONS
		 /*----------------------------------------------------------*/
		_getVent: function() {
			var vent = _.extend({}, Backbone.Events);




			// actions
			vent.a = {};



			/**
			 * Overlay for adding new blocks
			 * @type {string}
			 */
			vent.a.toggleBlockDraggableOverlay_on = 'toggleBlockDraggableOverlay:on';
			vent.a.toggleBlockDraggableOverlay_off = 'toggleBlockDraggableOverlay:off';


			/**
			 * Enable/disable x-ray mode, to make drag and drop more easier
			 */
			vent.a.xrayMode_on = 'xrayMode:on';
			vent.a.xrayMode_off = 'xrayMode:off';

			/**
			 * Box Model mode
			 */
			vent.a.boxModelMode_on = 'boxModelMode:on';
			vent.a.boxModelMode_off = 'boxModelMode:off';


			/**
			 * Context menu
			 */
			vent.a.contextMenu_delete = 'contextMenu:delete';
			vent.a.contextMenu_duplicate= 'contextMenu:duplicate';



			/**
			 * After the canvas iframe has been loaded
			 */
			vent.a.canvasIframe_load = 'canvasIframe:load';
			vent.a.canvas_connectBlock = 'canvas:connectBlock';
			vent.a.canvas_blockSelected = 'canvas:blockSelected';

			vent.a.canvas_convertTo = 'canvas:convertTo';
			vent.a.canvas_blockOrderChanged = 'canvas:blockOrderChanged';
			vent.a.canvas_renderBoxModelOnBlockByUniqueId = 'canvas:renderBoxModelOnBlockByUniqueId';

			vent.a.canvas_moveBlock = 'canvas:moveBlock';

			vent.a.canvas_toggleResponsiveBreakpoint = 'canvas:toggleResponsiveBreakpoint';


			vent.a.canvas_couldWeRefresh = 'canvas:couldWeRefresh';
			vent.a.canvas_beforeRefresh = 'canvas:beforeRefresh';
			vent.a.canvas_refresh = 'canvas:refresh';

			vent.a.blockData_load = 'blockData:load';
			vent.a.block_formSubmit = 'block:formSubmit';

			vent.a.keydown = 'keydown';

			vent.a.notification_add = 'notification:add';


			vent.a.loader_canvas_on = 'loader:canvas:on';
			vent.a.loader_canvas_off = 'loader:canvas:off';




			/**
			 * Variables
			 * @type {{}}
			 */
			vent.d = {};

			vent.d.blockDraggableOverlay = 'off';
			vent.d.boxModelMode = 'off';
			vent.d.xrayMode = 'off';
			vent.d.xrayModeAnimating = false;
			vent.d.blockDraggableOverlayAnimating = false;

			vent.d.canvas_couldWeRefresh = true;

			vent.d.responsiveModeBreakpoint = 'auto';

			vent.d.iframeLoaded = false;

			vent.d.focus = false;

			vent.d.loader_canvas = false;


			/*----------------------------------------------------------*/
			/* GLOBAL OBJECTS
			 /*----------------------------------------------------------*/
			vent.o = {};

			/*----------------------------------------------------------*/
			/* constants
			 /*----------------------------------------------------------*/
			vent.c = {};


			// responsive mode
			vent.c.responsiveMode = {};


			vent.c.responsiveMode.types = {};

			vent.c.responsiveMode.types.xs = 'xs';
			vent.c.responsiveMode.types.sm = 'sm';
			vent.c.responsiveMode.types.md = 'md';
			vent.c.responsiveMode.types.lg = 'lg';
			vent.c.responsiveMode.types.auto = 'auto';




			vent.c.responsiveMode.info = {};

			vent.c.responsiveMode.info.xs = {};
			vent.c.responsiveMode.info.xs.width = '480px';
			vent.c.responsiveMode.info.xs.name = 'Mobile';

			vent.c.responsiveMode.info.sm = {};
			vent.c.responsiveMode.info.sm.width = '768px';
			vent.c.responsiveMode.info.sm.name = 'Tablet';

			vent.c.responsiveMode.info.md = {};
			vent.c.responsiveMode.info.md.width = '992px';
			vent.c.responsiveMode.info.md.name = 'Laptop';

			vent.c.responsiveMode.info.lg = {};
			vent.c.responsiveMode.info.lg.width = '1200px';
			vent.c.responsiveMode.info.lg.name = 'Desktop';

			vent.c.responsiveMode.info.auto = {};
			vent.c.responsiveMode.info.auto.width = '100%';
			vent.c.responsiveMode.info.auto.name = 'Auto';



			/*----------------------------------------------------------*/
			/* EVENT FUNCTIONS
			 /*----------------------------------------------------------*/
			vent.f = {};

			vent.f.couldWeRefresh = function() {
				vent.trigger( vent.a.canvas_couldWeRefresh );
				return vent.d.canvas_couldWeRefresh;
			};

			vent.f.refresh = function( url ) {
				if( vent.f.couldWeRefresh() ) {
					vent.f.loaderCanvasEnable();
					vent.trigger( vent.a.canvas_beforeRefresh, url );
					vent.trigger( vent.a.canvas_refresh, url );

					return true;
				} else {
					return false;
				}
			};

			vent.f.changeUrl = function( url ) {
				if( vent.f.couldWeRefresh() ) {
					vent.f.loaderCanvasEnable();
					vent.trigger( vent.a.canvas_beforeRefresh, url );
					//vent.trigger( vent.a.canvas_refresh, url );
					window.location = url;

					return true;
				} else {
					return false;
				}
			}

			vent.f.loaderCanvasDisable = function() {
				vent.d.loader_canvas = false;
				vent.trigger( vent.a.loader_canvas_off );
			};

			vent.f.loaderCanvasEnable = function() {
				vent.d.loader_canvas = true;
				vent.trigger( vent.a.loader_canvas_on );
			};

			vent.f.pushNotification = function( type, text ) {
				vent.trigger( vent.a.notification_add, type, text );
			};

			vent.f.toggleBoxModelMode = function() {

				if( vent.d.boxModelMode == 'off' ) {
					vent.trigger( vent.a.boxModelMode_on )
					vent.d.boxModelMode = 'on';

				} else {
					vent.trigger( vent.a.boxModelMode_off )
					vent.d.boxModelMode = 'off';

				}
			};

			vent.f.toggleCanvasBreakpoint = function( type ) {

				if( type == 'next' ) {
					var currentMode = vent.d.responsiveModeBreakpoint;
					var types = vent.c.responsiveMode.types;

					type = frslib.array.nextKey( types, currentMode );

				} else if( type == 'prev' ) {
					var currentMode = vent.d.responsiveModeBreakpoint;
					var types = vent.c.responsiveMode.types;

					type = frslib.array.prevKey( types, currentMode );
				}

				vent.d.responsiveModeBreakpoint = type;
				vent.trigger( vent.a.canvas_toggleResponsiveBreakpoint, type )




			}

			vent.f.toggleXrayMode = function() {

				if( vent.d.xrayModeAnimating  ) {
					return false;
				}

				if( vent.d.xrayMode == 'off' ) {
					vent.trigger( vent.a.xrayMode_on );
					vent.d.xrayMode = 'on';
				} else {
					vent.trigger( vent.a.xrayMode_off );
					vent.d.xrayMode = 'off';
				}
			};

			/*----------------------------------------------------------*/
			/* DRAGGABLE OVERLAY
			 /*----------------------------------------------------------*/
			vent.f.toggleBlockDraggableOverlay = function() {
				if( vent.d.blockDraggableOverlayAnimating ) {
					return false;
				}

				if( vent.d.blockDraggableOverlay == 'off' ) {
					vent.d.blockDraggableOverlay = 'on';
					vent.trigger( vent.a.toggleBlockDraggableOverlay_on );


				} else {
					vent.d.blockDraggableOverlay = 'off';
					vent.trigger( vent.a.toggleBlockDraggableOverlay_off );

					;
				}
			};

			return vent;
		},
	});

})(jQuery, window.builder );



















