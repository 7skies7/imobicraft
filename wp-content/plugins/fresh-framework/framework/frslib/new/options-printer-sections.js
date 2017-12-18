(function($){
	frslib.provide('frslib.options2');

	/**
	 * Printing our options
	 */
	frslib.options2.printerSections = frslib.options2.printerElements.extend({

		_itemsOpenedStack: [],

		_isInSaveOnlyDifference: 0,

		_cbSectionNormalBefore: function( item ) {

			if( this._getItemParam( item, 'save-only-difference', false) && this._callCallbacks ) {

				if( this._isInSaveOnlyDifference == 0 ) {
					this._output += '<span class="ff-reading-param ff-reading-param-start" data-type="save-only-difference-start"></span>';
				}
				this._isInSaveOnlyDifference++;
			}

			// this._setItemParam( blockItem, 'block-unique-hash', blockUniqueHash);
			if( this._getItemParam(item, 'block-unique-hash' ) && this._callCallbacks  ) {
				this._output += '<span class="ff-reading-param ff-reading-param-start" data-type="block-unique-hash-start" data-id="' + item.id +'" data-value="' + this._getItemParam(item, 'block-unique-hash' ) + '"></span>';
			}
		},
		_cbSectionNormalAfter: function( item ) {
			if( this._getItemParam(item, 'block-unique-hash' ) && this._callCallbacks  ) {
				this._output += '<span class="ff-reading-param ff-reading-param-end" data-type="block-unique-hash-end" data-id="' + item.id +'" data-value="' + this._getItemParam(item, 'block-unique-hash' ) + '"></span>';
			}

			if( this._getItemParam( item, 'save-only-difference', false) && this._callCallbacks ) {

				this._isInSaveOnlyDifference--;

				if( this._isInSaveOnlyDifference == 0 ) {
					this._output += '<span class="ff-reading-param ff-reading-param-end" data-type="save-only-difference-end"></span>';
				}
			}


		},

		/*----------------------------------------------------------*/
		/* REPEATABLE VARIABLE
		/*----------------------------------------------------------*/
		_cbSectionRepVariableBefore: function( item ) {
			var attrHelper = this._getAttrHelper();
			if(this._getItemParam( item, 'all-items-opened') == true ) {
				attrHelper.addParam('class','ff-all-items-opened');
				this._itemsOpenedStack.push(true);
			} else {
				this._itemsOpenedStack.push( false );
			}


			if( !this._callCallbacks ) {
				return false;
			}


			var cssClasses = this._getItemParamArray( item, 'class');

			attrHelper.addParam('class', cssClasses);
			if(this._getItemParam( item, 'section-picker') == 'advanced' ) {
				attrHelper.addParam('class', 'ff-section-picker-advanced');
			}

			if(this._getItemParam( item, 'work-as-accordion') == true ) {
				attrHelper.addParam('class','ff-work-as-accordion');
			}

			if(this._getItemParam( item, 'can-be-empty', false) == true ) {
				attrHelper.addParam('class','ff-can-be-empty');
			}

			attrHelper.addParam('class', 'ff-repeatable ff-repeatable-js ff-repeatable-boxed');

			var currentLevel = this._getCurrentRouteLevel();

			this._output += '<ul ' + attrHelper.getAttrString() + ' data-current-level="'+currentLevel+'">';
		},

		_cbSectionRepVariableAfter: function( item ) {
			this._itemsOpenedStack.pop();

			if( !this._callCallbacks ) {
				return false;
			}

			this._output += '</ul>';

		},

		/*----------------------------------------------------------*/
		/* REPEATABLE VARIABLE
		/*----------------------------------------------------------*/
		_cbSectionRepVariationBefore: function( item ) {
			if( !this._callCallbacks ) {
				return false;
			}

			if( item == null ) {
				return;
			}

			var sectionName = this._getItemParam( item, 'section-name');

			var hideDefault = this._getItemParam(item, 'hide-default');

			var hideDefaultClass = '';

			if( hideDefault ) {
				hideDefaultClass = 'ff-hide-default';
			}

			var currentSectionRoute = '';//this._getCurrentRoute().join(' ');//this._getCurrentRouteValue().join(' ');//'';//this._cleanRoute.slice(0, -1).join(' ');//'';// _.walker.getCurrentSectionRoute();

			var dataRepVariableSectionRoute = this._cleanRoute.slice(0, -1).join(' ');

			var nameRoute = this._getNameRoute();
			var index = '';

			var isOpened = this._itemsOpenedStack[ this._itemsOpenedStack.length - 1 ];
			var openedClass;
			if( isOpened == true ) {
				openedClass = 'ff-repeatable-item-opened';
			} else {
				openedClass = 'ff-repeatable-item-closed';
			}

			var hasAdvancedToolsClass = '';

			if(this._getItemParam(item, 'show-advanced-tools') == true) {
				hasAdvancedToolsClass = 'ff-this-item-has-advanced-tools';
			}

			this._output += '<li class="ff-repeatable-item ff-repeatable-item-js ff-repeatable-item-'+index+' ' + openedClass +' ' + hideDefaultClass + ' ' + hasAdvancedToolsClass + '" data-rep-variable-section-route="'+dataRepVariableSectionRoute+'" data-section-id="'+item.id+'" data-section-name="'+sectionName+'" data-node-id="'+index+'" data-current-name-route="'+nameRoute+'" data-current-section-route="'+currentSectionRoute+'">';
			// HEADER
			this._output +=  '<div class="ff-repeatable-header ff-repeatable-drag  ui-sortable">';

			this._output += '<table class="ff-repeatable-header-table"><tbody><tr>';
			this._output += '<td class="ff-repeatable-item-number"></td>';
			this._output += '<td class="ff-repeatable-title">' + sectionName + '</td>';
			this._output += '<td class="ff-repeatable-description"> </td>';
			this._output += '</tr></tbody></table>';
			this._output += '<div class="ff-repeatable-handle"></div>';
			this._output += '<div class="ff-repeatable-settings"></div>';

			if(this._getItemParam(item, 'show-advanced-tools') == true) {
				this._output += '<div class="ff-show-advanced-tools dashicons dashicons-edit"></div>';
				this._output += '<div class="ff-repeatable-ig-changed-wrapper clearfix">';
					this._output += '<div class="ff-repeatable-instance-changed"></div>';
					this._output += '<div class="ff-repeatable-global-changed"></div>';
				this._output += '</div>';
			}

			this._output += '</div>';
			this._output += '<div class="ff-repeatable-content">';
			
			
			
		},
		_cbSectionRepVariationAfter: function( item ) {
			if( !this._callCallbacks ) {
				return false;
			}

			this._output += '</div>';


			this._output += '</li>';
			
		},

		_cbSectionRepVariableEmptyStart: function( item ) {},
		_cbSectionRepVariableEmptyEnd: function( item ) {
			if( !this._callCallbacks ) {
				return false;
			}

			var dataRepVariableSectionRoute = this._cleanRoute.join(' ');

			this._output += '<li class="ff-repeatable-item ff-repeatable-item-js ff-repeatable-item-empty-add ff-repeatable-item-empty-add-ffb" data-rep-variable-section-route="'+dataRepVariableSectionRoute+'">' +
				'<div class="ff-repeatable-add-ffb ff-repeatable-add-above ff-repeatable-add-above-js" title="Add Item"></div>' +


				// '<div class="ff-repeatable-header ff-repeatable-drag ff-repeatable-handle ui-sortable ui-sortable-handle">' +




				// '</div>' +
				'</li>';

		},

	});

})(jQuery);
