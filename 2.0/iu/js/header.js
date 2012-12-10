//alert('here');
function getWindowWidth() {
  var myWidth = 0, myHeight = 0;
  if( typeof( window.innerWidth ) == 'number' ) {
    //Non-IE
    myWidth = window.innerWidth;
    myHeight = window.innerHeight;
  } else if( document.documentElement && ( document.documentElement.clientWidth || document.documentElement.clientHeight ) ) {
    //IE 6+ in 'standards compliant mode'
    myWidth = document.documentElement.clientWidth;
    myHeight = document.documentElement.clientHeight;
  } else if( document.body && ( document.body.clientWidth || document.body.clientHeight ) ) {
    //IE 4 compatible
    myWidth = document.body.clientWidth;
    myHeight = document.body.clientHeight;
  }
  //window.alert( 'Width = ' + myWidth );
  //window.alert( 'Height = ' + myHeight );
  return myWidth;
}

var imgWidth = 120;
var imgHeight = 90;

$(window).bind("load resize",  function(){
	var winWidth = $("#headerContainer").width();
	var numImgs = ($(".headerImg").length);
	var winSpace = winWidth - imgWidth * numImgs;
	var imgSpace = winSpace / (numImgs - 1);
	for (var i = 1; i < (numImgs); i++) {
		$("#headerImg" + i).css("left", i * (imgWidth + imgSpace));
	}
	
});


function doHeader(e) {
	var winWidth = getWindowWidth();
	var imgWidth = 120;
	var imgHeight = 90;
	var imgDir = '/images/header/';
	var images = Array('house.jpg',
					'band.jpg',
					'showwater.jpg', 
					'wfhb.jpg'
	);
	var imgsWidth = imgWidth * images.length;
	var winSpace = winWidth - imgsWidth;
	var imgSpace = winSpace / (images.length - 1);
	imgSpace -= 10;
	var parent = document.getElementById('headerContainer');
	var child = '';
	if (document.getElementById('child')) {
		child = document.getElementById('child');
		parent.removeChild(child);
	}
	child = document.createElement('div');
	child.setAttribute('id', 'child');
	for (var i = 0; i < images.length; i++) {
		var img = document.createElement('img');
		img.setAttribute('src', imgDir + images[i]);
		img.style.cssText = 'float: left; width:' + imgWidth + 'px; display: block;' + 
			'height: ' + imgHeight + 'px;';
		child.appendChild(img);
		if (i < images.length - 1) {
			var space = document.createElement('div');
			space.style.cssText = 'float: left; width: ' + imgSpace + 'px;';
			space.innerHTML ='&nbsp;';
			child.appendChild(space);
		}
	}
	var head = document.createElement('div');
	head.style.cssText = 'position: absolute; left: 1px; top: 1px; color: #FFF;' + 
		' font: italic bold 20pt arial; padding: 5px;';
//	alert(header);
	head.innerHTML = header;
	child.appendChild(head);
	var drop = document.createElement('div');
	drop.style.cssText = 'position: absolute; left: 0px; top: 0px; color: #700;' + 
		' font: italic bold 20pt arial; padding: 5px;';
//	alert(header);
	drop.innerHTML = header;
	child.appendChild(drop);
	parent.appendChild(child);
}

//window.onresize = doHeader;
