var template;

$(document).ready(function() {
	//// namespace in template
	_.templateSettings.variable = "rc";
	
	//// load template
	template = _.template($("#feeds").html());
	/////////////////////////////
	///// Tab Navigation
	/////////////////////////////
	var defaultCategory = "Wires";
	var category = defaultCategory;

	$(window).bind('hashchange', function(e) {
		if (location.hash !='') {
			category = location.hash.replace("#", "");
		} else {
			category = defaultCategory;
		}
		var tab = $("#feed-category-"+category);
		setCategory(tab, category);		
	});

	$(window).trigger( 'hashchange' );

	$('.feed-category').click(function(e) {
		location.hash = $(this).attr('id').replace('feed-category-', '');
		// setCategory($(this), $(this).attr('id').replace('feed-category-', ''));
	})
	

	//// Open/close all entries in a feed
	$(document).on("click", ".feed-toggleall", 
		function() {
			var id = $(this).attr("id").split("_");
			var index = id[1];
			var thisClass =  ".feed-descriptions_" + index;
			if ($(this).html() == "expand all") {
				$(".feed-descriptions_" + index).show();
				$(this).html("collapse all");
			} else {
				$(".feed-descriptions_" + index).hide();	
				$(this).html("expand all");
			}
			return false;
		}
	);
 });

function setCategory($element, category) {
	
	$element.data('category', category);
	$.getJSON("feed.php", { category: category }, 
		function(data) {
			$( "#rss-feeds" ).html(
				template( data )
			);
			initLinks($element);		
		}
	);
	$element.html('Loading');
	$element.addClass('wait');

}



function initLinks($element) {
	////Initialize tooltip
	$('.feed-links').tooltip({
		content: function() {
			return '<h4>'+ $(this).html() + '</h4>'+$(this).attr('href')+'<br><br>'+$(this).next().html();
		}
	});
	////color tabs
	$(".feed-category").removeClass("active");
	$element.removeClass('wait');
	$element.addClass("active");
	//// Revert text to category
	$element.html($element.data("category"));
}
<<<<<<< HEAD
//// TODO: SCOPE
=======
//// Not used
>>>>>>> 7842472cc6c0e9b3a367fd0238969f9cd16eec59
var news = {
	clean: function(str) {
		str.replace(/&lt;/g, '<')
			.replace(/&gt;/g, '>')
			.replace(/<!\[CDATA\[/g, '')
			.replace(/\]\]>/g, '');
	}
}





