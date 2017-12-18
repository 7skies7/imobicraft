(function($){
	frslib.provide('window.ffbuilder');

	window.ffbuilder.ElementModel = Backbone.DeepModel.extend({
		/**
		 * functions are saved as strings, we create a functions from them
		 */
		processFunctions: function(){
			var self = this;
			$.each( this.get('functions'), function(key, value){

				var f = null; // temporary function holder

				eval('f = ' + value );
				self.set('functions.'+key, f);

			});
		}
	});


})(jQuery);


















