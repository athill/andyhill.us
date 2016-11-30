<?php
$h = html::singleton();
//echo "included";

class TemplateInstance {
	public $bodyAtts = 'id="default" class="default"';	
	public $stylesheets = ['/css/main.css', '/css/menu.css'];
	public $scripts = [];
	private $base;
	
	public function __construct($base) {
		global $site;
		$this->base = $base;	
		// $this->scripts[] = ($site['isPRD']) ? 
		// 	'/js/jquery-migrate-1.2.1.min.js' : 
		// 	'/js/jquery-migrate-1.2.1.js';
		$this->scripts = array_merge($this->scripts, ['/js/jquery-doubleTapToGo.js', "/js/site.js","/js/header.js"]);
	}
	
	public function heading() {
	  global $h;
		////Main container
	  	$h->odiv(['class' => 'container']);
	  	$h->odiv(['class' => 'row']);
	  	$h->div('', ['class' => 'col-md-1 hidden-sm site-side-padding']);
		$h->odiv(['id' => 'page', 'class' => 'col-md-10 col-sm-12']);
		$this->displayHeader();
		////Site structure
		$this->base->openLayout();
	}

	private function displayHeader() {
		global $h, $site;
		////header container
		$h->oheader('id="header"');
		$h->odiv(['id' => 'img-container']);
		////Images across the top
		$images = array('house.jpg',
					'band.jpg',
					'showwater.jpg', 
					'wfhb.jpg'
		);
		for ($i = 0; $i < count($images); $i++) {
			$h->img("/images/header/" . $images[$i], "", ['id' => 'header-img'.$i, 
				 'class' => 'header-img hidden-xs']);
		}
		$h->cdiv('/#img-container');
		
		////Header title
		$h->div($site['siteName'], ['id' => 'page-title']);

		$h->cheader('/#header');
		$h->odiv(['id' => 'top-divider', 'class' => 'row']);
		////Global Navigation
		$h->onav(['id' => 'nav', 'role' => 'navigation', 'class' => 'col-sm-12 col-xs-2']);
		$this->renderGlobalNav();
		$h->cnav('/#nav');
		////Gray bar
		//// path
		$h->onav(['id' => 'path', 'class' => 'col-sm-6 col-xs-10']);
		$this->breadcrumbs();
		$h->cnav();
		//// search toggle
		$h->odiv(['class' => 'visible-xs-block col-xs-2 search-toggle']);
		$h->icon('search', ['class' => 'fa-lg', 'buttonAtts' => ['id' => 'search-toggle', 'class' => 'btn btn-default']]);
		$h->cdiv('./search-toggle');
		////Search
		$h->odiv(['id' => 'search', 'class' => 'col-sm-6 col-xs-12 hidden-xs']);
		$this->displaySearch();
		$h->cdiv('/#search');
		$h->cdiv('/.#top-divider'); 
	}

	function renderGlobalNav() {
		global $h;
		// $h->h(3, "Primary Navigation", 'id="primary-navigation" class="hide"');
		//// from https://osvaldas.info/drop-down-navigation-responsive-and-touch-friendly
		$h->a('#nav', 'Show navigation', 'title="Show navigation"');
		
		$h->a('#', 'Hide navigation', 'title="Hide navigation"');
		$h->linkList($this->base->menu->xmlMenu2array(['maxdepth' => 0]));
	}


	function geekOut($content) {
		global $h;
		$h->odiv('id="geek-out"');
		$h->span("&nbsp;Geek Out&nbsp;", 'id="geek-out-button"');
		$h->div($content, 'id="geek-out-content" class="hide"');
		$h->cdiv();
	}
	
	private function displaySearch() {
		global $h, $webroot, $site;				
		$h->oform("http://google.com/search", "get", ['class' => 'form-inline']);
		$sitesearch = 'andyhill.us'.$webroot;
		// $h->tnl("Search ");
		$h->hidden("sitesearch", $sitesearch);
		$label = 'Search by Google';
		$h->label('q', $label, ['class' => 'sr-only']);
		$h->input("text", "q", "", [
			'size' => '15', 
			'maxlength' => '255', 
			'placeholder' => $label,
			'class' => 'form-control input-sm'
		]);
		$h->button('Search', ['class' => 'btn btn-default btn-xs', 'type' => 'submit']);
		// $h->tnl("by Google");
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
	  global $h, $site;
//	  $h->pa($breadcrumbs);
	  $h->odiv('id="breadcrumb"');
	  $this->base->breadcrumbs(array('breadcrumbs'=>$site['breadcrumbs']));
	  $h->cdiv();		
	}
	
	public function footer() {
		global $h;
		$this->base->closeLayout();
		$h->otag('footer');
//		$h->tbr("footer");
		$h->tnl('&copy; andyhill.us ' . date('Y'));
		$h->ctag('footer');
		$h->cdiv('./page');	////close page
		$h->div('', ['class' => 'col-md-1 hidden-sm site-side-padding']);
		$h->cdiv('./row');
		$h->cdiv('./container');
		$h->chtml();
	}
}

?>
