<?php
include_once("/ip/uirr/inc/html.class.php");
$h = html::singleton();
//echo "included";

class TemplateInstance {


	public $bodyAtts = 'id="default" class="default"';	
	public $stylesheets = "/global/css/import.css,/js/jquery-ui/css/smoothness/jquery-ui-1.8.12.custom.css";
	public $scripts = "/js/jquery.min.js,/js/jquery-ui/js/jquery-ui-1.8.12.custom.min.js";
	private $base;
	
	public function __construct($base) {
		$this->base = $base;	
	}
	
	public function heading() {
	  global $h, $pageTitle;
	  ////Hidden navigation for impaired
	  $this->base->skipNav();
	  ////Page structure
	  $h->odiv('id="wrapper"');
	  $h->odiv('id="container"');
	  //////////////////
	  ////Header/////////////
	  ////////////////
	  $h->odiv('id="header"');
	  $h->startBuffer();
	  $h->img("/global/img/iulogo.gif", "Indiana University", 'width="273" height="42"');
	  $img = trim($h->endBuffer());
	  $h->startBuffer();
	  $h->a("http://www.iu.edu/", $img);
	  $h->h(1, trim($h->endBuffer()));
	  ////Search form
	  $this->displaySearch();
	  ////site title
	  $h->startBuffer();
	  $h->a("http://www.iu.edu/~uirr/", "University Institutional Research and Reporting");
	  $h->h(2, trim($h->endBuffer()), 'id="sitetitle"');
	  $h->cdiv();	////Close header div
	  ////Top Nav
	  $this->displayTopNav();
	  $this->breadcrumbs();
	  ////Side Nav
	  if ($GLOBALS["leftSideBar"] != "none") {
		  $this->displaySideNav();
	  } 
	  ////Content
	  if ($GLOBALS["leftSideBar"] == "none" && $GLOBALS["rightSideBar"] == "none") {
		  $h->odiv('id="column123"');
	  }
	  
	  else if ($GLOBALS["rightSideBar"] == "none") $h->odiv('id="column23"');
	  else $h->odiv('id="column2"');
	  if (array_key_exists('submenu', $GLOBALS)) {
		include_once("/ip/uirr/inc/Submenu.class.php");
		$sm = new Submenu($GLOBALS['submenu']);  
	  }
	  if (array_key_exists('subsubmenu', $GLOBALS)) {
		include_once("/ip/uirr/inc/Submenu.class.php");
		$sm = new Submenu($GLOBALS['subsubmenu'], "subsubmenu"); 
		$h->br(); 
	  }	  
	  $h->name("skip1");
	  $h->odiv('id="content"');
	  ////breadcrumbs
	  
	  if ($GLOBALS["useImageHeader"]) {
		  $h->odiv('id="image4_hd_content"');
	  }
	  $h->h(3, $GLOBALS["pageTitle"]);
	  if ($GLOBALS["useImageHeader"]) {
		  $h->cdiv();
	  }
	}
	private function displaySearch() {
		global $h;
		$h->oform("http://search5.iu.edu/search", "get");
		$h->ofieldset("", 'id="set1"');
		$h->startBuffer();
		$h->label("searchbox", "Search");
		$h->h(3, trim($h->endBuffer()), 'id="skip2"');
		$h->input("text", "q", "", 'size="11" maxlength="255" id="searchbox"');
		$h->input("image", "go", "", 'src="/~uirr/global/img/search/go.gif" alt="GO"');
		$h->cfieldset();
		////search options
		$h->ofieldset("", 'id="set2"');
		
		$lis = array();
		$h->startBuffer();
		$h->input("radio", "as_sitesearch", "http://www.iu.edu/~uirr", 'id="search1" checked="checked"');
		$h->label("search1", "&nbsp;UIRR");
		$lis[] = trim($h->endBuffer());
		$h->startBuffer();
		$h->input("radio", "as_sitesearch", "http://www.iu.edu/", 'id="search2"');
		$h->label("search2", "&nbsp;IU");
		$lis[] = trim($h->endBuffer());
		$h->liArray("ul", $lis);
		////hidden
		$h->input("hidden", "as_dt", "i");
		$h->input("hidden", "client", "indiana");
		$h->input("hidden", "proxystylesheet", "indiana");
		$h->input("hidden", "output", "xml_no_dtd");		
		$h->cfieldset();		
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
		$h->cdiv();	////close content
		$h->cdiv(); ////close column2
		if ($GLOBALS["rightSideBar"] != "none") {
			$h->odiv('id="column3"');
			if ($GLOBALS["rightSideBar"] != "") {
				$h->odiv('class="boxwrap"');
				$column3 = explode(",", $column3);
				for ($i = 0; $i < count($column3); $i++) {
					$h->odiv('class="box"');
					include($column3[$i]);	
					$h->cdiv();
				}
				$h->cdiv();
			}
			$h->cdiv();
		}
		$h->cdiv(); ////close container
		$h->cdiv();	////close wrapper
		$h->odiv('id="footer"');
		$h->hr();
		$h->otag("p");
		$h->startBuffer();
		$h->img("/global/img/footer/blockiu.gif", "Block IU", 'width="22" height="28"');
		$h->a("http://www.iu.edu/", trim($h->endBuffer()), 'title="Indiana University" id="blockiu"');
		$h->tnl(" ");
		$h->a("http://www.iu.edu/comments/copyright.shtml", "Copyright");
		$h->tnl(" &copy; ".date("Y")." The Trustees of ");
		$h->a("http://www.iu.edu/", "Indiana University");
		$h->tnl("  &#124; ");
		$h->a("http://www.iu.edu/comments/complaint.shtml", "Copyright Complaints");
		$h->ctag("p");
		$links = array(
			array('href' => "/site/", 'display' => "Site Index"),
			array('href' => "/about/contact/", 'display' => "Contact Us"),
			array('href' => "/find/", 'display' => "Find People")
		);
		$h->linkList($links);
		$h->cdiv();
		
		$h->chtml();			
	}
}

?>