<?php
header("Content-type: application/vnd.ms-word");
header("Content-Disposition: attachment;Filename=Andy_Hill_Resume.doc");
////include styles
ob_start();
echo '<style type="text/css">'."\n";
include_once("resume.css");
echo '</style>'."\n";
$local['headerExtra'] = ob_get_contents();
ob_end_clean();


$local['jsModules']['popup'] = false;
$local['template'] = "Basic";
//$local['stylesheets'] = array("resume.css");
require_once("../inc/application.php");

include_once("resume.inc.php"); 
?>
