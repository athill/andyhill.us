<?php
require_once('inc/setup.inc.php');
$page = new Page();
/*$api_key = '0f9d6efec2874d029e55c76f67f08a88';
$baseurl = 'http://api.realtimecongress.org/api/v1/';

$data = json_decode(file_get_contents($baseurl.'bills.json?apikey='.$api_key.'&bill_id=hr3261-112'), true);*/

$h->p('Welcome to '.$site['siteName'].'! The idea of this site is to use technology to enable a more politically 
		informed populace. The data is currently all from from <a href="http://sunlightfoundation.com/api/" target="_blank">the 
	Sunlight Foundation</a>. I\'m hoping to expand on the current offerings, especially drilling down locally and acquiring up-to-the-minute ballot information, so hopefully that will work out.  The current offerings are:');


$pages = array(
	array('href'=>'/reps/', 
			'header'=>'Find Your Federal and State Congressional Representatives', 
			'descr'=>'Type in you address, and via <a href="https://developers.google.com/maps/" target="_blank">Google Maps API</a>, find your local and state representatives. Includes links to websites, twitter, facebook, etc.'),
	array('href'=>'/words/', 
			'header'=>'See What Federal Congressional Representives Are Using Key Words and How Often', 
			'descr'=>'Type in a term and see which representatives are using the term and how often. Bubble Graph generated with <a href="http://d3js.org/" target="_blank">D3.js</a>.'),
	array('href'=>'/floor_updates/', 
			'header'=>'The Federal Congressional Record', 
			'descr'=>'Find out what the House and Senate recorded recently. Includes links to <a href="http://www.opencongress.org/" target="_blank">Open Congress</a> for related bills.'),
	array('href'=>'/state_bills/', 
			'header'=>'Current State Bills', 
			'descr'=>'Current bills in selected state. Includes links to <a href="http://openstates.org/" target="_blank">Open States</a>'),
);

foreach ($pages as $item) {
	$h->h3($h->rtn('a', array('href'=>$item['href'], 'display'=>$item['header'])));
	$h->p($item['descr']);
}


$page->end();

?>