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
		}
		var tab = $("#feed-category-"+category);
		if (tab.length == 0) {
			tab = $("#feed-category-"+defaultCategory);
				
		}
		setCategory(tab, category);		
	});

	$(window).trigger( 'hashchange' );

	$('.feed-category').click(function(e) {
		setCategory($(this), $(this).attr('id').replace('feed-category-', ''));
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
	location.hash = category;
	$element.data('category', category);
	$.getJSON("feed.php", { category: category }, 
		function(data) {
			$( "#rss-feeds" ).html(
				template( data )
			);
			initLinks($element);		
		}
	);
	$element.html('<span style="color: white; background: red;">wait</span>');	

}



function initLinks($element) {
	////Initialize tooltip
	$('.feed-links').tooltip({
		content: function() {
			return '<h4>'+ $(this).html() + '</h4>' + $(this).next().html();
		}
	});
	$(".feed-category").css("background", "gray");
	////color tabs
	$element.css("background", "white");
	$element.html($element.data("category"));
}
//// TODO: SCOPE
var news = {
	clean: function(str) {
		str.replace(/&lt;/g, '<')
			.replace(/&gt;/g, '>')
			.replace(/<!\[CDATA\[/g, '')
			.replace(/\]\]>/g, '');
	}
}





