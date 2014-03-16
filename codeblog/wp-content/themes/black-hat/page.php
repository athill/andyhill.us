<?php get_header() ?>

	<div id="container">
		<div id="content">

<?php while ( have_posts() ) : the_post() ?>
			<div id="post-<?php the_ID(); ?>" class="post <?php sandbox_post_class() ?>">
				<h2 class="page-title"><?php the_title(); ?></h2>
				<div class="entry-meta">
					<?php edit_post_link('[ Edit ]', '', ''); ?>
				</div>
				<div class="entry-content">
<?php the_content() ?>

<br />
<?php wp_link_pages("\t\t\t\t\t<div class='page-link'>".__('Pages: ', 'sandbox'), "</div>\n", 'number'); ?>

				</div>
			</div><!-- .post -->

<?php comments_template('', true); ?>
<?php endwhile ?>
		</div><!-- #content -->
		<?php get_sidebar() ?>
        <div class="clear"></div>
	</div><!-- #container -->

<?php get_footer() ?>