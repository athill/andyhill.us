<?php
require_once('../inc/setup.inc.php');

$page = new Page(array(
	'jsModules'=>array('d3'=>true, 
						'd3.geo'=>true,
						'd3.tip'=>true
	),
	'stylesheets'=>array('styles.css')
));



$h->p('Use the radio buttons on the right to view the various combinations of per capita state and local tax burdens. Lighter shades indicate lower taxes. Hover over a state to see its per capita tax burden for the selected combination. Except for Total, I\'ve offered all combinations of the other fields to see how various tax types accumulate when combined.');

$combos = array();
$areas = array('Income', 'Sales', 'Property', 'Corporate');
$builds = array();
foreach ($areas as $area) {
	$combos[] = array($area=>1);
	foreach ($areas as $area2) {
		if ($area == $area2) continue;
		$check = array(
			$area => 1,
			$area2 => 1,
		);
		if (!in_array($check, $combos)) {
			$combos[] = $check;
		}
		if (!in_array($check, $builds)) {
			$builds[] = $check;
		}		
		// $h->pa($builds);
		foreach ($builds as $build) {
			$check = array_merge($build, array($area2=>1));
			if (!in_array($check, $combos)) {
				$combos[] = $check;
			}
		}
	}
}

$categories = array();
foreach ($combos as $combo) {
	$categories[] = implode('+', array_keys($combo));
}
$categories[] = implode('+', $areas);
$categories[] = 'Total';
sort($categories);
$h->otabletr('id="interface-container"');
//// Map
$h->td('', 'id="state_map"');
//// Options
$opts = array();
foreach ($categories as $category) {
	$opts[] = strtolower($category).'|'.$category;
}
$h->otd();
$h->h5('Category');
$h->choicegrid(array(
						'type'=>'radio',
						'numCols'=>2,
						'container'=>'table',
						'name'=>'option', 
						'vals'=>$opts,
						'selected'=>array('income+sales+property+corporate')
				)
);
$h->ctd();
$h->ctrtable('/#interface-container');

$h->p('<small>Source: US Census Bureau, 2011 reports.<br />
* The US Census Bureau does not classify revenue from Texas’s margin tax as corporate income tax revenue.<br />
Note: "$0" means no tax was collected or the amount was too insignificant to count.<br />
State Tax Collections per Capita by Category, 2011</small>');


$h->p('I found '.hlink('http://mercatus.org/publication/primer-state-and-local-tax-policy-trade-offs-among-tax-instruments', 'this report from Mercatus on the Trade-Offs among Tax Instruments') .' and found it interesting. The report is more than these numbers, looking at various tax instruments in '.hlink('http://mercatus.org/sites/default/files/Ross_PrimerTaxPolicy_summary_v1(KP).pdf', 'terms of revenue collected, collection costs, fairness, transparency, and minimizing distortions to the economy').' The actual data used here is from '.hlink('http://mercatus.org/sites/default/files/Ross_PrimerTaxPolicy_v2.pdf', 'page 33 of this PDF').'. I believe Mr. Ross got his numbers by merging U.S. Census '.hlink('http://www.census.gov/govs/statetax/', 'state government tax collections').' with '.hlink('http://www.census.gov/popest/data/state/totals/2013/index.html', 'state populations').' among other data. I\'m not sure how he calculated his totals. For example, Alaska has corportate taxes of $1003 per capita, income taxes of $0 per capita, sales tax of $0 per capita, and property tax of $255 per capita, yet has a total of $7708. So all the other $6550 is in some other tax category? This makes me want to redo the report using official Census data, but in the mean time, it\'s too cool not to publish.');

$h->p('This was created using the '.hlink('http://d3js.org/', 'D3').' and '.hlink('http://jquery.com/', 'jQuery').' libraries and the '.hlink('http://geojson.org/', 'GeoJson').' encoding format. I learned a lot of what is used here in the book '.hlink('http://shop.oreilly.com/product/0636920026938.do', ' Interactive Data Visualization for the Web ').'.');


$h->script('var data = '.file_get_contents('data.json').';');
$h->scriptfile('scripts.js');

?>
<div id="tooltip" class="hidden">
	<p><strong>Important Label Heading</strong></p>
	<p><span id="value">100</span>%</p>
</div>
<?php

$page->end();

function hlink($href, $display='') {
	global $h;
	if ($display == '') $display = $href;
	return $h->rtn('a', array($href, $display, 'target="_blank"'));
}


// 

// http://bl.ocks.org/mbostock/4090848

?>