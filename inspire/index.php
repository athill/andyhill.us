<?php
include("../inc/setup.inc.php");
//include($GLOBALS['fileroot'] . "/includes/dirList.php");
$root = dirname($_SERVER['SCRIPT_NAME']);
$includeroot = str_replace("/dev", "", $root);
$page = new Page(array(
	'jsModules'=>array('treemenu'=>true),
	'leftSideBar'=>array('type' =>'menu', 'args' => array()),
	'stylesheets'=>array($includeroot."/quotes.css"),
	'scripts' => ['inspire.js']
));

$url = 'http://'.$_SERVER['HTTP_HOST'].$root;
$content = <<<EOT
This directory uses Apache Web Server's 
<a href="http://httpd.apache.org/docs/current/mod/mod_rewrite.html">MOD_REWRITE</a>. 
Usually, the URL in the address 
bar follows the structure of the directory where the site is hosted. For example, 
if the URL is $url/, the directory path is $root/. However, within this directory, 
if the URL is $root/songs/, for example, the processing still occurs at $root/. I then 
use the rest of the URL (songs/ in this case) to determine what content to display. 
The actual content of the songs are contained in text files in the content/ sub-directory. 
for example, you can look at 
<a href="$url/content/songs/holdonhope.txt" target="_blank">$url/content/songs/holdonhope.txt</a>, 
which is rendered here:
<a href="$url/songs/holdonhope" target="_blank">$url/songs/holdonhope</a>, 
EOT;



$page->template->template->geekOut($content);
$h->tbr("Some words that inspire me.");
$options = array('maxdepth'=>-1);
$site['menu']->menuList($options);


$page->end();
?>
