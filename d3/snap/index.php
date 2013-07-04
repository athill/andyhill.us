<?php
$local['jsModules']['d3'] = true;
include('../../inc/application.php');



$h->tnl('Source: ');
$link = "http://www.fns.usda.gov/pd/SNAPsummary.htm";

$h->a('http://www.fns.usda.gov/pd/SNAPsummary.htm', 'http://www.fns.usda.gov/pd/SNAPsummary.htm', 'target="_blank"');
$h->br();	
$h->a('http://www.census.gov/population/www/documentation/twps0056/tab01.xls');

$h->div('', 'id="cost"');

$h->div('', 'id="participation"');

$h->div('', 'id="percent"');

// $h->script("$('#line-chart').linechart({
// 	csv: '/andyhill/d3/data/us_population.csv',
// 	fields: [
//         { name: 'total', 
//           color: 'blue', 
//           label: 'Total',
//           title: function(d) { return d.x + ' - ' + addCommas(d.total) }
// 		},
//         { name: 'white', 
//           color: 'red', 
//           label: 'Whites',
//           title: function(d) { return d.x + ' - ' + addCommas(d.white) }
// 		},
//         { name: 'black', 
//           color: 'white', 
//           label: 'Black',
//           title: function(d) { return d.x + ' - ' + addCommas(d.black) }
// 		},				
// 	],
// 	title: 'U.S. Population',
// 	yPadding: 100,
// 	xPadding: 100,

// })");


$h->scriptfile(array('/js/linechart.jquery.js', 'snap.js'));

$template->footer();
?>