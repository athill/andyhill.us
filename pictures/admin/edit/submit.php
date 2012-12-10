<?php
//echo 'here';
$local['template'] = "Basic";
require_once('../../../inc/application.php');

////path to images from main application
$imagedir = 'img/'.$category.'/';

$bin = '/usr/bin/';

if (array_key_exists('filelist', $_POST)) {
	$data = array();
	$filelist = explode(",", $_POST['filelist']);
//	$data['filelist'] = $_POST['filelist'];
	foreach ($filelist as $i => $filename) {
		$name = preg_replace("/\.\w+$/", "", $filename);
		$h->tbr('<strong>file: '.$name.'</strong>');
		if (array_key_exists($name.'_delete', $_POST)) {
			$h->tbr('deleting');
			if (file_exists($_POST['dir'].$filename)) {
				unlink($_POST['dir'].$filename);
			}
			continue;
		}
		if (array_key_exists($name.'_rotate', $_POST)) {
			$deg = '180';
			$value = $_POST[$name.'_rotate'];
			$filepath = $_POST['dir'].$filename;
			if ($value == 'clockwise') $deg = '90';
			else if ($_POST[$name.'_rotate'] == 'counter') $deg = '-90';
			$command = $bin.'mogrify -rotate '.$deg.' '.$filepath;
			$h->tbr('rotating'.$command);
			$h->img($filepath, $name);
			$result = exec($command, $output);
			echo 'result: '. $result;
			print_r($output);
			////mogrify -rotate 90 file.jpg
			
		}
		$data[$i]['image'] = $imagedir.$filename;
		if (array_key_exists($name.'_title', $_POST)) {
			$data[$i]['title'] = $_POST[$name.'_title'];
		}
		if (array_key_exists($name.'_descr', $_POST)) {
			$data[$i]['description'] = $_POST[$name.'_descr'];
		}
	}
}

//$h->pa($data);
////int file_put_contents ( string $filename , mixed $data [, int $flags = 0 [, resource $context ]] )
$datafile = '../../data.json';
if (file_exists($datafile)) {
	$json = json_decode(file_get_contents($datafile), true);
}

$json[$_POST['category']] = $data;

$h->pa($json);

file_put_contents($datafile, json_encode($json));

$template->footer();

?>
