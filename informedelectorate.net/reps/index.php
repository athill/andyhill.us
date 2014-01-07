<?php
require_once('../inc/setup.inc.php');
$page = new Page();
/*$api_key = '0f9d6efec2874d029e55c76f67f08a88';
$baseurl = 'http://api.realtimecongress.org/api/v1/';

$data = json_decode(file_get_contents($baseurl.'bills.json?apikey='.$api_key.'&bill_id=hr3261-112'), true);*/

$h->h1('Find Your Representatives');
$h->p('I use <a href="https://developers.google.com/maps/" target="_blank">Google Maps API</a> to translate the address to 
	latitude and longitude and then use data from <a href="http://sunlightfoundation.com/api/" target="_blank">the 
	Sunlight Foundation</a>.');


$h->oform('', 'get');
$h->label('addr', 'Search by address:');
$h->intext('addr', $h->getVal('addr'));
$h->input('submit', 's', 'Search');
$h->cform();

if (array_key_exists('addr', $_GET)) {
	$url = 'http://maps.googleapis.com/maps/api/geocode/json?address='.urlencode($_GET['addr']).'&sensor=false';
	$json = file_get_contents($url);
	$data = json_decode($json, true);
	if (count($data['results']) == 0) {
		$h->div('Invalid Address. Please try again.', 'class="alert"');

	} else {
		$results = $data['results'][0];
		$h->div('Showing results for '.$results['formatted_address']);
		$lat = $results['geometry']['location']['lat'];
		$lng = $results['geometry']['location']['lng'];
		require_once(dirname($GLOBALS['site']['fileroot']).'/inc/api/Sunlight.class.php');
		$sun = new Sunlight();	
		$data = $sun->get('congress3', '/legislators/locate', array('latitude'=>$lat,'longitude'=>$lng));
		$h->div('<strong>Your federal representatives:</strong>');
		foreach ($data['results'] as $leg) {
			render($leg);
			$h->hr();
		}		

		$data = $sun->get('openstates', '/legislators/geo', array('lat'=>$lat,'long'=>$lng));
		// $h->pa($data);
		$h->div('<strong>Your state representatives:</strong>');
		foreach ($data as $leg) {
			$committees = array();
			foreach ($leg['roles'] as $role) {
				if (array_key_exists('committee', $role)) {
					$committees[] = $role['committee'];
				}
			}
			$fields = array(
				'<img src="'.$leg['photo_url'].'" width="50" />'=>$leg['full_name'],
				'District'=>$leg['district'],
				'Party'=>$leg['party'],
				'Website'=>$leg['url'],
				'Chamber'=>ucfirst($leg['chamber']),
				'Phone'=>$leg['offices'][0]['phone'],
				'Committees'=>implode(',', $committees)
			);
			$count = 0;
			$h->otable();
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

		// $h->pa($data);
		// echo 'here';
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
		'Address' => $item['office'],
		'Website' => $item['website'],
		'Phone' => $item['phone'],
		'YouTube' => 'https://www.youtube.com/user/'.$item['youtube_id'],
		'OpenCongress' => 'http://www.opencongress.org/people/show/'.$item['govtrack_id'],
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