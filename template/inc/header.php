<?php
/////Set title
$path = $menu->buildPathAndSetTitle($menu->xml);
$title = "Andy's Web Site";
if ($GLOBALS['pageTitle'] != "") {
	$title .= " - ".$GLOBALS['pageTitle'];
}
if ($GLOBALS['path'] == "/home/") $header = "Andy's Web Site";
else $header = $title;

////////////////
// Includes
////////////////
////////Modules
include_once($GLOBALS['fileroot']."/inc/ModuleFactory.php");
$factory = ModuleFactory::singleton();

////Base includes 
$factory->add("Module", array("Base", "/js/jquery/jquery.js", ""));

////Lightbox
if ($GLOBALS['lightbox']) {
	$factory->add("Lightbox");
}
////Tooltip
if ($GLOBALS['tooltip']) {
	$factory->add("Tooltip");
}
////Menu
if ($GLOBALS['menuStyle'] == "tree") { 	
	$factory->add("TreeMenu");	
} else {
	$factory->add("PopupMenu");
}
////site specific
$factory->add("Module", array("Site", "/js/main.js,/js/header.js", "/css/main.css"));
////Build array
$includes = array_merge($factory->cssfiles, $factory->jsfiles); 

///////////////
////Begin display
////////////////
////Output header
$h->ohtml($title, $includes);
////Begin Display
$h->body();
////header container
$h->odiv('id="header"');
////Images across the top
$images = array('house.jpg',
				'band.jpg',
				'showwater.jpg', 
				'wfhb.jpg'
);
for ($i = 0; $i < count($images); $i++) {
	$h->img("/images/header/" . $images[$i], "", 'id="headerImg'.$i.'" class="header-img"');
}
////Header title
$h->div($title, 'class="page-header" id="drop"');
$h->div($title, 'class="page-header"');
$h->cdiv(); ////Close header
////Gray bar
$h->odiv('id="top-divider"');
//////Do path
$h->odiv('id="path"');
$menu->displayPath($path);
$h->cdiv();
////Search
$h->odiv('id="search"');
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
$h->cdiv(); ////close search div
$h->cdiv(); ////close topDivider div
////Site structure
$h->odiv('id="main"');
$h->odiv('id="sidebar"');
$menu->displayMenu();
$h->cdiv();
$h->odiv('id="content"');
?>
