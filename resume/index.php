<?php 
require_once("../inc/setup.inc.php");
$page = new Page([
	'stylesheets' => ['resume.css']
]);

$h->p('If you print this page, it will only print the resume. Alternatively, you can <a href="resume.pdf" target="_blank">download a PDF</a>.', ['class' => 'screen-only']);

require_once('Resume.php');
$resume = new Resume;
$resume->render();

$page->end();
