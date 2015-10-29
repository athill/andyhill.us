<?php
exit();

session_start();
require('../vendor/autoload.php');

// $lines = file('data.txt');

// $data = [];
// foreach ($lines as $line) {
// 	list($name1, $type1) = explode(';', $line);
	
// 	list($lname, $fname) = explode(',', $name1);
// 	$datum = [
// 		'name'=>trim($fname).' '.trim($lname),
// 		'type'=>($type1 == 'SR') ? 'Referral' : 'Match',
// 		'email'=>''
// 	];
// 	$data[] = $datum;
// }

// file_put_contents('pastor2.json', json_encode($data));
// var_dump($data);

$data = json_decode(file_get_contents('pastors.json'), true);

require('PastorEmail.php');
$pastorEmail = new PastorEmail();

$statuses = [];
foreach ($data as $datum) {
	$email = $datum['email'];
	// $email = 'andy@andyhill.us';
	$statuses[] = $pastorEmail->email($datum['name'], $email, $datum['type']);
}

print_r($statuses);