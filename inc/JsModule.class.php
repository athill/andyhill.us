<?php
class JsModule {
	var $modules;
	
	function __construct() {
		$this->modules = array(
					////Tooltip
			"tooltip" => array( 
				"scripts" => array("/js/jquery-tooltip/lib/jquery.bgiframe.js",
								"/js/jquery-tooltip/lib/jquery.dimensions.js",
								"/js/jquery-tooltip/jquery.tooltip.js"),
				"styles" => array("/js/jquery-tooltip/jquery.tooltip.css")
			),
			////Tree Table
			"treeTable" => array( 
				"scripts" => array("/js/treeTable/src/javascripts/jquery.treeTable.min.js"),
				"styles" => array("/js/treeTable/src/stylesheets/jquery.treeTable.css")
			),
			////High Charts
			"highcharts" => array(
				"scripts" => array("/js/Highcharts-2.1.6/js/highcharts.js"),
				"styles" => array("")
			),
			////superfish
			"popup" => array(
				"scripts" => array("/js/superfish/js/superfish.js","/js/superfish/js/hoverIntent.js",
								"/js/superfish/js/jquery.bgiframe.min.js"),
				"styles" => array("/js/superfish/css/superfish.css")
			),
			////Galleria
			"galleria" => array(
				"scripts" => array("/js/galleria/galleria-1.2.5.min.js",
								"/js/galleria/themes/classic/galleria.classic.min.js"),
				"styles" => array()
			),
			////Tree Menu
			"treemenu" => array(
				"scripts" => array("/js/jquery.treeview/jquery.treeview.js",
									"/js/jquery.treeview/lib/jquery.cookie.js"
				),
				"styles" => array("/js/jquery.treeview/jquery.treeview.css")
			),
			////D3.js
			"d3" => array(
				"scripts" => array("http://d3js.org/d3.v2.js"),
				"styles" => array("")
			),
			"ui" => array(
				"scripts" => array("/js/jquery-ui-1.10.3.custom/js/jquery-ui-1.10.3.custom.min.js"),
				"styles" => array("/js/jquery-ui-1.10.3.custom/css/ui-darkness/jquery-ui-1.10.3.custom.min.css")
			),
			"slideshow" => array(
				//"scripts" => array('/js/reveal.js/js/reveal.min.js'),
				'scripts'=>array(),
				"styles" => array('/js/reveal.js/css/reveal.min.css','/js/reveal.js/css/theme/default.css')
			)
		);
	}
	

}
?>
