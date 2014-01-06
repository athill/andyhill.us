<?php 
require_once("../inc/setup.inc.php");
$script = $_SERVER['SCRIPT_NAME'];
$basename = basename($script);
$isPrint = $basename == "print.php";
$hasTemplate = !($basename == "word.php");
$hasHeader = $isPrint || $hasTemplate;

if ($isPrint) {
	$local['template'] = "Basic";
}
if ($hasHeader) { 
	$page = new Page(array(
		'jsModules'=>array('treemenu'=>true),
		'leftSideBar'=>array('type' =>'menu', 'args' => array()),
		'stylesheets'=>array('resume.css')
	));
} else { 
	echo '<link rel="stylesheet" type="text/css" href="/resume/resume.css" />';
} 
include_once("resume.inc.php");

if ($hasHeader) { 
	$page->end();	
} 
?>
