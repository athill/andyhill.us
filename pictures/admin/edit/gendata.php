<?php
require_once('../../../inc/setup.inc.php');
$page = new Page(array(
	'template'=>'Basic'
));

$rawdata = array(
	'family' => json_decode(file_get_contents('family.json'), true),
	'nationalmall' => json_decode(file_get_contents('nationalmall.json'), true)
);

//$h->pa($rawdata);

$data = array();

foreach ($rawdata as $category => $arr) {
	$data[$category] = array();
	$files = explode(",", $arr['filelist']);
	foreach ($files as $file) {
		$name = preg_replace("/\.\w+$/", "", $file);
		$title = $rawdata[$category][$name.'_title'];
		$descr = $rawdata[$category][$name.'_descr'];
		$data[$category][] = array(
			'image'=>'img/'.$category.'/'.$file,
			'title'=>$title,
			'description'=>$descr
		);
	}
}

//$h->pa($data);
file_put_contents('../../data.json', json_encode($data));

$page->end();


/*
var data = [
    {
        image: 'img1.jpg',
        thumb: 'thumb1.jpg',
        big: 'big1.jpg',
        title: 'my first image',
        description: 'Lorem ipsum caption',
        link: 'http://domain.com'
    },

*/
?>