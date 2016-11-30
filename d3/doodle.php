<?php
include('../inc/setup.inc.php');
$page = new Page(array(
	'jsModules' => array('d3'=>true, 'treemenu'=>true),
	'leftSideBar'=>array('type' =>'menu', 'args' => array()),
	'scripts' => array('doodle.js'),
  'headerExtra'=>'<style>
.chart div {
   font: 10px sans-serif;
   background-color: steelblue;
   text-align: right;
   padding: 3px;
   margin: 1px;
   color: white;
}

.chart rect {
   stroke: white;
   fill: steelblue;
}
</style>'	
));

?>
	<h4>Real-time Bar Chart (simulated)</h4>
    <div id="dynamic"></div>

	<h4>Animations</h4>
    <div id="slide"></div>
	<h4>Tabular Data</h4>
	<div id="viz2"></div>
    
<?php
// $template->footer();
$page->end();
?>
