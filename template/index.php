<?php
include("inc/application.php");
if ($useView) {
	if (filesize($filescript) == 0) include($GLOBALS['fileroot'] . "/inc/dirList.php");
	include($filescript);
}




if ($footer != "") {
	include_once($GLOBALS['fileroot'] . $footer);
}
?>


