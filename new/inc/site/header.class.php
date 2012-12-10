<?php
include_once("/ip/uirr/inc/html.class.php");
include_once("/ip/uirr/inc/Menu.class.php");
	
$h = html::singleton();
	
	

class header {

	
	private $includes = array(
		"/global/css/import.css",
		"/css/import.css",
//		"/global/css/print.css",
//		"/global/js/sifr.js",
//		"/global/js/sifr-config.js",
		"/global/js/swfobject.js",
		"/global/js/nav.js",
		"/global/js/offspring.js",
		"/global/js/spamspan.js",
		"/global/js/breadcrumbs.js",
		"/js/newdocwindow.js",
		"/js/zebrarows.js",
		"/js/load.js",
		"/js/offsitelinks.js"	
	  );
	  
	  private $menu;
	  	
	public function __construct($title, $includes=array(), $sidebar="reports") {
	  global $h;
	  $xmlfile = $GLOBALS['fileroot'].'/www/menu.xml';
	  $this->menu = new Menu($xmlfile);
	  $h->ohtml($title, $this->includes);
	  $h->body('id="default" class="default"');	
	  ////Hidden navigation for impaired
	  $h->odiv('id="skip"');
	  $h->tag("p", '', "Skip to:", true);
	  $links = array(
	  	array("display" => "Content"),
		array("display" => "Search"),
		array("display" => "Primary Navigation"),
		array("display" => "Secondary Navigation"),
		array("display" => "Mini Index")
	  );
	  for ($i = 0; $i < count($links); $i++) $links[$i]['href'] = "#skip".($i+1);
	  $h->linkList($links);
	  $h->cdiv();
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
	  ////Side Nav
	  $this->displaySideNav($sidebar);
	  ////Content
	  $h->odiv('id="column2"');
	  $h->name("skip1");
	  $h->odiv('id="content"');
	  ////breadcrumbs
	  $h->odiv('id="breadcrumb"');
	  $h->script('KW_breadcrumbs("UIRR Home","&raquo;",0,1,"index.php",4,5)');
	  $h->cdiv();
	  $h->odiv('id="image4_hd_content"');
	  $h->h(3, $title);
	  $h->cdiv();
	  
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
		$this->menu->topNav();
		/*
		$links = array(
			array("href" => "/reports/", "display" => "Reports"),
			array("href" => "/surveys/", "display" => "Surveys"),
			array("href" => "/institutional/", "display" => "Institutional Research"),
			array("href" => "/epr/", "display" => "External Publics and Reporting"),
			array("href" => "/resources/", "display" => "Resources"),
			array("href" => "/about/", "display" => "About Us"),
			array("href" => "https://www.iu.edu/~uirr/intranet/index.shtml", "display" => "Intranet"),
		);	
		$h->linkList($links);
		*/
		$h->cdiv();
		
	}
	
	private function displaySideNav($type) {
		global $h;
		$h->odiv('id="column1"');
		$h->h(3, "Secondary Navigation", 'id="skip4"');
		$h->odiv('id="nav_vertical" class="subnav"');
		$links = array();
		switch ($type) {
			case "about":
				$root = $this->menu->xml->xpath("//links[@display='About Us']");
				$links = array();
				$pre = $root[0]['href'];
				foreach ($root[0] as $node) {
					$links[] = array('href' => $pre.$node['href'], 'display' => $node['display']);
				}
				break;	
			case "reports":
				$root = $this->menu->xml->xpath("//links[@display='Reports']");
				//print(count($root[0]->children()) . "<br />"););
				$links = $this->menu->xml2linkArray($root[0], "/reports/");
				//print_r($links);
				$tmp = array_pop($links);
				array_push($links, 
					array('href' => '/resources/IRDSI/', 'display' => 'Institutional Research Data Sources and Information'));
				array_push($links, $tmp);
				//print_r($links);
				break;
			default: 
				die("Bad sideNav type in header.class.php");
		}
		$h->linkList($links);
		$h->cdiv();	////close nav_vertical
		$h->cdiv();	////close column1	
		
	}
	
}

?>