<?php global $options;
foreach ($options as $value) {
    if (get_settings( $value['id'] ) === FALSE) { $$value['id'] = $value['std']; } else { $$value['id'] = get_settings( $value['id'] ); }
}?>

	<div id="sidebar">
		<ul class="xoxo">

			<li class="widget">
				<h3><?php _e('Subscribe', 'sandbox') ?></h3>
                <p style="margin:8px auto; text-align:center">
                
                    <?php if (trim($bh_use_fb_link == "")) { ?>
                        <a href="<?php bloginfo('rss_url'); ?>"><img style="float:none" src="<?php bloginfo('template_url'); ?>/images/rss_feed.gif" alt="" title="Subscribe to <?php bloginfo('name'); ?>" /></a>
                    <?php } else { ?>
                        <a href="http://feeds2.feedburner.com/<?php echo $bh_use_fb_link; ?>"><img style="float:none" src="<?php bloginfo('template_url'); ?>/images/rss_feed.gif" alt="" title="Subscribe to <?php bloginfo('name'); ?>" /></a>
                    <?php } ?>                
                
                    <?php if (trim($bh_use_fb_email == "")) { ?>
                    <?php } else { ?>
                        <a href="http://feedburner.google.com/fb/a/mailverify?uri=<?php echo $bh_use_fb_email; ?>&amp;loc=en_US"><img style="float:none; margin-left:10px;" src="<?php bloginfo('template_url'); ?>/images/email.gif" alt="" title="Subscribe to <?php bloginfo('name'); ?> via email" /></a>
                    <?php } ?>                
                
                </p>
			</li>
            
            <?php if (trim($bh_twitter_name == "")) { ?>
            <?php } else { ?>
                <li class="widget">
                    <?php
                    
                    // Your twitter username.
                    $username = $bh_twitter_name;
                    
                    // Prefix - some text you want displayed before your latest tweet.
                    // (HTML is OK, but be sure to escape quotes with backslashes: for example href=\"link.html\")
                    $prefix = "<h3>My last Tweet</h3>";
                    
                    // Suffix - some text you want display after your latest tweet. (Same rules as the prefix.)
                    $suffix = "";
                    
                    $feed = "http://search.twitter.com/search.atom?q=from:" . $username . "&rpp=1";
                    
                    function parse_feed($feed) {
                        $stepOne = explode("<content type=\"html\">", $feed);
                        $stepTwo = explode("</content>", $stepOne[1]);
                        $tweet = $stepTwo[0];
                        $tweet = str_replace("&lt;", "<", $tweet);
                        $tweet = str_replace("&gt;", ">", $tweet);
                        return $tweet;
                    }
                    
                    $twitterFeed = file_get_contents($feed);
                    echo stripslashes($prefix) . '<div class="textwidget">' . parse_feed($twitterFeed) . stripslashes($suffix) . '</div>';
					?>
                    <p align="center"><a href="http://twitter.com/<?php echo $bh_twitter_name; ?>"><img style="float:none;" src="<?php bloginfo('template_url'); ?>/images/twitter.png" alt="" /></a></p>
                </li>
            <?php } ?>                

<?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar(1) ) : // begin primary sidebar widgets ?>

			<li id="meta" class="widget">
				<h3><?php _e('Meta', 'sandbox') ?></h3>
                <ul>
                    <?php wp_register() ?>
                    <li><?php wp_loginout() ?></li>
                    <?php wp_meta() ?>
                </ul>
			</li>

			<li id="categories" class="widget">
				<h3><?php _e('Categories', 'sandbox'); ?></h3>
				<ul>
					<?php wp_list_categories('title_li=&show_count=0&hierarchical=1') ?> 
				</ul>
			</li>

			<li id="archives" class="widget">
				<h3><?php _e('Archives', 'sandbox') ?></h3>
				<ul>
					<?php wp_get_archives('type=monthly') ?>
				</ul>
			</li>
			
<?php endif; // end primary sidebar widgets  ?>
		</ul>
	</div><!-- #primary .sidebar -->