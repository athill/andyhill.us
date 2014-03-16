<?php
require_once('../../../inc/setup.inc.php');
$page = new Page();
////Select category
$h->oform("");
$h->select('category', array('family','nationalmall'), $h->getVal('category'));
$h->input('submit', 's', 'Select');
$h->cform();

echo crypt('apennyforyourthoughts');

if (!array_key_exists('category', $_POST)) {
	$template->footer();
	exit(1);
}
////Category selected
$category = $_POST['category'];

$dir = '../../img/'.$category.'/';

//$h->tbr($incroot.'/uft/Render.class.php');
//require_once($incroot.'/uft/Render.class.php') or die('fail');



$h->oform("submit.php");
//echo '<select name="file">';
$files = array();
foreach (new DirectoryIterator($dir) as $file) {
   // if the file is not this file, is not a dreictory, and does not start with a '.' or '..',
   // then store it for later display
   if (!$file->isDir() && (!$file->isDot()) && ($file->getFilename() != basename($_SERVER['PHP_SELF'])) ) {
		$files[] = $file->getFilename();
		
	}
}
$data = array();
$datafile = '../../data.json';
if (file_exists($datafile)) {
	$data1 = json_decode(file_get_contents($datafile), true);
}
$data = $data1[$category];
$h->pa($data);
//exit(1);

sort($files);
$h->otable();
foreach ($files as $i => $filename) {
		$name = preg_replace("/\.\w+$/", "", $filename);		
//		$h->odiv('style="border: thin solid black; padding: 1em;"');
		if ($i > 0) $h->corow();
		$h->otd();
		$h->img($dir.$filename, $filename);		
		$h->ctd();				
		$h->otd();
		$h->tbr($name);
		$h->label($name.'_title', 'title: ');
		$value = str_replace('\"', '"', getVal('title', $data[$i]));
		$value = str_replace("\\'", "'", $value);
		$h->intext($name.'_title', $value);
		$h->br();
		$h->label($name.'_descr', 'description: ');
		$h->br();
		$value = str_replace('\"', '"', getVal($name, $data[$i]));
		$value = str_replace("\\'", "'", $value);
		$h->textarea($name.'_descr', $value);
		$h->br();
		$h->input('checkbox', $name.'_delete');
		$h->label($name.'_delete', 'delete');
		$h->br();
		$h->label($name.'_rotate', '<strong>Rotate: </strong>');
		$h->choicegrid(array('type'=>'radio','name'=>$name.'_rotate', 
			'vals'=>array('clockwise|Clockwise', 'counter|Counter-clockwise', 'invert|Invert')));
		//$h->input('checkbox', $name.'_rotate');

		$h->ctd();

}
$h->ctable();
$h->input('hidden', 'filelist', implode(",", $files));
$h->input('hidden', 'dir', $dir);
$h->input('hidden', 'category', $category);
$h->input('submit', 's', 'Generate XML');
$h->cform();

function getVal($name, $array) {
	return (array_key_exists($name, $array)) ? $array[$name] : "";
}

$page->end();   

?>
