<?php
echo "here";
/*
date_default_timezone_set('America/New_York');
////useless here if any vars are set. first thing on each page (for sessions)
//session_start();
$settings = array(
	"webroot" => "/new",
	"fileroot" => "/home/andyhil/public_html/new",
	"isTST" => $_SERVER['HTTP_HOST'] === "webtest.iu.edu",

	"view" => $_SERVER['PHP_SELF'],
	"siteName" 	=> "Andy's Website",
	"leftSideBar" => "none",
	"rightSideBar" => "none",
	"template" => "default",
	"scripts" => array(),
	"stylesheets" => array(),
	"useImageHeader" => false,
	"cas"=>false,
);
////Defaults based on other defaults
$settings['pageTitle']  = $settings['siteName'];


$settings['dir'] = preg_replace('/(.*)\/[^\/]+$/', '$1', $_SERVER['SCRIPT_FILENAME']);
$settings['filename'] = preg_replace('/.*\/([^\/]+)$/', '$1', $_SERVER['PHP_SELF']);
$settings['isPRD'] = !$settings['isTST'];
$settings['incroot'] = $settings['fileroot'] . "/inc";
////TODO: Doing what? Better way: native functions
$tmp = str_replace($settings['webroot']."/", "", $_SERVER['PHP_SELF']);
$tmp = preg_replace("/\/(index.php)?$/", "", $tmp);
$settings["script"] = explode("/", $tmp);
$settings['view'] = $_SERVER['SCRIPT_NAME'];
$GLOBALS['menuStyle'] = "popup";

////Global objects
include_once($settings['incroot'] . "/html.class.php");
$settings['h'] = html::singleton();
include_once($settings['incroot'] . "/Logger.class.php");
$settings['logger'] = new Logger();
include_once($settings['incroot'] . "/ADS.class.php");
//$settings['ads'] = new ADS();
include_once($settings['incroot'] . "/Mailer.class.php");
$settings['mailer'] = new Mailer();


//// js/css packages
$settings['jsModules'] = array();
$modules = array(
	"tooltip", "treeTable", "highcharts"
);
foreach ($modules as $module) {
	if (!array_key_exists($module, $settings['jsModules'])) $settings['jsModules'][$module] = false;
}

////Globalize/localize vars
foreach ($settings as $key => $value) {
	$GLOBALS[$key] = $value;
	$$key = $value;
}

////Directory Settings -- override global settings for directory
$dirSettings = $GLOBALS['dir'].'/directorySettings.php';
//print_r($GLOBALS);
if (file_exists($dirSettings)) {
	require_once($dirSettings);
}
if (isset($directory)) $GLOBALS = array_merge($GLOBALS, $directory) or die("???");
////Local Settings override global and directory
if (isset($local))$GLOBALS = array_merge($GLOBALS, $local) or die("^^^");


////Menu
include_once($incroot."/Menu.class.php");
$xmlfile = $GLOBALS['fileroot'].'/menu.xml';
$menu = new Menu($xmlfile);
$breadcrumbs = $menu->buildPathAndSetTitle($menu->xml->links, "", 0, array());

////Error handler
////TODO: Move up to global objects?
include_once($incroot."/Error.class.php");
$error = new Error();

////Template
////TODO: Move instantiation up to global objects? um, no -- needs Menu and Template
include_once($incroot."/site/Template.class.php");
$template = new Template($menu, $GLOBALS["template"]);
////TODO: Move head() and heading() to template.start() ?
$template->head();
$template->heading();
*/
?>
