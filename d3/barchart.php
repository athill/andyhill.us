<?php
include('../inc/setup.inc.php');
$page = new Page(array(
  'jsModules' => array('d3'=>true),
  'scripts' => array('barchart.js'),
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

$h->div('', 'id="viz"');

$h->div('', 'id="dynamic"');


$page->end();
?>