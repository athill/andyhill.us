////HTML5 element fix for IE
var html5elems = "header,nav,section,article,figure,legend,aside,footer".split(',');
for (var i = 0; i < html5elems.length; i++) {
	document.createElement(html5elems[i]);
}

////Console.log fix for IE
if ( ! window.console ) console = { log: function(){} };

$(function() { 	
	$('ul.sf-menu').superfish({ autoArrows: false });
	var kids = $('ul#global-nav-menu:first').children();
	var width = ($("#global-nav").width()/kids.length) - 2;
	kids.css('width', width);			
	$(window).resize(function() {
		var width = ($('#global-nav:first').width()/kids.length) - 2;
		kids.css('width', width);													  
	});
	////tree menu
	if (typeof $.treeview == "object") {
		$("#lsb-menu").treeview({
			collapsed: true,
			persist: "cookie"
		});
	}
	////Geek out
	$('#geek-out-button').click(function() {
		$('#geek-out-content').toggleClass("hide");
	});
});


/*
$(function() {
	doHeader();
});
*/
