<?php
require_once('../../inc/setup.inc.php');
$page = new Page(array(
	'template'=>'none';
));

$bin = '/usr/bin/';

if (array_key_exists('filelist', $_POST)) {
	$data = array();
	$filelist = explode(",", $_POST['filelist']);
	foreach ($filelist as $filename) {
		$name = preg_replace("/\.\w+$/", "", $filename);
		$h->tbr('<strong>file: '.$name.'</strong>');
		if (array_key_exists($name.'_delete', $_POST)) {
			$h->tbr('deleting');
			if (file_exists($_POST['dir'].$filename)) {
				unlink($_POST['dir'].$filename);
			}
			continue;
		}
		if (array_key_exists($name.'_rotating', $_POST)) {
			$h->tbr('rotating');
			$result = exec($bin.'mogrify -rotate 90 '.$_POST['dir'].$filename, $output);
			echo 'result: '. $result;
			print_r($output);
			////mogrify -rotate 90 file.jpg
			
		}
		if (array_key_exists($name.'_title', $_POST)) {
			$data[$name.'_title'] = $_POST[$name.'_title'];
		}
		if (array_key_exists($name.'_descr', $_POST)) {
			$data[$name.'_descr'] = $_POST[$name.'_descr'];
		}
	}
}

////int file_put_contents ( string $filename , mixed $data [, int $flags = 0 [, resource $context ]] )
file_put_contents('data.json', json_encode($data));

$page->end();

?>
