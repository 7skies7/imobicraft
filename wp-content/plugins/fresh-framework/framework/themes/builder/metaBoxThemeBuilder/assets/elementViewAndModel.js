(function($){
	if( window.ffbuilder == undefined ) {
		window.ffbuilder = {};
	}


/**********************************************************************************************************************/
/* ELEMENT VIEW
/**********************************************************************************************************************/
	/**
	 * Element View, taking care about rendering the element and manipulating with it
	 */
	window.ffbuilder.ElementView = Backbone.View.extend({
		model : null,
		query: null,
		elementModels: null,
		elementPickerView: null,

		optionsManager: null,

		initialize: function() {
		},

		test : function() {
			this.$el.css('opacity', 0.5);
		},

		/**
		 * Render option form and set it as a content in the modal window
		 */
		renderOptionsForm: function() {
			var self = this;
			var manager = new frslib.options2.managerModal();
			this.optionsManager = manager;

			manager.setStructure( this.model.get('optionsStructure') );
			manager.setData( this.getOptionsData() );
			manager.setBlockCallback(function( uniqueHash){
				return (self.vent.d.blocksData[ uniqueHash ]);
			});

			var $content = manager.render();
			// walker.walk();
			// var content = walker.getOutput();

			this.vent.f.modalSetTitle( this.model.get('name') );
			// this.vent.f.modalSetContent( $content );

			$('.ffb-modal__body').html('').append( $content );

			// this.vent.f.modalShow();
			// walker.setIgnoreData( true );
			// walker.walk('o gen content value a-t');

			// walker.walkQuery('o gen content value');
			//o gen content 1-|-value value number
			// alert('aa');
			// o gen content
			return;

			$('.ffb-modal-origin').removeClass('ffb-modal-add-element');

			var self = this;

			var html = '';
			html += '<div class="ff-options-js-wrapper " data-print-copy-and-paste="false">';
			html += '<div class="ff-options-js-data-wrapper" style="display:none;">';
				html += '<textarea class="ff-options-structure-js"></textarea>';
				html += '<textarea class="ff-options-data-js"></textarea> ';
				html += '<div class="ff-options-prefix">elementData</div>';
			html += '</div>';
			html += '<div class="ff-options-js">';
				//html += '<span class="spinner"></span>';
			html += '</div>';
			html += '</div>';

			var $html = $(html);

			$html.find('.ff-options-data-js').data('data-json',  this.getOptionsData() );
			$html.find('.ff-options-structure-js').data('data-json',  JSON.stringify( this.model.get('optionsStructure') ) );
			$html.find('.ff-options-structure-js').data('data-block-callback', function( uniqueHash){

				return (self.vent.d.blocksData[ uniqueHash ]);
			});

			// console.log( this.model.get('name') );

			var previewImageUrl = this.model.get('previewImage');

			this.vent.f.modalSetTitle( this.model.get('name') );
			this.vent.f.modalSetContent( $html );
			this.vent.f.modalSetPreviewImage( previewImageUrl );
			
			frslib.options.functions.initOneOptionSet( $html, true )

			this.renderOptionsFormCssClasses( $html );
			this.markAdvancedTools( $html );

			var self = this;
			$html.on('opt-changed', function( event, changeType ){
				// console.log('changed', a, b);

				var interval = 0;
				if( changeType == 'removed' ) {
					interval = 1000;
				}
				setTimeout(function(){
					self.renderOptionsFormCssClasses( $html );
				}, interval );

			});

			$html.on('click', '.ffb-modal__action-done', function(e){
				if(e.target != this) return;
				self.markAdvancedTools( $html );

			});

			$html.on('click', '.ffb-modal__tab-header', function(e){
				self.markAdvancedTools( $html );
			});
			
			$html.on('click', 'input, select, textarea', function(e) {
				e.stopPropagation();
			});


			$('.ffb-modal-save-default-element-settings').unbind('click').click(function(){
				var confirmationMessage = 'Do you really want to create new default data for this element? The old ones will be overridden!';

				if( confirm(confirmationMessage ) ) {
					self.saveDefaultElementData();
				}

			});

		},

		isElementDisabled: function( hide ) {
			var options = this.getOptionsDataJSON();

			if( hide == 'switch' ) {
				var actualState = options['o']['gen']['ffsys-disabled'];

				if (actualState == undefined || actualState == 0 ) {
					this.vent.f.addNotification('info', 'Element has been disabled');
					hide = 1;
				} else {
					this.vent.f.addNotification('info', 'Element has been enabled');
					hide = 0;
				}
			}

			var toReturn = hide;
			// just retrieving the info
			if( hide == undefined ) {
				var isDisabled = options['o']['gen']['ffsys-disabled'];

				if (isDisabled == undefined) {
					isDisabled = 0;
				}

				toReturn = isDisabled;
			}
			// actually hiding the element
			else {
				options['o']['gen']['ffsys-disabled'] = hide;

				this.setOptionsData( options );

				this.canvasChanged();
			}

			if( toReturn == 1 ) {
				this.$el.addClass('ffb-element-disabled');

			} else {
				this.$el.removeClass('ffb-element-disabled');

			}

			return toReturn;
		},

		getSystemSectionNames: function() {
			var systemSections = new Array();

			systemSections.push('a-t');
			systemSections.push('b-m');
			systemSections.push('cc');
			systemSections.push('clrs');

			return systemSections;
		},

		/**
		 *
		 * @param $html
		 *
		 *
		 */
		markAdvancedTools: function( $html ) {
			var $form = $html.find('.ff-options-js');
			var data = frslib.options.template.functions.normalizeFast( $form, undefined, undefined, undefined, true );
			var diff = this.getOptionsWithDifferencies( data.elementData );

			var systemSections = this.getSystemSectionNames();
			var diffQuery = this.getOptionsQuery(diff);


			var $elementTabs = $form.find('.ffb-modal__tab-headers:first').find('.ffb-modal__tab-header');
			$elementTabs.removeClass('ffb-modal__tab-header--filled');

			var elementSystemTabsQuery = diffQuery.get('o');
			// ignore system repeatable sections
			for( var i in systemSections ) {
				var oneSection = systemSections[ i ];

				if( elementSystemTabsQuery.exists( oneSection ) ) {
					$elementTabs.filter('[data-id="' + oneSection +'"]').addClass('ffb-modal__tab-header--filled');
				}
			}

			// mark element

			// general tab and repeatables
			var markAdvancedTools_recursive = function( $options, query, routeOld ) {

				$options.findButNotInside('.ff-repeatable-js, .ff-toggle-box-advanced').each(function(){
					var route = $(this).attr('data-current-section-route');

					// its not the general options tab but first level tab
					if( route.indexOf('o gen') == -1 ) {
						return;
					}

					// deduct the route
					if( routeOld != undefined ) {
						route = route.split( routeOld ).pop();
						route = route.trim();
					}

					// ignore system repeatable sections
					for( var i in systemSections ) {
						var oneSection = systemSections[ i ];

						if( route != undefined && route.indexOf( oneSection + ' ') != - 1 ) {
							return;
						}
					}

					var $this = $(this);

					// route is undefined
					if( route == undefined ) {
						return null;
					}

					// route does not exists
					if( !query.exists(route )  ){
						return null;
					}

					var markOneRepeatableVariation = function( $node, query ) {
						var hasBeenChanged = false;

						var $tabs = $node.find('.ffb-modal__tab-headers:first').find('.ffb-modal__tab-header');
						$tabs.removeClass('ffb-modal__tab-header--filled');
						// mark system repeatable sections
						for (var i in systemSections) {
							var oneSection = systemSections[i];

							if (query.getWithoutComparationDefault(oneSection, null) != null) {
								hasBeenChanged = true;

								$tabs.filter('[data-id="' + oneSection +'"]').addClass('ffb-modal__tab-header--filled');
								// $node.find('[data-id="' + oneSection +'"]:first').css('color', 'red');
							}
						}

						if (hasBeenChanged == true) {
							$node.find('.ff-show-advanced-tools:first').addClass('ff-show-advanced-tools--active');
						} else {
							$node.find('.ff-show-advanced-tools:first').removeClass('ff-show-advanced-tools--active');
						}

						var newRouteDeduction = route + ' ' + $node.attr('data-section-id');

						markAdvancedTools_recursive($node, query, newRouteDeduction);
					};

					var newQuery = query.get( route );

					if(  $this.hasClass('ff-repeatable-js') ) {
						newQuery.each(function (query, variationType, index) {
							var $node = $this.children().eq(index);
							markOneRepeatableVariation( $node, query );
						});
					} else {
						var $node = $(this).children('li');
						markOneRepeatableVariation( $node, newQuery );
					}
				});

			};

			markAdvancedTools_recursive( $html, diffQuery );


		},

		renderOptionsFormCssClasses: function( $html ) {

			var elementId = this.getUniqueId();
			var level = 0;
			var currentLevel = 0;
			var counters = new Array();
			var classes = new Array();
			var systemSections = this.getSystemSectionNames();


			$html.find('.ff-insert-unique-css-class').html( '.ffb-id-' + elementId );

			$html.find('.ff-repeatable-item-js, .ff-toggle-box-advanced, .ff-css-wrapper').each(function(){

				// filter system sections
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

					if( dataCurrentLevel > currentLevel ) {
						level++;
					}
					else if (dataCurrentLevel == currentLevel ) {
						classes.pop();
					}
					else if( dataCurrentLevel < currentLevel ) {
						level--;
					}

					if( counters[level] == undefined ) {
						counters[level] = 0;
					}

					counters[ level ] ++;
					counters.splice( level + 1);

					if( dataCurrentLevel > currentLevel || dataCurrentLevel == currentLevel ) {
						var newId;

						if( $this.hasClass('ff-repeatable-item-js') ) {
							newId = '.ffb-' + id + counters.join('-');
						} else if( $this.hasClass( 'ff-toggle-box-advanced' ) ) {
							newId = '.ffb-' + id;
						}

						classes.push( newId );
					} else {
						classes.pop();
					}

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

		lastGeneratedId: null,

		generateUniqueId: function() {
			var number = new Date().getTime() -  new Date('2016-01-01').getTime();
			// this.lastGeneratedId = number;
			if( this.lastGeneratedId != null && this.lastGeneratedId >= number ) {
				number = this.lastGeneratedId + 1;
			}
			var newId = number.toString( 32 );
			this.lastGeneratedId = number;
			return newId;


		},

		generateUniqueIdClass: function( uniqueId ) {
			if( uniqueId == undefined ) {
				uniqueId = this.generateUniqueId();
			}

			return 'ffb-id-' + uniqueId;
		},

		createElementBackendHtml: function() {
			var self = this;
			var elementId = this.currentElementId;

			var itemId = elementId;
			var newItemModel = self.elementModels[ itemId ];

			var $newItemHTML = $(newItemModel.get('defaultHtml'));

			var uniqueId = self.generateUniqueId();
			var uniqueIdClass = self.generateUniqueIdClass( uniqueId );

			//self.$el.find('.ffb-dropzone:first').append( $newItemHTML);

			$newItemHTML.appendTo( self.$el.find('.ffb-dropzone:first') );

			$newItemHTML.attr('data-unique-id', uniqueId );
			$newItemHTML.addClass(uniqueIdClass);

			return $newItemHTML;
		},


        renderAddForm: function( insertElementCallback ) {
			var self = this;

			var called = false;

			this.elementPickerView.callback_ItemSelected = function( $item ) {
				var itemId = $item.attr('data-id');
				var newItemModel = self.elementModels[ itemId ];

				var $newItemHTML = $(newItemModel.get('defaultHtml'));

				var uniqueId = self.generateUniqueId();
				var uniqueIdClass = self.generateUniqueIdClass( uniqueId );

				//self.$el.find('.ffb-dropzone:first').append( $newItemHTML);

				if( insertElementCallback != undefined ) {
					insertElementCallback( $newItemHTML );
				} else {
					$newItemHTML.appendTo( self.$el.find('.ffb-dropzone:first') );
				}

				$newItemHTML.attr('data-unique-id', uniqueId );
				$newItemHTML.addClass(uniqueIdClass);

				$('.ffb-modal-origin').removeClass('ffb-modal-add-element');

				self.vent.f.modalHide();
				self.vent.f.connectElement($newItemHTML);
				called = true;
				self.vent.f.animateCanvasElement( $newItemHTML, 'inserted-new-element');
			};



			var $addElementHtml = this.elementPickerView.renderAddFormHtml( this );


			if( !called ) {

				// $('.')

				$('.ffb-modal-origin').addClass('ffb-modal-add-element');

				this.vent.f.modalSetContent( $addElementHtml );
				this.vent.f.modalShow();

				$('.ffb-filterable-library__search').focus();


			}




        },


/**********************************************************************************************************************/
/* CONTEXT MENU
/**********************************************************************************************************************/

		canWeInsertElementInside: function ( insertedElementId ) {

			var parentModel = this.model;
			if( this.$el.hasClass('ffb-canvas') ) {
				var parentName = 'Canvas';
				var parentId = 'canvas';
			} else {
				var parentName = parentModel.get('name');
				var parentId = parentModel.get('id');
			}

			var childModel = this.elementModels[ insertedElementId ];
			var childId = insertedElementId;

			var errorMessage = 'Element ' + childModel.get('name') + ' cannot be inserted inside ' + parentName;

			var whitelistedParent = childModel.get('parentWhitelistedElement');

			if( whitelistedParent.length > 0 && whitelistedParent.indexOf( parentId ) == -1 ) {
				return errorMessage;
			}

			if( parentId != 'canvas' ) {

				// check blacklisted Elements
				var blacklistedDropzone = parentModel.get('dropzoneBlacklistedElements');
				if( blacklistedDropzone.length > 0 && blacklistedDropzone.indexOf( childId ) != -1 ) {
					return errorMessage;
				}

				// check whitelisted Elements
				var whitelistedDropzone = parentModel.get('dropzoneWhitelistedElements');
				if( whitelistedDropzone.length > 0 && whitelistedDropzone.indexOf( childId ) == -1 ) {
					return errorMessage;
				}

			}

			return true;
		},

		deleteElement: function() {
			var self = this;
			var confirmation = confirm('Do you really want to delete this element and everything inside it?');

			if( confirmation ) {
			
				// Animate Out

				var $thisEl = this.$el;

				$thisEl.animateCSS('zoomOut');

				if ( $thisEl.is('.ffb-element-column') ){
					$thisEl.hide(301);
				} else {
					$thisEl.slideUp(301);
				}

				setTimeout(function(){

					$thisEl.remove();
					self.vent.f.canvasChanged();
				}, 301)


				this.vent.f.addNotification('info', 'Element has been deleted');
			}

		},

		pasteElement: function() {
			var elementValue = frslib.clipboard.pasteFrom();

			var $element = $(elementValue);

			/*----------------------------------------------------------*/
			/* COULD WE DROP CHECK
			/*----------------------------------------------------------*/
			var $parent = this.$el.parents('.ffb-element:first');
			var parentElementId = $parent.attr('data-element-id');
			var originalElementId = $element.attr('data-element-id');

			console.log( originalElementId, parentElementId );




			this.$el.after( $element );


			// Animate In

			$element.slideUp(0);

			$element.animateCSS('zoomIn');

			if ( $element.is('.ffb-element-column') ){
				$element.show(301);
			} else {
				$element.slideDown(301);
			}

		},


		copyElement: function() {
			var self = this;
			var $newElement = this.$el.clone();

			this.$el.addClass('ffb-element-anim-copy').animateCSS('fadeIn');

	        this.$el.one('animationend webkitAnimationEnd oAnimationEnd MSAnimationEnd', function(){
	            $(this).removeClass('ffb-element-anim-copy');
	        });

			this.vent.f.addNotification('info', 'Element is in clipboard');

			this.normalizeElementAfterCopyAndDuplication( $newElement );

			frslib.clipboard.copyTo( $('<div></div>').append( $newElement ).html() );
			// this.$el.before( $('<div></div>').append( $newElement ).html());
		},

		duplicateElement: function() {
			var self = this;
			var $newElement = this.$el.clone();

			this.normalizeElementAfterCopyAndDuplication( $newElement );

			this.$el.after( $newElement );

			this.vent.f.connectElement( $newElement );

			this.vent.f.animateCanvasElement( $newElement, 'element-duplicated');

			this.vent.f.addNotification('info', 'Element has been duplicated');
		},

		normalizeElementAfterCopyAndDuplication: function( $element ) {
			var self = this;
			$element.find('.ffb-element').addBack('.ffb-element').each(function(){
				var newUniqueId = self.generateUniqueId();
				$(this).attr('data-unique-id', newUniqueId );
			});

			$element.removeClass('action-toggle-context-menu-opened');
			$element.find('.context-menu-active').removeClass('context-menu-active');

			this.vent.f.initTooltips( $element );
		},

		canvasChanged: function(){
			this.vent.f.canvasChanged();
		},

		/**
		 * saveOptionsForm
		 * Saves the form into element data-attr directly
		 */
		saveOptionsForm: function() {

			var data = this.optionsManager.parseForm();

			return;

			var $form = $('.ffb-modal').find('.ff-options-js');

			//function( $form, returnForm, deleteOriginalForm, ignoreDefaultValues )
			var data = frslib.options.template.functions.normalizeFast( $form, undefined, undefined, undefined, true );

			var dataString = JSON.stringify(data.elementData);

			this.setOptionsData( dataString );


			var query = this.getOptionsQuery().get('o gen');

			var renderContentInfo = this.model.get('functions.renderContentInfo_JS');

			var previewObject = this.getPreviewObject( query );
			previewObject.$el = this.$el;

			this.$el.children('.ffb-element-preview').html('');

			renderContentInfo(query, data.elementData, this.$el.children('.ffb-element-preview'), this.$el, this.vent.d.blocksCallbacks,  previewObject, this, $form );
			previewObject.render();

			this.isElementDisabled();

			this.vent.f.animateCanvasElement(this.$el, 'element-options-changed');

			this.vent.trigger(this.vent.a.canvasChanged);

			if( this.$el.children('.ffb-element-preview').html().length == 0 ) {
				this.$el.children('.ffb-element-preview').html('<div class="ffb-preview-empty"><i class="ffb-preview-empty-content ff-font-awesome4 icon-eye-slash"></i></div>');
			}

			this.vent.f.addNotification('info', 'Your changes have been saved!')
		},


		/**
		 * Original data are the ones set as a data param in the element. New datas are the ones set as a
		 * @returns {boolean}
		 */
		formHasBeenEdited: function() {

			return false;
			var originalData = JSON.parse(this.getOptionsData());

			var $form = $('.ffb-modal').find('.ff-options-js');
			var newData = frslib.options.template.functions.normalizeFast( $form, undefined, undefined, undefined, true ).elementData;
			// console.log(JSON.stringify( newData) );
			// console.log( JSON.stringify( originalData)  );

			// level 1
			if( JSON.stringify( newData) == JSON.stringify( originalData ) ) {
				return false;
			}

			var origDataString = ( JSON.stringify( this.getOptionsWithDifferencies(originalData) ) );
			var newDataString = ( JSON.stringify( this.getOptionsWithDifferencies(newData) ) );

			// console.log( origDataString );
			// console.log( newDataString );

			return( origDataString != newDataString );
		},

		saveDefaultElementData: function() {
			var $form = $('.ffb-modal').find('.ff-options-js');

			var dataDiff = this.getOptionsWithDifferencies(frslib.options.template.functions.normalizeFast( $form, undefined, undefined, undefined, true ).elementData );
			var data = {};

			data.elementId = this.model.get('id');
			data.elementDefaultData = dataDiff;

			frslib.ajax.frameworkRequest( 'ff-builder-save-default-element-data', null, data, function( response ) {
				console.log( response );
			});
		},



		getOptionsWithDifferencies: function( data ) {
			var self = this;
			var walker = frslib.options.walkers.toScContentConvertor();
			walker.useContentParams = false;
			walker.setDataJSON( data );


			walker.setStructureJSON( this.model.get('optionsStructure'));
			walker.walker.callbackGetBlockItem = function( uniqueHash ) {
				return (self.vent.d.blocksData[ uniqueHash ]);
			};
			return walker.walk();
		},

		/**
		 * convertOptionsToShortcodes
		 * Some of the options are meant to be printed as a content. This is because of search and UTF8 characters.
		 * This function divides the data to the data-attr part and content part
		 * @returns {{}}
		 */
		convertOptionsToShortcodes: function() {
			var self = this;
			var walker = frslib.options.walkers.toScContentConvertor();
			walker.setDataJSON( this.getOptionsDataJSON() );
			walker.setStructureJSON( this.model.get('optionsStructure'));
			walker.walker.callbackGetBlockItem = function( uniqueHash ) {
				return (self.vent.d.blocksData[ uniqueHash ]);
			};
			var toReturn = {};
			toReturn.options = ( walker.walk());
			toReturn.shortcodes = walker.contentOutput;

			return toReturn;
		},

		/**
		 * Each element has option to render content preview, containing some important data
		 */
		renderContentPreview: function() {
			var query = this.getOptionsQuery().get('o gen');
			// var data = this.getOptionsDataJSON();

			var data = ( this.getOptionsWithDifferencies(  this.getOptionsData()) );

			var renderContentInfo = this.model.get('functions.renderContentInfo_JS');
			var previewObject = this.getPreviewObject( query );
			previewObject.$el = this.$el;

			if( this.getOptionsData() == 'null' ) {
				this.setOptionsData( data);
			}

			this.$el.children('.ffb-element-preview').html('');

			renderContentInfo(query, data.elementData, this.$el.children('.ffb-element-preview'), this.$el, this.vent.d.blocksCallbacks,  previewObject, this );
			previewObject.render();

			this.isElementDisabled();

			if( this.$el.children('.ffb-element-preview').html().length == 0 ) {
				this.$el.children('.ffb-element-preview').html('<div class="ffb-preview-empty"><i class="ffb-preview-empty-content ff-font-awesome4 icon-eye-slash"></i></div>');
			}

		},

		clearOptionsForm: function() {
			this.vent.f.modalCleanContent();
		},

		getPreviewObject: function( query ) {
			var previewViewClass = Backbone.View.extend({

				escapeHtml: function(text) {
					if( text == undefined ) {
						return text;
					}

					text = text.split('&quot;').join('"');

					text = text.split('<').join('&lt;');
					text = text.split('>').join('&gt;');

					return text.split('&quot;').join('"');
				},

				html : '',

				escapeHeading: function( heading ) {
					var maxNumChar = 75;

					if( heading.length > maxNumChar ) {
						heading = heading.substr(0, maxNumChar );
						heading = heading + '...';
					}

					return heading;
				},

				escapeText: function( text ) {
					var maxNumChar = 300;

					if( text.length > maxNumChar ) {
						text = text.substr(0, maxNumChar );
						text = text + '...';
					}

					return text;
				},

				addHeadingLg: function( heading ) {
					heading = this.escapeHeading( heading );
					this.html += '<div class="ffb-preview-heading-lg"><span>' + this.escapeHtml( heading ) + '</span></div>';
				},

				addHeadingSm: function( heading ) {
					heading = this.escapeHeading( heading );
					this.html += '<div class="ffb-preview-heading-sm"><span>' + this.escapeHtml( heading ) + '</span></div>';
				},

				addText: function( text ){
					text = this.escapeText( text );
					this.html += '<div class="ffb-preview-text">' + this.escapeHtml( text ) + '</div>';
				},

				addLink: function( text ){
					this.html += '<div class="ffb-preview-button">' + this.escapeHtml(text ) + '</div>';
				},

				addVideo: function( text ){
					this.html += '<div class="ffb-preview-video">' + this.escapeHtml(text) + '</div>';
				},

				addDivider: function( text ){
					this.html += '<div class="ffb-preview-divider"></div>';
				},

				addImage: function( src, textBefore, textAfter ){
					if (textBefore){}else textBefore = '';
					if (textAfter){}else textAfter = '';

					if( src.indexOf('"id":') != -1 && src.indexOf('"url":') != -1 ) {
						src = JSON.parse( src );

						if( src.id == -1 ) {
							src.url = ff_fw_template_url + '/builder/placeholders/' + src.url;
						}

						src = src.url;
					}

					this.html += textBefore + '<img class="ffb-preview-image" src="' + src + '" />' + textAfter;
				},

				addIcon: function( icon, textBefore, textAfter ){
					if (textBefore){}else textBefore = '';
					if (textAfter){}else textAfter = '';

					this.html += textBefore + '<div class="ffb-preview-icon"><i class="ffb-preview-icon-content ' + icon + '"></i></div>' + textAfter;
				},

				addPlainText: function( plainText ) {
					this.html += plainText;
				},

				render : function() {
					// this.$el.css('opacity', 0.5);
					if( this.html.length > 0 ) {
						this.$el.children('.ffb-element-preview').html( this.html );
					}
				}

			});

			var preview = new previewViewClass({ $el : this.$el });


			frslib.options.getNewEmptyQueryObject = function() {
				var _ = {};
				_.addHeadingLg = function( query, htmlBefore, htmlAfter ) {
					if (htmlBefore){}else htmlBefore = '';
					if (htmlAfter){}else htmlAfter = '';

					var value = '';
					if( query != null ) {
						value = _.get( query );
					}
					preview.addHeadingLg (htmlBefore + value + htmlAfter);
				};

				_.addHeadingSm = function( query, htmlBefore, htmlAfter ) {
					if (htmlBefore){}else htmlBefore = '';
					if (htmlAfter){}else htmlAfter = '';

					var value = '';
					if( query != null ) {
						value = _.get( query );
					}
					preview.addHeadingSm (htmlBefore + value + htmlAfter);
				};

				_.addText = function( query, htmlBefore, htmlAfter ) {
					if (htmlBefore){}else htmlBefore = '';
					if (htmlAfter){}else htmlAfter = '';

					var value = '';
					if( query != null ) {
						value = _.get( query );
					}
					preview.addText (htmlBefore + value + htmlAfter);
				};

				_.addLink = function( query, htmlBefore, htmlAfter ) {
					if (htmlBefore){}else htmlBefore = '';
					if (htmlAfter){}else htmlAfter = '';

					var value = '';
					if( query != null ) {
						value = _.get( query );
					}
					preview.addLink (htmlBefore + value + htmlAfter);
				};

				_.addVideo = function( query, htmlBefore, htmlAfter ) {
					if (htmlBefore){}else htmlBefore = '';
					if (htmlAfter){}else htmlAfter = '';

					var value = '';
					if( query != null ) {
						value = _.get( query );
					}
					preview.addVideo (htmlBefore + value + htmlAfter);
				};

				_.addDivider = function( query, htmlBefore, htmlAfter ) {
					if (htmlBefore){}else htmlBefore = '';
					if (htmlAfter){}else htmlAfter = '';

					var value = '';
					if( query != null ) {
						value = _.get( query );
					}
					preview.addDivider (htmlBefore + value + htmlAfter);
				};

				_.addImage = function( query, htmlBefore, htmlAfter ) {
					if (htmlBefore){}else htmlBefore = '';
					if (htmlAfter){}else htmlAfter = '';

					var value = '';
					if( query != null ) {
						value = _.get( query );
					}
					preview.addImage (value, htmlBefore, htmlAfter);
				};

				_.addIcon = function( query, htmlBefore, htmlAfter ) {
					if (htmlBefore){}else htmlBefore = '';
					if (htmlAfter){}else htmlAfter = '';

					var value = '';
					if( query != null ) {
						value = _.get( query );
					}
					preview.addIcon (value, htmlBefore, htmlAfter);
				};

				_.addPlainText = function( text ) {
					preview.addPlainText( text );
				};

				_.addBreak = function() {
					preview.addPlainText('</br>');
				};

				return _;
			}

			query.addHeadingLg = function( query, htmlBefore, htmlAfter) {
				if (htmlBefore){}else htmlBefore = '';
				if (htmlAfter){}else htmlAfter = '';

				var value = '';
				if( query != null ) {
					value = this.get( query );
				}
				preview.addHeadingLg (htmlBefore + value + htmlAfter);
			};

			query.addHeadingSm = function( query, htmlBefore , htmlAfter ) {
				if (htmlBefore){}else htmlBefore = '';
				if (htmlAfter){}else htmlAfter = '';

				var value = '';
				if( query != null ) {
					value = this.get( query );
				}
				preview.addHeadingSm (htmlBefore + value + htmlAfter);
			};

			query.addBreak = function() {
				preview.addPlainText('</br>');
			};

			query.addText = function( query, htmlBefore, htmlAfter ) {
				if (htmlBefore){}else htmlBefore = '';
				if (htmlAfter){}else htmlAfter = '';

				var value = '';
				if( query != null ) {
					value = this.get( query );
				}
				preview.addText (htmlBefore + value + htmlAfter);
			};

			query.addLink = function( query, htmlBefore, htmlAfter ) {
				if (htmlBefore){}else htmlBefore = '';
				if (htmlAfter){}else htmlAfter = '';

				var value = '';
				if( query != null ) {
					value = this.get( query );
				}
				preview.addLink (htmlBefore + value + htmlAfter);
			};

			query.addVideo = function( query, htmlBefore, htmlAfter ) {
				if (htmlBefore){}else htmlBefore = '';
				if (htmlAfter){}else htmlAfter = '';

				var value = '';
				if( query != null ) {
					value = this.get( query );
				}
				preview.addVideo (htmlBefore + value + htmlAfter);
			};

			query.addDivider = function( query, htmlBefore, htmlAfter ) {
				if (htmlBefore){}else htmlBefore = '';
				if (htmlAfter){}else htmlAfter = '';

				var value = '';
				if( query != null ) {
					value = this.get( query );
				}
				preview.addDivider (htmlBefore + value + htmlAfter);
			};

			query.addImage = function( query, htmlBefore, htmlAfter ) {
				if (htmlBefore){}else htmlBefore = '';
				if (htmlAfter){}else htmlAfter = '';

				var value = '';
				if( query != null ) {
					value = this.get( query );
				}
				preview.addImage (value, htmlBefore, htmlAfter);
			};

			query.addIcon = function( query, htmlBefore, htmlAfter ) {
				if (htmlBefore){}else htmlBefore = '';
				if (htmlAfter){}else htmlAfter = '';

				var value = '';
				if( query != null ) {
					value = this.get( query );
				}
				preview.addIcon (value, htmlBefore, htmlAfter);
			};

			query.addPlainText = function( text ) {
				preview.addPlainText( text );
			}

			return preview;
		},


		/**
		 * Get the options query object and inject proper data to it
		 * @returns {*}
		 */
		getOptionsQuery: function( data ) {
			var query = null;
			if( data == undefined ) {
				query = frslib.options.query( this.getOptionsDataJSON() );            // create options query
			} else {
				query = frslib.options.query( data );            // create options query
			}
			var structure = {};
			structure.data = _.extend({},this.model.get('optionsStructure'));

			query.setOptionsStructure(  structure ); // set options structure, in case we would need to get some default data
			return query;
		},

		/**
		 * get just the DATA attribute
		 * @returns {*}
		 */
		getOptionsData: function() {

			// var id = this.getUniqueId();
			// var data =  this.vent.o.elementData[ id ];
			//
			// if( data == undefined ) {
			// 	data = this.$el.attr('data-options');
			// }
			//
			// return data;

			var data = this.$el.attr('data-options');

			return data;
		},

		setOptionsData: function( data ) {
			if( typeof data != 'string' ) {
				data = JSON.stringify( data );
			}
			// var id = this.getUniqueId();
			// this.vent.o.elementData[ id ] = data;
			
			this.$el.attr('data-options', data);
		},

		getOptionsDataJSON: function() {
			return JSON.parse( this.getOptionsData() );
		},

		getUniqueId: function() {
			return this.$el.attr('data-unique-id');
		},

		getElementId: function() {
			var id = this.$el.attr('data-element-id');

			if( id == undefined ) {
				return this.currentElementId;
			}
			return this.$el.attr('data-element-id');
		}



	});

/**********************************************************************************************************************/
/* ELEMENT MODEL
/**********************************************************************************************************************/
	/**
	 * Element Model - having data about the element inside, including options structure and JS functions and all this stuff
	 */
	window.ffbuilder.ElementModel = Backbone.DeepModel.extend({
		/**
		 * functions are saved as strings, we create a functions from them
		 */
		processFunctions: function(){
			var self = this;
			$.each( this.get('functions'), function(key, value){

				var f = null; // temporary function holder

				eval('f = ' + value );
				self.set('functions.'+key, f);

			});
		}
	});



})(jQuery);