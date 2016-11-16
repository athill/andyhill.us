////HTML5 element fix for IE
var html5elems = "header,nav,section,article,figure,legend,aside,footer".split(',');
for (var i = 0; i < html5elems.length; i++) {
	document.createElement(html5elems[i]);
}

////Console.log fix for IE
if ( ! window.console ) console = { log: function(){} };

$(function() { 	
	if (typeof $.doubleTapToGo === "object") {
		$( '#nav li:has(ul)' ).doubleTapToGo();
	}
	////tree menu
	if (typeof $.treeview === "object") {
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
