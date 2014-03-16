Galleria.ready(function(options) {

    // this = the gallery instance
    // options = the gallery options

    this.bind('image', function(e) {
		var data = this.getData(e.index);
       // Galleria.log(data) // the image index
		$("#galleria-title").html(data.title);
		$("#galleria-descr").html(data.description);
    });
});



$(function() {
	$("#galleria").galleria({
		height: 400,
		width: 500,
//		transition: "fadeslide",
//		imageCrop: true,
		showInfo: false
	});
});
