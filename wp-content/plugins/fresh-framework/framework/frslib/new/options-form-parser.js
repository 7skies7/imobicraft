(function($){
	frslib.provide('frslib.options2');

	/**
	 * Parsing values of the options form to JSON or submitting it like a boss
	 */
	frslib.options2.formParser = Backbone.View.extend({

		_data: {},

		_counters: [],

		_saveOnlyDifference: true,

		_isInSaveOnlyDifferenceArea : false,

		_reset: function() {
			this._data = {};
		},

		getClonnedFormHTMLWithValues: function( $form ) {
			this.normalizeFormBeforeCopy( $form );
			var formHTML = $form.prop('outerHTML');
			this.revertNormalizationBeforeCopy( $form );

            var $html = $(formHTML);
            $html.find('.select2-container').remove();
            $html.find('.ff-richtext-area-wrapper').each(function(){
                $(this).find('.mce-tinymce').remove();
                console.log('sulin');
            });
            formHTML = $html.prop('outerHTML');


			return formHTML;
		},

		revertNormalizationBeforeCopy: function( $form ) {
			$form.find('.ff-opt').removeAttr('data-temporary-value-holder');
		},

		normalizeFormBeforeCopy: function( $form ) {
			var self = this;
			$form.find('.ff-opt').each(function(){
				var $this = $(this);
				var inputValue = self._getInputValueClean( $this );

				console.log( inputValue );

				$this.attr('data-temporary-value-holder', inputValue );
			});
		},

		normalizeFormAfterCopy: function( $form ) {
			var self = this;
			$form.find('.ff-opt').each(function(){
				var $this = $(this);
				var value = $this.attr('data-temporary-value-holder');
				$this.removeAttr('data-temporary-value-holder');
				$this.val( value );
			});
		},

		_setInputValueClean: function( $input, value ) {
			var inputType = $input.attr('data-opt-type');
			switch( inputType ) {
				case 'checkbox':

					if( value == '1' ) {
						$input.prop('checked', true);
					} else {
						$input.prop('checked', false);
					}
					break;

				default:
					$input.val( value );

					break;
			}
		},

		getDifferentInputsFromDefaultValue: function( $form, callback ) {
			this._reset();

			var formHasBeenChanged = false;

			this._traverseForm( $form, function( route, value, prefix, $input ){
				var currentValue = value;
				var defaultValue = $input.attr('data-default-value');
				var inputHasBeenChanged = false;

				if( value != defaultValue ) {
					formHasBeenChanged = true;
					inputHasBeenChanged = true;
				}

				if( callback != undefined ) {
					callback( $input, value, route, inputHasBeenChanged );
				}
			});

			return formHasBeenChanged;
		},

		hasBeenFormChanged: function( $form ) {
			this._reset();

			var formHasBeenChanged = false;

			this._traverseForm( $form, function( route, value, prefix, $input ){
				if( !$input.hasClass('ff-opt') ) {
					return;
				}

				var currentValue = value;

				var defaultValue = $input.attr('data-default-value');
				var userValue = $input.attr('data-user-value');

				if( defaultValue == undefined && userValue == undefined ){
					return;
				}

				if( userValue != undefined ) {
					if( value != userValue && value != defaultValue) {

						// console.log( 'userValue: ' + userValue );
						// console.log( $input.attr('data-default-value') );
						// console.log( route, value, $input, userValue );
						formHasBeenChanged = true;
						return false;
					}
				} else {
					if( value != defaultValue ) {

						console.log( route, value, $input, defaultValue );
						formHasBeenChanged = true;
						return false;
					}
				}
			}, function( $input ) {

				if( !$input.hasClass('ff-repeatable-js') ){
					return;
				}

				var startingChildsId = $input.attr('data-starting-childs-id');


				var endingChildsIdArray = [];

				$input.children('li:not(.ff-repeatable-item-empty-add)').each(function(){
					endingChildsIdArray.push( $(this).attr('data-section-id') );
				});

				if( endingChildsIdArray.join(',') != startingChildsId ) {
					formHasBeenChanged = true;
					return false;
				}
			});

			return formHasBeenChanged;
		},

		parseForm: function( $form ) {
			var self = this;
			this._data = {};
			this._traverseForm( $form, function( route, value ){
				self._setData( route, value );
			});

			return this._data;
		},

		parseFormAndGetNewForm: function( $form, returnOnlyInputs ) {
			if( returnOnlyInputs == undefined ) { returnOnlyInputs = false; }

			var $newForm = $('<form></form>');


			var self = this;
			this._traverseForm( $form, function( route, value, prefix ){
				// console.log( value );
				var $newInput = $('<input type="hidden">');
				var inputName = prefix + '[' + route.join('][') + ']';
				$newInput.attr('name', inputName);
				$newInput.val( value );
				$newForm.append( $newInput );
			});

			if( returnOnlyInputs ) {
				$newForm = $newForm.children();
			}

			return $newForm;
		},

		markChangedValues: function ($form) {
			this._saveOnlyDifference = false;
			this._reset();

			

			this._traverseForm( $form, function( route, value, prefix, $input ){
				var defaultValue = $input.attr('data-default-value');

				if( defaultValue != value ) {
					$input.parent().addClass('ffb-input-differ-from-default-value');
				} else {
					$input.parent().removeClass('ffb-input-differ-from-default-value');
				}

			}, function( $input ) {
				
				
				// if( !$input.hasClass('ff-repeatable-js') ){
				// 	return;
				// }
				// var endingChildsIdArray = [];
				// $input.children('li:not(.ff-repeatable-item-empty-add)').each(function(){
				// 	endingChildsIdArray.push( $(this).attr('data-section-id') );
				// });
				// var endingChildsId = endingChildsIdArray.join(',');
				//
				// $input.attr('data-starting-childs-id', endingChildsId);
			});

			this._saveOnlyDifference = true;
			// return formHasBeenChanged;
		},

		forceFormValuesAsUserValues: function( $form ) {
			this._reset();

			// var formHasBeenChanged = false;

			this._traverseForm( $form, function( route, value, prefix, $input ){
				$input.attr('data-user-value', value);

				console.log( 'xxxx');
			}, function( $input ) {
				if( !$input.hasClass('ff-repeatable-js') ){
					return;
				}
				var endingChildsIdArray = [];
				$input.children('li:not(.ff-repeatable-item-empty-add)').each(function(){
					endingChildsIdArray.push( $(this).attr('data-section-id') );
				});
				var endingChildsId = endingChildsIdArray.join(',');

				$input.attr('data-starting-childs-id', endingChildsId);
			});

			// return formHasBeenChanged;
		},

		parseFormAndNormalizeItForSubmit: function( $form ) {
			var parsedFormData = this.parseForm( $form );
			var parsedFormDataJSON = JSON.stringify( parsedFormData );
			var prefix = this._getFormPrefix( $form );
			var $newInput = $('<input type="hidden">');
			$newInput.attr('name', prefix + '-parsed');
			$newInput.val( parsedFormDataJSON );



			$form.find('[name]').removeAttr('name');
			$form.append( $newInput );

			// if( $form.prop('tagName') != 'form' && $form.find('form').size() == 0 ) {
			// 	$form.wrap('<form method="post"></form>');
			// }
		},

		_getFormPrefix: function( $form ) {
			var $elementWithName = $form.find('[name]:first');
			var name = $elementWithName.attr('name');

			var parsedNameInfo = this._parseInputName( name );
			return parsedNameInfo.prefix;
		},

		_traverseForm: function( $form, setDataCallback, allItemsCallback ) {
			var self = this;
			var optionCounter = 0;
			$form.find('.ff-repeatable-js, .ff-repeatable-item, .ff-reading-param, .ff-opt').addBack('.ff-repeatable-js, .ff-repeatable-item, .ff-reading-param, .ff-opt').each(function(){
				var $this = $(this);

				var name = null;
				var value = null;
				var currentLevel = null;

				if( $this.hasClass('ff-repeatable-js') ) {
					currentLevel = $this.attr('data-current-level');
					self._counters[ currentLevel ] = -1;
				}

				else if( $this.hasClass('ff-repeatable-item') ) {
					currentLevel = $this.parent().attr('data-current-level');
					self._counters[ currentLevel ]++;

					name = $this.attr('data-current-name-route');
					value = {};
				}

				else if( $this.hasClass('ff-reading-param') ) {
					var type = $this.attr('data-type');



					switch( type ) {
						case 'save-only-difference-start':
							self._isInSaveOnlyDifferenceArea = true;
							break;

						case 'save-only-difference-end':
							self._isInSaveOnlyDifferenceArea = false;
							break;
					}
				}

				else {
					optionCounter++;
					name = $this.attr('name');
					value = self._getInputValue( $this );
				}

				if( name != null && value != null ) {
					var data = self._parseInputName( name );
					if( setDataCallback( data.route, value, data.prefix, $this) == false ) {
						return false;
					}
				}

				if( allItemsCallback != undefined ) {
					if( allItemsCallback( $this ) == false ) {
						return false;
					}
				}
			});
		},


		getInputValueClean: function( $input) {
			return this._getInputValueClean( $input );
		},

		_getInputValueClean: function( $input ) {
			var inputType = $input.attr('data-opt-type');

			var value;
			switch( inputType ) {
				case 'checkbox':

					if( $input.is(':checked') ) {
						value = '1';
					} else {
						value = '0';
					}

					break;

				case 'textarea':
                    var showMode = $input.attr('data-show-mode');

                    if( showMode == 'richtext' ) {
                        var id = $input.attr('id');
                        value = window.tinyMCE.get(id).getContent();
                    } else {
                        value = $input.val();
                    }

					//if( $input.hasClass('ff-options__textarea-is-richtext') ) {
					//	var id = $input.attr('id');
					//	value = window.tinyMCE.get(id).getContent();
					//} else {
					//	value = $input.val();
					//}


					break;

				default:
					if( $input.hasClass('select2-hidden-accessible') ) {
						value = $input.select2('val');

						if( value instanceof Array ) {
							value = value.join('--||--');
						}

						if( value == null || value == 'null' ) {
							value = '';
						}
					}
					else {
						value = $input.val();
					}


					break;
			}

			return value;
		},

		_getInputValue: function( $input ) {
			var value = this._getInputValueClean( $input );

			value = String( value );

			if( this._isInSaveOnlyDifferenceArea && this._saveOnlyDifference ) {
				var defaultValue = $input.attr('data-default-value');

				if( defaultValue != value ) {
					return value;
				} else {
					return null;
				}

			} else {
				return value;
			}
		},

		_parseInputName: function( name ) {
			if( name.indexOf('-TEMPLATE-_-') != - 1 ) {
				for( var key in this._counters ) {
					name = name.replace('-_-'+key+'-TEMPLATE-_-', this._counters[key]);
				}
			}

			// default[o][gen][neco]
			var firstBracketStart = name.indexOf('[');
			// default
			var prefix = name.substring(0, firstBracketStart);
			// [o][gen][neco]
			var nameWithoutPrefix = name.substring(firstBracketStart);
			// o][gen][neco
			var nameClean = nameWithoutPrefix.substring(1, nameWithoutPrefix.length-1);
			// o gen neco -- ARRAY
			var nameArray = nameClean.split('][');

			var toReturn = {};
			toReturn.prefix = prefix;
			toReturn.route = nameArray;

			return toReturn;
		},

		_setData: function( route, value ) {
			value = this._escapeValue( value );
			var pointer = this._data;

			var routeLength = route.length

			var counter = 0;
			for( var id in route ) {
				counter++;

				var key = route[id];

				if( pointer[key] == undefined ) {
					pointer[key] = {};
				}

				if( counter == routeLength ) {
					pointer[key] = value;
				} else {
					var swap = pointer[key];
					pointer = swap;
				}
			}
		},

		_escapeValue : function( value ) {
			if( typeof value == 'string' ) {
				// value = value.split('&').join('&amp;');
			}

			return value;
		},

	});

})(jQuery);

