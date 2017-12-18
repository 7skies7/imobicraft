(function($){

	$(document).ready(function(){
		var settings = JSON.parse( $('.ff-collection-settings').attr('data-settings') );
		var specification = {
			adminScreenName : 'SitePreferences',
			adminViewName: 'Default',
			settings : settings,
			// action: 'saveOptions',
		};

		$('.ff-items-wrapper').perfectScrollbar();


		$(document).on('click','.ff-save-ajax', function(){
			// alert('aaa');
			$('.ffb-save-ajax').trigger('click');


		});

		$('.ff-current-template-name').freshfaceTooltip();

		$('.ffb-save-ajax').click(function(){
			frslib.options2.dataManager.saveColorLibrary();
			setTimeout( function(){
				$('.ff-options-2-holder').trigger('ff-get-form-data', function( data ){

					// '', array('adminScreenName'=>'SitePreferences', 'adminViewName'=>'Default')
					// var specification = {
					// 	adminScreenName : 'SitePreferences',
					// 	adminViewName: 'Default',
					// };
					frslib.ajax.frameworkRequest( 'ffAdminScreenManager', specification, {action: 'save-options', form: data}, function( response ){
						frslib.messages.broadcast({'command' : 'refresh'});
					});
				});
			}, 10);
		});

		$('body').on('ff-builder-saved-ajax', function(){
			frslib.messages.broadcast({'command' : 'refresh'});
		});

		$('.ff-edit-views').click(function () {
			var boxData = $('.ff-edit-views-content').html();

			var $boxData = $('<div class="ff-modal-select-views-wrapper">' + boxData + '</div>');

			$.freshfaceBox(  $boxData, function( $element){
				var data = $element.find('.ff-modal-select-views-wrapper').html();
				$('.ff-edit-views-content').html( data );

			});

			var bindContextMenu = function( $item ) {
				// $item.find('.ff-one-view-edit-button').css('opacity', 0.3);
				$item.find('.ff-one-view-edit-button').freshfaceContextMenu({menuItems: createContextMenu, openAction: 'contextmenu click'}, contextMenuCallback);
				$item.find('.ff-act-use:not(.ff-act-use-inherited-view)').freshfaceContextMenu({menuItems: createContextMenu, openAction:'contextmenu'}, contextMenuCallback);
				$item.find('.ff-act-use').click(function(){
					assignView( $(this).parents('.ff-one-view') );
				});
			}



			// contextMenu
			// var contextMenu = [];

			// contextMenu.push({name: 'Add', value: 'add'});
			// contextMenu.push({name: 'Select', value: 'assign'});
			// contextMenu.push({name: 'Rename', value: 'rename'});
			// contextMenu.push({name: 'Delete', value: 'delete'});
			//
			var assignView = function( $parent ) {
				if( $parent.hasClass('ff-one-view-active') ) {
					return false;
				}
				var templateName = $parent.find('.ff-name').html();
				var templateId = $parent.attr('data-view-id');
				$.freshfaceConfirmBox('Do you really want to assign <strong>"' +templateName+ '"</strong> Layout to this view?', function( result ){
					if( result == false ) {
						return result;
					}

					frslib.ajax.frameworkRequest( 'ffAdminScreenManager', specification, {action: 'assign-template-to-view', templateId: templateId}, function( response ){
						if( response.status == 1 ) {
							$.freshfaceAlertBox('The selected Layout has been assigned to this view. This page will be refreshed now.', function(){
								window.location.reload();
							});
						}
					//
					});
				});
			};

			// $boxData

			var addNewView = function( $parent ) {
				$.freshfaceInputBox({ confirmText: 'New name', inputText: '' }, function( newName ){
					if( newName == false ) {
						return false;
					}

					frslib.ajax.frameworkRequest( 'ffAdminScreenManager', specification, {action: 'add-view-item', newItemName: newName }, function( response ){
						console.log( response );
						if( response.status == 1 ) {
							var newItemHtml = $parent.outerHtml();
							var $newItem = $(newItemHtml );

							$newItem.attr('data-is-default', 0);
							$newItem.attr('data-is-assigned', 0);
							$newItem.find('.ff-assigned-views').html('Unassigned');
							$newItem.attr('data-view-id', response['new-view-id'] );
							$newItem.find('.ff-name').html( newName );
							$boxData.find('.ff-one-view:last').after( $newItem );

							$newItem.removeClass('ff-one-view-default');
							bindContextMenu( $newItem );
						}
						if( response.status == 0 ) {
							$.freshfaceAlertBox( response.message );
						}

					});
				});
			};

			var contextMenuCallback = function( action, $item ) {
				// console.log( value )
				var $parent = $item.parents('.ff-one-view');
				var name = $parent.find('.ff-name').html();
				var templateID = $parent.attr('data-view-id');
				switch( action ) {
					case 'assign':
						assignView( $parent );
						break;
					case 'add':
						addNewView($parent);
						break;

					case 'rename':


						$.freshfaceInputBox({ confirmText: 'New name', inputText: name }, function( newName ){
							if( newName == false ) {
								return false;
							}

							var viewId = $parent.attr('data-view-id');
							var viewName = $parent.find('.ff-name').html();
							frslib.ajax.frameworkRequest( 'ffAdminScreenManager', specification, {action: 'rename-view-item', newItemName: newName, itemId : viewId }, function( response ){
								if( response.status == 1 ) {
									$parent.find('.ff-name').html( newName);
									$.freshfaceAlertBox('Your item has been renamed');
								}
							});
						});
						break;

					case 'delete':

						if( parseInt($parent.attr('data-is-assigned')) == 1 ) {
							$.freshfaceAlertBox('This item has been assigned, it cannot be deleted');
							return false;
						}

						if( parseInt($parent.attr('data-is-default')) == 1 ) {
							$.freshfaceAlertBox('This is default item, it cannot be deleted');
							return false;
						}

						var viewId = $parent.attr('data-view-id');
						var viewName = $parent.find('.ff-name').html();

						$.freshfaceConfirmBox('Do you really want to delete the <strong>"'+ viewName +'"</strong> Layout?', function( answer){
							if( answer == false ) {
								return;
							}

							frslib.ajax.frameworkRequest( 'ffAdminScreenManager', specification, {action: 'delete-view-item', viewId: viewId }, function( response ){
								if( response.status == 1 ){
									$.freshfaceAlertBox( response.message );
									$parent.remove();
								}
							});
						});
						break;

					case 'duplicate':
						$.freshfaceInputBox({ confirmText: 'Name of the duplicated Layout', inputText: name + ' - Copy' }, function( newName ){
							frslib.ajax.frameworkRequest( 'ffAdminScreenManager', specification, {action: 'duplicate-template', templateId: templateID, newName: newName}, function( response ){
								if( response.status == 1 ) {
									var newItemHtml = $parent.outerHtml();
									var $newItem = $(newItemHtml );

									$newItem.attr('data-is-default', 0);
									$newItem.attr('data-is-assigned', 0);
									$newItem.find('.ff-assigned-views').html('Unassigned');
									$newItem.attr('data-view-id', response['new-view-id'] );
									$newItem.find('.ff-name').html( newName );
									$newItem.removeClass('ff-one-view-default');
									$newItem.removeClass('ff-one-view-active');

									bindContextMenu( $newItem );
									$parent.after( $newItem );
								}
								if( response.status == 0 ) {
									$.freshfaceAlertBox( response.message );
								}
							});
						});

						break;

					case 'reset':
						$.freshfaceConfirmBox('Resetting the <strong>"' +name +'"</strong> Layout will erase your content and settings from this Layout and fills it with native defaults instead.', function( answer){
							if( answer == false)  {
								return false;
							}

							frslib.ajax.frameworkRequest( 'ffAdminScreenManager', specification, {action: 'reset-template', templateId: templateID}, function( response ){
								if( response.status == 1 ) {
									if( $parent.hasClass('ff-one-view-active') ) {
										$.freshfaceAlertBox('The Layout has been successful reset. This page will be refreshed now.', function(){
											window.location.reload();
										});
									} else {
										$.freshfaceAlertBox('The Layout has been successful reset.');
									}
								}

							});
						});
						break;
				}

			};

			var createContextMenu = function ($item) {

				var $parent = $item.parents('.ff-one-view:first');
				// console.log( $item );

				var contextMenu = [];

				// contextMenu.push({name: 'Add', value: 'add'});
				contextMenu.push({name: 'Select', value: 'assign'});
				contextMenu.push({name: 'Duplicate', value: 'duplicate'});

				if( !$parent.hasClass('ff-one-view-default') ) {
					contextMenu.push({name: 'Rename', value: 'rename'});
					contextMenu.push({name: 'Delete', value: 'delete'});
				} else {
					contextMenu.push({name: 'Reset', value: 'reset'});
				}

				return contextMenu;
			};


			bindContextMenu($boxData);

			$boxData.find('.ff-add-new-view').click(function(){
				addNewView( $(this).parent().children('.ff-edit-views-list').children('.ff-one-view:last'));
			});
		});

		$('.ff-one-content-switcher').click(function(){
			if( $(this).hasClass('ff-one-sub-item-active') ) {
				return false;
			}

			var $parent = $(this).parent();

			var type = $(this).attr('data-type');
			var cssClassOfArea = '.ff-collection-' + type;

			$('.ff-collection-content-area').css('display', 'none');
			$( cssClassOfArea ) .css('display', 'block');


			$parent.find('.ff-one-content-switcher').removeClass('ff-one-sub-item-active');
			$(this).addClass('ff-one-sub-item-active');

			return false;

		});

	});

})(jQuery);