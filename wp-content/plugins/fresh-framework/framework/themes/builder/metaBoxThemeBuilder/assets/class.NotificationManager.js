(function($){
	frslib.provide('window.ffbuilder');

	window.ffbuilder.NotificationManager = Backbone.View.extend({
/**********************************************************************************************************************/
/* INIT
/**********************************************************************************************************************/
		_vent: null,

		$el: null,
		/*----------------------------------------------------------*/
		/* BINDING ACTIONS
		 /*----------------------------------------------------------*/
		_bindActions: function() {
			var self = this;
			this.listenTo( this._vent, this._vent.a.savedByAjax, function(){
				self.addNotification( 'success', 'Saved & Published');
			});

			this.listenTo( this._vent, this._vent.a.elementCopied, function(){
				self.addNotification( 'info', 'Copied');
			});

			this.listenTo( this._vent, this._vent.a.elementPasted, function(){
				self.addNotification( 'info', 'Pasted');
			});
		},

		/*----------------------------------------------------------*/
		/* INIT
		 /*----------------------------------------------------------*/
		initialize: function( options) {
			// this._vent = options.vent;
			this._createNotificationBox();
			// this._bindActions();
		},

		injectVent: function( vent ) {
			this._vent = vent;
			this._bindActions();
		},
/**********************************************************************************************************************/
/* CONTENT
/**********************************************************************************************************************/
		/**
		 * Creates the div, which holds all notifications and insert it right at the body
		 */
		_createNotificationBox: function() {
			var notificationBox = '';
			notificationBox += '<div class="ffb-notification-box">';
			notificationBox += '<span class="fftm-notify__list"></span>';
			notificationBox += '</div>';

			this.$el = $(notificationBox);

			$('body').append( this.$el );

			var $error = this._getNotificationObjectSuccess();
		},


		addNotification: function( type, text ) {

			var deletePreviousNotificationOfSameType = null;
			var $notification = null;
			var hideAutomatically = null;

			switch( type ) {
				case 'info':
					deletePreviousNotificationOfSameType = false;
					hideAutomatically = true;
					$notification = this._getNotificationObjectInfo( text );
					break;

				case 'success':
					deletePreviousNotificationOfSameType = false;
					hideAutomatically = true;
					$notification = this._getNotificationObjectSuccess( text );
					break;

				case 'warning':
					deletePreviousNotificationOfSameType = false;
					hideAutomatically = false;
					$notification = this._getNotificationObjectWarning( text );
					break;

				case 'error':
					deletePreviousNotificationOfSameType = false;
					hideAutomatically = false;
					$notification = this._getNotificationObjectError( text );
					break;
			}


			if( type != 'error' ) {
				this._bindClickRemoveNotification( $notification );
			}

			if( deletePreviousNotificationOfSameType == true ) {
				var notificationClass = '.fftm-notify__item-type--' + type;
				var $notificationsToRemove = this.$el.find( notificationClass);
				var self = this;

				if( $notificationsToRemove.size() > 0  ) {

					self._removeNotification( $notificationsToRemove, function(){
						self.$el.find('.fftm-notify__list').append( $notification );
						self._manageNotification( $notification, hideAutomatically );
					});

				} else {
					this.$el.find('.fftm-notify__list').append( $notification );
					this._manageNotification( $notification, hideAutomatically );
				}
			} else {
				this.$el.find('.fftm-notify__list').append( $notification );
				this._manageNotification( $notification, hideAutomatically );
			}

		},

		_removeNotification: function ( $notification, callback ) {
			$notification.removeClass('fftm-notify__item--anim-enter--ended').addClass('fftm-notify__item--anim-exit');

			setTimeout(function() {

				$notification.remove();

				if( callback != undefined ) {
					callback();
				}

			}, 437 ); // how long exiting animation takes
		},

		_bindClickRemoveNotification: function( $notification ) {
			var self = this;
			$notification.click(function(){
				self._removeNotification( $(this) );
			});
		},

		_manageNotification: function( $notification, hideAutomatically, deletePreviousNotificationOfSameType ) {
			var self = this;
			setTimeout(function() {

				$notification.removeClass('fftm-notify__item--anim-enter').addClass('fftm-notify__item--anim-enter--ended');

				if( hideAutomatically ) {
					setTimeout(function() {
						self._removeNotification( $notification );
					}, 3000 ); // how long do you want the notification to stay visible
				}

			}, 227 );

		},

		_getNotificationObjectError: function( text ) {
			var toReturn = '';

			toReturn += '<div class="fftm-notify__item fftm-notify__item--anim-enter fftm-notify__item-type--error">';
			toReturn += '<div class="fftm-notify__item-content">' + text + '</div>';
			toReturn += '<i class="fftm-notify__item-type-icon ff-font-awesome4 icon-times-circle"></i>';
			toReturn += '</div>';

			return $(toReturn);
		},

		_getNotificationObjectWarning: function( text ) {
			var toReturn = '';

			toReturn += '<div class="fftm-notify__item fftm-notify__item--anim-enter fftm-notify__item-type--warning">';
			toReturn += '<div class="fftm-notify__item-content">' + text + '</div>';
			toReturn += '<i class="fftm-notify__item-close-button fftm-notify__item-type-icon ff-font-awesome4 icon-exclamation-triangxxle"></i>';
			toReturn += '</div>';

			return $(toReturn);
		},

		_getNotificationObjectSuccess: function ( text ) {

			var toReturn = '';
			toReturn += '<div data-type="success" class="fftm-notify__item fftm-notify__item--anim-enter fftm-notify__item-type--success">';
			toReturn += '<div class="fftm-notify__item-content">' + text + '</div>';
			toReturn += '<i class="fftm-notify__item-close-button fftm-notify__item-type-icon ff-font-awesome4 icon-check-circle"></i>';
			toReturn += '</div>';

			return $(toReturn);
		},


		_getNotificationObjectInfo: function ( text ) {

			var toReturn = '';
			toReturn += '<div data-type="info" class="fftm-notify__item fftm-notify__item--anim-enter fftm-notify__item-type--info">';
			toReturn += '<div class="fftm-notify__item-content">' + text + '</div>';
			toReturn += '<i class="fftm-notify__item-close-button fftm-notify__item-type-icon ff-font-awesome4 icon-info-circle"></i>';
			toReturn += '</div>';

			return $(toReturn);
		},


	});

})(jQuery );