<?php
session_start();
date_default_timezone_set('America/New_York');
//// autoloader
require_once('autoload.php');

////Discover webroot and fileroot
$webroot = "";
$basefileroot = "/home/andyhil/public_html";
$dataroot = "/home/andyhil/data/andyhill.us";
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
	$dataroot = '/var/www/html/data/andyhill.us';
}

if ($_SERVER['HTTP_HOST'] == 'andyhill.app') {
	$webroot = '';
	$basefileroot = '/home/vagrant/Code/sites/andyhill';
}

$basefileroot = dirname(dirname(__FILE__));
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
	"stylesheets" => [],
	'jsModules' => array(
		'popup'=>true, 'bootstrap'=>true, 'font-awesome'=>true
	),
	"useImageHeader" => false,
	"cas"=>false,
	'meta'=>array(
		  'description' => "Andy Hill's Webpage",
		  'keywords' => "Andy Hill,Bloomington, IN, IU, indiana university,indiana,andy,hill",
		  'author' => "Andy Hill",
		  'copyright' => date('Y'). ', andyhill.us',
		  'icon'=>''
	)	
);
if ($site['isTST']) {
	ini_set ('display_errors', '1');
}

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
// if ($_SERVER['REMOTE_ADDR'] == '24.1.115.39') echo 'path?!?' . $site['path'].'<br />';	
$site["script"] = explode("/", $tmp);
if (count($site["script"]) > 0 && $site["script"][0] == "") {
	array_shift($site["script"]);
}

////Global objects

$site['h'] = Html::singleton();
$h = $site['h'];

$site['logger'] = new Logger();
$site['mailer'] = new Mailer();

////Menu
$xmlfile = $site['fileroot'].'/menu.xml';
$site['menu'] = new Menu($xmlfile, $site['script']);
//// FIX: $menu should not be global
$menu = $site['menu'];

//$retval = $site['menu']->buildPathAndSetTitle(array('script'=>$site['script']));
$rv = $site['menu']->parseData();
// $h->pa($rv);
$site['breadcrumbs'] = $rv['breadcrumbs'];
$site['pageTitle'] = $rv['pagetitle'];

$sanitizer = new Sanitizer();
$_GET = $sanitizer->sanitize($_GET);
$_POST = $sanitizer->sanitize($_POST);


////Directory Settings -- override global settings for directory
$dirSettings = $site['filedir'].'/directorySettings.php';
if (file_exists($dirSettings)) {
	require_once($dirSettings);
}
if (isset($directory['jsModules'])) $directory['jsModules'] = array_merge($site['jsModules'], $directory['jsModules']) or die("???");
if (isset($directory)) $site = array_merge($site, $directory) or die("???");
?>