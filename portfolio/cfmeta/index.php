<?php
$local['template'] = 'Basic';
$local['jsModules']['slideshow'] = true;
$local['pageTitle'] = 'Metaprogramming in ColdFusion';
include('../../inc/application.php');

//// slideshow html
include('slideshow.php');

//// reveal.js stuff
$h->scriptfile(array('/js/reveal/lib/js/head.min.js', 
	'/js/reveal/js/reveal.min.js', 
	'/js/reveal/plugin/highlight/highlight.js')
);
?>
<script>
//<![CDATA[

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
			
//]]>
</script>
<?php
$template->footer();
?>