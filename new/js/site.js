////HTML5 element fix for IE
var html5elems = "header,nav,section,article,figure,legend,aside,footer".split(',');
for (var i = 0; i < html5elems.length; i++) {
	document.createElement(html5elems[i]);
}
/*
$(function() {
	doHeader();
});
*/
