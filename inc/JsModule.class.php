<?php
class JsModule {
	var $modules;
	var $jquery;
	

	
	function __construct() {
		$this->jquery = ['/js/jquery-1.10.1.min.js'];
		$this->modules = [
			//// bootstrap
			'bootstrap' => [
				'scripts' => ['/css/bootstrap/js/bootstrap.min.js'],
				'styles' => ['/css/bootstrap/css/bootstrap.min.css']
			],
					////Tooltip
			"tooltip" => [ 
				"scripts" => ["/js/jquery-tooltip/lib/jquery.bgiframe.js",
								"/js/jquery-tooltip/lib/jquery.dimensions.js",
								"/js/jquery-tooltip/jquery.tooltip.js"],
				"styles" => ["/js/jquery-tooltip/jquery.tooltip.css"]
			],
			////Tree Table
			"treeTable" => [ 
				"scripts" => ["/js/treeTable/src/javascripts/jquery.treeTable.min.js"],
				"styles" => ["/js/treeTable/src/stylesheets/jquery.treeTable.css"]
			],
			////High Charts
			"highcharts" => [
				"scripts" => ["/js/Highcharts-2.1.6/js/highcharts.js"],
				"styles" => [""]
			],
			////superfish
			"popup" => [
				"scripts" => ["/js/superfish/js/superfish.js","/js/superfish/js/hoverIntent.js"],
				"styles" => ["/js/superfish/css/superfish.css"]
			],
			////Galleria
			"galleria" => [
				"scripts" => ["/js/galleria/galleria.min.js"],
				"styles" => []
			],
			////Tree Menu
			"treemenu" => [
				"scripts" => ["/js/jquery.treeview/jquery.treeview.js",
									"/js/jquery.treeview/lib/jquery.cookie.js"
				],
				"styles" => ["/js/jquery.treeview/jquery.treeview.css"]
			],
			////D3.js
			"d3" => [
				// "scripts" => ["http://d3js.org/d3.v3.min.js"],
				"scripts" => ["/js/d3-3.4.3.min.js"],
				"styles" => [""]
			],
			////D3.js
			"d3.geo" => [
				"scripts" => ["/js/d3.geo.projection.v0.min.js"],
				"styles" => [""]
			],
			////D3.js
			"d3.tip" => [
				"scripts" => ["/js/d3-tip/index.js"],
				"styles" => [""]
			],			

			"ui" => [
				"scripts" => ["/js/jquery-ui-1.10.3.custom/js/jquery-ui-1.10.3.custom.min.js"],
				"styles" => ["/js/jquery-ui-1.10.3.custom/css/ui-darkness/jquery-ui-1.10.3.custom.min.css"]
			],
			"slideshow" => [
				//"scripts" => ['/js/reveal.js/js/reveal.min.js'],
				'scripts'=>[],
				"styles" => ['/js/reveal/css/reveal.min.css','/js/reveal/css/theme/default.css']
			],
			"underscore" => [
				'scripts'=>['/js/underscore-min.js'],
				"styles" => []
			],
			"font-awesome" => [
				'scripts'=>[],
				'styles'=>['/css/font-awesome-4.3.0/css/font-awesome.min.css']
			]
		];
	}
}
