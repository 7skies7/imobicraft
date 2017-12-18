(function($){
	frslib.provide('window.ffbuilder');

	window.ffbuilder.ElementView = Backbone.View.extend({
		_model : null,

		_elementModels: null,

		_blockData: null,

		_blockCallbacks: null,

		_vent: null,

		_currentElementId: null,

		_optionsManager : null,

		_menuItems: null,

		_globalStyles: null,

		// _colorLibrary: null,

		_lastGeneratedId: null,

		initialize: function( options ){
			this._model = options.model;
			this._vent = options.vent;
			this._elementModels = options.elementModels;
			this._currentElementId = options.currentElementId;
			this._blockData = options.blockData;
			this._blockCallbacks = options.blockCallbacks;
			this._menuItems = options.menuItems;
			this._globalStyles = options.globalStyles;
		},

		_getOptionsManager: function() {
			if( this._optionsManager == null ) {
				var manager = new frslib.options2.managerModal();
				this._optionsManager = manager;

				manager.setStructure( this._model.get('optionsStructure') );
				manager.setData( this.getOptionsData() );
				manager.setBlocks( this._blockData );
			}

			return this._optionsManager;
		},

		getOptionsForm: function() {
			// console.log( 'MRDAT');
			return this._getOptionsManager()
				.setMetaData('element-unique-id', this.getUniqueId() )
				.setMetaData('element-id', this.getElementId() )
				.render();
		},


		getSystemInfoFromForm: function( name, defaultValue ) {
			var $form = this._getOptionsManager().$el;
			var valueJSON = $form.find('.ff-opt-ffsys-info').val();
			var value = JSON.parse( valueJSON );

			// console.log( value[name] );

			if( name == undefined ) {
				return value;
			} else {
				if( value[name] == undefined ) {
					return defaultValue;
				} else {
					return value[name];
				}
			}


		},


		setSystemInfoToForm: function(name, value) {
			var currentSystemInfo = this.getSystemInfoFromForm();
			currentSystemInfo[name] = value;
			var currentSystemInfoJSON = JSON.stringify( currentSystemInfo );

			var $form = this._getOptionsManager().$el;
			$form.find('.ff-opt-ffsys-info').val( currentSystemInfoJSON );

			if( name == 'global-style' ) {
				this._getOptionsManager().markGlobalOptionsTabs();
			}
		},


		getCurrentGlobalStyle: function() {
			var currentElementId = this._currentElementId;

			var globalStyle = {};
			globalStyle.value = this.getSystemInfoFromForm('global-style', 0);



			if( globalStyle.value == 0 ) {
				globalStyle.name = this._globalStyles.get(currentElementId + ' ' + globalStyle.value + ' name', 'Default');
			} else {
				globalStyle.name = this._globalStyles.get(currentElementId + ' ' + globalStyle.value + ' name', null)

				// console.log( currentElementId + ' ' + globalStyle.value + ' name' );

				if( globalStyle.name == null ) {
					globalStyle.value = 0;
					globalStyle.name = 'Default';
				}
			}

			return globalStyle;
		},

/**********************************************************************************************************************/
/* GLOBAL STYLES
/**********************************************************************************************************************/
		getGlobalStyle: function( id ) {
			return this._globalStyles.get(this._currentElementId + ' ' + id );
		},

		setGlobalStyleName: function( id, name ) {
			this._globalStyles.set(this._currentElementId + ' ' + id + ' name', name);
		},

		deleteGlobalStyle: function( id ) {
			var currentElementId = this._currentElementId;
			var gs = this._globalStyles;
			gs.unset(currentElementId + ' ' + id);

			console.log( gs, currentElementId + ' ' + id );

		},

		getGlobalStyleVariations: function() {
			var currentElementId = this._currentElementId;
			var gs = this._globalStyles;

			var elements = [];

			var defaultElementHasBeenAdded = false;

			var currentElementStyles =gs.get( currentElementId);


			if( currentElementStyles != null ) {
				currentElementStyles.each(function (data, key) {
					var id = key;
					var name = data.get('name', 'Default');
					var element = {};
					element.value = id;
					element.name = name;

					elements.push(element);

					if (parseInt(key) == 0) {
						defaultElementHasBeenAdded = true;
					}
				});
			}
			if( !defaultElementHasBeenAdded ) {
				var element = {};
				element.value = 0;
				element.name = 'Default';
				elements.unshift( element );
			}

			return elements;
		},

		hasElementFormBeenChanged: function() {
			return this._getOptionsManager().hasFormBeenChanged();
		},

		renderElementPreview: function( data ) {
			if( localStorage.getItem('ff_disable_live_preview') == 1 ) {
				return;
			}
			
			if( data == undefined ) {
				data = this.getOptionsData();
			}

			// text color printing
			var query = this._getOptionsManager().getQuery( data );
			var textColor = this.getCurrentTextColor( data );

			this.$el.removeClass('ffb-text-color-dark').removeClass('ffb-text-color-light').removeClass('ffb-text-color-inherit');
			this.$el.addClass('ffb-text-color-' + textColor );

			// all things rendering
			query = this._getOptionsManager().getQuery( data ).get('o gen');

            var elementUserID = this._getOptionsManager().getQuery( data ).get('o a-t id');

			if( query == undefined ) {
				return null;
			}


			var previewView = new window.ffbuilder.PreviewView();
			var elementCallbackFunction = this.model.get('functions.renderContentInfo_JS');

            var $currentHeaderTitle = this.$el.find('.ffb-header-name:first');
            $currentHeaderTitle.find('.ffb-user-id-addition').remove();

            if( elementUserID ) {

                $currentHeaderTitle.append('<span class="ffb-user-id-addition"> - ' + elementUserID + '</span>');
            }

            try {
                elementCallbackFunction(query, data, this.$el.children('.ffb-element-preview'), this.$el, this._blockCallbacks,  previewView, this );
                this._setElementPreview( previewView.getHtmlPreview() );
            } catch(e) {
                this._setElementPreview('<div class="ffb-preview-text">Preview Not Available</div>');
            }


			if( this.isElementDisabled() ) {
				this.setDisableElement(1);
			}
		},

		animationHighlight: function() {
			this.$el.delay(100).animate({opacity:0.5}, 200).animate({opacity:1}, 200);
		},

		setCurrentTextColor: function( color ) {
			var defaultTextColor = this.getDefaultTextColor();
			var data = this.getOptionsData();
			var query = this._getOptionsManager().getQuery( data );

			if( defaultTextColor == color ) {
				query.unset('o clrs text-color');
			} else {
				if( color == 'inherit' ) {
					color = '';
				} else {
					color = 'fg-text-' + color;
				}
				query.set('o clrs text-color', color);
			}

			this.setOptionsData( query.getData() );
			this.renderElementPreview();
		},

		getCurrentTextColor: function( data ) {
			if( data == undefined ) {
				data = this.getOptionsData();
			}

			var query = this._getOptionsManager().getQuery( data );

			var textColor;
			if( query.exists('o clrs text-color') ) {
				textColor = query.get('o clrs text-color');
				textColor = textColor.replace('fg-text-', '');

			} else {
				textColor = this.getDefaultTextColor();
			}
			if( textColor == '' ) {
				textColor = 'inherit';
			}

			return textColor;
		},

		getDefaultTextColor: function() {
			var defaultColor = this.model.get('defaultColor');
			if( defaultColor == '' ) {
				return 'inherit';
			} else {
				return defaultColor;
			}
		},

		_setElementPreview: function( html ) {
			if( html == '' ) {
				html = '<div class="ffb-preview-empty"><i class="ffb-preview-empty-content ff-font-awesome4 icon-eye-slash"></i></div>';
			}

			this.$el.children('.ffb-element-preview').html( html );
		},

		getFormHasBeenChanged: function() {
			return this._getOptionsManager().formHasBeenChanged();
		},


		getDataForShortcodes: function() {
			var data = this.getOptionsData();

			var toScConvertor = new frslib.options2.toScConvertor();

			toScConvertor.setData( data);
			toScConvertor.setStructure( this._model.get('optionsStructure') );
			toScConvertor.setBlocks( this._blockData );

			toScConvertor.walk();

			var toReturn = {};
			toReturn.dataWithoutPrintInContentParam = toScConvertor.getDataWithoutPrintInContentParam();
			toReturn.printInContent = toScConvertor.getDataPrintInContent();


			return toReturn;
		},

		saveRenderedOptionsForm: function() {
			var data = this.getOptionsFormData();
			this._getOptionsManager().forceFormValuesAsUserValues();
			this.setOptionsData( data );
			this.renderElementPreview( data );
			this._vent.f.canvasChanged();
		},

		getOptionsFormData: function() {
			return this._getOptionsManager().parseForm();
		},

		getCustomDropzoneSelector: function() {
			var customDropzoneSelector = null;

			var selectors = [];
			var key = null;

			var whitelistedParents = this._model.get('parentWhitelistedElement');
			// we have whitelisted elements
			if( whitelistedParents.length > 0 ) {
				for( key in whitelistedParents ) {
					var oneParent = whitelistedParents[ key ];
					selectors.push( '.ffb-dropzone-' + oneParent );
				}

				customDropzoneSelector = selectors.join(', ');
			}
			// we have to go trough every element and find relations like a bauss
			else {

				for( key in this._elementModels ) {
					var oneModel = this._elementModels[ key ];

					var whitelistedElements = oneModel.get('dropzoneWhitelistedElements');
					var blacklistedElements = oneModel.get('dropzoneBlacklistedElements');

					if( whitelistedElements.length > 0 && whitelistedElements.indexOf( this._currentElementId ) == -1 ) {
						selectors.push( '.ffb-dropzone-' + key );
					}

					if( blacklistedElements.length > 0 && blacklistedElements.indexOf( this._currentElementId ) != -1 ) {
						selectors.push( '.ffb-dropzone-' + key );
					}
				}

				if( selectors.length > 0 ) {
					customDropzoneSelector = '.ffb-dropzone:not(' + selectors.join(', ') + ')';
				}
			}

			return customDropzoneSelector;
		},

		getNewElementHtml: function() {
			var newItemDefaultHTML = this._model.get('defaultHtml');
			var $element = $(newItemDefaultHTML);

			this.makeElementUnique( $element );

			return $element;
		},

		makeElementUnique: function( $element ) {
			if( $element == undefined ) {
				$element = this.$el;
			}

			var oldUniqueId = $element.attr('data-unique-id');

			if( oldUniqueId != undefined ) {
				var oldUniqueClass = this.generateUniqueClass( oldUniqueId );
				$element.attr('data-unique-id', '');
				$element.removeClass( oldUniqueClass );
			}

			var newUniqueId = this.generateUniqueId();
			var newUniqueClass = this.generateUniqueClass( newUniqueId );

			$element.attr('data-unique-id', newUniqueId );
			$element.addClass( newUniqueClass );

			var self = this;
			if( !$element.hasClass('ffb-element-dropzone-no') ) {
				$element.find('.ffb-element').each(function(){
					self.makeElementUnique( $(this) );
				});
			}
		},

		setDisableElement: function( type ) {
			var options = this.getOptionsData();

			if( type == 'switch' ) {
				if( this.isElementDisabled() ) {
					type = 0;
				} else {
					type = 1;
				}
			}

			if( type == 0 ) {
				options['o']['gen']['ffsys-disabled'] = 0;
				this.$el.removeClass('ffb-element-disabled');
			} else if( type == 1 ) {
				options['o']['gen']['ffsys-disabled'] = 1;
				this.$el.addClass('ffb-element-disabled');
			}

			this.setOptionsData( options );

		},

		isElementDisabled: function() {
			var options = this.getOptionsData();
			var actualState = options['o']['gen']['ffsys-disabled'];

			if( parseInt( actualState ) == 1 ) {
				return true;
			} else {
				return false;
			}
		},

		generateUniqueClass: function( uniqueId ) {
			if( uniqueId == undefined )


			return 'ffb-id-' + uniqueId;
		},

		canvasChanged: function() {

		},

		generateUniqueId: function() {
			var number = new Date().getTime() -  new Date('2016-01-01').getTime();
			// this.lastGeneratedId = number;
			if( this._lastGeneratedId != null && this._lastGeneratedId >= number ) {
				number = this._lastGeneratedId + 1;
			}
			var newId = number.toString( 32 );
			this._lastGeneratedId = number;
			return newId;
		},

		getUniqueId: function() {
			return this.$el.attr('data-unique-id');
		},

		getElementId: function() {
			return this._currentElementId;
		},

		/*----------------------------------------------------------*/
		/* GETTERS AND SETTERS
		/*----------------------------------------------------------*/
		getOptionsData: function() {
			var dataJSON = this.$el.attr('data-options');
			var data = JSON.parse( dataJSON );

			return data;
		},

		setOptionsData: function( data ) {
			if( typeof data != 'string' ) {
				data = JSON.stringify( data );
			}

			this.$el.attr('data-options', data);
		}
	});


})(jQuery);


















