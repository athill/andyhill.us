(function($){  
	$.fn.imageArray = function(options) {
		var defaults = {
			imgWidth: 120
		};
		var options = $.extend(defaults, options);      
		return this.each(function() { 
			var container = $(this); 
			////map of container padding for ease of reference			
			var padding = {};
			$.each("left,bottom,top,right".split(","), function(i, pad) {
				padding[pad] = container
								.css('padding-'+pad)
								.replace(/[a-zA-Z]+/, "");
			});
			////do some calculations
			var hpad = parseInt(padding['left']) + parseInt(padding['right']);
			var vpad = parseInt(padding['top']) + parseInt(padding['bottom']);
			var winWidth = $(this).width() - hpad;
			var numImgs = ($("img", this).length);
			var winSpace = winWidth - options.imgWidth * numImgs;
			var imgSpace = winSpace / (numImgs - 1);
			////Loop thorough images
			$("img", this).each(function(index) {
				var left = parseInt(index * (options.imgWidth + imgSpace) + hpad);
				$(this).css({width: options.imgWidth+'px', position: 'absolute', left: left+'px', top: (vpad/2)+'px'});
			});			
		});  
	};  
})(jQuery);  
