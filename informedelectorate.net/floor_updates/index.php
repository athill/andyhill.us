<?php
include_once('../inc/setup.inc.php');
$page = new Page();

/*$api_key = '0f9d6efec2874d029e55c76f67f08a88';
$baseurl = 'http://api.realtimecongress.org/api/v1/';

$data = json_decode(file_get_contents($baseurl.'bills.json?apikey='.$api_key.'&bill_id=hr3261-112'), true);*/

require_once(dirname($GLOBALS['site']['fileroot']).'/inc/api/Sunlight.class.php');
$sun = new Sunlight();




$data = $sun->get('realtime', 'floor_updates', array());
// $h->pa($data['floor_updates']);


$tdata = array();
foreach ($data['floor_updates'] as $update) {
	// $h->cotr();
	// $date = formatDate($update['legislative_day']);
	$bills = array();
	foreach ($update['bill_ids'] as $bill) {
		$bills[] = array('href'=>'http://www.opencongress.org/bill/'.$bill.'/show', 
				'display'=>$bill,
				'atts'=>'target="_blank"'

		);
	}
	$tdata[] = array(
		getTime($update['timestamp']),
		ucfirst($update['chamber']),
		trim($h->rtn('liArray', array('ol', $update['events']))),
		trim($h->rtn('linkList', array($bills)))
	);
}	

$h->simpleTable(array(
	'headers'=>array('Date', 'Chamber', 'Event', 'Bills'),
	'data'=>$tdata,
	'atts'=>'border="1"'
));
// $h->ctable();
$page->end();


function formatDate($datestring) {
	// return $datestring;
	return preg_replace('/(\d{4})-(\d{2})-(\d{2})/', '$2/$3/$1', $datestring);
	return date('m/d/Y', strftime($datestring));
}

function getTime($timestamp) {
	return date('m/d/Y G:ia', strtotime($timestamp));
}

?>