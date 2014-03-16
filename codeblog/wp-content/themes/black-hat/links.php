<?php
/*
Template Name: Links
*/
?>
<?php get_header() ?>

	<div id="container">
		<div id="content">

			<?php the_post() ?>
			<div id="post-<?php the_ID(); ?>" class="post linkspg <?php sandbox_post_class() ?>">
				<h2 class="page-title"><?php the_title(); ?></h2>
				<div class="entry-content linkspglist">
                   <?php wp_list_bookmarks('title_li=&category_before=&category_after='); ?>
				</div>
			</div><!-- .post -->

<?php if ( get_post_custom_values('comments') ) comments_template() // Add a key+value of "comments" to enable comments on this page ?>

		</div><!-- #content -->
		<?php get_sidebar() ?>
        <div class="clear"></div>
	</div><!-- #container -->

<?php get_footer() ?>