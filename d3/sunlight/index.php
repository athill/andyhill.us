<?php
include_once('../../inc/setup.inc.php');
$page = new Page();
/*$api_key = '0f9d6efec2874d029e55c76f67f08a88';
$baseurl = 'http://api.realtimecongress.org/api/v1/';

$data = json_decode(file_get_contents($baseurl.'bills.json?apikey='.$api_key.'&bill_id=hr3261-112'), true);*/

require_once($GLOBALS['site']['fileroot'].'/inc/api/Sunlight.class.php');
$sun = new Sunlight();




$data = $sun->get('capitolwords', 'phrases/legislator', array('phrase'=>'free market'));



$sequence = array();
$results = array();
foreach ($data['results'] as $item) {
	$results[$item['legislator']] = array('count'=>$item['count']);
	// if (count($sequence) == 0) {
	// 	$sequence[] = $item['legislator'];
	// } else {
	// 	$added = false;
	// 	foreach ($sequence as $i => $bioguide_id) {
	// 		if ($item['count'] < $results[$bioguide_id]) {
	// 			array_slice($sequence, $i, 0, $bioguide_id);
	// 			$added = true;
	// 			break;
	// 		}
	// 	}
	// 	if (!$added) {
	// 		array_push($sequence, $bioguide_id);
	// 	}
	// }
}


$tmp = array();
$keys = array_keys($results);
$count = count($keys);
<<<<<<< HEAD
=======
$final = array();
>>>>>>> 7842472cc6c0e9b3a367fd0238969f9cd16eec59
foreach ($keys as $i => $bioguide_id)  {
	$tmp[] = $bioguide_id;
	if ($i % 5 == 0 || $i == $count - 1) {
		//echo 'in here ';
		$data = $sun->get('congress', 'legislators.getList', array('bioguide_id'=>$tmp));
<<<<<<< HEAD
		foreach ($data['response']['legislators'] as $j => $leg) {
			$d = $leg['legislator'];
			//print_r($d);
			$id = $d['bioguide_id'];
			$name = $d['firstname'];
			if ($d['middlename'] != '') $name .= ' '.$d['middlename'];
			if ($d['nickname'] != '') $name .= ' ('.$d['nickname'].')';
			$name .= ' '.$d['lastname'];
			$tmp2 = array(
				'name'=> $name,
				'party'=>$d['party'],
				'chamber'=>$d['chamber'],
				'state'=>$d['state'],
				'district'=>$d['district']
			);
			//print_r($tmp2);
			$results[$id] = array_merge($results[$id], $tmp2);
=======
		// $h->pa($data);
		foreach ($data['response']['legislators'] as $j => $leg) {

			$d = $leg['legislator'];
			if (count($d) > 0) {
				
				$id = $d['bioguide_id'];
				$name = $d['firstname'];
				if ($d['middlename'] != '') $name .= ' '.$d['middlename'];
				if ($d['nickname'] != '') $name .= ' ('.$d['nickname'].')';
				$name .= ' '.$d['lastname'];
				$tmp2 = array(
					'name'=> $name,
					'party'=>$d['party'],
					'chamber'=>$d['chamber'],
					'state'=>$d['state'],
					'district'=>$d['district'],
					'count'=>$results[$id]
				);
				//print_r($tmp2);
				$final[$id] = $tmp2;
			} else {
				// unset($results[$id]);
			}
>>>>>>> 7842472cc6c0e9b3a367fd0238969f9cd16eec59
		}
		$tmp = array();		
	}
}

<<<<<<< HEAD
$h->pa($results);
=======
$h->pa($final);


>>>>>>> 7842472cc6c0e9b3a367fd0238969f9cd16eec59

/*
{"response": 
	{"legislators": 
		[
			{"legislator": 
				{"website": "http://www.durbin.senate.gov", 
				"fax": "202-228-0400", 
				"govtrack_id": "300038", 
				"firstname": "Richard", 
				"chamber": "senate", 
				"middlename": "J.", 
				"lastname": "Durbin", 
				"congress_office": "711 Hart Senate Office Building", 
				"eventful_id": "", 
				"phone": "202-224-2152", 
				"webform": "http://www.durbin.senate.gov/public/index.cfm/contact", 
				"youtube_url": "http://www.youtube.com/SenatorDurbin", 
				"nickname": "Dick", 
				"gender": "M", 
				"district": "Senior Seat", 
				"title": "Sen", 
				"congresspedia_url": "http://www.opencongress.org/wiki/Richard_Durbin", 
				"in_office": true, 
				"senate_class": "II", 
				"name_suffix": "", 
				"twitter_id": "SenatorDurbin", 
				"birthdate": "1944-11-21", 
				"bioguide_id": "D000563", 
				"fec_id": "S6IL00151", 
				"state": "IL", 
				"crp_id": "N00004981", 
				"official_rss": "", 
				"facebook_id": "dickdurbin", 
				"party": "D", 
				"email": "", 
				"votesmart_id": "26847"
				}

			}, 
		...
		]
	}
}
*/




//$data = $sun->get('realtime', 'floor_updates', array('legislative_day'=>'2012-12-30'));

//$data = $sun->get('transparencydata', 'contributions', array('amount'=>'>|100000'));

//$data = $sun->get('openstates', 'legislators', array('state'=>'in'));

// $h->pa($data);

//$h->pa($results);

$page->end();


?>
