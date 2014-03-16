<?php
/*
Template Name: Sitemap
*/
?>
<?php get_header() ?>

	<div id="container">
		<div id="content">

			<?php the_post() ?>
			<div id="post-<?php the_ID(); ?>" class="post sitemap <?php sandbox_post_class() ?>">
				<h2 class="page-title"><?php the_title(); ?></h2>
				<div class="entry-content">

                    <h3>All internal pages:</h3>
                    <?php
                        if ( function_exists('wp_list_comments') ) { // WP 2.7 check, use new pages function
                            wp_page_menu('');
                        } else { // use legacy pages function
                            echo '<ul>';
                            wp_list_pages('title_li=');
                            echo "</ul>";
                        }
                    ?>
                    
                    <h3>All internal blog posts:</h3>
                    <ul>
                        <?php $archive_query = new WP_Query('showposts=99999');
                            while ($archive_query->have_posts()) : $archive_query->the_post(); ?>
                        <li><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title(); ?>"><?php the_title(); ?></a></li>
                        <?php endwhile; ?>
                    </ul>
                    
                    <h3>Monthly archive pages:</h3>
                    <ul>
                        <?php wp_get_archives('type=monthly'); ?>
                    </ul>
                    
                    <h3>Categories:</h3>
                    <ul>
                        <?php wp_list_categories('orderby=name&show_count=1&title_li='); ?>
                    </ul>
                    
                    <h3>Tags:</h3>
                    <p>
                        <?php wp_tag_cloud('smallest=8&largest=22'); ?>
                    </p>

				</div>
			</div><!-- .post -->

<?php if ( get_post_custom_values('comments') ) comments_template() // Add a key+value of "comments" to enable comments on this page ?>

		</div><!-- #content -->
		<?php get_sidebar() ?>
        <div class="clear"></div>
	</div><!-- #container -->

<?php get_footer() ?>