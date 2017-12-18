(function($) {
	frslib.provide('frslib.environment');

	frslib.environment.notificationMamanger = null;

	frslib.environment.environment = Backbone.View.extend({

		_builderApp: null,

		_builderSettings: null,

		_options : null,

		_notificationManager: null,

		initialize: function() {
			this._options = new frslib.options2.options();
			this._notificationManager = new ffbuilder.NotificationManager();
			frslib.environment.notificationMamanger = this._notificationManager;
			this._initializeBuilder();
			this._initOptions();
		},


		_initOptions: function() {
			// if( this._builderApp != null ) {
			// 	return false;
			// }
			// alert('opt');

			this._options.initOptionsWithoutBlocks();

			$(document).ready(function(){

				window.fixedToolbarsRAF = (function(){
					return  window.requestAnimationFrame	||
						window.webkitRequestAnimationFrame 	||
						window.mozRequestAnimationFrame    	||
						window.oRequestAnimationFrame      	||
						window.msRequestAnimationFrame     	||
						function( callback ){
							window.setTimeout(callback, 1000 / 60);
						};
				})();

				$('.ffb-builder-toolbar-fixed-wrapper').each(function(){

					var builderFixedToolbarInitPosCalc;

					var $thisToolbar = $(this);

					builderFixedToolbarInitPosCalc = function(){

						fixedToolbarsRAF(builderFixedToolbarInitPosCalc);

						var $builderFixedToolbar = $thisToolbar.find('.ffb-builder-toolbar-fixed');

						var builderFixedToolbarInitPos = $thisToolbar.offset().top;
						var scrollTop = $(window).scrollTop();
						var wHeight = $(window).height();

						if ( scrollTop+wHeight-99 < builderFixedToolbarInitPos ) {
							$builderFixedToolbar.addClass('ffb-builder-toolbar-fixed--fixed')
						}
						else {
							$builderFixedToolbar.removeClass('ffb-builder-toolbar-fixed--fixed')
						}

					}

					builderFixedToolbarInitPosCalc( $(this) );

				});

			});
		},

		_initializeBuilder: function() {
			var self = this;
			if( $('.ffb-builder').size() == 0 ) {
				return;
			}

			if( $('.ff-builder-post-settings').size() > 0  ) {
				// var settings = JSON.parse($('.ff-builder-post-settings').val()) ;
				this._builderSettings = JSON.parse($('.ff-builder-post-settings').val());

				if( this._builderSettings.usage == 'never' ||  this._builderSettings.usage == 'not' ) {
					this._initializeBuilder_printBuilderButton('classic', function(){self._initializeBuilder_actionShowBuilder()}, function(){self._initializeBuilder_actionHideBuilder()} );
				} else if( this._builderSettings.usage == 'used' ) {
					this._initializeBuilder_printBuilderButton('fresh', function(){self._initializeBuilder_actionShowBuilder()}, function(){self._initializeBuilder_actionHideBuilder()} );
				}
			} else {
				this._createBuilderClass();
				this._builderApp.initializeBuilder();
			}
		},

		_createBuilderClass: function() {
			this._builderApp = new window.ffbuilder.App({ options: this._options, notificationManager: this._notificationManager });
		},

		_setBuilderSettings: function( name, value ) {
			this._builderSettings[ name] = value;

			$('.ff-builder-post-settings').val( JSON.stringify( this._builderSettings ) );
		},

		_initializeBuilder_actionHideBuilder: function() {
			this._setBuilderSettings('usage', 'not');

			$('#FreshBuilder').css('display', 'none');
			$('#postdivrich').css('display', 'block');
			$('#post-preview').css('display', 'block');

			window.tinyMCE.execCommand('wpAutoResizeOff');
			// setTimeout(function(){window.tinyMCE.execCommand('wpAutoResizeOff');}, 1000);
			// setTimeout(function(){window.tinyMCE.execCommand('wpAutoResizeOff');}, 2000);
			// setTimeout(function(){window.tinyMCE.execCommand('wpAutoResizeOff');}, 3000);
		},

		_initializeBuilder_actionShowBuilder: function() {
			window.tinyMCE.execCommand('wpAutoResizeOff');
			// setTimeout(function(){window.tinyMCE.execCommand('wpAutoResizeOff');}, 1000);
			// setTimeout(function(){window.tinyMCE.execCommand('wpAutoResizeOff');}, 2000);
			// setTimeout(function(){window.tinyMCE.execCommand('wpAutoResizeOff');}, 3000);
			this._setBuilderSettings('usage', 'used');

			// function(){
			$('#FreshBuilder').css('display', 'block');
			$('#postdivrich').css('display', 'none');
			$('#post-preview').css('display', 'none');

			if( this._builderApp == null ) {
				// window.ffbuilder.appInstance = new window.ffbuilder.App();
				// window.ffbuilder.appInstance.initializeBuilder();
				// this._builderApp = new window.ffbuilder.App({ options: this._options});
				this._createBuilderClass();
				this._builderApp.initializeBuilder();

			}
			// }
		},

		_initializeBuilder_printBuilderButton: function( activeMode, callbackEnableBuilder, callbackDisableBuilder ) {
			var html = '';

			if( activeMode == undefined ) {
				activeMode = 'classic';
			}

			html += '<div class="edit-with-fresh-builder-btn edit-with-fresh-builder-btn--active-mode-'+activeMode+'" style="opacity: 0;">';
			html += '<span class="edit-with-fresh-builder-btn--mode-label-fresh">Edit in Classic Mode</span>';
			html += '<span class="edit-with-fresh-builder-btn--mode-label-classic">Edit with Fresh Builder</span>';
			html += '</div>';

			var $html = $(html);

			var self = this;
			$html.on('click', function(){

				if( !$(this).hasClass('edit-with-fresh-builder-btn--active-mode-fresh')) {
					callbackEnableBuilder();
				} else {
					callbackDisableBuilder();
				}

				$(this).toggleClass('edit-with-fresh-builder-btn--active-mode-classic');
				$(this).toggleClass('edit-with-fresh-builder-btn--active-mode-fresh');
			});

			$('#titlediv').after( $html );


			if( activeMode == 'fresh' ) {
				callbackEnableBuilder(this);
			}

		},



	});

	$(document).ready(function(){
		frslib.environment.instance = new frslib.environment.environment();
	});
})(jQuery);
