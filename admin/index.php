<?php
include('../inc/application.php');

$links = array(
	array( 'href'=>'errorPages/', 'display'=>'Generate Error Pages')
);

$h->linkList($links);


$template->footer();
?>