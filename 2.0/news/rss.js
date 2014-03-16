//alert("hi");

 $(document).ready(function() {
   // do stuff when DOM is ready
	$.get("/news/feed.php", { category: $("#select-category").html() }, 
		function(data) {
			$("#rss-feed-container").html(data);
		}
	);
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

	$(".rss-category").click( 
		function() { 
			$("#select-category").html($(this).html());

			$.get("/news/feed.php", { category: $(this).html() }, 
				function(data) {
					$("#rss-feed-container").html(data);
				}
			);
			$(this).html('<span style="color: white; background: red;">wait</span>');			
		}
	);
 });

function initLinks() {
	$(".rss-links").tooltip(  {
				bodyHandler: function() {
					return "<strong>" + $(this).attr("rel") + "</strong>" + 
						"<br /><br />" + 
						$(this).next().text();
				}, 
				showURL: false
	});
	$(".rss-category").css("background", "gray");
	$("#rss-category-" + $("#select-category").html()).css("background", "white");
	$("#rss-category-" + $("#select-category").html()).html($("#select-category").html());
}




