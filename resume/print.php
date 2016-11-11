<?php
require_once("../inc/setup.inc.php");
$page = new Page(array(
	'template'=>'Basic',
	'stylesheets'=>array('resume.css')
));
include_once("resume.inc.php"); 
$page->end();
