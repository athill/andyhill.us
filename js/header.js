//var imgWidth = 120;
//var imgHeight = 90;
$(function() {
	$(window).bind("load resize",  function() {
		$("#img-container").imageArray();
/*
		var padding = {};
		var paddings = "left,bottom,top,right".split(",");
		for (var i = 0; i < paddings.length; i++) {
			var pad = paddings[i];
			padding[pad] = $("#img-container")
				.css('padding-'+pad)
				.replace(/[a-zA-Z]+/, "");
		}
		var hpad = parseInt(padding['left']) + parseInt(padding['right']);
		var vpad = parseInt(padding['top']) + parseInt(padding['bottom']);
//		alert(padding['left']);
		var winWidth = $("#img-container").width() - hpad;
		
		var numImgs = ($(".header-img").length);
		var winSpace = winWidth - imgWidth * numImgs;
		var imgSpace = winSpace / (numImgs - 1);
		$(".header-img").each(function(index) {
			var left = parseInt(index * (imgWidth + imgSpace) + hpad);
			$(this).css("left", left+'px');
			$(this).css("top", padding['top']+'px');
		});
*/	
	});

});

(function($){  
	$.fn.imageArray = function(options) {
		var defaults = {
			imgWidth: 120
		};
		var options = $.extend(defaults, options);      
		return this.each(function() { 
			var container = $(this); 
			var padding = {};
			$.each("left,bottom,top,right".split(","), function(i, pad) {
				padding[pad] = container
					.css('padding-'+pad)
					.replace(/[a-zA-Z]+/, "");
			});
			var hpad = parseInt(padding['left']) + parseInt(padding['right']);
			var vpad = parseInt(padding['top']) + parseInt(padding['bottom']) + 10;
			var winWidth = $(this).width() - hpad;
			var numImgs = ($("img", this).length);
			var winSpace = winWidth - options.imgWidth * numImgs;
			var imgSpace = winSpace / (numImgs - 1);
			$("img", this).each(function(index) {
				var left = parseInt(index * (options.imgWidth + imgSpace) + hpad);
				$(this).css({width: options.imgWidth+'px', position: 'absolute', left: left+'px', top: (vpad/2)+'px'});
			});			
		});  
	};  
})(jQuery);  


