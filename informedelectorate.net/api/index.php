<?php
require_once('../inc/setup.inc.php');
require_once(dirname($GLOBALS['site']['fileroot']).'/inc/api/Sunlight.class.php');
$data = '{}';
$sun = new Sunlight();
if (isset($_GET['words'])) {
	$data = $sun->getData('capitolwords', 'phrases/legislator', array('phrase'=>$_GET['words']));	
	
} else if (isset($_GET['legislator'])) {
	$data = $sun->getData('congress3', 'legislators', array('bioguide_id'=>$_GET['legislator']));
}
header('Content-Type: application/json');

echo json_encode($data);
