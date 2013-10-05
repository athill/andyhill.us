<?php
date_default_timezone_set('America/New_York');
//// autoloader
require_once('autoload.php');

////useless here if any vars are set. first thing on each page (for sessions)
//session_start();

////Discover webroot and fileroot
$webroot = "";
$basefileroot = "/home/andyhil/public_html";
////dev environments
if (stripos($_SERVER['SCRIPT_NAME'], "/new/") === 0) {
	$webroot .= "/new";
} else if (stripos($_SERVER['SCRIPT_NAME'], "/dev/") === 0) {
	$webroot .= "/dev";
}
////Local
if ($_SERVER['HTTP_HOST'] == 'localhost' || !array_key_exists('HTTP_HOST', $_SERVER)) {
	$webroot = '/andyhill';
	$basefileroot = '/var/www/html';
}

//// Set up site
$self = $_SERVER['PHP_SELF'];
$site = array(
	"webroot" => $webroot,
	"fileroot" => $basefileroot.$webroot,
	'filename' => basename($self),
	'filedir' => dirname($_SERVER['SCRIPT_FILENAME']),
	"isTST" => $webroot != "",
	"view" => $self,
	"siteName" 	=> "andyhill.us",
	"leftSideBar" => array('type'=>"none", 'args'=>array()),
	"rightSideBar" => "none",
	"template" => "default",
	"scripts" => array(),
	"stylesheets" => array(),
	'jsModules' => array(
		'popup'=>true
	),
	"useImageHeader" => false,
	"cas"=>false,
	'meta'=>array(
		  'description' => "Andy Hill's Webpage",
		  'keywords' => "Andy Hill,Bloomington, IN",
		  'author' => "Andy Hill",
		  'copyright' => date('Y'). ', andyhill.us',
		  'icon'=>'',
		  'compatible'=>'IE=edge,chrome=1',
		  'viewport'=>'width=device-width',
		  'charset'=>'uft-8'
	)	
);
////Mobile?
require_once('IsMobile.class.php');
$device = new IsMobile();
$site['isMobile'] = $device->isMobile;
$site['isTablet'] = $device->isTablet;

////derived/calculated values
$site['pageTitle']  = $site['siteName'];
$site['isPRD'] = !$site['isTST'];
$site['incroot'] = $site['fileroot'] . "/inc";
//// set $site['path']
$tmp = $_SERVER['PHP_SELF'];
if ($webroot != "") {
	$tmp = str_replace($site['webroot']."/", "", $_SERVER['PHP_SELF']);
}
$tmp = preg_replace("/index.php$/", "", $tmp);
$site['path'] = $tmp;
if (strpos($site['path'], "/") !== 0) {
	$site['path'] = "/".$site['path'];
}
//if ($_SERVER['REMOTE_ADDR'] == '24.1.115.39') echo 'path?!?' . $site['path'].'<br />';	
$site["script"] = explode("/", $tmp);
if (count($site["script"]) > 0 && $site["script"][0] == "") {
	array_shift($site["script"]);
}


print_r($site);


////Global objects
$site['h'] = Html::singleton();
$h = $site['h'];
$site['logger'] = new Logger();
$site['mailer'] = new Mailer();
////Menu
$xmlfile = $site['fileroot'].'/menu.xml';
$menu = new Menu($xmlfile, $site['script']);
$retval = $menu->buildPathAndSetTitle(array('script'=>$site['script']));
//echo 'um';
//print_r($retval);
$site['breadcrumbs'] = $retval['breadcrumbs'];
$site['pageTitle'] = $retval['pagetitle'];


////Directory Settings -- override global settings for directory
$dirSettings = $site['filedir'].'/directorySettings.php';
if (file_exists($dirSettings)) {
	require_once($dirSettings);
}
if (isset($directory)) $site = array_merge_recursive($site, $directory) or die("???");
////Local Settings override global and directory
if (isset($local))$site = array_merge_recursive($site, $local) or die("^^^");

////Error handler
////TODO: Move up to global objects?
/*include_once($site['incroot']."/Error.class.php");
$error = new Error();*/
$current_error_reporting = error_reporting();
$old_error_reporting = error_reporting(E_ALL ^ E_NOTICE);

////Template
////TODO: Move instantiation up to global objects? um, no -- needs Menu and Template
include_once($site['incroot']."/site/Template.class.php");
$template = new Template($menu, $site["template"]);
////TODO: Move head() and heading() to template.start() ?
$template->head();
$template->heading();
?>
