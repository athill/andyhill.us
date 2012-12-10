<?php
echo 'here';

require_once('../../inc/application.php');

$links = array(
		array('href'=>'genXml.php', 'display'=>'Generate XML')
);


$h->linkList($links);

$template->footer();   

?>
