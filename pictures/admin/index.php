<?php
require_once('../../inc/setup.inc.php');
$page = new Page();

$links = array(
		array('href'=>'genXml.php', 'display'=>'Generate XML')
);


$h->linkList($links);

$page->end();   

?>
