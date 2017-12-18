/*
 The MIT License (MIT)
 https://github.com/moagrius/isOnScreen
 */

(function ($) {

	$.fn.isOnScreen = function(x, y){

		if(x == null || typeof x == 'undefined') x = 1;
		if(y == null || typeof y == 'undefined') y = 1;

		var win = $(window);

		var viewport = {
			top : win.scrollTop(),
			left : win.scrollLeft()
		};
		viewport.right = viewport.left + win.width();
		viewport.bottom = viewport.top + win.height();

		var height = this.outerHeight();
		var width = this.outerWidth();

		if(!width || !height){
			return false;
		}

		var bounds = this.offset();
		bounds.right = bounds.left + width;
		bounds.bottom = bounds.top + height;

		var visible = (!(viewport.right < bounds.left || viewport.left > bounds.right || viewport.bottom < bounds.top || viewport.top > bounds.bottom));

		if(!visible){
			return false;
		}

		var deltas = {
			top : Math.min( 1, ( bounds.bottom - viewport.top ) / height),
			bottom : Math.min(1, ( viewport.bottom - bounds.top ) / height),
			left : Math.min(1, ( bounds.right - viewport.left ) / width),
			right : Math.min(1, ( viewport.right - bounds.left ) / width)
		};

		return (deltas.left * deltas.right) >= x && (deltas.top * deltas.bottom) >= y;

	};

})(jQuery);


// REQUEST ANIMATION FRAME

window.fgRAF = (function(){
	return  window.requestAnimationFrame		||
		window.webkitRequestAnimationFrame 	||
		window.mozRequestAnimationFrame    	||
		window.oRequestAnimationFrame      	||
		window.msRequestAnimationFrame     	||
		function( callback ){
			window.setTimeout(callback, 1000 / 60);
		};
})();

(function($){

	"use strict"; // Start of use strict

	// FRESHGRID CLASS

	var freshGridClass = {
		run: true,
		/**
		 * Elements, which have the [data-fg-bg] [parameters]
		 */
		$freshGridElements: null,

		$bgLayersCollection : $(),

		$bgCollection: $(),

		$bgLayersCalledEveryTime: $(),

		$matchColumns: $(),

		$minHeight: $(),

		$forceFullwidth: $(),

		usedLayersType: {},

		$breakpoint: null,

		breakpoint: null,

		fgWowForInit: null,

		fgWowHasBeenInit: false,

		winWidth: null,
		winHeight: null,
		/**********************************************************************************************************************/
		/* SYSTEM THINGS
		 /**********************************************************************************************************************/
		getBreakpointNames: function() {
			var breakpointNames = new Array();
			breakpointNames.push('xs');
			breakpointNames.push('sm');
			breakpointNames.push('md');
			breakpointNames.push('lg');

			return breakpointNames;
		},

		initialize: function () {
			this.initBreakPoint();
			this.initWinWidthAndHeight();
			this.initFreshGrid();
			this.initForceMinHeight();
			this.initMatchColumnsHeight();
			this.initYoutubeVideos();
			this.initWowAnimations();
			this.initForceFullwidth();

			this.eventBinding();
			this.mainLoop();
		},

		/**********************************************************************************************************************/
		/* INITIALZIATION
		 /**********************************************************************************************************************/
		initBreakPoint: function() {
			$('body').append('<div class="fg-breakpoint"></div>');
			this.$breakpoint = $('.fg-breakpoint');

			this.recalculateBreakpoint();
		},

		initForceFullwidth: function() {
			this.$forceFullwidth = $('.fg-force-fullwidth');
			this.recalculateForceFullwidth();
		},

		initWinWidthAndHeight: function() {
			this.recalculateWinWidthAndHeight();
		},

		initWowAnimations: function() {
			$('[data-fg-wow]').each(function(){
				var $this = $(this);
				$this.addClass('fg-wow ' + $this.attr('data-fg-wow'));
			});

			var fgWow = new WOW(
				{
					boxClass: 'fg-wow',
					mobile: false,
					tablet: false
				}
			);

			if( $('.animsition-loading').size() == 0 ) {
				fgWow.init();
				this.fgWowHasBeenInit = true;
			} else {
				this.fgWowForInit = fgWow;
				this.fgWowHasBeenInit = false;
			}

		},

		/**
		 * Init youtube video layers, if used
		 */
		initYoutubeVideosCounter : 0,
		initYoutubeVideos: function() {
			if( this.usedLayersType['video'] == undefined ) {
				return false;
			}

			var $ytScript = $("<script type='text/javascript' src='//www.youtube.com/iframe_api'></script>");

			var self = this;

			window.onYouTubeIframeAPIReady = (function(){

				if ( !(typeof window.YT !== 'undefined' && typeof window.YT.Player !== 'undefined') && this.initYoutubeVideosCounter < 4 ) {
					self.initYoutubeVideosCounter++;
					setTimeout( function(){self.initYoutubeVideos()}, 300 );
					return;
				}
				self.$bgLayersCollection.filter('.fg-bg-type-video').each(function(){
					var hasSound = $(this).hasClass('has-sound');
					var $youtubeIframe = $(this).find('.fg-youtube-iframe');
					var player = new YT.Player($youtubeIframe[0], {
						videoId: $youtubeIframe.attr('data-videoId'),
						playerVars: {
							iv_load_policy: 3,
							modestbranding: 1,
							autoplay: 1,
							controls: 0,
							showinfo: 0,
							wmode: 'opaque',
							branding: 0,
							autohide: 0,
							rel: 0
						},
						events: {
							'onReady': function( event ){
								if ( !hasSound ){
									player.mute();
								}

								event.target.setPlaybackQuality('highres');
							},
							'onStateChange': function( event ){
								// loop video
								if (event.data === YT.PlayerState.ENDED) {
									player.playVideo();
								}
								// set quality
								if (event.data == YT.PlayerState.BUFFERING) {
									event.target.setPlaybackQuality('highres');
								}
							},
						}
					});

					$(self).data('youtube-player', player);
				});
			});

			$('body').append( $ytScript );
		},

		initMatchColumnsHeight: function() {
			this.$matchColumns = $($(".fg-row-match-cols").get().reverse());//$('.fg-row-match-cols');
		},

		initForceMinHeight: function() {
			var self = this;

			$('[data-fg-force-min-height]').each(function(){

				if( $(this).parent().hasClass('fg-row-match-cols') ) {
					return;
				}

				self.$minHeight = self.$minHeight.add( $(this) );
			});

			this.recalculateMinHeight();
		},



		/**
		 * Init the fresh grid on all elements which have it
		 */
		initFreshGrid: function () {
			var self = this;
			this.$freshGridElements = $('[data-fg-bg]');

			if( this.$freshGridElements.size() > 0 ) {
				this.$freshGridElements.each(function(){
					self.initGridOnOneElement( $(this) );
				});
			}

			this.$freshGridElements.removeAttr('data-fg-bg');
		},

		/**
		 * Init the freshgrid at one particular element and create all the bg layers and this type of things.
		 * @param $element
		 * @returns {boolean}
		 */
		initGridOnOneElement: function( $element ) {

			if( $element.data('fg-has-been-init') == 'true' ) {
				return true;
			}
			$element.data('fg-has-been-init', 'true');



			var bgData = JSON.parse( $element.attr('data-fg-bg') );

			if( bgData == '' ) {
				return false;
			}

			if( $element.hasClass('fg-bg-is-clipped') ) {
				$element = $element.children();
			}

			/*----------------------------------------------------------*/
			/* CSS THINGS
			 /*----------------------------------------------------------*/
			$element.addClass('has-fg-bg fg-hover');
			if ( 'static' == $element.css('position') ){
				$element.css('position', 'relative');
			}
			if ( 'auto' == $element.css('z-index') ){
				$element.css('z-index','1');
			}

			var $bgLayers = $('<div class="fg-bg"></div>');
			$element.prepend( $bgLayers );

			this.$bgCollection = this.$bgCollection.add( $bgLayers );
			var collectionTypes = new Array();
			/*----------------------------------------------------------*/
			/* INIT OF EVERY SINGLE LAYER
			 /*----------------------------------------------------------*/
			for( var i in bgData ) {

				var bgLayerData = bgData[ i ];
				var $bgLayer = $('<div></div>');

				$bgLayer.addClass('fg-bg-layer fg-bg-type-' + bgLayerData.type);
				$bgLayer.css('opacity', bgLayerData.opacity);

				if ( 'yes' == bgLayerData['hover_only'] ){
					$bgLayer.addClass('fg-bg-layer-hover-only');
				}

				// hide on xs, sm, md, lg
				var breakpointNames = this.getBreakpointNames();
				for( var z in breakpointNames ) {
					var oneBreakPoint = breakpointNames[ z ];
					if( 'yes' == bgLayerData['hidden_' + oneBreakPoint ] ) {
						$bgLayer.addClass('hidden-' + oneBreakPoint );
					}
				}

				$bgLayers.append( $bgLayer );
				this.$bgLayersCollection = this.$bgLayersCollection.add( $bgLayer );
				this.usedLayersType[ bgLayerData.type ] = true;


				$bgLayer.data('bgLayerData', bgLayerData );
				$bgLayer.data('$element', $element );
				$bgLayer.data('type', bgLayerData.type );



				if( collectionTypes.indexOf( bgLayerData.type ) == -1 ) {
					collectionTypes.push( bgLayerData.type );
				}

				switch( bgLayerData.type ) {
					case 'color': this.initLayerTypeColor( bgLayerData, $bgLayer, $element ); break;
                    case 'gradient': this.initLayerTypeGradient( bgLayerData, $bgLayer, $element ); break;
					case 'image': this.initLayerTypeImage( bgLayerData, $bgLayer, $element ); break;
					case 'video': this.initLayerTypeVideo( bgLayerData, $bgLayer, $element ); break;
					case 'slant': this.initLayerTypeSlant( bgLayerData, $bgLayer, $element ); break;
					case 'parallax': this.initLayerTypeParallax( bgLayerData, $bgLayer, $element ); break;
				}
			}

			$bgLayers.data('layer-types', collectionTypes );

		},

		/*----------------------------------------------------------*/
		/* TYPE COLOR
		 /*----------------------------------------------------------*/
		initLayerTypeColor: function( bgLayerData, $bgLayer, $element ) {
			$bgLayer.css('background-color', bgLayerData.color);
		},

        /*----------------------------------------------------------*/
        /* TYPE GRADIENT
         /*----------------------------------------------------------*/
        initLayerTypeGradient: function( bgLayerData, $bgLayer, $element ) {
            //console.log( bgLayerData );
            var currentStyleAttr = $bgLayer.attr('style');
            var newStyleAttr = currentStyleAttr + ' ' + bgLayerData.gradient;
            $bgLayer.attr('style', newStyleAttr );
            //$bgLayer.css('background-color', bgLayerData.color);
        },

		/*----------------------------------------------------------*/
		/* TYPE IMAGE
		 /*----------------------------------------------------------*/
		initLayerTypeImage: function( bgLayerData, $bgLayer, $element ) {
			$bgLayer.css({
				'background-image': "url('" + bgLayerData.url + "')",
				'background-size': bgLayerData.size,
				'background-repeat': bgLayerData.repeat,
				'background-attachment': bgLayerData.attachment,
				'background-position': bgLayerData.position
			});
		},

		/*----------------------------------------------------------*/
		/* TYPE PARALLAX
		 /*----------------------------------------------------------*/
		initLayerTypeParallax: function( bgLayerData, $bgLayer, $element ) {
			$bgLayer.css('background-image', "url('" + bgLayerData.url + "')");
		},



		/*----------------------------------------------------------*/
		/* TYPE VIDEO
		 /*----------------------------------------------------------*/
		initLayerTypeVideo: function( bgLayerData, $bgLayer, $element ) {
			// init video only at laptop and higher UNLESS it is a HTML video which is allowed to be shown on mobile devices
			if( this.breakpoint < 3 && 'html' != bgLayerData.variant ) {
				return false;
			}

			if ( 'youtube' == bgLayerData.variant ){

				var url = bgLayerData.url;
				if( url) {
					var videoID = url.match(/(?:https?:\/{2})?(?:w{3}\.)?youtu(?:be)?\.(?:com|be)(?:\/watch\?v=|\/)([^\s&]+)/);
					$bgLayer.append('<div class="fg-youtube-iframe" data-videoId="' + videoID[1] + '"></div>');
				}
			} else if ( 'html' == bgLayerData.variant ){
				var url = bgLayerData.url;
				$bgLayer.append('<video class="fg-bg-html-video-frame" autoplay="" loop="" muted="" playsinline><source type="video/mp4" src="' + url + '"></source></div>');
			}

			if ( 'on' == bgLayerData.shield ){
				$bgLayer.addClass('shield-on');
			}

			if ( 'on' == bgLayerData.sound ){
				$bgLayer.addClass('has-sound');
			}
		},

		/*----------------------------------------------------------*/
		/* TYPE COLOR
		 /*----------------------------------------------------------*/
		initLayerTypeSlant: function( bgLayerData, $bgLayer, $element ) {
			var calculateSlantFunction = null;
			if ( 'top' == bgLayerData.edge ){
				if ( 'up' == bgLayerData.direction ){
					calculateSlantFunction = function( thisElWidth, thisElHeight ){
						$bgLayer.css({
							'border-top': Math.tan(bgLayerData.angle*(Math.PI/180))*thisElWidth + 'px solid ' + bgLayerData.color,
							'border-right': thisElWidth + 'px solid transparent',
							'top': '0',
							'right': '0',
							'bottom': 'auto',
							'left': 'auto'
						});
					};
				} else {
					calculateSlantFunction = function( thisElWidth, thisElHeight ){
						$bgLayer.css({
							'border-top': Math.tan(bgLayerData.angle*(Math.PI/180))*thisElWidth + 'px solid ' + bgLayerData.color,
							'border-left': thisElWidth*1*1 + 'px solid transparent',
							'top': '0',
							'right': 'auto',
							'bottom': 'auto',
							'left': '0'
						});
					};
				}
			}

			if ( 'right' == bgLayerData.edge ){
				if ( 'up' == bgLayerData.direction ){
					calculateSlantFunction = function( thisElWidth, thisElHeight ){
						$bgLayer.css({
							'border-right': Math.tan(bgLayerData.angle*(Math.PI/180))*thisElHeight + 'px solid ' + bgLayerData.color,
							'border-top': thisElHeight*1*1 + 'px solid transparent',
							'top': '0',
							'right': '0',
							'bottom': 'auto',
							'left': 'auto'
						});
					};
				} else {
					calculateSlantFunction = function( thisElWidth, thisElHeight ){
						$bgLayer.css({
							'border-right': Math.tan(bgLayerData.angle*(Math.PI/180))*thisElHeight + 'px solid ' + bgLayerData.color,
							'border-bottom': thisElHeight*1*1 + 'px solid transparent',
							'top': 'auto',
							'right': '0',
							'bottom': '0',
							'left': 'auto'
						});
					};
				}
			}

			if ( 'bottom' == bgLayerData.edge ){
				if ( 'up' == bgLayerData.direction ){
					calculateSlantFunction = function( thisElWidth, thisElHeight ){
						$bgLayer.css({
							'border-bottom': Math.tan(bgLayerData.angle*(Math.PI/180))*thisElWidth + 'px solid ' + bgLayerData.color,
							'border-right': thisElWidth*1*1 + 'px solid transparent',
							'top': 'auto',
							'right': '0',
							'bottom': '0',
							'left': 'auto'
						});
					};
				} else {
					calculateSlantFunction = function( thisElWidth, thisElHeight ){
						$bgLayer.css({
							'border-bottom': Math.tan(bgLayerData.angle*(Math.PI/180))*thisElWidth + 'px solid ' + bgLayerData.color,
							'border-left': thisElWidth*1*1 + 'px solid transparent',
							'top': 'auto',
							'right': 'auto',
							'bottom': '0',
							'left': '0'
						});
					};
				}
			}

			if ( 'left' == bgLayerData.edge ){
				if ( 'up' == bgLayerData.direction ){
					calculateSlantFunction = function( thisElWidth, thisElHeight ){
						$bgLayer.css({
							'border-left': Math.tan(bgLayerData.angle*(Math.PI/180))*thisElHeight + 'px solid ' + bgLayerData.color,
							'border-bottom': thisElHeight*1*1 + 'px solid transparent',
							'top': 'auto',
							'right': 'auto',
							'bottom': '0',
							'left': '0'
						});
					};
				} else {
					calculateSlantFunction = function( thisElWidth, thisElHeight ){
						$bgLayer.css({
							'border-left': Math.tan(bgLayerData.angle*(Math.PI/180))*thisElHeight + 'px solid ' + bgLayerData.color,
							'border-top': thisElHeight*1*1 + 'px solid transparent',
							'top': '0',
							'right': 'auto',
							'bottom': 'auto',
							'left': '0'
						});
					};
				}
			}
			$bgLayer.data('calculateSlantFunction', calculateSlantFunction );

		},

		/**********************************************************************************************************************/
		/* MAIN LOOP
		 /**********************************************************************************************************************/
		mainLoop: function() {
			var self = this;
			var isFirstRun = true;
			var numberOfRuns = 0;
			var loop = function(){

				if( self.fgWowHasBeenInit == false && $('.animsition-loading').size() == 0 ) {
					self.fgWowForInit.init();
					self.fgWowHasBeenInit= true;
				}

				self.$bgCollection.each(function () {
					var $this = $(this);

					var hasBeenResized = self.figureOutIfElementHasBeenResized( $this );

					if( isFirstRun ) {
						hasBeenResized = true;
					}

					/**
					 * call the function, which should be in for every move
					 */
					var layerTypes = $this.data('layer-types');
					if( layerTypes ) {
						if (layerTypes.indexOf('video') != -1) {
							$this.find('.fg-bg-type-video').each(function () {
								var $bgLayer = $(this);

								var type = $bgLayer.data('type');
								var bgLayerData = $bgLayer.data('bgLayerData');
								var $element = $bgLayer.data('$element');

								self.recalculateVideoLayerPlayOrStop(bgLayerData, $bgLayer, $element, hasBeenResized);
							});
						}
					}

					var isOnScreen = $this.isOnScreen(0,0);


					if( !isOnScreen && !isFirstRun) {
						return;
					}

					if( isOnScreen && $this.data('been-on-screen') == undefined ) {
						hasBeenResized = true;
						$this.data('been-on-screen', true);
					}

					/**
					 * call only the visible functions
					 */
					$this.children().each(function(){
						var $bgLayer = $(this);

						var type = $bgLayer.data('type');
						var bgLayerData = $bgLayer.data('bgLayerData');
						var $element = $bgLayer.data('$element');


						switch( type ) {
							case 'video': self.recalculateVideoLayer( bgLayerData, $bgLayer, $element, hasBeenResized ); break;
							case 'slant': self.recalculateSlantLayer( bgLayerData, $bgLayer, $element, hasBeenResized); break;
							case 'parallax': self.recalculateParallaxLayer( bgLayerData, $bgLayer, $element, hasBeenResized); break;
						}
					});

				});

				self.recalcMatchColumnsHeight();

				isFirstRun = false;
				if( self.run ) {
					fgRAF( loop);
				}

			};
			loop();
		},

		recalculateForceFullwidth: function() {
			var self = this;
			this.$forceFullwidth.each(function(){
				var $this = $(this);
				$this.css('margin-left', 0);
				var offsetLeft = $this.offset().left;

				$this.css('margin-left', -offsetLeft);
				$this.css('width', self.winWidth);

			});
		},

		recalcMatchColumnsHeight: function() {
			var self = this;

			// console.log( this.breakpoint );


			this.$matchColumns.each(function(){
				var $row = $(this);

				var breakpoints = $row.data('fg-match-cols');

				var matchThisBp = false;
				if( breakpoints == undefined ) {
					matchThisBp = true;
				} else {
					if( parseInt(breakpoints[ self.breakpoint ]) == 1 ) {
						matchThisBp = true;
					}
				}

				var biggestColumnHeight = 0;

				var $cols;
				if( $row.hasClass('fg-row-match-cols-all') ) {
					$cols = $row.find('.fg-col');
				} else {
					$cols = $row.children('.fg-col');
				}

				$cols.each(function(){

					var $col = $(this);
					if( $col.hasClass('fg-col-not-match') ) {
						return;
					}

					/*----------------------------------------------------------*/
					/* BASIC COLUMN HEIGHT
					 /*----------------------------------------------------------*/
					var basicColumnHeight = $col.find('.fg-match-column-inside-wrapper:first').height();

					var paddingTop = parseInt($col.css('padding-top'));
					var paddingBottom = parseInt($col.css('padding-bottom'));

					var borderTop = parseInt($col.css('border-top-width'));
					var borderBottom = parseInt($col.css('border-bottom-width'));

					basicColumnHeight = basicColumnHeight + paddingTop + paddingBottom + borderTop + borderBottom;

					if( basicColumnHeight > biggestColumnHeight ) {
						biggestColumnHeight = basicColumnHeight;
					}

					var setHeight = '';

					/*----------------------------------------------------------*/
					/* FORCE MIN HEIGHT
					 /*----------------------------------------------------------*/
					var dataFgForceMinHeight = $col.attr('data-fg-force-min-height');

					if( dataFgForceMinHeight != undefined ) {

						var minHeight = JSON.parse( dataFgForceMinHeight );

						var currentMinHeight = minHeight[ 'breakpoint_' + self.breakpoint ];

						if ( currentMinHeight != undefined ){

							var height = parseInt(currentMinHeight.height);

							var offset =  parseInt(currentMinHeight.offset);

							if( isNaN( offset) ) {
								offset = 0;
							}

							var actualMinHeight = self.winHeight * ( height / 100 ) + offset;
							setHeight = actualMinHeight;

							if( actualMinHeight > biggestColumnHeight ) {
								biggestColumnHeight = actualMinHeight;
							}

						}

					}

					/*----------------------------------------------------------*/
					/* HEIGHT DATA
					 /*----------------------------------------------------------*/
					var dataFgHeight = $col.attr('data-fg-height');
					if( dataFgHeight != undefined ) {
						var heightData = JSON.parse( dataFgHeight );

						var currentHeight = heightData[ self.breakpoint ];
						setHeight = currentHeight;
						if( currentHeight != null && currentHeight > biggestColumnHeight ) {
							biggestColumnHeight = currentHeight;
						}
					}

					if( !matchThisBp ) {
						// console.log( setHeight );
						$col.css('height', setHeight);
					}

				});

				if( matchThisBp ) {
					$cols.filter(':not(.fg-col-not-match)').css('height', biggestColumnHeight );
				}

			});


		},

		eventBinding: function() {
			var self = this;
			$(window).on('resize orientationchange', function(){
				self.recalculateBreakpoint();
				self.recalculateWinWidthAndHeight();
				self.recalculateMinHeight();
				self.recalculateForceFullwidth();
			});
		},

		figureOutIfElementHasBeenResized: function ( $element ) {
			var cachedDimension = $element.data('cached-dimension');
			var newDimension = $element.outerWidth() + '-' + $element.outerHeight();

			if( newDimension != cachedDimension ){
				$element.data('cached-dimension', newDimension);
				return true;
			}

			return false;
		},

		recalculateWinWidthAndHeight: function() {
			this.winWidth = $(window).width();
			this.winHeight = $(window).height();
		},


		recalculateMinHeight: function() {
			var self = this;
			this.$minHeight.each(function(){
				var $this = $(this);

				// is data empty?
				var data = JSON.parse( $this.attr('data-fg-force-min-height') );
				if( data == '' ) {
					return;
				}

				// var recalcMinHeight = function() {
				var breakpoint = self.breakpoint;

				$this.css('height', '');

				var currentHeight = $this.height();

				if( data['breakpoint_' + breakpoint] != undefined ) {
					var bpSettings, new_height, new_offset;
					bpSettings = data['breakpoint_' + breakpoint];
					new_height = parseFloat(bpSettings.height) || 0;
					new_offset = parseFloat(bpSettings.offset) || 0;

					var final_height = (self.winHeight * ( new_height / 100 )) + new_offset + 0.2; // 0.2 is a hack to compensate for "integer only" output from matchHeight


					if( final_height < currentHeight ) {
						final_height = currentHeight;
					}

					$this.css('height', Math.round(final_height) + 'px'); // rounding is needed to fix inconsistencies in Chrome with usage of ForceMinHeight
				}
			});
		},

		recalculateParallaxLayer: function( bgLayerData, $bgLayer, $element, dimensionsHasBeenChanged) {
			var thisElWidth, thisElHeight, thisElTop, thisElLeft, bgLayerHeight;
			if( this.breakpoint >= 3 ) {
				thisElWidth = $element.outerWidth();
				thisElHeight = $element.outerHeight();

				thisElTop = $element.offset().top;
				thisElLeft = $element.offset().left;
				// bgLayerHeight = $bgLayer.outerHeight();

				$bgLayer.removeClass('parallax-off').addClass('parallax-on');

				var winScrollTop = $(window).scrollTop();

				var calcBgPosX, calcBgPosY, finalBgPos;

				if ( 'auto' == bgLayerData.size ){

					// CHANGE BACKGROUND SIZE
					$bgLayer.css('background-size', 'auto');

					// CHANGE BACKGROUND POSITION
					calcBgPosX = thisElLeft + (thisElWidth - bgLayerData.width)* ( bgLayerData.offset_h / 100 ) + 'px';

					calcBgPosY = ( ( thisElTop - winScrollTop ) * bgLayerData.speed / 100 ) + ( thisElHeight - bgLayerData.height ) * ( bgLayerData.offset_v / 100 )  + 'px';

					finalBgPos = calcBgPosX + ' ' + calcBgPosY;

					$bgLayer.css('background-position', finalBgPos);

				} else if ( 'cover' == bgLayerData.size ){

					// CHANGE BACKGROUND SIZE

					var newBgWidth = thisElWidth;
					var newBgHeight = ( thisElWidth / bgLayerData.width ) * bgLayerData.height;

					var finalBgSize;

					if ( newBgHeight < ( this.winHeight - ( this.winHeight - thisElHeight ) * ( bgLayerData.speed / 100 ) ) ){
						newBgHeight = ( this.winHeight - ( this.winHeight - thisElHeight ) * ( bgLayerData.speed / 100 ) );
						newBgWidth = ( bgLayerData.width / bgLayerData.height ) * newBgHeight;
					}

					finalBgSize = newBgWidth + 'px ' + newBgHeight + 'px';

					$bgLayer.css('background-size', finalBgSize);

					// CHANGE BACKGROUND POSITION

					calcBgPosX = thisElLeft - ( ( newBgWidth - thisElWidth ) / 2 ) + 'px';
					calcBgPosY = ( thisElTop - winScrollTop ) * ( bgLayerData.speed / 100 ) + 'px';

					finalBgPos = calcBgPosX + ' ' + calcBgPosY;

					$bgLayer.css('background-position', finalBgPos);
				}

			} else {
				$bgLayer.removeClass('parallax-on').addClass('parallax-off');

				$bgLayer.css('background-position', '');
				$bgLayer.css('background-size', '');

				if ( $bgLayer.css('background-image') ){
					$bgLayer.css('background-image', "url('" + bgLayerData.url + "')");
				}
			}

		},

		recalculateSlantLayer: function( bgLayerData, $bgLayer, $element, dimensionsHasBeenChanged) {
			if( !dimensionsHasBeenChanged ) {
				return;
			}

			var elementWidth = $element.outerWidth();
			var elementHeight = $element.outerHeight();
			var recalculateSlantFunction = $bgLayer.data('calculateSlantFunction');

			recalculateSlantFunction( elementWidth, elementHeight );
		},

		recalculateVideoLayerPlayOrStop: function( bgLayerData, $bgLayer, $element, dimensionsHasBeenChanged ) {
			var self = this;
			/*----------------------------------------------------------*/
			/* PAUSE VIDEO WHEN ITS NOT VISIBLE
			 /*----------------------------------------------------------*/
			(function(){
				var playToggle = $bgLayer.data('playToggle');
				var player = $bgLayer.data('youtube-player');

				if( player == undefined || player.playVideo == undefined ) {
					return;
				}

				if( $element.isOnScreen(0,0) ){
					if( playToggle == 0 || playToggle == undefined ) {
						player.playVideo();
						$bgLayer.data('playToggle', 1);
					}
				} else {
					if( playToggle == 1 || playToggle == undefined ) {
						player.pauseVideo();
						$bgLayer.data('playToggle', 0);
					}
				}
			})();
		},

		recalculateVideoLayer: function( bgLayerData, $bgLayer, $element, dimensionsHasBeenChanged ) {
			/*----------------------------------------------------------*/
			/* CALCULATE VIDEO SIZE
			 /*----------------------------------------------------------*/
			// if( dimensionsHasBeenChanged ) {
			(function(){
				if( self.breakpoint < 3 || !$element.isOnScreen(0,0) ) {
					return false;
				}

				var thisElWidth = $element.outerWidth();
				var thisElHeight = $element.outerHeight();

				var newVideoWidth, newVideoHeight;

				if ( thisElHeight > ( thisElWidth / bgLayerData.width * bgLayerData.height ) ){

					newVideoWidth = ( thisElHeight / bgLayerData.height * bgLayerData.width ) * 1.005;
					newVideoHeight = ( thisElHeight ) * 1.005;

					$bgLayer.css({
						'width': newVideoWidth + 'px',
						'height': newVideoHeight + 'px',
						'left': ( -(newVideoWidth/2) + thisElWidth/2 ) + 'px',
						'top': '-1px'
					});

				} else {

					newVideoWidth = ( thisElWidth ) * 1.005;
					newVideoHeight = ( thisElWidth / bgLayerData.width * bgLayerData.height ) * 1.005;

					$bgLayer.css({
						'width': newVideoWidth + 'px',
						'height': newVideoHeight + 'px',
						'left': '-1px',
						'top': ( -(newVideoHeight/2) + thisElHeight/2 ) + 'px'
					});

				}
			})();
			// }


		},

		/*----------------------------------------------------------*/
		/* SMALL
		 /*----------------------------------------------------------*/
		recalculateBreakpoint: function() {
			this.breakpoint = this.$breakpoint.width();
		},

	};

	$(document).ready(function(){

		// SIMULATE HOVER

		$(document).on('touchstart touchend', '.fg-hover', function(e) {});

		// FRESHGRID INIT

		freshGridClass.initialize();

	});

})(jQuery);




