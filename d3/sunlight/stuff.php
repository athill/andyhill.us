<?php
include_once('../../inc/application.php');

/*$api_key = '0f9d6efec2874d029e55c76f67f08a88';
$baseurl = 'http://api.realtimecongress.org/api/v1/';

$data = json_decode(file_get_contents($baseurl.'bills.json?apikey='.$api_key.'&bill_id=hr3261-112'), true);*/

require_once($GLOBALS['site']['fileroot'].'/inc/api/Sunlight.class.php');
$sun = new Sunlight();




$data = $sun->get('realtime', 'floor_updates', array());
$h->pa($data);
exit(1);


$h->otable('border="1"');
$headers = explode(',', 'Date,Time,Event,Bills');
foreach ($headers as $header) {
	$h->th($header);
}
foreach ($data['floor_updates'] as $update) {
	$h->cotr();
	$date = formatDate($update['legislative_day']);
	$h->td($date);
	$h->td(getTime($update['timestamp']));
	$h->startBuffer();
	$h->liArray('ol', $update['events']);
	$h->td($h->endBuffer());
	$h->startBuffer();
	$h->liArray('ol', $update['bill_ids']);
	$h->td($h->endBuffer());	
}	
$h->ctable();
$template->footer();


function formatDate($datestring) {
	return $datestring;
	return date('m/d/Y', strftime($datestring));
}

function getTime($timestamp) {
	
}

?>