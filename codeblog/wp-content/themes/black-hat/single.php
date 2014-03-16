<?php get_header() ?>

	<div id="container">
		<div id="content">
            <div class="navigationpage">
                 <div class="alignleftnav"><?php next_post_link('&laquo; %link') ?></div>
                 <div class="alignrightnav"><?php previous_post_link('%link &raquo;') ?></div>
            <div class="clear"></div>
            </div>

<?php the_post(); ?>

			<div id="post-<?php the_ID(); ?>" class="<?php sandbox_post_class() ?>">
				<h2 class="entry-title"><a href="<?php the_permalink() ?>" title="<?php printf(__('Permalink to %s', 'sandbox'), wp_specialchars(get_the_title(), 1)) ?>" rel="bookmark"><?php the_title() ?></a></h2>
				<div class="entry-meta">
					<span class="author vcard"><?php printf(__('Posted by %s on ', 'sandbox'), '<a class="url fn n" href="'.get_author_link(false, $authordata->ID, $authordata->user_nicename).'" title="' . sprintf(__('View all posts by %s', 'sandbox'), $authordata->display_name) . '">'.get_the_author().'</a>') ?></span><abbr class="published" title="<?php the_time('Y-m-d\TH:i:sO'); ?>"><?php unset($previousday); printf(__('%1$s &#8211; %2$s', 'sandbox'), the_date('', '', '', false), get_the_time()) ?></abbr> &nbsp; &nbsp; &nbsp; <?php edit_post_link('[ Edit ]', '', ''); ?>
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
<?php the_content(''.__('Read More <span class="meta-nav">&raquo;</span>', 'sandbox').''); ?>
<?php wp_link_pages("\t\t\t\t\t<div class='page-link'>".__('Pages: ', 'sandbox'), "</div>\n", 'number'); ?>
				</div>
                <!--
                <?php trackback_rdf(); ?>
                -->
				<div class="entry-footer">
					<img src="<?php bloginfo('template_directory'); ?>/images/comm_rss_icon.png" alt="" border="0" style="vertical-align:middle; float:none;" />
					<?php printf(__('<a href="%3$s" title="Comments RSS to %2$s" rel="alternate" type="application/rss+xml">Comments RSS Feed</a> <span>&nbsp;</span>', 'sandbox'), get_permalink(), wp_specialchars(get_the_title(), 'double'), comments_rss() ) ?>
					
<?php if ((comments_open()) && ('open' == $post->ping_status)) : // Comments and trackbacks open ?>
					<img src="<?php bloginfo('template_directory'); ?>/images/comments_icon.png" alt="" border="0" style="vertical-align:middle; float:none;" />
					<?php printf(__('<a class="comment-link" href="#respond" title="Post a comment">Post a comment</a> <span>&nbsp;</span>', 'sandbox'))?>
					<img src="<?php bloginfo('template_directory'); ?>/images/trackback_icon.png" alt="" border="0" style="vertical-align:middle; float:none;" />
					<?php printf(__('<a class="trackback-link" href="%s" title="Trackback URL for your post" rel="trackback">Trackback URL</a>', 'sandbox'), get_trackback_url()) ?>
<?php elseif (!(comments_open()) && ('open' == $post->ping_status)) : // Only trackbacks open ?>
					<?php printf(__('Comments are closed <span>&nbsp;</span>', 'sandbox')) ?>
					<img src="<?php bloginfo('template_directory'); ?>/images/trackback_icon.png" alt="" border="0" style="vertical-align:middle; float:none;" />
					<?php printf(__('<a class="trackback-link" href="%s" title="Trackback URL for your post" rel="trackback">Trackback URL</a>', 'sandbox'), get_trackback_url()) ?>
<?php elseif ((comments_open()) && !('open' == $post->ping_status)) : // Only comments open ?>
					<?php printf(__('Trackbacks are closed <span>&nbsp;</span>', 'sandbox')) ?>
					<img src="<?php bloginfo('template_directory'); ?>/images/comments_icon.png" alt="" border="0" style="vertical-align:middle; float:none;" />
					<?php printf(__('<a class="comment-link" href="#respond" title="Post a comment">Post a comment</a>', 'sandbox')) ?>
<?php elseif (!(comments_open()) && !('open' == $post->ping_status)) : // Comments and trackbacks closed ?>
					<?php _e('Both comments and trackbacks are currently closed') ?>
<?php endif; ?>
					<span>&nbsp;</span>
					<img src="<?php bloginfo('template_directory'); ?>/images/twitter_icon.png" alt="" border="0" style="vertical-align:middle; float:none;" />
					<?php
                    $turl = getTinyUrl(get_permalink($post->ID));
                    echo '<a href="http://twitter.com/home?status=Reading this: '.$turl.'" title="Send a link to this article on Twitter" target="_blank">Share on Twitter</a>';
                    ?>
					<span>&nbsp;</span>
					<img src="<?php bloginfo('template_directory'); ?>/images/facebook_icon.png" alt="" border="0" style="vertical-align:middle; float:none;" />
					<?php 
					$turl = getTinyUrl(get_permalink($post->ID)); ?>
					<a href="http://www.facebook.com/sharer.php?u=<?php echo $turl;?>&amp;t=<?php the_title(); ?>" target="blank">Share on Facebook</a>
				</div>
			</div><!-- .post -->
            
<?php global $options;
foreach ($options as $value) {
    if (get_settings( $value['id'] ) === FALSE) { $$value['id'] = $value['std']; } else { $$value['id'] = get_settings( $value['id'] ); }
}?>
            <?php if ($bh_related_posts == "false") { ?>

				<?php if( function_exists('the_tags') ) {
                    // for use in the loop, list 5 post titles related to first tag on current post
                    // if there are no tags, this section does not appear
				  $backup = $post;  // backup the current object
				  $tags = wp_get_post_tags($post->ID);
				  $tagIDs = array();
				  if ($tags) {
					$tagcount = count($tags);
					for ($i = 0; $i < $tagcount; $i++) {
					  $tagIDs[$i] = $tags[$i]->term_id;
					}
					$args=array(
					  'tag__in' => $tagIDs,
					  'post__not_in' => array($post->ID),
					  'showposts'=>5,
					  'caller_get_posts'=>1
					);
					$my_query = new WP_Query($args);
					if( $my_query->have_posts() ) {
									  echo '<div class="related">';
									  echo '<h3 class="related-title">Related Posts</h3>';
					  while ($my_query->have_posts()) : $my_query->the_post(); ?>
						<ul><li><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></li></ul>
					  <?php endwhile;
					echo '</div><!-- .related -->';
					}
				  }
				  $post = $backup;  // copy it back
				  wp_reset_query(); // to use the original query again

                } ?>
			<?php } ?>

<?php comments_template('', true); ?>

		</div><!-- #content -->
		<?php get_sidebar() ?>
        <div class="clear"></div>
	</div><!-- #container -->

<?php get_footer() ?>