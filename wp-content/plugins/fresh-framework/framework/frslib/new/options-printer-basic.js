(function($){
	frslib.provide('frslib.options2');

	/**
	 * Printing our options
	 */
	frslib.options2.printerBasic = frslib.options2.walker.extend({

		_prefix: 'default',

		_output : '',

		getOutput: function() {
			return this._output;
		},

		_escAttr : function(s, preserveCR) {
			preserveCR = preserveCR ? '&#13;' : '\n';
			return ('' + s) /* Forces the conversion to string. */
				.replace(/&/g, '&amp;') /* This MUST be the 1st replacement. */
				.replace(/'/g, '&apos;') /* The 4 other predefined entities, required. */
				.replace(/"/g, '&quot;')
				.replace(/</g, '&lt;')
				.replace(/>/g, '&gt;')
				/*
				 You may add other replacements here for HTML only
				 (but it's not necessary).
				 Or for XML, only if the named entities are defined in its DTD.
				 */
				.replace(/\r\n/g, preserveCR) /* Must be before the next replacement. */
				.replace(/[\r\n]/g, preserveCR);
			;
		},

		_getAttrHelper : function() {
			return frslib.attr.createHelper();
		},

		setPrefix: function( prefix)  {
			this._prefix = prefix;
		}
	});

})(jQuery);
