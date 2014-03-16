<?php
if ( ! isset( $content_width ) )
	$content_width = 520;

$Teal_themename = "Teal";
$Teal_textdomain = "Teal";

function Teal_setup(){
  // This theme uses wp_nav_menu() in one location.
  register_nav_menus( array(
    'mainmenu' => __( 'Main Navigation', 'Teal' )
  ) );

  // This theme uses post thumbnails
  add_theme_support( 'post-thumbnails' );
  add_image_size( 'Tealthumb', 450, 300, true );  
  add_image_size( 'Tealthumbfull', 1200, 500, true );    
  add_image_size( 'Tealthumbslider', 630, 270, true );   
  // Add default posts and comments RSS feed links to head
  add_theme_support( 'automatic-feed-links' );
  add_filter( 'use_default_gallery_style', '__return_false' );
  
  // Add Custom header feature  
  $customhargs = array(
	'flex-width'    => true,
	'width'         => 1200,
	'flex-height'    => true,
	'height'        => 500,
  );
  add_theme_support( 'custom-header', $customhargs ); 
  
  // Add Custom background feature    
  if ( of_get_option('skin_style') ) {
  	$custombgargsskin = of_get_option('skin_style');
  }else {
  	$custombgargsskin = 'darky';
  }
  $custombgargs = array(
	'default-color' => 'd4dae2',
	'default-image' => get_template_directory_uri() . '/images/'.$custombgargsskin.'/page_bg.png',
	);
  add_theme_support( 'custom-background', $custombgargs );    
}
add_action( 'after_setup_theme', 'Teal_setup' );

/* 
 * Loads the Options Panel
 */
 
if ( !function_exists( 'optionsframework_init' ) ) {

	/* Set the file path based on whether we're in a child theme or parent theme */


		define('OPTIONS_FRAMEWORK_URL', get_template_directory() . '/admin/');
		define('OPTIONS_FRAMEWORK_DIRECTORY', get_template_directory_uri() . '/admin/');


	require_once (OPTIONS_FRAMEWORK_URL . 'options-framework.php');
}

/* 
 * This is an example of how to add custom scripts to the options panel.
 * This example shows/hides an option when a checkbox is clicked.
 */

add_action('optionsframework_custom_scripts', 'optionsframework_custom_scripts');

function optionsframework_custom_scripts() { ?>

<script type="text/javascript">
jQuery(document).ready(function() {

	jQuery('#example_showhidden').click(function() {
  		jQuery('#section-example_text_hidden').fadeToggle(400);
	});
	
	if (jQuery('#example_showhidden:checked').val() !== undefined) {
		jQuery('#section-example_text_hidden').show();
	}
	
});
</script>

<?php
}













/**
 * Get ID of the page, if this is current page
 */
function Teal_get_page_id() {
	global $wp_query;

	$page_obj = $wp_query->get_queried_object();

	if ( isset( $page_obj->ID ) && $page_obj->ID >= 0 )
		return $page_obj->ID;

	return -1;
}

/**
 * Get custom field of the current page
 * $type = string|int
 */
function Teal_get_custom_field($filedname, $id = NULL, $single=true)
{
	global $post;
	
	if($id==NULL)
		$id = get_the_ID();
	
	if($id==NULL)
		$id = Teal_get_page_id();

	$value = get_post_meta($id, $filedname, $single);
	
	if($single)
		return stripslashes($value);
	else
		return $value;
}

/**
 * Get Limited String
 * $output = string
 * $max_char = int
 */
function Teal_get_limited_string($output, $max_char=100, $end='...')
{
    $output = str_replace(']]>', ']]&gt;', $output);
    $output = strip_tags($output);
    $output = strip_shortcodes($output);

  	if ((strlen($output)>$max_char) && ($espacio = strpos($output, " ", $max_char )))
	{
        $output = substr($output, 0, $espacio).$end;
		return $output;
   }
   else
   {
      return $output;
   }
}

/**
 * Tests if any of a post's assigned categories are descendants of target categories
 *
 * @param mixed $cats The target categories. Integer ID or array of integer IDs
 * @param mixed $_post The post
 * @return bool True if at least 1 of the post's categories is a descendant of any of the target categories
 * @see get_term_by() You can get a category by name or slug, then pass ID to this function
 * @uses get_term_children() Gets descendants of target category
 * @uses in_category() Tests against descendant categories
 * @version 2.7
 */
function Teal_post_is_in_descendant_category( $cats, $_post = null )
{
	foreach ( (array) $cats as $cat ) {
		// get_term_children() accepts integer ID only
		$descendants = get_term_children( (int) $cat, 'category');
		if ( $descendants && in_category( $descendants, $_post ) )
			return true;
	}
	return false;
}

/**
 * Custom comments for single or page templates
 */
function Teal_comments($comment, $args, $depth) {
   $GLOBALS['comment'] = $comment; ?>
   <li <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">
   
   <div id="comment-<?php comment_ID(); ?>">
		<div class="comment-author vcard">  <?php echo get_avatar($comment,'82'); ?> <cite class="fn"><?php echo get_comment_author_link(); ?></cite></div>
		<div class="comment-meta commentmetadata"><a href="<?php echo esc_html( get_comment_link( $comment->comment_ID ) ) ?>"><?php printf(__('%1$s at %2$s','Teal'), get_comment_date(),  get_comment_time()) ?></a><?php edit_comment_link(__('(Edit)','Teal'),'  ','') ?></div>
      <?php if ($comment->comment_approved == '0') : ?>
         <p><em><?php _e('Your comment is awaiting moderation.','Teal') ?></em></p>
      <?php endif; ?>
		<div class="entry">
		<?php comment_text() ?>
		</div>
		<div class="reply"><?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?></div>
	</div>
<?php
}

/**
 * Browser detection body_class() output
 */
function Teal_browser_body_class($classes) {
	global $is_Teal, $is_gecko, $is_IE, $is_opera, $is_NS4, $is_safari, $is_chrome, $is_iphone;

	if($is_Teal) $classes[] = 'Teal';
	elseif($is_gecko) $classes[] = 'gecko';
	elseif($is_opera) $classes[] = 'opera';
	elseif($is_NS4) $classes[] = 'ns4';
	elseif($is_safari) $classes[] = 'safari';
	elseif($is_chrome) $classes[] = 'chrome';
	elseif($is_IE) $classes[] = 'ie';
	else $classes[] = 'unknown';

	if($is_iphone) $classes[] = 'iphone';
	return $classes;
}
/**
 * Add StyleSheets
 */
function Teal_add_stylesheets( ) {
	
	if( !is_admin() ) {

								wp_enqueue_style('Teal_dropdowncss', get_template_directory_uri().'/css/dropdown.css');
								wp_enqueue_style('Teal_rtldropdown', get_template_directory_uri().'/css/dropdown.vertical.rtl.css');
								wp_enqueue_style('Teal_advanced_dropdown', get_template_directory_uri().'/css/default.advanced.css');

								
								echo '<!--[if lte IE 7]>
<style type="text/css">
html .jquerycssmenu{height: 1%;} /*Holly Hack for IE7 and below*/
</style>
<![endif]--> ';

								wp_enqueue_style('Teal_wilto', get_template_directory_uri().'/css/wilto.css');
									
								if( of_get_option('skin_style') == 'teal' ) {
									wp_enqueue_style('Teal_Tealstyle', get_template_directory_uri().'/teal.css');	
									wp_enqueue_style('Teal_TealResponsive', get_template_directory_uri().'/tealresponsive.css');	
								} elseif( of_get_option('skin_style') == 'azurite' ) {
									wp_enqueue_style('Teal_Azuritestyle', get_template_directory_uri().'/azurite.css');	
									wp_enqueue_style('Teal_AzuriteResponsive', get_template_directory_uri().'/azuriteresponsive.css');	
								} elseif( of_get_option('skin_style') == 'darky' ) {
									wp_enqueue_style('Teal_darkystyle', get_template_directory_uri().'/darky.css');	
									wp_enqueue_style('Teal_darkyResponsive', get_template_directory_uri().'/darkyresponsive.css');	
								} elseif( of_get_option('skin_style') == 'oren' ) {
									wp_enqueue_style('Teal_darkystyle', get_template_directory_uri().'/oren.css');	
									wp_enqueue_style('Teal_darkyResponsive', get_template_directory_uri().'/orenresponsive.css');	
								} elseif( of_get_option('skin_style') == 'bred' ) {
									wp_enqueue_style('Teal_bredstyle', get_template_directory_uri().'/bred.css');	
									wp_enqueue_style('Teal_bredResponsive', get_template_directory_uri().'/bredresponsive.css');	
								} elseif( of_get_option('skin_style') == 'gren' ) {
									wp_enqueue_style('Teal_grenstyle', get_template_directory_uri().'/gren.css');	
									wp_enqueue_style('Teal_grenResponsive', get_template_directory_uri().'/grenresponsive.css');	
								} elseif( of_get_option('skin_style') == 'rubia' ) {
									wp_enqueue_style('Teal_rubiastyle', get_template_directory_uri().'/rubia.css');	
									wp_enqueue_style('Teal_rubiaResponsive', get_template_directory_uri().'/rubiaresponsive.css');	
								} elseif( of_get_option('skin_style') == 'aqua' ) {
									wp_enqueue_style('Teal_aquastyle', get_template_directory_uri().'/aqua.css');	
									wp_enqueue_style('Teal_aquaResponsive', get_template_directory_uri().'/aquaresponsive.css');	
								} elseif( of_get_option('skin_style') == 'bgre' ) {
									wp_enqueue_style('Teal_Defaultstyle', get_stylesheet_directory_uri().'/lite.css');
									wp_enqueue_style('Teal_Defaultresponsive', get_stylesheet_directory_uri().'/responsive.css');
									wp_enqueue_style('Teal_Colors', get_stylesheet_directory_uri().'/bgre.css');	
								} elseif( of_get_option('skin_style') == 'blby' ) {
									wp_enqueue_style('Teal_Defaultstyle', get_stylesheet_directory_uri().'/lite.css');
									wp_enqueue_style('Teal_Defaultresponsive', get_stylesheet_directory_uri().'/responsive.css');
									wp_enqueue_style('Teal_Colors', get_stylesheet_directory_uri().'/blby.css');	
								} elseif( of_get_option('skin_style') == 'blbr' ) {
									wp_enqueue_style('Teal_Defaultstyle', get_stylesheet_directory_uri().'/lite.css');
									wp_enqueue_style('Teal_Defaultresponsive', get_stylesheet_directory_uri().'/responsive.css');
									wp_enqueue_style('Teal_Colors', get_stylesheet_directory_uri().'/blbr.css');	
								} elseif( of_get_option('skin_style') == 'brow' ) {
									wp_enqueue_style('Teal_Defaultstyle', get_stylesheet_directory_uri().'/lite.css');
									wp_enqueue_style('Teal_Defaultresponsive', get_stylesheet_directory_uri().'/responsive.css');
									wp_enqueue_style('Teal_Colors', get_stylesheet_directory_uri().'/brow.css');	
								} elseif( of_get_option('skin_style') == 'yrst' ) {
									wp_enqueue_style('Teal_Defaultstyle', get_stylesheet_directory_uri().'/lite.css');
									wp_enqueue_style('Teal_Defaultresponsive', get_stylesheet_directory_uri().'/responsive.css');
									wp_enqueue_style('Teal_Colors', get_stylesheet_directory_uri().'/yrst.css');	
								} elseif( of_get_option('skin_style') == 'grun' ) {
									wp_enqueue_style('Teal_Defaultstyle', get_stylesheet_directory_uri().'/lite.css');
									wp_enqueue_style('Teal_Defaultresponsive', get_stylesheet_directory_uri().'/responsive.css');
									wp_enqueue_style('Teal_Colors', get_stylesheet_directory_uri().'/grun.css');	
								} elseif( of_get_option('skin_style') == 'kafe' ) {
									wp_enqueue_style('Teal_Defaultstyle', get_stylesheet_directory_uri().'/lite.css');
									wp_enqueue_style('Teal_Defaultresponsive', get_stylesheet_directory_uri().'/responsive.css');
									wp_enqueue_style('Teal_Colors', get_stylesheet_directory_uri().'/kafe.css');
								} else {
									wp_enqueue_style('Teal_Defaultstyle', get_stylesheet_directory_uri().'/lite.css');
									wp_enqueue_style('Teal_Defaultresponsive', get_stylesheet_directory_uri().'/responsive.css');
								}									
										

	}
}
/**
 * Add JS scripts
 */
function Teal_add_javascript( ) {

	if (is_singular() && get_option('thread_comments'))
		wp_enqueue_script('comment-reply');
		
	wp_enqueue_script('jquery');
	
	if( !is_admin() ) {

		wp_enqueue_script('Teal_jquery', get_template_directory_uri().'/js/respond.min.js' );
		wp_enqueue_script('Teal_respmenu', get_template_directory_uri().'/js/tinynav.min.js' );	
		wp_enqueue_script('Teal_wilto', get_template_directory_uri().'/js/wilto.js');
		wp_enqueue_script('Teal_wiltoint', get_template_directory_uri().'/js/wilto.int.js');

	}

}


function Teal_backupmenu() {
	 	if ( current_user_can('edit_theme_options') ) {
				echo '	<ul id="Main_nav" class="dropdown dropdown-horizontal">
							<li class="menu-item menu-item-type-custom menu-item-object-custom current-menu-item current_page_item menu-item-home">
								<a href="'.get_admin_url().'nav-menus.php">'.__("Select a Menu to appear here in Dashboard->Appearance->Menus ", "Teal").'</a>
							</li>
		
						</ul>	';
		} else {
				echo '	<ul id="Main_nav" class="dropdown dropdown-horizontal">
							<li class="menu-item menu-item-type-custom menu-item-object-custom current-menu-item current_page_item menu-item-home">
								<a href="'.esc_url( get_home_url() ).'">'.__("Home", "Teal").'</a>
							</li>
		
						</ul>	';			
		}
}

/**
 * Register widgetized areas
 */
function Teal_the_widgets_init() {
	
    if ( !function_exists('register_sidebars') )
        return;
    
    $before_widget = '<div id="%1$s" class="sidebar_widget %2$s">
																			
																			<div class="widget">';
    $after_widget = '</div>
																			
																		</div>';
    $before_title = '<h3 class="widgettitle">';
    $after_title = '</h3>';

	
	

    register_sidebar(array('name' => __('Left','Teal'),'id' => 'left','before_widget' => $before_widget,'after_widget' => $after_widget,'before_title' => $before_title,'after_title' => $after_title));
    register_sidebar(array('name' => __('Right','Teal'),'id' => 'right','before_widget' => $before_widget,'after_widget' => $after_widget,'before_title' => $before_title,'after_title' => $after_title));	
    register_sidebar(array('name' => __('300x250 Ads','Teal'),'id' => 'sidebar-ads','before_widget' => $before_widget,'after_widget' => $after_widget,'before_title' => $before_title,'after_title' => $after_title));
    register_sidebar(array('name' => __('125x125 Ads','Teal'),'id' => 'sidebar-ads-onetwofive','before_widget' => $before_widget,'after_widget' => $after_widget,'before_title' => $before_title,'after_title' => $after_title));   
}

/**
 * Filter for get_the_excerpt
 */
 
function Teal_get_the_excerpt($content){
	return str_replace(' [...]','',$content);
}

/**
 * Get the sidebar ID
 */
 
function Teal_get_sidebar_id(){
	global $post;
	$sidebar_id = 'sidebar-default';
	if(isset($post->ID))
		if(is_active_sidebar('sidebar-'.$post->ID))
			$sidebar_id = 'sidebar-'.$post->ID;
	return $sidebar_id;
}


/* Wp Title */
function Teal_doc_title( $doc_title ) {
        if( is_category() ) {
                $doc_title = __( 'Category: ', 'Teal' ) . $doc_title . ' - ';
        } elseif( is_tag() ) {
                $doc_title = single_tag_title( __( 'Tag Archive for &quot;', 'Teal'), false ) . '&quot; - ';
        } elseif( is_archive() ) {
                $doc_title .= __( ' Archive - ', 'Teal' );
        } elseif( is_page() ) {
                $doc_title .= ' - ';
        } elseif( is_search() ) {
                $doc_title = __('Search for &quot;','Teal') . get_search_query() . '&quot; - ';
        } elseif( ! is_404() && is_single() || is_page() ) {
                $doc_title .= ' - ';
        } elseif( is_404() ) {
                $doc_title = __( 'Not Found - ', 'Teal' );
        }
        $doc_title .= get_bloginfo('name');
        return $doc_title;
}

add_filter( 'wp_title', 'Teal_doc_title' );

add_filter( 'the_content_more_link', 'Teal_more_link', 10, 2 );

function Teal_more_link( $more_link, $more_link_text ) {
	return '<br /><br />'.$more_link;
}

add_filter('the_title','Teal_has_title');
function Teal_has_title($title){
	global $post;
	if($title == ''){
		return get_the_time(get_option( 'date_format' ));
	}else{
		return $title;
	}
}




if (!is_admin()){
	add_action( 'wp_enqueue_scripts', 'Teal_add_stylesheets' );	
	add_action( 'wp_enqueue_scripts', 'Teal_add_javascript' );
}

add_filter('body_class','Teal_browser_body_class');
add_filter('the_excerpt', 'Teal_get_the_excerpt');
add_filter('get_the_excerpt', 'Teal_get_the_excerpt');
add_action( 'widgets_init', 'Teal_the_widgets_init' );

// Allow Shortcodes in Sidebar Widgets
add_filter('widget_text', 'do_shortcode');

/**
 * Add default options and show Options Panel after activate
 */
if (is_admin() && isset($_GET['activated'] ) && $pagenow == "themes.php" ) {
	
	//Do redirect

	wp_redirect( admin_url( 'admin.php?page=options-framework' ) ); exit;
	
}

add_action( 'widgets_init', 'Teal_ads_sidebar' );

/**
 * Register our widget.
 * 'Example_Widget' is the widget class used below.
 *
 * @since 0.1
 */
function Teal_ads_sidebar() {
	register_widget( 'Teal_sidebarads' );
}

/**
 * Example Widget class.
 * This class handles everything that needs to be handled with the widget:
 * the settings, form, display, and update.  Nice!
 *
 * @since 0.1
 */
class Teal_sidebarads extends WP_Widget {

	/**
	 * Widget setup.
	 */
	function Teal_sidebarads() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'example', 'description' => __('An example widget that displays ads in sidebar.', 'Teal') );

		/* Widget control settings. */
		$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => '300x250' );

		/* Create the widget. */
		$this->WP_Widget( '300x250', __('300x250 Ads', 'Teal'), $widget_ops, $control_ops );
	}

	/**
	 * How to display the widget on the screen.
	 */
	function widget( $args, $instance ) {
		extract( $args );

		/* Our variables from the widget settings. */
		$image = $instance['image'];
		$url= $instance['url'];

	
		if ( $url )
			printf( '<p class="sidebar_ad_250"><a href="%1$s">', $url );

		if ( $image )
			printf( '<img src="%1$s" alt="" /></a></p>', $image );


	}

	/**
	 * Update the widget settings.
	 */
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		/* No need to strip tags for sex and show_sex. */
		$instance['image'] = $new_instance['image'];
		$instance['url'] = $new_instance['url'];

		return $instance;
	}

	/**
	 * Displays the widget settings controls on the widget panel.
	 * Make use of the get_field_id() and get_field_name() function
	 * when creating your form elements. This handles the confusing stuff.
	 */
	function form( $instance ) {

		/* Set up some default widget settings. */
		$defaults = array( 'image' => __('', 'Teal'), 'url' => __('', 'Teal') );
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<!-- Widget Title: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'image' ); ?>"><?php _e('Banner URL:', 'Teal'); ?></label>
			<input id="<?php echo $this->get_field_id( 'image' ); ?>" name="<?php echo $this->get_field_name( 'image' ); ?>" value="<?php echo $instance['image']; ?>" class="widefat" />
		</p>

		<!-- Your Name: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'url' ); ?>"><?php _e('Target URL', 'Teal'); ?></label>
			<input id="<?php echo $this->get_field_id( 'url' ); ?>" name="<?php echo $this->get_field_name( 'url' ); ?>" value="<?php echo $instance['url']; ?>" class="widefat" />
		</p>


	<?php
	}
}


add_action( 'widgets_init', 'Teal_ads_sidebar_onetwofive' );

/**
 * Register our widget.
 * 'Example_Widget' is the widget class used below.
 *
 * @since 0.1
 */
function Teal_ads_sidebar_onetwofive() {
	register_widget( 'Teal_sidebarads_onetwofive' );
}

/**
 * Example Widget class.
 * This class handles everything that needs to be handled with the widget:
 * the settings, form, display, and update.  Nice!
 *
 * @since 0.1
 */
class Teal_sidebarads_onetwofive extends WP_Widget {

	/**
	 * Widget setup.
	 */
	function Teal_sidebarads_onetwofive() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'example', 'description' => __('An example widget that displays ads in sidebar.', 'Teal') );

		/* Widget control settings. */
		$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => '125x125' );

		/* Create the widget. */
		$this->WP_Widget( '125x125', __('125x125 Ads', 'Teal'), $widget_ops, $control_ops );
	}

	/**
	 * How to display the widget on the screen.
	 */
	function widget( $args, $instance ) {
		extract( $args );

		/* Our variables from the widget settings. */
		$image = $instance['image'];
		$url= $instance['url'];

	
		if ( $url )

			printf( '<p class="sidebar_ad"><a href="%1$s">', $url );

		if ( $image )
			printf( '<img src="%1$s" alt="" /></a></p>', $image );


	}

	/**
	 * Update the widget settings.
	 */
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		/* No need to strip tags for sex and show_sex. */
		$instance['image'] = $new_instance['image'];
		$instance['url'] = $new_instance['url'];

		return $instance;
	}

	/**
	 * Displays the widget settings controls on the widget panel.
	 * Make use of the get_field_id() and get_field_name() function
	 * when creating your form elements. This handles the confusing stuff.
	 */
	function form( $instance ) {

		/* Set up some default widget settings. */
		$defaults = array( 'image' => __('', 'Teal'), 'url' => __('', 'Teal') );
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<!-- Widget Title: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'image' ); ?>"><?php _e('Banner URL:', 'Teal'); ?></label>
			<input id="<?php echo $this->get_field_id( 'image' ); ?>" name="<?php echo $this->get_field_name( 'image' ); ?>" value="<?php echo $instance['image']; ?>" class="widefat" />
		</p>

		<!-- Your Name: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'url' ); ?>"><?php _e('Target URL', 'Teal'); ?></label>
			<input id="<?php echo $this->get_field_id( 'url' ); ?>" name="<?php echo $this->get_field_name( 'url' ); ?>" value="<?php echo $instance['url']; ?>" class="widefat" />
		</p>


	<?php
	}
}

?>