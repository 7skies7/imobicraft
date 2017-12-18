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

// _JS:_

var _ = function(obj) {
	if (obj instanceof _) return obj;
	if (!(this instanceof _)) return new _(obj);
	this._wrapped = obj;
};

// _JS:REST ARGS

restArgs = function(func, startIndex) {
	startIndex = startIndex == null ? func.length - 1 : +startIndex;
	return function() {
		var length = Math.max(arguments.length - startIndex, 0);
		var rest = Array(length);
		for (var index = 0; index < length; index++) {
			rest[index] = arguments[index + startIndex];
		}
		switch (startIndex) {
			case 0: return func.call(this, rest);
			case 1: return func.call(this, arguments[0], rest);
			case 2: return func.call(this, arguments[0], arguments[1], rest);
		}
		var args = Array(startIndex + 1);
		for (index = 0; index < startIndex; index++) {
			args[index] = arguments[index];
		}
		args[startIndex] = rest;
		return func.apply(this, args);
	};
};

// _JS:NOW

_.now = Date.now || function() {
		return new Date().getTime();
	};

// _JS:DELAY

_.delay = restArgs(function(func, wait, args) {
	return setTimeout(function() {
		return func.apply(null, args);
	}, wait);
});

// _JS:THROTTLE

_.throttle = function(func, wait, options) {
	var timeout, context, args, result;
	var previous = 0;
	if (!options) options = {};

	var later = function() {
		previous = options.leading === false ? 0 : _.now();
		timeout = null;
		result = func.apply(context, args);
		if (!timeout) context = args = null;
	};

	var throttled = function() {
		var now = _.now();
		if (!previous && options.leading === false) previous = now;
		var remaining = wait - (now - previous);
		context = this;
		args = arguments;
		if (remaining <= 0 || remaining > wait) {
			if (timeout) {
				clearTimeout(timeout);
				timeout = null;
			}
			previous = now;
			result = func.apply(context, args);
			if (!timeout) context = args = null;
		} else if (!timeout && options.trailing !== false) {
			timeout = setTimeout(later, remaining);
		}
		return result;
	};

	throttled.cancel = function() {
		clearTimeout(timeout);
		previous = 0;
		timeout = context = args = null;
	};

	return throttled;
};

// _JS:DEBOUNCE

_.debounce = function(func, wait, immediate) {
	var timeout, result;

	var later = function(context, args) {
		timeout = null;
		if (args) result = func.apply(context, args);
	};

	var debounced = restArgs(function(args) {
		if (timeout) clearTimeout(timeout);
		if (immediate) {
			var callNow = !timeout;
			timeout = setTimeout(later, wait);
			if (callNow) result = func.apply(this, args);
		} else {
			timeout = _.delay(later, wait, this, args);
		}

		return result;
	});

	debounced.cancel = function() {
		clearTimeout(timeout);
		timeout = null;
	};

	return debounced;
};

(function($){

	"use strict"; // Start of use strict

	// GET WINDOW SIZE

	var fgWinWidth;
	var fgWinHeight;

	function calcFgWinWidth(){
		fgWinWidth = $(window).width();
	}

	function calcFgWinHeight(){
		fgWinHeight = $(window).height();
	}

	calcFgWinWidth();
	calcFgWinHeight();

	// DOCUMENT READY

	$(document).ready(function(){

		// BREAKPOINT DETECTION

		$('body').append('<div class="fg-breakpoint"></div>');

		var $fgBreakpoint = $('.fg-breakpoint');
		var fgBreakpoint;

		function calcFgBreakpoint(){
			fgBreakpoint = $fgBreakpoint.width();
		}

		calcFgBreakpoint();

		// SIMULATE HOVER

		$(document).on('touchstart touchend', '.fg-hover', function(e) {});

		// ROW MATCH COLS HEIGHT

		$('.fg-row-match-cols').each(function(){
			$(this).children('.fg-col').matchHeight({
				byRow:false
			});
		});

		var fgRowMatchArray = new Array();

		$('.fg-row-match-cols > .fg-col').each(function(index){
			var $this = $(this);
			fgRowMatchArray[index]={
				'$col' : $this,
				'height' : $this.outerHeight()
			}
		});

		var refreshMatchColsThrottled = _.debounce(function() {
			$.fn.matchHeight._update();
		}, 1);

		function fgRowMatchHeightRecalc() {
			fgRAF(fgRowMatchHeightRecalc);

			var i, len;
			var fgRowMatchThisItem;
			var currentHeight;
			var lastHeight;
			var memoryHeight;

			for (i = 0, len = fgRowMatchArray.length; i < len; i++) {


				if ( fgRowMatchArray[i].$col.isOnScreen(0,0) ){

					fgRowMatchThisItem = fgRowMatchArray[i];

					memoryHeight = fgRowMatchArray[i].$col.outerHeight();

					fgRowMatchArray[i].$col.css('height', 'auto');

					currentHeight = fgRowMatchArray[i].$col.outerHeight();

					lastHeight = fgRowMatchArray[i].height;

					if ( currentHeight != lastHeight ){
						refreshMatchColsThrottled();
					}

					fgRowMatchArray[i].height = currentHeight;

					fgRowMatchArray[i].$col.css('height', memoryHeight);

				}

			}

		}

		if ( 0 != $('.fg-row-match-cols > .fg-col').size() ){
			fgRowMatchHeightRecalc();
		};

		// SCALE ELEMENT TO FULLSCREEN (HEIGHT ONLY)

		$.fn.fgForceMinHeight = function(){

			this.each(function() {

				var $this_el = $(this);

				var forceMinHeightData = JSON.parse($this_el.attr('data-fg-force-min-height'));

				if ( '' == forceMinHeightData ){
					return;
				}

				var bpSettings;
				var new_height = '';
				var new_offset = '';

				function fgForceMinHeightRecalc(){

					if ( undefined != forceMinHeightData['breakpoint_' + fgBreakpoint] ){
						bpSettings = forceMinHeightData['breakpoint_' + fgBreakpoint];
						new_height = parseFloat(bpSettings.height) || 0;
						new_offset = parseFloat(bpSettings.offset) || 0;

						var final_height = (fgWinHeight * ( new_height / 100 )) + new_offset + 0.2; // 0.2 is a hack to compensate for "integer only" output from matchHeight

						$this_el.css('min-height', Math.round(final_height) + 'px'); // rounding is needed to fix inconsistencies in Chrome with usage of ForceMinHeight

					} else {
						$this_el.css('min-height', '');
					}

					$.fn.matchHeight._update();

				}

				fgForceMinHeightRecalc();

				$(window).on('resize orientationchange', function() {
					fgForceMinHeightRecalc();
				});

			});

			return this;

		};

		$('[data-fg-force-min-height]').fgForceMinHeight();

		// WOW ANIMATIONS

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

		fgWow.init();

		// BACKGROUNDS

		$.fn.fgBackground = function(){

			function fgBgInitYT(){

				if ( 0 == $('.fg-youtube-iframe').size() ){
					return;
				}

				if (typeof window.YT !== 'undefined' && typeof window.YT.Player !== 'undefined') {

					$('.fg-youtube-iframe').each(function(){

						var $this = $(this);

						var $thisElementWithVideo = $this.closest('[data-fg-bg]');

						var player = new YT.Player($this[0], {
							videoId: $this.attr('data-videoId'),
							playerVars: {
								iv_load_policy: 3,
								modestbranding: 1,
								autoplay: 1,
								controls: 0,
								showinfo: 0,
								wmode: 'opaque',
								branding: 0,
								autohide: 0
							},
							events: {
								'onReady': onPlayerReady,
								'onStateChange': onPlayerStateChange
							}
						});

						function onPlayerStateChange(event) {

							// LOOP THE VIDEO

							if (event.data === YT.PlayerState.ENDED) {
								player.playVideo();
							}

							// SET QUALITY

							if (event.data == YT.PlayerState.BUFFERING) {
								event.target.setPlaybackQuality('highres');
							}

						}

						function onPlayerReady(event) {

							// MUTE

							player.mute();

							// SET QUALITY

							event.target.setPlaybackQuality('highres');

							// PAUSE VIDEO IF ELEMENT IS OUTSIDE OF THE VIEWPORT

							var playToggle = null;

							function isVideoVisible() {

								fgRAF(isVideoVisible);

								if ( $thisElementWithVideo.isOnScreen(0,0) ){

									if ( 0 == playToggle || null == playToggle ){

										player.playVideo();
										playToggle = 1;

									}

								} else {

									if ( 1 == playToggle || null == playToggle ){

										player.pauseVideo();
										playToggle = 0;

									}

								}

							}

							isVideoVisible();
						}


					});

				} else {
					window.setTimeout(fgBgInitYT,300);
				}

			}

			function bg_type_color(bgLayerData, $bgLayer, $this_el){
				$bgLayer.css('background-color', bgLayerData.color);
			}

			function bg_type_image(bgLayerData, $bgLayer, $this_el){
				$bgLayer.css({
					'background-image': "url('" + bgLayerData.url + "')",
					'background-size': bgLayerData.size,
					'background-repeat': bgLayerData.repeat,
					'background-attachment': bgLayerData.attachment,
					'background-position': bgLayerData.position
				});
			}

			function bg_type_video(bgLayerData, $bgLayer, $this_el){

				function fgVideoBgSize() {

					var thisElWidth = $this_el.outerWidth();
					var thisElHeight = $this_el.outerHeight();

					if ( thisElHeight > ( thisElWidth / bgLayerData.width * bgLayerData.height ) ){

						var newVideoWidth = ( thisElHeight / bgLayerData.height * bgLayerData.width ) * 1.005;
						var newVideoHeight = ( thisElHeight ) * 1.005;

						$bgLayer.css({
							'width': newVideoWidth + 'px',
							'height': newVideoHeight + 'px',
							'left': ( -(newVideoWidth/2) + thisElWidth/2 ) + 'px',
							'top': '-1px'
						});

					} else {

						var newVideoWidth = ( thisElWidth ) * 1.005;
						var newVideoHeight = ( thisElWidth / bgLayerData.width * bgLayerData.height ) * 1.005;

						$bgLayer.css({
							'width': newVideoWidth + 'px',
							'height': newVideoHeight + 'px',
							'left': '-1px',
							'top': ( -(newVideoHeight/2) + thisElHeight/2 ) + 'px'
						});

					}

				}

				function fgVideoBgSizeRecalc() {

					fgRAF(fgVideoBgSizeRecalc);

					if ( fgBreakpoint >= 3 ) {

						if ( $bgLayer.isOnScreen(0,0) ){

							fgVideoBgSize();

						}

					}

				}

				if ( fgBreakpoint >= 3 ) {

					if ( 'youtube' == bgLayerData.variant ){

						var url = bgLayerData.url;
						if(url){
							var videoID = url.match(/(?:https?:\/{2})?(?:w{3}\.)?youtu(?:be)?\.(?:com|be)(?:\/watch\?v=|\/)([^\s&]+)/);
							$bgLayer.append('<div class="fg-youtube-iframe" data-videoId="' + videoID[1] + '"></div>');
						}


					} else if ( 'html' == bgLayerData.variant ){

						var url = bgLayerData.url;

						$bgLayer.append('<video class="fg-bg-html-video-frame" autoplay="" loop="" muted="" ><source type="video/mp4" src="' + url + '"></source></div>');

					}

					if ( 'on' == bgLayerData.shield ){
						$bgLayer.addClass('shield-on');
					}

					fgVideoBgSize();
					fgVideoBgSizeRecalc();

				}

			}

			function bg_type_slant(bgLayerData, $bgLayer, $this_el){

				var thisElWidth = $this_el.outerWidth();
				var thisElHeight = $this_el.outerHeight();

				function calcElSize(){
					thisElWidth = $this_el.outerWidth();
					thisElHeight = $this_el.outerHeight();
				}

				calcElSize();

				var calcSlant = null;

				if ( 'top' == bgLayerData.edge ){
					if ( 'up' == bgLayerData.direction ){
						calcSlant = function(){
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
						calcSlant = function(){
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
						calcSlant = function(){
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
						calcSlant = function(){
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
						calcSlant = function(){
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
						calcSlant = function(){
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
						calcSlant = function(){
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
						calcSlant = function(){
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

				function doSlant(){

					fgRAF(doSlant);

					if ( $this_el.isOnScreen(0,0) ){

						calcElSize();

						if ( calcSlant ){
							calcSlant();
						}

					}

				}

				doSlant();

			}

			function bg_type_parallax(bgLayerData, $bgLayer, $this_el){

				var lastLoop = new Date;

				function fgParallax() {

					fgRAF(fgParallax);

					if ( fgBreakpoint >= 3 ) {

						thisElWidth = $this_el.outerWidth();
						thisElHeight = $this_el.outerHeight();
						thisElTop = $this_el.offset().top;
						thisElLeft = $this_el.offset().left;
						bgLayerHeight = $bgLayer.outerHeight();

						$bgLayer.removeClass('parallax-off').addClass('parallax-on');

						var winScrollTop = $(window).scrollTop();

						if ( $bgLayer.isOnScreen(0,0) ){

							if ( 'auto' == bgLayerData.size ){

								// CHANGE BACKGROUND SIZE

								$bgLayer.css('background-size', 'auto');

								// CHANGE BACKGROUND POSITION

								var calcBgPosX = thisElLeft + (thisElWidth - bgLayerData.width)* ( bgLayerData.offset_h / 100 ) + 'px';

								var calcBgPosY = ( ( thisElTop - winScrollTop ) * bgLayerData.speed / 100 ) + ( thisElHeight - bgLayerData.height ) * ( bgLayerData.offset_v / 100 )  + 'px';

								var finalBgPos = calcBgPosX + ' ' + calcBgPosY;

								$bgLayer.css('background-position', finalBgPos);

								// ATTACH BACKGROUND IMAGE

								if ( $bgLayer.css('background-image') ){
									$bgLayer.css('background-image', "url('" + bgLayerData.url + "')");
								}

							} else if ( 'cover' == bgLayerData.size ){

								// CHANGE BACKGROUND SIZE

								var newBgWidth = thisElWidth;
								var newBgHeight = ( thisElWidth / bgLayerData.width ) * bgLayerData.height;

								var finalBgSize;

								if ( newBgHeight < ( fgWinHeight - ( fgWinHeight - thisElHeight ) * ( bgLayerData.speed / 100 ) ) ){
									newBgHeight = ( fgWinHeight - ( fgWinHeight - thisElHeight ) * ( bgLayerData.speed / 100 ) );
									newBgWidth = ( bgLayerData.width / bgLayerData.height ) * newBgHeight;
								}

								finalBgSize = newBgWidth + 'px ' + newBgHeight + 'px';

								$bgLayer.css('background-size', finalBgSize);

								// CHANGE BACKGROUND POSITION

								var calcBgPosX = thisElLeft - ( ( newBgWidth - thisElWidth ) / 2 ) + 'px';
								var calcBgPosY = ( thisElTop - winScrollTop ) * ( bgLayerData.speed / 100 ) + 'px';

								var finalBgPos = calcBgPosX + ' ' + calcBgPosY;

								$bgLayer.css('background-position', finalBgPos);

								// ATTACH BACKGROUND IMAGE

								if ( $bgLayer.css('background-image') ){
									$bgLayer.css('background-image', "url('" + bgLayerData.url + "')");
								}

							}

						}

					} else {

						$bgLayer.removeClass('parallax-on').addClass('parallax-off');

						$bgLayer.css('background-position', '');
						$bgLayer.css('background-size', '');

						if ( $bgLayer.css('background-image') ){
							$bgLayer.css('background-image', "url('" + bgLayerData.url + "')");
						}

					}

				}

				function fgParallaxInit(){

					if ( fgBreakpoint >= 3 ) {

						fgParallax();

					} else {

						$bgLayer.removeClass('parallax-on').addClass('parallax-off');
						$bgLayer.css('background-image', "url('" + bgLayerData.url + "')");

					}

				}

				var thisElWidth, thisElHeight, thisElTop, thisElLeft, bgLayerHeight;

				fgParallaxInit();

			}

			this.each(function() {
				var $this_el = $(this);
				var bgData = JSON.parse($this_el.attr('data-fg-bg'));

				var len, i, bgLayerData, $bgLayer, $bgLayers;

				if ( '' == bgData ){
					return;
				}

				$this_el.addClass('has-fg-bg fg-hover');

				if ( 'static' == $this_el.css('position') ){
					$this_el.css('position', 'relative');
				}

				if ( 'auto' == $this_el.css('z-index') ){
					$this_el.css('z-index','1');
				}

				$bgLayers = $('<div class="fg-bg"></div>');
				$this_el.prepend($bgLayers);

				for (i = 0, len = bgData.length; i < len; i++) {
					bgLayerData = bgData[i];
					$bgLayer = $('<div></div>');
					$bgLayer.addClass('fg-bg-layer fg-bg-type-' + bgLayerData.type);

					$bgLayer.css('opacity', bgLayerData.opacity);

					if ( "yes" == bgLayerData.hover_only ){
						$bgLayer.addClass('fg-bg-layer-hover-only');
					}

					if ( "yes" == bgLayerData.hidden_xs ){
						$bgLayer.addClass('hidden-xs');
					}

					if ( "yes" == bgLayerData.hidden_sm ){
						$bgLayer.addClass('hidden-sm');
					}

					if ( "yes" == bgLayerData.hidden_md ){
						$bgLayer.addClass('hidden-md');
					}

					if ( "yes" == bgLayerData.hidden_lg ){
						$bgLayer.addClass('hidden-lg');
					}

					$bgLayers.append($bgLayer);

					switch (bgLayerData.type){
						case 'color': bg_type_color(bgLayerData, $bgLayer, $this_el); break;
						case 'image': bg_type_image(bgLayerData, $bgLayer, $this_el); break;
						case 'video': bg_type_video(bgLayerData, $bgLayer, $this_el); break;
						case 'slant': bg_type_slant(bgLayerData, $bgLayer, $this_el); break;
						case 'parallax': bg_type_parallax(bgLayerData, $bgLayer, $this_el); break;
					}

				}
			});

			fgBgInitYT();

			return this;

		};

		$('[data-fg-bg]').fgBackground();

		// WINDOW RESIZE

		$(window).on('resize orientationchange', function() {
			calcFgBreakpoint();

			calcFgWinWidth();
			calcFgWinHeight();
		});

	});


})(jQuery);




