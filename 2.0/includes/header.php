<?php
//Determine title/header
//// XML: $fileroot . '/menu.xml')

$j = 0;
for ($i = 0; $i < count($vals); $i++) {
	$val = $vals[$i];
	if ($val['tag'] == "LINK" || ($val['tag'] == "LINKS" && $val['type'] == "complete")
			|| ($val['tag'] == "LINKS" && $val['type'] == "open")) {
		if ($val['level'] - 2 == $j && preg_replace("/\//", "", $val['attributes']['HREF']) == $script[$j]) {
			if ($j == count($script) - 1) $pageTitle = $val['attributes']['DISPLAY'];
			$j++;
		}
	}
}


if ($GLOBALS['path'] == "/home/") $header = "Andy's Web Site";
else $header = $pageTitle;
$pageTitle = "Andy's Web Site - " . $pageTitle;

$GLOBALS['pageTitle'] = "";
$path = $menu->buildPathAndSetTitle($menu->xml);
$title = "Andy's Web Site";
if ($GLOBALS['pageTitle'] != "") {
	$title .= " - ".$GLOBALS['pageTitle'];
}
if ($GLOBALS['path'] == "/home/") $header = "Andy's Web Site";
else $header = $title;
?>
<?php 
////////////////
// Includes
////////////////
$includes = array();
////jquery
$includes[] = '/js/jquery/jquery.js';
//$includes[] = '/js/jquery/jquery.dimension.js';
if ($GLOBALS['lightbox']) {
	//prototype.js,scriptaculous.js,lightbox.js,effects.js
	$incs = explode(",", "prototype.js,scriptaculous.js,lightbox.js,effects.js");
	for ($i = 0; $i < count($incs); $i++) {
		$includes[] = "/js/lightbox/$incs[$i]";
	}
	$includes[] = "/css/lightbox.css";
}
if ($GLOBALS['tooltip']) {
	//jquery.bgiframe.js,jquery.tooltip.js
	$incs = explode(",", "jquery.bgiframe.js,jquery.dimension.js,jquery.tooltip.js");
	for ($i = 0; $i < count($incs); $i++) {
		$includes[] = "/js/jquery/$incs[$i]";
	}
	$includes[] = "/css/jquery.tooltip.css";	
}


////Include the appropriate menu files
if ($GLOBALS['menuStyle'] == "tree") { 
	$includes[] = '/js/mktree.js';
	$includes[] = '/css/mktree.css';
} else {
	$includes[] = '/js/menu.js';
	$includes[] = '/css/menu.css';
}
$includes[] = '/css/main.css';
$includes[] = '/js/header.js';


///////////////
////Begin display
////////////////
////Output header
$h->ohtml($title, $includes);
////Begin Display
$h->body();
////Main container
$h->odiv('id="mainContainer"');
////header container
$h->odiv('id="headerContainer"');
$h->odiv('id="imgContainer"');
$h->cdiv();
////Images across the top
$images = array('house.jpg',
			'band.jpg',
			'showwater.jpg', 
			'wfhb.jpg'
);
for ($i = 0; $i < count($images); $i++) {
	$h->img("/images/header/" . $images[$i], "", 'id="headerImg'.$i.'" class="headerImg"');
}
////Header title
$h->div($title, 'id="headerTitleDrop"');
$h->div($title, 'id="headerTitle"');

/*
$h->startBuffer();
$h->tnl("var header = '".addslashes($title)."';");
$h->tnl("doHeader();");
$h->script($h->endBuffer());
*/
////Gray bar
$h->otable('id="topDivider"');
//////Do path
$h->otd('id="pathContainer"');
//include($GLOBALS['fileroot'] . "/includes/path.php");
$menu->displayPath($path);
$h->ctd();
////Search
$h->otd('id="searchContainer" class="right"');
$h->oform("http://google.com/search", "get");
$sitesearch = array("|Web", "andyhill.us".$webroot."|Site");
foreach ($menu->xml as $elem) {
	$sitesearch[] = "andyhill.us".$webroot.$elem['href']."|".$elem['display'];
}
$h->tnl("Search ");
$h->select("sitesearch", $sitesearch, "andyhill.us$webroot");
$h->input("text", "q", "", 'size="10" maxlength="255"');
$h->tnl("by Google");
$h->cform();
$h->ctd();

$h->ctable(); ////close topDivider div
////close  div
$h->cdiv();
$h->div("", 'style="clear: both"');
////Site structure
$h->otable('width="100%" cellpadding="0" cellspacing="0" summary=""');
$h->otd('id="leftContainer"');
//include($GLOBALS['fileroot'] . "/includes/menu.php");
$menu->displayMenu();
$h->otd('id="contentContainer"');
?>
