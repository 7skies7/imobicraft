(function($){
	frslib.provide('frslib.options2');

	$(document).ready(function(){
		$('body').on('mousemove', function(e){
			frslib.options2.modalLastMouseEvent = e;
		});
	});


	$(document).ready(function(){
		$(document).on('keydown', null, 'space return', function(){

			console.log ('space pull');

            //if( '.ff-advanced-select-modal__action-save')

            if( $('.ff-advanced-select-modal__action-save').size() > 0 ) {
                $('.ff-advanced-select-modal__action-save:last').trigger('click');

                return false;
            }

			if( $('.fftm__option-type--color-picker__btn-save').size() > 0 ) {
				$('.fftm__option-type--color-picker__btn-save:last').trigger('click');

				return false;
			}



			if( $('.ff-modal-confirm-box, .ff-modal-confirm-wrapper').size() > 0 ) {
				$('.ff-modal-confirm-ok:last').trigger('click');
				return false;
			}


		});

		$(document).on('keydown', '.ffb-filterable-library__search', 'esc', function(){
			$('.ffb-modal__action-cancel').trigger('click');
		});

		$(document).on('keydown', '.sp-input', 'esc', function() {
			$('.fftm__option-type--color-picker__btn-cancel').trigger('click');
		});

		$(document).on('keydown', '.sp-input', 'space return', function() {
			$('.fftm__option-type--color-picker__btn-save').trigger('click');
			return false;
		});

		$(document).on('keydown', null, 'esc q', function(){

            if( $('.ff-advanced-select-modal__action-cancel').size() > 0 ) {
                $('.ff-advanced-select-modal__action-cancel:last').trigger('click');

                return false;
            }

			if( $('.fftm__option-type--color-picker__btn-cancel').size() > 0 ) {
				$('.fftm__option-type--color-picker__btn-cancel:last').trigger('click');

				return false;
			}

			if( $('.ff-modal-confirm-box').size() > 0 ) {
				$('.ff-modal-confirm-cancel:last').trigger('click');
				return false;
			} else if ( $('html').hasClass('ffb-modal-opened') ) {
				var $openedSubModal =  $('.ffb-modal-sub-opened');

				if ( $('.ffb-global-options-temporary-holder').size() > 0 ) {
					$('.ffb-action-cancel-global:first').trigger('click');
				}
			 	else if( $openedSubModal.size() != 0 ) {
					$openedSubModal.find('.ffb-modal__action-done:first').trigger('click');
				}
				else {
					$('.ffb-modal__action-cancel:first').trigger('click');
				}

				return false;
			}

		});
	});

	/**
	 * Printing our options
	 */
	frslib.options2.modal = Backbone.View.extend({

		_elementHasBeenGenerated: false,

		$content : null,

		_options: {},

		_numberOfMenuLevels: null,

		_closeCallback: null,

		initialize: function() {
			this._numberOfMenuLevels = 0;

			this._initOptions();
		},

		getContent: function() {
			return this.$el;
		},

		_initOptions: function() {
			this._options = {
				cursor: {
					gapLeft: 5,
					gapTop: 5,
				},

				padding: {
					top: 30,
					left: 30,
				},
				itemWidth: 75,
				overlayClosesPopup: true,
				overlayClasses: [],
				contentClasses: [],
			};
		},

		printContent: function( content, closeCallback, options ) {
			var settings = $.extend({
				overlay: true,
			}, options );

			this._generateElement();



			this._setContent( content );
			this._calculatePosition();
			this._closeCallback = closeCallback;

			if( settings.overlay == false ) {
				this.$el.filter('.fftip-overlay').remove();
			}

			return this.$el;
		},

		printInputBox:function( settings, callback ) {
			var confirmText = settings.confirmText;
			var inputText = settings.inputText;

			var self = this;
			var html = '';

			html += '<div class="ff-modal-confirm-wrapper">';

				html += '<div class="ff-modal-confirm-text">';
					html += confirmText;
				html += '</div>';
				html += '<div class="ff-modal-input-text">';
					html += '<input type="text" class="ff-text-input">';
				html += '</div>';

				html += '<div class="ff-modal-confirm-buttons">';
					html += '<div data-type="ok" class="ff-modal-button ff-modal-confirm-ok">Save</div>';
					html += '<div data-type="cancel" class="ff-modal-button ff-modal-confirm-cancel">Cancel</div>';
				html += '</div>';

			html += '</div>';

			this._options.overlayClasses.push('fftip-overlay-background');
			this._options.overlayClosesPopup = false;

			var $html = $(html);

			var $input =$html.find('.ff-text-input');
			$input.val( inputText );

			$input.on('input change paste keyup mouseup', function( e) {
				e.stopPropagation();
			});


			$html.find('.ff-modal-button').click(function(){
				var callbackReturnValue = true;
				if( $(this).attr('data-type') == 'ok' ) {
					callbackReturnValue = callback( $input.val() );
				} else {
					callbackReturnValue = callback (false);
				}
				if( callbackReturnValue != false ) {
					self.close();
				}
			});

			this.printContent( $html );

			$input.focus();
			$input.select();
		},

		printConfirmBox: function( confirmText, callback ){
			var self = this;
			var html = '';

			html += '<div class="ff-modal-confirm-wrapper ff-modal-confirm-box">';

				html += '<div class="ff-modal-confirm-text">';
					html += confirmText;
				html += '</div>';
				html += '<div class="ff-modal-confirm-buttons">';
					html += '<div data-type="ok" class="ff-modal-button ff-modal-confirm-ok">Yes</div>';
					html += '<div data-type="cancel" class="ff-modal-button ff-modal-confirm-cancel">Cancel</div>';
				html += '</div>';

			html += '</div>';

			this._options.overlayClasses.push('fftip-overlay-background');
			this._options.overlayClosesPopup = false;

			var $html = $(html);

			$html.find('.ff-modal-button').click(function(){
				if( $(this).attr('data-type') == 'ok' ) {
					callback( true );
				} else {
					callback (false);
				}
				self.close();
			});

			this.printContent( $html );


		},

		printAlertBox: function( confirmText, callback ){
			
			var self = this;
			var html = '';

			html += '<div class="ff-modal-confirm-wrapper">';

				html += '<div class="ff-modal-confirm-text">';
					html += confirmText;
				html += '</div>';
				html += '<div class="ff-modal-confirm-buttons">';
					html += '<div data-type="ok" class="ff-modal-button ff-modal-confirm-ok">OK</div>';
					// html += '<div data-type="cancel" class="ff-modal-button ff-modal-confirm-cancel">Cancel</div>';
				html += '</div>';

			html += '</div>';

			this._options.overlayClasses.push('fftip-overlay-background');
			this._options.overlayClosesPopup = false;

			var $html = $(html);

			$html.find('.ff-modal-button').click(function(){
				if( callback != undefined ) {
					callback( true) ;
				}
				// if( $(this).attr('data-type') == 'ok' ) {
				// 	callback( true );
				// } else {
				// 	callback (false);
				// }
				self.close();
			});

			this.printContent( $html );
		},

		setCloseOverlayCallback: function( callback ) {
			this._closeOverlayCallback = callback;
		},

		_printMenuHtml : function( menu, depth ) {
			if( depth == undefined ) {
				depth = 0;
			}

			depth ++;

			if( this._numberOfMenuLevels < depth ) {
				this._numberOfMenuLevels = depth;
			}

			var wrapperClass = '';
			if( depth > 1 ) {
				wrapperClass = 'ff-modal-menu-wrapper__submenu clearfix';
			} else {

			}

			var html = '';
			html += '<div class="ff-modal-menu-wrapper ' + wrapperClass + '">';
			for( var i in menu ) {
				var oneMenuItem = menu[ i ];
				var itemClass = ''

				if( oneMenuItem.childs != undefined ) {
					itemClass = 'ff-modal-menu-item__has-submenu';
				}


				html += '<div class="ff-modal-menu-item ' + itemClass + ' ' + oneMenuItem.extraClasses + ' " data-value="' + oneMenuItem.value + '">';
					html += '<div class="ff-modal-menu-item-inner">';

						// if( oneMenuItem.active == true ) {
						// 	html += '<strong>';
						// }

							html += oneMenuItem.name;

						// if( oneMenuItem.active == true ) {
						// 	html += '</strong>';
						// }
					html += '</div>';
					if( oneMenuItem.childs != undefined ) {
						html += this._printMenuHtml( oneMenuItem.childs, depth );
					}
				html += '</div>';

			}
			html += '</div>';
			return html;
		},

		printMenu: function( menu, callback ) {
			var html = this._printMenuHtml( menu );

			var $html = $(html);
			var self = this;

			this.printContent( $html );

			$html.find('.ff-modal-menu-item').click(function(){
				if( $(this).hasClass('ff-modal-menu-item__has-submenu') ) {
					return;
				}
				var value = $(this).attr('data-value');
				self.close();

				callback( value );
			});
			$html.on('contextmenu', function(){
				return false;
			});

			$('.fftip-overlay').on('contextmenu', function(){
				return false;
			});

		},


		_calculatePosition: function() {
			var mouseEvent = frslib.options2.modalLastMouseEvent;

			var mouseX = mouseEvent.clientX + this._options.cursor.gapLeft;
			var mouseY = mouseEvent.clientY + this._options.cursor.gapTop;

			var contentWidth = this.$content.outerWidth();
			var contentHeight = this.$content.outerHeight();

			var viewportWidth = $(window).innerWidth();
			var viewportHeight = $(window).innerHeight();

			var left = mouseX;
			var top = mouseY;


			if( (mouseY + contentHeight + this._options.padding.top) > viewportHeight ) {
				var difference =  (mouseY + contentHeight + this._options.padding.top) - viewportHeight;
				top = top - difference;
			}

			if( (mouseX + contentWidth + this._options.padding.left) > viewportWidth ) {
				left = mouseX - (this._options.cursor.gapLeft * 2) - contentWidth;
				this.$content.find('.ff-modal-menu-wrapper .ff-modal-menu-wrapper__submenu').css('left', 'auto').css('right','100%');
			}


			this.$content.css('top', top );
			this.$content.css('left', left );
		},

		_setContent: function( $content ) {
			this.$content.append( $content );
		},

		_generateElement: function() {
			if( this._elementHasBeenGenerated ) {
				return;
			}
			var self = this;
			var html = '';
			html += '<div class="fftip-overlay ' + this._options.overlayClasses.join(' ') + '"></div>';
			html += '<div class="fftip-content ' + this._options.contentClasses.join(' ') + '"></div>';

			this.$el = $(html);

			$('body').append( this.$el );

			this.$el.filter('.fftip-overlay').click(function(){
				if( self._options.overlayClosesPopup == false ) {
					return false;
				}

				self.close();

				if( self._closeOverlayCallback != null ) {
					self._closeOverlayCallback();
				}
			});

			this.$content = this.$el.filter('.fftip-content');

			// $('body').on('mousemove', this.catchMouseMove);
		},

		catchMouseMove: function( e ) {
			console.log( e );
		},

		close: function() {
			if( this._closeCallback != null && this._closeCallback != undefined ) {
				this._closeCallback( this.$el );
			}
			this.$el.remove();
		}

	});


    $.freshfaceContextMenu = function( options, callback) {
        var settings = $.extend({
            menuItems: {},
        }, options );

        var modal = new frslib.options2.modal();
        var menuItems = {};

        if (typeof settings.menuItems == 'function') {
            menuItems = settings.menuItems();
        } else {
            menuItems = settings.menuItems;
        }

        modal.printMenu(menuItems, function (result) {
            callback(result);
        });
    };

	$.fn.freshfaceContextMenu = function( options , callback ) {
		var settings = $.extend({
			openAction:'click',
			menuItems: {},
		}, options );

		var $elementCollection = this;

        if( settings.openAction == 'now' ) {

            var $element = $(this);
            var modal = new frslib.options2.modal();
            var menuItems = {};

            if (typeof settings.menuItems == 'function') {
                menuItems = settings.menuItems($element);
            } else {
                menuItems = settings.menuItems;
            }

            modal.printMenu(menuItems, function (result) {
                callback(result, $element);
            });

        } else {


            $elementCollection.on(settings.openAction, function (e) {
                var $element = $(this);
                var modal = new frslib.options2.modal();
                var menuItems = {};

                if (typeof settings.menuItems == 'function') {
                    menuItems = settings.menuItems($element);
                } else {
                    menuItems = settings.menuItems;
                }

                modal.printMenu(menuItems, function (result) {
                    callback(result, $element);
                });
                return false;
            });

        }
	};

	$.fn.freshfaceTooltip = function( ) {
		var $elementCollection = this;

		$elementCollection.on('mouseenter', function(e){

			var $source = $(this);

			var content = $(this).attr('data-ffb-tooltip');
			content = '<div class="ffb-tooltip">' + content + '</div>';
			var modal = new frslib.options2.modal();
			var $content = modal.printContent(content, undefined, {overlay:false}).filter('.fftip-content');

			// $content.css('opacity',0).delay(500).animate({opacity:1}, 300);

			$(this).data('ffmodal', modal );

			$elementCollection.on('mousemove', function(e){

				var sourceTop = $source[0].getBoundingClientRect().top;
				var sourceLeft = $source[0].getBoundingClientRect().left;

				$content.css('top', sourceTop );
				$content.css('left', sourceLeft + $source.outerWidth()/2 - $content.outerWidth()/2 );
			});

		});

		$elementCollection.on('mouseleave', function(e){
			var modal = $(this).data('ffmodal');

			if( modal != undefined ) {
				modal.close();
			}
		});
	};

	$.fn.freshfaceInputBox = function( options, callback ) {
		// var settings = $.extend({
		// 	openAction:'click'
		// }, options);
	};

	$.freshfaceInputBox = function( options, callback ) {
		var settings = $.extend({
			confirmText:'Confirm',
			inputText : '',
		}, options);

		var modal = new frslib.options2.modal();
		modal.printInputBox( settings, callback );
	};

	$.freshfaceConfirmBox = function (text, callback ) {
		var modal = new frslib.options2.modal();
		modal.printConfirmBox( text, callback );
	};

	$.freshfaceAlertBox = function( text, callback ) {
		var modal = new frslib.options2.modal();
		modal.printAlertBox( text, callback );
	};

	$.freshfaceBox = function( $content, closeCallback ) {
		var modal = new frslib.options2.modal();
		modal.printContent( $content, closeCallback );

		return modal;
	};

	$.freshfaceScrollLockData = {};
	$.freshfaceScrollLockData.status = false;
	$.freshfaceScrollLockData.hasBeenInited = false;
	$.freshfaceScrollLockData.position = null;
	$.freshfaceScrollLock = function( params ) {

		if( $.freshfaceScrollLockData.status == false ) {
			$.freshfaceScrollLockData.status = true;
			$.freshfaceScrollLockData.position = $(window).scrollTop();
		} else {
			$.freshfaceScrollLockData.status = false;
			$.freshfaceScrollLockData.position = null;
		}

		if( $.freshfaceScrollLockData.hasBeenInited == false ) {
			$(window).on('scroll', function(){
				if( $.freshfaceScrollLockData.status == true ) {
					$(window).scrollTop( $.freshfaceScrollLockData.position );
				}
			});
		}

		// console.log( 'aa');
		// console.log( $.freshfaceScrollLock.hasBeenInited );

		// if( $.freshfaceScrollLock.status == false );
	};

	$.freshfaceWait = function( options ) {
		var settings = $.extend({
			action: 'activate'
		}, options);

		if( settings.action == 'activate' ) {
			$('body').addClass('ffb-waiting-cursor');
		}

		else if( settings.action == 'deactivate' ) {
			$('body').removeClass('ffb-waiting-cursor');
		}
	};

	$.fn.freshfaceForceOverlay = function( options, callback ) {
		var $this = this;
		var offset = $this.offset();
		var $overlayCollection = $();

		var closeOverlay = function( $collectionToClose ){
			if( $collectionToClose == undefined ) {
				$collectionToClose = $overlayCollection;
			}

			var canWeClose = true;

			if( callback != undefined ) {
				canWeClose = callback();
			}

			if( $this.data('overlay-callback') != undefined ) {
				canWeClose = $this.data('overlay-callback').call();
			}


			if( canWeClose ){
				$collectionToClose.animate({opacity:0}, 500, function () {
					$(this).remove();
					$this.data('overlay-collection', null);
					$this.data('overlay-callback', null);

				});
			}
		};

		var settings = $.extend({
			topLeftPoint: null,
			bottomRightPoint: null,
		}, options);

		if( settings.action == 'close' ) {

			$overlayCollection = $this.data('overlay-collection');
			$overlayCollection.animate({opacity:0}, 300, function () {
				$(this).remove();
				$this.data('overlay-collection', null);
				$this.data('overlay-callback', null);
			});

			return;
		} else if( settings.action == 'close-with-callback' ) {
			closeOverlay( $this.data('overlay-collection') );
			return;
		}

		var win = $(window);

		if( settings.topLeftPoint == null ) {
			settings.topLeftPoint = {}
			settings.topLeftPoint.x = offset.left;
			settings.topLeftPoint.y = offset.top;
		} else if( settings.topLeftPoint instanceof jQuery ) {
			var newOffset = settings.topLeftPoint.offset();
			settings.topLeftPoint = {}
			settings.topLeftPoint.x = newOffset.left;
			settings.topLeftPoint.y = newOffset.top;
		}

		if( settings.bottomRightPoint == null ) {
			settings.bottomRightPoint = {}
			settings.bottomRightPoint.x = settings.topLeftPoint.x + $this.outerWidth();
			settings.bottomRightPoint.y = settings.topLeftPoint.y + $this.outerHeight();
		} else if( settings.bottomRightPoint instanceof jQuery ) {
			var newOffset = settings.bottomRightPoint.offset();
			var outerWidth = settings.bottomRightPoint.outerWidth();
			var outerHeight = settings.bottomRightPoint.outerHeight();

			settings.bottomRightPoint = {}
			settings.bottomRightPoint.x = newOffset.left + outerWidth;
			settings.bottomRightPoint.y = newOffset.top + outerHeight;
		}

		var doc = {};
		doc.width = $(document).width();
		doc.height = $(document).height();
		var topLeftPoint = settings.topLeftPoint;
		var bottomRightPoint = settings.bottomRightPoint;


		var $topDiv = $('<div></div>');
		$topDiv.css({
			'position': 'absolute',
			'top': '0px',
			'left': topLeftPoint.x,
			'width': ( bottomRightPoint.x - topLeftPoint.x ),
			'height': topLeftPoint.y,
			// 'background-color': 'black',
			// 'z-index':9999999999
		});

		var $rightDiv = $('<div></div>');
		$rightDiv.css({
			'position': 'absolute',
			'top': '0px',
			'left': bottomRightPoint.x,
			'width': doc.width - bottomRightPoint.x,
			'height': doc.height,
			// 'background-color': 'black',
			// 'z-index':9999999999
		});

		var $bottomDiv = $('<div></div>');
		$bottomDiv.css({
			'position': 'absolute',
			'top': bottomRightPoint.y,
			'left': topLeftPoint.x,
			'width': ( bottomRightPoint.x - topLeftPoint.x ),
			'height': doc.height - bottomRightPoint.y,
			// 'background-color': 'black',
			// 'z-index':9999999999
		});

		var $leftDiv = $('<div></div>');
		$leftDiv.css({
			'position': 'absolute',
			'top': '0px',
			'left': '0px',
			'width': topLeftPoint.x,
			'height': doc.height,
			// 'background-color': 'black',
			// 'z-index':9999999999
		});




		// var $overlayCollection = $();
		$overlayCollection = $overlayCollection.add($topDiv);
		$overlayCollection = $overlayCollection.add($rightDiv);
		$overlayCollection = $overlayCollection.add($bottomDiv);
		$overlayCollection = $overlayCollection.add($leftDiv);

		$overlayCollection.addClass('ffb-forced-overlay');

		$overlayCollection.css('opacity',0);
		// $overlayCollection
		$('body').append( $overlayCollection );

		$overlayCollection.animate({opacity:0.5}, 300);

		$this.data('overlay-collection', $overlayCollection );
		$this.data('overlay-callback', callback);

		$overlayCollection.on('click', function(){
			closeOverlay();
		});

	};

})(jQuery);
