<?php
exit();
include('../inc/application.php');
////Facebook
// App ID: 405216726278675
// App Secret: 1e677d512a76fac8ea474f5df4445268


$links = array(
	array( 'href'=>'errorPages/', 'display'=>'Generate Error Pages')
);

$h->linkList($links);


$template->footer();
?>