<?php
require_once("../inc/setup.inc.php");
header("Content-type: application/vnd.ms-word");
header("Content-Disposition: attachment;Filename=Andy_Hill_Resume.doc");

////include styles
ob_start();
echo '<style type="text/css">'."\n";
include_once("resume.css");
echo '</style>'."\n";
$headerExtra = ob_get_contents();
ob_end_clean();

$page = new Page(array(
	'jsModules'=>array('popup'=>false),
	'template'=>'Basic',
	'headerExtra'=>$headerExtra
));


include_once("resume.inc.php"); 
$page->end();
?>
