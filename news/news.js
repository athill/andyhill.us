$(document).ready(function() {
	/////////////////////////////
	///// Load opening feed set
	///// according to hash, or wires if no hash
	/////////////////////////////
	var defaultCategory = "Wires";
	var category = defaultCategory;
	if (window.location.hash.length) {
		category = window.location.hash.replace("#", "");
	}
	var $element = $("#rss-category-"+category);
	if ($element.length == 0) {
		$element = $("#rss-category-"+defaultCategory);
			
	}
	setCategory($element);

	///////////////////////////
	//// Open/close all entries in a feed
	///////////////////////////
	$(".rss-toggleall").live("click", 
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
		setCategory($(this));
		}
	);
 });

function setCategory($element) {
	var category = $element.html().replace(/\s/g, ''); 
	window.location.hash = category;
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




