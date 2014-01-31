<?php
require_once('../inc/setup.inc.php');

$page = new Page(array(
	'jsModules'=>array('ui'=>true),
));

require_once(dirname($GLOBALS['site']['fileroot']).'/inc/api/Sunlight.class.php');
$sun = new Sunlight();

$meta = $sun->get('openstates', '/metadata', array());

$options = array();
foreach ($meta as $item) {
	$options[] = $item['abbreviation'].'|'.$item['name'];
}

$h->oform('', 'get');
$h->label('state', 'Select a state:');
$h->select('state', $options, $h->getVal('state'), '', true);
$h->submit('s', 'View Bills');
$h->cform();

// $h->pa($meta);

if (array_key_exists('state', $_GET)) {
	$state = $_GET['state'];
	$cachefile = 'cache/'.$state.'.html';
	///// file exists and is less than an hour old
	if (file_exists($cachefile) && time() - filemtime($cachefile) < 3600) {
		$content = file_get_contents($cachefile);
		echo $content;
	} else {
		$dateformat = 'm/d/Y G:ia';
		$data = $sun->get('openstates', '/bills', array('state'=>$_GET['state']));
		// $h->pa($data);
		// exit();
		$tdata = array();
		foreach ($data as $item) {
			$url = 'http://openstates.org/'.$_GET['state'].'/bills/'.$item['session'].'/'.str_replace(' ', '', $item['bill_id']);
			$title = str_replace('"', '&quot;', $item['title']);
			$tdata[] = array(
				'<a href="'.$url.'" target="_blank" title="'.$item['title'].'" class="bill-link">'.$item['bill_id'].'</a>',
				date($dateformat, strtotime($item['created_at'])),
				date($dateformat, strtotime($item['updated_at'])),
				//$item['title'],
				implode(', ', $item['type']),
				(array_key_exists('subjects', $item))? implode(', ', $item['subjects']) : '',

			);
		}
		$h->startBuffer();
		$h->simpleTable(array(
			'headers'=>array('Bill', 'Created', 'Updated', 'Type', 'Subjects'),
			'data'=>$tdata,
			'atts'=>'class="data-table"'
		));
		$content = $h->endBuffer();
		file_put_contents($cachefile, $content);
		echo $content;
	}
}

$h->script('
$(function() {
	$(".bill-link").tooltip();
});
');



// 

$page->end();
?>