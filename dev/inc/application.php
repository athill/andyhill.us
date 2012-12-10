<?php
date_default_timezone_set('America/New_York');
////useless here if any vars are set. first thing on each page (for sessions)
//session_start();
$webroot = "";
if (stripos($_SERVER['SCRIPT_NAME'], "/new/") === 0) {
	$webroot .= "/new";
} else if (stripos($_SERVER['SCRIPT_NAME'], "/dev/") === 0) {
	$webroot .= "/dev";
}

$settings = array(
	"webroot" => $webroot,
	"fileroot" => "/home/andyhil/public_html".$webroot,
	"isTST" => $webroot != "",

	"view" => $_SERVER['PHP_SELF'],
	"siteName" 	=> "andyhill.us",
	"leftSideBar" => array('type'=>"none", 'args'=>array()),
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
$tmp = preg_replace("/index.php$/", "", $tmp);
//echo $tmp;
$settings['path'] = $tmp;
if (strpos($settings['path'], "/") !== 0) {
	$settings['path'] = "/".$settings['path'];
}
$settings["script"] = explode("/", $tmp);
if (count($settings["script"]) > 0 && $settings["script"][0] == "") {
	array_shift($settings["script"]);
}
//print_r($settings["script"]);
$settings['view'] = $_SERVER['SCRIPT_NAME'];
$GLOBALS['menuStyle'] = "popup";

////Global objects
include_once($settings['incroot'] . "/html.class.php");
$settings['h'] = html::singleton();
include_once($settings['incroot'] . "/Logger.class.php");
$settings['logger'] = new Logger();
//include_once($settings['incroot'] . "/ADS.class.php");
//$settings['ads'] = new ADS();
include_once($settings['incroot'] . "/Mailer.class.php");
$settings['mailer'] = new Mailer();
////Menu
//echo "here0".$incroot."/Menu.class.php";
include_once($settings['incroot']."/Menu.class.php");
$xmlfile = $settings['fileroot'].'/menu.xml';
//echo 'SCRIPT';
//print_r($settings['script']);
$menu = new Menu($xmlfile, $settings['script']);
$retval = $menu->buildPathAndSetTitle(array('script'=>$settings['script']));
//echo 'um';
//print_r($retval);
$settings['breadcrumbs'] = $retval['breadcrumbs'];
$settings['pageTitle'] = $retval['pagetitle'];
//// js/css packages
$settings['jsModules'] = array();
$modules = array(
	"tooltip", "treeTable", "highcharts", "popup", "galleria", "treemenu"
);
foreach ($modules as $module) {
	if (!array_key_exists($module, $settings['jsModules'])) $settings['jsModules'][$module] = false;
}
$settings['jsModules']['popup'] = true;


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



//print_r($directory);
if (isset($directory)) $GLOBALS = array_merge($GLOBALS, $directory) or die("???");
////Local Settings override global and directory
if (isset($local))$GLOBALS = array_merge($GLOBALS, $local) or die("^^^");

if (isset($directory['jsModules'])) $GLOBALS['jsModules'] = array_merge($settings['jsModules'], $directory['jsModules']) or die("???");
////Local Settings override global and directory
if (isset($local['jsModules'])) {

	$GLOBALS['jsModules'] = array_merge($settings['jsModules'], $local['jsModules']) or die("^^^");
}

//echo '<pre>';
//print_r($GLOBALS['jsModules']);
//echo '</pre>';

//print_r($GLOBALS['stylesheets']);

//echo 'TEMPLATE: '.$GLOBALS["template"];

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

?>
