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
				"styles" => array("/js/jquery-tooltip/jquery.tooltip.css",
							"/js/jquery-tooltip/demo/screen.css")
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
			////Dirty forms
			"dirtyform" => array(
				"scripts" => array("/js/jquery.dirtyforms.js"),
				"styles" => array("")
			),


		);
	}
	

}
?>