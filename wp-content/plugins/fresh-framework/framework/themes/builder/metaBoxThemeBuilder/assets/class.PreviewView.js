(function($){
	frslib.provide('window.ffbuilder');
	window.ffbuilder.PreviewView = Backbone.View.extend({
		_html : '',

		initialize: function() {
			this._mixQueryAndPreview();
		},

		escapeHtml: function(text) {
			if( text == undefined ) {
				return text;
			}


			text = $('<div>' + text + '</div>').text();

			text = text.split('&quot;').join('"');

			text = text.split('<').join('&lt;');
			text = text.split('>').join('&gt;');

			return text.split('&quot;').join('"');
		},

		escapeHeading: function( heading ) {
			var maxNumChar = 75;

			if( heading.length > maxNumChar ) {
				heading = heading.substr(0, maxNumChar );
				heading = heading + '...';
			}

			return heading;
		},

		escapeText: function( text ) {
			var maxNumChar = 300;

			if( text.length > maxNumChar ) {
				text = text.substr(0, maxNumChar );
				text = text + '...';
			}

			return text;
		},

		addHeadingLg: function( heading ) {
			heading = this.escapeHtml( heading );
			heading = this.escapeHeading( heading );
			// console.log('bbb');
			// console.log( heading );
			// console.log('aaa');
			// alert('ss');
			if( heading == '' ) {
				return;
			}
			this._html += '<div class="ffb-preview-heading-lg"><span>' + heading + '</span></div>';
		},

		addHeadingSm: function( heading ) {
			heading = this.escapeHtml( heading );
			heading = this.escapeHeading( heading );

			if( heading == '' ) {
				return;
			}

			this._html += '<div class="ffb-preview-heading-sm"><span>' + heading + '</span></div>';
		},

		addText: function( text ){
			text = this.escapeHtml( text );
			text = this.escapeText( text );

			if( text == '' ) {
				return;
			}

			this._html += '<div class="ffb-preview-text">' + text + '</div>';
		},

		addLink: function( text ){
			text = this.escapeHtml( text );
			this._html += '<div class="ffb-preview-button">' + text + '</div>';
		},

		addVideo: function( text ){
			text = this.escapeHtml( text );

			if( text == '' ) {
				return;
			}

			this._html += '<div class="ffb-preview-video">' + text + '</div>';
		},

		addDivider: function( text ){
			text = this.escapeHtml( text );

			if( text == '' ) {
				return;
			}
			
			this._html += '<div class="ffb-preview-divider"></div>';
		},

		addImage: function( src, textBefore, textAfter ){
			if (textBefore){}else textBefore = '';
			if (textAfter){}else textAfter = '';

			if( src.indexOf('"id":') != -1 && src.indexOf('"url":') != -1 ) {
				src = JSON.parse( src );

				if( src.substitute != undefined ) {
					src = src.substitute;
				}

				if( src.id == -1 ) {
					src.url = ff_ark_core_plugin_url + '/builder/placeholders/' + src.url;
				}

				src = src.url;
			}

			this._html += textBefore + '<img class="ffb-preview-image" src="' + src + '" />' + textAfter;
		},

		addIcon: function( icon, textBefore, textAfter ){
			if (textBefore){}else textBefore = '';
			if (textAfter){}else textAfter = '';

			this._html += textBefore + '<div class="ffb-preview-icon"><i class="ffb-preview-icon-content ' + icon + '"></i></div>' + textAfter;
		},

		addPlainText: function( plainText ) {
			this._html += plainText;
		},

		getHtmlPreview: function() {
			return this._html;
		},

		_mixQueryAndPreview: function() {

			var previewObject = this;

			_.extend( frslib.options2.query.prototype, {
				addHeadingLg : function( query, htmlBefore, htmlAfter ) {
					htmlBefore = this._makeSureItsString( htmlBefore );
					htmlAfter = this._makeSureItsString( htmlAfter );

					var value = '';
					if( query != null ) {
						value = this.get( query );
					}

					previewObject.addHeadingLg( htmlBefore + value + htmlAfter );
				},

				addHeadingSm: function( query, htmlBefore, htmlAfter ) {
					htmlBefore = this._makeSureItsString( htmlBefore );
					htmlAfter = this._makeSureItsString( htmlAfter );

					var value = '';
					if( query != null ) {
						value = this.get( query );
					}
					previewObject.addHeadingSm (htmlBefore + value + htmlAfter);
				},

				addText: function( query, htmlBefore, htmlAfter ) {
					htmlBefore = this._makeSureItsString( htmlBefore );
					htmlAfter = this._makeSureItsString( htmlAfter );

					var value = '';
					if( query != null ) {
						value = this.get( query );
					}
					previewObject.addText (htmlBefore + value + htmlAfter);
				},

				addLink: function( query, htmlBefore, htmlAfter ) {
					htmlBefore = this._makeSureItsString( htmlBefore );
					htmlAfter = this._makeSureItsString( htmlAfter );

					var value = '';
					if( query != null ) {
						value = this.get( query );
					}
					previewObject.addLink (htmlBefore + value + htmlAfter);
				},

				addVideo: function( query, htmlBefore, htmlAfter ) {
					htmlBefore = this._makeSureItsString( htmlBefore );
					htmlAfter = this._makeSureItsString( htmlAfter );

					var value = '';
					if( query != null ) {
						value = this.get( query );
					}
					previewObject.addVideo (htmlBefore + value + htmlAfter);
				},

				addDivider: function( query, htmlBefore, htmlAfter ) {
					htmlBefore = this._makeSureItsString( htmlBefore );
					htmlAfter = this._makeSureItsString( htmlAfter );

					var value = '';
					if( query != null ) {
						value = this.get( query );
					}
					previewObject.addDivider (htmlBefore + value + htmlAfter);
				},

				addImage: function( query, htmlBefore, htmlAfter ) {
					htmlBefore = this._makeSureItsString( htmlBefore );
					htmlAfter = this._makeSureItsString( htmlAfter );

					var value = '';
					if( query != null ) {
						value = this.get( query );
					}
					previewObject.addImage (value, htmlBefore, htmlAfter);
				},

				addIcon: function( query, htmlBefore, htmlAfter ) {
					htmlBefore = this._makeSureItsString( htmlBefore );
					htmlAfter = this._makeSureItsString( htmlAfter );

					var value = '';
					if( query != null ) {
						value = this.get( query );
					}
					previewObject.addIcon (value, htmlBefore, htmlAfter);
				},

				addPlainText: function( text ) {
					previewObject.addPlainText( text );
				},

				addBreak: function() {
					previewObject.addPlainText('</br>');
				},

				_makeSureItsString: function( value ) {
					if( value == undefined ) {
						return '';
					} else {
						return value;
					}
				}

			});

		},

	});


})(jQuery);


















