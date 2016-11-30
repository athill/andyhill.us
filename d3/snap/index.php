<?php
include('../../inc/setup.inc.php');
$page = new Page(array(
	'jsModules' => array('d3'=>true, 'treemenu'=>true),
	'leftSideBar'=>array('type' =>'menu', 'args' => ['path' => '/d3/']),
));


$h->tnl('Source: ');
$link = "http://www.fns.usda.gov/pd/SNAPsummary.htm";

$h->a('http://www.fns.usda.gov/pd/SNAPsummary.htm', 'http://www.fns.usda.gov/pd/SNAPsummary.htm', 'target="_blank"');
$h->br();	
$h->a('http://www.census.gov/population/www/documentation/twps0056/tab01.xls');

$h->div('', 'id="cost"');

$h->div('', 'id="participation"');

$h->div('', 'id="percent"');


$h->scriptfile(array('/js/linechart.jquery.js', 'snap.js'));

$page->end();
?>