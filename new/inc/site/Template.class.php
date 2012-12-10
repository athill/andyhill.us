<?php
include_once($GLOBALS['incroot']."/html.class.php");
$h = html::singleton();

class Template {
	private $template;
	private $templateText = "default";
	private $home;
	public $menu;
	private $includes = array(
		//"/global/js/swfobject.js",
//		"/global/js/nav.js",
		//"/global/js/offspring.js",
		//"/global/js/spamspan.js",
		//"/global/js/breadcrumbs.js",
		//"/js/newdocwindow.js",
		//"/js/zebrarows.js",
		//"/js/load.js",
		//"/js/offsitelinks.js"	
	  );
	
	
	public function __construct($menu, $templateText="default") {
		global $incroot;
		$this->templateText = $templateText;
		include_once($GLOBALS['incroot']."/site/templates/".$this->templateText.".class.php");
		$this->template = new TemplateInstance($this) or die("???");
		$this->menu = $menu;
	}
	
	public function head() {
	  global $h, $pageTitle;
	  ////Add scripts/sheets from template
	  $scripts = explode(",", $this->template->scripts);
	  $sheets = explode(",", $this->template->stylesheets);
	  $this->includes = array_merge($this->includes, $scripts, $sheets);
	  ////Add scripts/styles from jsModules
	  include_once($GLOBALS['incroot']."/JsModule.class.php");
	  $jsMods = new JsModule();
	  foreach ($GLOBALS['jsModules'] as $module => $bool) {
		  if ($bool) {
			  	$mod = $jsMods->modules[$module];
		  		$this->includes = array_merge($this->includes, $mod['scripts'], $mod['styles']);
		  }
	  }
 	  ////Add scripts/sheets from $GLOBALS
	  $this->includes = array_merge($this->includes, $GLOBALS['scripts'], $GLOBALS['stylesheets']);
	  ////HTML/head
	  $h->ohtml($pageTitle, $this->includes);
	  if (array_key_exists('headerExtra', $GLOBALS)) {
		$h->tnl($GLOBALS['headerExtra']);  
	  }
	  $h->body($this->template->bodyAtts);		
	}

	public function openLayout() {
		global $h;
		////Site structure
		$h->odiv('id="layout"');
		$class = "column123";
		if ($GLOBALS['leftSideBar'] != "none" && $GLOBALS['rightSideBar'] != "none") {
			$class = 'column2';
			$this->leftSideBar();
		} else if ($GLOBALS['leftSideBar'] != "none") {
			$class = 'column23';
			$this->leftSideBar();
		} else if ($GLOBALS['rightSideBar'] != "none") {
			$class = 'column12';
		}
		$h->odiv('id="content-wrapper" class="'.$class.'"');
		$h->odiv('id="content"');
	}

	function closeLayout() {
		$h->cdiv();	////close content
		$h->cdiv();	//close content-wrapper
		if ($GLOBALS['rightSideBar']) {
			$this->rightSideBar();
		}
		$h->cdiv();	//close layout


	}
	
	
	////For accessibility
	public function skipNav() {
	  global $h;
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
	}
	////Website header
	public function heading() {
		$this->template->heading();	
	}
	
	////Left side bar
	public function leftSideBar() {
		global $h, $leftSideBar;
		$h->odiv('id="column1"');
		$h->tbr("lsb");
		$h->cdiv(); //close column 1
				
	}

	public function rightSideBar() {
		global $h;
		$h->odiv('id="column3"');
		$h->tbr("rsb");
		$h->cdiv(); //close column 3
	}
	
	public function breadcrumbs() {
	  global $h;
	  //$h->script('KW_breadcrumbs("UIRR Home","&raquo;",0,1,"index.php",4,5)');		
	  $this->menu->displayPath();
	}
	
	public function footer() {
		$this->template->footer();	
	}
	
}
?>
