/*
var imgWidth = 120;
var imgHeight = 90;

$(window).bind("load resize",  function(){
	var winWidth = $("#header").width();
	var numImgs = $(".header-img").length;
	var winSpace = winWidth - (imgWidth * numImgs);
	var imgSpace = winSpace / (numImgs - 1);
	var offset = imgWidth + imgSpace;
	$("#header").children(".header-img").each(
		function(i) {
			$(this).css("left", i * offset);	
	});
});
*/
