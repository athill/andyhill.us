<?php get_header() ?>

	<div id="container">
		<div id="content">

			<div id="post-0" class="post error404">
				<h2 class="entry-title"><?php _e('Error 404 - Not Found', 'sandbox') ?></h2>
				<div class="entry-content" style="clear:both; padding:25px;">
					<p><img src="<?php bloginfo('template_url'); ?>/images/404.png" alt="" class="alignleft" />
                        <br />
                        Ooops! Something went wrong somewhere. We're pretty sure it's something Sparky did. Or maybe we should've taken that left turn at Albuquerque.  </p>
					<p>What ever it is you're looking for is not here. Sorry! </p>
					<p>Try going to the <a href="<?php echo get_option('home'); ?>/">home page</a> or use the search function to find the content for which you're looking.</p>
			  </div>
			</div><!-- .post -->

		</div><!-- #content -->
		<?php get_sidebar() ?>
        <div class="clear"></div>
	</div><!-- #container -->

<?php get_footer() ?>