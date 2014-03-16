<?php
add_filter('comments_template', 'legacy_comments');
function legacy_comments($file) {
	if(!function_exists('wp_list_comments')) 	$file = TEMPLATEPATH . '/legacy.comments.php';
	return $file;
}

function list_pings($comment, $args, $depth) {
       $GLOBALS['comment'] = $comment;
?>
<li id="comment-<?php comment_ID(); ?>"><?php comment_author_link(); ?>
<?php }

add_filter('get_comments_number', 'comment_count', 0);

function comment_count( $count ) {
	global $id;
	$get_comments= get_comments('post_id=' . $id);
	$comments_by_type = &separate_comments($get_comments);
	return count($comments_by_type['comment']);
}

function getTinyUrl($url) {
    $tinyurl = file_get_contents("http://tinyurl.com/api-create.php?url=".$url);
    return $tinyurl;
}

function sandbox_globalnav() {
	if ( function_exists('wp_list_comments') ) { // WP 2.7 check, use new pages function
		?><div id="menu"><?php
		$menu = wp_page_menu('show_home=1&menu_class=page-navi'); // Params for the page list in header.php
		echo str_replace(array("\r", "\n", "\t"), '', $menu);
		?><?php if (is_user_logged_in()) { ?><ul><li><?php wp_register('', ''); ?></li><li><?php wp_loginout(); ?></li></ul><?php } ?></div><?php
	} else { // use legacy pages function
		echo '<div id="menu"><ul><li><a href="'.get_option('home').'/" title="'.__('Homepage', 'sandbox').'">'.__('Home', 'sandbox').'</a></li>';
		$menu = wp_list_pages('title_li=&sort_column=menu_order&echo=0'); // Params for the page list in header.php
		echo str_replace(array("\r", "\n", "\t"), '', $menu);
		?><li><?php wp_register('', ''); ?></li><li><?php wp_loginout(); ?></li><?php
		echo "</ul></div>\n";
	}
}

function widget_mytheme_pages() {
	/* Pages are in the header.  No need to have them in the sidebar too. */
}

function widget_mytheme_rsslinkies() {
	/* Already in sidebar.  No need to have them repeated. */
}

// Generates semantic classes for BODY element
function sandbox_body_class( $print = true ) {
	global $wp_query, $current_user;
	
	// It's surely a WordPress blog, right?
	$c = array('wordpress');

	// Applies the time- and date-based classes (below) to BODY element
	sandbox_date_classes(time(), $c);

	// Generic semantic classes for what type of content is displayed
	is_home()       ? $c[] = 'home'       : null;
	is_archive()    ? $c[] = 'archive'    : null;
	is_date()       ? $c[] = 'date'       : null;
	is_search()     ? $c[] = 'search'     : null;
	is_paged()      ? $c[] = 'paged'      : null;
	is_attachment() ? $c[] = 'attachment' : null;
	is_404()        ? $c[] = 'four04'     : null; // CSS does not allow a digit as first character

	// Special classes for BODY element when a single post
	if ( is_single() ) {
		$postID = $wp_query->post->ID;
		the_post();

		// Adds 'single' class and class with the post ID
		$c[] = 'single postid-' . $postID;

		// Adds classes for the month, day, and hour when the post was published
		if ( isset($wp_query->post->post_date) )
			sandbox_date_classes(mysql2date('U', $wp_query->post->post_date), $c, 's-');

		// Adds category classes for each category on single posts
		if ( $cats = get_the_category() )
			foreach ( $cats as $cat )
				$c[] = 's-category-' . $cat->slug;

		// Adds tag classes for each tags on single posts
		if ( $tags = get_the_tags() )
			foreach ( $tags as $tag )
				$c[] = 's-tag-' . $tag->slug;

		// Adds MIME-specific classes for attachments
		if ( is_attachment() ) {
			$the_mime = get_post_mime_type();
			$boring_stuff = array("application/", "image/", "text/", "audio/", "video/", "music/");
				$c[] = 'attachment-' . str_replace($boring_stuff, "", "$the_mime");
		}

		// Adds author class for the post author
		$c[] = 's-author-' . sanitize_title_with_dashes(strtolower(get_the_author_login()));
		rewind_posts();
	}

	// Author name classes for BODY on author archives
	else if ( is_author() ) {
		$author = $wp_query->get_queried_object();
		$c[] = 'author';
		$c[] = 'author-' . $author->user_nicename;
	}

	// Category name classes for BODY on category archvies
	else if ( is_category() ) {
		$cat = $wp_query->get_queried_object();
		$c[] = 'category';
		$c[] = 'category-' . $cat->slug;
	}

	// Tag name classes for BODY on tag archives
	else if ( is_tag() ) {
		$tags = $wp_query->get_queried_object();
		$c[] = 'tag';
		$c[] = 'tag-' . $tags->slug; // Does not work; however I try to return the tag I get a false. Grrr.
	}

	// Page author for BODY on 'pages'
	else if ( is_page() ) {
		$pageID = $wp_query->post->ID;
		the_post();
		$c[] = 'page pageid-' . $pageID;
		$c[] = 'page-author-' . sanitize_title_with_dashes(strtolower(get_the_author('login')));
		rewind_posts();
	}

	// For when a visitor is logged in while browsing
	if ( $current_user->ID )
		$c[] = 'loggedin';

	// Paged classes; for 'page X' classes of index, single, etc.
	if ( ( ( $page = $wp_query->get("paged") ) || ( $page = $wp_query->get("page") ) ) && $page > 1 ) {
		$c[] = 'paged-'.$page.'';
		if ( is_single() ) {
			$c[] = 'single-paged-'.$page.'';
		} else if ( is_page() ) {
			$c[] = 'page-paged-'.$page.'';
		} else if ( is_category() ) {
			$c[] = 'category-paged-'.$page.'';
		} else if ( is_tag() ) {
			$c[] = 'tag-paged-'.$page.'';
		} else if ( is_date() ) {
			$c[] = 'date-paged-'.$page.'';
		} else if ( is_author() ) {
			$c[] = 'author-paged-'.$page.'';
		} else if ( is_search() ) {
			$c[] = 'search-paged-'.$page.'';
		}
	}

	// Separates classes with a single space, collates classes for BODY
	$c = join(' ', apply_filters('body_class',  $c));

	// And tada!
	return $print ? print($c) : $c;
}

// Generates semantic classes for each post DIV element
function sandbox_post_class( $print = true ) {
	global $post, $sandbox_post_alt;

	// hentry for hAtom compliace, gets 'alt' for every other post DIV, describes the post type and p[n]
	$c = array('hentry', "p$sandbox_post_alt", $post->post_type, $post->post_status);

	// Author for the post queried
	$c[] = 'author-' . sanitize_title_with_dashes(strtolower(get_the_author('login')));

	// Category for the post queried
	foreach ( (array) get_the_category() as $cat )
		$c[] = 'category-' . $cat->slug;

	// Tags for the post queried
	foreach ( (array) get_the_tags() as $tag )
		$c[] = 'tag-' . $tag->slug;

	// For password-protected posts
	if ( $post->post_password )
		$c[] = 'protected';

	// Applies the time- and date-based classes (below) to post DIV
	sandbox_date_classes(mysql2date('U', $post->post_date), $c);

	// If it's the other to the every, then add 'alt' class
	if ( ++$sandbox_post_alt % 2 )
		$c[] = 'alt';

	// Separates classes with a single space, collates classes for post DIV
	$c = join(' ', apply_filters('post_class', $c));

	// And tada!
	return $print ? print($c) : $c;
}

// Define the num val for 'alt' classes (in post DIV and comment LI)
$sandbox_post_alt = 1;

// Generates semantic classes for each comment LI element
function sandbox_comment_class( $print = true ) {
	global $comment, $post, $sandbox_comment_alt;

	// Collects the comment type (comment, trackback),
	$c = array($comment->comment_type);

	// Counts trackbacks (t[n]) or comments (c[n])
	if ($comment->comment_type == 'trackback') {
		$c[] = "t$sandbox_comment_alt";
	} else {
		$c[] = "c$sandbox_comment_alt";
	}

	// If the comment author has an id (registered), then print the log in name
	if ( $comment->user_id > 0 ) {
		$user = get_userdata($comment->user_id);

		// For all registered users, 'byuser'; to specificy the registered user, 'commentauthor+[log in name]'
		$c[] = "byuser comment-author-" . sanitize_title_with_dashes(strtolower($user->user_login));
		// For comment authors who are the author of the post
		if ( $comment->user_id === $post->post_author )
			$c[] = 'bypostauthor';
	}

	// If it's the other to the every, then add 'alt' class; collects time- and date-based classes
	sandbox_date_classes(mysql2date('U', $comment->comment_date), $c, 'c-');
	if ( ++$sandbox_comment_alt % 2 )
		$c[] = 'alt';

	// Separates classes with a single space, collates classes for comment LI
	$c = join(' ', apply_filters('comment_class', $c));

	// Tada again!
	return $print ? print($c) : $c;
}

// Generates time- and date-based classes for BODY, post DIVs, and comment LIs; relative to GMT (UTC)
function sandbox_date_classes($t, &$c, $p = '') {
	$t = $t + (get_option('gmt_offset') * 3600);
	$c[] = $p . 'y' . gmdate('Y', $t); // Year
	$c[] = $p . 'm' . gmdate('m', $t); // Month
	$c[] = $p . 'd' . gmdate('d', $t); // Day
	$c[] = $p . 'h' . gmdate('H', $t); // Hour
}

// For category lists on category archives: Returns other categories except the current one (redundant)
function sandbox_cats_meow($glue) {
	$current_cat = single_cat_title('', false);
	$separator = "\n";
	$cats = explode($separator, get_the_category_list($separator));

	foreach ( $cats as $i => $str ) {
		if ( strstr($str, ">$current_cat<") ) {
			unset($cats[$i]);
			break;
		}
	}

	if ( empty($cats) )
		return false;

	return trim(join($glue, $cats));
}

// For tag lists on tag archives: Returns other tags except the current one (redundant)
function sandbox_tag_ur_it($glue) {
	$current_tag = single_tag_title('', '',  false);
	$separator = "\n";
	$tags = explode($separator, get_the_tag_list("", "$separator", ""));

	foreach ( $tags as $i => $str ) {
		if ( strstr($str, ">$current_tag<") ) {
			unset($tags[$i]);
			break;
		}
	}

	if ( empty($tags) )
		return false;

	return trim(join($glue, $tags));
}


// Widget: Search; to match the Sandbox style and replace Widget plugin default
function widget_sandbox_search($args) {
	extract($args);
	if ( empty($title) )
		$title = __('Search', 'sandbox');
?>
		<?php echo $before_widget ?>
			<?php echo $before_title ?><label for="s"><?php echo $title ?></label><?php echo $after_title ?>
			<form id="searchform" method="get" action="<?php bloginfo('home') ?>" style="width:191px; margin:5px auto; padding:2px 5px;">
				<div class="iffy">
					<input id="s" name="s" type="text" value="<?php echo wp_specialchars(stripslashes($_GET['s']), true) ?>" tabindex="1" />
                    <input id="searchsubmit" name="searchsubmit" type="image" src="<?php bloginfo('template_url'); ?>/images/search_magnifier.gif" tabindex="2" />
				</div>
			</form>
		<?php echo $after_widget ?>

<?php
}

// Widget: Meta; to match the Sandbox style and replace Widget plugin default
function widget_sandbox_meta($args) {
	extract($args);
	if ( empty($title) )
		$title = __('Meta', 'sandbox');
?>
		<?php echo $before_widget; ?>
			<?php echo $before_title . $title . $after_title; ?>
			<ul>
				<?php wp_register() ?>
				<li><?php wp_loginout() ?></li>
				<?php wp_meta() ?>
			</ul>
		<?php echo $after_widget; ?>
<?php
}

// Widget: RSS links; to match the Sandbox style
function widget_sandbox_rsslinks($args) {
	extract($args);
	$options = get_option('widget_sandbox_rsslinks');
	$title = empty($options['title']) ? __('RSS Links', 'sandbox') : $options['title'];
?>
		<?php echo $before_widget; ?>
			<?php echo $before_title . $title . $after_title; ?>
			<ul>
				<li><a href="<?php bloginfo('rss2_url') ?>" title="<?php echo wp_specialchars(get_bloginfo('name'), 1) ?> <?php _e('Posts RSS feed', 'sandbox'); ?>" rel="alternate" type="application/rss+xml"><?php _e('All posts', 'sandbox') ?></a></li>
				<li><a href="<?php bloginfo('comments_rss2_url') ?>" title="<?php echo wp_specialchars(bloginfo('name'), 1) ?> <?php _e('Comments RSS feed', 'sandbox'); ?>" rel="alternate" type="application/rss+xml"><?php _e('All comments', 'sandbox') ?></a></li>
			</ul>
		<?php echo $after_widget; ?>
<?php
}

// Widget: RSS links; element controls for customizing text within Widget plugin
function widget_sandbox_rsslinks_control() {
	$options = $newoptions = get_option('widget_sandbox_rsslinks');
	if ( $_POST["rsslinks-submit"] ) {
		$newoptions['title'] = strip_tags(stripslashes($_POST["rsslinks-title"]));
	}
	if ( $options != $newoptions ) {
		$options = $newoptions;
		update_option('widget_sandbox_rsslinks', $options);
	}
	$title = htmlspecialchars($options['title'], ENT_QUOTES);
?>
			<p><label for="rsslinks-title"><?php _e('Title:'); ?> <input style="width: 250px;" id="rsslinks-title" name="rsslinks-title" type="text" value="<?php echo $title; ?>" /></label></p>
			<input type="hidden" id="rsslinks-submit" name="rsslinks-submit" value="1" />
<?php
}

// Widgets plugin: intializes the plugin after the widgets above have passed snuff
function sandbox_widgets_init() {
	if ( !function_exists('register_sidebars') )
		return;

	// Uses H3-level headings with all widgets to match Sandbox style
	$p = array(
		'before_title' => "<h3 class='widgettitle'>",
		'after_title' => "</h3>\n",
	);

	// Table for how many? Two? This way, please.
	register_sidebars(1, $p);

	// Finished intializing Widgets plugin, now let's load the Sandbox default widgets
	register_sidebar_widget(__('Search', 'sandbox'), 'widget_sandbox_search', null, 'search');
	unregister_widget_control('search');
	register_sidebar_widget(__('Meta', 'sandbox'), 'widget_sandbox_meta', null, 'meta');
	unregister_widget_control('meta');
	//register_sidebar_widget(array(__('RSS Links', 'sandbox'), 'widgets'), 'widget_sandbox_rsslinks');
	//register_widget_control(array(__('RSS Links', 'sandbox'), 'widgets'), 'widget_sandbox_rsslinks_control', 300, 90);
	register_sidebar_widget(__('Pages'), 'widget_mytheme_pages');
	register_sidebar_widget(__('RSS Links'), 'widget_mytheme_rsslinkies');
}

// Translate, if applicable
load_theme_textdomain('sandbox');

// Runs our code at the end to check that everything needed has loaded
add_action('init', 'sandbox_widgets_init');

// Adds filters so that things run smoothly
add_filter('archive_meta', 'wptexturize');
add_filter('archive_meta', 'convert_smilies');
add_filter('archive_meta', 'convert_chars');
add_filter('archive_meta', 'wpautop');

// Remember: the Sandbox is for play.




/* Different Favicon for Backend */
function favicon4admin() {
 echo '<link rel="shortcut icon" href="' . get_bloginfo('template_url') . '/images/favadmin.ico" />';
}
add_action( 'admin_head', 'favicon4admin' );




/*Start of Theme Options*/
 
$themename = "Black Hat";
$shortname = "bh";
$options = array (
 
array( "name" => "Header Options",
		"type" => "title",
		"style" => "background-color:#e3e6fe; padding:5px 10px; border:1px solid #cccccc; border-radius:10px; -moz-border-radius:10px; -webkit-border-radius:10px;"),
 
array( "type" => "open"),
 
array( "name" => "Meta Keywords",
        "desc" => "Enter the keywords you would like to use for this site separated by commas.",
        "id" => $shortname."_meta_keywords",
        "std" => "",
        "type" => "text",
		"notes" => "<em>Example: test, sample, lorem ipsum, circus, lions, tigers, clowns are scary, blah</em>"),
 
array( "type" => "close"),
 
array( "name" => "Sidebar Options",
		"type" => "title",
		"style" => "background-color:#e5fee3; padding:5px 10px; border:1px solid #cccccc; border-radius:10px; -moz-border-radius:10px; -webkit-border-radius:10px;"),
 
array( "type" => "open"),
 
array( "name" => "Sidebar location",
        "desc" => "Choose the side on which you would like the sidebar to appear.  To hide the sidebar altogether, choose 'hidden'.",
		"id" => $shortname."_body_style",
		"type" => "select",
		"std" => "left",
		"options" => array("left", "right", "hidden")),

array( "name" => "Feedburner RSS",
        "desc" => "Enter your Feedburner feed's ID here to point to use your Feedburner RSS link instead of the default link in the sidebar.",
        "id" => $shortname."_use_fb_link",
        "std" => "",
        "type" => "text",
		"notes" => "<em>Example: whole link is http://feeds2.feedburner.com/FEED_ID</em>"),
 
array( "name" => "Feedburner Email Subscription",
		"desc" => "Enter your Feedburner feed's ID here to display the email link beside the RSS icon in the sidebar.",
		"id" => $shortname."_use_fb_email",
        "std" => "",
        "type" => "text",
		"notes" => "Note: You must first have email subscription enabled in your Feedburner account to use this!"),
 
array( "name" => "Twitter Tweet",
		"desc" => "Enter your Twitter username to enable the 'My last Tweet' item in the sidebar.</em>",
		"id" => $shortname."_twitter_name",
        "std" => "",
        "type" => "text",
		"notes" => ""),
 
array( "name" => "Stylize 'Recent Posts'",
        "desc" => "Check this box to style the Recent Posts widget to display a visitor's read posts links with a strikethrough.",
        "id" => $shortname."_recent_posts",
        "type" => "checkbox",
        "std" => "false"),

array( "type" => "close"),
 
array( "name" => "Post Options",
		"type" => "title",
		"style" => "background-color:#fef6e3; padding:5px 10px; border:1px solid #cccccc; border-radius:10px; -moz-border-radius:10px; -webkit-border-radius:10px;"),
 
array( "type" => "open"),
 
array( "name" => "Related Posts",
        "desc" => "Check this box to hide the 'Related Posts' feature.",
        "id" => $shortname."_related_posts",
        "type" => "checkbox",
        "std" => "false"),
 
array( "type" => "close")
 
);

function mytheme_add_admin() {
 
global $themename, $shortname, $options;
 
if ( $_GET['page'] == basename(__FILE__) ) {
 
if ( 'save' == $_REQUEST['action'] ) {
 
foreach ($options as $value) {
update_option( $value['id'], $_REQUEST[ $value['id'] ] ); }
 
foreach ($options as $value) {
if( isset( $_REQUEST[ $value['id'] ] ) ) { update_option( $value['id'], $_REQUEST[ $value['id'] ]  ); } else { delete_option( $value['id'] ); } }
 
header("Location: themes.php?page=functions.php&saved=true");
die;
 
} else if( 'reset' == $_REQUEST['action'] ) {
 
foreach ($options as $value) {
delete_option( $value['id'] ); }
 
header("Location: themes.php?page=functions.php&reset=true");
die;
 
}
}
 
add_theme_page("Theme Options", "Theme Options", 'edit_themes', basename(__FILE__), 'mytheme_admin');
 
}
 
function mytheme_admin() {
 
global $themename, $shortname, $options;
 
if ( $_REQUEST['saved'] ) echo '<div id="message" class="updated fade"><p><strong>'.$themename.' settings saved.</strong></p></div>';
if ( $_REQUEST['reset'] ) echo '<div id="message" class="updated fade"><p><strong>'.$themename.' settings reset.</strong></p></div>';
 
?>
<div class="wrap">
<h2><?php echo $themename; ?> Settings</h2>
<br />
 
<form method="post">
 
<?php foreach ($options as $value) {
switch ( $value['type'] ) {
 
case "open":
?>

 
<?php break;
 
case "close":
?>
 
</table><br />
 
<?php break;
 
case "title":
?>
<table width="100%" border="0" style="<?php echo $value['style']; ?>"><tr>
<td colspan="2"><h3 style="font-family:Georgia,'Times New Roman',Times,serif; font-size:20px;"><?php echo $value['name']; ?></h3></td>
</tr>
 
<?php break;
 
case 'text':
?>
 
<tr>
    <td width="20%" rowspan="2" valign="middle"><strong><?php echo $value['name']; ?></strong></td>
    <td width="80%"><?php echo $value['desc']; ?></td>
</tr>
 
<tr>
    <td><input style="width:400px;" name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" type="<?php echo $value['type']; ?>" value="<?php if ( get_settings( $value['id'] ) != "") { echo get_settings( $value['id'] ); } else { echo $value['std']; } ?>" />
    <br />
	<br />
    <?php echo $value['notes']; ?>
	</td>
</tr>

<tr>
    <td colspan="2" style="margin-bottom:5px;border-bottom:1px dotted #cccccc">&nbsp;</td>
</tr>

<tr>
	<td colspan="2">&nbsp;</td>
</tr>
 
<?php
break;
 
case 'textarea':
?>
 
<tr>
    <td width="20%" rowspan="2" valign="middle"><strong><?php echo $value['name']; ?></strong></td>
    <td width="80%"><?php echo $value['desc']; ?></td>
</tr>
 
<tr>
    <td><textarea name="<?php echo $value['id']; ?>" style="width:400px; height:200px;" type="<?php echo $value['type']; ?>" cols="" rows=""><?php if ( get_settings( $value['id'] ) != "") { echo get_settings( $value['id'] ); } else { echo $value['std']; } ?></textarea></td>
</tr>

<tr>
    <td colspan="2" style="margin-bottom:5px;border-bottom:1px dotted #cccccc">&nbsp;</td>
</tr>

<tr>
	<td colspan="2">&nbsp;</td>
</tr>
 
<?php
break;
 
case 'select':
?>
<tr>
    <td width="20%" rowspan="2" valign="middle"><strong><?php echo $value['name']; ?></strong></td>
    <td width="80%"><?php echo $value['desc']; ?></td>
</tr>
 
<tr>
    <td><select style="width:240px;" name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>"><?php foreach ($value['options'] as $option) { ?><option<?php if ( get_settings( $value['id'] ) == $option) { echo ' selected="selected"'; } elseif ($option == $value['std']) { echo ' selected="selected"'; } ?>><?php echo $option; ?></option><?php } ?></select></td>
</tr>

<tr>
    <td colspan="2" style="margin-bottom:5px;border-bottom:1px dotted #cccccc">&nbsp;</td>
</tr>

<tr>
	<td colspan="2">&nbsp;</td>
</tr>
 
<?php
break;
 
case "checkbox":
?>
<tr>
    <td width="20%" valign="middle"><strong><?php echo $value['name']; ?></strong></td>
    <td width="80%"><?php if(get_option($value['id'])){ $checked = "checked=\"checked\""; }else{ $checked = "";} ?><input type="checkbox" name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" value="true" <?php echo $checked; ?> /> &nbsp; <?php echo $value['desc']; ?></td>
</tr>
 
<tr>
    <td colspan="2" style="margin-bottom:5px;border-bottom:1px dotted #cccccc">&nbsp;</td>
</tr>

<tr>
	<td colspan="2">&nbsp;</td>
</tr>
 
<?php break;
 
}
}
?>
 
<p class="submit">
<input name="save" type="submit" value="Save changes" />
<input type="hidden" name="action" value="save" />
</p>
</form>
<form method="post">
<p class="submit">
<input name="reset" type="submit" value="Reset all back to default" />
<input type="hidden" name="action" value="reset" />
</p>
</form>
 
<?php
}













add_action('admin_menu', 'mytheme_add_admin');

/**
 * add a default-gravatar to options
 */
if ( !function_exists('fb_addgravatar') ) {
	function fb_addgravatar( $avatar_defaults ) {
		$myavatar = get_bloginfo('template_directory').'/images/user.gif';
                //default avatar
		$avatar_defaults[$myavatar] = 'Black Hat theme default avatar';

		return $avatar_defaults;
	}

	add_filter( 'avatar_defaults', 'fb_addgravatar' );
}
?>