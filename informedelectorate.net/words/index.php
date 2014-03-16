<?php
require_once('../inc/setup.inc.php');

$page = new Page(array(
	'jsModules'=>array('d3'=>true),
));
/*$api_key = '0f9d6efec2874d029e55c76f67f08a88';
$baseurl = 'http://api.realtimecongress.org/api/v1/';

$data = json_decode(file_get_contents($baseurl.'bills.json?apikey='.$api_key.'&bill_id=hr3261-112'), true);*/

$h->h2('Key Words');

$h->p('Use this page to see how many times legislators have used key terms. For example, "free market" or "iraq". 
		Uses the Sunlight <a href="http://sunlightfoundation.com/api/" target="_blank">Capital Words API</a> for the 
		data and <a href="http://d3js.org/" target="_blank">D3.js</a> to render the graph.');
$h->oform('', 'get');
$h->label('words', "Search for key words:");
$h->intext('words', $h->getVal('words'));
$h->submit('s', "Search");
$h->cform();

if (array_key_exists('words', $_GET)) {
	$h->h4('Results for "'.$_GET['words'].'"');
	require_once(dirname($GLOBALS['site']['fileroot']).'/inc/api/Sunlight.class.php');
	$sun = new Sunlight();
	$data = $sun->get('capitolwords', 'phrases/legislator', array('phrase'=>$_GET['words']));

	$h->div('', 'id="chart"');

	$sequence = array();
	$results = array();
	foreach ($data['results'] as $item) {
		$results[$item['legislator']] = array('count'=>$item['count']);
	}

	// print_r($results);


	$tmp = array();
	$keys = array_keys($results);
	$count = count($keys);
	$final = array();
	foreach ($keys as $i => $bioguide_id)  {
		$tmp[] = $bioguide_id;
		if ($i % 5 == 0 || $i == $count - 1) {
			//echo 'in here ';
			$data = $sun->get('congress', 'legislators.getList', array('bioguide_id'=>$tmp));
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
						'lname'=>$d['lastname'],
						'party'=>$d['party'],
						'chamber'=>ucfirst($d['chamber']),
						'state'=>$d['state'],
						'district'=>$d['district'],
						'count'=>$results[$id]['count']
					);
					//print_r($tmp2);
					$final[$id] = $tmp2;
				} else {
					// unset($results[$id]);
				}
			}
			$tmp = array();		
		}
	}

	$graph = array('name'=>'words', 'children'=>array());

	foreach ($final as $key => $value) {
		$graph['children'][] = array(
			'name'=>$key,
			'children'=>array(
				array(
					'name'=>$value['lname']."(".$value['party'].' '.$value['chamber'].' '.$value['state'].')',
					'size'=>$value['count']
				)
			)
		);
	}

	$h->script('var json='.json_encode($graph));
	$h->scriptfile('scripts.js');
}
// $h->pa($final);

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