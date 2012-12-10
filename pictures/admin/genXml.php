<?php
require_once('../../inc/application.php');
$dir = '../img/nationalmall/';
$h->oform("genXml_submit.php");
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
if (file_exists('data.json')) {
	$data = json_decode(file_get_contents('data.json'), true);
}
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
		$h->intext($name.'_title', getVal($name.'_title', $data));
		$h->br();
		$h->label($name.'_descr', 'description: ');
		$h->br();
		$h->textarea($name.'_descr', str_replace('\"', '"', getVal($name.'_descr', $data)));
		$h->br();
		$h->input('checkbox', $name.'_delete');
		$h->label($name.'_delete', 'delete');
		$h->br();
		$h->input('checkbox', $name.'_rotate');
		$h->label($name.'_delete', 'rotate');
		$h->ctd();

}
$h->ctable();
$h->input('hidden', 'filelist', implode(",", $files));
$h->input('hidden', 'dir', $dir);
$h->input('submit', 's', 'Generate XML');
$h->cform();

function getVal($name, $array) {
	return (array_key_exists($name, $array)) ? $array[$name] : "";
}

$template->footer();   


/*
class SortableDirectoryIterator implements IteratorAggregate {

    private $_storage;

    public function __construct($path) {
	    $this->_storage = new ArrayObject();
	    $files = new DirectoryIterator($path);

	    foreach ($files as $file) {
	        $this->_storage->offsetSet($file->getFilename(), $file->getFileInfo());
	    }

////here's the problem
	    $this->_storage->uksort(
	        function ($a, $b) {
	            return strcmp($a, $b);
	        }
	    );
////end problem
    }

    public function getIterator() {
	    return $this->_storage->getIterator();
    }

}
*/
?>
