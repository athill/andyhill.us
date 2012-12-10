<?php
include("inc/application.php");

$contacts = array(
	array('left'=>"Address", 
		'right'=>"Pizza King of Carmel<br />301 E. Carmel Dr., Suite A-800<br />" .
		"Carmel, IN 46032"),
	array('left'=>"Telephone", 'right'=>"317-848-7994"),
	array('left'=>"Email", 'right'=>"PizzaKingOfCarmel@yahoo.com"),
);
$h->odiv('id="contact-us"');
$h->dictionaryGrid($contacts);
$h->cdiv();

/*
$h->odiv('class="dictionary-grid" id="contact-us"');
$h->odiv('class="row"');
$h->div(, 'class="row-left"');
$h->div(, 'class="row-right"');
$h->cdiv();	////close row
$h->odiv('class="row"');
$h->div(, 'class="row-left"');
$h->div(, 'class="row-right"');
$h->cdiv();	////close row
$h->odiv('class="row"');
$h->div(, 'class="row-left"');
$h->div(, 'class="row-right"');
$h->cdiv();	////close row
$h->cdiv(); ////close contact-us
*/


if ($footer != "") {
	include_once($GLOBALS['fileroot'] . $footer);
}
?>
