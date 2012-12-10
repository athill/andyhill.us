<?php

date_default_timezone_set('America/New_York');
session_start();
$settings = array(
	"webroot" => "/new",
	"fileroot" => "/home/andyhil/public_html/new",
	"isTST" => $_SERVER['HTTP_HOST'] === "webtest.iu.edu",

	"view" => $_SERVER['PHP_SELF'],
	"siteName" 	=> "Andy's Website",
	"leftSideBar" => "about",
	"rightSideBar" => "",
	"template" => "default",
	"scripts" => array(),
	"stylesheets" => array(),
	"useImageHeader" => false,
	"cas"=>false,
);
$settings['pageTitle']  = $settings['siteName'];


$tmp = str_replace($settings['webroot']."/", "", $_SERVER['PHP_SELF']);
$tmp = preg_replace("/\/(index.php)?$/", "", $tmp);

$settings["script"] = explode("/", $tmp);
$settings['isPRD'] = !$settings['isTST'];
$settings['incroot'] = $settings['fileroot'] . "/inc";



include_once($settings['incroot'] . "/html.class.php");
$settings['h'] = html::singleton();
include_once($settings['incroot'] . "/Logger.class.php");
$settings['logger'] = new Logger();

include_once($settings['incroot'] . "/ADS.class.php");

//$settings['ads'] = new ADS();

include_once($settings['incroot'] . "/Mailer.class.php");



$settings['ads'] = new Mailer();
$settings['dir'] = preg_replace('/(.*)\/[^\/]+$/', '$1', $_SERVER['SCRIPT_FILENAME']);
$settings['filename'] = preg_replace('/.*\/([^\/]+)$/', '$1', $_SERVER['PHP_SELF']);
//print $settings['filename'];
$settings['jsModules'] = array();
$modules = array(
	"tooltip", "treeTable", "highcharts", "dirtyform"
);

foreach ($modules as $module) {
	if (!array_key_exists($module, $settings['jsModules'])) $settings['jsModules'][$module] = false;
}


foreach ($settings as $key => $value) {
	$GLOBALS[$key] = $value;
	$$key = $value;
}



////directory settings
$dirSettings = $GLOBALS['dir'].'/directorySettings.php';
//print_r($GLOBALS);
if (file_exists($dirSettings)) {
	require_once($dirSettings);
}

if (isset($directory)) $GLOBALS = array_merge($GLOBALS, $directory) or die("???");
if (isset($local))$GLOBALS = array_merge($GLOBALS, $local) or die("^^^");


////Menu
include_once($incroot."/Menu.class.php");

$xmlfile = $GLOBALS['fileroot'].'/menu.xml';

$menu = new Menu($xmlfile);

$breadcrumbs = $menu->buildPathAndSetTitle($menu->xml->links, "", 0, array('<a href="'.$GLOBALS['webroot'].'/">UIRR Home</a>'));

//print("breadcrumbs");
//print_r($breadcrumbs);


include_once($incroot."/Error.class.php");
$error = new Error();

//print_r($GLOBALS);

include_once($incroot."/site/Template.class.php");


//$h->tbr("loading: " . $GLOBALS["template"]);
$template = new Template($menu, $GLOBALS["template"]);

$template->head();
//echo "including";
$template->heading();

?>
