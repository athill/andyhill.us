<?php
//header("Content-type: application/vnd.ms-word");
//header("Content-Disposition: attachment;Filename=Andy_Hill_Resume.doc");
//echo '<style type="text/css">'."\n";
//include_once("resume.css");
//echo '</style>'."\n";
// $local['template'] = "Basic";
// $local['stylesheets'] = array("resume.css");
require_once("../inc/setup.inc.php");
$page = new Page(array(
	'template'=>'Basic',
	'stylesheets'=>array('resume.css')
));
include_once("resume.inc.php"); 
$page->end();
?>
