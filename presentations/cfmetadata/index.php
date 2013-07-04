<?php
$local['jsModules']['slideshow'] = true;
$local['template'] = 'Basic';
include('../../inc/application.php');




?>

		<div class="reveal">

			<!-- Any section element inside of this container is displayed as a slide -->
			<div class="slides">

				<section>
					<h1>Reveal.js</h1>
					<h3>HTML Presentations Made Easy</h3>
					<p>
						<small>Created by <a href="http://hakim.se">Hakim El Hattab</a> / <a href="http://twitter.com/hakimel">@hakimel</a></small>
					</p>
				</section>
				<section>
					<h2>Heads Up</h2>
					<p>
						reveal.js is a framework for easily creating beautiful presentations using HTML. You'll need a browser with
						support for CSS 3D transforms to see it in its full glory.
					</p>

					<aside class="notes">
						Oh hey, these are some notes. They'll be hidden in your presentation, but you can see them if you open the speaker notes window (hit 's' on your keyboard).
					</aside>
				</section>				
			</div>
		</div>



		<script src="/andyhill/js/reveal.js/lib/js/head.min.js"></script>
		<script src="/andyhill/js/reveal.js/js/reveal.min.js"></script>

		<script>

			// Full list of configuration options available here:
			// https://github.com/hakimel/reveal.js#configuration
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

		</script>		


<?php
$template->footer();
?>