(function($){
	frslib.provide('frslib.options2');

	/**
	 * Printing our options
	 */
	frslib.options2.manager = Backbone.View.extend({
	/*----------------------------------------------------------*/
	/* OBJECTS
	/*----------------------------------------------------------*/
		_applyToOptions: [],
		/**
		 *
		 */
		_optionsPrinter : null,

		_formParser: null,

		_dataManager: null,

		_applyToOptionsAfterInsert: [],

		_metaData: [],

		_applyToOptionsAfterChange: [],

	/*----------------------------------------------------------*/
	/* FUNCTIONS
	/*----------------------------------------------------------*/
		initialize: function() {
			this._optionsPrinter = new frslib.options2.printer();
			this._formParser = new frslib.options2.formParser();
			this._dataManager = new frslib.options2.dataManager();
			// init Potential Inherited childrens
			this._initChildren();
		},

		setMetaData: function( name, value ) {
			this._metaData[ name ] = value;
			return this;
		},

		getMetaData: function( name, defaultValue ) {
			if( this._metaData[ name ] != undefined ) {
				return this._metaData[ name ];
			} else {
				return defaultValue;
			}
		},

		_initChildren: function() {
			this._applyToOptions = [];
			this._applyToOptionsAfterInsert =[];
			for( var i = 1; i <= 10; i++ ) {
				if( this['_autoCalledInit_' + i] != undefined ) {
					this['_autoCalledInit_' + i].call( this );
				}
			}
		},

		render: function() {
			var self = this;
			var start = performance.now();
			this._renderOptions();
			this._initOptions( this.$el );
			var end = performance.now();

			console.log( 'Printing and options bounding: ' + (end - start) );

			this.$el.on('insertedToDOM', function(){
				self._initOptionsAfterInsert();
			});

			this.$el.on('beforeRemovingFromDOM', function(){
				self._destroyOptionsBeforeRemoval();
			});
			return this.$el;
		},



		_destroyOptionsBeforeRemoval: function() {
			var $element = this.$el;

			this._destroyTinyMCE( $element );
            this._destroyAceEditor( $element );
		},

		_initOptionsAfterInsert: function( $element ) {
			if( $element == undefined ) {
				$element = this.$el;
			}

			this._initTinyMCE( $element );
			for( var i in this._applyToOptionsAfterInsert ) {
				var oneCallback = this._applyToOptionsAfterInsert[ i ];
				this[oneCallback].call( this, $element );
			}
		},

		markChangedValues: function() {
			this._formParser.markChangedValues( this.$el );
		},

		formHasBeenChanged: function() {
			var newData= this.parseForm();
			var newDataJSON = JSON.stringify( newData );



			var oldData = this._optionsPrinter.getData();
			var oldDataJSON = JSON.stringify( oldData );


			return newDataJSON == oldDataJSON;
		},

		forceFormValuesAsUserValues: function() {
			this._formParser.forceFormValuesAsUserValues( this.$el );
		},

		parseForm: function() {
			var start = performance.now();
			var formData = this._formParser.parseForm( this.$el );
			var end = performance.now();
			console.log( 'Parsing form: ' + (end - start) );

			return formData;
			// console.log( 'yess');
		},

		hasFormBeenChanged: function() {
			return this._formParser.hasBeenFormChanged( this.$el );
		},
		
		prepareFormForSaving: function() {
			this._formParser.parseFormAndNormalizeItForSubmit( this.$el);
		},

		_renderOptions: function() {
			this._optionsPrinter.setMetaDataAll( this._metaData );
			this._optionsPrinter.walk();
			var output = this._optionsPrinter.getOutput();
			this.$el = $(output);
		},

		_initOptions: function( $element ) {
			this._initRepeatable( $element );

			for( var i in this._applyToOptions ) {
				var oneCallback = this._applyToOptions[ i ];
				this[oneCallback].call( this, $element );
			}
		},

		/*----------------------------------------------------------*/
		/* INIT REPEATABLE
		/*----------------------------------------------------------*/
		_initRepeatable: function( $element ) {
			this._initRepeatablePopup( $element);
			this._initRepeatableOpenAndClose( $element );
			this._initRepeatableAdd( $element );
			this._initRepeatableSortable( $element );
			this._initHidingBox( $element );
			this._initImagePicker( $element );
			this._initImageGallery( $element );
			this._initColorLibrary( $element );
            this._initStyleSelect( $element );
            this._initFreshSelect( $element );
			this._initPostTypeSelector( $element );
			this._initSidebarManager( $element );
			this._initTaxTypeSelector( $element );
			this._initRevoSliderSelector( $element );
			this._initGoogleFontSelector( $element );
			this._initFullFonts( $element );
			this._initRepeatableStartingValues( $element );
			// this._initTinyMCE( $element );
            this._initAceEditor( $element );
            this._initACFFields( $element );
		},

        _initACFFields: function( $element ) {
            var self = this;
            $element.find('.ff-acf-select-holder').each(function(){

                var $groupHolder = $(this);
                $groupHolder.css('opacity', 0.3);
                var $group = $(this).find('.ff-opt-acf-group-type');
                var $field = $(this).find('.ff-opt-acf-field-type');


                var changeFields = function( fields ) {
                    var selected = $field.attr('data-user-value');
                    var optionsString = '';
                    for( var i in fields ) {
                        var oneField = fields[i];


                        var selectedString = '';
                        if( selected == oneField.value ) {
                            selectedString = ' selected="selected" ';
                        }
                        optionsString += '<option ' + selectedString + ' value="' + oneField.value + '">' + oneField.name + '</option>';

                    }

                    $field.html( optionsString);
                };

                $group.on('change', function(){
                    var newGroupId = $(this).val();

                    self._dataManager.getAvailableACFGroups( function( data ) {
                        if( data.fields[ newGroupId ] ) {
                            changeFields( data.fields[newGroupId ] );
                        } else {
                            changeFields( [ {name:'empty', 'value':''}]);
                        }
                    });

                });


                self._dataManager.getAvailableACFGroups( function( data ) {

                    var groups = data.groups;

                    var groupsSelected = $group.attr('data-user-value');
                    var groupsSelect ='';

                    var selectedGroupId = null;

                    for( var i in groups ) {
                        var selected = '';
                        if( groupsSelected == groups[i].value ) {
                            selectedGroupId = groups[i].value;
                            selected = ' selected="selected" ';
                        }
                        groupsSelect += '<option ' + selected + ' value="' + groups[i].value + '">' + groups[i].name + '</option>';
                    }

                    $group.html( groupsSelect );

                    if( !selectedGroupId ) {
                        selectedGroupId = groups[0].value;
                    }

                    if( data.fields[ selectedGroupId ] ) {
                        changeFields( data.fields[selectedGroupId ] );
                    }


                    //console.log( data );
                    $groupHolder.animate({opacity:1}, 1000);
                });



            });
        },

        _initAceEditor: function( $element ) {
            //setTimeout(function(){
            $element.find('.ff-options__code-editor').each(function(){
                var $clonnedTextArea = $(this).clone();
                $(this).after( $clonnedTextArea );
                $clonnedTextArea.css('display', 'none');

                var type = $(this).attr('data-code-editor-type');

                var editor =ace.edit( this );

                // ace.require("ace/ext/emmet");
                // editor.setTheme("ace/theme/monokai");

                if( type == 'php' ) {
                    editor.getSession().setMode({path:'ace/mode/php', inline:true});
                } else {
                    editor.getSession().setMode('ace/mode/' + type);
                }

                // ace.config.set("basePath", "../../extern/ace/src-min-noconflict/");


                var editorOptions = {};
                editorOptions.minLines = 10;
                editorOptions.maxLines = 20;

                editor.setOptions(editorOptions);
                editor.setFontSize(12);
                editor.renderer.setShowGutter(false);
                // editorOptions.enableEmmet = true;

                $(this).data('ff-ace-editor', editor);
                $clonnedTextArea.data('ff-ace-editor', editor);

                editor.getSession().on('change', function(){
                    $clonnedTextArea.text(editor.getSession().getValue());
                });
            });
        },

        _destroyAceEditor: function ( $element ) {
            $element.find('.ff-options__code-editor').each(function(){
                var editor = $(this).data('ff-ace-editor');
                editor.destroy();
            });
        },

		_initRepeatableStartingValues: function( $element ){
			$element.find('.ff-repeatable-js').addBack('.ff-repeatable-js').each(function(){
				var $repeatable = $(this);

				var childIds = [];

				$repeatable.children('li:not(.ff-repeatable-item-empty-add)').each(function(){
					childIds.push( $(this).attr('data-section-id') );
				});
				$repeatable.attr('data-starting-childs-id', childIds.join(','));
			});
		},


		_actionOptionsChanged: function( action ) {
			for( var i in this._applyToOptionsAfterChange ) {
				var oneCallback = this._applyToOptionsAfterChange[ i ];
				this[oneCallback].call( this, action );
			}
		},

		_getElementSysInfo: function( name, defaultValue ) {
			var $opt = this.$el.find('.ff-opt-ffsys-info');
			var val = JSON.parse( $opt.val());



			if( name != undefined ) {
				if( val[name] == undefined ) {
					return defaultValue
				} else {
					return val[name];
				}
			} else {
				if( defaultValue == undefined ) {
					return val;
				}  else {
					return defaultValue;
				}
				// return val;
			}
		},

		_setElementSysInfo: function( name, value ) {
			var $opt = this.$el.find('.ff-opt-ffsys-info');
			var val = JSON.parse( $opt.val());

			if( value == undefined ) {
				val = name;
			} else {
				val[ name ] = value;
			}
			val = JSON.stringify(val);

			$opt.val( val );
		},



		_destroyTinyMCE: function( $element ) {
			$element.find('.ff-options__textarea-is-richtext').each(function(){
				var id = $(this).attr('id');

				window.tinyMCE.execCommand( 'mceRemoveEditor', true, id);
			});
		},



		_initTinyMCE: function( $element ) {

			var enableTinyMCE = function ( $element ) {
				var id = $element.attr('id');

				window.tinyMCE.execCommand( 'mceRemoveEditor', true, id);
				// window.tinyMCE.execCommand( 'mceAddEditor', false, id );

				tinymce.init({
					theme: 'modern',
					plugins: "wordpress media image wplink textcolor colorpicker",
					toolbar:  [
						'styleselect | bold italic underline | forecolor backcolor | link image | alignleft aligncenter alignright | bullist numlist outdent indent ',
					],
					selector: '#' + id,
                    convert_urls: false,
					// plugins: "link"
					// menubar: "insert",
					// toolbar: "link"

				});
			};

			var disableTinyMCE = function( $element ) {
				var id = $element.attr('id');

				var content = window.tinyMCE.get(id).getContent();
				window.tinyMCE.execCommand( 'mceRemoveEditor', true, id);

				$element.val( content );
			};


            var newEnableAceEditor = function( $oldElement, mode ) {

                var $clonnedTextArea = $oldElement.clone(true).off();
                //$oldElement.css('opacity', 0.5);
                $oldElement.after($clonnedTextArea);
                $oldElement.css('display', 'none');
                //$clonnedTextArea.css('display', 'none');
                var newId = new Date().getTime().toString(32);
                $clonnedTextArea.attr('id', newId);
                //var type = $element.attr('data-code-editor-type');
                var type = mode;


                var editor = ace.edit(newId);

                // ace.require("ace/ext/emmet");
                // editor.setTheme("ace/theme/monokai");

                if (type == 'php') {
                    editor.getSession().setMode({path: 'ace/mode/php', inline: true});
                } else {
                    editor.getSession().setMode('ace/mode/' + type);
                }

                var editorOptions = {};
                editorOptions.minLines = 10;
                editorOptions.maxLines = 20;

                editor.setOptions(editorOptions);
                editor.setFontSize(12);
                // editorOptions.enableEmmet = true;


                $clonnedTextArea.data('ff-ace-editor', editor);
                $oldElement.data('ff-ace-editor', editor);
                $oldElement.attr('data-new-id', newId);
                $oldElement.data('editor-object', $clonnedTextArea);

                editor.getSession().on('change', function () {
                    $oldElement.html(editor.getSession().getValue());
                    $oldElement.val(editor.getSession().getValue());
                });

            }

            var destroyAceEditor = function( $element ) {
                var editor = $element.data('ff-ace-editor');

                editor.destroy();
                var newId = $element.attr('data-new-id');

                ace.edit(editor).destroy();

                var $parent = $element.parents('.ff-richtext-area-wrapper');

                $parent.find('.ace_editor').remove();

                $element.css('display', 'block');
            }



			$element.find('.ff-options__textarea-can-be-richtext').each(function(){

                var $parent = $(this).parents('.ff-richtext-area-wrapper');
                var $toggle = $parent.find('.ff-richtext-toggle-btn');
                var $textarea = $(this);
                var $isRichtextInput = $parent.find('.ff-opt-textarea-is-richtext-status-holder');

                var applyModeToTextArea = function( mode ) {
                    //$textarea = $parent.find('.ff-options__textarea-can-be-richtext');
                    $parent.find('.ff-richtext-toggle-btn').removeClass('ff-richtext-enabled').addClass('ff-richtext-disabled');
                    $parent.find('.ff-mode-' + mode).addClass('ff-richtext-enabled');
                    switch( mode ) {
                        case 'text':
                            $isRichtextInput.val(0);
                            // $parent.find('.ff-visible-in-text').animate({opacity:1}, 500);
                            $parent.find('.ff-richtext-syntax-btns-wrapper').animate({opacity:1}, 500);
                            // do nutin then
                            break;

                        case 'richtext':
                            $isRichtextInput.val(1);
                            enableTinyMCE( $textarea );

                            // $parent.find('.ff-visible-in-text').animate({opacity:0}, 500);
                            $parent.find('.ff-richtext-syntax-btns-wrapper').animate({opacity:0}, 500);

                            break;

                        default:

                            $isRichtextInput.val(2);
                            newEnableAceEditor($textarea, mode);
                            break;
                    }

                    $textarea.attr('data-show-mode', mode);
                };


                var makeTextareaPlainText = function() {
                    var mode = $textarea.attr('data-show-mode');
                    $isRichtextInput.val(0);
                    switch( mode ) {
                        case 'richtext':
                            disableTinyMCE( $textarea );
                            break;

                        case 'text':

                            break;

                        default:
                            destroyAceEditor( $textarea );
                            break;
                    }
                }



                var startMode = $(this).attr('data-show-mode');


                applyModeToTextArea( startMode, $(this) );


                $toggle.click(function() {
                    makeTextareaPlainText( $textarea );

                    var newMode = $(this).attr('data-mode');

                    applyModeToTextArea( newMode, $textarea );
                });












                return;

				var isRichtext = $(this).hasClass('ff-options__textarea-is-richtext');

				var $parent = $(this).parents('.ff-richtext-area-wrapper');
				var $textarea = $(this);
				var $isRichtextInput = $parent.find('.ff-opt-textarea-is-richtext-status-holder');
				var $toggle = $parent.find('.ff-richtext-toggle-btn');

				if( isRichtext == true) {
					enableTinyMCE( $textarea );
				}

				var toggleTinyMCE = function() {
					if ( $(this).hasClass('ff-richtext-enabled') && $parent.hasClass('ff-richtext-toggle-disabled') || $(this).hasClass('ff-richtext-disabled') && $parent.hasClass('ff-richtext-toggle-enabled') ){
						return false;
					}
					if( isRichtext ) {
						isRichtext = false;
						$textarea.removeClass('ff-options__textarea-is-richtext');
						$parent.removeClass('ff-richtext-toggle-enabled').addClass('ff-richtext-toggle-disabled');
						$isRichtextInput.val(0);

						disableTinyMCE( $textarea );
					} else {
						isRichtext = true;
						$textarea.addClass('ff-options__textarea-is-richtext');
						$parent.addClass('ff-richtext-toggle-enabled').removeClass('ff-richtext-toggle-disabled');
						$isRichtextInput.val(1);

						enableTinyMCE( $textarea );
					}
				}

				$toggle.click(toggleTinyMCE);

			});

		},


		_initSelect2OnInput: function( $input, options ) {
			var value = $input.val();

			if( options == undefined ) {
				options = {};
			}

			var defaultOptions = $.extend({
				// containerCssClass	: 'ff-select2',
				// dropdownCssClass	: 'ff-select2 ff-select2-dropdown',
				placeholder : '',
				width: 'resolve',
				allowClear: true}, options);

			$input.select2(defaultOptions);
		},

		_initGoogleFontSelector: function( $element ) {
			// ff-opt-type-gfont_selector
			// return false;
			var $gfonts = $element.find('.ff-opt-type-gfont_selector');

			if( $gfonts.size() == 0 ) {
				return false;
			}

			var self = this;
			self._dataManager.getAvailableGoogleFonts( function( data ) {
				data.unshift( {name:'', value:''});
				$element.find('.ff-opt-type-gfont_selector').each(function(){
				var $el = $(this);

					var value = $el.attr('data-user-value');
					var html = self._dataManager.getSelectHtmlFromArray( data, value );
					$el.html( html );
					//
					$el.parent().find('.spinner').remove();
					$el.removeProp('disabled');
					//
					self._initSelect2OnInput( $el );
				});

			});
		},

		_initSidebarManager: function( $element ) {
			var self = this;
			$element.find('.ff-opt-type-sidebar_selector').each(function(){
				var $el = $(this);

				self._dataManager.getSidebars(function( data ) {
					var value = $el.attr('data-user-value');
					var html = self._dataManager.getSelectHtmlFromArray( data, value );
					$el.html( html );
					//
					$el.parent().find('.spinner').remove();
					$el.removeProp('disabled');
					//
					self._initSelect2OnInput( $el );
				
				})
			});
		},

		_initPostTypeSelector: function( $element ) {
			var self = this;
			$element.find('.ff-opt-type-post_type_selector').each(function(){
				var $el = $(this);

				var postType = $(this).attr('data-post-type');
				var posts = self._dataManager.getPostsByType( postType, function( data ) {

					console.log( 'xxx');

					var value = $el.attr('data-user-value');

					// consol

					// data.unshift( {name:'', value:''})

					var html = self._dataManager.getSelectHtmlFromArray( data, value );
					var htmlOld = $el.html();

					// console.log( html);
					// console.log(htmlOld );

					$el.html( htmlOld + html );

					$el.parent().find('.spinner').remove();
					$el.removeProp('disabled');

					self._initSelect2OnInput( $el );
				});
				
				$el.parents('.ff-content-block-area').find('.ff-post-edit-link').click(function(){
					var value = $el.val();

					if( value != '' ) {
						var valueArray = value.split('--||--');
						var postId = valueArray[0];

						var postEditUrl = $(this).attr('data-edit-url').replace('!!!POST_ID!!!', postId);
						window.open(postEditUrl, '_blank');
						return false;
					}

					return false;
				});
			});
		},

		_initTaxTypeSelector: function( $element ) {
			var self = this;

			// return;
			$element.find('.ff-opt-type-tax_type_selector').each(function() {
				var $el = $(this);
				var taxType = $(this).attr('data-tax-type');

				var taxonomies = self._dataManager.getTaxonomiesByType( taxType, function( data ) {
					var value = $el.attr('data-user-value');

					if( value != undefined ) {
						value = value.split('--||--');
					} else {
						value = null;
					}

					var html = self._dataManager.getSelectHtmlFromArray( data, value );
					$el.html( html );

					$el.parent().find('.spinner').remove();
					$el.removeProp('disabled');

					self._initSelect2OnInput( $el, { placeholder: 'All'} );
				});
			});
		},

		_initRevoSliderSelector: function( $elements ) {
			var self = this;

			$elements.find('.ff-opt-type-revolution_slider').each(function(){
				var $el = $(this);

				self._dataManager.getRevolutionSliders( function( data ) {
					var value = $el.attr('data-user-value');

					var html = self._dataManager.getSelectHtmlFromArray( data, value );
					$el.html( html );

					$el.parent().find('.spinner').remove();
					$el.removeProp('disabled');
				});
			});
		},

		_initImageGallery: function( $elements ) {
			var self = this;

			$elements.find('.ff-image-gallery-wrapper').each(function(){
				var $this = $(this);
				var $input = $(this).find('.ff-opt-type-image_gallery');
				var $addButton = $(this).find('.ff-image-gallery_add-button');
				var $imageGalleryContent = $(this).find('.ff-image-gallery__content');



				var writeImageGalleryContentToInput = function() {
					var overallValue = [];
					$this.find('.ff-image-gallery__image').each(function(){
						var data = JSON.parse($(this).attr('data-json'));
						overallValue.push( data );
					});

					overallValue = JSON.stringify( overallValue );
					$input.val( overallValue );

				};


				var initSortable = function() {
					$imageGalleryContent.sortable({
						update:function(){
							writeImageGalleryContentToInput();
						},
						placeholder: {
							element: function( $currentItem ) {
								return '<div class="ui-sortable-placeholder"></div>';
							},
							update: function() {

							}
						},
						cursor: 'move',
						tolerance: 'pointer',
						cursorAt: { left: -5, top: -5 }
					});


				};

				var renderImageGalleryContent = function( images ) {
					var imagesContent = '';

					$.each(images,function(i, value ) {
						var img = '';
						var attrHelper = self._getAttrHelper();

						attrHelper.addParamEsc('class', 'ff-image-gallery__image');
						attrHelper.addParamEsc('data-json', JSON.stringify( value ) );
						attrHelper.addParamEsc('style', "background-image:url('" + value.url + "');");

						img += '<div ' + attrHelper.getAttrString() + '></div>';

						imagesContent += img;
					});

					var $imagesContent = $(imagesContent);

					$imagesContent.hover(function(){
						if ( $(this).siblings('.ui-sortable-placeholder').length){
							return;	
						}
						var $oneImage = $(this);
						var $deleteButton = $('<div class="ff-image-gallery__image-delete"></div>');

						$deleteButton.click(function( e){

							// $oneImage.animate({width:0, opacity:0}, 300, function(){
							var $nextImage = $oneImage.next();
							$oneImage.remove();
							setTimeout(function(){
								$nextImage.trigger('mouseover');
								setTimeout(function(){
									$nextImage.find('.ff-image-gallery__image-delete').trigger('mouseover');
								},100);

								// $nextImage.mousemove();
							},100);
							e.stopPropagation();
							// });
							writeImageGalleryContentToInput();
						});

						$(this).append( $deleteButton );
					}, function(){
						$(this).html('');
					});

					$imagesContent.click(function ( e ) {
						var $thisImage = $(this);

						var $clickButton = $thisImage.find('.ff-image-gallery__image-delete');
						var clickButtonOffset = $clickButton.offset();
						var clickButtonWidth = $clickButton.outerWidth();
						var clickButtonHeight = $clickButton.outerHeight();

						var mouseX = e.pageX;
						var mouseY = e.pageY;

						if( (mouseX > clickButtonOffset.left) && mouseX < (clickButtonOffset.left + clickButtonWidth) ) {
							if( ( mouseY > clickButtonOffset.top ) &&  mouseY < (clickButtonOffset.top + clickButtonHeight ) ) {
								$clickButton.trigger('click');
								e.stopPropagation();
								return false;
							}
						}


						var imagesDataJSON = $(this).attr('data-json');
						var imagesData = JSON.parse( imagesDataJSON );

						var custom_uploader = wp.media({
							title: 'Select Image',
							button: { text: 'Select Image' },
							library : { type : 'image'},
							multiple: false  // Set this to true to allow multiple files to be selected
						});

						custom_uploader.on('open',function() {
							var selection = custom_uploader.state().get('selection');
							var attachment = wp.media.attachment(imagesData.id);
							attachment.fetch();
							selection.add( attachment ? [ attachment ] : [] );
						});

						custom_uploader.on('select', function() {
							var attachment = custom_uploader.state().get('selection').first().toJSON();

							var image = {};
							image.id = attachment.id;
							image.url = attachment.url;
							image.width = attachment.width;
							image.height = attachment.height;

							var imageJSON = JSON.stringify( image );

							$thisImage.attr('data-json', imageJSON);
							$thisImage.css('background-image', "url('" + image.url + "')");

							var galleryVal = $input.val();
							galleryVal = galleryVal.replace(imagesDataJSON, imageJSON);
							imagesDataJSON = imageJSON;
							imagesData = image;
							$input.val( galleryVal );
						});

						custom_uploader.open();
					});

					return $imagesContent;
				};

				var initialValue = $input.val();

				if( initialValue == '' ) {
					initialValue = [];
				} else {
					try {
						initialValue = JSON.parse( initialValue );

					} catch( e ) {

						try {
							initialValue = JSON.parse (initialValue.replace(/\\(.)/mg, "$1") );
						} catch ( e ) {
							initialValue = '[]';
						}
					}
				}


				var initialGalleryContent = renderImageGalleryContent(initialValue);
				$imageGalleryContent.html( initialGalleryContent );
				initSortable();

				$addButton.click(function(){
					var custom_uploader = wp.media({
						title: 'Select Image',
						button: { text: 'Select Image' },
						library : { type : 'image'},
						multiple: true  // Set this to true to allow multiple files to be selected
					});

					custom_uploader.on('select', function() {
						var selection = custom_uploader.state().get('selection');
						var selectionJSON = selection.toJSON();
						var ourSelection = [];

						$.each(selectionJSON, function( index, attachment ) {
							var oneImage = {};
							oneImage.id = attachment.id;
							oneImage.url = attachment.url;
							oneImage.width = attachment.width;
							oneImage.height = attachment.height;

							ourSelection.push( oneImage );
						});

						$imageGalleryContent.append(renderImageGalleryContent( ourSelection ));
						writeImageGalleryContentToInput();
						initSortable();

					});

					custom_uploader.open();

					// // Single
					// custom_uploader.on('open',function() {
					// 	var selection = custom_uploader.state().get('selection');
					// 	var jsoned_value = $imageLibraryButton.find('input').val();
					// 	if( jsoned_value ){ ; } else { return; }
					//
					// 	try {
					// 		obj = JSON.parse( jsoned_value );
					// 	} catch(err) {
					// 		return;
					// 	}
					//
					// 	if( obj ){ ; } else { return; }
					// 	var id = obj.id;
					//
					// 	var attachment = wp.media.attachment(id);
					// 	attachment.fetch();
					// 	selection.add( attachment ? [ attachment ] : [] );
					// });
					//

					// .open();


				});

			});
		},

		_initImagePicker: function( $elements ) {

			$elements.find('.ff-open-library-remove').click(function(){
				var $button = $(this).parents('.ff-open-image-library-button-wrapper-new').find('.ff-open-image-library-button-new');
				if ($button) {
					$button.removeClass('ff-bad-resolution');
					$button.find('input').val('');
					$button.find('input').change();
					$button.find('.ff-open-library-button-preview-image').css('background-image', 'none');
					$button.parents('.ff-open-image-library-button-wrapper-new').addClass('ff-empty');
					$button.parents('.ff-open-image-library-button-wrapper-new').find('.ff-open-library-button-preview-image-large').attr('src', '');
				}
			});

			var forceMaxWidthOnPreviewImage = function( $imageLibraryButton ) {
				var jsoned_value = $imageLibraryButton.find('input').val();
				try {
					var attachment = JSON.parse( jsoned_value );
				} catch(err) {
					return;
				}

				if( attachment.substitute != undefined ) {
					attachment = attachment.substitute;
				}

				if( attachment.id == -1 ) {
					attachment.url = ff_ark_core_plugin_url + '/builder/placeholders/' + attachment.url;
				}

				var maxPreviewImageWidth = 400;
				var $previewImageLarge = $imageLibraryButton.find('.ff-open-library-button-preview-image-large');

				$previewImageLarge.removeAttr('width');
				$previewImageLarge.removeAttr('height');

				$previewImageLarge.on('load', function(){

					var imageWidth = this.width;
					var imageHeight = this.height;


					if( imageWidth > maxPreviewImageWidth ) {
						var heightRatio = imageHeight / imageWidth;
						imageWidth = maxPreviewImageWidth;
						imageHeight = maxPreviewImageWidth * heightRatio;
					}

					$previewImageLarge.attr('width', imageWidth);
					$previewImageLarge.attr('height', imageHeight);
				//
				});

				$previewImageLarge.attr('src', attachment.url);




			};

			$elements.find('.ff-open-image-library-button-new').each(function(){
				forceMaxWidthOnPreviewImage( $(this) );
			});



			$elements.find('.ff-open-image-library-button-wrapper-new').mouseenter( function(){
				$(this).find('.ff-open-library-remove').css('visibility', 'visible');
			});

			$elements.find('.ff-open-image-library-button-wrapper-new').mouseleave( function(){
				$(this).find('.ff-open-library-remove').css('visibility', 'hidden');
			});

			$elements.find('.ff-open-image-library-button-new').click(function(e){

				var $imageLibraryButton = $(this);
				e.preventDefault();

				var custom_uploader = wp.media({
					title: 'Select Image',
					button: { text: 'Select Image' },
					library : { type : 'image'},
					// id: 103,
					multiple: false  // Set this to true to allow multiple files to be selected
				});

				// Multiple
				// custom_uploader.on('open',function() {
				// 	var selection = custom_uploader.state().get('selection');
				// 	ids = jQuery('#my_field_id').val().split(',');
				// 	ids.forEach(function(id) {
				// 		attachment = wp.media.attachment(id);
				// 		attachment.fetch();
				// 		selection.add( attachment ? [ attachment ] : [] );
				// 	});
				// });

				// Single
				custom_uploader.on('open',function() {
					var selection = custom_uploader.state().get('selection');
					var jsoned_value = $imageLibraryButton.find('input').val();
					if( jsoned_value ){ ; } else { return; }

					try {
						obj = JSON.parse( jsoned_value );
					} catch(err) {
						return;
					}

					if( obj ){ ; } else { return; }
					var id = obj.id;

					var attachment = wp.media.attachment(id);
					attachment.fetch();
					selection.add( attachment ? [ attachment ] : [] );
				});

				custom_uploader.on('select', function() {
					var attachment = custom_uploader.state().get('selection').first().toJSON();
					$imageLibraryButton.find('.custom_media_image').attr('src', attachment.url);

					j = { "id":attachment.id, "url":attachment.url, "width":attachment.width, "height":attachment.height };

					$imageLibraryButton.find('input').val( JSON.stringify( j ) );
					$imageLibraryButton.find('input').change();

					$imageLibraryButton.find('.ff-open-library-button-preview-image').css('background-image', 'url(' + attachment.url + ')');
					$imageLibraryButton.parents('.ff-open-image-library-button-wrapper-new').removeClass('ff-empty');

					 forceMaxWidthOnPreviewImage( $imageLibraryButton );
				})
				.open();
			});
		},

		_initRepeatableSortable: function( $element ) {
			var self = this;
			$element.find('.ff-repeatable')
				.filter(':not(.ff-toggle-box)')
				.sortable({
					handle : '.ff-repeatable-handle:not(.ff-repeatable-handle-toggle-box), .ff-repeatable-drag:not(.ff-repeatable-handle-toggle-box)',
					items: '.ff-repeatable-item:not(.ff-repeatable-item-empty-add, .ff-repeatable-item-toggle-box)',
					update:function() {
						self._actionOptionsChanged('updated');
					},
				});
		},


		_initColorLibrary: function( $elements ) {
			$elements.find('.fftm__option-type--color-picker').each(function(){
				var colorLibraryView = new frslib.options2.colorLibrary({ $option: $(this)});
			});

		},

        _initStyleSelect: function( $element ) {
            var self = this;

            $element.find('.ff-style-select').each(function(){

                var $input = $(this);

                    self._dataManager.getAllGlobalStyles( function( data ) {
                        ////// we need to check if the previously selected global styles already exists
                        var selectedValues = $input.val();
                        var newValues = [];

                        $.each(selectedValues.split('--||--'), function( index, value ){
                            var splittedValue = value.split('*|*');

                            var styleValue = splittedValue[0];
                            var styleName = splittedValue[1];

                            var exists = false;

                            $.each(data, function(index, existingValue ) {
                                if( existingValue.value == styleValue ) {
                                    exists = true;
                                }
                            });

                            if( exists ) {
                                newValues.push( styleValue + '*|*' + styleName);
                            }
                        });

                        newValues = newValues.join('--||--');
                        //
                        $input.val( newValues );

                        var stylesJSON = JSON.stringify( data );
                        $input.attr('data-select-values', stylesJSON );

                        var $parent = $input.parents('.ff-advanced-select-modal:first');

                        $parent.removeClass('ff-advanced-select-modal__not-initialize');
                        self._initFreshSelect( $parent.parent() );

                    });

            });

        },


        _initFreshSelect: function( $element ) {

            //$element.find('.ff-advanced-select-modal').each(function(){
            //    /*----------------------------------------------------------*/
            //    /* Variable Setting
            //    /*----------------------------------------------------------*/
            //    var $this = $(this);
            //    var $input = $this.find('.ff-opt');
            //    var $selectedItems = $this.find('.ff-advanced-select-modal__selected-items');
            //    var $placeholder = $this.find('.ff-advanced-select-modal__placeholder');
            //
            //
            //});
            //
            //
            //
            //
            //return;

            $element.find('.ff-advanced-select-modal').each(function() {
                if( $(this).hasClass('ff-advanced-select-modal__not-initialize') || $(this).hasClass('ff-advanced-select-modal__has-been-initalized') ) {
                    return true;
                }

                $(this).addClass('ff-advanced-select-modal__has-been-initalized');



                //$(this).addClass('sulin');






                var $this = $(this);
                var $input = $(this).find('.ff-opt');
                var $selectedItems = $this.find('.ff-advanced-select-modal__selected-items');
                var $placeholder = $this.find('.ff-advanced-select-modal__placeholder');

                var orderingType = $input.attr('data-ordering-type');

                /*----------------------------------------------------------*/
                /* GET SELECT VALUES
                 /*----------------------------------------------------------*/
                // get values and sort them alphabetically
                var getSelectValues = function() {
                    var isGroup = parseInt($input.attr('data-is-group') ) == 1 ? true : false;

                    var values;
                    try {
                        values = JSON.parse( $input.attr('data-select-values') );
                    if( values == null || values == 'null' ) {
                        values = [];
                    }
                    } catch (e) {
                        values = [];
                    }

                    //console.log(  $input.attr('data-select-values'), values );

                    if(  isGroup ) {
                        var newValues = [];


                        for( var name in values ) {
                            var oneGroup = values[ name ];

                            var newValue = {};
                            newValue.name = name;
                            newValue.value = 'ff-group-title';

                            newValues.push( newValue );


                            newValues = newValues.concat( oneGroup );

                        }

                        values = newValues;
                    }

                    //values = newValues;

                    if( !isGroup ) {
                        if (typeof values == 'object') {
                            values.sort(function (a, b) {
                                if (a.name < b.name) return -1;
                                if (a.name > b.name) return 1;
                                return 0;
                            });
                        }
                    }



                    return values;
                };

                //2*|*cat2--||--1*|*Uncategorized
                var getSelectedValues = function() {
                    var selected = [];

                    var inputVal = $input.val();

                    if( inputVal.indexOf('--||--') != -1 || inputVal.indexOf('*|*') != -1 ) {
                        if( inputVal.indexOf('*|*') != -1 ) {
                            var partSelected = inputVal.split('--||--');

                            for( var i in partSelected ) {
                                var oneValue = partSelected[ i ];
                                var splitted = oneValue.split( '*|*' );

                                selected.push( splitted[0] );
                            }

                        } else {
                            selected = inputVal.split('--||--');
                        }
                    } else {
                        try {
                            selected = JSON.parse( $input.val() );
                        } catch( e ) {
                            selected = [];
                        }
                    }


                    return selected;
                };


                var getCompleteInfoForSelectedValues = function( selectedValues ) {
                    if( typeof  selectedValues == 'string' ) {
                        var temporaryHolder = [];
                        temporaryHolder.push( selectedValues );
                        selectedValues = temporaryHolder;
                    }

                    var selectValues = getSelectValues();

                    var toReturn = [];

                    for( var i in selectedValues ) {
                        var oneSelectedValue = selectedValues[ i ];

                        for( var j in selectValues ) {
                            var oneSelectValueFull = selectValues[ j ];

                            if( oneSelectValueFull.value == oneSelectedValue ) {
                                toReturn.push( oneSelectValueFull );
                            }
                        }

                    }

                    return toReturn;
                };

                var setValue = function( selectedValues ){

                };

                var actualizeSelectedItems = function(){
                    var selectedValues = getSelectedValues();
                    var completeInfo =getCompleteInfoForSelectedValues( selectedValues);

                    var selectedItemsHtml = '';
                    for( var i in completeInfo ) {
                        var oneCompleteValue = completeInfo[i];

                        selectedItemsHtml += '<div class="ff-advannced-select-modal__one-item">' + oneCompleteValue.name + '</div>';
                    }

                    $selectedItems.html( selectedItemsHtml );

                    if( selectedValues.length == 0 ) {
                        $placeholder.css('display', 'block');
                    } else {
                        $placeholder.css('display', 'none');
                    }
                };



                actualizeSelectedItems();

                $input.on('ff-changed', actualizeSelectedItems);

                $this.click(function() {
                    var selectValues = getSelectValues();
                    var selected = getSelectedValues();


                    var content = '';

                    content += '<div class="ff-advanced-select-modal__content">';
                    content += '<div class="ff-advanced-select-modal__header">';
                    content += $input.attr('data-select-modal-title');
                    //content += 'Select Categories';
                    content += '</div>';
                    content += '<div class="ff-advanced-select-modal__content-body">';
                    content += '<div class="ff-advanced-select-modal__content-body-left">';
                    content += '<div class="ff-advanced-select-modal__content-body-left-header">';
                    content += '<input type="text" class="ff-advanced-select-modal__search" placeholder="Search..">';
                    content += '</div>';
                    content += '<div class="ff-advanced-select-modal__list-all-wrapper">';
                    content += '<div class="ff-advanced-select-modal__list-all">';

                    for( var i in selectValues ) {
                        var oneValue = selectValues[i];

                        var attrHelper = frslib.attr.createHelper();

                        if( oneValue.value == 'ff-group-title' ) {

                            attrHelper.addParam('class', 'ff-advanced-select-modal__list-group-title');

                            // if( selected.indexOf( oneValue.value) != -1 ) {
                            // 	attrHelper.addParam('class', 'ff-advanced-select-modal__list-all-item--active');
                            // }

                            attrHelper.addParam('data-value', oneValue.value);

                        } else {

                            attrHelper.addParam('class', 'ff-advanced-select-modal__list-all-item');

                            if( selected.indexOf( oneValue.value) != -1 ) {
                                attrHelper.addParam('class', 'ff-advanced-select-modal__list-all-item--active');
                            }

                            attrHelper.addParam('data-value', oneValue.value);
                        }


                        content += '<div ' + attrHelper.getAttrString() + '>' + oneValue.name + '</div>'
                    }


                    content += '</div>';
                    content += '</div>';
                    content += '<div class="ff-advanced-select-modal__content-body-left-footer">';
                    content += '</div>';
                    content += '</div>';
                    content += '<div class="ff-advanced-select-modal__content-body-right">';
                    content += '<div class="ff-advanced-select-modal__content-body-right-header">';
                    content += '<div class="ff-advanced-select-modal__filters-wrapper">';
                    content += '<div class="ff-advanced-select-modal__select-order-by">Order by: ';

                    content += '<select class="ff-advanced-select-modal__select-order-by--select">';
                    content += '<option value="name">Name</option>';
                    content += '<option value="manually">Manually</option>';
                    content += '</select>';
                    content += '</div>';
                    content += '<div class="ff-advanced-select-modal__select-order" style="display:none;">Order: ';
                    content += '<select class="ff-advanced-select-modal__select-order--select">';
                    content += '<option>Asc</option>';
                    content += '<option>Desc</option>';
                    content += '</select>';
                    content += '</div>';
                    // content += '<div class="ff-advanced-select-modal__remove-all">Clear list</div>';
                    content += '</div>';
                    content += '</div>';
                    content += '<div class="ff-advanced-select-modal__list-selected-wrapper">';
                    content += '<div class="ff-advanced-select-modal__list-selected">';
                    var selectedValues = getSelectedValues();
                    var completeSelectedValues = getCompleteInfoForSelectedValues( selectedValues );


                    for( var i in completeSelectedValues ) {
                        var oneSelected = completeSelectedValues[ i ];

                        var attrHelper = frslib.attr.createHelper();
                        attrHelper.addParam('class', 'ff-advanced-select-modal__list-selected-item');
                        attrHelper.addParam('data-value', oneSelected.value );
                        content += '<div ' + attrHelper.getAttrString() + '>' + oneSelected.name + '</div>';
                    }

                    content += '</div>';
                    content += '</div>';
                    content += '<div class="ff-advanced-select-modal__content-body-right-footer">';
                    content += '</div>';
                    content += '</div>';
                    content += '<div class="ff-advanced-select-modal__footer">';
	                    content += '<a href="#" class="ffb-modal__button-save_all ffb-modal__action-save-all-fresh-select ff-advanced-select-modal__quick-save-button">Quick Save</a>';
	                    content += '<div class="ff-advanced-select-modal__action-btn ff-advanced-select-modal__action-select-all">All/None</div>';
                    	// content += '<div class="ff-advanced-select-modal__action-btn ff-advanced-select-modal__action-clear-list">Clear list</div>';
                    content += '<div class="ff-advanced-select-modal__action-btn ff-advanced-select-modal__action-cancel">Cancel</div>';
                    content += '<div class="ff-advanced-select-modal__action-btn ff-advanced-select-modal__action-save ff-advanced-select-modal">Save Changes</div>';
                    content += '</div>';
                    content += '</div>';
                    content += '</div>';

                    var $content = $(content);

                    var $orderBySelect = $content.find('.ff-advanced-select-modal__select-order-by--select');
                    var $orderSelect = $content.find('.ff-advanced-select-modal__select-order--select');

                    if( orderingType = 'manually-only' ) {
                        $orderBySelect.attr('disabled', 'disabled');
                    }

                    var modal = $.freshfaceBox($content,function(){}, {overlayBackground: true});

                    var getCurrentFormValue = function() {
                        var values = [];
                        $content.find('.ff-advanced-select-modal__list-selected-item').each(function(){
                            var oneValue = $(this).attr('data-value');
                            values.push( oneValue );
                        });

                        return values;
                    };

                    var solveOrdering = function( firstRun ) {



                        var selectedValues = getCurrentFormValue();
                        var completeSelectedValuesUnsorted = getCompleteInfoForSelectedValues( selectedValues );

                        var unsortedJSON = JSON.stringify(completeSelectedValuesUnsorted);

                        completeSelectedValuesUnsorted.sort(function( a, b ){
                            if(a.name < b.name) return -1;
                            if(a.name > b.name) return 1;
                            return 0;
                        });

                        var sortedJSON = JSON.stringify( completeSelectedValuesUnsorted );

                        if( unsortedJSON == sortedJSON ) {
                            $orderBySelect.val('name');
                        } else {
                            $orderBySelect.val('manually');
                        }

                        if( orderingType == 'manually-only' ) {
                            $orderBySelect.val('manually');
                        }


                    };
                    solveOrdering(true);

                    /*----------------------------------------------------------*/
                    /* SORTING FUNCTION
                     /*----------------------------------------------------------*/
                    var sortSelected = function() {
                        var $toSort = $content.find('.ff-advanced-select-modal__list-selected-item');
                        var $sorted = $toSort.sort(function(a,b){
                            var contentA = $(a).html();
                            var contentB = $(b).html();

                            if(contentA < contentB) return -1;
                            if(contentA > contentB) return 1;
                            return 0;
                        });

                        $toSort.remove();
                        $content.find('.ff-advanced-select-modal__list-selected').append($sorted);
                    };

                    /*----------------------------------------------------------*/
                    /* SORTABLE
                     /*----------------------------------------------------------*/
                    $content.find('.ff-advanced-select-modal__list-selected').sortable({
						cursor: 'move',
						// tolerance: 'pointer',
						cursorAt: { left:-5, top:-5 },
						placeholder: 'ui-sortable-placeholder',
                        update:function( event, ui ){
                            $orderBySelect.val('manually');
                            solveOrdering();
                        }
                    });

                    /*----------------------------------------------------------*/
                    /* SELECT CHANGE
                     /*----------------------------------------------------------*/
                    $orderBySelect.on('change', function(){
                        var value = $(this).val();

                        if( value == 'name' ) {
                            sortSelected();
                        }
                    });

                    /*----------------------------------------------------------*/
                    /* ADDING NEW ITEM
                     /*----------------------------------------------------------*/
                    $content.on('click', '.ff-advanced-select-modal__list-all-item', function(){
                        var $clickedItem = $(this);

                        if( $clickedItem.hasClass('ff-advanced-select-modal__list-all-item--active') ) {
                            var value = $clickedItem.attr('data-value');

                            $content.find('.ff-advanced-select-modal__list-selected-item').each(function(){

                                if( $(this).attr('data-value') == value ) {
                                    $(this).animate({opacity:0}, 250, function(){
                                        $(this).remove();
                                    });
                                }

                            });

                            $clickedItem.removeClass('ff-advanced-select-modal__list-all-item--active')
                            return;
                        }

                        $clickedItem.addClass('ff-advanced-select-modal__list-all-item--active');
                        var selectedInfo = getCompleteInfoForSelectedValues( $clickedItem.attr('data-value') ).pop();

                        var attrHelper = frslib.attr.createHelper();
                        attrHelper.addParam('class', 'ff-advanced-select-modal__list-selected-item');
                        attrHelper.addParam('data-value', selectedInfo.value );
                        var selectedItem = '<div ' + attrHelper.getAttrString() + '>' + selectedInfo.name + '</div>';
                        var $selectedItem = $(selectedItem);
                        $selectedItem.css('opacity', 0);
                        $content.find('.ff-advanced-select-modal__list-selected').append( $selectedItem );

                        if( $orderBySelect.val() == 'name' ) {
                            sortSelected();
                        }

                        $selectedItem.animate({opacity:1}, 300);
                    });

                    /*----------------------------------------------------------*/
                    /* REMOVING SELECTED ITEM
                     /*----------------------------------------------------------*/
                    $content.on('click', '.ff-advanced-select-modal__list-selected-item', function(){
                        var currentlySelectedValue = $(this).attr('data-value');

                        $content.find('.ff-advanced-select-modal__list-all').find('.ff-advanced-select-modal__list-all-item').each(function(){
                            if( $(this).attr('data-value') == currentlySelectedValue ) {
                                $(this).removeClass('ff-advanced-select-modal__list-all-item--active');
                            }
                        });

                        $(this).animate({opacity:0}, 250, function(){
                            $(this).remove();
                        });
                    });

                    /*----------------------------------------------------------*/
                    /* SEARCH
                     /*----------------------------------------------------------*/
                    $content.find('.ff-advanced-select-modal__search').on('keyup', function(){
                        // var value = $(this).val().toLowerCase();
                        //
                        // $content.find('.ff-advanced-select-modal__list-all-item').each(function(){
                        // 	var currentName = $(this).html().toLowerCase();
                        //
                        // 	var currentValue = $(this).attr('data-value').toLowerCase();
                        //
                        // 	var hide = true;
                        //
                        // 	if( currentName.indexOf( value ) != - 1 ) {
                        // 		hide = false;
                        // 	}
                        //
                        // 	if( currentValue.indexOf( value ) != -1 ) {
                        // 		hide = false;
                        // 	}
                        //
                        // 	if( hide ) {
                        // 		$(this).css('display', 'none');
                        // 	} else {
                        // 		$(this).css('display', 'block');
                        // 	}
                        // });
                    });
                    var saveFreshSelect = function() {
                        var values = getCurrentFormValue();

                        var valueJSON = JSON.stringify( values );
                        $input.val( valueJSON );
                        actualizeSelectedItems();

                        var savingType = $input.attr('data-saving-type');

                        if( savingType == 'freshformat' ) {
                            var valuesNotJoined = [];

                            $content.find('.ff-advanced-select-modal__list-selected-item').each(function(){
                                var oneLine = $(this).attr('data-value') + '*|*' + $(this).html();
                                valuesNotJoined.push( oneLine );
                            });

                            values = valuesNotJoined.join('--||--');


                            $input.val( values );
                            // $input.addClass('hovno');
                            // $input.attr('kokotik', values);
                            // $input.attr('value', values);
                        } else if( savingType == 'json' ) {
                            var values = [];
                        }
                    };
                    /*----------------------------------------------------------*/
                    /* SAVING
                     /*----------------------------------------------------------*/
                    $content.on('click', '.ff-advanced-select-modal__action-save', function(){
                        saveFreshSelect();

                        modal.close();
                    });

                    $content.on('click', '.ffb-modal__action-save-all-fresh-select', function(){
                        saveFreshSelect();
                        $('.ffb-modal__action-save-all:first').trigger('click');

                    });

                    /*----------------------------------------------------------*/
                    /* CANCEL
                     /*----------------------------------------------------------*/
                    $content.on('click', '.ff-advanced-select-modal__action-cancel', function () {
                        modal.close();
                    });

                    //$content.find('.ff-advanced-select-modal__action-select-al').click(function(){
                    //
                    //    alert('clicked');
                    //
                    //});

                    /*----------------------------------------------------------*/
                    /* CLEAR LIST
                     /*----------------------------------------------------------*/
                    $content.find('.ff-advanced-select-modal__action-select-none').click(function(){
                        $content.find('.ff-advanced-select-modal__list-selected-item').animate({opacity:0}, 300, function(){
                            $(this).remove();
                        });

                        $content.find('.ff-advanced-select-modal__list-all-item--active').removeClass('ff-advanced-select-modal__list-all-item--active');
                    });

                    /*----------------------------------------------------------*/
                    /* SELECT ALL
                     /*----------------------------------------------------------*/
                    $content.find('.ff-advanced-select-modal__action-select-all').click(function(){

                        var $allItems = $('.ff-advanced-select-modal__list-all-item');

                        var allItemsCount = $allItems.length;
                        var selectedItemsCount = $allItems.filter('.ff-advanced-select-modal__list-all-item--active').length;

                        // all selected - all disable
                        if( allItemsCount == selectedItemsCount ) {
                            $content.find('.ff-advanced-select-modal__list-selected-item').animate({opacity:0}, 300, function(){
                                $(this).remove();
                            });

                            $content.find('.ff-advanced-select-modal__list-all-item--active').removeClass('ff-advanced-select-modal__list-all-item--active');
                        } else {
                            $content.find('.ff-advanced-select-modal__list-all-item').each(function () {
                                if( !$(this).hasClass('ff-advanced-select-modal__list-all-item--active') ) {
                                    $(this).trigger('click');
                                }
                            });
                        }

                    });
                });

            });

        },


		/*----------------------------------------------------------*/
		/* OPEN AND CLOSE
		/*----------------------------------------------------------*/
		_initRepeatableOpenAndClose: function( $element ) {

			var closeElement = function( $elementToClose ) {
				$elementToClose.addClass('ff-repeatable-item-closed').removeClass('ff-repeatable-item-opened');
				$elementToClose.find('.ff-repeatable-content').css('display', 'none');
			};

			var openElement = function( $elementToOpen ) {
				$elementToOpen.addClass('ff-repeatable-item-opened').removeClass('ff-repeatable-item-closed');
				$elementToOpen.find('.ff-repeatable-content:first').css('display', 'block');
			};

			$element.find('.ff-repeatable-handle').click(function(e){
				e.stopPropagation();
				var $item = $(this).parents('.ff-repeatable-item:first');

				if( $item.hasClass('ff-repeatable-item-opened') ) {
					closeElement( $item );
				} else {
					openElement( $item );
				}
			});

			$element.find('.ff-all-items-opened').each(function(){

				$(this).children().each(function(){
					openElement( $(this) );
				});

			});

		},

		_initRepeatableAdd: function( $element ) {
			var self = this;
			$element.find('.ff-repeatable-add-above').click(function(e){

				var modal = new frslib.options2.modal();
				var $item = $(this).parents('.ff-repeatable-item:first');
				var route = $item.attr('data-rep-variable-section-route');

				var childs = self._optionsPrinter.getSectionChilds( route );
				e.stopPropagation();

				modal.printMenu( childs, function(value){
					var renderingRoute = route + ' ' + value;

					var newHtml = self._optionsPrinter.printNewPart( renderingRoute  );

					var $html = $(newHtml );

					$html.css('display', 'none');
					$item.before( $html );

					$item.parents('.ff-repeatable:first').trigger('repeatable-changed');
					$html.find('.ff-repeatable-item:not(.ff-repeatable-item-empty-add, .ff-repeatable-item-toggle-box)').remove();
					self._initOptions( $html );
					self._initOptionsAfterInsert( $html );
					$html.show(300);
				});
			});
		},

		_initFullFonts: function( $elements ) {
			var self = this;

			var $fonts =$elements.find('.ff-opt-type-font');
			if( $fonts.size() == 0 ) {
				return;
			}

			self._dataManager.getAllGoogleFonts( function( data ) {

				var html = self._dataManager.getSelectHtmlFromArray( data );

				$fonts.each(function () {
					var value = $(this).attr('data-user-value');

					$(this).find('.GoogleFonts').html( html );
					$(this).val( value );
					$(this).trigger('change');
					self._initSelect2OnInput( $(this), {allowClear: false});
				});
			});


			$fonts.on('change', function(){
				if( $(this).val() ){

				} else{
					return;
				}

				if( $(this).val().indexOf(',') != -1 ){

					$(this).parents('.ff-font-option-holder').find('.font-example').css('font-family', $(this).val() );
					return;

				}

				var font_name = $(this).val().replace(/\'/g,'');

				var css_id = font_name.replace(/ /g,'_');

				if( 0 == $( '#' + css_id ).size()){
					var css_link = '//fonts.googleapis.com/css?family='+font_name+':300italic,400italic,600italic,300,400,600&subset=latin,latin-ext';
					var css_html = '<link rel="stylesheet" id="'+css_id+'" href="'+css_link+'" type="text/css" media="all" />';
					$('head').append(css_html);
				}
				$(this).parents('.ff-font-option-holder').find('.font-example').css('font-family',$(this).val());
			});
		},

		/*----------------------------------------------------------*/
		/* POPUP
		/*----------------------------------------------------------*/
		_initRepeatablePopup: function( $elements ) {
			var self = this;



			var showContextMenuForElement = function( $element ) {

				var route = $element.attr('data-rep-variable-section-route');

				var childs = self._optionsPrinter.getSectionChilds( route );

				var childsBefore = [];
				var childsAfter = [];
				for( var i in childs ) {
					var oneChild = childs[ i ];

					var newChildBefore = {};
					var newChildAfter = {};

					newChildBefore.name = oneChild.name;
					newChildAfter.name = oneChild.name;

					newChildBefore.value = 'add-before-' + oneChild.value;
					newChildAfter.value = 'add-after-' + oneChild.value;

					childsBefore.push( newChildBefore );
					childsAfter.push( newChildAfter );
				}

				var contextMenuItems = [
					{ name: 'Add Above', value: 'add-before', childs : childsBefore },
					{ name: 'Add Below', value: 'add-after', childs : childsAfter },
					 { name: 'Duplicate<div class="ff-modal-menu-divider"></div>', value: 'duplicate'},
					 { name: 'Copy', value: 'copy'},
					 { name: 'Paste', value: 'paste', childs: [
					 	{ name : 'Before', value: 'paste-before'},
					 	{ name : 'After', value: 'paste-after'}
					 ]},

					{ name: 'Delete<div class="ff-modal-menu-divider"></div>', value: 'delete'}
				];


				var modal = new frslib.options2.modal();

				modal.printMenu( contextMenuItems, function( action ){
					switch( action ) {
						case 'delete' :
							self._actionRepeatableRemove( $element );
							break;

						case 'duplicate':
							self._actionRepeatableDuplicate( $element );
							break;
						case 'copy':
							self._actionRepeatableCopy( $element );
							break;

						case 'paste-before':
							self._actionRepeatablePaste( $element, 'before' );
							break;
						case 'paste-after':
							self._actionRepeatablePaste( $element, 'after' );
							break;

						default:
							var itemToAddName;
							var newAction;
							if( action.indexOf('add-before-') != -1 ) {
								newAction = 'add-before';
								itemToAddName = action.replace('add-before-', '');
							} else {
								newAction = 'add-after';
								itemToAddName = action.replace('add-after-', '');
							}

							console.log( newAction );

							var route = $element.attr('data-rep-variable-section-route');
							var renderingRoute = route + ' ' + itemToAddName;

							var newHtml = self._optionsPrinter.printNewPart( renderingRoute  );

							var $html = $(newHtml );
							$html.css('display', 'none');

							if( newAction == 'add-before') {
								$element.before( $html );
							} else {
								$element.after( $html );
							}

							//$element.before( $html );

							$element.parents('.ff-repeatable:first').trigger('repeatable-changed');
							$html.find('.ff-repeatable-item:not(.ff-repeatable-item-empty-add, .ff-repeatable-item-toggle-box)').remove();
							self._initOptions( $html );
							self._initOptionsAfterInsert( $html );
							$html.show(300);



							break;
					}

				});
			}

			$elements.find('.ff-repeatable-settings').click(function(e){
				var $parent = $(this).parents('.ff-repeatable-item:first');
				if( $parent.hasClass('ff-repeatable-item-toggle-box') ) {
					return;
				}
				e.stopPropagation();
				showContextMenuForElement( $parent );
				return false;
			});

			$elements.find('.ff-repeatable-item').addBack('.ff-repeatable-item').contextmenu(function(e){
				if( $(this).hasClass('ff-repeatable-item-toggle-box') ) {
					return;
				}
				e.stopPropagation();
				showContextMenuForElement( $(this) );
				return false;
			});
		},

		_actionRepeatableRemove: function( $element ) {

			var $parentList = $element.parents('.ff-repeatable:first');

			if( !$parentList.hasClass('ff-can-be-empty') ) {
				var numberOfChilds = $parentList.children('.ff-repeatable-item:not(.ff-repeatable-item-empty-add)').size();

				if( numberOfChilds == 1 ) {
					$element.animate({ left:-10},200).animate({ left:10},200).animate({ left:0},200);

					return false;
				}

			}
			var modal = new frslib.options2.modal();

			modal.printConfirmBox('Are you sure you want to delete it? ', function( result ){
				if( result == true ) {

					$element.slideUp(300, function(){
						var $repeatableParent =$element.parents('.ff-repeatable:first');
						$element.remove();
						$repeatableParent.trigger('repeatable-changed');
					});
				}
			});

		},

		_actionRepeatableCopy: function( $element ) {

            var toPaste = this._actionRepeatable_copyElement( $element );
            //this._actionRepeatable_pasteElement($element, toPaste );
            var toPasteJSON = JSON.stringify( toPaste );
            frslib.clipboard.copyTo( toPasteJSON );
            alert( 'Data has been copied to clipboard');
		},

		_actionRepeatablePaste: function( $element, whereToPaste ) {
			var toPasteJSON = frslib.clipboard.pasteFrom();
            var toPaste = JSON.parse( toPasteJSON );
            //this._actionRepeatable_pasteElement($element, toPaste );

            var pasteAfter = false
            if( whereToPaste == 'after' ) {
                pasteAfter  =true;
            }

            this._actionRepeatable_pasteElement($element, toPaste, pasteAfter );

            return;
		},

        _actionRepeatable_copyElement: function( $element ) {
            var currentRoute = $element.attr('data-current-name-route');
            var newCleanRoute = currentRoute;

            var currentIndex = $element.index();
            var currentDepth = null;
            var $repeatableParents = $element.parents('.ff-repeatable, .ff-repeatable-item');
            $repeatableParents.each(function(){
                var $this = $(this);

                if( $this.hasClass('ff-repeatable-item') ) {
                    currentIndex = $this.index();
                } else if( $this.hasClass('ff-repeatable') ) {
                    currentDepth = $this.attr('data-current-level');


                    currentRoute = currentRoute.replace('-_-'+currentDepth+'-TEMPLATE-_-', currentIndex);
                    newCleanRoute = newCleanRoute.replace('-_-'+currentDepth+'-TEMPLATE-_-', 0);
                }
            });

            var getPathFromNameRoute = function( nameRoute ){
                // TODO TODO TODO
                //var firstBracket = nameRoute.indexOf('[');
                nameRoute = nameRoute.replace('default[', '').split('][').join(' ').replace(']', '');

                return nameRoute;
            };

            currentRoute = getPathFromNameRoute(currentRoute);
            newCleanRoute = getPathFromNameRoute(newCleanRoute);
            var formValue = ( this._formParser.parseForm( this.$el ));
            var query = new frslib.options2.query();
            query.setData( formValue );
            var justNodeValue = query.getWithoutComparation(currentRoute, true);

            var newQuery = new frslib.options2.query();
            newQuery.setData({});
            newQuery.set(newCleanRoute, justNodeValue);

            //console.log( newQuery._data );


            var route = $element.attr('data-rep-variable-section-route');
            route += ' ' + $element.attr('data-section-id');

            var toPaste = {};
            toPaste.route = route;
            toPaste.data = frslib.clone( newQuery._data );

            return toPaste;
        },

        _actionRepeatable_pasteElement: function($element, toPaste, pasteAfter ) {
            var route = toPaste.route;
            var data = toPaste.data;

            var newHtml = this._optionsPrinter.printNewPart( route, data   );

            var $html = $(newHtml );
            $html.css('display', 'none');

            //if( newAction == 'add-before') {
            if( pasteAfter ) {
                $element.after( $html );
            } else {
                $element.before( $html );
            }

            //} else {
            //    $element.after( $html );
            //}

            //$element.before( $html );

            $element.parents('.ff-repeatable:first').trigger('repeatable-changed');
            $html.find('.ff-repeatable-item:not(.ff-repeatable-item-empty-add, .ff-repeatable-item-toggle-box)').remove();
            this._initOptions( $html );
            this._initOptionsAfterInsert( $html );
            $html.show(300);
        },

		_actionRepeatableDuplicate: function( $element ){
            var toPaste = this._actionRepeatable_copyElement( $element );
            this._actionRepeatable_pasteElement($element, toPaste );


		},



		_initHidingBox: function( $element ) {
			setTimeout(function(){
			$element.find('.ff-hiding-box, .ff-hiding-box-normal').each(function(){
				var $hidingBox = $(this);

				var optionName = $hidingBox.attr('data-option-name');
				var optionValue = $hidingBox.attr('data-option-value').split(',');

				var optionOperator = $hidingBox.attr('data-option-operator');

				var parentSelector = $hidingBox.attr('data-parent-selector');

				var $parent;

				if( parentSelector == undefined ) {
					$parent = $hidingBox.closest('.ff-repeatable-content, .ff-options, .ff-hiding-box-parent, .ff-options2');
				} else {
					$parent = $hidingBox.closest( parentSelector );
				}


				var $actionInput = $parent.find('.ff-opt-' + optionName + ':first');
				var compareHidingBox = function(){

					var actionInputValue;

					if( $actionInput.attr('type') == 'checkbox' ) {
						actionInputValue = $actionInput.prop('checked');

						if( actionInputValue ) {
							actionInputValue = 'checked';
						} else {
							actionInputValue = 'unchecked';
						}

					} else {
						actionInputValue = $actionInput.val();
					}

					if( optionOperator == 'equal' ) {
						if( optionValue.indexOf(actionInputValue) != -1  ) {
							$hidingBox.stop(true, false).show(500);

						} else {
							$hidingBox.stop(true, false).hide(500);
						}
					}
					else {
						if( optionValue.indexOf(actionInputValue) == -1 ) {
							$hidingBox.stop(true, false).show(500);
						} else {
							$hidingBox.stop(true, false).hide(500);
						}
					}
				};

				compareHidingBox();

				$actionInput.on('change', function(){
					compareHidingBox();
				});

			});
			},50);
		},

		getQuery: function( data ) {
			var query = new frslib.options2.query();

			query.setStructure( this._optionsPrinter.getStructure() );
			if( data != undefined ) {
				query.setData( data );
			}

			return query;
		},

		getQueryWithOldData: function() {
			var query = this.getQuery( this._optionsPrinter.getData() );

			return query;
		},

		getQueryWithNewData: function() {
			var newData = this.parseForm();

			var query = this.getQuery( newData );

			return query;
		},

		setData: function( data ) {
			this._optionsPrinter.setData( data );
		},

		setStructure: function( structure ) {
			this._optionsPrinter.setStructure( structure );
		},

		setBlocks: function( blockCallback ) {
			this._optionsPrinter.setBlocks( blockCallback )
		},

		setPrefix: function( prefix ) {
			this._optionsPrinter.setPrefix( prefix);
		},

		_getAttrHelper : function() {
			return frslib.attr.createHelper();
		},

	});

})(jQuery);

