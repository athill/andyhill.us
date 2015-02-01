<?php
class JsModule {
	var $modules;
	var $jquery;
	

	
	function __construct() {
		$this->jquery = array('/js/jquery-1.10.1.min.js');
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
				"scripts" => array("/js/superfish/js/superfish.js","/js/superfish/js/hoverIntent.js"),
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
				// "scripts" => array("http://d3js.org/d3.v3.min.js"),
				"scripts" => array("/js/d3-3.4.3.min.js"),
				"styles" => array("")
			),
			////D3.js
			"d3.geo" => array(
				"scripts" => array("/js/d3.geo.projection.v0.min.js"),
				"styles" => array("")
			),
			////D3.js
			"d3.tip" => array(
				"scripts" => array("/js/d3-tip/index.js"),
				"styles" => array("")
			),			

			"ui" => array(
				"scripts" => array("/js/jquery-ui-1.10.3.custom/js/jquery-ui-1.10.3.custom.min.js"),
				"styles" => array("/js/jquery-ui-1.10.3.custom/css/ui-darkness/jquery-ui-1.10.3.custom.min.css")
			),
			"slideshow" => array(
				//"scripts" => array('/js/reveal.js/js/reveal.min.js'),
				'scripts'=>array(),
				"styles" => array('/js/reveal/css/reveal.min.css','/js/reveal/css/theme/default.css')
			),
			"underscore" => array(
				'scripts'=>array('/js/underscore-min.js'),
				"styles" => array()
			),
			"font-awesome" => array(
				'scripts'=>array(),
				'styles'=>array('/css/font-awesome-4.3.0/css/font-awesome.min.css')
			)
		);
	}
	

}
?>