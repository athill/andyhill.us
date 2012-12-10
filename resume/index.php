<?php 
$script = $_SERVER['SCRIPT_NAME'];
$basename = basename($script);
$isPrint = $basename == "print.php";
$hasTemplate = !($basename == "word.php");
$hasHeader = $isPrint || $hasTemplate;
//if ($hasTemplate) echo "template<br />";
//if ($isPrint) echo "print<br />";
//echo $isPrint." here |".$hasTemplate . "|";
//$hasHeader = true;
if ($isPrint) {
	$local['template'] = "Basic";
}
if ($hasHeader) { 
	$local['jsModules']['treemenu'] = true;
	$local['leftSideBar'] = array('type' =>'menu', 'args' => array());
	$local['stylesheets'] = array("resume.css");
//	$local['scripts'] = array("resume.js");
	require_once("../inc/application.php");
	//$stuff = $template->menu->getNodeFromPath();
	//echo 'result: ' . $stuff;
	//$h->pa($stuff);
} else { 
	echo '<link rel="stylesheet" type="text/css" href="/resume/resume.css" />';
} 
include_once("resume.inc.php");

if ($hasHeader) { 
	$template->footer();	
} 
?>
