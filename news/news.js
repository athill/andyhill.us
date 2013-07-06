$(document).ready(function() {
	// jQuery.migrateMute = true;
	/////////////////////////////
	///// Tab Navigation
	/////////////////////////////
	var defaultCategory = "Wires";
	var category = defaultCategory;

	$(window).bind('hashchange', function(e) {
		if (location.hash !='') {
			category = location.hash.replace("#", "");
		}
		var tab = $("#rss-category-"+category);
		if (tab.length == 0) {
			tab = $("#rss-category-"+defaultCategory);
				
		}
		setCategory(tab, category);		
	});

	$(window).trigger( 'hashchange' );


	

	///////////////////////////
	//// Open/close all entries in a feed
	///////////////////////////
	$(document).on("click", ".rss-toggleall", 
		function() {
			var id = $(this).attr("id").split("_");
			var index = id[1];
			var thisClass =  ".rss-description_" + index;
			if ($(this).html() == "expand all") {
				$(".rss-descriptions_" + index).show();
				$(this).html("collapse all");
			} else {
				$(".rss-descriptions_" + index).hide();	
				$(this).html("expand all");
			}
			return false;
		}
	);
	/////////////////////
	//// Tab navigation
	///////////////////////
	$(".rss-category").click(function() {
			var category = $.trim($(this).html()); 
			setCategory($(this), category);
		}
	);
 });

function setCategory($element, category) {
	location.hash = category;
	$element.data('category', category);
	$.get("feed.php", { category: category }, 
		function(data) {
			$("#rss-feed-container").html(data);
			initLinks($element);		
		}
	);
	$element.html('<span style="color: white; background: red;">wait</span>');	

}

function initLinks($element) {
	////Initialize tooltip
	$(".rss-links").tooltip(  {
				bodyHandler: function() {
					return "<strong>" + $(this).attr("rel") + "</strong>" + 
						"<br /><br />" + 
						$(this).next().text();
				}, 
				showURL: false
	});
	$(".rss-category").css("background", "gray");
	////color tabs
	$element.css("background", "white");
	$element.html($element.data("category"));
}




