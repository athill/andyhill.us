<?php
include("inc/application.php");

$family = array(
	array('left'=>"Rushville, IN", 
		'right'=>"<u>Main</u><br />". 
				"... N. Perkins St.<br />".
				"Rushville, IN 46173<br />".
				"ph# 756-932-2212<br /><br />".
				"<u>North</u><br />". 
				"... N. Main St. 46173<br />".
				"Rushville, IN 46173<br />".
				"ph# ...<br /><br />"				
	),
	array('left'=>"Greensburg, IN", 'right'=>"..."),
	array('left'=>"Liberty, IN", 'right'=>"..."),
	array('left'=>"Brookville, IN", 'right'=>"..."),
);
$h->odiv('id="pk-family"');
$h->dictionaryGrid($family);
$h->cdiv();



if ($footer != "") {
	include_once($GLOBALS['fileroot'] . $footer);
}
?>
