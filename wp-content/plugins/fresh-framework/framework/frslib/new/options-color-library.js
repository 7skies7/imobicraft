(function($) {
	frslib.provide('frslib.options2');

    frslib.messages.addListener(function (message) {
        if (message.command == 'colorLibraryChange' ) {

            var newColorLibrary = frslib.clone( message.colorLibrary);
            window.frs_theme_color_library = newColorLibrary;

        }
    });

	/**
	 * Printing our options
	 */
	frslib.options2.colorLibrary = Backbone.View.extend({

		initialize: function( options ){
			this.$option = 	options.$option;

			this._bindActions();
		},

		_bindActions: function() {
			this._bindActionReset();
			this._bindActionOpenLibrary();
		},

		_bindActionReset: function() {
			var $option = this.$option;
			$option.find('.fftm__option-type__reset').on('click', function(){
				$option.addClass('fftm__option-type__is-reset');
				$option.find('input').val('');
				$option.find('input').trigger('change');
				$option.find('.fftm__option-type--color-picker__select-preview-color').attr('data-color', '');
			});
		},

		_bindActionOpenLibrary: function() {
			var self = this;
			this.$option.find('.fftm__option-type--color-picker__select').click(function(){ self._openLibrary() });
		},

		_resetVariables: function() {

		},

		_openLibrary: function() {
			this._gatherValues();
			this._generateAndShowHtml();
			this._initSpectrum();

			this._setUpValuesFromInput();

			this._bindActionsAtLibrary();
		},

		_bindActionsAtLibrary: function() {
			this._bindPickerAndPaletteSwitching();
			this._bindColorPaletteClick();
			this._bindColorLibrarySwitching();
			this._bindColorLibraryClick();
			this._bindColorLibraryInputChange();
			this._bindColorLibraryHover();
			this._bindColorPickerPreviewClick();
			this._bindButtonOkAndCancel();
		},

		_bindButtonOkAndCancel: function () {
			var self = this;

			this.$buttonOk.on('click', function(){
				var currentColorValue = self.$el.find('.sp-input').val();
				self._colorHasBeenChanged( currentColorValue, 'button-ok');
				self.modal.close();
			});

			var cancelColorLibrary = function() {
				var originalColor = self.originalColor;
				var originalPosition = self.originalPosition;

				if( originalPosition != null ) {
					self._setValueToInput('[' + originalPosition + ']');
					self._setColorToInput( originalColor, originalPosition );

					self._fillOriginalLibraryToOtherPreviews();
				} else {
					self._setColorToInput( originalColor, '' );
					self._setValueToInput( originalColor );
				}

				self.modal.close();
				window.frslib.colorLibrary= frslib.clone(self.backupColorLibrary);
			};
			this.modal.setCloseOverlayCallback(function(){
				cancelColorLibrary();
			});

			this.$buttonCancel.on('click', function(){
				cancelColorLibrary();
			});

		},

		_fillOriginalLibraryToOtherPreviews: function() {
			// return;
			var originalLibrary = this.backupColorLibrary;
			var self = this;

			$('.fftm__option-type--color-picker').each(function(){
				var $previewColor = $(this).find('.fftm__option-type--color-picker__select-preview-color');
				var $dataInput = $(this).find('input');

				var value = $dataInput.val();


				if( self._isColorFromLibrary( self ) ) {
					value = self._getNumberFromPosition( value );

					var colorObject = originalLibrary[value];

					if( colorObject != undefined ) {
						$previewColor.css('background', colorObject.color );
						$previewColor.css('color', frslib.colors.contrast( colorObject.color ) );
					}

					// console.log( color );

					// console.log( value );
					// console.log( position );
					// if( value != '' && value == position ) {
					// 	$previewColor.css('background', color );
					// 	$previewColor.css('color', frslib.colors.contrast(color) );
					// }

				}
			});

		},

		/**
		 *
		 */
		_bindColorPickerPreviewClick: function() {
			var self = this;
			this.$previewHistoryOld.on('click', function(){
				var color = $(this).attr('data-color');
				self._colorHasBeenChanged( color, 'preview-old');
			});
		},

		/**
		 * Hovering the colors and then changing the name
		 */
		_bindColorLibraryHover: function() {
			var self = this;
			this.$el.find('.fftm__option-type--color-picker__library-color__clicker').hover(function(){
				var $colorLibraryItem = $(this).next();
				var position = $colorLibraryItem.attr('data-color-position');

				var colorName = self._getNameFromLibrary( position );

				self.$nameInput.val( colorName );
			}, function(){
				var originalColorPosition = self.$selectedColor.attr('data-color-position');
				var originalName = self._getNameFromLibrary( originalColorPosition );

				self.$nameInput.val( originalName );
			});
		},

		/**
		 * Save the values of changed input
		 */
		_bindColorLibraryInputChange: function() {
			var self = this;
			this.$nameInput.on('keyup', function(){
				var value = $(this).val();
				self._changeColorLibraryName( value );
			});
		},

		_changeColorLibraryName: function( name ) {
			var position = this.$selectedColor.attr('data-color-position');
			this._setNameToLibrary( position, name );
		},

		/**
		 * Click on color library color
		 */
		_bindColorLibraryClick: function() {
			var self = this;
			this.$el.find('.fftm__option-type--color-picker__library-color__clicker').on('click', function(){
				var position = $(this).next().attr('data-color-position');

				self._applyColorFromLibrary( position );
			});
		},

		/**
		 * Enable / Disable color library
		 */
		_bindColorLibrarySwitching: function() {
			var $el = this.$el;
			var self = this;
			// use / unuse library
			$el.find('.fftm__option-type--color-picker__use-library').on('click', function(){
				if( $(this).prop('checked') ) {
					self._enableColorLibrary();
				} else {
					self._disableColorLibrary();
				}
			});
		},



		/**
		 * Click on color picker palette
		 */
		_bindColorPaletteClick: function() {
			var self = this;
			this.$el.find('.fftm__option-type--color-picker__palette-color').on('click', function(){
				var color = $(this).attr('data-color');
				self._colorHasBeenChanged( color, 'palette' );
			});
		},

		_bindPickerAndPaletteSwitching: function () {
			var $el = this.$el;
			/*----------------------------------------------------------*/
			/* TABS PICKER / PALETTE
			 /*----------------------------------------------------------*/
			// picker
			$el.find('.fftm__option-type--color-picker__picker-tab__picker').on('click', function(){
				$el.removeClass('fftm__option-type--color-picker__picker-tab--active--palette').addClass('fftm__option-type--color-picker__picker-tab--active--picker');
			});
			// palette
			$el.find('.fftm__option-type--color-picker__picker-tab__palette').on('click', function(){
				$el.removeClass('fftm__option-type--color-picker__picker-tab--active--picker').addClass('fftm__option-type--color-picker__picker-tab--active--palette');
			});

		},


		_setUpValuesFromInput: function() {
			if( this.isColorLibrary ) {
				this._enableColorLibrary( this.originalPosition );
			} else {
				this._colorHasBeenChanged( this.originalColor, 'init');
			}

			var originalColor = this.originalColor;
			this.$previewHistoryOld.css('background-color', originalColor ).css('color', originalColor);
			this.$previewHistoryNew.css('background-color', originalColor ).css('color', originalColor);
			this.$previewHistoryOld.attr('data-color', originalColor );
		},

		_colorHasBeenChanged: function (color, origin ) {
			this.currentColor = color.toString();
			color = color.toString();

			if( origin != 'picker' ) {
				this._setColorToPicker( color.toString() );
			}

			if( this._isColorLibraryActive() ) {

				var position = this.$selectedColor.attr('data-color-position');
				this._setColorToInput( color, position );
				this._setValueToInput( '[' + position + ']' );

				this._setColorToLibraryPreview(position, color );
				this._setColorToLibrary( position, color );
				this._setColorToOtherPreviews( position, color );

			} else {

				this._setColorToInput( color, '' );
				this._setValueToInput( color );

			}

			this.$previewHistoryNew.css('background-color', color).css('color', color);
		},



		_setColorToOtherPreviews: function( position, color ) {

			var self = this;
			$('.fftm__option-type--color-picker').each(function(){
				var $previewColor = $(this).find('.fftm__option-type--color-picker__select-preview-color');
				var $dataInput = $(this).find('input');
				var value = $dataInput.val();
				if( self._isColorFromLibrary( value ) ) {

					value = self._getNumberFromPosition( value );
					if( value != '' && value == position ) {
						$previewColor.css('background', color );
						$previewColor.css('color', frslib.colors.contrast(color) );
					}

				}
			});
		},

		_setColorToLibraryPreview: function( position, color ) {
			var $libraryItem = this.$el.find('.fftm__option-type--color-picker__library-color-' + position);
			var $preview = $libraryItem.find('.fftm__option-type--color-picker__library-color-preview');

			$libraryItem.attr('data-color', color);
			$preview.css('background-color', color);
			$preview.css('color', frslib.colors.contrast(color) );
		},

		_isColorLibraryActive : function() {
			if( this.$selectedColor == null ) {
				return false;
			} else {
				return true;
			}
		},

		_setColorToInput: function( color, text ) {
			this.$previewColor.css('background', color);

			this.$option.removeClass('fftm__option-type__is-reset')

			if( text != undefined ) {
				this.$previewColor.css('color', frslib.colors.contrast(color) );
				this.$previewColor.html( text);
			}
		},

		_setValueToInput: function( value ) {
			this.$dataInput.val( value );

			if( value == '' || value == null ) {
				this.$dataInput.val( '' );
				this.$option.addClass('fftm__option-type__is-reset');
			}

			this.$dataInput.trigger('change');
		},

		_setColorToPicker: function( color ) {
			this.$el.find('.fftm__option-type--color-picker__picker').spectrum('set', color );
			this.$el.find('.fftm__option-type--color-picker__picker').spectrum('reflow');
		},

		_initSpectrum: function() {
			var self = this;
			this.$el.find('.fftm__option-type--color-picker__picker').spectrum({
				color: this.originalColor,
				flat: true,
				showAlpha: true,
				showInput: true,
				showInitial: true,
				// allowEmpty:true,
				preferredFormat: "hex",
				move: function( color ){
					self._colorHasBeenChanged( color, 'picker' );
				},

			});
			setTimeout(function(){
				self.$el.find('.sp-input').focus().select();
			}, 100);
		},

		_gatherValues: function() {
			var $option = this.$option;
			this.$selectedColor = null;
			this.$dataInput = $option.find('input');
			this.$previewColor = $option.find('.fftm__option-type--color-picker__select-preview-color');


			this.originalValue = this.$dataInput.val();
			this.originalPosition = null;

			this.originalColor = this._getColorClean(  this.originalValue );
			this.isColorLibrary = this._isColorFromLibrary( this.originalValue );


			if( this.isColorLibrary ) {
				this.originalPosition = this._getNumberFromPosition( this.originalValue );
			}

			this.backupColorLibrary = frslib.clone(window.frs_theme_color_library);
		},

		_generateAndShowHtml: function() {
			this.$el = this._generateColorPickerHtml();
			this.modal = new frslib.options2.modal();
			this.modal.printContent( this.$el );

			this.$nameInput = this.$el.find('.fftm__option-type--color-picker__library-color-name');
			this.$previewHistoryOld = this.$el.find('.fftm__option-type--color-picker__history-old');
			this.$previewHistoryNew = this.$el.find('.fftm__option-type--color-picker__history-new');
			this.$buttonOk = this.$el.find('.fftm__option-type--color-picker__btn-save');
			this.$buttonCancel = this.$el.find('.fftm__option-type--color-picker__btn-cancel');
			this.$nameInput = this.$el.find('.fftm__option-type--color-picker__library-color-name');

			// console.log( this.$option);
			if( parseInt(this.$option.find('.ff-opt').attr('data-locked-library')) == 1 ){
				this.$el.addClass('fftm__option-type--color-picker--library-color-is-locked');
			}
		},

		_enableColorLibrary: function( position ) {
			this.$el.addClass('fftm__option-type--color-picker--library-color-is-active');
			this.$el.find('.fftm__option-type--color-picker__use-library').prop('checked', 'checked');

			if( position == undefined ) {
				position = 1;
			}

			this._applyColorFromLibrary( position );
		},

		_applyColorFromLibrary: function( position ) {
			this.$el.find('.fftm__option-type--color-picker__library-color').removeClass('fftm__option-type--color-picker__library-color--active');
			this.$selectedColor = this.$el.find('.fftm__option-type--color-picker__library-color-' + position);
			this.$selectedColor.addClass('fftm__option-type--color-picker__library-color--active');

			var color = this._getColorFromLibrary( position );
			var name = this._getNameFromLibrary( position );

			this.$nameInput.val( name );

			this._colorHasBeenChanged( color, 'library');
		},

		_disableColorLibrary: function() {
			this.$el.removeClass('fftm__option-type--color-picker--library-color-is-active');
			this.$el.find('.fftm__option-type--color-picker__use-library').prop('checked', '');

			var color = this.$selectedColor.attr('data-color');
			this.$selectedColor = null;

			this._colorHasBeenChanged( color, 'disabled-library');
		},

		_getColorClean: function( color ) {
			if( this._isColorFromLibrary( color ) ) {
				return this._getColorFromLibrary( color );
			} else {
				return color;
			}
		},

		_setNameToLibrary : function ( position, name ) {
			position = this._getNumberFromPosition( position );
			window.frs_theme_color_library[position]['name'] = name;
		},

		_getNameFromLibrary: function( position ) {
			position = this._getNumberFromPosition( position );
			return window.frs_theme_color_library[position]['name'];
		},

		_getNumberFromPosition : function( position ) {
			return position.toString().replace('[','').replace(']','').trim();
		},

		_setColorToLibrary : function ( position, color ) {
			position = this._getNumberFromPosition( position );
			window.frs_theme_color_library[position]['color'] = color;
		},

		_getColorFromLibrary: function( position ) {
			var number = this._getNumberFromPosition( position );
			// console.log( number, window.frslib.colorLibrary );
			return window.frs_theme_color_library[number]['color'];
		},

		_isColorFromLibrary: function( color ) {
			if( color.toString().indexOf('[') == -1 ) {
				return false;
			} else {
				return true;
			}
		},


		_generateColorPickerHtml : function( colorValue ) {
			if( colorValue == undefined ) {
				colorValue = '#ffffff';
			}

			var colorPalette = new Array();

			colorPalette.push('#ffffff');
			colorPalette.push('#f5f5f5');
			colorPalette.push('#cccccc');
			colorPalette.push('#444444');
			colorPalette.push('#000000');
			colorPalette.push('#ff3300');
			colorPalette.push('#E91E63');
			colorPalette.push('#9C27B0');
			colorPalette.push('#673AB7');
			colorPalette.push('#3F51B5');
			colorPalette.push('#2196F3');
			colorPalette.push('#03A9F4');
			colorPalette.push('#00BCD4');
			colorPalette.push('#009688');
			colorPalette.push('#4CAF50');
			colorPalette.push('#8BC34A');
			colorPalette.push('#FFEB3B');
			colorPalette.push('#FFC107');
			colorPalette.push('#FF9800');
			colorPalette.push('#FF5722');

			var input = '';
            input += '<div class="fftm__option-type--color-picker__window fftm__option-type--color-picker__picker-tab--active--picker clearfix">';
                input += '<div class="fftm__option-type--color-picker__header clearfix">';
                    input += '<div class="fftm__option-type--color-picker__library-tabs clearfix"><label><input class="fftm__option-type--color-picker__use-library" type="checkbox"> Use Global Color</label></div>';
                    input += '<div class="fftm__option-type--color-picker__picker-tabs clearfix">';
                        input += '<div class="fftm__option-type--color-picker__picker-tab fftm__option-type--color-picker__picker-tab__picker">Picker</div>';
                        input += '<div class="fftm__option-type--color-picker__picker-tab fftm__option-type--color-picker__picker-tab__palette">Palette</div>';
                    input += '</div>';
                input += '</div>';
                input += '<input type="text" class="fftm__option-type--color-picker__picker" />';
                input += '<div class="fftm__option-type--color-picker__library clearfix">';
                    input += '<div class="clearfix">';
                        input += '<div class="fftm__option-type--color-picker__library-color-position-wrapper">';
                            input += '<div class="fftm__option-type--color-picker__library-color-position"></div>';
                        input += '</div>';
                        input += '<input type="text" class="fftm__option-type--color-picker__library-color-name" placeholder="Color name" />';
                        input += '<div class="fftm__option-type--color-picker__no-library-text"></div>';
                    input += '</div>';
                    input += '<div class="fftm__option-type--color-picker__library-colors clearfix">';

						var colorLibrary = window.frs_theme_color_library;
						for( var number = 1; number <= 50; number++ ) {
							var color = colorLibrary[ number ];

							var value = '#f5f5f5';
							if( color != undefined ) {
								value = color[ 'color' ];
							}


							if( value == null ) {
								value = '#f5f5f5';
							}
							input += '<div class="fftm__option-type--color-picker__library-color__clicker"></div>';
							input += '<div class="fftm__option-type--color-picker__library-color fftm__option-type--color-picker__library-color-'+ number +'" data-color-position="'+number+'" data-color-name="" data-color="' + value + '" data-color-tooltip="">';
								input += '<div style="background-color:'+value+'; color: '+ frslib.colors.contrast(value) +';" class="fftm__option-type--color-picker__library-color-preview">'+ number +'</div>';
							input += '</div>';

						}
                    input += '</div>';
                input += '</div>';
                input += '<div class="fftm__option-type--color-picker__palette">';

					for( var keyInPalette in colorPalette ) {
						var colorFromPalette = colorPalette[ keyInPalette ];

						input += '<div class="fftm__option-type--color-picker__palette-color" data-color="' + colorFromPalette + '" style="background-color: '+colorFromPalette+';"></div>';
					}

                input += '</div>';

                input += '<div class="fftm__option-type--color-picker__history-preview fftm__option-type--color-picker__history-old" style="background-color:'+colorValue+'; color: '+colorValue+';"></div>';
                input += '<div class="fftm__option-type--color-picker__history-preview fftm__option-type--color-picker__history-new" style="background-color:'+colorValue+'; color: '+colorValue+';"></div>';
                input += '<div class="fftm__option-type--color-picker__btn-save">Save</div>';
                input += '<div class="fftm__option-type--color-picker__btn-cancel">Cancel</div>';
            input += '</div>';
            input += '<div class="fftm__option-type--color-picker__window-spacer"></div>';

            return $(input);
		},

	});


})(jQuery);

