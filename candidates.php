<?php
require_once('/var/www/inc/html.class.php');
$h = html::singleton();


////Start rendering
$h->ohtml('Candidate Portal');
$h->body();

////Objectives
$h->h(2, 'Objectives');
$items = array(
	"Non-partisan",
	"Increase citizens' ability to easily access candidates' stances on issues, etc.", 
	"Increase citizens' knowledge of candidates and their positions, electoral process",
	"Increase citizens' knowledge of issues of the day",
	"Open source expansion into other cities, counties, states, etc."
);
$h->liArray('ol', $items);

////Idea
$h->h(2, 'Idea');
$items = array(
	"Non-profit/public partnership",
	"Some type of secure web service agreement with appropriate election board", 
	"Create/delete (or archive) accounts based on candidate status (from web service)",
	"When candidate is official, send email invitation. Their portal would include website, fb, statement, rss?, forum?, etc",
	"General election portal could include press releases, debates, etc."


);
$h->liArray('ol', $items);


$h->chtml();
////End rendering
?>