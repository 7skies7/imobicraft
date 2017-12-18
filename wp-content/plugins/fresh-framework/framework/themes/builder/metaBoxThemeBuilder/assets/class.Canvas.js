(function($){
	frslib.provide('window.ffbuilder');

	window.ffbuilder.Canvas = Backbone.View.extend({
		_vent : null,

		_$hoveredEl: [],

		_convertToShortcodes_data: '',

		_convertToShortcodes_depth: 0,

		_bindActions: function() {
			var self = this;
			$('.ffb-save-ajax').click(function(e ){
				e.stopPropagation();
				self._vent.f.saveAjax();
				return false;
			});

			$('.ffb-canvas__add-section-item__element').click(function(e){
				self._insertNewElement( $('.ffb-canvas'), 'insert-inside-bottom' );
			});

			$('.ffb-canvas__add-section-item__library').click(function(e){
				self._insertNewElement( $('.ffb-canvas'), 'insert-inside-bottom', true );
			});

			$('.ffb-canvas__add-section-item__grid').click(function(e){
				var numberOfColumns = $(this).attr('data-number-of-columns');

				self._insertNewElement( $('.ffb-canvas'), 'insert-inside-bottom', true, 'section_'+numberOfColumns+'_columns')
			});
			// predefined_elements
			// section_1_columns
			/*----------------------------------------------------------*/
			/* MAXIMALIZE / MINIMALIZE BUILDER FEATURE
			/*----------------------------------------------------------*/
			$('.ffb-builder-toolbar-max-builder-btn, .ffb-builder-toolbar-min-builder-btn').on('click', function(){
				$('.ffb-builder:first').toggleClass('ffb-builder--max');
				$.scrollLock();
			});

			$('.ffb-builder-toolbar-cm-menu--action_options').freshfaceContextMenu({menuItems:[
				{ name: 'Copy', value:'copy'},
				{ name: 'Paste', value:'paste'},
				{ name: 'Delete', value:'delete'},
			]}, function(result) { self._contextMenuActions( result ); } );

			$('.ffb-builder-toolbar-cm-menu--action_shortcuts').on('click', function(){
				$('.ffb-builder-shortcuts-popup').show();
				$.freshfaceScrollLock();
			});

			$('.ffb-builder-shortcuts-popup-action-close').on('click', function(e){
				e.preventDefault();

				if(e.target != this) return;
				e.stopPropagation();

				$('.ffb-builder-shortcuts-popup').hide();
				$.freshfaceScrollLock();
			});

			$('.ffb-canvas__add-section-items').find('[data-ffb-tooltip]').freshfaceTooltip();

			this._bindShortcuts();

			// duplicateElement
		},

		_bindShortcuts: function() {
			var self = this;
			// edit
			$(document).on('keydown', null, 'e', function(){
				var $el = _.last(self._$hoveredEl);
				if( $el == undefined  ){
					return;
				}

				$el.find('.action-edit-element:first').trigger('click');
			});

			// duplicate
			$(document).on('keydown', null, 'd', function(){
				var $el = _.last(self._$hoveredEl);
				if( $el == undefined  ){
					return;
				}

				self.duplicateElement( $el );
			});

			// duplicate
			$(document).on('keydown', null, 'r', function(){
				var $el = _.last(self._$hoveredEl);
				if( $el == undefined  ){
					return;
				}

				self.deleteElement( $el );
			});

			// copy
			$(document).on('keydown', null, 'c', function(){
				var $el = _.last(self._$hoveredEl);
				if( $el == undefined  ){
					return;
					
				}
				self._copyElement( $el );
			});

			$(document).on('keydown', null, 'v', function(){
				var $el = _.last(self._$hoveredEl);
				if( $el == undefined  ){
					return;

				}
				self._pasteElement( $el, 'paste-after');
			});

			// save
			$(document).on('keydown', null, 's', function(){
				var $el = _.last(self._$hoveredEl);
				if( $el == undefined  ){
					return;

				}
				
				self._vent.f.saveAjax();
				return false;
			});

			// disable / enable
			$(document).on('keydown', null, 't', function(){
				var $el = _.last(self._$hoveredEl);
				if( $el == undefined  ){
					return;

				}

				self.disableEnableElement( $el );
				return false;
			});

			// insert new element
			$(document).on('keydown', null, 'a', function(){
				var $el = _.last(self._$hoveredEl);
				if( $el == undefined  ){
					return;

				}

				var insertWay = $el.hasClass('ffb-element-dropzone-yes') ? 'insert-inside-bottom' : 'insert-after';

				self._insertNewElement( $el, insertWay );
				return false;
			});





		},

		initialize: function( options){
			this._vent = options.vent;
			this._bindActions();
			this.$el = $('.ffb-canvas');
			this.bindEventsOnElements( this.$el );


			this.listenTo( this._vent, this._vent.a.dataLoaded, this._actionDataLoaded );
		},

/**********************************************************************************************************************/
/* CONVERTING TO SHORTCODES
/**********************************************************************************************************************/
		_contextMenuActions: function( action ) {
			var self = this;
			switch( action ) {
				case 'copy':
					// var canvasValue = this.convertToShortcodes();
					var canvasValue = this.$el.children('.ffb-dropzone-canvas').html();
					frslib.clipboard.copyTo( canvasValue );
					$.freshfaceAlertBox('Content has been copied to clipboard');
					break;
				case 'paste':
					// $.freshfaceConfirmBox('Do you really want to paste the content? You will loose all items in canvas.', function( result ) {
					// 	if( result == false ) {
					// 		return false;
					// 	}
						var content = frslib.clipboard.pasteFrom();
						// $.freshfaceInputBox({confirmText:'Paste the content here'}, function( content ) {
							self.$el.children('.ffb-dropzone-canvas').append( content );
							self.bindEventsOnElements( self.$el );
							self._refreshElementsPreview( self.$el );
							self._vent.f.canvasChanged();
						// });

						// console.log( value );
					// });
					break;
				case 'delete':
					$.freshfaceConfirmBox('Do you really want to delete the content? There is no way back then.', function( result ) {
						if( result == false ) {
							return false;
						}
						self.$el.children('.ffb-dropzone-canvas').children().hide(500, function(){
							$(this).remove();
							self._vent.f.canvasChanged();
						});
					});
					break;
			}
		},


		/**
		 * Convert the canvas to string of shortcodes compatible with our builder
		 * @param $data
		 * @returns {string}
		 */
		convertToShortcodes: function( $data ) {
			if( $data == undefined ) {
				$data = this.$el;
			}
			this._convertToShortcodes_data = '';
			this._convertToShortcodes_depth = 0;

			var self = this;
			var $elements;
			// we are converting canvas
			if( $data.hasClass('ffb-canvas') ) {
				$elements = $data.children('.ffb-dropzone').children('.ffb-element');
			}
			// we are converting some specific dropzone
			else if( $data.hasClass('ffb-dropzone') ) {
				$elements = $data.children('.ffb-element');
			}
			// we are converting the rest
			else {
				$elements = $data.children('.ffb-element');
			}

			$elements.each(function(){
				self._convertToShortcodes_Element( $(this) );
			});

			var toReturn = this._convertToShortcodes_data;
			this._convertToShortcodes_depth = '';
			return toReturn;

		},

		_convertToShortcodes_Dropzone: function( $dropzone ) {
			var self = this;
			this._convertToShortcodes_depth++;
			$dropzone.children('.ffb-element').each(function(){
				self._convertToShortcodes_Element( $(this) );
			});
			this._convertToShortcodes_depth--;
		},

		_convertToShortcodes_encodeAttribute: function( attribute ) {

			attribute = encodeURIComponent( attribute );

			attribute = attribute.split('%20').join(' ');


			return attribute;
		},

		_convertToShortcodes_Element: function( $element ) {
			var self = this;
			var elementView =this._vent.f.getElementViewFromSelector( $element );
			var elementId = elementView.getElementId();
			var dataForShortcodes = elementView.getDataForShortcodes();

			// normal data part
			var dataJSON = JSON.stringify(dataForShortcodes.dataWithoutPrintInContentParam);
			var dataJSONEscaped = this._convertToShortcodes_encodeAttribute( dataJSON );

			// shortcodeParams
			var shortcodeContentParams = '';
			for( var i in dataForShortcodes.printInContent ) {
				var oneParam = dataForShortcodes.printInContent[i];

				shortcodeContentParams += '[ffb_param route="' + oneParam.name +'"]' + oneParam.value + '[/ffb_param]'
			}


			var dataAttr = 'data="' + dataJSONEscaped + '"';
			var uniqueID = elementView.getUniqueId();

			this._convertToShortcodes_data += '[ffb_' + elementId +'_' + this._convertToShortcodes_depth + ' unique_id="' + uniqueID + '" ' + dataAttr + ']';
			this._convertToShortcodes_data += shortcodeContentParams;
			$element.children('.ffb-dropzone').each(function(){
				self._convertToShortcodes_Dropzone( $(this) );
			});

			this._convertToShortcodes_data += '[/ffb_' + elementId +'_' + this._convertToShortcodes_depth + ']';

		},


/**********************************************************************************************************************/
/* BINDING ELEMENTS
/**********************************************************************************************************************/
		bindEventsOnElements: function( $elements ) {
			this._bindAddNewElement( $elements );
			this._bindEditElement( $elements );
			this._bindContextMenu( $elements );
			this._bindTextColorMenu( $elements );
			this._bindHover( $elements );
			this._bindCollapseToggle( $elements );
			this._bindTooltips( $elements );
			var $dropzones = $elements.find('.ffb-dropzone');
			this._bindSortableOnDropzones( $dropzones );
		},

		_bindTooltips: function ( $elements ) {
			$elements.find('[data-ffb-tooltip]').freshfaceTooltip();
		},

		_bindCollapseToggle: function( $elements ) {

			$elements.find('.action-toggle-collapse').on('click', function(e){
				e.preventDefault();

				var $element = $(this).parents('.ffb-element:first');

				if( $element.hasClass('ffb-element-dropzone-yes') ) {
					$element.find('.ffb-dropzone:first').toggle();
				} else {
					$element.find('.ffb-element-preview:first').toggle();
				}

				$(this).toggleClass('action-is-collapsed');
				$element.toggleClass('ffb-element-is-collapsed');
			});
		},

		_bindHover: function( $elements ) {
			var self = this;
			$elements.find('.ffb-element').addBack('.ffb-element').each(function(){
				var $el = $(this);


				$el.on('mouseover', function(e){
					var $hoveredElement = self.$el.find('.ffb-element-is-hovered')
					$hoveredElement.removeClass('ffb-element-is-hovered');

					// setTimeout( function(){
					$el.addClass('ffb-element-is-hovered');

					self._$hoveredEl.push($el);
					// },5);
					e.stopPropagation();
				});

				$el.on('mouseout', function(e){


					if( $(e.toElement).hasClass('fftip-overlay') ) {
						return;
					}

					self._$hoveredEl.pop();

					$el.removeClass('ffb-element-is-hovered');
				});
			});

		},

		_bindTextColorMenu: function( $elements ) {
			var self = this;
			$elements.find('.action-text-color').freshfaceContextMenu({menuItems:function( $element ){
				var $parent = $element.parents('.ffb-element:first');
				var elementView = self._vent.f.getElementViewFromSelector( $parent );

				var defaultColor = elementView.getDefaultTextColor();
				var selectedColor = elementView.getCurrentTextColor();

				var colorTypes = ['inherit', 'light', 'dark'];

				var contextMenu = [];

				var currentItem = {
					name: 'This',
					value: 'current-item',
					childs: []
				};

				for( var i in colorTypes ) {
					var color = colorTypes[ i ];

					var colorItem = {};
					var colorName = color.toLowerCase().replace(/\b[a-z]/g, function(letter) {
						return letter.toUpperCase();
					});
					colorItem.name = colorName;
					colorItem.value = color;

					if( color == defaultColor ) {
						colorItem.name += ' (Default)';
					}

					if( color == selectedColor ) {
						colorItem.active = true;
					}
					contextMenu.push( colorItem );
				}

				if( $parent.find('.ffb-dropzone').size() == 0  ) {
					// return currentItem.childs;
					return contextMenu;
				}

				var forceChilds = {
					name: 'Inner Elements',
					value: 'force-to-childs',
					childs: [],
				}




				for( var i in colorTypes ) {
					color = colorTypes[ i ];

					var colorItem = {};
					var colorName = color.toLowerCase().replace(/\b[a-z]/g, function(letter) {
						return letter.toUpperCase();
					});
					colorItem.name = colorName;
					colorItem.value = 'force-to-child-' + color;

					forceChilds.childs.push( colorItem );
				}

				// contextMenu.push( currentItem );
				contextMenu.push( forceChilds );


				// var addNew = {
				// 	name: 'Add',
				// 	value: 'add-new',
				//	childs: [
						// { name : 'Above', value: 'insert-before'},
					// 	{ name : 'Below', value: 'insert-after'}
					// ]
				// };

				return contextMenu;
			}}, function(action, $colorButton ){
				var $parent = $colorButton.parents('.ffb-element:first');

				if( action.indexOf('force-to-child-') != -1 ) {
					var color = action.replace('force-to-child-','');
					$parent.find('.ffb-element').each(function(){
						var elementView = self._vent.f.getElementViewFromSelector( $(this) );
						elementView.setCurrentTextColor( color );
					});
				} else {
					var elementView = self._vent.f.getElementViewFromSelector( $parent );
					elementView.setCurrentTextColor( action );
				}



			});
		},

		/*----------------------------------------------------------*/
		/* CONTEXT MENU
		/*----------------------------------------------------------*/
		_getContextMenuObject: function( hasDropzone, elementView ) {
			var contextMenu = [];

			var addNew = {
				name: 'Add',
				value: 'add-new',
				childs: [
					{ name : 'Above', value: 'insert-before'},
					{ name : 'Below', value: 'insert-after'}
				]
			};
			if( hasDropzone ) {
				addNew.childs.push( { name : 'Inside Top<div class="ff-modal-menu-divider"></div>', value: 'insert-inside-top'} );
				addNew.childs.push( { name : 'Inside Bottom', value: 'insert-inside-bottom'} );
			}
			contextMenu.push( addNew );
			contextMenu.push( { name: 'Duplicate<div class="ff-modal-menu-divider"></div>', value: 'duplicate' } );
			contextMenu.push( { name: 'Copy', value: 'copy' } );

			var paste = {
				name: 'Paste',
				value: 'paste',
				childs: [
					{ name : 'Above', value: 'paste-before'},
					{ name : 'Below', value: 'paste-after'}
				]
			};
			if( hasDropzone ) {
				paste.childs.push( { name : 'Inside Top<div class="ff-modal-menu-divider"></div>', value: 'paste-inside-top'} );
				paste.childs.push( { name : 'Inside Bottom', value: 'paste-inside-bottom'} );
			}
			contextMenu.push( paste );

			if( elementView.isElementDisabled() ) {
				contextMenu.push( { name: 'Enable<div class="ff-modal-menu-divider"></div>', value: 'disable-enable' } );
			} else {
				contextMenu.push( { name: 'Disable<div class="ff-modal-menu-divider"></div>', value: 'disable-enable' } );
			}

			contextMenu.push( { name: 'Delete', value: 'delete' } );

			return contextMenu;

		},

		/*----------------------------------------------------------*/
		/* CONTEXT MENU
	 	/*----------------------------------------------------------*/
		_bindContextMenu: function( $elements ) {
			var self = this;

			var openContextMenuOnElement = function( $element ) {
				// var $element = $(this).parents('.ffb-element:first');
				var elementView = self._vent.f.getElementViewFromSelector( $element );

				var hasDropzone = !$(this).hasClass('action-toggle-context-menu-no-dropzone');
				var modal = new frslib.options2.modal();

				var contextMenuItems = self._getContextMenuObject( hasDropzone, elementView );
				modal.printMenu( contextMenuItems, function( action ){
					switch( action ) {
						case 'delete' :
							self.deleteElement( $element );
							break;

						case 'duplicate':
							self.duplicateElement( $element );
							break;

						case 'disable-enable':
							self.disableEnableElement( $element );
							break;

						case 'copy':
							self._copyElement( $element );
							break;

						case 'paste-inside-top':
						case 'paste-inside-bottom':
						case 'paste-before':
						case 'paste-after':
							self._pasteElement( $element, action);
							break;

						case 'insert-inside-top':
						case 'insert-inside-bottom':
						case 'insert-before':
						case 'insert-after':
							self._insertNewElement( $element, action );
							break;
					}

				});
			}

			$elements.find('.action-toggle-context-menu').click(function(e){
				e.stopPropagation();
				openContextMenuOnElement( $(this).parents('.ffb-element:first') );
			});

			$elements.find('.ffb-element').addBack('.ffb-element').contextmenu(function(e){
				e.stopPropagation();
				openContextMenuOnElement( $(this) );
				return false;

			});
		},

		_copyElement: function( $element ) {
			var elementHtml = $element.prop('outerHTML');
			$element.animate({opacity:0.7},100).animate({opacity:1}, 100);
			frslib.clipboard.copyTo( elementHtml );
			this._vent.f.elementCopied();
		},

		_pasteElement: function( $element, action ) {
			var newElement = frslib.clipboard.pasteFrom();
			var $newElement = $(newElement);
			var newElementView = this._vent.f.getElementViewFromSelector( $newElement );
			$newElement.css('display', 'none');

			switch( action ) {
				case 'paste-inside-top':
					$element.find('.ffb-dropzone:first').prepend( $newElement );
					break;

				case 'paste-inside-bottom':
					$element.find('.ffb-dropzone:first').append( $newElement );
					break;

				case 'paste-before':
					$element.before( $newElement );
					break;

				case 'paste-after':
					$element.after( $newElement );
					break;
			}
			newElementView.makeElementUnique();

			$newElement.slideDown(300);

			this.bindEventsOnElements( $newElement );
			this._refreshElementsPreview( $newElement );
			this._vent.f.elementPasted();
			this._vent.f.canvasChanged();
		},


		_bindAddNewElement: function( $elements ) {
			var self = this;
			$elements.find('.action-add-element').click(function(e){
				e.stopPropagation();
				var $element = $(this).parents('.ffb-element:first');
				self._insertNewElement( $element, 'insert-inside-bottom');
			});

			$elements.find('.ffb-dropzone').click(function( e ){
				e.stopPropagation();
				if( $(this).children().size() > 0 ) {
					return false;
				} else {
					var $element = $(this).parents('.ffb-element:first');
					self._insertNewElement( $element, 'insert-inside-bottom');
				}
			});
		},

		_insertNewElement: function( $elementWhichTriggeredAction, position, triggerSectionTab, predefinedElementName ) {
			var $element = $elementWhichTriggeredAction;
			if( position == 'insert-before' || position == 'insert-after') {
				$element = $elementWhichTriggeredAction.parents('.ffb-element:first');

				if( $element.size() == 0 ) {
					$element = $elementWhichTriggeredAction.parents('.ffb-canvas');
				}
			}



			var self = this;
			this._vent.f.addElement( $element, function(type, data ){
				if( type == 'element' ) {
					var elementView = data;
					var $newElement = elementView.getNewElementHtml();

					$newElement.css('display', 'none');
					switch( position ) {
						case 'insert-before':
							$elementWhichTriggeredAction.before( $newElement );
							break;

						case 'insert-after':
							$elementWhichTriggeredAction.after( $newElement );
							break;

						case 'insert-inside-top':
							$element.find('.ffb-dropzone:first').prepend( $newElement );
							break;

						case 'insert-inside-bottom':
							$element.find('.ffb-dropzone:first').append( $newElement );
							break;
					}
					self.bindEventsOnElements( $newElement );
					self._refreshElementsPreview( $newElement );

					if( $newElement.attr('data-element-id') == 'column') {
						$newElement.show(300);
					} else {
						$newElement.slideDown(300);
					}
					self._vent.f.canvasChanged();
				} else if( type =='section' ) {
					var sectionDataWithoutContent = data;

					var $sectionTemporaryHolder = self._insertNewElement_getSectionTemporaryHolder();

					$('.ffb-canvas .ffb-dropzone:first').append( $sectionTemporaryHolder );

					self._vent.f.getSectionContentFromData( sectionDataWithoutContent, function( data){
						var $newSection = $(data);
						$sectionTemporaryHolder.after( $newSection );
						// $sectionTemporaryHolder.remove();

						self.bindEventsOnElements( $newSection );
						self._refreshElementsPreview( $newSection );

						$sectionTemporaryHolder.hide(500).remove();
						self._vent.f.canvasChanged();
					});
				} else if( type == 'predefined_section' ) {
					var $newSection = $(data);
					$newSection.hide();
					$('.ffb-canvas .ffb-dropzone:first').append( $newSection );
					// $sectionTemporaryHolder.remove();

					self.bindEventsOnElements( $newSection );
					var newSectionView = self._vent.f.getElementViewFromSelector( $newSection );
					newSectionView.makeElementUnique();
					self._refreshElementsPreview( $newSection );

					$newSection.show(500);


					// makeElementUnique
					// $sectionTemporaryHolder.hide(500).remove();
					self._vent.f.canvasChanged();
				}

			}, triggerSectionTab, predefinedElementName);
		},

		_insertNewElement_getSectionTemporaryHolder: function() {
			var html = '';
			html += '<div class="ffb-section-temporary-loader">';
				html += '<span class="ffb-spinner spinner is-active"></span>';
			html += '</div>';

			return $(html);
		},

		disableEnableElement: function( $element ) {
			var elementView = this._vent.f.getElementViewFromSelector( $element );
			elementView.setDisableElement('switch');
			this._vent.f.canvasChanged();
		},

		duplicateElement: function( $element ) {
			var elementView = this._vent.f.getElementViewFromSelector( $element );
			var $duplicatedElement = $element.clone();
			$duplicatedElement.removeClass('ffb-element-is-hovered');
			elementView.makeElementUnique( $duplicatedElement );
			$duplicatedElement.css('display', 'none');
			$element.after( $duplicatedElement);
			this.bindEventsOnElements( $duplicatedElement );
			this._refreshElementsPreview( $duplicatedElement );
			this._vent.f.canvasChanged();

			$duplicatedElement.slideDown(300);
		},

		deleteElement:function( $element ) {
			var self = this;


			var modal = new frslib.options2.modal();

			modal.printConfirmBox('Are you sure you want to delete it? ', function( result ){
				if( result == false ) {return; }
				var removeElement = function() {
					$element.remove();
					self._vent.f.canvasChanged();

				};
				if( $element.attr('data-element-id') == 'column') {
					$element.hide(300, removeElement);
				} else {
					$element.slideUp( 300, removeElement);
				}
			});
		},


		_actionDataLoaded: function() {
			this._refreshElementsPreview( this.$el );
			$('html').addClass('ffb-builder--loaded');
		},

		_refreshElementsPreview: function( $elements ) {
			var self = this;
			$elements.find('.ffb-element').addBack('.ffb-element').each(function() {
				var elementView = self._vent.f.getElementViewFromSelector( $(this) );
				elementView.renderElementPreview();
			});
		},

		_bindEditElement: function( $elements ) {
			var self = this;

			var editElement = function( $element ) {
				$.freshfaceWait();


				setTimeout(function(){
					self._vent.f.editElement( $element );
				},30);
			};

			$elements.find('.action-edit-element, .ffb-header-name').click(function(e){
				e.stopPropagation();

				var $element = $(this).parents('.ffb-element:first');
				editElement( $element );
			});

			$elements.find('.ffb-header').click(function(e){
				var $target = $(e.target);

				if(!( $target.hasClass('action-edit-element') || $target.hasClass('ffb-header') ) ) {
					return false;
				}
				e.stopPropagation();

				var $element = $(this).parents('.ffb-element:first');
				editElement( $element );
			});


		},

		_bindSortableOnDropzones: function( $dropzones ) {
			var self = this;

			$dropzones.each(function(){
				$(this).sortable({
					/**
					 * General Options
					 */
					connectWith: '.ffb-dropzone',
					cursor: 'move',
					tolerance: 'pointer',
					cursorAt: { left:-5, top:-5 },
                    delay: 100,

					/**
					 * Placeholding
					 */
					placeholder: {
						element: function( $currentItem ) {
							return '<div class="ui-sortable-placeholder"></div>';
						},
						update: function() {

						}
					},

					/**
					 * Calculating allowed dropzones
					 */
					helper: function( event, $element ) {
						var elementView = self._vent.f.getElementViewFromSelector( $element );
						var customDropzoneSelector = elementView.getCustomDropzoneSelector();
						if( customDropzoneSelector != null ) { 
							$(this).sortable( 'option', 'connectWith', customDropzoneSelector);
							$(this).sortable('refresh');
						}

						return $element;

					},

					start: function( event, ui ) {
						$('body').addClass('ffb-canvas-drag-in-progress');
						$(this).sortable('refresh'); // needed because when you drag a long element downwards, it does work very good. this helps recalculate everything.
					},

					stop: function( event, ui ) {
						$('body').removeClass('ffb-canvas-drag-in-progress');
						setTimeout(function(){ self._vent.f.canvasChanged(); }, 10);
					},
				});

			});
		},

		// _bindEventsOnOneElement: function( $element ) {
		//
		// 	$element.find('.action-edit-element:first').click(function(){
		//
		//
		// 	});
		// },
	});


})(jQuery);


















