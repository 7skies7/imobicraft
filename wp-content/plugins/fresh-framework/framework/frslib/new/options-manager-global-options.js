(function($){
	frslib.provide('frslib.options2');

	/**
	 * Printing our options
	 */
	frslib.options2.managerGlobalOptions = frslib.options2.manager.extend({

		// _defaultImagePlaceholdersData: null,

		_autoCalledInit_1 : function() {


			this._applyToOptions.push('_initGlobalOptions');
			this._applyToOptionsAfterInsert.push('_markGlobalOptionsTabs');

		},

		markGlobalOptionsTabs: function() {
			this._markGlobalOptionsTabs( this.$el );
		},

		_markGlobalOptionsTabs: function( $element ) {
			// firstly just the top items:
			var self = this;

			$element.find('.ffb-modal__tabs').addBack('.ffb-modal__tabs').each(function( index, $el ) {
				var $this = $(this);
				var $contents = $this.children('.ffb-modal__tab-contents');
				var $headers = $this.children('.ffb-modal__tab-headers');

				var isRepeatableTab = false;
				var repeatableHasGlobalSettings = false;

				$headers.find('.ffb-modal__tab-header').each(function(){
					var $tabHeader = $(this);
					var info = self._initGlobalOptions_getElementLocalizationInfo( $tabHeader );

					if( info.route != 'o' ) {
						isRepeatableTab = true;
					}

					var currentData = self._dataManager.getElementGlobalStyle( info.elementId, info.elementVariation, info.route, info.systemTabId );

					if( _.size(currentData) > 0 ) {
						$tabHeader.addClass('ffb-modal__tab-header--filled-global');
						var id = $tabHeader.attr('data-id');
						$tabHeader.parents('.ffb-modal__tabs:first').children('.ffb-modal__tab-contents').children('.ffb-modal__tab-content[data-id="' + id +'"]').addClass('ffb-modal__tab-content-global-changed');
						repeatableHasGlobalSettings = true;
					} else {
						$tabHeader.removeClass('ffb-modal__tab-header--filled-global');
						var id = $tabHeader.attr('data-id');
						$tabHeader.parents('.ffb-modal__tabs:first').children('.ffb-modal__tab-contents').children('.ffb-modal__tab-content[data-id="' + id +'"]').removeClass('ffb-modal__tab-content-global-changed');
					}

				});

				if( isRepeatableTab ) {
					if( repeatableHasGlobalSettings ) {
						$this.parents('.ff-repeatable-item:first').addClass('ff-repeatable-global-changed-active');
					} else {
						$this.parents('.ff-repeatable-item:first').removeClass('ff-repeatable-global-changed-active');
					}
				}
				 
			});
		},



		_initGlobalOptions_getNewOptionsForm: function( blockUniqueHash, optionsManager ) {
			var currentBlock = this._optionsPrinter._blocks[ blockUniqueHash ];


			// optionsManager.setData({'b-m':{'pd-xs':{'t':158}}});
			optionsManager.setStructure( currentBlock );
			optionsManager.setBlocks(this._optionsPrinter._blocks);

			var $data = optionsManager.render();
			var $newData = $('<div class="ffb-global-options-temporary-holder"></div>');
			$newData.html( $data );

			$newData.find('.ffb-modal__tab-header').remove();
			$newData.find('.ffb-modal__tab-content').css('display', 'block');
			$newData.find('.ffb-modal__tab-content').css('background', 'white');

			var $globalSwitcher = this._getGlobalLocalSwitcherHTML('global');
			$newData.find('.ffb-modal__tab-content').prepend( $globalSwitcher);
			var $saveBar = this._getSaveBarHTML();
			$newData.find('.ffb-modal__tab-content').append( $saveBar );

			return $newData;
		},

		_initGlobalOptions_getCurrentGlobalStyle: function() {
			return this._getElementSysInfo('global-style', 0);
		},

		_initGlobalOptions_getElementLocalizationInfo: function( $tab ) {
			var info = {};
			info.elementId = this.getMetaData('element-id');

			info.elementVariation = this._getElementSysInfo('global-style', 0);

			if( !this._dataManager.elementGlobalStyleExists( info.elementId, info.elementVariation ) ) {
				info.elementVariation = 0;
			}

			// var globalStyleDataHolder = this._autoCalledInit_1.
			

			var $parent = $tab.closest('.ffb-modal-origin, .ff-repeatable-item');

			if( $parent.hasClass('ffb-modal-origin') ) {
				info.route = 'o';
			} else if( $parent.hasClass('ff-repeatable-item-js') ) {
				info.route = $parent.attr('data-rep-variable-section-route') + ' ' + $parent.attr('data-section-id');
			} else if( $parent.hasClass('ff-repeatable-item-toggle-box') ) {
				info.route = $parent.attr('data-current-section-route') + ' ' + $parent.attr('data-section-id');
			}

			if( $tab.hasClass('ffb-global-options-temporary-holder') ) {
				info.systemTabId = $tab.find('.ffb-modal__content-system:first').attr('data-id');
			} else {
				info.systemTabId = $tab.attr('data-id');
			}



			return info;
		},



		_initGlobalOptions: function( $element ) {
            if( frslib.options2.dataHolder.elementGlobalStyles == undefined || Object.getOwnPropertyNames(frslib.options2.dataHolder.elementGlobalStyles).length == 0 ) {
                return;
            }

			var self = this;
			$element.find('.ffb-modal__content-system').each(function(){
				var $this = $(this);
				var id = $this.attr('data-id');
				var $tabHolder = $(this).parents('.ffb-modal__tab-contents');
				var $localOptions = $this.find('.ffb-modal__content--options:first');

				var blockUniqueHash = $tabHolder.children('.ff-reading-param[data-id="' + id +'"]').attr('data-value');
				var $switcher = self._getGlobalLocalSwitcherHTML('instance');

				$this.prepend( $switcher );

				$switcher.find('.ffb-switch-to__global').click(function(){
					var info = self._initGlobalOptions_getElementLocalizationInfo($this);

					var currentData = self._dataManager.getElementGlobalStyle( info.elementId, info.elementVariation, info.route, info.systemTabId );

					var optionsManager= new frslib.options2.managerModal();
					optionsManager.setData( currentData );

					var $newData = self._initGlobalOptions_getNewOptionsForm(blockUniqueHash, optionsManager);

					optionsManager.markChangedValues( $newData );

					$this.css('display', 'none');
					$this.after( $newData );

					$newData.freshfaceForceOverlay({bottomRightPoint: $newData.find('.ffb-modal__content--options') }, function(){
						return false;
					});

					$newData.on('change', '.ff-opt', function(){
						optionsManager.markChangedValues( $newData );
					});

					var saveGlobalTab = function () {
						var data = optionsManager.parseForm();

						self._dataManager.setElementGlobalStyle(info.elementId,info.elementVariation, info.route, info.systemTabId, data[ info.systemTabId ] );
						// self._dataManager.saveElementGlobalStyles();
						optionsManager.forceFormValuesAsUserValues();

						$('.ffb-modal__action-save-all:first').trigger('click');



					};

					var closeGlobalTab = function () {

						if( optionsManager.hasFormBeenChanged() ) {
							$.freshfaceConfirmBox('Are you sure you want to leave? All unsaved Global Style changes will be lost.', function( result ){
								if( result ) {
									$newData.freshfaceForceOverlay({action:'close'});
									$this.css('display', '');
									$newData.remove();
									self._markGlobalOptionsTabs( self.$el );
								}
							});
						} else {
							$newData.freshfaceForceOverlay({action:'close'});
							$this.css('display', '');
							$newData.remove();
							self._markGlobalOptionsTabs( self.$el );
						}
					};

					$newData.find('.ffb-switch-to__instance, .ffb-action-cancel-global').click(function(){
						closeGlobalTab();
					});

					$newData.find('.ffb-action-save-global').click(function(){
						saveGlobalTab();
					});

				});


			});
		},

		_getSaveBarHTML: function() {
			var html = '';
			html += '<div class="ffb-save-bar">';
			html += '<div class="ffb-save-bar-btn ffb-save-global-button ffb-action-save-global">Quick Save</div>';
			html += '<div class="ffb-save-bar-btn ffb-cancel-global-button ffb-action-cancel-global">Cancel</div>';
			html += '</div>';

			return $(html);
		},

		_getGlobalLocalSwitcherHTML: function( active ) {
			var html = '';
			html += '<div class="ffb-gl-switcher-holder clearfix">';
				html += '<div class="ffb-switch-to ffb-switch-to__instance">Instance</div>';
				html += '<div class="ffb-switch-to ffb-switch-to__global">Global Style</div>';
			html += '</div>';

			var $html = $(html);

			if( active == 'global' ) {
				$html.find('.ffb-switch-to__global').addClass('ffb-switch-to--active');
			} else {
				$html.find('.ffb-switch-to__instance').addClass('ffb-switch-to--active');
			}

			return $html;
		},


	});

})(jQuery);
