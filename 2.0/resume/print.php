<?php
header("Content-type: application/vnd.ms-word");
header("Content-Disposition: attachment;Filename=Andy_Hill_Resume.doc");
echo '<style type="text/css">'."\n";
include_once("resume.css");
echo '</style>'."\n";
include_once("resume.php"); 
?>