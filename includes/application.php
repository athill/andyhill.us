<?php
session_start();
/*****************************
 * Set a bunch of globals
 ***************************/
$GLOBALS['webroot'] = "";									//start path for web docs
$GLOBALS['fileroot'] = "/home/andyhil/public_html/";			//Start path for files

//initiate the view
if (!isset($_GET['view'])) $_GET['view'] = "/home/";			//Default view
if (!file_exists($GLOBALS['fileroot'] . $_GET['view'])) $_GET['view'] = "/home/"; 	////Non-existent view, go home
$GLOBALS['view'] = $_GET['view'];								//View
$GLOBALS['webscript'] = $GLOBALS['webroot'] . $GLOBALS['view'];	//web path for current view
$GLOBALS['webdir'] = preg_replace("/(.*)\/.*\.php$/", "$1", $GLOBALS['webscript']);  	//web path to current directory
$GLOBALS['filescript'] = $GLOBALS['fileroot'] . $GLOBALS['view'];						//file path to current view
$GLOBALS['filedir'] = preg_replace("/(.*)\/.*\.php$/", "$1", $filescript);	//file path to current directory	
if (!preg_match("/\.php$/", $GLOBALS['filescript'])) $GLOBALS['filescript'] .= "index.php";	//Add index.php to dirs
$GLOBALS['filename'] = preg_replace("/.*\/([^\/]+\.php$)/", "$1", $GLOBALS['filescript']);
////Plugins
$GLOBALS['lightbox'] = false;
$GLOBALS['tooltip'] = false;
////Which menu
if (isset($_GET['menuStyle'])) {
	setcookie('menuStyle', $_GET['menuStyle']);
	$GLOBALS['menuStyle'] = $_GET['menuStyle'];
} else if (isset($_COOKIE['menuStyle'])) {
	$GLOBALS['menuStyle'] = $_COOKIE['menuStyle'];
} else {
	$GLOBALS['menuStyle'] = "popup";
}
$GLOBALS['menuStyle'] ? $_GET['menuStyle'] : "popup";
////Build script array from path
$script = preg_replace("/(.*)\/$/", "$1", $GLOBALS['view']);
$script = preg_replace("/^\/(.*)/", "$1", $script);
$GLOBALS['script'] = explode("/", $script);


////default header and footer
$GLOBALS['header'] = '/includes/header.php';
$GLOBALS['footer'] = '/includes/footer.php';

////parse the XML menu
$xmlFile = $GLOBALS['fileroot'] . "/menu.xml";
$xml_parser = xml_parser_create();
if (!($fp = fopen($xmlFile, "r"))) {
   die("could not open XML input");
}
$data = fread($fp, filesize($xmlFile));
fclose($fp);
xml_parse_into_struct($xml_parser, $data, $vals, $index);
xml_parser_free($xml_parser);
$GLOBALS['vals'] = $vals;

include_once($GLOBALS['fileroot'] . "/includes/Html.php.inc");
$h = Html::singleton();
include_once($GLOBALS['fileroot'] . "/includes/Menu.php.inc");
$GLOBALS['menu'] = new Menu($xmlFile);

////Clone globals to local scope
foreach ($GLOBALS as $key=>$val) {
	$$key = $val;
}

////Override Global settings
if (file_exists($filedir . "/directorySettings.php")) {
	include($filedir . "/directorySettings.php");
}
include_once($GLOBALS['fileroot'] . "/includes/utils.php");

//Include the header
if ($header != "") {
	include_once($GLOBALS['fileroot'] . $header);
}
?>
