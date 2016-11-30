<?php
include('../inc/setup.inc.php');
$page = new Page(array(
	'jsModules' => array('d3'=>true, 'treemenu'=>true),
	'leftSideBar'=>array('type' =>'menu', 'args' => array()),
));


$sources = array('http://www.whitehouse.gov/sites/default/files/omb/budget/fy2013/assets/hist01z1.xls');

sources($sources);	

function sources($sources) {
	global $h;
	$h->h(5, 'Sources:');
	foreach($sources as $i => $source) {
		$h->startBuffer();
		$h->a($source, $source, 'target="_blank"');
		$sources[$i] = trim($h->endBuffer());
	}
	$h->liArray('ul', $sources);
}


$h->div('', 'id="line-chart"');


$link = 'http://www.verisi.com/resources/d3-tutorial-basic-charts.htm#s2';
$h->tbr('Modified from <a href="'.$link.'" target="_blank">'.$link.'</a>.');


$h->scriptfile(array('/js/linechart.jquery.js', 'line.js'));

$page->end();
?>