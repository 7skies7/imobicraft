(function($){

	$(document).ready(function(){
		//$('#jstree_demo_div').jstree();
		
		var confirm_deleting = 'not_asked';
		
		var newPathInfo = {};
		
		var currentFileOpenedPath = '';
		
		var getDataPath = function( id ) {
			
			var $originalLi = $('#' + id);
			
			var $parents = $originalLi.parents('li[role="treeitem"]');
			
			var path = new Array();
			
			
			$parents.each(function(){
				
				if( $(this).attr('data-is-top') == 'true' ) {
					path.unshift( $(this).attr('data-path'));
				} else {
					path.unshift( $(this).children('a').text() );
				}
				
				//path += $(this).children('a').text();
				
			});
			
			if( $parents.length == 0 ) {
				path = $originalLi.attr('data-path');
			} else {
				path = path.join('/')+ '/' + $originalLi.children('a').text();
			}
			 
			
			
			return path;
			
			
			var parentPath = '';
			
			if( newPathInfo.hasOwnProperty( id ) ) {
				parentPath = newPathInfo[ id ];
			} else {
				parentPath = $('#' + id).attr('data-path');
				newPathInfo[ id ] = parentPath;
			}
			
			return parentPath;
		};
		
		var setDataPath = function( id, path ) {
			newPathInfo[ id ] = path;
		}
		
		var jsTreeRel = $('#jstree_demo_div').jstree({
			'core' : {
				'data' : function (obj, callback) {
					var ajaxData = {};
					ajaxData.path = '';
					if( obj.hasOwnProperty('data') ) {
						ajaxData.path = obj.data.path;
					}
					
					frslib.ajax.adminScreenRequest('action-load-tree', ajaxData, function( response ){
						callback.call(this, response);
					});
					
				},
				
				'check_callback' : function(o, n, p, i, m) {
					if(m && m.dnd && m.pos !== 'i') { return false; }
					if(o === "move_node" || o === "copy_node") {
						if(this.get_node(n).parent === this.get_node(p).id) { return false; }
					}
					
					if( o === 'delete_node' ) {
 
						
						var nodeID = n.id;
						var $node = $('#' + nodeID );
						var path = $node.attr('data-path');
						
						if( confirm_deleting == 'not_asked' ) {
							confirm_deleting = confirm( 'Delete?' );
							setTimeout(function(){ confirm_deleting = 'not_asked';}, 500);
						} 
						
						if ( confirm_deleting == true ) {
							confirm_deleting = 'confirm_deleting';
							return true;
						} else if ( confirm_deleting == false ) {
							confirm_deleting = 'confirm_deleting';
							return false;
						}
						
						
					}
					
					return true;
				},
			},
			'types' : {
				'folder' : { 'icon' : 'dashicons dashicons-category' },
				'file' : { 'valid_children' : [], 'icon' : 'ff-icon-hidden' }
			},

			
			'contextmenu' : {
				'items' : function(node) {
					
					var tmp = $.jstree.defaults.contextmenu.items();
					
					delete tmp.create.action;
					delete tmp.ccp;
					tmp.create.label = "New";
					tmp.create.submenu = {
						"create_file" : {
							"label"				: "File",
							"action"			: function (data) {
								var inst = $.jstree.reference(data.reference),
									obj = inst.get_node(data.reference);
								inst.create_node(obj, { type : "file", text : "NewFile.txt" }, "last", function (new_node) {
									setTimeout(function () { inst.edit(new_node); },0);
								});
							}
						},
						"create_folder" : {
							"separator_after"	: true,
							"label"				: "Folder",
							"action"			: function (data) {
								var inst = $.jstree.reference(data.reference),
									obj = inst.get_node(data.reference);
								inst.create_node(obj, { type : "folder", text : "NewFolder" }, "last", function (new_node) {
									setTimeout(function () { inst.edit(new_node); },0);
								});
							}
						}
					};
					if(this.get_type(node) === "file") {
						delete tmp.create;
					}
					return tmp;
				}
			},

			'plugins': ["wholerow", "contextmenu", "types"]
		}).on('delete_node.jstree', function (e, data) {
			
			var nodeID = data.node.id;
			var $node = $('#' + nodeID );
			var path = getDataPath( nodeID );//$node.attr('data-path');
			
			

		var ajaxData = {};
		ajaxData.path = path;
		ajaxData.type = data.node.type
		
			  
		frslib.ajax.adminScreenRequest('action-delete-file-or-folder', ajaxData, function( response ){
				 
				//console.log( response );
		});
 
			
			
		})
		.on('create_node.jstree', function (e, data) {
			
			// parentPath
			var parentPath = '';
			var newNodeName = data.node.text;
			var newPath = '';
			var currentNodeID = data.node.id;
		
			parentPath = getDataPath( data.parent );
			
			newPath = parentPath + '/' + newNodeName;
			
			//newPathInfo[ currentNodeID ] = newPath;
			setDataPath( currentNodeID, newPath );
			
			 var ajaxData = {};
			  ajaxData.path = newPath;
			  ajaxData.type = data.node.type
			  
				frslib.ajax.adminScreenRequest('action-create-file-or-folder', ajaxData, function( response ){
					 
					//data.instance.refresh();
					
				});			  
			
	
		})
		.on('rename_node.jstree', function (e, data) {
			
			//console.log( data );
			
			
			// parentPath
			var parentPath = '';
			var newNodeName = data.node.text;
			var newPath = '';
			var currentNodeID = data.node.id;
			
			if( newPathInfo.hasOwnProperty( data.node.parent ) ) {
				parentPath = newPathInfo[ data.node.parent ];
			} else {
				parentPath = $('#' + data.node.parent).attr('data-path');
				newPathInfo[ data.node.parent ] = parentPath;
			}
			
			newPath = parentPath + '/' + newNodeName;
			
			//newPathInfo[ currentNodeID ] = newPath;
			setDataPath( currentNodeID, newPath );
			
		

			var ajaxData = {};
			ajaxData.newName = data.text;
			ajaxData.oldName =  data.old;
			ajaxData.path = parentPath;
			
			frslib.ajax.adminScreenRequest('action-rename-file-or-folder', ajaxData, function( response ){
				 //console.log( response );
				
			});
		 
		})
		.on('move_node.jstree', function (e, data) {
			return;
			$.get('?operation=move_node', { 'id' : data.node.id, 'parent' : data.parent })
				.done(function (d) {
					//data.instance.load_node(data.parent);
					data.instance.refresh();
				})
				.fail(function () {
					data.instance.refresh();
				});
		})
		.on('copy_node.jstree', function (e, data) {
			return;
			$.get('?operation=copy_node', { 'id' : data.original.id, 'parent' : data.parent })
				.done(function (d) {
					//data.instance.load_node(data.parent);
					data.instance.refresh();
				})
				.fail(function () {
					data.instance.refresh();
				});
		}).delegate(".jstree-open>a", "click.jstree", function(event){
		   $.jstree.reference(this).close_node(this,false,false);
		}).delegate(".jstree-closed>a", "click.jstree", function(event){
		    $.jstree.reference(this).open_node(this,false,false);
			//console.log( $.jstree )
		}).delegate('.jstree-closed>i', 'click.jstree', function(event){
			//console.log( 'c');
			$(this).parent().children('a').click();
			//$.jstree.reference(this).toggle_node(this,false,false);
		});
		
		
		//rjstree-icon 


		

////////////////////////////////////////////////////////////////////////////////
// JSTREE CLICK AND LOAD TO THE ACE
////////////////////////////////////////////////////////////////////////////////
		var getDirFromParents = function( parents ) {
			for( var key in parents ) {
				console.log( parents[key ] );
			}
		};
		
		var lastMouseButton = 0;
		
		$(document).on('mousedown', '#jstree_demo_div', function( e ){
			lastMouseButton = e.button;
			setTimeout(function(){ lastMouseButton = 0 }, 800);
		});
		
		var currentEditorText = '';
		
		$('#jstree_demo_div').on('changed.jstree', function (e, data) {
			
			
			if( data.action == 'select_node' && lastMouseButton == 0 ) {
				
				var editorId =$('body').find('pre[data-ff-option-type="code"]').attr('id');
				var editor = ace.edit( editorId );
				var $editor = $('#'+editorId);
				
				editor.setFontSize(12);
				
				var newValue = editor.getSession().getValue();
				
				
				if( ( (currentEditorText != newValue) && confirm('Your changes will be lost. Are you sure?') ) || currentEditorText == newValue  ) {
					
				
				
				
				//var path2 = data.node.id
				var path = getDataPath(data.node.id); // $('#'+data.node.id).attr('data-path');
				var type = data.node.text.substr((~-data.node.text.lastIndexOf(".") >>> 0) + 2);//$('#'+data.node.id).attr('data-type');
				
				currentFileOpenedPath = path;
				
				//console.log( data );
				
				if( data.node.type == 'folder' ) {
					type = 'folder';
				}
				
				switch( type ) {
					case 'gif':
					case 'jpeg':
					case 'jpg':
					case 'png':
					case 'tiff':
					case 'bmp':
						
						$('.ff-file-editor-editor-cell').addClass('ff-file-editor-image-preview-cell');
						$('.ff-file-editor-editor-cell-inner').css('display','none');
						$('.ff-file-editor-image-preview').css('display','block');
						$('.ff-file-editor-image-preview').find('img').attr('src', $('#'+data.node.id).attr('data-url')); 
 						$(window).resize();
						break;
						
					case 'folder':
					case 'zip':
							$('.ff-file-editor-editor-cell').removeClass('ff-file-editor-image-preview-cell');
							$('.ff-file-editor-editor-cell-inner').css('display','none');
							$('.ff-file-editor-image-preview').css('display','none');
						break;
						
					default:
						
						$('.ff-file-editor-editor-cell').removeClass('ff-file-editor-image-preview-cell');
						$('.ff-file-editor-editor-cell-inner').css('display','block');
						$('.ff-file-editor-image-preview').css('display','none');
						
						
						var ajaxData = {};
						ajaxData.path = path
						
					
						
			
						
			
						
						var $loaderDiv = $('<div class="ff-file-editor-loading"><div class="spinner"></div></div>');
						$editor.append( $loaderDiv );
						frslib.ajax.adminScreenRequest('action-load-file', ajaxData, function( response ){
							$loaderDiv.remove();
		  
							editor.session.setValue(response, -1);
							
							currentEditorText = response;
							
							if( type == 'js' ) {
								type = 'javascript';
							}
							
							if( type == 'php' || type == 'css' || type == 'javascript' || type =='html') {
								
								editor.getSession().setMode({path:"ace/mode/"+type});
							} else {
								editor.getSession().setMode({path:"ace/mode/txt"});
							}
						 
						});
						
						break;
				}
				
				
				
				}
			}
		});
		

		  
		
		$('.ff-file-editor-save-button').click(function() {
			if( confirm('Save?') ) {
				
				
				var editorId =$('body').find('pre[data-ff-option-type="code"]').attr('id');
				var editor = ace.edit( editorId );
				var $editor = $('#'+editorId);
				
				
				var $loaderDiv = $('<div class="ff-file-editor-loading"><div class="spinner"></div></div>');
				$editor.append( $loaderDiv );
				
				var value = editor.getSession().getValue();
				
				
				var ajaxData = {};
				ajaxData.path = currentFileOpenedPath;
				ajaxData.value = value;
			
				frslib.ajax.adminScreenRequest('action-save-file', ajaxData, function( response ){
					$loaderDiv.remove();				 
				});
			}
		});
		  
		var resizeAce = function() {
			var newHeight = $(window).height() - $('#wpfooter').outerHeight()*2 - $('.ff-file-editor-editor-cell').offset().top - 48;
		
			$('#code-code-code').height( newHeight );
		    $('.ff-file-editor-tree-wrapper').css('max-height', newHeight).css('overflow', 'auto');
 
		    var editorId =$('body').find('pre[data-ff-option-type="code"]').attr('id');
			var editor = ace.edit( editorId );
			editor.resize(true);
		};
	  
		$(window).resize(function(){
			resizeAce();
		});
		resizeAce();
		  
		var resizeImagePreview = function() {
		    $('.ff-file-editor-image-preview img').hide();
			var newHeight = $(window).height() - $('#wpfooter').outerHeight()*2 - $('.ff-file-editor-editor-cell').offset().top - 48;
			var newWidth = $('.ff-file-editor-editor-cell').outerWidth();
		    $('.ff-file-editor-image-preview img').css('display', 'block').css('max-height', newHeight).css('max-width', newWidth);
		};
	  
		$(window).resize(function(){
			resizeImagePreview();
		});
		resizeImagePreview();
	
		$('.ff-file-editor-editor-cell-inner').css('display','none');
		$('.ff-file-editor-image-preview').css('display','none');

	});
})(jQuery);
