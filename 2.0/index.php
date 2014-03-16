<?php
include("includes/application.php");



if (filesize($filescript) == 0) include($GLOBALS['fileroot'] . "/includes/dirList.php");
include($filescript);
if ($footer != "") {
	include_once($GLOBALS['fileroot'] . $footer);
}
?>


