<?php
date_default_timezone_set('America/New_York');
////useless here if any vars are set. first thing on each page (for sessions)
//session_start();
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


$settings = array(
	"webroot" => $webroot,
	"fileroot" => $basefileroot.$webroot,
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
$useragent=$_SERVER['HTTP_USER_AGENT'];
$settings['isMobile'] = (preg_match('/android.+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|e\-|e\/|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(di|rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|xda(\-|2|g)|yas\-|your|zeto|zte\-/i',substr($useragent,0,4)));

$settings['isTablet'] = uaContains("ipad") || (uaContains("android") && !uaContains("mobile"));	

function uaContains($str) {
	return stripos($_SERVER['HTTP_USER_AGENT'], $str) > 0;
}

$settings['pageTitle']  = $settings['siteName'];


$settings['dir'] = preg_replace('/(.*)\/[^\/]+$/', '$1', $_SERVER['SCRIPT_FILENAME']);
$settings['filename'] = preg_replace('/.*\/([^\/]+)$/', '$1', $_SERVER['PHP_SELF']);
$settings['isPRD'] = !$settings['isTST'];
$settings['incroot'] = $settings['fileroot'] . "/inc";
////TODO: Doing what? Better way: native functions
//if ($_SERVER['REMOTE_ADDR'] == '24.1.115.39') echo 'path?!?' . $_SERVER['PHP_SELF'].'<br />';	//echo $tmp;
//if ($_SERVER['REMOTE_ADDR'] == '24.1.115.39') echo 'path?!?' . $settings['webroot'].'<br />';	//echo $tmp;
$tmp = $_SERVER['PHP_SELF'];
if ($webroot != "") {
	$tmp = str_replace($settings['webroot']."/", "", $_SERVER['PHP_SELF']);
} else {
}
//if ($_SERVER['REMOTE_ADDR'] == '24.1.115.39') echo 'path?!?' . $tmp.'<br />';	//echo $tmp;
$tmp = preg_replace("/index.php$/", "", $tmp);

$settings['path'] = $tmp;
if (strpos($settings['path'], "/") !== 0) {
	$settings['path'] = "/".$settings['path'];
}
//if ($_SERVER['REMOTE_ADDR'] == '24.1.115.39') echo 'path?!?' . $settings['path'].'<br />';	
$settings["script"] = explode("/", $tmp);
if (count($settings["script"]) > 0 && $settings["script"][0] == "") {
	array_shift($settings["script"]);
}
//print_r($settings["script"]);
$settings['view'] = $_SERVER['SCRIPT_NAME'];
$GLOBALS['menuStyle'] = "popup";

////Global objects
include_once($settings['incroot'] . "/Html.class.php");
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
	"tooltip", "treeTable", "highcharts", "popup", "galleria", "treemenu", "d3"
);
foreach ($modules as $module) {
	if (!array_key_exists($module, $settings['jsModules'])) $settings['jsModules'][$module] = false;
}
$settings['jsModules']['popup'] = true;


////Globalize/localize vars

/*
foreach ($settings as $key => $value) {
	$GLOBALS[$key] = $value;
	$$key = $value;
}
*/

$GLOBALS['site'] = $settings;



////Directory Settings -- override global settings for directory
$dirSettings = $GLOBALS['site']['dir'].'/directorySettings.php';
//print_r($GLOBALS);
if (file_exists($dirSettings)) {
	require_once($dirSettings);
}
if (isset($directory['jsModules'])) $directory['jsModules'] = array_merge($GLOBALS['site']['jsModules'], $directory['jsModules']) or die("???");
if (isset($directory)) $GLOBALS['site'] = array_merge($GLOBALS['site'], $directory) or die("???");


////Local Settings override global and directory
if (isset($local['jsModules'])) {
	$local['jsModules'] = array_merge($GLOBALS['site']['jsModules'], $local['jsModules']) or die("^^^!!");
}
if (isset($local))$GLOBALS['site'] = array_merge($GLOBALS['site'], $local) or die("^^^");



////Error handler
////TODO: Move up to global objects?
/*include_once($GLOBALS['site']['incroot']."/Error.class.php");
$error = new Error();*/
$current_error_reporting = error_reporting();
$old_error_reporting = error_reporting(E_ALL ^ E_NOTICE);


////Template
////TODO: Move instantiation up to global objects? um, no -- needs Menu and Template
include_once($GLOBALS['site']['incroot']."/site/Template.class.php");
$template = new Template($menu, $GLOBALS['site']["template"]);
////TODO: Move head() and heading() to template.start() ?
$template->head();
$template->heading();
?>
