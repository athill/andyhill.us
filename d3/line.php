<?php
$local['jsModules']['d3'] = true;
// $local['jsModules']['ui'] = true;
$local['scripts'] = array('/js/linechart.jquery.js');

include('../inc/application.php');


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

$template->footer();
?>