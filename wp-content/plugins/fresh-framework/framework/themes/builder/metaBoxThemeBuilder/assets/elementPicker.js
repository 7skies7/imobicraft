// (function($){
//     if( window.ffbuilder == undefined ) {
//         window.ffbuilder = {};
//     }
// /**********************************************************************************************************************/
// /* Element Picker View
// /**********************************************************************************************************************/
//     window.ffbuilder.ElementPickerView = Backbone.View.extend({

//         /*
//             How it looks like:
//             <div class="ffb-filterable-library clearfix">
//                 <ul class="ffb-filterable-library__filters clearfix">
//                     <li class="ffb-filterable-library__filter--all">aaaaa</li>
//                 </ul>
//                 <ul class="ffb-filterable-library__content clearfix">
//                     <li class="filt--video">aaaaa</li>
//                 </ul>
//             </div>
//         */

//         callback_ItemSelected: null,
//         /**
//          * Array containing all registered elements models (which contains all important data)
//          */
//         elementModels : null,

// 		currentElementModel: null,

// 		currentElementId: null,

//         /**
//          * Array containing all section picker elements menu's
//          */
//         menuItems: null,

//         bindActions: function() {
//             var self = this;
//             $(document).on('click', '.filt-click', function(){
//                 if( self.callback_ItemSelected != null ) {
//                     self.callback_ItemSelected( $(this));
//                 }
//             });
//         },

//         initialize: function( options ) {
//             this.bindActions();
//             this.vent = options.vent;
//             this.elementModels = options.elementModels;
//             this.menuItems = options.menuItems;
//         },



//         _getBasicHtml: function() {
//             var html = '';

//             html += '<div class="ffb-filterable-library clearfix">';

//                 html += '<ul class="ffb-filterable-library__filters clearfix">';

//                 html += '</ul>';
//                 html += '<div class="ffb-filterable-library__top-bar clearfix">';
// 					html += '<input type="text" class="ffb-filterable-library__search" placeholder="Search..">';
//                 html += '</div>';
//                 html += '<ul class="ffb-filterable-library__content clearfix">';

//                 html += '</ul>';
//             html += '</div>';



//             return $(html);
//         },


//         renderAddFormHtml: function( elementView ) {
// 			var elementId = elementView.getElementId();
// 			console.log( elementId );
// 			this.currentElementId = elementId;
// 			this.currentElementModel = this.elementModels[ elementId ];

//             var self = this;
//             var $html = this._getBasicHtml();

//             $html.find('.ffb-filterable-library__filters').html( this.renderMenuItems() );
//             $html.find('.ffb-filterable-library__content').html( this.renderContentItems() );

// 			// hide all menus except for all
// 			$html.find('.ffb-filterable-library__filters').children('li').css('display', 'none');
// 			$html.find('.ffb-filterable-library__filters').find('.ffb-filterable-library__filter-all').css('display', 'block');

// 			// show only the used menu
// 			$html.find('.ffb-filterable-library__content').children('li').each(function(){
// 				var menuId = $(this).attr('data-menu-id');
// 				var menuSelector = '.ffb-filterable-library__filter-' + menuId;
// 				$html.find( menuSelector ).css('display', 'block');
// 			});


// 			$html.find('.ffb-filterable-library__filter').click(function(){
// 				var $parent = $(this).parents('.ffb-filterable-library:first');


// 				$(this).siblings().removeClass('ffb-filterable-library__filter--active');
// 				$(this).addClass('ffb-filterable-library__filter--active');

// 				var filter = $(this).attr('data-filter');
// 				var filterClass = '.filt--menu--' + filter;

// 				$parent.find('.filt--item').css('display', 'none');

// 				if( filter == '*' ) {
// 					filterClass = '.filt--item';
// 				}
// 				$parent.find( filterClass ).css('display', 'block');




// 			});

// 			var self= this;

// 			$(document).on('keyup', '.ffb-filterable-library__search', function(){
// 				var value = $(this).val();
// 				self.filterItems( value );
// 			});


// 			// $html.find('.ffb-filterable-library__search').on('change', function(){
// 			//
// 			// 	console.log('change');
// 			//
// 			// });


//             return $html;
//         },

// 		filterItems: function( search ) {

// 			search = search.toLowerCase();

// 			if( search == '') {
// 				$('.filt--item').css('display', 'block');
// 			} else {
// 				$('.filt--item').each(function(){

// 					var tags = $(this).attr('data-tags').toLowerCase();

// 					if( tags.indexOf( search ) == -1 ) {
// 						$(this).css('display', 'none');
// 					} else {
// 						$(this).css('display', 'block');
// 					}

// 				});
// 			}
// 		},

//         renderMenuItems: function() {
//             var html = '';

// 			var counter = 0;
//             for( var key in this.menuItems ) {
//                 var item = this.menuItems[ key ];
// 				var classes = '';
// 				if( counter == 0 ) {
// 					classes += 'ffb-filterable-library__filter--active';
// 				}

// 				if( item.id == '*' ) {
// 					classes += ' ffb-filterable-library__filter-all';
// 				} else {
// 					classes += ' ffb-filterable-library__filter-' + item.id;
// 				}

//                 html += '<li data-filter="'+ item.id +'" class="ffb-filterable-library__filter '+ classes +'">'+ item.name +'</li>';
// 				counter++;
//             }

//             return $(html);
//         },

//         renderContentItems: function() {

// 			var whitelistedDropzone =  '';
// 			var blacklistedDropzone = '' ;

// 			if( this.currentElementModel != undefined ) {
// 				whitelistedDropzone = this.currentElementModel.get('dropzoneWhitelistedElements');
// 				blacklistedDropzone = this.currentElementModel.get('dropzoneBlacklistedElements');
// 			}





// 			var html = '';

//             for( var key in this.elementModels ) {
//                 var model = this.elementModels[ key ];
// 				var modelId = model.get('id');

// 				var whitelistedParent = model.get('parentWhitelistedElement');

// 				if( whitelistedParent.length > 0 && whitelistedParent.indexOf( this.currentElementId ) == -1 ) {
// 					continue;
// 				}

// 				if( whitelistedDropzone.length >  0 && whitelistedDropzone.indexOf( modelId) == -1 )  {
// 					continue;
// 				}

// 				if( blacklistedDropzone.length >  0 && blacklistedDropzone.indexOf( modelId) != -1 )  {
// 					continue;
// 				}




// 				var menuID = model.get('picker.menuId');
// 				var tags = model.get('name') + model.get('picker.tags');

//                 var previewImage = '<img src="' + model.get('previewImage') + '" />';

// 				var classes = new Array();
// 				classes.push('filt-click');
// 				classes.push('filt--item');
// 				classes.push('filt--' + modelId);
// 				classes.push('filt--menu--' + menuID );

//                 html += '<li data-menu-id="'+menuID+'" data-id="'+modelId+'" class="' + classes.join(' ') + '" data-tags="' + tags + '">'+ previewImage+ model.get('name') + '</li>';
//             }

//             var $html = $(html);


// 			if( $html.filter('li').size() == 1 ) {
// 				this.callback_ItemSelected( $html.filter('li').eq(0) );
// 				// alert(' nur eins' );
// 			}



//             return $html;
//         },

//     });

// })(jQuery);