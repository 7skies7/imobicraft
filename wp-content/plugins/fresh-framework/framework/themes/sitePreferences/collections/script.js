(function($){

	// alert('aaa');

	$(document).ready(function(){

        $('body').append('<style>.ff-options2 .ffb-builder-toolbar-fixed-wrapper {display: none;}');

		$('.ff-items-wrapper').perfectScrollbar();		

		var settings = JSON.parse( $('.ff-collection-settings').attr('data-settings') );
		var specification = {
			adminScreenName : $('.ff-collection-sidebar-title').html(),
			adminViewName: 'Default',
			settings : settings,
			// action: 'saveOptions',
		};

		var addNewItem = function() {
			$.freshfaceInputBox({ confirmText: 'Name of your new item'}, function( newName ){
				if( newName == false ) {
					return;
				}
				frslib.ajax.frameworkRequest( 'ffAdminScreenManager', specification, {action: 'menu-add-new-item', newItemName: newName }, function( response ){
					console.log( response );

					if( response.status == 0 ) {
						$.freshfaceAlertBox( response.message );
					} else if( response.status == 1 ) {
						document.location = response.url;
					}
				});
			});
		};

		$(document).on('click','.ff-save-ajax', function(){
			if( $('.ffb-builder-loaded').size() == 0 ) {
				$('body').trigger('ff-save-header');
			} else {
				$('.ffb-save-ajax').trigger('click');
			}

			// $('.ffb-save-ajax').trigger('click');


			// alert('sa');
		});


		$('body').on('click', '.ffb-modal__action-save-all', function(e){
			// ffb-main-save-ajax-btn
			e.stopPropagation();
			$('.ffb-main-save-ajax-btn:first').trigger('click');
			// alert('sdsds');

			return false;
		});

		// $('.ffb-save-ajax').click(function(){
		$('body').on('ff-builder-saved-ajax ff-save-header', function(){
			if( $('.ff-has-no-options').size() > 0 ) {
				return false;
			}

			if( $('.ff-collection-content-options-wrapper').find('.ff-has-no-options').size() > 0 ) {
				// console.log(' TEEEEED ');
				frslib.messages.broadcast({'command' : 'refresh'});
			} else {
				// setTimeout(function(){
					$('.ff-options-2-holder').trigger('ff-get-form-data', function( data ){

						if( $('.ffb-builder-loaded').size() == 0 ) {
							frslib.environment.notificationMamanger.addNotification('info', 'Saving ...');
						}

						frslib.ajax.frameworkRequest( 'ffAdminScreenManager', specification, {action: 'saveOptions', form: data}, function( response ){
							console.log( response )
							frslib.messages.broadcast({'command' : 'refresh'});


							if( $('.ffb-builder-loaded').size() == 0 ) {
								frslib.environment.notificationMamanger.addNotification('success', 'Saved & Published');
							}
						});
					});
			}

		});
		//
		$('.ff-collection-sidebar').find('.ff-one-item').freshfaceContextMenu({
			openAction:'contextmenu',
			menuItems: function ( $item ) {
				var items = [];

				items.push({name:'Add New', value:'add-new'});
				items.push({name:'Rename', value:'rename'});

				if( parseInt($item.attr('data-is-default'))  != 1  ) {
					items.push({name:'Delete', value:'delete'});
				} else {
					items.push({name:'Reset', value:'reset'});
				}

                items.push({name:'Duplicate', value:'duplicate'});

				return items;
			}
		}, function( result, $item ){
			var itemName = $item.find('a').html();
			var itemId = $item.attr('data-item-id');

			switch( result ) {
				case 'add-new':
					addNewItem();
					break;
				case 'rename':
					$.freshfaceInputBox({ confirmText: 'New name', inputText: itemName }, function( newName ){
						if( newName == false ) {
							return false;
						}
						frslib.ajax.frameworkRequest( 'ffAdminScreenManager', specification, {action: 'menu-rename-item', newItemName: newName, itemId : itemId }, function( response ){
							// console.log( response );
							if( response.status == 1 ) {
								// window.location = response.new_url;
								$.freshfaceAlertBox('Item "' + itemName + '" has been renamed to "' + newName + '".');
								$item.find('a:first').html( newName );
								// location.reload();
							}
							// if( response.status == 0 ) {
							// 	$.freshfaceAlertBox( response.message );
							// } else if( response.status == 1 ) {
							// 	document.location = response.url;
							// }
						});
					});
					break;

                case 'duplicate':
                    frslib.ajax.frameworkRequest( 'ffAdminScreenManager', specification, {action: 'menu-duplicate-item', itemId : itemId }, function( response ){
                         console.log( response );
                        if( response.status == 1 ) {
                            // window.location = response.new_url;
                            $.freshfaceAlertBox('Item "' + itemName + '" has been duplicated to "' + itemName + ' - DUPLICATED". Window will be reloaded', function(){

                                location.reload();

                            });
                            //$item.find('a:first').html( itemName + ' - DUPLICATED' );
                        }
                        ///location.reload();
                        // if( response.status == 0 ) {
                        // 	$.freshfaceAlertBox( response.message );
                        // } else if( response.status == 1 ) {
                        // 	document.location = response.url;
                        // }
                    });
                    break;
				case 'reset':
					$.freshfaceConfirmBox('Do you really want to reset item "'+itemName+'" ?', function( result ){
						if( result == false ) {
							return;
						}

						var itemIsActive = false;
						if( $item.hasClass('ff-one-item-active') ) {
							itemIsActive = true;
						}

						frslib.ajax.frameworkRequest( 'ffAdminScreenManager', specification, {action: 'menu-reset-item', itemId: itemId}, function( response ){
							console.log( response) ;
							if( response.status == 1  ) {
								if( itemIsActive ) {
									$.freshfaceAlertBox('Item has been reset, your website will be refreshed', function(){
										window.location.reload();
									});
								} else {
									$.freshfaceAlertBox('Item has been reset', function(){

									});
								}

							}
						});

					});
					break;

				case 'delete' :
					$.freshfaceConfirmBox('Do you really want to delete item "'+itemName+'" ?', function( result ){
						if( result == false ) {
							return;
						}

						frslib.ajax.frameworkRequest( 'ffAdminScreenManager', specification, {action: 'menu-delete-item', itemIdToDelete: itemId}, function( response ){
							// console.log( response );
							if( response.status == 1  ) {

								if( response.new_url != undefined ) {
									window.location = response.new_url;
								} else {
									$item.hide(500, function(){
										$item.remove();
									});
								}
								// location.reload();
							}
							// if( response.status == 0 ) {
							// 	$.freshfaceAlertBox( response.message );
							// } else if( response.status == 1 ) {
							// 	document.location = response.url;
							// }
						});
					});
					break;
			}

		});


		$('.ff-toggle-context-menu').click(function(){
			$(this).parents('.ff-one-item').trigger('contextmenu');
		});

		$('.ff-add-new-item').click(function(){
			// alert('sdsd');
			addNewItem();
			return false;
		});

		$('.ff-one-sub-item').click(function(){
			if( $(this).hasClass('ff-one-sub-item-active') ) {
				return false;
			}

			var type = $(this).attr('data-type');
			var cssClassOfArea = '.ff-collection-' + type;

			$('.ff-collection-content-area').css('display', 'none');
			$( cssClassOfArea ) .css('display', 'block');

			$('.ff-one-sub-item').removeClass('ff-one-sub-item-active');
			$(this).addClass('ff-one-sub-item-active');
			
			
			// alert('aa');

			return false;

		});

		$('.ff-collection__action-save-all').click(function(){
			// $('.ff-save-ajax').trigger('click');
			$('.ffb-save-ajax').trigger('click');

			return false;
		});

		// fixed QUICK SAVE button after scrolling

		var $qSaveBtn = $('.ff-collection__button-save-all:first');
		var qSaveBtnInitPos = $qSaveBtn.offset();

		$(window).scroll(function () {
			if ( $(window).scrollTop() > qSaveBtnInitPos.top-62 ) {
				$qSaveBtn.addClass('ff-collection__button-save-all--fixed')
			} else {
				$qSaveBtn.removeClass('ff-collection__button-save-all--fixed')
			}
		});

	});

})(jQuery);