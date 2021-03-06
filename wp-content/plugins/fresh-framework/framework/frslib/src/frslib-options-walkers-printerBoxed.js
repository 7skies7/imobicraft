(function($){
    frslib.provide('frslib.options');
    frslib.provide('frslib.options.walkers');

    frslib.options.walkers.printerBoxed = function() {
        var _ = {};
        var walker = frslib.options.walkers.walker();

/**********************************************************************************************************************/
/* PRIVATE VARIABLES
/**********************************************************************************************************************/
        _.output = '';

        _.$output = null;

        _.walker = walker;
        walker.ignoreData = true;

        
        _.setStructureString = walker.setStructureString;
        _.setStructureJSON = walker.setStructureJSON;
        _.setDataString = walker.setDataString;
        _.setDataJSON = walker.setDataJSON;
        _.setIgnoreHideDefault = walker.setIgnoreHideDefault;

        _.getCurrentRouteCount = function() {
            return Object.keys(_.walker.idRoute).length;
        }

        _.setPrefix = walker.setPrefix;

        _.walk = function() {
            _.output = '';
            walker.walk();

            //_.$output = $(_.output);

            //console.log(_.output );

            return _.output;
        }

        _.$output = null;
        _.getJqueryOutput = function () {

            if(_.$output == null ) {
                var $n = $('<div></div>');

                $n.html(_.output);

                _.$output = $n; //$(_.output);
            }



            return _.$output;
        }


		walker.callbackGetEmptyRepeatableVariationEnd = function() {
			_.output += '<li class="ff-repeatable-item ff-repeatable-item-js ff-repeatable-item-empty-add ff-repeatable-item-empty-add-ffb">' +
				'<div class="ff-repeatable-add-ffb ff-repeatable-add-above ff-repeatable-add-above-js" title="Add Item"></div>' +
				// '<div class="ff-repeatable-header ff-repeatable-drag ff-repeatable-handle ui-sortable ui-sortable-handle">' +

				'<div class="ff-popup-container">' +
				'<div class="ff-popup-wrapper">' +
				'<div class="ff-popup-backdrop"></div>' +
				'<ul class="ff-popup ff-repeatable-add-variation-selector-popup">' +
				'<li class="ff-popup-button-wrapper"><div class="ff-popup-button">Placeholder</div></li>' +
				'</ul>' +
				'</div>' +
				'</div>' +


				// '</div>' +
				'</li>';
		}


/**********************************************************************************************************************/
/* ROUTE AND QUERYING
/**********************************************************************************************************************/

        _.getChildSections = function( route ) {

            var $result = _.getJqueryOutput();

            var $parentUl = $result.find('li[data-current-section-route="'+route+'"]').parents('.ff-repeatable-js:first');


            var sections = new Array();

            $parentUl.children('li').not('.ff-repeatable-item-empty-add').each(function() {
                var newSection = {};
                newSection.name = $(this).attr('data-section-name');
                newSection.id = $(this).attr('data-section-id');
                newSection.route = $(this).attr('data-current-section-route');

                sections.push(newSection);
            });

            return sections;

        }

        _.getChildSectionsParentUl = function( route ) {

            var $result = _.getJqueryOutput();

            var $parentUl = $result.find('li[data-current-section-route="'+route+'"]').parents('.ff-repeatable-js:first');

            return $parentUl;
        }

        _.getSection = function( route, id ) {


            var $result = _.getJqueryOutput();

            var $li = $result.find('li[data-section-id="'+id+'"]').filter('li[data-current-section-route="'+route+'"]');

            return $li;
        }

/**********************************************************************************************************************/
/* ITEM HELPERS
/**********************************************************************************************************************/
        _.escapeValue = function( value ) {
            value = value.split('&').join('&amp;');
            value = value.split('<').join('&lt;');
            value = value.split('>').join('&gt;')
            value = value.split('"').join('&quot;')
            value = value.split("'").join('&apos;');

            return value;
        }

        _.getItemParam = function ( item, param, defaultValue ) {
            if( item == null ) {
                return null;
            }
            if( item.params == undefined || item.params == null ) {
               if( defaultValue != undefined) {
                    return defaultValue;
                } else {
                    return null;
                }
            }
            if( item.params[param] != undefined &&  item.params[param] != null ) {
                return item.params[param][0];
            } else {
                if( defaultValue != undefined) {
                    return defaultValue;
                } else {
                    return null;
                }
            }
        }
        _.getItemParamArray = function( item, param ) {
            if( item.params == undefined || item.params == null ) {
                return null;
            }
            if( item.params[param] != undefined && item.params[param] != null ) {
                return item.params[param];
            } else {
                return null;
            }
        }
/**********************************************************************************************************************/
/* OPTIONS & ELEMENTS FUNCTIONS
/**********************************************************************************************************************/
        _.getItemClassesString = function( item ) {
            var paramClasses = _.getItemParamArray(item, 'class');

            var classes = '';

            for( var id in paramClasses ) {
                classes += ' ' + paramClasses[ id ];
            }

            return paramClasses;
        }

        _.getItemCols = function( item ) {
            var cols = _.getItemParam('cols');

            if( cols != null ) {
                return ' cols="'+cols+'"';
            } else {
                return ' cols="30"';
            }
        }

        _.getItemRows = function( item ) {
            var cols = _.getItemParam('rows');

            if( cols != null ) {
                return ' rows="'+rows+'"';
            } else {
                return ' rows="5"';
            }
        }

        _.getItemCheckedCheckBox = function( item ) {
            if( parseInt( item.value ) == 1 ) {
                return ' checked="checked" ';
            } else {
                return '';
            }
        }

/**********************************************************************************************************************/
/* ELEMENTS
/**********************************************************************************************************************/
        walker.setCallbackOneElement(function(item, id){
            switch( item.type ) {
                case 'type_table_start':
                    _.printElementTableStart( item, id );
                    break;

                case 'type_table_end':
                    _.printElementTableEnd(item, id );
                    break;

                case 'type_table_data_start':
                    _.printElementTableDataStart( item, id);
                    break;

                case 'type_table_data_end':
                    _.printElementTableDataEnd( item, id );
                    break;

                case 'type_new_line':
                    _.printElementNewLine( item, id );
                    break;

                case 'type_html':
                    _.printElementHtml( item, id );
                    break;

                case 'type_heading':
                    _.printElementHeading( item, id );
                    break;

                case 'type_paragraph':
                    _.printElementParagraph( item, id );
                    break;

                case 'type_description':
                    _.printElementDescription( item, id );
                    break;

                case 'type_toggle_box_start':
                    _.printElementToggleBoxStart( item, id );
                    break;

                case 'type_toggle_box_end':
                    _.printElementToggleBoxEnd( item, id );
                    break;
            }
        });

        /*----------------------------------------------------------*/
        /* TABLE START
        /*----------------------------------------------------------*/
        _.printElementTableStart =  function( item, id ){
            var classParam = _.getItemClassesString( item );

            _.output += '<table class="' + classParam +' form-table ff-options"><tbody>';

        };


        /*----------------------------------------------------------*/
        /* TABLE END
        /*----------------------------------------------------------*/
        _.printElementTableEnd =  function( item, id ){
            _.output += '</tbody></table>';
        };


        /*----------------------------------------------------------*/
        /* TABLE DATA START
        /*----------------------------------------------------------*/
        _.printElementTableDataStart = function( item, id ) {
            _.output += '<tr>';
            _.output += '<th scope="row">' + item.title + '</th>';
            _.output += '<td><fieldset>';

        }

        /*----------------------------------------------------------*/
        /* TABLE DATA END
        /*----------------------------------------------------------*/
        _.printElementTableDataEnd = function( item, id ) {
            _.output += '</fieldset></td></tr>';
        }

        /*----------------------------------------------------------*/
        /* NEW LINE
        /*----------------------------------------------------------*/
        _.printElementNewLine = function( item, id ) {
            _.output += '<br>';
        }


        /*----------------------------------------------------------*/
        /* HEADING
        /*----------------------------------------------------------*/
        _.printElementHeading = function( item, id ) {
            var type = _.getItemParam('heading_type');
            if( type == null ) {
                type = 'h3';
            }

            _.output += '<' + type + '>';
            _.output += item.title;
            _.output += '</' + type + '>';
        }

        /*----------------------------------------------------------*/
        /* PARAGRAPH
        /*----------------------------------------------------------*/
        _.printElementParagraph = function( item, id ) {
            _.output += '<p>';
            _.output += item.title;
            _.output += '</p>';
        }


        /*----------------------------------------------------------*/
        /* DESCRIPTION
        /*----------------------------------------------------------*/
        _.printElementDescription= function( item, id ) {
            var type = _.getItemParam( item, 'tag', 'p');
            _.output += '<' + type + ' class="description">';
            _.output += item.title;
            _.output += '</' + type + '>';
        }

        /*----------------------------------------------------------*/
        /* TOGGLE BOX START
        /*----------------------------------------------------------*/
        _.printElementToggleBoxStart = function( item, id ) {

			var isOpened = _.getItemParam( item, 'is-opened', true);

			var liClass = isOpened ? 'ff-repeatable-item-opened' : 'ff-repeatable-item-closed';
			var contentStyle = isOpened ? '' : 'display: none;';


			// console.log( item, id) ;

			var currentSectionRoute = _.walker.getCurrentSectionRoute() + ' ' + item.id ;


			var advancedClass = _.getItemParam(item, 'show-advanced-tools') == true ? 'ff-toggle-box-advanced' : '';

            _.output += '<ul style="display: block;" class="ff-repeatable ff-toggle-box '+advancedClass+' ff-odd ff-repeatable-boxed " data-current-section-route="' + currentSectionRoute + '" data-section-id="'+item.id+'" data-current-level="' +  _.getCurrentRouteCount() + '">';
                // _.output += '<li class="ff-repeatable-template-holder"></li>';
                _.output += '<li class="ff-repeatable-item ff-repeatable-item-toggle-box ' + liClass + '" style="opacity: 1;">';
                    _.output += '<div class="ff-repeatable-header ff-repeatable-handle ff-repeatable-handle-toggle-box">';
                        _.output += '<table class="ff-repeatable-header-table">';
                            _.output += '<tbody>';
                            _.output += '<tr>';
                                _.output += '<td class="ff-repeatable-item-number"></td>';
                                _.output += '<td class="ff-repeatable-title">' + item.title + '</td>';
                                _.output += '<td class="ff-repeatable-description"></td>';
                            _.output += '</tr>';
                            _.output += '</tbody>';

							if(_.getItemParam(item, 'show-advanced-tools') == true) {
								_.output += '<div class="ff-show-advanced-tools dashicons dashicons-edit"></div>';
							}

                        _.output += '</table>';
                        _.output += '<div class="ff-repeatable-handle "></div>';
                    _.output += '</div>';
                    _.output += '<div class="ff-repeatable-content" style="' + contentStyle + '">';
        }

        /*----------------------------------------------------------*/
        /* TOGGLE BOX END
        /*----------------------------------------------------------*/
        _.printElementToggleBoxEnd = function( item, id ) {
                    _.output += '</div>';
                _.output += '</li>';
            _.output += '</ul>';
        }


        /*----------------------------------------------------------*/
        /* HTML
        /*----------------------------------------------------------*/
        _.printElementHtml = function( item, id ) {
            var sanitized = item.title;

			if( sanitized == null  ) {
				_.output += sanitized;
			} else {
				var ret = sanitized.replace(/&gt;/g, '>');
				ret = ret.replace(/&lt;/g, '<');
				ret = ret.replace(/&quot;/g, '"');
				ret = ret.replace(/&apos;/g, "'");
				ret = ret.replace(/&amp;/g, '&');
			}


            _.output += ret;
        }

/**********************************************************************************************************************/
/* OPTION
/**********************************************************************************************************************/
        /*----------------------------------------------------------*/
        /* GET PLACEHOLDER
        /*----------------------------------------------------------*/
        _.getPlaceholder = function( item ) {
            var placeholder = _.getItemParam( item, 'placeholder');

            if( placeholder != null ) {
                return ' placeholder="' + placeholder + '" ';
            } else {
                return '';
            }
        }


        _.missingOptions = {};

        walker.setCallbackOneOption(function(item, id, nameRoute ){
            switch( item.type ) {
                case 'text' :
                    _.printOptionText(item, id, nameRoute );
                    break;

                case 'number' :
                    _.printOptionNumber(item, id, nameRoute );
                    break;


                case 'textarea' :
                    _.printOptionTextarea(item, id, nameRoute );
                    break;

				case 'tinymce' :
					_.printOptionTinyMCE( item, id, nameRoute );
					break;

                case 'checkbox' :
                    _.printOptionCheckbox( item, id, nameRoute );
                    break;

				case 'hidden' :
					_.printOptionHidden( item, id, nameRoute );
					break;

                case 'image' :
                    _.printOptionImage( item, id, nameRoute);
                    break;

                case 'icon' :
                    _.printOptionIcon( item, id, nameRoute );
                    break;

                case 'select' :
                    _.printOptionSelect( item, id, nameRoute );
                    break;






                case 'select2' :
                    _.printOptionSelect2( item, id, nameRoute );
                    break;
                case 'navigation_menu_selector' :
                    _.printOptionNavigationMenuSelector( item, id, nameRoute );
                    break;

                case 'color_picker_wp' :
                    item.params = {};
                    item.params['class'] ='ff-default-wp-color-picker';
                    _.printOptionText(item, id, nameRoute );
                    break;

				case 'post_type_selector':
					_.printOptionPostTypeSelector( item, id, nameRoute );
					break;

				case 'gfont_selector':
					_.printOptionGfontSelector( item, id, nameRoute )
					break;


				case 'tax_type_selector':
					_.printOptionTaxTypeSelector( item, id, nameRoute );
					break;

				case 'color_picker_with_lib':
					_.printOptionColorPickerWithLib( item, id, nameRoute );
					break;

                default :

                    _.output += '<span style="color:red">' + item.type + ' MISSING - javascript options printer </span>';
                    _.missingOptions[ item.type ] = 1;

                    console.log(_.missingOptions );
                    break;

            }
        });


		_.printOptionColorPickerWithLib = function( item, id, nameRoute ) {

			if( item.value == 'null' ) {
				item.value = '';
			}

			if( item.value == null ) {
				item.value = '';
			}

			if( item.defaultValue== 'null' ) {
				item.defaultValue= '';
			}

			if( item.defaultValue== null ) {
				item.defaultValue= '';
			}

            var hiddenInput = '';
            hiddenInput += '<input type="hidden" ';
            hiddenInput += ' name="' + nameRoute + '" ';
            hiddenInput += ' class=" fftm__option-type--input"';
            hiddenInput += ' value="' + item.value + '" ';
            hiddenInput += '>';



			var backgroundColor = item.value;

			var colorInputText = '';

			var isResetClass = '';

			if( backgroundColor == null || backgroundColor == '' ) {
				isResetClass = 'fftm__option-type__is-reset';
			}

			if( backgroundColor != null && backgroundColor.indexOf('[') != -1 ) {
				var colorIndex = backgroundColor.replace('[', '').replace(']', '');
				colorInputText = colorIndex;
				var colorLibrary = window.ffbuilder.appInstance.colorLibrary;

				var colorObject = colorLibrary[ colorIndex ];

				backgroundColor = colorObject.color;
			}

			var labelAfter = _.getItemParam(item, 'PARAM_TITILE_AFTER');


            var input = '';
            input +='<label class="fftm__option-type--color-picker__label">';
			input += item.title + ' ';
            input +='<div class="fftm__option-type--color-picker fftm__option-type__can-reset '+ isResetClass +' clearfix">';
                input +='<div class="fftm__option-type--color-picker__select">';
                    input +='<div class="fftm__option-type--color-picker__select-preview-color" data-color="' + backgroundColor + '" style="background:'+ backgroundColor +'">'+colorInputText+'</div>';
                    input += hiddenInput;

                input +='</div>';
                input +='<div class="fftm__option-type__reset"></div>';
            input +='</div>';

			if( labelAfter != null && labelAfter != 'null' ) {
				input += labelAfter;
			}

            input +='</label>';

            _.output += input;
		};


		_.printOptionTaxTypeSelector = function(item, id, nameRoute) {


			if( item.value.indexOf('||tax-s||') == -1  ) {
				item.value = '||tax-s||' + item.value + '||tax-e||';
			}

			var input = '';
            var labelAfter = _.getItemParam(item, 'PARAM_TITILE_AFTER');
			var selectValues = item.selectValues;

            if( labelAfter == null ) {
                labelAfter = '';
            }

			var multiple = '';
			var selectedValue = item.value;



			var taxType = _.getItemParamArray(item, 'tax_type');




			// var additionalCssClass = 'ff-option-tax-type-selector';
			// var additionalParams = new Array();
			//
			// additionalParams.push('data-tax-type="' + taxType + '"');
			// additionalParams.push('data-selected-value="' + selectedValue + '"');
			// additionalParams.push('data-default-value="' + item.defaultValue + '"');
			//
			// _.printOptionSelect2( item, id, nameRoute, 'ff-option-tax-type-selector', additionalParams.join(' ') );
			//
			// return;

			input += '<div class="ff-select2-wrapper">';
            input += '<label>';
			input += '<select data-tax-type="' +taxType+ '"' + multiple + ' size="1" data-selected-value="' + selectedValue + '" class="ff-option-tax-type-selector" name="' + nameRoute +'" '+' data-default-value="' + item.defaultValue + '" >';

			// input += '<option value="' + oneValue.value + '" ' + selected + '>' + oneValue.name + '</option>';
			// input += '<option value="val" ' + selected + '>Hodnota</option>';

			for( var i in selectValues ) {
				var oneValue = selectValues[i];
				var selected = '';

				if( oneValue.value == selectedValue ) {
					selected = ' selected="selected" ';
				}

				input += '<option value="' + oneValue.value + '" ' + selected + '>' + oneValue.name + '</option>';

			}




			input += '</select>';

            input += ' ';
            input += labelAfter;
            input += '</label>';

			input += '</div>';

			_.output += input;

		};

		_.printOptionGfontSelector = function( item, id, nameRoute ) {
			var labelAfter = _.getItemParam(item, 'PARAM_TITILE_AFTER');
			var input = '';

			var multiple = '';
			var selectedValue = item.value;

			var selectValues = item.selectValues;

			// var data = {};

			var postType = _.getItemParamArray(item, 'post_type');

			input += '<div class="ff-select2-wrapper">';
			input += '<label>';
			input += '<select ' + multiple + ' size="1" data-selected-value="' + selectedValue + '" class="ff-option-gfont-selector" name="' + nameRoute +'" '+' data-default-value="' + item.defaultValue + '" >';

			for( var i in selectValues ) {
				var oneValue = selectValues[i];
				var selected = '';

				if( oneValue.value == selectedValue ) {
					selected = ' selected="selected" ';
				}

				input += '<option value="' + oneValue.value + '" ' + selected + '>' + oneValue.name + '</option>';

			}

			input += '</select>';
			input += '&nbsp;&nbsp;&nbsp;' + labelAfter;
			input += '</label>';

			input += '</div>';

			_.output += input;

			return input;
		}

		_.printOptionPostTypeSelector = function( item, id, nameRoute ) {
			var input = '';

			var multiple = '';
			var selectedValue = item.value;

			var selectValues = item.selectValues;

			// var data = {};

			var postType = _.getItemParamArray(item, 'post_type');

			input += '<div class="ff-select2-wrapper">';
			input += '<span class="spinner is-active"></span>';

			input += '<select style="display:none;" data-post-type="' +postType+ '"' + multiple + ' size="1" data-selected-value="' + selectedValue + '" class="ff-option-post-type-selector" name="' + nameRoute +'" '+' data-default-value="' + item.defaultValue + '" >';

			for( var i in selectValues ) {
				var oneValue = selectValues[i];
				var selected = '';

				if( oneValue.value == selectedValue ) {
					selected = ' selected="selected" ';
				}

				input += '<option value="' + oneValue.value + '" ' + selected + '>' + oneValue.name + '</option>';

			}

			input += '</select>';

			input += '</div>';

			_.output += input;

			return input;
		}

        /*----------------------------------------------------------*/
        /* OPTION TEXT
        /*----------------------------------------------------------*/
        _.printOptionText = function( item, id, nameRoute ) {
            var label = item.title;
            var labelAfter = _.getItemParam(item, 'PARAM_TITILE_AFTER');

            var shortClass = '';
            if (_.getItemParam( item, 'short') ){ shortClass = 'input-short' };

            var input = '';
            input += '<input type="text" ';
            input += ' name="' + nameRoute + '" ';
            input += ' class="' + _.getItemClassesString( item ) + ' ' + shortClass + ' ' + 'ff-opt-' + item.id + '" ';
            input += ' value="' + item.value + '" ';
            input += ' data-default-value="' + item.defaultValue + '" ';
            input += ' ' + _.getPlaceholder( item ) + ' ';
            input += '>';


            if( label == null && labelAfter == null ) {
                _.output += input;
            } else {
                if( labelAfter == null ) {
                    labelAfter = '';
                }
                if(_.getItemParam( item, 'fullwidth') ) {
                    _.output += '<label class="ff-input-wideflex__label">';
                        _.output += '<div class="ff-input-wideflex__label-text">';
                            _.output += label;
                        _.output += '</div>';
                        _.output += '<div class="ff-input-wideflex__input-wrapper">';
                            _.output += input;
                        _.output += '</div>';
                        _.output += labelAfter;
                    _.output += '</label>';
                } else {
                    _.output += '<label>';
                        _.output += label;
                        _.output += ' ';
                        _.output += input;
                        _.output += ' ';
                        _.output += labelAfter;
                    _.output += '</label>';
                }

            }
        }


        /*----------------------------------------------------------*/
        /* OPTION NUMBER
        /*----------------------------------------------------------*/
        _.printOptionNumber = function( item, id, nameRoute ) {
            var label = item.title;
            var labelAfter = _.getItemParam(item, 'PARAM_TITILE_AFTER');

            var input = '';
            input += '<input type="number" ';
            input += ' name="' + nameRoute + '" ';
            input += ' class="' + _.getItemClassesString( item ) + '" ';
            input += ' value="' + item.value + '" ';
            input += ' data-default-value="' + item.defaultValue + '" ';
            input += ' ' + _.getPlaceholder( item ) + ' ';

            ['min','max','step'].forEach(function(attr,index,arr) {
                var val = _.getItemParam( item, attr );
                if( undefined != val && null != val ) {
                    input += ' ' + attr + '="' + val + '" ';
                }
            });
            input += '>';


            if( label == null && labelAfter == null ) {
                _.output += input;
            } else {
                if( labelAfter == null ) {
                    labelAfter = '';
                }
                if(_.getItemParam( item, 'fullwidth') ) {
                    _.output += '<label class="ff-input-wideflex__label">';
                        _.output += '<div class="ff-input-wideflex__label-text">';
                            _.output += label;
                        _.output += '</div>';
                        _.output += '<div class="ff-input-wideflex__input-wrapper">';
                            _.output += input;
                        _.output += '</div>';
                        _.output += labelAfter;
                    _.output += '</label>';
                } else {
                    _.output += '<label>';
                        _.output += label;
                        _.output += ' ';
                        _.output += input;
                        _.output += ' ';
                        _.output += labelAfter;
                    _.output += '</label>';
                }

            }
        }
		/*----------------------------------------------------------*/
		/* OPTION TEXTAREA
		 /*----------------------------------------------------------*/
		_.printOptionTinyMCE = function( item, id, nameRoute ) {

			var input = '';

			input += '<div class="ff-options__tinymce-holder">';
			input += '<div class="ff-options__tinymce-enable button">Enable TinyMCE Editor</div>';
			input += '<div class="ff-options__tinymce-disable button">Disable TinyMCE Editor</div>';


			input += '<textarea ';
			input += ' name="' + nameRoute + '" ';
			input += ' data-id="' + item.id + '" ';
			input += _.getItemCols( item );
			input += _.getItemRows( item );
			input += ' class="ff-options__tinymce ' + _.getItemClassesString( item ) + ' ff-options__textarea"';
			input += ' data-default-value="' + item.defaultValue + '" ';
			input += ' ' + _.getPlaceholder( item ) + ' ';
			input += '>';

			input += item.value;

			input += '</textarea>';

			input += '</div>';

			_.output += input;

		};

        /*----------------------------------------------------------*/
        /* OPTION TEXTAREA
        /*----------------------------------------------------------*/
        _.printOptionTextarea = function( item, id, nameRoute ) {

            var label = item.title;
            var labelAfter = _.getItemParam(item, 'PARAM_TITILE_AFTER');

            var input = '';
            input += '<textarea ';
            input += ' name="' + nameRoute + '" ';
            input += _.getItemCols( item );
            input += _.getItemRows( item );
            input += ' class="' + _.getItemClassesString( item ) + ' ff-options__textarea"';
            input += ' data-default-value="' + item.defaultValue + '" ';
            input += ' ' + _.getPlaceholder( item ) + ' ';
            input += '>';

            input += item.value;

            input += '</textarea>';

            input += '<span class="description">' + item.description + '</span>';

            if( label == null && labelAfter == null ) {
                _.output += input;
            } else {
                if( labelAfter == null ) {
                    labelAfter = '';
                }

                    _.output += '<label class="ff-options__textarea__label">';
                        _.output += label;
                        _.output += ' ';
                        _.output += input;
                        _.output += ' ';
                        _.output += labelAfter;
                    _.output += '</label>';
            }
        }


        /*----------------------------------------------------------*/
        /* OPTION CHECKBOX
        /*----------------------------------------------------------*/
        _.printOptionCheckbox = function( item, id, nameRoute ) {

            var label = item.title;
            var labelAfter = _.getItemParam(item, 'PARAM_TITILE_AFTER');

            var input = '';
            //input += '<div class="ff-checkbox-wrapper">';
            input += '<input type="hidden" class="ff-checkbox-shadow" value="0" name="' + nameRoute + '" >';

            input += '<input type="checkbox" ';
            input += ' name="' + nameRoute + '" ';
            input += ' value="1" ';
            input += ' data-default-value="' + item.defaultValue + '" ';
            input += _.getItemCheckedCheckBox( item );
            input += ' class="' + _.getItemClassesString( item ) + ' ff-opt-' + item.id + '"';
            input += ' ' + _.getPlaceholder( item ) + ' ';
            input += '>';
            //input += '<div>';


            if( label == null && labelAfter == null ) {
                _.output += input;
            } else {
                if( labelAfter == null ) {
                    labelAfter = '';
                }

                    _.output += '<label>';
                        _.output += input;
                        _.output += ' ';
                        _.output += label;
                    _.output += '</label>';
            }
        }

		/*----------------------------------------------------------*/
		/* OPTION HIDDEN
		 /*----------------------------------------------------------*/
		_.printOptionHidden = function( item, id, nameRoute ) {

			// var label = item.title;
			// var labelAfter = _.getItemParam(item, 'PARAM_TITILE_AFTER');

			var input = '';
			//input += '<div class="ff-checkbox-wrapper">';
			input += '<input type="hidden" class="ff-input-hidden ff-opt-' + item.id + '" value="' + item.value + '" name="' + nameRoute + '" >';

			// input += '<input type="checkbox" ';
			// input += ' name="' + nameRoute + '" ';
			// input += ' value="1" ';
			// input += ' data-default-value="' + item.defaultValue + '" ';
			// input += _.getItemCheckedCheckBox( item );
			// input += ' class="' + _.getItemClassesString( item ) + ' ff-opt-' + item.id + '"';
			// input += ' ' + _.getPlaceholder( item ) + ' ';
			// input += '>';
			// input += '<div>';
			//
			//
			// if( label == null && labelAfter == null ) {
			// 	_.output += input;
			// } else {
			// 	if( labelAfter == null ) {
			// 		labelAfter = '';
			// 	}
			//
			// 	_.output += '<label>';
				_.output += input;
				// _.output += ' ';
				// _.output += label;
				// _.output += '</label>';
			// }
		}




        /*----------------------------------------------------------*/
        /* OPTION SELECT
        /*----------------------------------------------------------*/
        _.printOptionSelect = function( item, id, nameRoute ) {

			// console.log( _ );
			// console.log( _.walker.idRoute  );

			// console.log( item );

            var selectValues = item.selectValues;
            var selectedValue = item.value;
            var isGroup = _.getItemParam( item, 'is_group', false);
            var labelAfter = _.getItemParam(item, 'PARAM_TITILE_AFTER');

            var enables = _.getItemParam( item, 'enables', '');
            if( enables != '' ) {
                enables = ' data-enables="' + enables + '" ';
            }

            var input = '';

            if(_.getItemParam( item, 'print_label', true) == true ) {
                input += '<label>';
            }

            var shortClass = '';
            if (_.getItemParam( item, 'short') ){ shortClass = 'select-short' };

            input += item.title;
            input += '<select';
            input += ' our-value="'+selectedValue+'"';
            input += ' class="' + _.getItemClassesString( item ) + ' ' + shortClass + ' ff-opt-' + item.id + '"';
            input += ' data-default-value="' + item.defaultValue + '" ';
            input += ' name="' + nameRoute + '" ';
            input += ' ' + enables + '>';


                if( !isGroup ) {

                    for( var i in selectValues ) {
                        var oneValue = selectValues[i];
                        var selected = '';

                        if( oneValue.value == selectedValue ) {
                            selected = ' selected="selected" ';
                        }

                        input += '<option value="' + oneValue.value + '" ' + selected + '>' + oneValue.name + '</option>';

                    }

                } else {

					for( var groupName  in selectValues ) {
						var oneGroup = selectValues[ groupName ];
						input += '<optgroup label="' + groupName +'">';
						for( var i in oneGroup ) {
							var oneValue = oneGroup[i];

							var selected = '';

							if( oneValue.value == selectedValue ) {
								selected = ' selected="selected" ';
							}

							input += '<option value="' + oneValue.value + '" ' + selected + '>' + oneValue.name + '</option>';
						}

						input += '</optgroup>';

					}

                }

            input += '</select>';

            if( labelAfter != null ) {
                input += ' ' + labelAfter;
            }            

            if(_.getItemParam( item, 'print_label', true) == true ) {
                input += '</label>';
            }

            _.output += input;
        }


        /*----------------------------------------------------------*/
        /* SELECT2
        /*----------------------------------------------------------*/
        _.printOptionSelect2 = function( item, id, nameRoute, additionalCssClass, additionalWrapperParams ) {


			if( additionalCssClass == undefined ) {
				additionalCssClass = '';
			}

			if( additionalWrapperParams == undefined ) {
				additionalWrapperParams = '';
			}

            var selectValues = item.selectValues;
            var selectedValue = item.value;

            var selectedValueExploded = selectedValue.split('--||--');
            var multiple = _.getItemParam( item, 'type', '');

            var input = '';

            input += '<div class="ff-select2-wrapper ' + additionalCssClass +'" ' + additionalWrapperParams + '>';

                // real value wrapper
                input += '<div class="ff-select2-value-wrapper">';
                input += '<input type="text" class="ff-select2-value" name="'+ nameRoute + '" value="'+ selectedValue +'">';
                input += '</div>';

                input += '<div class="ff-select2-real-wrapper">';



                    input += '<select ' + multiple + ' size="1" data-selected-value="' + selectedValue + '" class="ff-select2" name="' + nameRoute +'" '+' data-default-value="' + item.defaultValue + '" >';

                        for( var i in selectValues ) {
                            var oneValue = selectValues[i];
                            var selected = '';


                            if($.isArray( selectedValueExploded ) ) {
                                //console.log( $.inArray( oneValue.value,  selectedValueExploded ) );
                                //    console.log( oneValue.value.toString(), selectedValueExploded );
                                if($.inArray( oneValue.value.toString(),  selectedValueExploded  ) != -1 ) {
                                    selected = ' selected="selected" ';
                                }
                            } else {

                                if( oneValue.value == selectedValue ) {
                                    selected = ' selected="selected" ';
                                }
                            }



                            input += '<option value="' + oneValue.value + '" ' + selected + '>' + oneValue.name + '</option>';

                        }

                    input += '</select>';
                input += '</div>';



                input += '<div class="ff-select2-shadow-wrapper">';
                    input += '<select ' + multiple + ' size="1" data-selected-value="' + selectedValue + '" class="ff-select2" name="' + nameRoute +'" >';

                            for( var i in selectValues ) {
                                var oneValue = selectValues[i];
                                var selected = '';

                                if( oneValue.value == selectedValue ) {
                                    selected = ' selected="selected" ';
                                }

                                input += '<option value="' + oneValue.value + '" ' + selected + '>' + oneValue.name + '</option>';

                            }

                    input += '</select>';
                input += '</div>';


            input += '</div>';

            _.output += input;


        }

        _.printOptionNavigationMenuSelector = function( item, id, nameRoute ) {
            var selectValues = JSON.parse($('.ff-navigation-menu-selector-content').html());
            var selectedValue = item.value;
            var isGroup = _.getItemParam( item, 'is_group', false);


            var enables = _.getItemParam( item, 'enables', '');
            if( enables != '' ) {
                enables = ' data-enables="' + enables + '" ';
            }

            var input = '';

            if(_.getItemParam( item, 'print_label', true) == true ) {
                input += '<label>';
            }

            input += item.title;
            input += '<select class="ff-navigation-menu-selector ' + _.getItemClassesString( item ) + '" name="' + nameRoute + '" ' + enables + '>';

                if( !isGroup ) {

                    for( var i in selectValues ) {
                        var oneValue = selectValues[i];
                        var selected = '';

                        if( oneValue.value == selectedValue ) {
                            selected = ' selected="selected" ';
                        }

                        input += '<option value="' + oneValue.value + '" ' + selected + '>' + oneValue.name + '</option>';

                    }

                } else {

                    alert(' OPTIONS IN GROUPS ARE NOT READY!!!')

                }

            input += '</select>';

            if(_.getItemParam( item, 'print_label', true) == true ) {
                input += '</label>';
            }

            _.output += input;
        }

        /*----------------------------------------------------------*/
        /* OPTION IMAGE
        /*----------------------------------------------------------*/
        _.printOptionImage = function( item, id, nameRoute ) {


            var value = item.value;

            value = value.split('_ffqt_').join('"');

            if( value == '' ) {
                var defaultValueJSON = {};
                defaultValueJSON.url = '';
                defaultValueJSON.id = '';
                defaultValueJSON.width = 0;
                defaultValueJSON.height = 0;
                value = defaultValueJSON;
            } else {

                //console.log( value );
                try {
                    value = JSON.parse( value );
                } catch( e ) {
                    var defaultValueJSON = {};
                    defaultValueJSON.url = '';
                    defaultValueJSON.id = '';
                    defaultValueJSON.width = 0;
                    defaultValueJSON.height = 0;
                    value = defaultValueJSON;
                }
            }


            var label = item.title;

            if( label == null ) {
                label = 'Select Image';
            }

			if( value.id == -1 ) {
				value.url = ff_fw_template_url + '/builder/placeholders/' + value.url;
			}

            var dataForcedWidth = _.getItemParam( item, 'data-forced-width', '');
            if( dataForcedWidth != '' ) {
                dataForcedWidth = ' data-forced-width="' + dataForcedWidth + '" ';
            }

            var dataForcedHeight = _.getItemParam( item, 'data-forced-height', '');
            if( dataForcedHeight != '' ) {
                dataForcedHeight = ' data-forced-height="' + dataForcedHeight + '" ';
            }

            var imgUrlIsEmpty = '';
            if ( '' == _.escapeValue( value.url ) ){
                imgUrlIsEmpty = 'ff-empty';
            }            

            input = '';

            input +=  '<span class="ff-open-library-button-wrapper ff-open-image-library-button-wrapper ' + imgUrlIsEmpty + '">';
            input +=  '<a class="ff-open-library-button ff-open-image-library-button" ' + dataForcedWidth + ' ' + dataForcedHeight + '>';
            input +=  '<span class="ff-open-library-button-preview">';
            input +=  '<span class="ff-open-library-button-preview-image" style="background-image:url(\'' + _.escapeValue( value.url ) + '\');">';
            input +=  '</span>';
            input +=  '</span><span class="ff-open-library-button-title">' + label + '</span>';
            input +=  '<input type="hidden" name="' + nameRoute + '" id="" class="ff-image" value="' + _.escapeValue( item.value ) +'" '+' data-default-value="' + item.defaultValue + '" '+'>';
            input +=  '<span class="ff-open-library-button-preview-image-large-wrapper">';
            // input +=  '<img class="ff-open-library-button-preview-image-large" src="'  + _.escapeValue( value.url ) + '" width="'+ value.width + '" height="'+ value.height + '">';
			input +=  '<img class="ff-open-library-button-preview-image-large" src="'  + _.escapeValue( value.url ) + '" width="'+ 300 + '" >';
            input +=  '</span>';
            input +=  '</a>';
            input +=  '<a class="ff-open-library-remove" title="Clear"></a>';
			input +=  '<a class="ff-default-content-img">DEFAULT</a>';
            input +=  '</span>';


            var labelAfter = _.getItemParam(item, 'PARAM_TITILE_AFTER');
            var description = item.description;


            if( description == null && labelAfter == null ) {
                _.output += input;
            } else {
                if( labelAfter == null ) {
                    labelAfter = '';
                }

                    _.output += '<label>';
                        _.output += description;
                        _.output += ' ';
                        _.output += input;
                        _.output += ' ';
                        _.output += labelAfter;
                    _.output += '</label>';
            }

        }

        _.printOptionIcon = function( item, id, nameRoute ) {
            var label = item.title;

            if( label == null ) {
                label = 'Select Icon';
            }

            var data_autofilter = _.getItemParam( item, 'data-autofilter', '');
            if( data_autofilter != '' ) {
                data_autofilter = ' data-autofilter="'+data_autofilter+'" ';
            }

            var input = '';
            input += '<span class="ff-open-icon-library-button-wrapper">';
			input += '<a class="ff-open-library-button ff-open-library-icon-button">';
				input += '<span class="ff-open-library-button-preview">';

				input += '<i class="' + item.value + '"></i>';

				input += '</span>';
				input += '<span class="ff-open-library-button-title">' + label + '</span>';
				input += '<input type="hidden" name="' + nameRoute +'" id="" class="ff-icon" value="' + _.escapeValue( item.value )+ '" ' + data_autofilter +' '+' data-default-value="' + item.defaultValue + '" '+'>';

                input += '</a>';
			input +=  '<a class="ff-open-library-remove" title="Clear"></a>';
            input += '</span>';

            _.output += input;
        }

        /*----------------------------------------------------------*/
        /* OPTION RADIO
        /*----------------------------------------------------------*/
        _.printOptionRadio = function( item, id, nameRoute ) {


            _.output += '<span style="color:red; font-size:20px;"> OPTION RADIO MISSING </span>';

            var label = item.title;
            var labelAfter = _.getItemParam(item, 'PARAM_TITILE_AFTER');

            var input = '';

            input += '<input type="hidden" value="0" name="' + nameRoute + '" >';

            input += '<input type="checkbox" ';
            input += ' name="' + nameRoute + '" ';
            input += ' value="1" ';
            input += ' data-default-value="' + item.defaultValue + '" ';
            input += _.getItemCheckedCheckBox( item );
            input += ' class="' + _.getItemClassesString( item ) + ' ff-opt-' + item.id + '"';
            input += ' ' + _.getPlaceholder( item ) + ' ';
            input += '>';

            if( label == null && labelAfter == null ) {
                _.output += input;
            } else {
                if( labelAfter == null ) {
                    labelAfter = '';
                }

                    _.output += '<label>';
                        _.output += input;
                        _.output += ' ';
                        _.output += label;
                    _.output += '</label>';
            }
        }




/**********************************************************************************************************************/
/* VARIATION
/**********************************************************************************************************************/
        walker.setCallbackBeforeRepeatableVariationContainer(function( item, id, index ){

            if( item == null ) {
                return;
            }


            //console.log('--- variation - START ' + item.id );

            var sectionName = _.getItemParam( item, 'section-name');

            var hideDefault = _.getItemParam(item, 'hide-default');

			var hideDefaultClass = '';

			if( hideDefault ) {
				hideDefaultClass = 'ff-hide-default';
			}

            var currentSectionRoute = _.walker.getCurrentSectionRoute();

            var nameRoute = (_.walker.getNameRoute() );

            _.output += '<li class="ff-repeatable-item ff-repeatable-item-js ff-repeatable-item-'+index+' ff-repeatable-item-closed ' + hideDefaultClass + '" data-section-id="'+item.id+'" data-section-name="'+sectionName+'" data-node-id="'+index+'" data-current-name-route="'+nameRoute+'" data-current-section-route="'+currentSectionRoute+'">';


            if(_.getItemParam( item, 'advanced-picker-menu-title') != null ) {
                _.output += '<div class="ff-repeatable-section-info" style="display:none">';
                    _.output +=  '<span class="ff-advanced-section-name">'+ _.getItemParam( item, 'section-name')+'</span>';
                    _.output +=  '<span class="ff-advanced-section-id">' + item.id + '</span>';
                    _.output +=  '<span class="ff-advanced-section-image">'+ _.getItemParam( item, 'advanced-picker-section-image') + '</span>';
                    _.output +=  '<span class="ff-advanced-menu-title">'+ _.getItemParam( item, 'advanced-picker-menu-title') + '</span>';
                    _.output +=  '<span class="ff-advanced-menu-id">'+ _.getItemParam( item, 'advanced-picker-menu-id') + '</span>';
                _.output +=  '</div>';
            }

            // HEADER
            _.output +=  '<div class="ff-repeatable-header ff-repeatable-drag ff-repeatable-handle ui-sortable">';

            _.output += '<table class="ff-repeatable-header-table"><tbody><tr>';
                _.output += '<td class="ff-repeatable-item-number"></td>';
                _.output += '<td class="ff-repeatable-title">' + sectionName + '</td>';
                _.output += '<td class="ff-repeatable-description"> </td>';
                _.output += '</tr></tbody></table>';
                _.output += '<div class="ff-repeatable-handle"></div>';
                _.output += '<div class="ff-repeatable-settings"></div>';

                if(_.getItemParam(item, 'show-advanced-tools') == true) {
                    _.output += '<div class="ff-show-advanced-tools dashicons dashicons-edit"></div>';
                }

                //_.output += '<div class="ff-repeatable-settings"></div>';

                    if(_.getItemParam( item, 'advanced-picker-section-image') != null ) {
                        var url = _.getItemParam( item, 'advanced-picker-section-image');
                        _.output += '<div class="ff-repeatable-preview">';
                            _.output += '<img src="' + url + '" alt="">';
                        _.output += '</div>';
                    }

                _.output += '<div class="ff-popup-container">';
                _.output += '<div class="ff-popup-wrapper">';
                    _.output += '<div class="ff-popup-backdrop"></div>';
                    _.output += '<ul class="ff-repeatable-settings-popup ff-popup">';

                        //_.output += '<li class="ff-popup-button-wrapper">';
                        //    _.output += '<div class="ff-popup-button ff-repeatable-js-duplicate-above">Duplicate Above</div>';
                        //_.output += '</li>';
                        //
                        //_.output += '<li class="ff-popup-button-wrapper">';
                        //    _.output += '<div class="ff-popup-button ff-repeatable-js-duplicate-below">Duplicate Below</div>';
                        //_.output += '</li>';


						_.output += '<li class="ff-popup-button-wrapper">';
							_.output += '<div class="ff-popup-button ff-repeatable-duplicate">Duplicate</div>';
						_.output += '</li>';
                        _.output += '<li class="ff-popup-button-wrapper">';
                            _.output += '<div class="ff-popup-button ff-repeatable-copy">Copy</div>';
                        _.output += '</li>';
                        _.output += '<li class="ff-popup-button-wrapper">';
                            _.output += '<div class="ff-popup-button ff-repeatable-paste">Paste</div>';
                        _.output += '</li>';
                        _.output += '<li class="ff-popup-button-wrapper">';
                            _.output += '<div class="ff-popup-button ff-repeatable-remove">Delete</div>';
                        _.output += '</li>';

                    _.output += '</ul>';
                _.output += '</div>';
            _.output += '</div>';
            _.output += '</div>';
            _.output += '<div class="ff-repeatable-content">';
        });

        walker.setCallbackAfterRepeatableVariationContainer(function( item, id ){
            _.output += '</div>';

            _.output += '<div class="ff-repeatable-controls-top ff-repeatable-variation-selector">';
            _.output += '<div class="ff-repeatable-add-above ff-repeatable-add-above-js" title="Add Item"></div>';

                _.output += '<div class="ff-popup-container">';
                            _.output += '<div class="ff-popup-wrapper">';
                                _.output += '<div class="ff-popup-backdrop"></div>';
                                _.output += '<ul class="ff-popup ff-repeatable-add-variation-selector-popup">';
                                    _.output += '<li class="ff-popup-button-wrapper">';
                                        _.output += '<div class="ff-popup-button">Placeholder</div>';
                                    _.output += '</li>';
                                _.output += '</ul>';
                            _.output += '</div>';
                        _.output += '</div>';
            _.output += '</div>';




            _.output += '<div class="ff-repeatable-controls-bottom ff-repeatable-variation-selector">';
            _.output += '<div class="ff-repeatable-add-below ff-repeatable-add-below-js" title="Add Item"></div>';
                    _.output += '<div class="ff-popup-container">';
                        _.output += '<div class="ff-popup-wrapper">';
                            _.output += '<div class="ff-popup-backdrop"></div>';
                            _.output += '<ul class="ff-popup ff-repeatable-add-variation-selector-popup">';
                                _.output += '<li class="ff-popup-button-wrapper">';
                                    _.output += '<div class="ff-popup-button">Placeholder</div>';
                                _.output += '</li>';
                            _.output += '</ul>';
                        _.output += '</div>';
                    _.output += '</div>';
            _.output += '</div>';

            _.output += '</li>';
        });

/**********************************************************************************************************************/
/* VARIABLE
/**********************************************************************************************************************/
        walker.setCallbackBeforeRepeatableVariableContainer(function(item, id ){
			
            var currentLevel = _.getCurrentRouteCount();
            var currentSectionRoute = _.walker.getCurrentSectionRoute();
            var classes = '';

            if(_.getItemParam( item, 'section-picker') == 'advanced' ) {
                classes += 'ff-section-picker-advanced';
            }

            var cssClasses = _.getItemParam(item, 'class');

            if( cssClasses != null ) {
                classes += ' ' + cssClasses;
            }


            if(_.getItemParam( item, 'work-as-accordion') == true ) {
                classes += ' ff-work-as-accordion';
            }

            if(_.getItemParam( item, 'all-items-opened') == true ) {
                classes += ' ff-all-items-opened';
            }

			if(_.getItemParam( item, 'can-be-empty', false) == true ) {
				classes += ' ff-can-be-empty';
			}


            _.output += '<ul data-current-name-route="' + _.walker.getNameRoute() + '" class="ff-repeatable ff-repeatable-js ff-repeatable-boxed '+classes+'" data-current-level="'+currentLevel+'" data-current-section-route="'+currentSectionRoute+'">';
        });

        walker.setCallbackAfterRepeatableVariableContainer(function(item, id ){
            _.output += '</ul>';
        });



        return _;
    }
})(jQuery);