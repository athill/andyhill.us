(function($){  
	$.fn.imageArray = function(options) {
		var defaults = {
			imgWidth: 120
		};
		var options = $.extend(defaults, options);      
		return this.each(function() {  
			var padding = {};
			var paddings = "left,bottom,top,right".split(",");
			for (var i = 0; i < paddings.length; i++) {
				var pad = paddings[i];
				padding[pad] = $(this)
					.css('padding-'+pad)
					.replace(/[a-zA-Z]+/, "");
			}
			var hpad = parseInt(padding['left']) + parseInt(padding['right']);
			var vpad = parseInt(padding['top']) + parseInt(padding['bottom']);
			var winWidth = $(this).width() - hpad;
			var numImgs = ($("img", this).length);
			var winSpace = winWidth - options.imgWidth * numImgs;
			var imgSpace = winSpace / (numImgs - 1);
			$("img", this).each(function(index) {
				var left = parseInt(index * (options.imgWidth + imgSpace) + hpad);
				$(this).css({position: 'absolute', left: left+'px', top: padding['top']+'px'});
			});			
		});  
	};  
})(jQuery);  

