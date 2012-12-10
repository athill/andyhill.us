<?php
include_once("/ip/uirr/inc/html.class.php");
include_once("/ip/uirr/inc/Menu.class.php");
$h = html::singleton();

class Test {
	public $template;
	private $templateText = "Default";
	private $home;
	private $menu;
	private $includes = array(
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
	
	
	public function __construct($templateText="") {
		global $incroot;
		echo "constructing";
		
		if ($templateText != "") $this->templateText = $templateText;
		//include($template.".tmpl.php") or die("fail");


		//$this->template = new Test() or die("????");
		
		
		$xmlfile = $GLOBALS['fileroot'].'/www/menu.xml';
		$this->menu = new Menu($xmlfile);
		
	}
	
	public function loadTemplate() {
		include_once "templates/Test.php" or die("fail");
		//$arr = file("/ip/uirr/inc/site/templates/Test.php");
		//print_r($arr);
		$test = new Test2() or die("???");		
	}
	/*
	public function head() {
	  global $h;
	  $sheets = explode(",", $this->template->stylesheets);
	  for ($i = 0; $i < count($sheets); $i++) {
		$this->includes[] = $sheets[$i];  
	  }
	  $h->ohtml($title, $this->includes);
	  $h->body($this->template->bodyAtts);		
	}
	
	public function heading() {
		$this->template->heading();	
	}
	*/
}
?>