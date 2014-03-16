<?php get_header() ?>

	<div id="container">
		<div id="content">

<?php if (have_posts()) : ?>

			<h2 class="page-title"><?php _e('Search Results for:', 'sandbox') ?> <span id="search-terms"><?php echo wp_specialchars(stripslashes($_GET['s']), true); ?></span></h2>

<?php while ( have_posts() ) : the_post() ?>
			<div id="post-<?php the_ID() ?>" class="post <?php sandbox_post_class() ?>">
				<?php
                    $title 	= get_the_title();
                    $keys= explode(" ",$s);
                    $title 	= preg_replace('/('.implode('|', $keys) .')/iu',
                        '<strong class="search-excerpt">\0</strong>',
                        $title);
                ?>
				<h2 class="entry-title"><a href="<?php the_permalink() ?>" title="<?php printf(__('Permalink to %s', 'sandbox'), wp_specialchars(get_the_title(), 1)) ?>" rel="bookmark"><?php echo $title; ?></a></h2>

				<?php if ( comments_open() ) : ?>
                <div class="entry-comments"><?php comments_popup_link(__('0', 'sandbox'), __('1', 'sandbox'), __('%', 'sandbox')) ?></div>
                <?php endif; ?> 

				<div class="clear"><!-- --></div>
				<div class="entry-meta">
					<span class="author vcard"><?php printf(__('Posted by %s on ', 'sandbox'), '<a class="url fn n" href="'.get_author_link(false, $authordata->ID, $authordata->user_nicename).'" title="' . sprintf(__('View all posts by %s', 'sandbox'), $authordata->display_name) . '">'.get_the_author().'</a>') ?></span><abbr class="published" title="<?php the_time('Y-m-d\TH:i:sO'); ?>"><?php unset($previousday); printf(__('%1$s &#8211; %2$s', 'sandbox'), the_date('', '', '', false), get_the_time()) ?></abbr>
				</div>
				<div class="entry-categ">
					<span class="cat-links"><?php printf(__('Filed under %s', 'sandbox'), get_the_category_list(', ')) ?></span>
					<?php if( function_exists('the_tags') ) {
                        // if there are no tags, this section does not appear
                        $tags = wp_get_post_tags($post->ID);
                        if ($tags) { ?>
							<br />
							<span class="cat-links">Tagged as <?php the_tags('') ?></span><?php 
	                    }
					} ?>
				</div>				
				<div class="entry-content">
<?php //the_content(''.__('Read More &raquo;', 'sandbox').''); ?>
				<?php
                    $content 	= get_the_content();
                    $keys= explode(" ",$s);
                    $content 	= preg_replace('/('.implode('|', $keys) .')/iu',
                        '<strong class="search-excerpt">\0</strong>',
                        $content);
                ?>
				<?php echo $content; ?>
<?php wp_link_pages("\t\t\t\t\t<div class='page-link'>".__('Pages: ', 'sandbox'), "</div>\n", 'number'); ?>
				</div>				
			</div><!-- .post -->

<?php comments_template() ?>
<?php endwhile ?>

			<div id="nav-below" class="navigation" style="margin-bottom:100px;">
				<div class="floater-left"><?php next_posts_link(__('<span class="meta-nav">&laquo;</span> Older posts', 'sandbox')) ?></div>
				<div class="floater-right"><?php previous_posts_link(__('Newer posts <span class="meta-nav">&raquo;</span>', 'sandbox')) ?></div>
				<div class="clear"></div>
			</div>

<?php else : ?>

			<div id="post-0" class="post noresults">
				<h2 class="entry-title"><?php _e('Nothing Found', 'sandbox') ?></h2>
				<div class="entry-content" style="clear:both; padding:25px;">
					<p><?php _e('Sorry, but nothing matched your search criteria. Please try again with some different keywords.', 'sandbox') ?></p>
				</div>
				<br />
			</div><!-- .post -->

<?php endif; ?>

		</div><!-- #content -->
		<?php get_sidebar() ?>
        <div class="clear"></div>
	</div><!-- #container -->

<?php get_footer() ?>