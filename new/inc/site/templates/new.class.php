<?php
include_once($GLOBALS['incroot']."/html.class.php");
$h = html::singleton();
//echo "included";

class TemplateInstance {


	public $bodyAtts = 'id="default" class="default"';	
	public $stylesheets = "/css/main.css";
	public $scripts = "/js/jquery.js,/js/site.js,/js/header.js";
	private $base;
	
	public function __construct($base) {
		$this->base = $base;	
	}
	
	public function heading() {
	  global $h, $pageTitle;
		
		////Main container
		$h->odiv('id="page"');
		
		$this->displayHeader();
		////Site structure
		$this->base->openLayout();
	}

	private function displayHeader() {
		global $h;
		////header container
		$h->otag('header', 'id="header"');
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
		$pageTitle = "andyhill.us";
		$h->div($pageTitle, 'id="page-title-drop" class="page-title-base"');
		$h->div($pageTitle, 'id="page-title" class="page-title-base"');
		////Global Navigation
		$h->otag('nav', 'id="global-nav"');		
		$h->tnl("Global Nav");
		$h->ctag('nav');
		////Gray bar
		$h->odiv('id="top-divider"');
				
		//////Do path
		$h->otag('nav', 'id="path"');
		$h->tbr("Path");
		$h->ctag('nav');
		////Search
		$h->odiv('id="search"');
		$this->displaySearch();
		$h->cdiv();

		$h->cdiv(); ////close top-divider div
		////close  div
		$h->ctag('header');
		$h->div("", 'style="clear: both"');
	}

	private function displaySearch() {
		global $h;				
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
	}
	
	private function displayTopNav() {
		
		global $h;
		$h->odiv('id="nav_horizontal"');
		$h->h(3, "Primary Navigation", 'id="skip3"');
		$this->base->menu->topNav();
		$h->cdiv();
		
	}
	
	private function displaySideNav() {
		global $h;
		$h->odiv('id="column1"');
		$h->h(3, "Secondary Navigation", 'id="skip4"');
		$h->odiv('id="nav_vertical" class="subnav"');
		$this->base->leftSideBar();
		$h->cdiv();	////close nav_vertical
		$h->cdiv();	////close column1	
		
	}
	
	public function breadcrumbs() {
	  global $h;
	  $h->odiv('id="breadcrumb"');
	  $this->base->breadcrumbs();
	  $h->cdiv();		
	}
	
	public function footer() {
		global $h;

		$h->cdiv(); //column1,2
		$h->cdiv();
		$h->cdiv();
		$h->otag('footer');
		$h->tbr("footer");
		$h->ctag('footer');
		$h->chtml();
	}
}

?>
