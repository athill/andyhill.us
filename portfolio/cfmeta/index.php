<?php
require_once('../../inc/setup.inc.php');
$page = new Page(array(
	'template'=>'Basic',
	'jsModules'=>array('slideshow'=>true),
	'pagetitle'=>'Metaprogramming in ColdFusion'
));


//// slideshow html
include('slideshow.php');

//// reveal.js stuff
$h->scriptfile(array('/js/reveal/lib/js/head.min.js', 
	'/js/reveal/js/reveal.min.js', 
	'/js/reveal/plugin/highlight/highlight.js')
);
$h->script("
Reveal.initialize({
	controls: true,
	progress: true,
	history: true,
	center: true,

	theme: Reveal.getQueryHash().theme, // available themes are in /css/theme
	transition: Reveal.getQueryHash().transition || 'default', // default/cube/page/concave/zoom/linear/none

	// Optional libraries used to extend on reveal.js
	dependencies: []
});
");
$page->end();
?>