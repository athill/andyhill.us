Galleria.ready(function(options) {
    this.bind('image', function(e) {
       Galleria.log(e.galleriaData.original.title);
		$("#galleria-title").html(e.galleriaData.original.title);
		$("#galleria-descr").html(e.galleriaData.original.alt);
    });
});

$(function() {
	  Galleria.loadTheme(webroot + '/js/galleria/themes/classic/galleria.classic.min.js');
	  Galleria.run('#galleria', {
	  	responsive: true
	  });
});
