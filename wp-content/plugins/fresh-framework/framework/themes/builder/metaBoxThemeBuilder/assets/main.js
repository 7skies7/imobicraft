(function($){

	// $(document).ready(function(){
	// 	window.ffbuilder.appInstance = new window.ffbuilder.App();
	// });






	/* ******************************************* */
	/* builder QUICK SAVE fixed floating on scroll */
	/* ******************************************* */

	


	/* ************************************ */
	/* HIGHLIGHT HOVERED FFB ELEMENTS */
	/* ************************************ */


   






    


	return;
    if( window.ffbuilder == undefined ) {
        window.ffbuilder = {};
    }


/**********************************************************************************************************************/
/* APP
/**********************************************************************************************************************/
    window.ffbuilder.App = Backbone.View.extend({

        /**
         * Element Picker View
         */
        elementPickerView: null,

        /**
         * All menu items
         */
        menuItems: null,

        /**
         * This variable contains data about every element
         */
        elementModels: null,

        /**
         * Currently selected (opened options) element view
         */
        selectedElementView: null,

		/**
		 * Canvas View
		 */
		canvasView: null,

		/**
		 * Color library - contains array[ colorID ] => array ( color, name );
		 */
		colorLibrary: null,

		/**
		 * Predefined elements - mainly section with 2,3,4 columns
		 */
		predefinedElements: null,



        /*----------------------------------------------------------*/
        /* BIND ACTIONS
        /*----------------------------------------------------------*/
        /**
         * All dynamic actions binding and interaction with dome
         */
        bindActions: function() {
            var $el = this.$el;
            var self = this;

			$(document).bind('keydown', 'ctrl+s', function(){
				if( self.vent.d.modalOpened == true  ) {
					$('.ffb-modal__action-save-all:first').trigger('click');
				} else {
					self.saveAjax();
				}
				return false;
			});

			$(document).bind('keydown', 'esc', function() {
				if( self.vent.d.modalOpened == true  ) {
					$('.ffb-modal__action-cancel:first').trigger('click');
				}
			});
			/*----------------------------------------------------------*/
			/* EDIT BUTTON
			/*----------------------------------------------------------*/
            $el.on('click','.action-edit-element, .ffb-element-preview.action-edit-element *, .ffb-header, .ffb-header-name', function(e){
                if(e.target != this) return;
				e.stopPropagation();

                self.selectedElementView = self._createElementViewFromElement( $(this) );
                self.selectedElementView.renderOptionsForm();

                self.vent.f.modalShow();
            });

			/*----------------------------------------------------------*/
			/* CANCEL MODAL
			/*----------------------------------------------------------*/
            $(document).on('click', '.ffb-modal__action-cancel', function(e){
                if(e.target != this) return;
				e.stopPropagation();

				if( self.selectedElementView != null &&  $(this).parents('.ffb-modal-add-element').size() == 0 && self.selectedElementView.formHasBeenEdited() ) {
					if( confirm( 'All your changes will be lost') ) {
						self.selectedElementView = null;
						self.vent.f.modalHide();
						self.vent.f.modalSetContent('');
						self.vent.f.addNotification('info', 'Changes lost');
					}
				} else {
					self.selectedElementView = null;
					self.vent.f.modalHide();
					self.vent.f.modalSetContent('');
					self.vent.f.addNotification('info', 'Changes lost');
				}

                return false;
            });



			/*----------------------------------------------------------*/
			/* SAVE MODAL
			/*----------------------------------------------------------*/
			$(document).on('click', '.ffb-modal__action-save-all', function(e){
				e.stopPropagation();
				self.selectedElementView.saveOptionsForm();
				self.saveAjax();
			});

            $(document).on('click', '.ffb-modal__action-save', function( e ) {
				e.stopPropagation();
                self.vent.f.modalHide();
                self.selectedElementView.saveOptionsForm();
                self.selectedElementView.clearOptionsForm();
                self.selectedElementView = null;

                return false;
            });

			$(document).on('click', '.ffb-canvas__add-section-item', function(){
				e.stopPropagation();
				if( $(this).hasClass('ffb-canvas__add-section-item__grid-bs') ) {

					var view = self._createElementViewFromId( 'section-bootstrap' );
					var $html= view.createElementBackendHtml();

					$('.ffb-canvas').children('.ffb-dropzone').append( $html );

					self.vent.f.connectElement( $html );

					// var element var view = this._createElementViewFromId( elementId );
					// var lastElement = self.$el.children('')
				} else if( $(this).hasClass('ffb-canvas__add-section-item__element') ) {
					var view = self._createElementViewFromId( 'canvas' );

					view.renderAddForm(function( $newElement ){

						$('.ffb-canvas').children().append( $newElement );

						self.vent.f.connectElement( $newElement );

					});
				} else if( $(this).hasClass('ffb-canvas__add-section-item__grid') ) {

					var numberOfColumns = $(this).attr('data-number-of-columns');
					var $code = $(self.predefinedElements['section_' + numberOfColumns + '_columns']);

					$('.ffb-canvas').children().append( $code );

					var view = self._createElementViewFromId('section');

					view.normalizeElementAfterCopyAndDuplication( $code );

					self.vent.f.connectElement( $code );
				}

			});

			this.bindContextMenu();

			/*----------------------------------------------------------*/
			/* ADD ELEMENT
			/*----------------------------------------------------------*/
            $(document).on('click', '.action-add-element, .ffb-dropzone:empty', function(){

                self.selectedElementView = self._createElementViewFromElement( $(this) );
                self.selectedElementView.renderAddForm();

            });

			$(document).on('click', '.ffb-save-ajax', function(){

				self.saveAjax();

				return false;
			});

            // when canvas is changed, convert to shortcodes and fill it into WP editor
            this.vent.listenTo(this.vent, this.vent.a.canvasChanged, function(){
                self.writeCanvasToPostContentArea();
            });

            // when all elements data are loaded, we are going to refresh the canvas
            // to render the preview of all elements
            this.vent.listenTo(this.vent, this.vent.a.elementsDataLoaded, function(){
				self.loadElementDataToArray();
                self.refreshElementsPreview( self.$el );
                self.elementPickerView = new window.ffbuilder.ElementPickerView({vent: self.vent, elementModels: self.elementModels, menuItems: self.menuItems});
            });
        },

		loadElementDataToArray: function() {
			return;
			var self = this;
			self.$el.find('.ffb-element').each(function(){
				var uniqueId = $(this).attr('data-unique-id');

				var dataString = $(this).attr('data-options');
				// var data = JSON.parse( dataString );

				self.vent.o.elementData[ uniqueId ] = dataString;
				$(this).attr('data-options', '');
				// console.log( uniqueId );
			});

			// console.log( self.vent.o );
		},


		bindContextMenu: function( $element ){
			var self = this;
			/*----------------------------------------------------------*/
			/* CONTEXT MENU
			 /*----------------------------------------------------------*/
			/**
			 * Copy, Paste, Delete, Duplicate and other stuff is handled here
			 */

			var $contextMenu;

			if( $element != undefined ) {
				$contextMenu = $element.find('.action-toggle-context-menu');
			} else {
				$contextMenu = $('.action-toggle-context-menu');
			}


			$contextMenu.each(function(){

				/*----------------------------------------------------------*/
				/* creating selector
				/*----------------------------------------------------------*/
				var $element = $(this).parents('.ffb-element:first');

				var uniqueId = $element.attr('data-unique-id');
				var selector = '.ffb-element[data-unique-id="' + uniqueId +'"] .action-toggle-context-menu:first';

				var hasDropzone = $(this).hasClass('action-toggle-context-menu-dropzone');

				$.contextMenu({
					selector: selector,
					className: 'ffb-canvas-contextmenu',
					trigger: 'left',
					animation: {duration: 0, show: 'show', hide: 'hide'},
					position: function(opt, x, y) {
						opt.$menu.position({
							my: 'left top',
							at: 'left bottom',
							of: opt.$trigger
						});
					},

					build: function( $trigger, e ) {
						var view = self._createElementViewFromElement( $element );
						var elementIsDisabled = view.isElementDisabled();

						var items;

						var disableText = 'Disable';
						if( elementIsDisabled == 1 ) {
							disableText = 'Enable';
						}

						if( hasDropzone ) {
							items =  {
								'insert' : {
									name: 'Add New',
									items: {
										'insert-before' : {name:'Before'},
										'insert-after' : {name:'After'},
										'insert-inside-top' : {name:'Inside Start'},
										'insert-inside-bottom' : {name:'Inside End'}
									}
								},

								'duplicate': {name: "Duplicate"},
								'copy': {name: "Copy" },
								'paste': {
									name: "Paste",
									items: {
										'paste-before' : {name:'Before'},
										'paste-after' : {name:'After'},
										'paste-inside-top' : {name:'Inside Start'},
										'paste-inside-bottom' : {name:'Inside End'}
									}
								},

								'disable-or-enable': {name: disableText},

								'delete': {name: "Delete"}
							};
						} else {
							items =  {
								'insert' : {
									name: 'Add New',
									items: {
										'insert-before' : {name:'Before'},
										'insert-after' : {name:'After'},
									}
								},

								'duplicate': {name: "Duplicate"},
								'copy': {name: "Copy" },
								'paste': {
									name: "Paste",
									items: {
										'paste-before' : {name:'Before'},
										'paste-after' : {name:'After'},
										// 'paste-inside' : {name:'Inside'}
									}
								},

								'disable-or-enable': {name: disableText},
								'delete': {name: "Delete"}
							};
						}


						return {
							callback: function (key, options) {

								/*----------------------------------------------------------*/
								/* INSERT
								 /*----------------------------------------------------------*/
								// BEFORE AND AFTER
								if (key == 'insert-before' || key == 'insert-after') {
									var $parent = $(this).parents('.ffb-element:first').parent().closest('.ffb-element, .ffb-canvas');
									var $this = $(this);
									var view = self._createElementViewFromElement($parent);


									view.renderAddForm(function ($newElement) {
										if (key == 'insert-before') {
											$this.parents('.ffb-element:first').before($newElement);
										} else if (key == 'insert-after') {
											$this.parents('.ffb-element:first').after($newElement);
										}
										self.vent.f.connectElement($newElement);
									});
								}
								// inside top and bottom
								else if (key == 'insert-inside-top' || key == 'insert-inside-bottom') {
									var $element = $(this).parents('.ffb-element:first');
									var $this = $(this);
									var view = self._createElementViewFromElement($element);

									view.renderAddForm(function ($newElement) {
										if (key == 'insert-inside-top') {
											$element.find('.ffb-dropzone:first').prepend($newElement);
										} else if (key == 'insert-inside-bottom') {
											$element.find('.ffb-dropzone:first').append($newElement);
										}
										self.vent.f.connectElement($newElement);
									});

								}

								/*----------------------------------------------------------*/
								/* PASTE
								 /*----------------------------------------------------------*/
								// before and after
								else if (key == 'paste-before' || key == 'paste-after') {

									var $parent = $(this).parents('.ffb-element:first').parent().closest('.ffb-element, .ffb-canvas');

									var view = self._createElementViewFromElement($parent);


									var elementValue = frslib.clipboard.pasteFrom();

									var $element = $(elementValue);

									if (!$element.hasClass('ffb-element')) {
										alert('This is not a valid element');
										return false;
									}

									/*----------------------------------------------------------*/
									/* COULD WE DROP CHECK
									 /*----------------------------------------------------------*/
									var originalElementId = $element.attr('data-element-id');

									var canWeInsertElement = view.canWeInsertElementInside(originalElementId);

									if (canWeInsertElement == true) {
										if (key == 'paste-before') {
											$(this).parents('.ffb-element:first').before($element);
										} else if (key == 'paste-after') {
											$(this).parents('.ffb-element:first').after($element);
										}


										var newView = self._createElementViewFromElement($element);
										newView.normalizeElementAfterCopyAndDuplication($element);

										self.vent.f.connectElement($element);
										self.vent.f.animateCanvasElement($element, 'element-pasted');

									} else {
										alert(canWeInsertElement);
									}

								}


								// inside top and bottom
								else if (key == 'paste-inside-top' || key == 'paste-inside-bottom') {
									var $parent = $(this).parents('.ffb-element:first');
									var view = self._createElementViewFromElement($parent);


									var elementValue = frslib.clipboard.pasteFrom();

									var $element = $(elementValue);

									if (!$element.hasClass('ffb-element')) {
										alert('This is not a valid element');
										return false;
									}

									/*----------------------------------------------------------*/
									/* COULD WE DROP CHECK
									 /*----------------------------------------------------------*/
									var originalElementId = $element.attr('data-element-id');

									var canWeInsertElement = view.canWeInsertElementInside(originalElementId);

									// alert( canWeInsertElement );

									if (canWeInsertElement == true) {
										if (key == 'paste-inside-top') {
											$parent.find('.ffb-dropzone:first').prepend($element);
										} else if (key == 'paste-inside-bottom') {
											$parent.find('.ffb-dropzone:first').append($element);
										}

										var newView = self._createElementViewFromElement($element);
										newView.normalizeElementAfterCopyAndDuplication($element);

										self.vent.f.connectElement($element);
										self.vent.f.animateCanvasElement($element, 'element-pasted');
									} else {
										alert(canWeInsertElement);
									}
								}


								else if (key == 'copy') {
									var view = self._createElementViewFromElement($(this).parents('.ffb-element:first'));
									view.copyElement();
								}

								else if( key == 'disable-or-enable' ) {
									var view = self._createElementViewFromElement($(this).parents('.ffb-element:first'));
									view.isElementDisabled('switch');
								}

								else if (key == 'duplicate') {
									var view = self._createElementViewFromElement($(this).parents('.ffb-element:first'));
									view.duplicateElement();
								}

								else if (key == 'delete') {
									var view = self._createElementViewFromElement($(this).parents('.ffb-element:first'));
									view.deleteElement();
								}
							}
							,

							events: {
								show : function (options) {
									this.closest('.ffb-element').addClass('action-toggle-context-menu-opened');
								}
							,
								hide : function (options) {
									this.closest('.ffb-element').removeClass('action-toggle-context-menu-opened');
								}
							}
							,

							items: items
						}
					}
				});

			});

		},


        /*----------------------------------------------------------*/
        /* INITIALIZE - constructor
        /*----------------------------------------------------------*/
        /**
         * First initialization
         */
        initialize: function() {
            this.vent = this._getVent();
            this.$el = $('.ffb-canvas');

			return;

            this.init();
            this.bindActions();
        },

        /*----------------------------------------------------------*/
        /* INIT
        /*----------------------------------------------------------*/
        /**
         * First call - after loading the builder, we need to initialise every js functions, connect JS things with the
         * canvas and all other stuff
         */
        init: function(){
            this.loadElementsData();
            this.connectElements( this.$el );
			this.vent.f.initTooltips();
			this.vent.f.initTooltips( $('.ffb-canvas__add-section-button-wrapper'));


			$('html').addClass('ffb-options-page');
        },

        refreshElementsPreview: function ( $elements ) {
            var self = this;

            if( $elements.hasClass('ffb-element' ) ) {
                self._createElementViewFromElement( $elements ).renderContentPreview();
            }
            $elements.find('.ffb-element').each(function(){
                self._createElementViewFromElement( $(this) ).renderContentPreview();
            });
        },

		saveAjax: function() {
			var shortcodesContent = this.convertToShortcodes( this.$el );
			var data = {};
			data.content = shortcodesContent;
			data.postId = $('#post_ID').val();
			data.colorLibrary = this.colorLibrary;

			var self = this;

			this._metaBoxAjax( 'saveAjax', data, function(response){
				frslib.messages.broadcast({'command' : 'refresh', 'post_id': $('#post_ID').val() })
				self.vent.f.addNotification('success', 'All Saved!');
			});
		},

	


        /*----------------------------------------------------------*/
        /* LOAD ELEMENTS DATA
        /*----------------------------------------------------------*/
        /**
         * load data about all builder elements and create backboneJS models from them, for better rendering and
         * everything next time
         * @param $elements
         */
        loadElementsData :function() {
            var self = this;
            this.elementModels = [];
            this.menuItems = null;
            this._metaBoxAjax( this.vent.ajax.getElementsData, {}, function( response ){
                var data = JSON.parse( response );

				/*----------------------------------------------------------*/
				/* MENU ITEMS
				/*----------------------------------------------------------*/
                // information about all menu items in the "Add" section
                self.menuItems = data.menuItems;

				/*----------------------------------------------------------*/
				/* ELEMENTS DATA
				/*----------------------------------------------------------*/
                var elementsData = data.elements;
                var key = null;
                for( key in elementsData ) {
                    var oneElement = elementsData[ key ];
                    var elementModel = new window.ffbuilder.ElementModel();

                    for( var attr in oneElement ) {
                        elementModel.set( attr, oneElement[attr]);
                    }

                    elementModel.set('optionsStructure', JSON.parse( elementModel.get('optionsStructure') ) );
                    elementModel.processFunctions();

                    self.elementModels[ key ] = elementModel;



                }

				/*----------------------------------------------------------*/
				/* BLOCKS DATA
				/*----------------------------------------------------------*/
                var blocksDataUnpacked = data.blocks;
				var blocksData = {};
				for( key in blocksDataUnpacked ) {
					blocksData[ key ] = JSON.parse(blocksDataUnpacked[ key ]);
				}

                // console.log(data.blocks_functions)

				var blocksCallbacksModel = Backbone.DeepModel.extend({
					render: function( blockName, query, params ) {
						return this.get(blockName)(query, params);
					}
				});
				self.vent.d.blocksCallbacks = new blocksCallbacksModel();

				$.each( data.blocks_functions, function(key, value){

					var f = null; // temporary function holder

					eval('f = ' + value );


					self.vent.d.blocksCallbacks.set(key, f);
				});


				/*----------------------------------------------------------*/
				/* COLOR LIBRARY
			 	/*----------------------------------------------------------*/
				self.colorLibrary = data.color_library;

				self.vent.d.blocksData = blocksData;

                self.vent.trigger(self.vent.a.elementsDataLoaded);
				
				/*----------------------------------------------------------*/
				/* PREDEFINED ELEMENTS
				/*----------------------------------------------------------*/
				self.predefinedElements = data.predefined_elements;
            });

            ;
        },



        /*----------------------------------------------------------*/
        /* writeCanvasToPostContentArea
        /*----------------------------------------------------------*/
        /**
         * Converts all our shortcodes to canvas and then write it
         * to post content area
         */
        writeCanvasToPostContentArea: function() {
            var canvasShortcodeNotation = this.convertToShortcodes( this.$el.children('.ffb-dropzone') );

            this._setTinyMCEContent( canvasShortcodeNotation );
        },




        /*----------------------------------------------------------*/
        /* convertToShortcodes
        /*----------------------------------------------------------*/
        /**
         * Convert given elements to ShortCodes notation
         * @param $elements
         */
        convertToShortcodes_data: '',
        convertToShortcodes_depth: 0,

        convertToShortcodes: function ( $data ) {
            this.convertToShortcodes_depth = 0;
            this.convertToShortcodes_data = '';
            if( $data.hasClass('ffb-canvas') ) {
				var $elements = $data.children('.ffb-dropzone').children('.ffb-element');

				var self = this;

				$elements.each(function(){
					self.convertToShortcodes_Element( $(this) );
				});
            } else if ($data.hasClass('ffb-dropzone') ) {
				var $elements = $data.children('.ffb-element');

				var self = this;

				$elements.each(function(){
					self.convertToShortcodes_Element( $(this) );
				});

            } else {
                var $elements = $data.children('.ffb-element');
                var self = this;

                $elements.each(function(){
                    self.convertToShortcodes_Element( $(this) );
                });
            }

            var toReturn = this.convertToShortcodes_data;
            this.convertToShortcodes_data = '';
            return toReturn;
        },

        convertToShortcodes_encodeAttribute: function( attribute ) {

            attribute = encodeURIComponent( attribute );

            attribute = attribute.split('%20').join(' ');


            return attribute;
        },

        convertToShortcodes_Element: function( $element ) {
            var self = this;

            var elementId = $element.attr('data-element-id');

            var elementModel = this._createElementViewFromElement($element );
            var elementData = elementModel.convertOptionsToShortcodes();


            // options, shortcodes
            var dataString = JSON.stringify( elementData.options );

            var data = this.convertToShortcodes_encodeAttribute( dataString );
            if( data == 'null' ) {
                data = '';
            }
            var dataAttr = 'data="' + data + '"';

            var uniqueID = $element.attr('data-unique-id');


            this.convertToShortcodes_data += '[ffb_' + elementId +'_' + this.convertToShortcodes_depth + ' unique_id="' + uniqueID + '" ' + dataAttr + ']';
                this.convertToShortcodes_data += elementData.shortcodes;
                $element.children('.ffb-dropzone').each(function(){
                    self.convertToShortcodes_Dropzone( $(this) );
                });

            this.convertToShortcodes_data += '[/ffb_' + elementId +'_' + this.convertToShortcodes_depth + ']';

        },

        convertToShortcodes_Dropzone: function( $dropzone ) {
            var self = this;
            this.convertToShortcodes_depth++;
            $dropzone.children('.ffb-element').each(function(){
                self.convertToShortcodes_Element( $(this) );
            });
            this.convertToShortcodes_depth--;
        },




        /*----------------------------------------------------------*/
        /* CONNECT ELEMENTS
        /*----------------------------------------------------------*/
        /**
         * function called on every new element, which wants to be added into the canvas - do some js hooks
         * @param $elements
         */
        connectElements: function( $elements ) {

            var $dropzones = $elements.find('.ffb-dropzone');

            if( $dropzones.size() > 0 ) {
                this.reInitSortableOnDropzones( $dropzones );
            }
        },

        reInitSortableOnDropzones: function( $dropzones)  {
            this.initSortableOnDropzones( $dropzones );
            // this.$el.find('.ffb-dropzone').sortable('refresh');
			// TODO potential problems with commenting this line
			$dropzones.sortable('refresh');
        },

        initSortableOnDropzones: function( $dropzones ) {
            var self = this;

            $dropzones.each(function(){
                var $this = $(this);
                var $element = $(this).parents('.ffb-element:first');
                var connectWith = '.ffb-dropzone';

                $(this).sortable({
					connectWith: connectWith,
					cursor: 'move',
					tolerance: 'pointer',

					cursorAt: { left: -5, top: -5 },

					placeholder: {
						element: function($currentItem ) {
							// var $placeholder = $currentItem.clone().html('').addClass('ui-sortable-placeholder').css('position','').css('width','');
							// $placeholder.attr( 'data-element-id', $currentItem.attr('data-element-id') );

                            var $placeholder = '<div class="ui-sortable-placeholder"></div>';

							return $placeholder;
					 	},

						update: function() {

						}
					},

					/**
					 * Calculate the blacklisted and whitelisted elements here like a boss
					 * @param event
					 * @param $element
					 * @returns {*}
					 */
					helper:  function(event, $element) {
						var elementId = $element.attr('data-element-id');
						var model = self.elementModels[ elementId ];

						var whitelistedParents = model.get('parentWhitelistedElement');

						var customDropzoneSelector = null;


						var selectors = [];
						var key = null;

						/**
						 * If we have only list of whitelisted parents, we dont need to search anything
						 */
						if( whitelistedParents.length > 0 ) {

							for( key in whitelistedParents ) {
								var oneParent = whitelistedParents[ key ];
								selectors.push( '.ffb-dropzone-' + oneParent );
							}
							customDropzoneSelector = selectors.join(', ');

						}
						/**
						 * If we dont have the list, we have to go trough all possible elements and find their black / white list
						 */
						else {
							for( key in self.elementModels ) {
								var oneModel  = self.elementModels[ key ];

								var whitelistedElements  =oneModel.get('dropzoneWhitelistedElements');
								var blacklistedElements  =oneModel.get('dropzoneBlacklistedElements');

								if( whitelistedElements.length > 0 && whitelistedElements.indexOf( elementId ) == -1 ) {
									selectors.push( '.ffb-dropzone-' + key );
								}

								if( blacklistedElements.length > 0 && blacklistedElements.indexOf( elementId ) != -1 ) {
									selectors.push( '.ffb-dropzone-' + key );
								}
							}

							if( selectors.length > 0 ) {
								customDropzoneSelector = '.ffb-dropzone:not(' + selectors.join(', ') + ')';
							}
						}

						if( customDropzoneSelector != null ) {
							$(this).sortable( 'option', 'connectWith', customDropzoneSelector);

							$(this).sortable('refresh');
							// $dropzones.sortable( "refresh" );
						}

						return $element;
					},

                   start: function (event, ui) {
                    $('body').addClass('ffb-canvas-drag-in-progress');
                    $(this).sortable('refresh'); // needed because when you drag a long element downwards, it does work very good. this helps recalculate everything.
                   },


				   stop: function (event, ui) {
                    $('body').removeClass('ffb-canvas-drag-in-progress');
					   self.vent.trigger(self.vent.a.canvasChanged);

					   self.vent.f.animateCanvasElement( ui.item, 'sortable-stop');
				   }
				});


            });
        },


        /*----------------------------------------------------------*/
        /* EVENTS
        /*----------------------------------------------------------*/
        /**
         * Generate our event class, which stores all event names as as "pseudo constants"
         * This class is basically backbone of our eventing system
         * @private
         */
        _getVent: function() {
            var self = this;
            var vent = _.extend({}, Backbone.Events);

            vent.ajax = {};
            vent.ajax.getElementsData = 'getElementsData';

			vent.o = {};
			vent.o.notificationManager = new window.ffbuilder.NotificationManager({ vent:vent });
			vent.o.elementData = {};
			

            vent.a = {};
            vent.a.canvasChanged = 'canvasChanged';
            vent.a.elementsDataLoaded = 'elementsDataLoaded';

			vent.d = {};
			vent.d.blocksData = {};
			vent.d.modalOpened = false;

            vent.f = {};

			vent.f.addNotification = function( type, text) {
				vent.o.notificationManager.addNotification( type, text );
			}

			vent.f.animateCanvasElement = function( $element, actionType ) {
				switch( actionType ) {
					case 'sortable-stop':

						$element.slideUp(0);
						$element.animateCSS('zoomIn');

						if ( $element.is('.ffb-element-column') ){
							$element.show(151);
						} else {
							$element.slideDown(151);
						}

						break;

					case 'inserted-new-element':

						$element.slideUp(0);

						$element.animateCSS('zoomIn');

						if ( $element.is('.ffb-element-column') ){
							$element.show(301);
						} else {
							$element.slideDown(301);
						}
						break;

					case 'element-options-changed':
							$element.delay(70).animate({opacity:0.2},150).animate({opacity:1},150);
						break;


					case 'element-pasted':
					case 'element-duplicated':

						$element.hide(0);
						if ( $element.is('.ffb-element-column') ){
							$element.show(301);
						} else {
							$element.slideDown(301);
						}


						break;
				}
			};

			vent.f.animateCanvas = function( type ) {
				// switch type:
			};

			vent.f.initTooltips = function( $element ) {
				if( $element == undefined ) {
					$element = $('.ffb-canvas');
				}

				return;

				$element.find('[data-ffb-tooltip]').each(function(){

					$(this).qtip({
						content: {
							attr: 'data-ffb-tooltip'
						},
						style: {
							tip: {
								corner: false
							},
							classes: 'ffb-tooltip'
						},
						position: {
							// target: 'mouse',
							my: 'bottom center',  // tooltip
							at: 'top center' // container
						},
						show: {
							delay: 0,
							// effect: false, // disable fading animation
						},
						hide: {
							effect: false, // disable fading animation
						}
					});
				});
			};

            vent.f.connectElement = function( $element ) {
				setTimeout(function(){
					self.connectElements( $element );
					self.refreshElementsPreview( $element );
					self.writeCanvasToPostContentArea();
					self.bindContextMenu();
				}, 20);
            };

			vent.f.canvasChanged = function() {
				vent.trigger( vent.a.canvasChanged );
			}

            vent.f.modalShow = function(){
				if( vent.d.modalOpened ) {
					return;
				}

				vent.d.modalOpened = true;
                $.scrollLock();
				$('html').addClass('ffb-modal-opened');
                $('.ffb-modal-origin').css('display', 'block');
            };

            vent.f.modalHide = function() {

				if( !vent.d.modalOpened ) {
					return;
				}

				vent.d.modalOpened = false;

                $.scrollLock();
				$('html').removeClass('ffb-modal-opened');
                $('.ffb-modal-origin').css('display','none');
            };


			vent.f.modalSetPreviewImage = function ( previewImageUrl ) {
				var $modal = $('.ffb-modal-origin');

				var $previewImage = $modal.find('.ffb-modal__header-icon-preview-content img');

				$previewImage.attr('src', previewImageUrl );
			}

			vent.f.modalSetTitle = function( title ) {
				var $modal = $('.ffb-modal-origin');
				var $title = $modal.find('.ffb-modal__name:first').find('span');

				$title.html( title );
			};

            vent.f.modalSetContent = function( content ) {
                // $('.ffb-modal-origin').find('.ffb-modal__body').html( content);

				var $modal = $('.ffb-modal-origin');
				vent.trigger( vent.a.modalContentChanged, $modal, content );
				frslib.callbacks.doCallback('ffbuilder-modalContentChanged', $modal, content );
				$modal.find('.ffb-modal__body').html( content);
            };

			vent.f.modalCleanContent = function() {
				var $modal = $('.ffb-modal-origin');
				vent.trigger( vent.a.modalContentCleaned, $modal, content );
				frslib.callbacks.doCallback('ffbuilder-modalContentCleaned', $modal, content );
				$modal.find('.ffb-modal__body').html('');
			};



            return vent;
        },

        _setTinyMCEContent: function( content ) {
            var activeEditor = tinyMCE.get(wpActiveEditor);

            if( activeEditor ==undefined ) {
                $('.wp-editor-area').val( content );
            } else {
                activeEditor.setContent(content);
            }

                ///wp-editor-area
            //console.log( wpActiveEditor, tinyMCE,  tinyMCE.get(wpActiveEditor) );
            //tinyMCE.get(wpActiveEditor).setContent(content);
        },

        /*----------------------------------------------------------*/
        /* metaBoxAjax
        /*----------------------------------------------------------*/
        /**
         * Ajax request to our meta box "Theme Builder"
         * @param action
         * @param data
         * @param callback
         * @private
         */
        _metaBoxAjax: function( action, data, callback ) {
            data.action = action;
            var specification = {};
			specification.metaboxClass = 'ffMetaBoxThemeBuilder';
            frslib.ajax.frameworkRequest( 'ffMetaBoxManager', specification, data, function( response ) {
                callback( response );
            });
        },

        _createElementViewFromElement: function( $element ) {

			if( $element.hasClass('ffb-canvas') ) {
				var elementId = $element.attr('data-element-id');
			} else {
				if( !$element.hasClass('ffb-element') && $element.attr('data-element-id') != '' ) {
					$element = $element.parents('.ffb-element:first');
				}
				var elementId = $element.attr('data-element-id');
			}

            var view = this._createElementViewFromId( elementId );
            view.$el = $element;

            return view;
        },

        _createElementViewFromId: function( elementId ) {
            var view = new window.ffbuilder.ElementView();
            view.elementPickerView = this.elementPickerView;
            view.model = this._createElementModelFromId( elementId );
            view.vent = this.vent;
            view.elementModels = this.elementModels;
			view.currentElementId = elementId;

            return view;
        },

        _createElementModelFromId: function( elementId ) {
            var model = this.elementModels[ elementId ];

			var modelCopy = {};
			if( model != undefined ) {
				modelCopy = model.clone();
			}

            modelCopy.vent = this.vent;

            return modelCopy;
        },

    });


    $(document).ready(function(){
        window.ffbuilder.appInstance = new window.ffbuilder.App();
    });

    // HOVER OVER FFB ELEMENTS STYLE - START

    

    // DO NOT DELETE!
    

    // HOVER OVER FFB ELEMENTS STYLE - END

    // ADD SECTION BUTTON - START


    $.fn.extend({
        animateCSS: function (animationName) {
            var animationEnd = 'webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend';
            $(this).addClass('animated ' + animationName).one(animationEnd, function() {
                $(this).removeClass('animated ' + animationName);
            });
        }
    });
/*

    $(document).on('click', '.action-add-section:not(.action-add-section-triggered)', function(e){
        e.preventDefault();


		var $this = $(this);

		if( $this.hasClass('currently-animating') ) {
			return false;
		}

		$(this).addClass('currently-animating');

        $(this).find('.ffb-canvas__add-section-button').fadeOut(100, function(){
            $(this).closest('.ffb-canvas__add-section-button-wrapper').addClass('action-add-section-triggered');
            $('.ffb-canvas__add-section-item').animateCSS('fadeInDown');
        });

		// var endCounter = 0;
		$(this).find('.ffb-canvas__add-section-item').last().one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function(){

			// endCounter++;

			$this.removeClass('currently-animating');


		});
    });

    $(document).on('click', '.ffb-canvas__add-section-item, .ffb-canvas__add-section-item__cancel, .action-add-section.action-add-section-triggered', function(e){
        e.preventDefault();

        var $thisSection = $(this).closest('.ffb-canvas__add-section-button-wrapper');

		if( $thisSection.hasClass('currently-animating') ) {
			return false;
		}

		$thisSection.addClass('currently-animating');

        console.log($thisSection);

        // $thisSection.addClass('anim-back');

        $thisSection.find('.ffb-canvas__add-section-item').animateCSS('fadeOutUp');
        $thisSection.find('.ffb-canvas__add-section-item').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function(){

            $(this).css('opacity', '0');


        });
        $thisSection.find('.ffb-canvas__add-section-item:last-child').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function(){

            $thisSection.find('.ffb-canvas__add-section-item').css('opacity','');
            $thisSection.removeClass('action-add-section-triggered');
            $thisSection.find('.ffb-canvas__add-section-button').fadeIn(150);

			$thisSection.removeClass('currently-animating');
            // $thisSection.removeClass('anim-back');
        });

    });
*/
    // ADD SECTION BUTTON - END

    // COLLAPSE ELEMENT TOGGLE - START

    $(document).on('click', '.action-toggle-collapse', function(e){
        e.preventDefault();

        var $thisEl = $(this).closest('.ffb-element');

        if ( $thisEl.is('.ffb-element-dropzone-yes') ){
            $thisEl.find('.ffb-dropzone').toggle();          
        } else {
            $thisEl.find('.ffb-element-preview').toggle();
        }

        $(this).toggleClass('action-is-collapsed');
        $thisEl.toggleClass('ffb-element-is-collapsed');
    });

    // COLLAPSE ELEMENT TOGGLE - END

    // AUTORESIZE CODE TEXTAREAS - START

        // @todo TOMAS PRESUNOUT
        // @todo TOMAS PRESUNOUT
        // @todo TOMAS PRESUNOUT
        // @todo TOMAS PRESUNOUT
        // @todo TOMAS PRESUNOUT
        // @todo TOMAS PRESUNOUT
        // @todo TOMAS PRESUNOUT

        $(document).ready(function(){
            $(".ffb-options-textarea-code-wrapper textarea").on('keydown keyup', function(){
                this.style.height = "1px";
                this.style.height = (this.scrollHeight) + "px"; 
            });
        });

    // AUTORESIZE CODE TEXTAREAS - END

    // TOOLTIP - START




    // TOOLTIP - END


    // REPEATABLE SLIDE TOGGLE - START

    // $(document).on('click', '.ff-repeatable-header', function(){
    //     if( $(this).parent().hasClass('.ff-repeatable-item-closed') ){
    //         $(this).parent().removeClass('.ff-repeatable-item-closed').addClass('.ff-repeatable-item-opened');
    //     } else {
    //         $(this).parent().removeClass('.ff-repeatable-item-opened').addClass('.ff-repeatable-item-closed');
    //     }
    // });

    // REPEATABLE SLIDE TOGGLE - END


})(jQuery);









