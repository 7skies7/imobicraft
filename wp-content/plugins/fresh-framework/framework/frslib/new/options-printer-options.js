(function($){
	frslib.provide('frslib.options2');

	frslib.options2.optionsPrinterCounter = 0;

	/**
	 * Printing our options
	 */
	frslib.options2.printerOptions = frslib.options2.printerBasic.extend({
		_optionCounter : 0,

		_prepareOption: function( item, attrHelper ) {
			frslib.options2.optionsPrinterCounter++;
			item.valueEscaped = this._escAttr( item.value );

			attrHelper.setParam('name', this._getNameRoute() );
			attrHelper.setParam('class', this._getItemParamArray(item, 'class') );
			attrHelper.addParam('class', 'ff-opt-' + item.id);
			attrHelper.addParam('class', 'ff-opt-type-'+ item.type );
			attrHelper.addParam('class', 'ff-opt');
			attrHelper.addParam('id', 'ff-opt-' + frslib.options2.optionsPrinterCounter  );

			if( this._getItemParam(item, 'short', false) == true ) {
				attrHelper.addParam('class', 'input-short');
			}

			attrHelper.setParam('data-default-value', this._escAttr( item.defaultValue));

			// if( this._escAttr( item.defaultValue) != item.valueEscaped ) {
			attrHelper.setParam('data-user-value', item.valueEscaped );
			// }
			attrHelper.setParam('data-id', item.id );
			attrHelper.setParam('value', item.valueEscaped );
			attrHelper.setParam('placeholder', this._getItemParam( item, 'placeholder' ) );
			attrHelper.setParam('data-opt-type', item.type);
		},

		_cbOption: function( item ) {

			if( !this._callCallbacks ) {
				return false;
			}

			var attrHelper = this._getAttrHelper();
			this._prepareOption( item, attrHelper );


			switch ( item.type ) {
				case 'text' :
					this._printOptionText( item, attrHelper );
					break;

				case 'number':
					this._printOptionNumber( item, attrHelper );
					break;

				// case 'tinymce':
				case 'textarea':
					this._printOptionTextarea( item, attrHelper );
					break;

				case 'checkbox':
					this._printOptionTypeCheckbox( item, attrHelper );
					break;

				case 'hidden':
					this._printOptionTypeHidden( item, attrHelper );
					break;

				case 'select':
					this._printOptionTypeSelect( item, attrHelper );
					break;

                case 'select_styles':
                    this._printSelectStyles( item, attrHelper);
                    break;

                case 'select_fresh':
                    this._printSelectFresh( item, attrHelper );
                    break;

				case 'image':
					this._printOptionTypeImage( item, attrHelper );
					break;

				case 'image_gallery':
					this._printOptionTypeImageGallery( item, attrHelper );
					break;

				case 'icon':
					this._printOptionTypeIcon( item, attrHelper );
					break;

				case 'color_picker_with_lib':
					this._printOptionsTypeColorPickerWithLib( item, attrHelper );
					break;

				case 'gfont_selector':
					this._printOptionGfontSelector( item, attrHelper );
					break;

				case 'sidebar_selector':
					this._printOptionSidebarSelector( item, attrHelper );
					break;

				case 'font':
					this._printOptionFont( item, attrHelper );
					break;

				case 'post_type_selector':
					this._printPostTypeSelector( item, attrHelper );
					break;

				case 'tax_type_selector':
					this._printTaxTypeSelector( item, attrHelper );
					break;

				case 'revolution_slider':
					this._printRevoSliderSelector( item, attrHelper );
					break;
				default:
					console.log( 'OPTIONS PRINTER - missing ' + item.type + ' !');
					console.log( item );
					break;
			}
		},




		/*----------------------------------------------------------*/
		/* OPTION TEXT
		 /*----------------------------------------------------------*/
		_printOptionText:function( item, attrHelper ) {
			attrHelper.setParam('type', 'text');
			var input = '<input ' + attrHelper.getAttrString() + '>';
			this._printOptionWithLabels( input, item );
		},

		/*----------------------------------------------------------*/
		/* OPTION NUMBER
		 /*----------------------------------------------------------*/
		_printOptionNumber : function( item, attrHelper ) {
			attrHelper.setParam('type', 'number');
			attrHelper.setParam('min', this._getItemParam(item, 'min') );
			attrHelper.setParam('max', this._getItemParam(item, 'max') );
			attrHelper.setParam('step', this._getItemParam(item, 'step') );

			var input = '<input ' + attrHelper.getAttrString() + '>';
			this._printOptionWithLabels( input, item );
		},


		/*----------------------------------------------------------*/
		/* TEXTAREA
		 /*----------------------------------------------------------*/
		_printOptionTextarea: function( item, attrHelper ) {
			attrHelper.setParam('cols', this._getItemParam(item, 'cols', 30 ) );
			attrHelper.setParam('rows', this._getItemParam(item, 'rows', 5 ) );
			attrHelper.addParam('class', 'ff-options__textarea');

			var input = '';

			if( this._getItemParam(item, 'can-be-richtext', true ) ) {
				var routeTinyMCE = frslib.clone( this._route );
				routeTinyMCE = routeTinyMCE.join(' ') + '-is-richtext';
				routeTinyMCE = routeTinyMCE.split(' ');

				var tinyMCEActive = this._getRouteValue( routeTinyMCE );

				if( tinyMCEActive == null ) {
					tinyMCEActive = 0;
				}


				var richtextToggleClass = ( tinyMCEActive == 1 ) ? 'ff-richtext-toggle-enabled' : 'ff-richtext-toggle-disabled';


				input += '<div class="ff-richtext-area-wrapper ' + richtextToggleClass +'">';

				input += '<div class="ff-richtext-toggles-wrapper">'
					input += '<div class="ff-richtext-toggle-btn ff-richtext-disabled ff-mode-richtext" data-mode="richtext">Visual</div>';
                    input += '<div class="ff-richtext-toggle-btn ff-richtext-disabled ff-mode-text" data-mode="text">Text</div>';
                    input += '<div class="ff-richtext-syntax-btns-wrapper">';
	                    input += '<div class="ff-richtext-toggle-btn ff-richtext-disabled ff-mode-html ff-visible-in-text" data-mode="html">HTML</div>';
	                    input += '<div class="ff-richtext-toggle-btn ff-richtext-disabled ff-mode-php ff-visible-in-text" data-mode="php">PHP</div>';
	                    input += '<div class="ff-richtext-toggle-btn ff-richtext-disabled ff-mode-javascript ff-visible-in-text" data-mode="javascript">JS</div>';
	                    input += '<div class="ff-richtext-toggle-btn ff-richtext-disabled ff-mode-css ff-visible-in-text" data-mode="css">CSS</div>';
                    input += '</div>';

                    //input += '<div class="ff-toggle-btn-php">PHP</div>';
				input += '</div>';

				input += '<input type="hidden" class="ff-opt ff-opt-textarea-is-richtext-status-holder" value="'+ tinyMCEActive +'" name="' + this._getNameRoute(routeTinyMCE) + '">';

				attrHelper.addParam('class', 'ff-options__textarea-can-be-richtext');
				//if( tinyMCEActive == 1 ) {
				//	attrHelper.addParam('class', 'ff-options__textarea-is-richtext');
				//}

                var mode = 'text';

                switch( parseInt(tinyMCEActive) ) {
                    case 1:
                        mode = 'richtext';
                        break;
                    case 2:
                        mode = 'php';
                        break;
                    case 3:
                        mode = 'js';
                        break;
                    case 4:
                        mode = 'css';
                        break;
                }

                attrHelper.addParam('data-show-mode', mode);
                attrHelper.addParam('data-tinimce-active', tinyMCEActive);
			}

            var codeEditor = this._getItemParam(item, 'code_editor');
            if( codeEditor != null ) {
                attrHelper.addParam('class', 'ff-options__code-editor');
                attrHelper.addParam('data-code-editor-type', codeEditor );
            }

			input += '<textarea ' + attrHelper.getAttrString() +'>';
			input += item.valueEscaped;
			input += '</textarea>';
			input += '<span class="description">' + item.description + '</span>';

			if( this._getItemParam(item, 'can-be-richtext', true ) ) {
				input += '</div>';
				this._output += input;
			} else {
				this._printOptionWithLabels( input, item );
			}


		},

		/*----------------------------------------------------------*/
		/* CHECKBOX
		 /*----------------------------------------------------------*/
		_printOptionTypeCheckbox: function( item, attrHelper ) {
			attrHelper.setParam('type', 'checkbox');
			attrHelper.setParam('value', 1);

			if(  parseInt( item.value ) == 1 ) {
				attrHelper.setParam('checked', 'checked');
			}

			var nameRoute = this._getNameRoute();

			var input = '';

			input += '<input type="hidden" class="ff-checkbox-shadow" value="0" name="' + nameRoute + '" >';
			input += '<input ' + attrHelper.getAttrString() + '>';

			if( item.title != null ) {
				this._output += '<label>';
				this._output += input;
				this._output += ' ';
				this._output += item.title;
				this._output += '</label>';
			} else {
				this._output += input;
			}
		},

		/*----------------------------------------------------------*/
		/* HIDDEN
		 /*----------------------------------------------------------*/
		_printOptionTypeHidden: function( item, attrHelper ) {
			attrHelper.setParam('type', 'hidden');

			var input = '<input ' + attrHelper.getAttrString() + '>';

			this._output += input;
		},

		_printPostTypeSelector: function( item, attrHelper ) {
			var postType = this._getItemParam(item, 'post_type', 'post');//item.params['post_type'];//this._getItemParam(item, 'post_type', 'post');

			if( item.value == '' ) {
				item.value = item.defaultValue;
			}

			attrHelper.addParam('class', 'ff-post-type-selector');
			attrHelper.setParam('data-post-type', postType );
			attrHelper.setParam('disabled', 'disabled');
			item.title = item.title + ' <span class="spinner is-active"></span>';
			this._printOptionTypeSelect( item, attrHelper );

		},

		_printRevoSliderSelector: function( item, attrHelper ) {
			attrHelper.addParam('class', 'ff-revo-slider-selector');
			attrHelper.setParam('disabled', 'disabled');

			// if( this._getItemParam(item, 'multiple', true) != 'not' ) {
			// 	attrHelper.setParam('multiple', 'multiple');
			// }

			item.title = item.title + ' <span class="spinner is-active"></span>';
			this._printOptionTypeSelect( item, attrHelper );
		},

		_printTaxTypeSelector: function( item, attrHelper ) {
			var taxType = this._getItemParam(item, 'tax_type', 'category');//item.params['post_type'];//this._getItemParam(item, 'post_type', 'post');

			// alert( taxType );

			attrHelper.addParam('class', 'ff-tax-type-selector');
			attrHelper.setParam('data-tax-type', taxType );
			attrHelper.setParam('disabled', 'disabled');

			if( this._getItemParam(item, 'multiple', true) != 'not' ) {
				attrHelper.setParam('multiple', 'multiple');
			}

			item.title = item.title + ' <span class="spinner is-active"></span>';
			this._printOptionTypeSelect( item, attrHelper );

		},

		/*----------------------------------------------------------*/
		/* SELECT
	 	/*----------------------------------------------------------*/
		_printOptionTypeSelect: function( item, attrHelper ) {

			var selectValues = item.selectValues;
			var selectedValue = item.value;
			var isGroup = this._getItemParam( item, 'is_group', false);

			var selectValuesHTML = this._getSelectValues( selectValues, selectedValue, isGroup );

			var input = '';

			input += '<select ' + attrHelper.getAttrString() + '>';
			input += selectValuesHTML;
			input += '</select>';

			this._printOptionWithLabels( input, item );
		},
        /*----------------------------------------------------------*/
        /* SELECT STYLE
        /*----------------------------------------------------------*/
        _printSelectStyles: function( item, attrHelper ) {
            this._setItemParam(item, 'selectModalTitle', 'Style Groups' );
            attrHelper.addParamEsc('class', 'ff-style-select');
            this._printSelectFresh( item, attrHelper, true );
        },

        /*----------------------------------------------------------*/
        /* FRESH SELECT
        /*----------------------------------------------------------*/
        _printSelectFresh: function( item, attrHelper, notInitialize ) {
            var input = '';

            var selectModalTitle = this._getItemParam(item, 'selectModalTitle', '');
            var savingType = this._getItemParam(item, 'saving_type', 'freshformat'); // json
            var placeholder = this._getItemParam(item, 'placeholder', 'Not Selected'); // json
            // name, manually, name-only, manually-only
            var orderingType = this._getItemParam(item, 'orderingType', 'name');

            var selectValues = JSON.stringify(item.selectValues);

            //console.log( selectValues );

            if( selectValues == null || selectValues == 'null' ) {
                selectValues = '{}';
            }

            //console.log( selectValues );

            attrHelper.addParamEsc('data-select-values', selectValues);
            attrHelper.addParamEsc('data-saving-type', savingType);
            attrHelper.addParamEsc('class', 'ff-fresh-select-input');
            attrHelper.addParamEsc('data-ordering-type', orderingType);
            attrHelper.addParamEsc('data-select-modal-title', selectModalTitle );


            var notInitializeClass = '';
            if( notInitialize ) {
                notInitializeClass = 'ff-advanced-select-modal__not-initialize'
            }

            input += '<div class="ff-advanced-select-modal '+notInitializeClass+'">';
            input += '<div class="ff-advanced-select-modal__inside">';
            input += '<input ' + attrHelper.getAttrString() + '>';
            input += '<div class="ff-advanced-select-modal__selected-items">';
            input += '<div class="ff-advannced-select-modal__one-item"></div>';
            input += '</div>';
            input += '<div class="ff-advanced-select-modal__placeholder"></div>';
            input += '</div>';
            input += '</div>';

            //this._printOptionWithLabels( input, item );

            this._output += input;

            return;
        },

		/*----------------------------------------------------------*/
		/* IMAGE
		 /*----------------------------------------------------------*/
		_printOptionTypeImage: function( item, attrHelper ) {


			var value = item.value;
			var label = item.title == null ? 'Select Image' : item.title;


			// default value
			if( value == '' ) {
				value = this._getImageDefaultValue();
			} else {
				try {
					value = JSON.parse( value );

				} catch( e ) {

					try {
						value = JSON.parse (item.value.replace(/\\(.)/mg, "$1") );
					} catch ( e ) {
						value = this._getImageDefaultValue();
					}
				}
			}


			if( ff_fw_developer_mode == false ) {
				if( value.substitute != undefined ) {
					value = value.substitute;
				}
			}


			if( value.id == -1 ) {
				value.url = ff_ark_core_plugin_url + '/builder/placeholders/' + value.url;
			}

			var imgUrlIsEmpty = (this._escAttr( value.url ) == '' ) ? 'ff-empty' : '';

			var forcedDimensionsAttrHelper = this._getAttrHelper();
			forcedDimensionsAttrHelper.setParam('data-forced-width', this._getItemParam( item, 'data-forced-width', '') );
			forcedDimensionsAttrHelper.setParam('data-forced-height', this._getItemParam( item, 'data-forced-height', '') );

			var input = '';

			input +=  '<span class="ff-open-library-button-wrapper ff-open-image-library-button-wrapper-new ' + imgUrlIsEmpty + '">';
			input +=  '<a class="ff-open-library-button ff-open-image-library-button-new" ' + forcedDimensionsAttrHelper.getAttrString() + '>';
			input +=  '<span class="ff-open-library-button-preview">';
			input +=  '<span class="ff-open-library-button-preview-image" style="background-image:url(\'' + this._escAttr( value.url ) + '\');">';
			input +=  '</span>';
			input +=  '</span><span class="ff-open-library-button-title">' + label + '</span>';

			attrHelper.addParam('class', 'ff-image');
			attrHelper.addParam('type', 'hidden');
			input +=  '<input ' + attrHelper.getAttrString() + '>';
			input +=  '<span class="ff-open-library-button-preview-image-large-wrapper">';
			// input +=  '<img class="ff-open-library-button-preview-image-large" src="'  + _.escapeValue( value.url ) + '" width="'+ value.width + '" height="'+ value.height + '">';
			input +=  '<img class="ff-open-library-button-preview-image-large" src="'  + this._escAttr( value.url ) + '" width="'+ 300 + '" >';
			input +=  '</span>';
			input +=  '</a>';
			input +=  '<a class="ff-open-library-remove" title="Clear"></a>';

			if( ff_fw_developer_mode ) {
				input +=  '&nbsp;&nbsp;<a class="ff-default-content-img">DEFAULT</a>';
				input +=  '&nbsp;&nbsp;<a class="ff-substitute-content-img">SUBSTITUTE</a>';

				var substituteImgUrl = '';
				if( value.substitute != undefined ) {
					substituteImgUrl =  value.substitute.url;
				}

				input += '&nbsp;&nbsp;<img class="ff-substitute-img" src="' + ff_ark_core_plugin_url + '/builder/placeholders/' + substituteImgUrl +'" width="25" height="25">';
			}

			input +=  '</span>';

			var labelAfter = this._getItemParam(item, 'PARAM_TITILE_AFTER');
			var description = item.description;

			if( description == null && labelAfter == null ) {
				this._output += input;
			} else {
				if( labelAfter == null ) {
					labelAfter = '';
				}

				this._output += '<label>';
				this._output += description;
				this._output += ' ';
				this._output += input;
				this._output += ' ';
				this._output += labelAfter;
				this._output += '</label>';
			}
		},

		_getImageGalleryDefaultValue: function() {
			var defaultValue = [];

			return defaultValue;
		},

		_printOptionTypeImageGallery: function( item, attrHelper ) {
			var value = item.value;

			if( value == '' ) {
				value = this._getImageGalleryDefaultValue();
			} else {
				try {
					value = JSON.parse( value );

				} catch( e ) {

					try {
						value = JSON.parse (item.value.replace(/\\(.)/mg, "$1") );
					} catch ( e ) {
						value = this._getImageGalleryDefaultValue();
					}
				}
			}

			var input = '';

			input += '<div class="ff-image-gallery-wrapper">';
				attrHelper.addParam('class', 'ff-image');
				attrHelper.addParam('type', 'hidden');
				input +=  '<input ' + attrHelper.getAttrString() + '>';
				input += '<div class="ff-image-gallery__content clearfix">';
				input += '</div>';
				input += '<div class="ff-image-gallery_add-button"></div>';
			input += '</div>';

			this._output += input;
		},


		/*----------------------------------------------------------*/
		/* ICON
		 /*----------------------------------------------------------*/
		_printOptionTypeIcon: function( item, attrHelper ) {
			var label = item.title == null ? 'Select Icon' : item.title;

			attrHelper.setParam('data-autofilter', this._getItemParam( item, 'data-autofilter', '') );
			attrHelper.addParam('class', 'ff-icon');
			attrHelper.setParam('type', 'hidden');

			var input = '';
			input += '<span class="ff-open-icon-library-button-wrapper">';
			input += '<a class="ff-open-library-button ff-open-library-icon-button">';
			input += '<span class="ff-open-library-button-preview">';

			input += '<i class="' + item.value + '"></i>';

			input += '</span>';
			input += '<span class="ff-open-library-button-title">' + label + '</span>';
			input += '<input ' + attrHelper.getAttrString() + '>';

			input += '</a>';
			input +=  '<a class="ff-open-library-remove" title="Clear"></a>';
			input += '</span>';

			this._output += input;

		},

		/*----------------------------------------------------------*/
		/* COLOR PICKER WITH LIB
		 /*----------------------------------------------------------*/
		_printOptionsTypeColorPickerWithLib: function( item, attrHelper ) {

			item.value = ( item.value == 'null' || item.value == null ) ? '' : item.value;
			item.defaultValue = ( item.defaultValue == 'null' || item.defaultValue == null ) ? '' : item.defaultValue;

			// additional hardcoded reset
			item.valueEscaped = this._escAttr( item.value );
			attrHelper.setParam('data-default-value', this._escAttr( item.defaultValue));
			attrHelper.setParam('value', item.valueEscaped );

			attrHelper.setParam('type', 'hidden');

			if( this._getItemParam(item, 'locked-library', false) ) {
				attrHelper.setParam('data-locked-library', '1');
			} else {
				attrHelper.setParam('data-locked-library', '0');
			}

			var hiddenInput = '<input ' + attrHelper.getAttrString() + '>';

			var backgroundColor = item.value;
			var colorInputText = '';
			var isResetClass = '';

			if( backgroundColor == null || backgroundColor == '' ) {
				isResetClass = 'fftm__option-type__is-reset';
			}

			if( backgroundColor != null && backgroundColor.indexOf('[') != -1 ) {
				var colorIndex = backgroundColor.replace('[', '').replace(']', '').trim();
				colorInputText = colorIndex;
				backgroundColor = '#ffffff';
				if( ff_fw_is_ark ) {
					var colorLibrary = window.frs_theme_color_library;
					var colorObject = colorLibrary[colorIndex];
					backgroundColor = colorObject.color;
				}
			}

			var labelAfter = this._getItemParam(item, 'PARAM_TITILE_AFTER');

			var contrastClass = frslib.colors.contrast( backgroundColor );

			var input = '';
			input +='<label class="fftm__option-type--color-picker__label">';
			input += item.title + ' ';
			input +='<div class="fftm__option-type--color-picker fftm__option-type__can-reset '+ isResetClass +' clearfix">';
			input +='<div class="fftm__option-type--color-picker__select">';
			input +='<div class="fftm__option-type--color-picker__select-preview-color" data-color="' + backgroundColor + '" style="background:'+ backgroundColor +'; color:'+contrastClass+';">'+colorInputText+'</div>';
			input += hiddenInput;

			input +='</div>';
			input +='<div class="fftm__option-type__reset"></div>';
			input +='</div>';

			if( labelAfter != null && labelAfter != 'null' ) {
				input += labelAfter;
			}

			input +='</label>';

			this._output += input;
		},

		_printOptionFont: function( item, attrHelper ) {

			var defaultFonts = [];

			defaultFonts["Arial"] = "Arial, Helvetica, sans-serif";
			defaultFonts["Arial Black"] = "'Arial Black', Gadget, sans-serif";
			defaultFonts["Comic Sans MS"] = "'Comic Sans MS', cursive, sans-serif";
			defaultFonts["Courier New"] = "'Courier New', Courier, monospace";
			defaultFonts["Georgia"] = "Georgia, serif";
			defaultFonts["Helvetica"] = "Helvetica, sans-serif";
			defaultFonts["Impact"] = "Impact, Charcoal, sans-serif";
			defaultFonts["Lucida Console"] = "'Lucida Console', Monaco, monospace";
			defaultFonts["Lucida Sans Unicode"] = "'Lucida Sans Unicode', 'Lucida Grande', sans-serif";
			defaultFonts["Palatino Linotype"] = "'Palatino Linotype', 'Book Antiqua', Palatino, serif";
			defaultFonts["Times New Roman"] = "'Times New Roman', Times, serif";
			defaultFonts["Tahoma"] = "Tahoma, Geneva, sans-serif";
			defaultFonts["Trebuchet MS"] = "'Trebuchet MS', Helvetica, sans-serif";
			defaultFonts["Verdana"] = "Verdana, Geneva, sans-serif";

			var selectValues = item.selectValues;
			selectValues[ 'Web Safe Fonts'] = [];
			for( var i in defaultFonts ) {
				var newFont = {};

				newFont.name = i;
				newFont.value = defaultFonts[ i ];

				selectValues['Web Safe Fonts'].push( newFont );
			}

			var fontAjaxUrl = this._getItemParam(item, 'font-ajax-url', null);

			attrHelper.addParam('data-font-ajax-url', this._escAttr( fontAjaxUrl ) );

			selectValues['Google Fonts'] = [];

			// console.log( this._getItemParam(item, 'custom_group' ) );
			// console.log( 'xxxx');

			item.selectValues = selectValues;
			this._setItemParam( item, 'is_group', true);

			this._output += '<div class="ff-font-option-holder">';

			this._printOptionTypeSelect(item, attrHelper );

			this._output += '<div class="ff-font-example">';

			this._output +=  '<h1 class="font-example">Grumpy wizards make toxic brew for the evil Queen and Jack.</h1>';
			this._output +=  '<p class="font-example">';
			this._output +=  'Grumpy wizards make toxic brew for the evil Queen and Jack.<br/>';
			this._output +=  'Latin Extended: D&#232;s No&#235;l o&#249; un z&#233;phyr ha&#239; me v&#234;t de gla&#231;ons w&#252;rmiens je d&#238;ne d&#8217;exquis r&#244;tis de b&#339;uf au kir &#224; l&#8217;a&#255; d&#8217;&#226;ge m&#251;r & c&#230;tera.<br/>';
			this._output +=  'Cyrillic Extended: &#1042; &#1095;&#1072;&#1097;&#1072;&#1093; &#1102;&#1075;&#1072; &#1078;&#1080;&#1083; &#1073;&#1099; &#1094;&#1080;&#1090;&#1088;&#1091;&#1089;? &#1044;&#1072;, &#1085;&#1086; &#1092;&#1072;&#1083;&#1100;&#1096;&#1080;&#1074;&#1099;&#1081; &#1101;&#1082;&#1079;&#1077;&#1084;&#1087;&#1083;&#1103;&#1088;!<br/>';
			this._output +=  'Greek Extended: &#932;&#940;&#967;&#953;&#963;&#964;&#951; &#945;&#955;&#974;&#960;&#951;&#958; &#946;&#945;&#966;&#942;&#962; &#968;&#951;&#956;&#941;&#957;&#951; &#947;&#951;, &#948;&#961;&#945;&#963;&#954;&#949;&#955;&#943;&#950;&#949;&#953; &#965;&#960;&#941;&#961; &#957;&#969;&#952;&#961;&#959;&#973; &#954;&#965;&#957;&#972;&#962;<br/>';
			this._output +=  'Vietnamese: T&#244;i c&#243; th&#7875; &#259;n th&#7911;y tinh m&#224; kh&#244;ng h&#7841;i g&#236;.T&#244;i c&#243; th&#7875; &#259;n th&#7911;y tinh m&#224; kh&#244;ng h&#7841;i g&#236;.<br/>';
			this._output +=  'East Europe Latin: P&#345;&#237;&#353;ern&#283; &#382;lu&#357;ou&#269;k&#253; k&#367;&#328; &#250;p&#283;l &#271;&#225;belsk&#233; &#243;dy.<br/>';
			this._output +=  '</p>';
			this._output +=  '</label>';

			this._output += '</div>';


			this._output += '</div>';
		},

		_printOptionGfontSelector: function( item, attrHelper ) {

			var newItem = frslib.clone( item );
			attrHelper.setParam('disabled', 'disabled');
			newItem.title = newItem.title + ' <span class="spinner is-active"></span>';

			var newSelectValue = {};
			newSelectValue.name = newItem.value;
			newSelectValue.value = newItem.value;

			newItem.selectValues.push( newSelectValue );
			// console.log( item );
			// item.addSelectValue

			// alert( item.value );


			this._printOptionTypeSelect( newItem, attrHelper );

		},

		_printOptionSidebarSelector: function( item, attrHelper ) {

			var newItem = frslib.clone( item );
			attrHelper.setParam('disabled', 'disabled');
			newItem.title = newItem.title + ' <span class="spinner is-active"></span>';

			var newSelectValue = {};
			newSelectValue.name = newItem.value;
			newSelectValue.value = newItem.value;

			newItem.selectValues.push( newSelectValue );

			this._printOptionTypeSelect( newItem, attrHelper );
		},
	//
	// 	// _printOption
	// 	_.printOptionGfontSelector = function( item, id, nameRoute ) {
	// 	var labelAfter = _.getItemParam(item, 'PARAM_TITILE_AFTER');
	// 	var input = '';
	//
	// 	var multiple = '';
	// 	var selectedValue = item.value;
	//
	// 	var selectValues = item.selectValues;
	//
	// 	// var data = {};
	//
	// 	var postType = _.getItemParamArray(item, 'post_type');
	//
	// 	input += '<div class="ff-select2-wrapper">';
	// 	input += '<label>';
	// 	input += '<select ' + multiple + ' size="1" data-selected-value="' + selectedValue + '" class="ff-option-gfont-selector" name="' + nameRoute +'" '+' data-default-value="' + item.defaultValue + '" >';
	//
	// 	for( var i in selectValues ) {
	// 		var oneValue = selectValues[i];
	// 		var selected = '';
	//
	// 		if( oneValue.value == selectedValue ) {
	// 			selected = ' selected="selected" ';
	// 		}
	//
	// 		input += '<option value="' + oneValue.value + '" ' + selected + '>' + oneValue.name + '</option>';
	//
	// 	}
	//
	// 	input += '</select>';
	// 	input += '&nbsp;&nbsp;&nbsp;' + labelAfter;
	// 	input += '</label>';
	//
	// 	input += '</div>';
	//
	// 	_.output += input;
	//
	// 	return input;
	// }

		_getImageDefaultValue: function() {
			var defaultValue = {};
			defaultValue.url = '';
			defaultValue.id = '';
			defaultValue.width = 0;
			defaultValue.height = 0;

			return defaultValue;
		},

		_getSelectValues: function( selectValues, selectedValue, isGroup ) {
			var toReturn = '';

			// group select values
			if( isGroup != true ) {
				for( var i in selectValues ) {
					var oneValue = selectValues[ i ];
					var selected =  ( oneValue.value == selectedValue ) ? ' selected="selected" ' : ' ';

					toReturn += '<option value="' + this._escAttr(oneValue.value) +'" ' + selected + '>' + oneValue.name +'</option>';
				}
			}
			// actually is group
			else {
				for( var groupName in selectValues ) {
					var groupId = frslib.stringToId( groupName );
					toReturn += '<optgroup label="' + groupName + '" class="' + groupId + '">';

					var oneGroup = selectValues[ groupName ];

					toReturn += this._getSelectValues( oneGroup, selectedValue );

					toReturn += '</optgroup>';
				}
			}

			return toReturn;
		},

		_printOptionWithLabels: function( itemText, item ) {
			if( this._getItemParam(item, 'no-wrapping', false) ) {
				this._output += itemText;
				return;
			}

			if( this._getItemParam(item, 'fullwidth') ) {
				this._output += '<label class="ff-input-wideflex__label">';
				if( item.title != null ) {

					this._output += '<div class="ff-input-wideflex__label-text">' + item.title + '</div>';
				}

				this._output += itemText;

				if( this._getItemParam(item, 'PARAM_TITILE_AFTER') != null ) {
					this._output += '<div class="ff-input-wideflex__input-wrapper">' + this._getItemParam(item, 'PARAM_TITILE_AFTER', '') + '</div>';
				}
				this._output += '</label>';
			} else {
				if( item.title != null ) {
					this._output += '<label class="ff-opt-label-'+item.type+'">';
					this._output += item.title;
				}

				this._output += itemText;

				this._output += this._getItemParam(item, 'PARAM_TITILE_AFTER', '');
				if( item.title != null ) {
					this._output += '</label>';
				}
			}

		},


		_getNameRoute: function( route ) {
			var nameRoute = '';
			var currentValue;

			if( route == undefined ) {
				route = this._route;
			}

			for( var i in route ) {
				if( route[ i ]. split( '-|-').length == 2 ) {
					var itemIndex = i;
					var itemName = route[ i ].split( '-|-').pop();

					currentValue = '-_-'+ itemIndex +'-TEMPLATE-_--|-' + itemName;
				} else {
					currentValue = route[ i ];
				}
				nameRoute += '[' + currentValue + ']';
			}
			nameRoute = this._prefix + nameRoute;

			return nameRoute;
		},

	});

})(jQuery);
