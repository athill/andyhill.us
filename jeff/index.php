<?php
include("inc/application.php");
if ($useView) {
	if (filesize($filescript) == 0) include($GLOBALS['fileroot'] . "/inc/dirList.php");
	include($filescript);
}
$h->br();
$h->odiv('style="text-align: center;"');
$h->img($webroot . "/img/splash_logo.png", "", 'align="center"');
$h->cdiv();


if ($footer != "") {
	include_once($GLOBALS['fileroot'] . $footer);
}
?>


