<?php
/**
 * XML menu interface
 * Expects and XML file of the following "schema":
 * Root node: menu (no attributes)
 * "links" nodes have children, "link" nodes are empty
 * Both "links" and "link" nodes support the following attributes 
 * 	 (white space is ignored)
 * 	Required	
 * 		display - text to display (could default to href in the future, but how
 * 			often do you have a URL in a menu?)
 * 		href - Generally the portion of the path in the script path
 *	 		TODO: finish
 * 	Optional
 * 		redirect - override href path
 * 		target - same as anchor tag target
 * 		security - list of security tokens. Security implementation is up to 
 * 			the developer. 
 * @package includes
 * @author andy hill 1 2009
 * @version 1.0
 *
 */

//include_once($GLOBALS['incroot']."/html.class.php");


class Menu {
	 	
 	/**
	 * Simple Xml Object
	 *
	 */  
 	public $xml;
	private $debugOn = true;//; 	
	var $host = "";
	var $path = "";
	var $script;
 	/**
	 * constructor
	 *
	 * create an instance of the Menu class
	 *
	 * @param 
	 */ 
 	function __construct($pathToXmlFile, $script="") {
		global $site; 		
		$this->debugOn = ($_SERVER['REMOTE_ADDR'] == '24.1.115.39') && false;
		if(!$this->xml=simplexml_load_file($pathToXmlFile)) {
		    trigger_error('Error reading XML file',E_USER_ERROR);
		}
//print_r($GLOBALS);
		$this->script = ($script=="") ? $site['script'] : $script;
		$this->path = $site['path'];		
		if (array_key_exists('REDIRECT_URL', $_SERVER)) {
			$path = $_SERVER['REDIRECT_URL'];
			if (stripos($path, $webroot) === 0) {
				$path = str_ireplace($webroot, "", $path);
			}						
			$this->path = $path;
			$this->script = explode("/", $path);
			if (count($this->script) > 0 && $this->script[0] == "") {
				array_shift($this->script);
			}
		}
		
		$this->host = $_SERVER['HTTP_HOST'];
	}

	function menuList($options=array()) {
		global $h;
		$defaults = array(
			'path' => $this->path,
			'maxdepth'=>0,
			'atts'=>''
		);
		$opts = $h->extend($defaults, $options);
		if ($this->debugOn) $h->pa($opts);
		$node = $this->getNodeFromPath(array('path'=>$opts['path']));
		$array = $this->xmlMenu2array(array('xml'=>$node, 'root'=>$opts['path'], 'maxdepth'=>$opts['maxdepth']));
		$h->linkList($array, $opts['atts']);
	}
	
	////TODO: Used for directory listings, etc. Use xpath
	function getNodeFromPath($options=array()) {
		global $site, $h;
		$d = $this->debugOn && false; 	////debug
		$defaults = array(
			'path' => $this->path,
			'xml' => $this->xml,
			'return'=>null
		);
		$opts = $h->extend($defaults, $options);
		$path = $opts['path'];
		if (stripos($path, $site['webroot']) === 0) {
			$path = str_ireplace($site['webroot'], "", $path);
		}
		foreach ($opts['xml'] as $tagname => $node) {		
			$href = (string)$node['href'];
			if ($d) $h->tbr('path: ' . $path . ' href: '. $href);			
			if (stripos($path, $href) === 0 || stripos($path.'/', $href) === 0) {
				if ($d) $h->tbr('Match!');
				if ($path == "/") {
					if ($d) $h->tbr('root node match');
					return $node;
				} else if ($href == "/") {
					continue;
				} else {
					if ($d) $h->tbr('non-root node match');
					$path = str_ireplace($href, "", $path);
					if ($d) $h->tbr('path: '. $path . 'len: '. strlen($path));	
					if (strlen($path) == 0) {
						return $node;
					} else {
						if (!preg_match("\/$", $path)) $path .= "/";
							return $this->getNodeFromPath(array(
									'path'=>$path,
									'xml' => $node,
									'return'=>$node
						));

					}
				}				
			}
		}
		return $opts['return'];

	}

	
	/************************************
	 *Title and breadcrumbs
	 ************************************/
	function parseData($options=array()) {
		global $h, $site;
		$defaults = array(
			'xml' => $this->xml,	////MenuXml to parse -- used in recursion
			'script' => str_replace('index.php', '', $_SERVER['PHP_SELF']),
			'path'=>$site['webroot'],	////Build the path -- used in recursion
			'depth'=>0,				////Current depth -- used in recursion
			'return'=> array(
						'breadcrumbs'=> array(
							array('href'=>'/', 'display'=>'Home')
						), ////seq of assoc: href,display
						'pagetitle'=>"",		////pagetitle
						'complete'=>false,		////full url matched
					)
		);

		$opts = $h->extend($defaults, $options);
		$isRoot = $opts['script'] == $site['webroot'].'/';
		////Main loop over children
		foreach ($opts['xml']->children() as $elem) {
			// print_r($elem);
			if (array_key_exists('redirect', $elem)) {
				continue;
			}
			//// root exception
			if ($elem['href'] == '/') {
				if ($isRoot) {
					$opts['return']['pageTitle'] = (string)$elem['display'];
					$opts['return']['complete'] = true;
					return $opts['return'];
				} else {
					continue;
				}
			}
			$compare = $opts['path'].$elem['href'];
			//// match
			if (strpos($opts['script'], $compare) === 0) {
				$display = (string)$elem['display'];
				$opts['path'] = $compare;
				$opts['depth']++;
				$opts['return']['breadcrumbs'][] = array(
					'href'=>$compare,
					'display'=>$display,
				);
				$opts['return']['pagetitle'] = $display;
				// echo 'cpm: '.$opts['script'].' '.$compare."\n";
				if ($opts['script'] === $compare) {
					$opts['return']['complete'] = true;
					return $opts['return'];
				} else if (count($elem->children())) {
					$opts['xml'] = $elem;
					return $this->parseData($opts);
				}
			}
		}
		return $opts['return'];
	}

	function renderBreadcrumbs($options) {
		global $h, $webroot;
		$defaults = array(
			'breadcrumbs'=>array(),
			'delimiter'=>' &gt; '
		);
		$opts = $h->extend($defaults, $options);		
		$len = count($opts['breadcrumbs']);
		$lis = array();
		foreach ($opts['breadcrumbs'] as $i => $bc) {
			$lis[] = ($i < $len - 1) ?
				$h->rtn('a', [$bc['href'], $bc['display']]) :
				$bc['display'];
		}

		$h->liArray('ul', $lis);
		return;
	}



	////////////////////////////////////////////////////
	//// Takes an XML menu and returns array of the form 
	//// $array = [ { href=$href, $display=$display, 
	////				atts=$atts, children=[
	////					....
	////		   	] },
	////			...
	////];
	//// which can be passed to HTML.linkList()
	///////////////////////////////////////////////////
	function xmlMenu2array($options=array()) {
		global $h;
		
		$d = $this->debugOn && false; 	////debug
		$defaults = array(
			'xml' => $this->xml,	////Xml to parse -- used in recursion
			'path'=>'',				////Build the path -- used in recursion
			'maxdepth'=>-1,			////How deep to go
			'testFunction'=>"",		////optional function to determine active tab
			'depth'=>0,				////Current depth -- used in recursion
			'root'=>''
		);
		
		$opts = $h->extend($defaults, $options);
		$array = array();

		foreach ($opts['xml'] as $tagname => $node) {
			$item = array();			
			foreach ($node->attributes() as $key => $value) {
				$item[$key] = (string)$value;
			}
			if (array_key_exists('target', $item)) {
				$item['atts'] = 'target="'.$item['target'].'"';
				unset($item['target']);
			}
			$href = $item['href'];
			$item = $this->parseItem($item, $opts['root'].$opts['path'], $opts['depth'], $opts['testFunction']);
			if ($d) $h->pa($item);
			if (count($node->children()) > 0 && ($opts['maxdepth'] == -1 || $opts['depth'] < $opts['maxdepth'])) {
//				$h->tbr('path: '.$opts['path'] .' href: '. $item['href'] .' root: ' . $opts['root']);
				$item['children'] = $this->xmlMenu2array(
					array('xml'=>$node, 
						'depth'=>++$opts['depth'],
						'path' => $opts['path'].$href,
						'root' => $opts['root']
					)
				);
			}
			$array[] = $item;
		}
		return $array;
	}


	///////////////////////////////////////////////////
	///// Converts MenuXML node to linkList (in html) 
	///// list item. 
	///// TODO: Use strpos on path?
	///////////////////////////////////////////////////
	function parseItem($item, $path, $depth, $test="") {
		global $h;
		$d = false; 		////debug
		$active = false;	////node is in path
		if ($d) print_r($this->script);
		////If href is in pipe form, split into href|display
		if (strpos($item['href'], "|") > -1) {	
			list($item['href'], $item['display']) = explode("|", $item['href']);	
		}
		/////Exception for matching root element
		if (count($this->script) == 0 && $depth == 0 && $item['href'] == "/") {
			$item['liAtts'] = 'class="active"';
			if ($d) $h->tbr('active!');
			return $item;			
		}
		////If redirect attribute exists, that's the link and it's not in the path,
		//// hence return
		if (array_key_exists('redirect', $item)) {
			$item['href'] = $item['redirect'];
			unset($item['redirect']);
			return $item;
		////Otherwise, append href to path
		} else {
			$item['href'] = $path.$item['href'];
		}
		////Step is used in comparison to current step in path
		////Remove forward slashes to match step in path
		$step = str_replace("/", "", $item['href']);
		////debugging
		if ($d) {
			if ($depth < count($this->script)) {
				 $h->tbr('step: '.$step .': depth: '. $this->script[$depth] . ' href: ' . $item['href']);
			} else {
				$h->tbr('depth > $count');
			}
		}
		//////check if item is in path, if so, set as active
		if ($test != "" && $test->test($item)) { 
			$active = true;	
		} else if ($item['href'] == $this->path || 
				(isset($_SERVER['QUERY_STRING']) && $item['href'] == './?'.$_SERVER['QUERY_STRING']) || 
				($depth < count($this->script) && $step == $this->script[$depth])) {
			$active = true;
		}
		if ($active) {
			$item['liAtts'] = 'class="active"';
			if ($d) $h->tbr('active!');
		}
//		$item['href'] = $href;
		return $item;
	}
		
	
	function debug($str, $obj="") {
		global $h;
		if ($this->debugOn) {
			$h->tbr("DEBUG: " . (string)$str);
			if ($obj != "") {
				$h->pa($obj);
			}
		}
	}
}
?>