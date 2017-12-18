(function($){
	frslib.provide('frslib.options2');

	/**
	 * Printing our options
	 */
	frslib.options2.printerElements = frslib.options2.printerOptions.extend({
		_cbElement: function( item ) {

			if( !this._callCallbacks ) {
				return false;
			}

			switch( item.type ) {
				case 'type_table_start':
					this._printElementTableStart( item );
					break;

				case 'type_table_end':
					this._printElementTableEnd(item);
					break;

				case 'type_table_data_start':
					this._printElementTableDataStart( item );
					break;

				case 'type_table_data_end':
					this._printElementTableDataEnd( item );
					break;

				case 'type_new_line':
					this._printElementNewLine( item );
					break;

				case 'type_html':
					this._printElementHtml( item );
					break;

				case 'type_heading':
					this._printElementHeading( item );
					break;

				case 'type_paragraph':
					this._printElementParagraph( item );
					break;

				case 'type_description':
					this._printElementDescription( item );
					break;

				case 'type_toggle_box_start':
					this._printElementToggleBoxStart( item );
					break;

				case 'type_toggle_box_end':
					this._printElementToggleBoxEnd( item );
					break;

				case 'type_modal_start':
					this._printElementModalStart( item );
					break;

				case 'type_modal_end':
					this._printElementModalEnd( item );
					break;
			}
		},

		/*----------------------------------------------------------*/
		/* TABLE START
		/*----------------------------------------------------------*/
		_printElementTableStart : function( item ) {
			var classParam = this._getItemClassesString( item );
			this._output += '<table class="' + classParam +' form-table ff-options"><tbody>';
		},

		/*----------------------------------------------------------*/
		/* TABLE END
		/*----------------------------------------------------------*/
		_printElementTableEnd : function( item ) {
			this._output += '</tbody></table>';
		},

		/*----------------------------------------------------------*/
		/* TABLE DATA START
		/*----------------------------------------------------------*/
		_printElementTableDataStart : function( item ) {
			this._output += '<tr>';
			this._output += '<th scope="row">' + item.title + '</th>';
			this._output += '<td><fieldset>';
		},

		/*----------------------------------------------------------*/
		/* TABLE DATA END
		 /*----------------------------------------------------------*/
		_printElementTableDataEnd : function( item ) {
			this._output += '</fieldset></td></tr>';
		},


		/*----------------------------------------------------------*/
		/* NEW LINE
		 /*----------------------------------------------------------*/
		_printElementNewLine : function( item, id ) {
			this._output += '<br>';
		},


		/*----------------------------------------------------------*/
		/* HEADING
		/*----------------------------------------------------------*/
		_printElementHeading: function( item, id ) {
			var type = this._getItemParam(item, 'heading_type', 'h3');

			this._output += '<' + type + '>';
			this._output += item.title;
			this._output += '</' + type + '>';
		},

		/*----------------------------------------------------------*/
		/* PARAGRAPH
		/*----------------------------------------------------------*/
		_printElementParagraph : function( item, id ) {
			this._output += '<p>';
			this._output += item.title;
			this._output += '</p>';
		},


		/*----------------------------------------------------------*/
		/* DESCRIPTION
		/*----------------------------------------------------------*/
		_printElementDescription: function( item, id ) {
			var type = this._getItemParam( item, 'tag', 'p');
			this._output += '<' + type + ' class="description">';
			this._output += item.title;
			this._output += '</' + type + '>';
		},

		/*----------------------------------------------------------*/
		/* TOGGLE BOX START
		/*----------------------------------------------------------*/
		_printElementToggleBoxStart : function( item, id ) {

			// return;

			var isOpened = this._getItemParam( item, 'is-opened', true);

			var liClass = isOpened ? 'ff-repeatable-item-opened' : 'ff-repeatable-item-closed';
			var contentStyle = isOpened ? '' : 'display: none;';


			// console.log( item, id) ;

			var currentSectionRoute = this._cleanRoute.join(' ');


			var advancedClass = this._getItemParam(item, 'show-advanced-tools') == true ? 'ff-toggle-box-advanced' : '';

			// return;

			this._output += '<ul style="display: block;" class="ff-repeatable ff-toggle-box '+advancedClass+' ff-odd ff-repeatable-boxed" data-current-section-route="' + currentSectionRoute + '" data-section-id="'+item.id+'" data-current-level="' +  this._getCurrentRouteLevel() + '">';
			// this._output += '<li class="ff-repeatable-template-holder"></li>';
			this._output += '<li class="ff-repeatable-item ff-repeatable-item-toggle-box ' + liClass + '" style="opacity: 1;" data-current-section-route="' + currentSectionRoute + '" data-section-id="'+item.id+'">';
			this._output += '<div class="ff-repeatable-header ff-repeatable-handle-toggle-box">';
			this._output += '<table class="ff-repeatable-header-table">';
			this._output += '<tbody>';
			this._output += '<tr>';
			this._output += '<td class="ff-repeatable-item-number"></td>';
			this._output += '<td class="ff-repeatable-title">' + item.title + '</td>';
			this._output += '<td class="ff-repeatable-description"></td>';
			this._output += '</tr>';
			this._output += '</tbody>';

			if(this._getItemParam(item, 'show-advanced-tools') == true) {
				this._output += '<div class="ff-show-advanced-tools dashicons dashicons-edit"></div>';
			}

			this._output += '</table>';
			this._output += '<div class="ff-repeatable-handle "></div>';
			this._output += '</div>';
			this._output += '<div class="ff-repeatable-content" style="' + contentStyle + '">';
		},

		/*----------------------------------------------------------*/
		/* TOGGLE BOX END
		/*----------------------------------------------------------*/
		_printElementToggleBoxEnd : function( item, id ) {

			// return;
			this._output += '</div>';
			this._output += '</li>';
			this._output += '</ul>';
		},


		/*----------------------------------------------------------*/
		/* HTML
		 /*----------------------------------------------------------*/
		_printElementHtml : function( item, id ) {
			var sanitized = item.title;

			// console.log( sanitized );

			if( sanitized == null  || sanitized == undefined || sanitized == false) {
				this._output += sanitized;
			} else {
				var ret = sanitized.replace(/&gt;/g, '>');
				ret = ret.replace(/&lt;/g, '<');
				ret = ret.replace(/&quot;/g, '"');
				ret = ret.replace(/&apos;/g, "'");
				ret = ret.replace(/&amp;/g, '&');
			}

			this._output += ret;
		},

		/*----------------------------------------------------------*/
		/* HTML
		 /*----------------------------------------------------------*/
		_printElementModalStart : function( item, id ) {

			this._output += '<div class="ffb-modal-holder ' + this._getItemParam(item, 'modal-class') + '">';

			if( this._getItemParam(item, 'print-open-button', false ) ) {
				this._output += '<div class="ffb-modal-opener-button">OPEN ADVANCED SETTINGS</div>';
			}

			this._output += '<div class="ffb-modal ffb-modal-nested">';
			this._output += '<div class="ffb-modal__vcenter-wrapper">';

			this._output += '<div class="ffb-modal__vcenter ffb-modal__action-done">';
			this._output += '<div class="ffb-modal__box">';
			this._output += '<div class="ffb-modal__header">';
			this._output += '<div class="ffb-modal__name">';
			this._output += this._getItemParam(item, 'modal-name');
			this._output += '</div>';
			this._output += '</div>';
			this._output += '<div class="ffb-modal__body">';
		},
		
		/*----------------------------------------------------------*/
		/* HTML
		 /*----------------------------------------------------------*/
		_printElementModalEnd : function( item, id ) {
			this._output +='</div>';
			this._output +='<div class="ffb-modal__footer">';
			/*this._output += '<a class="ffb-modal__button-image_preview"><i class="ff-font-simple-line-icons icon-eye"></i><div class="ffb-modal__header-icon-preview-content"><img src="<?php echo ffContainer()->getWPLayer()->getFrameworkUrl(); ?>/framework/themes/builder/metaBoxThemeBuilder/assets/images/element-preview-example.jpg"></div></a>';*/
			this._output += '<a href="#" class="ffb-modal__button-save_all ffb-modal__action-save-all">Quick Save</a>';
			this._output +='<a href="#" class="ffb-modal__button-save ffb-modal__action-done">Done</a>';
			this._output +='</div>';
			this._output +='</div>';
			this._output +='</div>';
			this._output +='</div>';
			this._output +='</div>';

			this._output +='</div>';
		},


		/*----------------------------------------------------------*/
		/* HELPERS
		/*----------------------------------------------------------*/
		_getItemClassesString : function( item ) {
			var paramClasses = this._getItemParamArray(item, 'class');

			var classes = '';

			for( var id in paramClasses ) {
				classes += ' ' + paramClasses[ id ];
			}

			return paramClasses;
		}

	});

})(jQuery);
