(function($){
	frslib.provide('frslib.options2');

	/**
	 * Printing our options
	 */
	frslib.options2.managerModal = frslib.options2.managerGlobalOptions.extend({

		_defaultImagePlaceholdersData: null,

		_autoCalledInit_2 : function() {
			this._applyToOptions.push('_initModalTabs');
			this._applyToOptions.push('_initShowAdvancedTools');
			this._applyToOptions.push('_initAdvancedToolsActionDone');
			this._applyToOptions.push('_initModalTabChanges');
			this._applyToOptions.push('_initDefaultImageData');
			this._applyToOptions.push('_initCssSelectors');
			this._applyToOptions.push('_initCustomCodeBuilder');
			this._applyToOptions.push('_initModalTabsCopyAndPaste');
			


			this._applyToOptionsAfterChange.push('_initCssSelectors');

		},

		_initModalTabsCopyAndPaste: function() {
			
		},



		_initCustomCodeBuilder: function( $element ) {
            var isGlobalStylesScreen = false;

            if( $element.parents('.ffb-modal').hasClass('ffb-modal__global-styles') ) {
                isGlobalStylesScreen = true;
            }

			$element.find('.ffb-custom-css-code-wrapper').each(function(){
				var $modalParent = $(this).parents('.ffb-modal__content--options:first');

				var value = $modalParent.find('.ff-insert-unique-css-class:first').html();

				var selectorsArray = value.split(' ');
				var numberOfSelectors = selectorsArray.length;

				var selectorArray = new Array();
				for( var i = 1; i <= numberOfSelectors; i++ ) {
					selectorArray.push('%s' + i);
				}

				var selectorString = selectorArray.join(' ');

				$modalParent.find('.ff-opt-slct').each(function(){
					if( $(this).val() == '' ) {
						$(this).val( selectorString );
					}

				});//.val( selectorString );
			});

			var minWidth = {};
			minWidth['xs'] = 320;
			minWidth['sm'] = 768;
			minWidth['md'] = 992;
			minWidth['lg'] = 1200;

			var maxWidth = {};
			maxWidth['xs'] = 767;
			maxWidth['sm'] = 991;
			maxWidth['md'] = 1199;



			$element.find('.ffb-custom-css-code-wrapper').each(function(){
				var $this = $(this);

				var $viewportMin = $this.find('.ff-opt-min');
				var $viewportMax = $this.find('.ff-opt-max');
				var $selector = $this.find('.ff-opt-slct');
                var $selectorSwitch = $this.find('.ff-opt-slct-switch');

                //setTimeout( function(){
                console.log( $selectorSwitch.val() );

                if( $selectorSwitch.val() == '' && isGlobalStylesScreen ) {
                    $selectorSwitch.val('rel');
                    $selector.val('%s1');
                }

                //}, 1000);

                //$selector.val('%s1');
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
		},

		// _initOpt
		_initCssSelectors: function( $element ) {

			var elementId = this.getMetaData('element-unique-id', null );
			if( elementId == null ) {
				return;
			}

			var systemSections = [];

			systemSections.push('a-t');
			systemSections.push('b-m');
			systemSections.push('cc');
			systemSections.push('clrs');

			var level = 0;
			var currentLevel = 0;
			var counters = new Array();
			var classes = new Array();
			// var systemSections = this.getSystemSectionNames();

			// console.log( this._metaData );

			this.$el.find('.ff-insert-unique-css-class').html( '.ffb-id-' + elementId );
			this.$el.find('.ff-repeatable-item-js, .ff-toggle-box-advanced, .ff-css-wrapper').each(function(){
				var route = $(this).attr('data-current-section-route');
				// ignore system repeatable sections
				for( var i in systemSections ) {
					var oneSection = systemSections[ i ];

					if( route != undefined && route.indexOf( oneSection + ' ') != - 1 ) {
						return;
					}
				}


				var $this = $(this);

				if( $this.hasClass('ff-repeatable-item-js' ) || $(this).hasClass('ff-toggle-box-advanced') ) {
					var id = $(this).attr('data-section-id');



					if( id == undefined ) {
						return ;
					}

					var dataCurrentLevel;
					if( $this.hasClass('ff-repeatable-item-js') ) {
						dataCurrentLevel = $this.parent().attr('data-current-level');
					} else if( $this.hasClass( 'ff-toggle-box-advanced' ) ) {
						dataCurrentLevel = $this.attr('data-current-level');
					}

					console.log( id, dataCurrentLevel, currentLevel );

					if( dataCurrentLevel > currentLevel ) {
						level++;
					}
					else if (dataCurrentLevel == currentLevel ) {
						classes.pop();
					}
					else if( dataCurrentLevel < currentLevel ) {
						classes.pop();
						classes.pop();
						level--;
					}

					if( counters[level] == undefined ) {
						counters[level] = 0;
					}

					counters[ level ] ++;
					counters.splice( level + 1);



					// if( parseInt(dataCurrentLevel) > parseInt(currentLevel) || parseInt(dataCurrentLevel) == parseInt(currentLevel) ) {
					//
					// } else {
					// 	classes.pop();
					// }

					// if( parseInt(dataCurrentLevel) == parseInt(currentLevel) || parseInt(dataCurrentLevel) < parseInt(currentLevel) ) {
					// 	classes.pop();
					// }

					var newId;



					if( $this.hasClass('ff-repeatable-item-js') ) {
						newId = '.ffb-' + id + counters.join('-');
					} else if( $this.hasClass( 'ff-toggle-box-advanced' ) ) {
						newId = '.ffb-' + id;
					}

					// console.log( newId );

					classes.push( newId );

					currentLevel = dataCurrentLevel;
				}

				else if( $this.hasClass('ff-css-wrapper') ) {

					var type = $this.attr('data-type');

					if( type == 'start' ) {
						classes.push( '.' + $this.attr('data-css-class') );
					} else {
						classes.pop();
					}
				}

				var classesString;

				classesString = classes.join(' ');
				classesString = ' ' + classesString;

				$(this).find('.ff-insert-unique-css-class').html('.ffb-id-' + elementId + classesString);

			});


		},

		_initDefaultImageData: function( $element ) {
			var data = {};
			var self = this;

			var initDefaultImageData = function(){
				$element.find('.ff-default-content-img, .ff-substitute-content-img').click(function() {


					var $this = $(this);
					var $input = $this.parent().find('input.ff-image');
					var $previewSmall = $this.parent().find('.ff-open-library-button-preview-image');
					var $previewLarge = $this.parent().find('.ff-open-library-button-preview-image-large');
					var $substituteImage = $this.parent().find('.ff-substitute-img');


					var i;
					var $holder = $('<div class="ff-default-image-placeholder-qtip"><ul></ul></div>');

					var images = self._defaultImagePlaceholdersData;

					$holder.css('background-color', 'white');

					var modal = $.freshfaceBox( $holder);


					for( i in images ) {
						var oneImage = images[i];


						var $image = $('<li><img></li>');
						$image.css('padding', 20);

						$image.find('img').attr('src', oneImage.url_real);

						$image.data('oneImage', oneImage );
						// $image.attr('data-image', JSON.stringify( oneImage ) );

						if( $this.hasClass('ff-default-content-img') ) {
							$image.click(function () {

								oneImage = $(this).data('oneImage');

								var imageValue = JSON.parse(JSON.stringify(oneImage));
								delete imageValue.url_real;

								$input.val(JSON.stringify(imageValue));
								$previewSmall.css('background-image', "url('" + oneImage.url_real + "')");
								$previewLarge.attr('src', oneImage.url_real);

								modal.close();
							});
						} else if( $this.hasClass('ff-substitute-content-img') )  {
							$image.click(function () {

								oneImage = $(this).data('oneImage');

								var imageValue = JSON.parse(JSON.stringify(oneImage));

								var originalValue = $input.val();

								try {
									originalValue = JSON.parse( originalValue );
								} catch (e) {
									originalValue = {};
								}


								$substituteImage.attr('src', imageValue.url_real);
								delete imageValue.url_real;

								originalValue.substitute = imageValue;
								$input.val( JSON.stringify( originalValue ) );
								modal.close();



								// console.log( imageValue );
								// delete imageValue.url_real;
								//
								// $input.val(JSON.stringify(imageValue));
								// $previewSmall.css('background-image', "url('" + oneImage.url_real + "')");
								// $previewLarge.attr('src', oneImage.url_real);
								//
								// modal.close();
							});
						}

						$holder.children().append( $image );
					}

					// return $holder;

					return false;
				});
			};

			if( this._defaultImagePlaceholdersData == null ) {
				frslib.ajax.frameworkRequest('ff-builder-load-placeholders', null, data, function( response ) {
					try {
						self._defaultImagePlaceholdersData = JSON.parse( response );
					} catch (e ) {
						self._defaultImagePlaceholdersData = {};
					}

					initDefaultImageData();
				});
			} else {
				initDefaultImageData();
			}


		},

		_initModalTabChanges: function( $element ) {

			 if( $element.parents('.ffb-global-options-temporary-holder').size() > 0 ) {
				 return false;
			 }

			var self = this;
			var $systemTabs = $element.find('.ffb-modal__content-system');
			var makeHeaderFilled = function( $tabHeader ) {
				$tabHeader.addClass('ffb-modal__tab-header--filled');
				// $tabHeader.parents('.ff-advanced-options:first').parents('.ff-repeatable-item:first').find('.ff-show-advanced-tools').addClass('ff-show-advanced-tools--active');

				$tabHeader.parents('.ff-advanced-options:first').parents('.ff-repeatable-item:first').addClass('ff-repeatable-instance-changed-active');

				var id = $tabHeader.attr('data-id');

				$tabHeader.parents('.ffb-modal__tabs:first').children('.ffb-modal__tab-contents').children('.ffb-modal__tab-content[data-id="' + id +'"]').addClass('ffb-modal__tab-content-instance-changed');

			};

			var makeHeaderUnfilled = function(  $tabHeader  ) {
				$tabHeader.removeClass('ffb-modal__tab-header--filled');

				if( $tabHeader.parents('.ff-advanced-options:first').find('.ffb-modal__tab-header--filled').size() == 0 ) {
					$tabHeader.parents('.ff-advanced-options:first').parents('.ff-repeatable-item:first').removeClass('ff-repeatable-instance-changed-active');

					var id = $tabHeader.attr('data-id');
					$tabHeader.parents('.ffb-modal__tabs:first').children('.ffb-modal__tab-contents').children('.ffb-modal__tab-content[data-id="' + id +'"]').removeClass('ffb-modal__tab-content-instance-changed');
				}
			};
			var recalculateModalTimeout = null;
			var bindChangeToOptions = function( $option ) {
				$option.change(function(){
					var defaultValue = $(this).attr('data-default-value');
					var inputValue = self._formParser.getInputValueClean( $(this));

					if( defaultValue != inputValue ) {
						$(this).parent().addClass('ffb-input-differ-from-default-value');
					} else {
						$(this).parent().removeClass('ffb-input-differ-from-default-value');
					}

					clearTimeout( recalculateModalTimeout );
					recalculateModalTimeout = setTimeout(function(){

						var $tabContent= $option.parents('.ffb-modal__content-system:first');
						var hasBeenChanged = self._formParser.getDifferentInputsFromDefaultValue($tabContent);


						var tabId = $tabContent.attr('data-id');
						var $tabHeader = $option.parents('.ffb-modal__tabs:first').find('.ffb-modal__tab-headers:first').find('.ffb-modal__tab-header[data-id="'+tabId+'"]');

						if( hasBeenChanged ) {
							makeHeaderFilled($tabHeader);
						} else {
							makeHeaderUnfilled($tabHeader);
						}

					}, 75);
				});
			};

			if( $systemTabs.size() > 0 ) {
				$systemTabs.each(function(){

					var $tabContent= $(this);
					var tabId = $tabContent.attr('data-id');
					var $tabHeader = $(this).parents('.ffb-modal__tabs:first').find('.ffb-modal__tab-headers:first').find('.ffb-modal__tab-header[data-id="'+tabId+'"]');

					var makeCompleteCheck = function() {
						var tabHasBeenFilled = false;
						// check repeatables

						$tabContent.find('.ff-repeatable').each(function(){
							if( $(this).children().size() > 1 ) {
								tabHasBeenFilled = true;
							}
						});

						var hasBeenChanged = self._formParser.getDifferentInputsFromDefaultValue( $tabContent, function($input, value, route, inputHasBeenChanged){
							if( inputHasBeenChanged ) {
								$input.parent().addClass('ffb-input-differ-from-default-value');
							} else {
								$input.parent().removeClass('ffb-input-differ-from-default-value');
							}
						});

						if( hasBeenChanged ) { tabHasBeenFilled = true; }


						if( tabHasBeenFilled ) {
							makeHeaderFilled($tabHeader);
						} else {
							makeHeaderUnfilled($tabHeader);
						}
					};

					makeCompleteCheck();

					$tabContent.find('.ff-repeatable').on('repeatable-changed', function(){
						makeCompleteCheck();
					});


					bindChangeToOptions($tabContent.find('.ff-opt'));

				});
			} else {
				var $systemTabParent = $element.parents('.ffb-modal__content-system:first');
				if( $systemTabParent.size() > 0 ) {
					bindChangeToOptions($element.find('.ff-opt'));
				}
			}

		},
		
		_initModalTabs: function( $element ) {
			$element.find('.ffb-modal__tabs').addBack('.ffb-modal__tabs').each(function( index, $el ){
				var $contents = $(this).children('.ffb-modal__tab-contents');
				var $headers = $(this).children('.ffb-modal__tab-headers');


				// copy headers from content to the header part
				var $headersToCopy = $contents.children('.ffb-modal__tab-header');
				$headersToCopy.appendTo(  $headers );

				// actuvate tabs click
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


		},

		_initAdvancedToolsActionDone: function( $element ) {
			$element.find('.ffb-modal__action-done').click(function( e ){
				if(e.target != this) return;
				var $modal = $(this).parents('.ffb-modal:first');
				$modal.css('display', 'none');
				$modal.removeClass('ffb-modal-sub-opened');
				$(this).parents('.ff-repeatable-item:first').removeClass('ff-repeatable-item-closed__open-popup');

				return false;
			});
		},

		_initShowAdvancedTools: function( $element ) {

			 

			$element.find('.ff-show-advanced-tools, .ff-repeatable-header').click(function(e ){

				var $toElement = $(e.toElement);

				if( $toElement.hasClass('ff-repeatable-handle') && !$toElement.hasClass('ff-repeatable-handle-toggle-box') ) {
					return;
				}

				if( !$toElement.hasClass('ff-repeatable-drag')  ) {
					e.stopPropagation();
				}

				if( $toElement.hasClass('ff-repeatable-handle-toggle-box') ) {
					e.stopPropagation();
				}

				var $parent = $(this).parents('.ff-repeatable-item:first');

				if( $parent.hasClass('ff-repeatable-item-toggle-box') ) {
					var $header = $parent.children('.ff-repeatable-header')
					if( $header.find('.ff-show-advanced-tools').size() == 0 ) {
						return false;
					} else {
						e.stopPropagation();
						e.preventDefault();
					}
					// if( $parent.find('.ff-repeatable-header:first .ff-show-advanced-tool').size() == 0 ) {
					// 	return false;
					// }
				}
				else if( !$parent.hasClass('ff-this-item-has-advanced-tools') ) {
					return false;
				}

				// alert('xx');

				if( $parent.hasClass('ff-repeatable-item-closed') ) {
					$parent.addClass('ff-repeatable-item-closed__open-popup');
				}

				// e.stopPropagation();

				var repeatableItemName = $parent.find('.ff-repeatable-title:first').html();

				var $originalModal = $('.ffb-modal-origin');
				var originalModalName = $originalModal.find('.ffb-modal__name:first').find('span').html();

				// var newName = ( 'Advanced Tools - ' + originalModalName + ' / ' + repeatableItemName );
				var newName = ( originalModalName + ' | ' + repeatableItemName );

				var $modal = $(this).parents('.ff-repeatable-item:first').find('.ff-advanced-options:first').find('.ffb-modal:first');
				$modal.addClass('ffb-modal-sub-opened');

				$modal.find('.ffb-modal__tab-header:first').click();

				$modal.find('.ffb-modal__name:first').html(newName );

				$modal.css('display','block');


				return false;
			});

			$element.find('.ffb-modal-opener-button').click(function(){
				var $modal = $(this).parent().find('.ffb-modal:first');
				$modal.find('.ffb-modal__tab-header:first').click();
				$modal.css('display', 'block');
			});

			$element.find('.ff-advanced-tools-opener-button').click(function(){
				var $modal = $(this).siblings('.ffb-modal-holder').find('.ffb-modal');
				$modal.find('.ffb-modal__tab-header:first').click();
				$modal.css('display', 'block');
			});
		},
	});

})(jQuery);
