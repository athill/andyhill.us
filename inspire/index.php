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
This section uses <a href="https://developer.mozilla.org/en-US/docs/Web/API/WindowEventHandlers/onhashchange" target="_blank">hash navigation</a>, 
which means it uses the part of the URL after the pound sign (hash, '#') to determine the content of the page rather than reloading the 
entire page. When a link is clicked, it changes the part of the URL after the hash. This is then parsed by the client-side script (JavaScript) 
and then a request is made to the server for the content. On the server, the request makes a query against a 
<a href="https://sqlite.org/" target="_blank">SQLite</a> database to retrieve the content, and then the breadcrumbs and page content 
are updated without the page reloading. 
EOT;



$page->template->template->geekOut($content);

$h->div('', ['id' => 'inspire-root']);


$options = ['maxdepth' => -1, 'atts' => ['id' => 'inspire-menu']];
$h->startBuffer();
$site['menu']->menuList($options);
$menu = preg_replace("/[\n\t]/", "", $h->endBuffer());
$menu = str_replace("'", "\'", $menu);

$h->script("var menu = '$menu';", true);
$page->end();

?>
