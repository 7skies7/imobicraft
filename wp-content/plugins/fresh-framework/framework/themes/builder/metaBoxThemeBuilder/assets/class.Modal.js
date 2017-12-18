(function($){
	frslib.provide('window.ffbuilder');

	window.ffbuilder.Modal = Backbone.View.extend({

		_modalOpened: false,

		_vent: null,

		_modalMode: null,

		_currentElementView: null,

		_addElementCallback: null,

		_sections: null,

		_$currentContent: null,

		_bindActions: function() {
			var self = this;
			this.$el.find('.ffb-modal__action-cancel').click(function(e){
				if( self._modalMode =='add' && $(e.toElement).hasClass('ffb-modal__action-cancel') ) {

					self._closeModal();
					return false;
				}

				if(e.target != this) return;

				if( self._modalMode !='add' && self._currentElementView.hasElementFormBeenChanged() ) {
					var modal = new frslib.options2.modal();
					modal.printConfirmBox('Are you sure you want to close the window? Unsaved changes will be lost.', function( result ){
						if( result == true ) {
							self._closeModal();
						}
					});
				} else {
					self._closeModal();
					return false;
				}

				return false;
			});

			this.$el.find('.ffb-modal__action-save').click(function(e){
				e.stopPropagation();
				self._currentElementView.saveRenderedOptionsForm();
				// self._vent.f.saveAjax();
				self._closeModal();

				return false;
			});

			this.$el.find('.ffb-modal__action-save-all').click(function(e){
				e.stopPropagation();
				self._currentElementView.saveRenderedOptionsForm();
				self._vent.f.saveAjax();

				return false;
			});

			this.$el.on('click', '.ffb-modal__action-save-all', function(e){
				e.stopPropagation();
				self._currentElementView.saveRenderedOptionsForm();
				self._vent.f.saveAjax();

				return false;
			});

			this.$el.on('click', '.ff-save-default-data', function(e){
				var data = self._currentElementView.getOptionsFormData();

				var elementId = self._currentElementView.getElementId();
				self._vent.f.saveAjaxDefaultElementData( elementId, data );
			});

			this.$el.on('click', '.ff-global-style-select', function(e){
				var globalStyleVariations = self._currentElementView.getGlobalStyleVariations();
				var $styleSelector = self._getGlobalStyleHtml( globalStyleVariations );

				$.freshfaceBox( $styleSelector );
				// var test ='<div class="ff-modal-select-views-wrapper"><div class="ff-views-title">Select Layout</div><div class="ff-edit-views-list"><div data-view-id="blog-archive" data-is-default="1" class="ff-one-view-default ff-one-view" data-is-assigned="1"><div class="ff-act-use"><div class="ff-name">Blog Archive</div><div class="ff-assigned-views">Assigned to: Blog Archive</div></div><div class="ff-one-view-edit-button"></div></div><div data-view-id="page" data-is-default="1" class="ff-one-view-default ff-one-view ff-one-view-active" data-is-assigned="1"><div class="ff-act-use"><div class="ff-name">Page</div><div class="ff-assigned-views">Assigned to: Page</div></div><div class="ff-one-view-edit-button"></div></div><div data-view-id="post" data-is-default="1" class="ff-one-view-default ff-one-view" data-is-assigned="1"><div class="ff-act-use"><div class="ff-name">Post</div><div class="ff-assigned-views">Assigned to: Blog Single</div></div><div class="ff-one-view-edit-button"></div></div></div><div class="ff-add-new-view"></div></div>';
				// $.freshfaceBox( test );
			});

			//
		},

		initialize: function( options ){

            if( options.getOnlyModalHTML != undefined ) {
                return this._generateElementHtml();
            }

			this._vent = options.vent;
			this.$el = $(this._generateElementHtml());

            var dataMan = new frslib.options2.dataManager();
            var self = this;
            dataMan.getElementGlobalStyles( function(styles){

                if( !styles || Object.keys(styles).length === 0) {
                    console.log( styles );
                    self.$el.find('.ff-global-style-select').css('display', 'none');
                    self.$el.addClass('ffb-modal__hide-global-styles');
                }

            });

            if( frslib.options2.dataHolder.elementGlobalStyles == undefined || Object.getOwnPropertyNames(frslib.options2.dataHolder.elementGlobalStyles).length == 0 ) {

            }

			this.$el.find('[data-ffb-tooltip]').freshfaceTooltip();
			$('body').append( this.$el);
			this._bindActions();
		},

		/**********************************************************************************************************************/
		/* GLOBAL STYLES HANDLING HERE
		 /**********************************************************************************************************************/
		_getGlobalStyleHtml: function( variations) {

            if( frslib.options2.dataHolder.elementGlobalStyles == undefined || Object.getOwnPropertyNames(frslib.options2.dataHolder.elementGlobalStyles).length == 0 ) {
                $('.ff-global-style-select').css('display', 'none');
                return $('<div></div>');
            }

			var self = this;

			var currentlySelectedStyle = 0;
			var systemData =self._currentElementView.getSystemInfoFromForm();

			if( systemData['global-style'] != undefined ) {
				currentlySelectedStyle = systemData['global-style'];
			}

			var getOneStyle = function( name, value ) {
				var isDefaultSection = ( value == 0 );


				var html =
					"      <div data-style-id=\"\" data-is-default=\"\" class=\" ff-one-view\" >" +
					"         <div class=\"ff-act-use\">" +
					"            <div class=\"ff-name\"></div>" +
					"         </div>" +
					"         <div class=\"ff-one-view-edit-button\"></div>" +
					"      </div>";

				var $html = $(html);

				$html.attr('data-style-id', value);

				if( isDefaultSection ) {
					$html.attr('data-is-default', 1);
					$html.addClass('ff-one-view-default');
				} else {
					$html.attr('data-is-default', 0);
				}

				$html.find('.ff-name').html( name);

				var menuItems = [];

				menuItems.push({ name: 'Select', value: 'select'});
				// menuItems.push({ name: 'Duplicate', value: 'duplicate'});

				if( !isDefaultSection ) {
					menuItems.push({ name: 'Rename', value: 'rename'});
					menuItems.push({ name: 'Delete', value: 'delete'});
				}

				var selectMenuItem = function( $item ) {
					var selectedId = $item.attr('data-style-id');
					self._currentElementView.setSystemInfoToForm('global-style', selectedId );

					$item.siblings().removeClass('ff-one-view-active');
					$item.addClass('ff-one-view-active');

					self.$el.find('.ff-global-style-select').html( $item.find('.ff-name').html() );
				};

				var contextMenuCallback = function( result, $item ) {
					var $parent = $item.parents('.ff-one-view');
					var globalStyleID = $parent.attr('data-style-id');

					// console.log( globalStyleID  + 'xxx');

					switch( result ) {
						case 'select':
							selectMenuItem( $parent );
							break;

						case 'delete':
							if( $parent.hasClass('ff-one-view-active') ) {
								$.freshfaceAlertBox('Cannot delete selected global style. Switch to different global style for first');
							} else {
								$.freshfaceConfirmBox('Are you sure you want to delete this style? It will be lost permanently.', function( result ){
									if( result == true ) {
										self._currentElementView.deleteGlobalStyle( globalStyleID );
										$parent.hide(500, function(){ $parent.remove(); });
									}
								});

							}
							break;

						case 'rename':
							var currentName = $parent.find('.ff-name').html();
							$.freshfaceInputBox({
								confirmText:'Rename this global style',
								inputText : currentName,
							}, function( result ) {
								$parent.find('.ff-name').html( result );
								if( $parent.hasClass('ff-one-view-active') ) {
									self.$el.find('.ff-global-style-select').html(result);
								}

								self._currentElementView.setGlobalStyleName( globalStyleID, result );
							});
							break;
					}

				};

				$html.find('.ff-one-view-edit-button').freshfaceContextMenu({ menuItems: menuItems, openAction:'contextmenu click'}, contextMenuCallback);
				$html.find('.ff-act-use').freshfaceContextMenu({ menuItems: menuItems, openAction:'contextmenu'}, contextMenuCallback);

				$html.on('click', function(){
					selectMenuItem( $(this) );
				});

				return $html;
			};

			var sb = "<div class=\"ff-modal-select-views-wrapper\">" +
				"   <div class=\"ff-views-title\">Select Global Style</div>" +
				"   <div class=\"ff-edit-views-list\">" +

				"   </div>" +
				"   <div class=\"ff-add-new-view\"></div>" +
				"</div>";

			var $globalStyle = $(sb);

			for( var i in variations ) {
				var oneVariation = variations[i];
				var $oneHtml = getOneStyle( oneVariation.name, oneVariation.value );
				$globalStyle.find('.ff-edit-views-list').append( $oneHtml );

				if( oneVariation.value == currentlySelectedStyle ) {
					$oneHtml.addClass('ff-one-view-active');
				}
			}

			if( $globalStyle.find('.ff-one-view-active').size() == 0 ) {
				$globalStyle.find('.ff-one-view-default').addClass('ff-one-view-active');
			}

			var activeName = $globalStyle.find('.ff-one-view-active').find('.ff-name').html();
			self.$el.find('.ff-global-style-select').html( activeName );

			var addNewGlobalStyle = function(){
				$.freshfaceInputBox({confirmText:'Please specify new global style name'}, function( name ){
					if( name == false) {
						return true;
					};
					var newId = frslib.stringToId( name );

					if( newId == 0 || newId == '0' || self._currentElementView.getGlobalStyle( newId ) !== null ) {
						$.freshfaceAlertBox('This Global Style already exists, please name it differently');
						return false;
					}

					self._currentElementView.setGlobalStyleName( newId, name );

					var $newStyle = getOneStyle(name, newId );
					$globalStyle.find('.ff-edit-views-list').append( $newStyle);

					return true;
				});
			}

			$globalStyle.find('.ff-add-new-view').click( addNewGlobalStyle );

			return $globalStyle;
		},

		_transformModalToAddElement: function() {
			this.$el.addClass('ffb-modal-add-element');
			this._setModalTitle('Add Element / Section');
		},

		_transformModalToEditElement: function() {
			this.$el.removeClass('ffb-modal-add-element');
		},

		renderEditElement: function( elementView ) {
			this._modalMode = 'edit';

			this._currentElementView = elementView;

			var model = elementView._model;
			var $content = elementView.getOptionsForm();
			this._transformModalToEditElement();
			this._setModalContent( $content );
			this._setModalTitle( model.get('name') );
			this._setModalPreviewImage( model.get('previewImage') );

			var currentGlobalStyleName = elementView.getCurrentGlobalStyle().name;
			this.$el.find('.ff-global-style-select').html(currentGlobalStyleName);

			this._openModal();
			$.freshfaceWait({action:'deactivate'});
		},

		/**********************************************************************************************************************/
		/* RENDER ADD ELEMENT - basic classes
		 /**********************************************************************************************************************/
		renderAddElement: function( elementView, callback ) {
			var self = this;
			this._modalMode ='add';

			this._currentElementView = elementView;
			this._addElementCallback = callback;

			this._transformModalToAddElement();
			this._openModal();
			var $content = this._renderAddElement_getHtml();
			this._setModalContent( $content );


			$content.find('.ffb-filterable-library__search').focus();
		},

		triggerSectionTab: function() {
			this.$el.find('.ffb-modal__tab-header-sections').trigger('click');
		},

		_renderAddElement_elementSelected: function( $li ) {
			var id = $li.attr('data-id');
			var elementView = this._vent.f.getElementViewFromId( id );
			this._closeModal();
			this._addElementCallback('element', elementView);

		},

		_renderAddElement_sectionSelected: function( $li ) {
			var id = $li.attr('data-id');
			var sectionData = null;

			for( var i in this._sections) {
				var oneData = this._sections[i];

				if( oneData.id == id ) {
					sectionData = this._sections[i];
					break;
				}
			}

			this._closeModal();
			this._addElementCallback('section', sectionData);
		},

		_renderAddElement_getHtml: function() {
			var self = this;

			var $content = this._renderAddElement_getComplexHtmlWrappers();
			var $elementPicker = this._renderElementPicker();
			var $sectionPicker = this._renderSectionPicker();

			$content.find('.ffb-modal__tab-content[data-id="elements"] .ffb-modal__content--options').html( $elementPicker );
			$content.find('.ffb-modal__tab-content[data-id="sections"] .ffb-modal__content--options').html( $sectionPicker );



			// hide all menus except for all
			// $content.find('.ffb-filterable-library__filters').children('li').css('display', 'none');
			$content.find('.ffb-filterable-library__filters').find('.ffb-filterable-library__filter-all').css('display', '');

			// show only the used menu
			$content.find('.ffb-filterable-library__content').children('.ffb-flib-item').each(function(){
				var menuId = $(this).attr('data-menu-id');
				var menuSelector = '.ffb-filterable-library__filter-' + menuId;
				$content.find( menuSelector ).css('display', '');
			});

			// filtering
			$content.find('.ffb-modal__tab-content-elements').find('.ffb-filterable-library__filter').click(function(){
				var $parent = $(this).parents('.ffb-filterable-library:first');

				$(this).siblings().removeClass('ffb-filterable-library__filter--active');
				$(this).addClass('ffb-filterable-library__filter--active');

				var filter = $(this).attr('data-filter');
				var filterClass = '.filt--menu--' + filter;

				$parent.find('.filt--item').css('display', 'none');

				if( filter == '*' ) {
					filterClass = '.filt--item';
				}
				$parent.find( filterClass ).css('display', '');
			});

			$content.find('.ffb-modal__tab-content-sections').find('.ffb-filterable-library__filter').click(function(){
				var $parent = $(this).parents('.ffb-filterable-library:first');

				$(this).siblings().removeClass('ffb-filterable-library__filter--active');
				$(this).addClass('ffb-filterable-library__filter--active');

				var filter = $(this).attr('data-filter');

				if( filter == '*' ) {
					filter = '';
				}
				$('.ffb-modal__tab-content-sections').find('.ffb-filterable-library__search').val(filter).trigger('keyup');


				// var filterClass = '.filt--menu--' + filter;



				// $parent.find('.filt--item').css('display', 'none');

				// if( filter == '*' ) {
				// 	filterClass = '.filt--item';
				// }
				// $parent.find( filterClass ).css('display', '');
			});



			$content.find('.ffb-filterable-library__search').on('keyup', function(){
				var value = $(this).val();
				var filterItems = function( search ) {
					search = search.toLowerCase();

					if( search == '') {
						$('.filt--item').css('display', '');
					} else {
						$('.filt--item').each(function(){

							var tags = $(this).attr('data-tags').toLowerCase();

							if( tags.indexOf( search ) == -1 ) {
								$(this).css('display', 'none');
							} else {
								$(this).css('display', '');
							}

						});
					}
				};
				filterItems( value );
			});

			$content.find('.filt-click').click(function(){
				var $li = $(this);

				if( $li.attr('data-type') == 'element' ) {
					self._renderAddElement_elementSelected( $li );
				} else if( $li.attr('data-type') == 'section' ) {
					self._renderAddElement_sectionSelected( $li );
				}

			});

			return $content;

		},

		_renderElementPicker: function() {
			var $content = this._renderAddElement_getBasicHtml();

			$content.find('.ffb-filterable-library__filters').html( this._renderAddElement_renderMenuItems() );
			$content.find('.ffb-filterable-library__content').html( this._renderAddElement_renderContentItems() );

			return $content;
		},

		_renderSectionPicker_renderMenuItems: function() {
			var menuItems = [];
			menuItems.push({id:'*', name:'All'});
			menuItems.push({id:'divider1', name:'<div class="ffb-filterable-library__filters-divider"></div>'});
			menuItems.push({id:'basic', name:'Basic'});
			menuItems.push({id:'divider1', name:'<div class="ffb-filterable-library__filters-divider"></div>'});
			menuItems.push({id:'banner', name:'Banner'});
			menuItems.push({id:'chart', name:'Charts'});
			menuItems.push({id:'process', name:'Process'});
			menuItems.push({id:'testimonial', name:'Testimonials'});
			menuItems.push({id:'about', name:'About'});
			menuItems.push({id:'blog', name:'Blog'});
			menuItems.push({id:'contact', name:'Contact Form'});
			menuItems.push({id:'counter', name:'Counters'});
			menuItems.push({id:'icon', name:'Icons'});
			menuItems.push({id:'map', name:'Map'});
			menuItems.push({id:'portfolio', name:'Portfolio'});
			menuItems.push({id:'pricing', name:'Pricing'});
			menuItems.push({id:'service', name:'Services'});
			menuItems.push({id:'slider', name:'Sliders'});
			menuItems.push({id:'team', name:'Team'});
			// menuItems.push({id:'blog', name:'Blog'});
			// menuItems.push({id:'team', name:'Team'});


			// Banner
			// Charts
			// Process
			// Testimonials
			// About
			// Basic
			// Blog
			// Contact Form
			// Counters
			// Icons
			// Map
			// Portfolio
			// Pricing
			// Services
			// Sliders
			// Team


			var html = '';
			var counter = 0;

			for( var key in menuItems ) {
				var oneMenuItem = menuItems[ key ];
				var cssClasses = '';
				if( counter == 0 ) {
					cssClasses += 'ffb-filterable-library__filter--active';
				}

				if( oneMenuItem.id == '*' ) {
					cssClasses += ' ffb-filter-library__filter-all';
				} else {
					cssClasses += ' ffb-filterable-library__filter-' + oneMenuItem.id;
				}

				html += '<li data-filter="'+ oneMenuItem.id +'" class="ffb-filterable-library__filter '+ cssClasses +'">'+ oneMenuItem.name +'</li>';
				counter++;
			}

			return $(html);
		},

		_renderSectionPicker: function() {

			var $basicHtml = this._renderAddElement_getBasicHtml();


			$basicHtml.find('.ffb-filterable-library__filters').html( this._renderSectionPicker_renderMenuItems() );

			var content = '';
			for( var i in this._sections ) {
				var oneSection = this._sections[ i ];
				// console.log( oneSection );
				content += '<div data-menu-id="basic" data-type="section" data-section-type="' + oneSection.type + '" data-id="'+ oneSection.id +'" class="ffb-flib-item filt-click filt--item filt--buttons filt--menu--basic" data-tags="'+ oneSection.tags +'">';
				content += '<img src="'+ oneSection.image +'">';
				content += oneSection.name;
				content += '</div>';
			}
			$basicHtml.find('.ffb-filterable-library__content').html( content );

			// content += '</ul>';
			// content += '</div>';

			return $basicHtml;

		},

		_renderAddElement_getComplexHtmlWrappers:function() {
			var complexHtmlWrappers = "<div class=\"ffb-modal__tabs\">" +
				"				<div class=\"ffb-modal__tab-headers clearfix\">" +
				"					<div class=\"ffb-modal__tab-header  ffb-modal__tab-header-elements ffb-modal__tab-header--active\" data-id=\"elements\" data-tab-header-name=\"Elements\">Elements</div>" +
				"					<div class=\"ffb-modal__tab-header ffb-modal__tab-header-sections \" data-id=\"sections\" data-tab-header-name=\"Sections\">Sections</div>" +
				"				</div>" +
				"				<div class=\"ffb-modal__tab-contents clearfix\">" +
				"					<div class=\"ffb-modal__tab-content  ffb-modal__tab-content--active ffb-modal__tab-content-elements\" data-id=\"elements\" data-tab-content-name=\"Elements\">" +
				'<div class="ffb-modal__content--options ffb-options"></div>' +
				"					</div>" +
				"					<div class=\"ffb-modal__tab-content ffb-modal__tab-content-sections\" data-id=\"sections\" data-tab-content-name=\"Sections\">" +
				'<div class="ffb-modal__content--options ffb-options">sekce</div>' +
				"					</div>" +
				"				</div>	" +
				"			</div>";

			var $html = $(complexHtmlWrappers);

			$html.find('.ffb-modal__tab-header').click(function(){
				var id = $(this).attr('data-id');

				$html.find('.ffb-modal__tab-content').removeClass('ffb-modal__tab-content--active');
				$html.find('.ffb-modal__tab-content[data-id="' + id + '"]').addClass('ffb-modal__tab-content--active');

				$html.find('.ffb-modal__tab-header').removeClass('ffb-modal__tab-header--active');

				$(this).addClass('ffb-modal__tab-header--active');

			});

			return $html;
		},

		_renderAddElement_getBasicHtml: function () {
			var html = '';

			html += '<div class="ffb-filterable-library clearfix">';
			html += '<ul class="ffb-filterable-library__filters clearfix">';
			html += '</ul>';
			html += '<div class="ffb-filterable-library__top-bar clearfix">';
			html += '<input type="text" class="ffb-filterable-library__search" placeholder="Search..">';
			html += '</div>';
			html += '<div class="ffb-filterable-library__content clearfix">';
			html += '</div>';
			html += '</div>';

			return $(html);
		},

		_renderAddElement_renderContentItems : function() {
			var currentModel = this._currentElementView._model;
			var currentElementId = this._currentElementView.getElementId();
			var allModels = this._currentElementView._elementModels;

			var whitelistedDropzone = ( currentModel.get != undefined ) ? currentModel.get('dropzoneWhitelistedElements') : '';
			var blacklistedDropzone = ( currentModel.get != undefined ) ? currentModel.get('dropzoneBlacklistedElements') : '';

			var html = '';

			for( var key in allModels ) {
				var model = allModels[ key ];
				var modelId = model.get('id');

				var whitelistedParent = model.get('parentWhitelistedElement');

				if( whitelistedParent.length > 0 && whitelistedParent.indexOf( currentElementId ) == -1 ) {
					continue;
				}

				if( whitelistedDropzone.length >  0 && whitelistedDropzone.indexOf( modelId) == -1 )  {
					continue;
				}

				if( blacklistedDropzone.length >  0 && blacklistedDropzone.indexOf( modelId) != -1 )  {
					continue;
				}

				var menuID = model.get('picker.menuId');
				var tags = model.get('name') + model.get('picker.tags');
				var itemWidth = model.get('picker.itemWidth');


				var previewImage = '<img src="' + model.get('previewImage') + '" />';

				var classes = [];
				classes.push('ffb-flib-item');
				classes.push('filt-click');
				classes.push('filt--item');
				classes.push('filt--' + modelId);
				classes.push('filt--menu--' + menuID );
				classes.push('ffb-flib--width-' + itemWidth);

				html += '<div data-menu-id="'+menuID+'" data-type="element" data-id="'+modelId+'" class="' + classes.join(' ') + '" data-tags="' + tags + '">'+ previewImage+ model.get('name') + '</div>';
			}

			var $html = $(html);

			if( $html.filter('.ffb-flib-item').size() == 1 ) {
				this._renderAddElement_elementSelected( $html.filter('.ffb-flib-item').eq(0) );
			}

			return $html;
		},

		_renderAddElement_renderMenuItems : function() {
			var html = '';
			var counter = 0;
			var menuItems = this._currentElementView._menuItems;

			for( var key in menuItems ) {
				var oneMenuItem = menuItems[ key ];
				var cssClasses = '';
				if( counter == 0 ) {
					cssClasses += 'ffb-filterable-library__filter--active';
				}

				if( oneMenuItem.id == '*' ) {
					cssClasses += ' ffb-filter-library__filter-all';
				} else {
					cssClasses += ' ffb-filterable-library__filter-' + oneMenuItem.id;
				}

				html += '<li data-filter="'+ oneMenuItem.id +'" class="ffb-filterable-library__filter '+ cssClasses +'">'+ oneMenuItem.name +'</li>';
				counter++;
			}

			return $(html);
		},


		_openModal: function() {
			if( this._modalOpened ) {
				return false;
			}

			this._modalOpened = true;
			$.freshfaceScrollLock();
			// $.scrollLock();
			$('html').addClass('ffb-modal-opened');
			this.$el.css('display', 'block');

			// var oldScroll = $(window).scrollTop();
			// $(window).on('scroll', function(e){
			// 	$(window).scrollTop( oldScroll );
			// 	event.preventDefault();
			// 	return false;
			// });
			// this.$el.find('.ffb-modal__content--options').on('scroll', function(e){
			// 	e.stopPropagation();
			// 	console.log( scroll );
			// });
		},

		_setModalContent: function( $content ) {
			this.$el.find('.ffb-modal__body:first').html('');
			this.$el.find('.ffb-modal__body:first').append( $content );
			this._$currentContent = $content;
			$content.trigger('insertedToDOM');
		},

		_setModalTitle: function( title )  {
			this.$el.find('.ffb-modal__name:first').find('span').html( title );
		},

		_setModalPreviewImage: function( previewImageUrl ) {
			this.$el.find('.ffb-modal__header-icon-preview-content img').attr('src', previewImageUrl );
		},

		_closeModal: function() {
			if( this._$currentContent != null ) {
				this._$currentContent.trigger('beforeRemovingFromDOM');
			}
			if( !this._modalOpened ) {
				return false;
			}

			this._modalOpened = false;

			// $.scrollLock();
			$.freshfaceScrollLock();
			$('html').removeClass('ffb-modal-opened');
			this.$el.css('display','none');
			this.$el.find('.ffb-modal__body:first').html('');

			if( this._modalMode == 'edit' ) {
				this._currentElementView.animationHighlight();
			}

		},

		_generateElementHtml: function() {

			var saveDefaultData = '';
			if( ff_fw_developer_mode == true ) {
				saveDefaultData =  '<div class="ff-save-default-data"> SAVE DEFAULT</div>';
			}

			var modal = "<div class=\"ffb-modal ffb-modal-origin\">" +
				"            <div class=\"ffb-modal__vcenter-wrapper\">" +
				"                <div class=\"ffb-modal__vcenter ffb-modal__action-cancel\">" +
				"                    <div class=\"ffb-modal__box\">" +
				"                        <div class=\"ffb-modal__header\">" +
				"                            <div class=\"ffb-modal__name clearfix\">" +
				"                                <span>TITLE</span>" + '<div class="ff-global-style-select" data-ffb-tooltip="Global Style">Default</div>' + saveDefaultData +
				"                                <a href=\"\" class=\"ffb-modal__header-icon ffb-modal__header-icon-close ffb-modal__action-cancel ff-font-simple-line-icons icon-close\"></a>" +
				"                            </div>" +
				"                        </div>" +
				"                        <div class=\"ffb-modal__body\">" +
				"                            <div class=\"ffb-modal__tabs\">" +
				"                                <div class=\"ffb-modal__tab-headers clearfix\"></div>" +
				"                                <div class=\"ffb-modal__tab-contents clearfix\">" +
				"                                    <div class=\"ffb-modal__tab-header\" data-tab-header-name=\"General\">TAB HEADER</div>" +
				"                                    <div class=\"ffb-modal__tab-content\" data-tab-content-name=\"General\">" +
				"                                        <div class=\"ffb-modal__content--options ffb-options\">TAB CONTENT</div>" +
				"                                    </div>" +
				"                                    <div class=\"ffb-modal__tab-header\" data-tab-header-name=\"Advanced\">TAB HEADER</div>" +
				"                                    <div class=\"ffb-modal__tab-content\" data-tab-content-name=\"Advanced\">" +
				"                                        <div class=\"ffb-modal__content--options ffb-options\">TAB CONTENT</div>" +
				"                                    </div>" +
				"                                </div>" +
				"                            </div>" +
				"                        </div>" +
				"                        <div class=\"ffb-modal__footer\">" +
				"                            <a class=\"ffb-modal__button-image_preview\"><i class=\"ff-font-simple-line-icons icon-eye\"></i><div class=\"ffb-modal__header-icon-preview-content\"><img src=\"\"></div></a>" +
				"	                        <a href=\"#\" class=\"ffb-modal__button-save_all ffb-modal__action-save-all\">Quick Save</a>" +
				"                            <a href=\"#\" class=\"ffb-modal__button-save ffb-modal__action-save\">Save Changes</a>" +
				"                            <a href=\"#\" class=\"ffb-modal__button-cancel ffb-modal__action-cancel\">Cancel</a>" +
				"                        </div>" +
				"                    </div>" +
				"                </div>" +
				"            </div>" +
				"        </div>";
			return modal;
		},
	});

})(jQuery);


















