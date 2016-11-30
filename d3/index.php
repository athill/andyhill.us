<?php
include('../inc/setup.inc.php');
$page = new Page(array(
	'jsModules' => array('d3'=>true, 'treemenu'=>true),
	'leftSideBar'=>array('type' =>'menu', 'args' => array()),
));

$g3=<<<EOT
<a href="http://d3js.org/" target="_blank">D3.js</a> is a JavaScript library for manipulating 
documents based on data. Most of what I've done is just tutorials and simple things, but I'd 
like to do cooler things like <a href="http://bl.ocks.org/mbostock/4657115" target="_blank">this</a>.
EOT;
$h->p($g3);

$site['menu']->menuList();

$page->end();
