(function($) {

    frslib.provide('frslib.options.themebuilder');
    frslib.provide('frslib.options.themebuilder');

/**********************************************************************************************************************/
/* INIT CONTENT BLOCK
/**********************************************************************************************************************/
	frslib.options.themebuilder.initContentBlock = function( $options ) {
		$options.find('.ff-content-block-area').each(function(){
			var $this = $(this);

			$this.on('click', '.ff-post-edit-link', function(){
				var value = $this.find('.select2-container').select2('val');


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
	};

	frslib.callbacks.addCallback( 'initOneOptionSet', frslib.options.themebuilder.initContentBlock );
	frslib.callbacks.addCallback( 'options-section-inserted', frslib.options.themebuilder.initContentBlock );
/**********************************************************************************************************************/
/* CUSTOM CSS CODE BUILDER
/**********************************************************************************************************************/
	frslib.options.themebuilder.initValuesInCustomCssCodeBuilder = function( $options ) {
		$options.find('.ffb-custom-css-code-wrapper').each(function(){
			var $modalParent = $(this).parents('.ffb-modal__content--options:first');

			var value = $modalParent.find('.ff-insert-unique-css-class:first').html();

			var selectorsArray = value.split(' ');
			var numberOfSelectors = selectorsArray.length;

			var selectorArray = new Array();
			for( var i = 1; i <= numberOfSelectors; i++ ) {
				selectorArray.push('%s' + i);
			}

			var selectorString = selectorArray.join(' ');
			
			$modalParent.find('.ff-opt-slct').val( selectorString );
		});

	};

	frslib.options.themebuilder.initCustomCssCodeBuilder = function( $options ) {
		var minWidth = {};
		minWidth['xs'] = 320;
		minWidth['sm'] = 768;
		minWidth['md'] = 992;
		minWidth['lg'] = 1200;

		var maxWidth = {};
		maxWidth['xs'] = 767;
		maxWidth['sm'] = 991;
		maxWidth['md'] = 1199;



		$options.find('.ffb-custom-css-code-wrapper').each(function(){
			var $this = $(this);

			var $viewportMin = $this.find('.ff-opt-min');
			var $viewportMax = $this.find('.ff-opt-max');
			var $selector = $this.find('.ff-opt-slct');

			// var $before = $this.find('.ffb-custom-code-before');

			// var $after = $this.find('.ffb-custom-code-after');

			var writeCustomCodeDetails = function() {

				var $modalParent = $this.parents('.ffb-modal__content--options:first');
				var value = $modalParent.find('.ff-insert-unique-css-class:first').html();
				var selectorsArray = value.split(' ');
				var numberOfSelectors = selectorsArray.length;

				// finalised strings
				var stringMediaQueryBeginning = '';
				var stringMediaQueryEnd = '';
				var stringSelector = '';

				var viewportMin = $viewportMin.val();
				var viewportMax = $viewportMax.val();
				var selector = $selector.val();

				var mediaQueryArray = [];

				if( viewportMin.length > 0 ) {
					var viewportMinString = 'min-width:' + minWidth[ viewportMin ] + 'px';
					mediaQueryArray.push( viewportMinString );
				}

				if( viewportMax.length > 0 ) {
					var viewportMaxString = 'max-width:' + maxWidth[ viewportMax ] + 'px';
					mediaQueryArray.push( viewportMaxString );
				}

				if( mediaQueryArray.length > 0 ) {
					stringMediaQueryBeginning = '@media (' + mediaQueryArray.join(' and ') + ') {';
					stringMediaQueryEnd = '}';
				}

				for( var i = 1; i <= numberOfSelectors; i ++ ) {
					var currentSelector = selectorsArray[i-1];

					selector = selector.replace('%s'+i, currentSelector );
				}

				stringSelector += selector;
				stringSelector += ' {';





				$this.find('.ff-media-query-before').html( stringMediaQueryBeginning );
				$this.find('.ff-media-query-after').html( stringMediaQueryEnd );
				$this.find('.ff-selector').html( stringSelector );
			};


			$viewportMin.change(function(){
				writeCustomCodeDetails();
			});

			$viewportMax.change(function(){
				writeCustomCodeDetails();
			});

			$selector.keyup(function(){
				writeCustomCodeDetails();
			});

			// $whitespace.change(function(){
			// 	writeCustomCodeDetails();
			// });

			writeCustomCodeDetails();
			setTimeout(function(){writeCustomCodeDetails();}, 1000);
		});
		//ffb-custom-css-code-wrapper
	};

	frslib.callbacks.addCallback( 'options-section-inserted', frslib.options.themebuilder.initValuesInCustomCssCodeBuilder );
	frslib.callbacks.addCallback( 'options-section-inserted', frslib.options.themebuilder.initCustomCssCodeBuilder );
	frslib.callbacks.addCallback( 'initOneOptionSet', frslib.options.themebuilder.initCustomCssCodeBuilder );


/**********************************************************************************************************************/
/* DEFUALT CONTENT IMAGE
/**********************************************************************************************************************/

	frslib.options.themebuilder.defaultImagePlaceholdersData = null;

	frslib.options.themebuilder.initDefaultContentImage = function( $options ) {
		var initQtipOnOptions = function(){

			$options.find('.ff-default-content-img').each(function(){

				var $this = $(this);
				var $input = $this.parent().find('input.ff-image');
				var $previewSmall = $this.parent().find('.ff-open-library-button-preview-image');
				var $previewLarge = $this.parent().find('.ff-open-library-button-preview-image-large');


				$(this).qtip({
					content: {
						text:
							function(){
								var i;
								var $holder = $('<div class="ff-default-image-placeholder-qtip"><ul></ul></div>');

								var images = frslib.options.themebuilder.defaultImagePlaceholdersData;

								$holder.css('background-color', 'white');

								for( i in images ) {
									var oneImage = images[i];


									var $image = $('<li><img></li>');
									$image.css('padding', 20);

									$image.find('img').attr('src', oneImage.url_real);

									$image.data('oneImage', oneImage );
									// $image.attr('data-image', JSON.stringify( oneImage ) );

									$image.click(function(){
										$this.qtip().hide();
										oneImage = $(this).data('oneImage');

										var imageValue = JSON.parse( JSON.stringify( oneImage ) );
										delete imageValue.url_real;

										$input.val( JSON.stringify( imageValue ) );
										$previewSmall.css('background-image', "url('" + oneImage.url_real +"')");
										$previewLarge.attr('src', oneImage.url_real );
									});

									$holder.children().append( $image );
								}

								return $holder;

							}
					},
					show: {
						event: 'click',
						effect: false, // disable fading animation
						modal: {
							on: true, // turn on modal plugin
							effect: false, // disable fading animation
							blur: true, // hide tooltip by clicking backdrop
							escape: true // hide tooltip when ESC pressed
						}
					},
					hide: {
						event: 'unfocus',
						effect: false, // disable fading animation
					},
					position: {
						target: $(this),
						adjust: {
							mouse: false // not following the mouse
						},
						viewport: $(window) // force tooltip to stay inside viewport
					},
					style: {
						tip: {
							corner: false
						},
						classes: ''
					},

					events: {

						show: function (event, api) {
							// console.log('ppppppppppp');
						}
					}
				});

			});
		}

		if( frslib.options.themebuilder.defaultImagePlaceholdersData == null ) {

			var data = {};

			data.action = 'getDefaultElementPlaceholders';

			frslib.ajax.frameworkRequest('ff-builder-load-placeholders', null, data, function( response ) {
				frslib.options.themebuilder.defaultImagePlaceholdersData = JSON.parse( response );

				initQtipOnOptions();
			});


		} else {
			initQtipOnOptions();
		}



		$options.find('.ff-default-content-img').click(function(){

		});
	};

	frslib.callbacks.addCallback( 'initOneOptionSet', frslib.options.themebuilder.initDefaultContentImage );
	frslib.callbacks.addCallback( 'options-section-inserted', frslib.options.themebuilder.initDefaultContentImage );
	//ff-default-content-img


	//ff-option-gfont-selector
/**********************************************************************************************************************/
/* INIT TABS
/**********************************************************************************************************************/

	/*----------------------------------------------------------*/
	/* INIT TABS
	 /*----------------------------------------------------------*/
	/**
	 * Tabs in the modal window
	 * @param $options
	 */

	frslib.options.themebuilder.availableGoogleFonts = null;
	frslib.options.themebuilder.initGfontSelector = function( $options ) {

		var initGoogleFontSelector = null;

		initGoogleFontSelector = function() {
			var fonts = frslib.options.themebuilder.availableGoogleFonts;
			$options.find('.ff-option-gfont-selector').each(function(){
				var $self = $(this);

				var selectedValue = $self.attr('data-selected-value');
				var $newData = $('<div></div>');
				var i;

				for( i in fonts ) {
					var newFont = fonts[i];

					var $newOption = $('<option></option>');

					$newOption.html( newFont );
					$newOption.attr('value', newFont );

					$newData.append( $newOption );
				}

				var newDataHtml = $newData.html();

				$self.html( $self.html() + newDataHtml );

				$self.find('option[value="' + selectedValue + '"]').attr('selected', 'selected');

				try {
					$self.select2({allowClear: true, containerCssClass: 'ff-select2-minwidth', dropdownCssClass:'ff-select2'});
				} catch (e ) {

				}


			});
		};

		// load available google fonts via ajax
		if( $options.find('.ff-option-gfont-selector').size() > 0 && frslib.options.themebuilder.availableGoogleFonts == null  ) {
			frslib.ajax.frameworkRequest('theme-get-available-google-fonts', null, null, function( response ) {
				var fontsArray = JSON.parse( response );

				frslib.options.themebuilder.availableGoogleFonts = fontsArray;

				initGoogleFontSelector();
			});

		} else {
			initGoogleFontSelector();
		}
	};
	frslib.callbacks.addCallback( 'initOneOptionSet', frslib.options.themebuilder.initGfontSelector );
	frslib.callbacks.addCallback( 'options-section-inserted', frslib.options.themebuilder.initGfontSelector );

/**********************************************************************************************************************/
/* INIT TABS
/**********************************************************************************************************************/

	/*----------------------------------------------------------*/
	/* INIT TABS
	/*----------------------------------------------------------*/
	/**
	 * Tabs in the modal window
	 * @param $options
	 */
    frslib.options.themebuilder.initTabs = function( $options ) {
        $options.find('.ffb-modal__tabs').each(function(){

            var $contents = $(this).children('.ffb-modal__tab-contents');
            var $headers = $(this).children('.ffb-modal__tab-headers');


            // copy headers from content to the header part
            var $headersToCopy = $contents.children('.ffb-modal__tab-header');
            $headersToCopy.appendTo(  $headers );


            var activateTabFromHeader = function ( $header ) {

                var index = $header.index();

                $headers.children('.ffb-modal__tab-header').removeClass('ffb-modal__tab-header--active');
                $header.addClass('ffb-modal__tab-header--active');

                $contents.children('.ffb-modal__tab-content').removeClass('ffb-modal__tab-content--active');
                $contents.children('.ffb-modal__tab-content').eq( index).addClass('ffb-modal__tab-content--active');

            };

            $headers.find('.ffb-modal__tab-header').click(function(e){
				e.stopPropagation();
                activateTabFromHeader( $(this) );

            });

        });
    };
	frslib.callbacks.addCallback( 'initOneOptionSet', frslib.options.themebuilder.initTabs );
	frslib.callbacks.addCallback( 'options-section-inserted', frslib.options.themebuilder.initTabs );

/**********************************************************************************************************************/
/* INIT HIDING BOX
/**********************************************************************************************************************/
	/*----------------------------------------------------------*/
	/* INIT TABS
	 /*----------------------------------------------------------*/
	/**
	 * Tabs in the modal window
	 * @param $options
	 */
	frslib.options.themebuilder.initHidingBox = function( $options ) {
		$options.find('.ff-hiding-box').each(function(){

			var $hidingBox = $(this);

			var optionName = $hidingBox.attr('data-option-name');
			var optionValue = $hidingBox.attr('data-option-value').split(',');

			var optionOperator = $hidingBox.attr('data-option-operator');

			var $parent = $hidingBox.closest('.ff-repeatable-content, .ff-options, .ff-hiding-box-parent');



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


	};
	frslib.callbacks.addCallback( 'initOneOptionSet', frslib.options.themebuilder.initHidingBox );
	frslib.callbacks.addCallback( 'options-section-inserted', frslib.options.themebuilder.initHidingBox );

/**********************************************************************************************************************/
/* TINY MCE OPTIONS
/**********************************************************************************************************************/
	/**
	 * Init this thing on one selector
	 * @param id
	 */
	var initTinyMCEOnSelector = function( id )  {
		tinymce.init({
			height: 200,
			selector: '#' + id,
			menubar:false,
			toolbar: 'styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
		});




		var $textarea =$('#' + id);

		var $parent = $textarea.parents('.ff-options__tinymce-holder:first');
		$parent.addClass('ff-options__tinymce-holder--tinymce-enabled');
		$parent.removeClass('ff-options__tinymce-holder--tinymce-disabled');

		$textarea.attr('data-tinymce-active', 'yes');

		$textarea.parents('.ff-tinymce-wrapper:first').find('.ff-tinymce-status-holder').find('input').val(1);
		// $(tinyMceEnableInputClass).val(1 );
	};

	/**
	 * destroy it on one selector
	 * @param id
	 */
	var destroyTinyMCEOnSelector = function( id ) {
		window.tinyMCE.execCommand( 'mceRemoveEditor', true,  id );

		var $textarea =$('#' + id);

		var $parent = $textarea.parents('.ff-options__tinymce-holder:first');
		$parent.addClass('ff-options__tinymce-holder--tinymce-disabled');
		$parent.removeClass('ff-options__tinymce-holder--tinymce-enabled');

		$textarea.attr('data-tinymce-active', 'no');

		$textarea.parents('.ff-tinymce-wrapper:first').find('.ff-tinymce-status-holder').find('input').val(0);
	};

	/**
	 * Init tinyMCE after rendering the options
	 * @param $options
	 */
	frslib.options.themebuilder.initTinyMCE = function( $options ) {


		setTimeout( function(){
		var counter = new Date().getTime() -  new Date('2016-01-01').getTime();
		$options.find('.ff-options__tinymce').each(function(){
			var idAttr = 'ffb-tinymce-' + counter.toString(32);
			$(this).attr('id', idAttr);



			// var uniqueId = $(this).attr('data-id');

			// console.log( idAttr, uniqueId );

			// var inputClass = '.' + uniqueId + '-tinymce-enable';
			var tinyMCEEnabled  = $(this).parents('.ff-tinymce-wrapper').find('.ff-tinymce-status-holder').find('input').val();

			tinyMCEEnabled = parseInt( tinyMCEEnabled );


			console.log( tinyMCEEnabled, idAttr );

			// var tinyMCEEnabled = parseInt( $options.find( inputClass ).val() );
			if( tinyMCEEnabled == 1 ) {
				initTinyMCEOnSelector( idAttr );
			} else {
				destroyTinyMCEOnSelector( idAttr );
			}

			counter++;
		});

		$options.find('.ff-options__tinymce-enable').click(function(){
			var $parent = $(this).parent();
			var $textarea= $parent.find('.ff-options__tinymce');

			var id = $textarea.attr('id');
			// if( $textarea.attr('data-tinymce-active') != 'yes' ) {
				initTinyMCEOnSelector( id );
			// } else {
			// 	destroyTinyMCEOnSelector( id );
			// }
		});

		$options.find('.ff-options__tinymce-disable').click(function(){
			var $parent = $(this).parent();
			var $textarea= $parent.find('.ff-options__tinymce');

			var id = $textarea.attr('id');
			// if( $textarea.attr('data-tinymce-active') != 'yes' ) {
			// 	initTinyMCEOnSelector( id );
			// } else {
			destroyTinyMCEOnSelector( id );
			// }
		});
		}, 100);

	};
	frslib.callbacks.addCallback( 'initOneOptionSet', frslib.options.themebuilder.initTinyMCE );
	frslib.callbacks.addCallback( 'options-section-inserted', frslib.options.themebuilder.initTinyMCE );
	/**
	 * Reinit the tinyMCE after sorting
	 * @param $options
	 */
	frslib.options.themebuilder.reinitTinyMCE = function( $options ) {
		$options.find('.ff-options__tinymce').each(function(){

			if( $(this).attr('data-tinymce-active') == 'yes' ) {
				var id = $(this).attr('id');
				destroyTinyMCEOnSelector(id);
				initTinyMCEOnSelector( id );
			}

		});
	};
	frslib.callbacks.addCallback( 'opt-changed-sorted', frslib.options.themebuilder.reinitTinyMCE );

	/**
	 * Remove the tinyMCE after closing the lightbox
	 */
	frslib.callbacks.addCallback('ffbuilder-modalContentCleaned', function( $content ){
		$content.find('.ff-options__tinymce').each(function(){
			var id = $(this).attr('id');
			window.tinyMCE.execCommand( 'mceRemoveEditor', true,  id );
		});
	});


/**********************************************************************************************************************/
/* COLOR LIBRARY
/**********************************************************************************************************************/
	frslib.options.themebuilder.initColorWithLib = function( $options ) {

		$options.find('[data-hasqtip]').removeAttr('data-hasqtip');
		$options.find('[data-has-been-init]').removeAttr('data-has-been-init');

        var self = this;
        /*----------------------------------------------------------*/
        /* GENERATE THE HTML CODE FOR THE LIBRARY
        /*----------------------------------------------------------*/
        var generateColorPickerHTML = function(colorValue) {
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

						var colorLibrary = window.ffbuilder.appInstance.colorLibrary;
						for( var number = 1; number <= 50; number++ ) {
							var color = colorLibrary[ number ];
							var value = color[ 'color' ];

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

            return input;
        };



        $options.find('.fftm__option-type--color-picker').each(function(){

			var $oneOption = $(this);


			if( $(this).attr('data-has-been-init') == 'yes' ) {
				return;
			}
			$(this).attr('data-has-been-init', 'yes');


			$(this)



            var $this = $(this);
            var $dataInput = $(this).find('.fftm__option-type--input');
			var $previewColor = $(this).find('.fftm__option-type--color-picker__select-preview-color');

			var colorSelected = $dataInput.val();
			var colorValue = $previewColor.attr('data-color');

			$previewColor.css('color', frslib.colors.contrast(colorValue));

            $.fn.qtip.zindex = 999999; // Non-modal z-index
            $.fn.qtip.modal_zindex = 999800; // Modal-specific z-index

			var $qtippedElement = $(this).find('.fftm__option-type--color-picker__select');

			var qtipHiddenBy = 'overlay';

            $qtippedElement.qtip({
                content: {
                    text: function(){

						var $input = $(generateColorPickerHTML(colorValue));

						var colorPickerViewObject = Backbone.View.extend({

							$el : null,

							$dataInput : null,

							$previewColor : null,

							$nameInput : null,

							$buttonOk: null,

							$buttonCancel: null,

							/**
							 * Selected color from library
							 */
							$selectedColor: null,

							currentColor: null,

							currentColorPosition: null,

							originalColor: null,

							originalColorPosition: null,

							originalColorLib: null,

							/*----------------------------------------------------------*/
							/* BIND ACTIONS
							/*----------------------------------------------------------*/
							bindActions: function () {
								this.bindPickerAndPaletteSwitching();
								this.bindColorPaletteClick();
								this.bindColorLibrarySwitching();
								this.bindColorLibraryClick();
								this.bindColorLibraryInputChange();
								this.bindColorLibraryHover();
								this.bindColorPickerPreviewClick();
								this.bindButtonOkAndCancel();
							},

							bindButtonOkAndCancel: function () {
								var self = this;

								this.$buttonOk.on('click', function(){
									var currentColorValue = self.$el.find('.sp-input').val();
									self.colorHasBeenChanged( currentColorValue, 'button-ok');

									qtipHiddenBy = 'ok';
									$qtippedElement.qtip().hide();
								});

								var cancelColorLibrary = function() {
									

									var originalColor = self.originalColor;
									var originalPosition = self.originalColorPosition;

									console.log( originalColor, originalPosition );

									if( originalPosition != null ) {



										self.setValueToInput( originalPosition );
										self.setColorToInput( originalColor, self.getNumberFromPosition(originalPosition) );

										self.fillOriginalLibraryToOtherPreviews();
									} else {
										self.setColorToInput( originalColor, '' );
										self.setValueToInput( originalColor );
									}


									$qtippedElement.qtip().hide();
									window.ffbuilder.appInstance.colorLibrary = JSON.parse( JSON.stringify( self.originalColorLib ) ); //_.extend({}, );
								};

								$('#qtip-overlay').unbind('click').one('click', function(){
									qtipHiddenBy = 'overlay';
									cancelColorLibrary();
								});

								this.$buttonCancel.on('click', function(){
									qtipHiddenBy = 'cancel';
									cancelColorLibrary();
								});

							},

							/**
							 *
 							 */
							bindColorPickerPreviewClick: function() {
								var self = this;
								this.$previewHistoryOld.on('click', function(){
									var color = $(this).attr('data-color');
									self.colorHasBeenChanged( color, 'preview-old');
								});
							},

							/**
							 * Hovering the colors and then changing the name
							 */
							bindColorLibraryHover: function() {
								var self = this;
								this.$el.find('.fftm__option-type--color-picker__library-color__clicker').hover(function(){
									var $colorLibraryItem = $(this).next();
									var position = $colorLibraryItem.attr('data-color-position');

									var colorName = self.getNameFromLibrary( position );

									self.$nameInput.val( colorName );
								}, function(){
									var originalColorPosition = self.$selectedColor.attr('data-color-position');
									var originalName = self.getNameFromLibrary( originalColorPosition );

									self.$nameInput.val( originalName );
								});
							},

							/**
							 * Save the values of changed input
							 */
							bindColorLibraryInputChange: function() {
								var self = this;
								this.$nameInput.on('keyup', function(){
									var value = $(this).val();
									self.changeColorLibraryName( value );
								});
							},

							/**
							 * Switch between color picker and palette
							 */
							bindPickerAndPaletteSwitching: function () {
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

							/**
							 * Click on color picker palette
							 */
							bindColorPaletteClick: function() {
								var self = this;
								this.$el.find('.fftm__option-type--color-picker__palette-color').on('click', function(){
									var color = $(this).attr('data-color');
									self.colorHasBeenChanged( color, 'palette' );
								});
							},

							/**
							 * Enable / Disable color library
							 */
							bindColorLibrarySwitching: function() {
								var $el = this.$el;
								var self = this;
								// use / unuse library
								$el.find('.fftm__option-type--color-picker__use-library').on('click', function(){
									if( $(this).prop('checked') ) {
										self.enableColorLibrary();
									} else {
										self.disableColorLibrary();
									}
								});
							},

							/**
							 * Click on color library color
							 */
							bindColorLibraryClick: function() {
								var self = this;
								this.$el.find('.fftm__option-type--color-picker__library-color__clicker').on('click', function(){
									var position = $(this).next().attr('data-color-position');

									self.applyColorFromLibrary( position );
								});
							},


							initialize: function( params ) {
								this.$el = params.$el;
								this.$dataInput = params.$dataInput;
								this.$previewColor = params.$previewColor;
								this.$nameInput = this.$el.find('.fftm__option-type--color-picker__library-color-name');

								this.$previewHistoryOld = this.$el.find('.fftm__option-type--color-picker__history-old');
								this.$previewHistoryNew = this.$el.find('.fftm__option-type--color-picker__history-new');

								this.$buttonOk = this.$el.find('.fftm__option-type--color-picker__btn-save');
								this.$buttonCancel = this.$el.find('.fftm__option-type--color-picker__btn-cancel');

								this.bindActions();
								this.initSpectrum();

								this.setUpValuesFromInput();
							},

							setUpValuesFromInput: function() {
								var color = this.$dataInput.val();


								this.originalColorLib = JSON.parse( JSON.stringify( window.ffbuilder.appInstance.colorLibrary ));

								// if( color == 'null' ) {
								// 	return;
								// }



								if( this.isColorFromLibrary( color ) ) {

									var position = this.getNumberFromPosition( color );
									this.originalColorPosition = color;
									this.enableColorLibrary( position );
									color = this.getColorFromLibrary( position );

								} else {
									this.colorHasBeenChanged( color, 'init');
								}

								this.originalColor = color;

								var cleanColor = this.getOriginalColor();

								var self = this;

								// setTimeout( function(){

									this.$previewHistoryOld.css('background-color', cleanColor ).css('color', cleanColor);
									this.$previewHistoryNew.css('background-color', cleanColor ).css('color', cleanColor);
									this.$previewHistoryOld.attr('data-color', cleanColor );

								// }, 1000);
							},

							isOriginalColorNull: function() {
								return this.originalColor == '';
							},

							getOriginalColor: function() {
								if( this.originalColor == '' ) {
									return '#000000';
								} else {
									return this.originalColor;
								}
							},


							colorHasBeenChanged : function( color, origin ) {
								this.currentColor = color.toString();
								color = color.toString();

								if( origin != 'picker' ) {
									this.setColorToPicker( color.toString() );
								}

								if( this.isColorLibraryActive() ) {

									var position = this.$selectedColor.attr('data-color-position');
									this.setColorToInput( color, position );
									this.setValueToInput( '[' + position + ']' );

									this.setColorToLibraryPreview(position, color );
									this.setColorToLibrary( position, color );
									this.setColorToOtherPreviews( position, color );

								} else {

									this.setColorToInput( color, '' );
									this.setValueToInput( color );

								}

								this.$previewHistoryNew.css('background-color', color).css('color', color);
							},

							applyColorFromLibrary: function( position ) {
								this.$el.find('.fftm__option-type--color-picker__library-color').removeClass('fftm__option-type--color-picker__library-color--active');
								this.$selectedColor = this.$el.find('.fftm__option-type--color-picker__library-color-' + position);
								this.$selectedColor.addClass('fftm__option-type--color-picker__library-color--active');

								var color = this.getColorFromLibrary( position );
								var name = this.getNameFromLibrary( position );

								this.$nameInput.val( name );

								this.colorHasBeenChanged( color, 'library');
							},

							changeColorLibraryName: function( name ) {
								var position = this.$selectedColor.attr('data-color-position');
								this.setNameToLibrary( position, name );
							},

							enableColorLibrary: function( position ) {
								this.$el.addClass('fftm__option-type--color-picker--library-color-is-active');
								this.$el.find('.fftm__option-type--color-picker__use-library').prop('checked', 'checked');

								if( position == undefined ) {
									position = 1;
								}

								this.applyColorFromLibrary( position );
							},

							disableColorLibrary: function() {
								this.$el.removeClass('fftm__option-type--color-picker--library-color-is-active');
								this.$el.find('.fftm__option-type--color-picker__use-library').prop('checked', '');

								var color = this.$selectedColor.attr('data-color');
								this.$selectedColor = null;

								this.colorHasBeenChanged( color, 'disabled-library');
							},


							isColorFromLibrary: function( color ) {
								if( color.toString().indexOf('[') == -1 ) {
									return false;
								} else {
									return true;
								}
							},

							getNumberFromPosition : function( position ) {
								return position.toString().replace('[','').replace(']','');
							},

							getPositionFromNumber : function( number ) {
								var cleanNumber = this.getNumberFromPosition( number );
								return '[' + cleanNumber + ']';
							},

							getColorFromLibrary: function( position ) {
								position = this.getNumberFromPosition( position );
								return window.ffbuilder.appInstance.colorLibrary[position]['color'];
							},

							getNameFromLibrary: function( position ) {
								position = this.getNumberFromPosition( position );
								return window.ffbuilder.appInstance.colorLibrary[position]['name'];
							},

							setColorToLibrary : function ( position, color ) {
								position = this.getNumberFromPosition( position );
								window.ffbuilder.appInstance.colorLibrary[position]['color'] = color;
							},

							setColorToLibraryPreview: function( position, color ) {
								var $libraryItem = this.$el.find('.fftm__option-type--color-picker__library-color-' + position);
								var $preview = $libraryItem.find('.fftm__option-type--color-picker__library-color-preview');

								$libraryItem.attr('data-color', color);
								$preview.css('background-color', color);
								$preview.css('color', frslib.colors.contrast(color) );
							},

							setColorToOtherPreviews: function( position, color ) {
								var self = this;
								$('.fftm__option-type--color-picker').each(function(){
									var $previewColor = $(this).find('.fftm__option-type--color-picker__select-preview-color');
									var $dataInput = $(this).find('.fftm__option-type--input');

									var value = $dataInput.val();

									if( self.isColorFromLibrary( self ) ) {
										value = self.getNumberFromPosition( value );
										position = self.getNumberFromPosition( position );

										if( value != '' && value == position ) {
											$previewColor.css('background', color );
											$previewColor.css('color', frslib.colors.contrast(color) );
										}

									}
								});
							},

							fillOriginalLibraryToOtherPreviews: function() {
								var originalLibrary = this.originalColorLib;
								var self = this;

								$('.fftm__option-type--color-picker').each(function(){
									var $previewColor = $(this).find('.fftm__option-type--color-picker__select-preview-color');
									var $dataInput = $(this).find('.fftm__option-type--input');

									var value = $dataInput.val();

									if( self.isColorFromLibrary( self ) ) {
										value = self.getNumberFromPosition( value );

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

							setNameToLibrary : function ( position, name ) {
								position = this.getNumberFromPosition( position );
								window.ffbuilder.appInstance.colorLibrary[position]['name'] = name;
							},

							isColorLibraryActive : function() {
								if( this.$selectedColor == null ) {
									return false;
								} else {
									return true;
								}
							},

							getCurrentColorPosition: function() {
								return 1;
							},

							setColorToInput: function( color, text ) {
								this.$previewColor.css('background', color);

								$oneOption.removeClass('fftm__option-type__is-reset')

								if( text != undefined ) {
									this.$previewColor.css('color', frslib.colors.contrast(color) );
									this.$previewColor.html( text);
								}
							},

							setValueToInput: function( value ) {
								this.$dataInput.val( value );

								if( value == '' || value == null ) {
									this.$dataInput.val( '' );
									$oneOption.addClass('fftm__option-type__is-reset');
								}

							},

							setColorToPicker: function( color ) {
								$input.find('.fftm__option-type--color-picker__picker').spectrum('set', color );
								$input.find('.fftm__option-type--color-picker__picker').spectrum('reflow');
							},

							initSpectrum: function() {
								var self = this;
								colorSelected = '#00ff00';

								this.$el.find('.fftm__option-type--color-picker__picker').spectrum({
									color: colorSelected,
									flat: true,
									showAlpha: true,
									showInput: true,
									showInitial: true,
									// allowEmpty:true,
									preferredFormat: "hex",
									move: function( color ){
										self.colorHasBeenChanged( color, 'picker' );
									},

									change: function( color ) {
										// self.colorHasBeenChanged( color, 'picker' );
										//self.colorPickerChanged( color );
									}
								});
								var self = this;
								setTimeout(function(){
									self.$el.find('.sp-input').focus().select();
								}, 100);
							},

						});

						setTimeout( function(){ var colorPickerView = new colorPickerViewObject({$el : $input, $dataInput : $dataInput, $previewColor: $previewColor}); }, 50);

						return $input;
                    }
                },
                show: {
                    event: 'click',
                    effect: false, // disable fading animation
                    modal: {
                        on: true, // turn on modal plugin
                        effect: false, // disable fading animation
                        blur: true, // hide tooltip by clicking backdrop
                        escape: true // hide tooltip when ESC pressed
                    }
                },
                hide: {
                    event: 'unfocus',
                    effect: false, // disable fading animation
                },
                position: {
                    target: $this,
                    adjust: {
                        mouse: false // not following the mouse
                    },
                    viewport: $(window) // force tooltip to stay inside viewport
                },
                style: {
                    tip: {
                        corner: false
                    },
                    classes: ''
                },
                events: {


                    render: function(event, api) {
                        // Grab the overlay element
                        var elem = api.elements.overlay;
                        // Add class
                        elem.find('div').addClass('qtip-overlay-minimal');
                    },

                    show: function( event, api ) {
						setTimeout( function(){
                            // can be moved elsewhere? ( START )
                            var latestColor = api.elements.target.find('.fftm__option-type--color-picker__select-preview-color').attr('data-color');
                            if ( '' == latestColor ){
                                latestColor = '#ffffff';
                            }
                            // $(event.target).find('.fftm__option-type--color-picker__history-old').css('background-color', latestColor );
                            // $(event.target).find('.fftm__option-type--color-picker__history-new').css('background-color', latestColor );
                            // can be moved elsewhere? ( END )

							// $(event.target).find('.fftm__option-type--color-picker__picker').spectrum('reflow');

						}, 60);

                        setTimeout(function(){
                            // var curColor = api.elements.target.find('.fftm__option-type--color-picker__select-preview-color').attr('data-color');
                            // var oldColor = curColor;
                            var historyColorDivs = api.elements.content.find('.fftm__option-type--color-picker__history-old, .fftm__option-type--color-picker__history-new');
                            var printHistoryPreview = function(event, api){
                                // console.log(api.elements.target.attr('class'));
                                // if ( api.elements.target.hasClass('fftm__option-type--color-picker__history-new') ){
                                //     console.log(api.elements.target);
                                    var curColor = api.elements.target.css('background-color');
                                //     console.log('1');
                                //     console.log(curColor);
                                // } else {
                                //     curColor = oldColor;
                                //     console.log('2');
                                // }
                                return '<div class="fftm__option-type--color-picker__history-mockup-wrapper" style="background-color: ' + curColor + '; color: ' + curColor + ';"><div class="fftm__option-type--color-picker__history-mockup fftm__option-type--color-picker__history-preview__var1"><h2>The quick brown fox jumps over the lazy dog</h2><p>The quick brown fox jumps over the lazy dog</p></div><div class="fftm__option-type--color-picker__history-mockup fftm__option-type--color-picker__history-preview__var2"><h2>The quick brown fox jumps over the lazy dog</h2><p>The quick brown fox jumps over the lazy dog</p></div><div class="fftm__option-type--color-picker__history-mockup fftm__option-type--color-picker__history-preview__var3"><h2>The quick brown fox jumps over the lazy dog</h2><p>The quick brown fox jumps over the lazy dog</p></div><div class="fftm__option-type--color-picker__history-mockup fftm__option-type--color-picker__history-preview__var4"><h2>The quick brown fox jumps over the lazy dog</h2><p>The quick brown fox jumps over the lazy dog</p></div></div>';

                            }
                            historyColorDivs.qtip({
                                content: {
                                    text: function(event, api){
                                        printHistoryPreview(event, api);
                                    }
                                },
                                show: {
                                    delay: 0,
                                    effect: false, // disable fading animation
                                },
                                hide: {
                                    effect: false, // disable fading animation
                                },
                                position: {
                                    target: $this,
                                    adjust: {
                                        mouse: false // not following the mouse
                                    },
                                    viewport: $(window) // force tooltip to stay inside viewport
                                },
                                style: {
                                    tip: {
                                        corner: false
                                    },
                                    classes: ''
                                },
                                events: {
                                    show: function(event, api) {
                                        historyColorDivs.qtip('option', 'content.text', printHistoryPreview(event, api) );
                                    }
                                }
                            });
                        }, 70);

                        setTimeout(function(){

                            var fixSubPixPos = function(){

                                // overwrite sub-pixel positioning of the modal. otherwise things inside are not pixel perfect.

                                var topPosInt = api.elements.tooltip.css('top');
                                topPosInt = parseFloat(topPosInt);
                                topPosInt = Math.round(topPosInt);

                                var leftPosInt = api.elements.tooltip.css('left');
                                leftPosInt = parseFloat(leftPosInt);
                                leftPosInt = Math.round(leftPosInt);


                                api.elements.tooltip.css('top', topPosInt).css('left', leftPosInt);

                            }

                            fixSubPixPos();

                            // setTimeout(function(){
                            //     fixSubPixPos();
                            // }, 100);

                            // setTimeout(function(){
                            //     fixSubPixPos();
                            // }, 200);

                            // setTimeout(function(){
                            //     fixSubPixPos();
                            // }, 300);

                            // setTimeout(function(){
                            //     fixSubPixPos();
                            // }, 500);

                        }, 500);
                    },
                }
            });
        });

	};

	frslib.callbacks.addCallback( 'initOneOptionSet', frslib.options.themebuilder.initColorWithLib );
	frslib.callbacks.addCallback( 'options-section-inserted', frslib.options.themebuilder.initColorWithLib );

	//
	//
    // $(document).on('click', '.ffb-modal-opener-button', function() {
	//
    //     $(this).parent().children('.ffb-modal').css('display', 'block');
	//
    // });
	//
    // $(document).on('click', '.ffb-modal__action-done', function(e) {
    //     if(e.target != this) return;
    //     $(this).parents('.ffb-modal:first').css('display', 'none');
    //     $(this).parents('.ff-repeatable-item:first').removeClass('ff-repeatable-item-closed__open-popup');
    // });

    // $(document).on('click', '.ff-show-advanced-tools', function(e){
	//
    //     var $parent = $(this).parents('.ff-repeatable-item:first');
	//
    //     if( $parent.hasClass('ff-repeatable-item-closed') ) {
    //         $parent.addClass('ff-repeatable-item-closed__open-popup');
    //     }
	//
    //     e.stopPropagation();
	//
		// var repeatableItemName = $parent.find('.ff-repeatable-title:first').html();
	//
		// var $originalModal = $('.ffb-modal-origin');
		// var originalModalName = $originalModal.find('.ffb-modal__name:first').find('span').html();
	//
		// // var newName = ( 'Advanced Tools - ' + originalModalName + ' / ' + repeatableItemName );
		// var newName = ( originalModalName + ' / ' + repeatableItemName );
	//
		// var $modal = $(this).parents('.ff-repeatable-item:first').find('.ff-advanced-options:first').find('.ffb-modal:first');
	//
		// $modal.find('.ffb-modal__tab-header:first').click();
	//
		// $modal.find('.ffb-modal__name:first').html(newName );
	//
    //     $modal.css('display','block');
	//
	//
	//
    //     return false;
	//
    // });


})(jQuery);