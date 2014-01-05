<?php
include_once('../../inc/setup.inc.php');
$page = new Page();

/*$api_key = '0f9d6efec2874d029e55c76f67f08a88';
$baseurl = 'http://api.realtimecongress.org/api/v1/';

$data = json_decode(file_get_contents($baseurl.'bills.json?apikey='.$api_key.'&bill_id=hr3261-112'), true);*/

$h->p("Proof of concept. I'd like to expand into state reps, but that at least requires an actual address. 
	Even using zip code on the national level can return more than one representative. Main point is that 
	I'm retrieving data from  <a href=\"http://services.sunlightlabs.com/\" target=\"_blank\">Sunlight Foundation</a> and trying to make it useful. There are other exciting resources such as legislative 
	agenda, transparency, etc., but not bad for a first foray. Hoping to integrate some data with <a href=\"http://d3js.org/\" target=\"blank\">D3.js</a> for cool visuals at some point.");


$h->oform('', 'get');
$h->label('zip', 'Search by zip code:');
$h->intext('zip', array_key_exists('zip', $_GET) ? $_GET['zip'] : '');
$h->input('submit', 's', 'Search');
$h->cform();

if (array_key_exists('zip', $_GET)) {
	require_once($GLOBALS['site']['fileroot'].'/inc/api/Sunlight.class.php');
	$sun = new Sunlight();	
	$data = $sun->get('congress', 'legislators.allForZip', array('zip'=>$_GET['zip']));
	//print_r($data);
	$h->br(2);
	$h->tnl('<strong>Your federal representatives:</strong>');
	foreach ($data['response']['legislators'] as $j => $leg) {
		$d = $leg['legislator'];
		// foreach ($d as $k => $v) {
		// 	$h->tbr($k.'='.$v);
		// }
		render($d);
		$h->hr();
	}
}

function render($item) {
	global $h, $sun;
	$h->otable();
	$fields = array(
		'Name' => $sun->getFullName($item),
		'Chamber' => ucfirst($item['chamber']),
		'District' => $item['district'],
		'Party' => $item['party'],
		'Address' => $item['congress_office'],
		'Webform' => $item['webform'],
		'Phone' => $item['phone'],
		'YouTube' => $item['youtube_url'],
		'Congresspedia' => $item['congresspedia_url'],
		'Twitter' => strlen($item['twitter_id']) ? 'https://twitter.com/'.$item['twitter_id'] : '',
		'Facebook' => (strlen($item['facebook_id'])) ? 'https://www.facebook.com/'.$item['facebook_id'] : ''
	);
	$count = 0;
	foreach ($fields as $label => $value) {
		if ($count > 0) $h->cotr();
		$h->th($label.': ', 'align="left"');
		if (preg_match('/^https?:/', $value)) {
			$h->startBuffer();
			$h->a($value, $value, 'target=_blank');
			$value = $h->endBuffer();
		}
		$h->td($value);
		$count++;
	}
	$h->ctable();
}








$page->end();
?>