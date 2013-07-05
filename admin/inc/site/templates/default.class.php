<?php
$h = html::singleton();
//echo "included";

class TemplateInstance {


	public $bodyAtts = 'id="default" class="default"';	
	public $stylesheets = array("/css/main.css");
	public $scripts = array("/js/jquery-1.10.1.min.js");
	private $base;
	
	public function __construct($base) {
		global $site;
		$this->base = $base;	
		$this->scripts[] = ($site['isPRD']) ? 
			'/js/jquery-migrate-1.2.1.min.js' : 
			'/js/jquery-migrate-1.2.1.js';
		$this->scripts = array_merge($this->scripts, array("/js/site.js","/js/header.js"));
	}
	
	public function heading() {
	  global $h;
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
		$h->odiv('id="img-container"');
		////Images across the top
		$images = array('house.jpg',
					'band.jpg',
					'showwater.jpg', 
					'wfhb.jpg'
		);
		for ($i = 0; $i < count($images); $i++) {
			$h->img("/images/header/" . $images[$i], "", 'id="header-img'.$i.'" class="header-img"');
		}
		$h->cdiv(); ////close img-container
		////Header title
		$pageTitle = "andyhill.us";
		$h->div($pageTitle, 'id="page-title-drop" class="page-title-base"');
		$h->div($pageTitle, 'id="page-title" class="page-title-base"');
		$h->ctag('header');		////close header
		////Global Navigation
		$h->otag('nav', 'id="global-nav"');		
		//$h->tnl("Global Nav");
		$this->renderGlobalNav();
		$h->ctag('nav');

		////Gray bar
		$h->odiv('id="top-divider"');
				
		//////Do path
		$h->otag('nav', 'id="path"');
//		$h->tnl("Path");
		$this->breadcrumbs();
		$h->ctag('nav');
		////Search
		$h->odiv('id="search"');
		$this->displaySearch();
		$h->cdiv();

		$h->cdiv(); ////close top-divider div
		
		$h->div("", 'style="clear: both"');
	}

	function renderGlobalNav() {
		global $h;
		$h->h(3, "Primary Navigation", 'id="primary-navigation" class="hide"');
//		$array = $this->base->menu->xmlMenu2array($this->xml);
		$h->linkList($this->base->menu->xmlMenu2array(), 'class="sf-menu" id="global-nav-menu"');
	}


	function geekOut($content) {
		global $h;
		$h->odiv('id="geek-out"');
		$h->span("&nbsp;Geek Out&nbsp;", 'id="geek-out-button"');
		$h->div($content, 'id="geek-out-content" class="hide"');
		$h->cdiv();
	}
	
	private function displaySearch() {
		global $h, $webroot;				
		$h->oform("http://google.com/search", "get");
		$sitesearch = array("|Web", "andyhill.us".$webroot."|Site");
/*
		foreach ($this->base->menu->xml as $elem) {
			$sitesearch[] = "andyhill.us".$webroot.$elem['href']."|".$elem['display'];
		}
*/
		$h->tnl("Search ");
		$h->select("sitesearch", $sitesearch, "andyhill.us$webroot");
		$h->input("text", "q", "", 'size="10" maxlength="255"');
		$h->tnl("by Google");
		$h->cform();
	}
	
	
	private function displaySideNav() {
		global $h;
		$h->odiv('id="column1"');
		$h->h(3, "Secondary Navigation", 'id="secondary-navigation"');
		$h->odiv('id="nav_vertical" class="subnav"');
		$this->base->leftSideBar();
		$h->cdiv();	////close nav_vertical
		$h->cdiv();	////close column1	
		
	}
	
	public function breadcrumbs() {
	  global $h, $breadcrumbs;
//	  $h->pa($breadcrumbs);
	  $h->odiv('id="breadcrumb"');
	  $this->base->breadcrumbs(array('breadcrumbs'=>$breadcrumbs));
	  $h->cdiv();		
	}
	
	public function footer() {
		global $h;
		$this->base->closeLayout();
		$h->otag('footer');
//		$h->tbr("footer");
		$h->tnl('&copy; andyhill.us ' . date('Y'));
		$h->ctag('footer');
		$h->cdiv();	////close page
		$h->chtml();
	}
}

?>
