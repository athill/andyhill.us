<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes() ?>>
<head profile="http://gmpg.org/xfn/11">
<meta http-equiv="content-type" content="<?php bloginfo('html_type') ?>; charset=<?php bloginfo('charset') ?>" />
<meta name="distribution" content="global" />

<!-- Note: If you have your Privacy Settings in WP Admin set to block search engines, WP will override this! -->
<?php if(!is_archive() && !is_search() && !is_author() && !is_category() && !is_tag() && !is_404()){ ?>
<meta name="robots" content="all" />
<?php }else{ ?>
<meta name="robots" content="noindex, follow" />
<?php } ?>

<meta name="description" content="<?php bloginfo('description') ?>" />

<title><?php 
if ( is_home() ) {
		bloginfo('name'); wp_title();
} else if ( is_404() ) {
		echo 'Not Found &mdash; '; bloginfo('name'); 
} else if ( is_search() ) {
		echo 'Search Results for: "'; echo wp_specialchars($s, 1); echo '" &mdash; '; bloginfo('name');
} else if ( is_tag() || is_category() ) {
		echo 'Currently browsing '; wp_title('',true,''); echo ' posts &mdash; '; bloginfo('name');
} else { 
		wp_title('',true,''); echo ' &mdash; '; bloginfo('name');
} 
?></title>


<meta name="DC.title" content="<?php 
if ( is_home() ) {
		bloginfo('name'); wp_title();
} else if ( is_404() ) {
		echo 'Not Found &mdash; '; bloginfo('name'); 
} else if ( is_search() ) {
		echo 'Search Results for: "'; echo wp_specialchars($s, 1); echo '" &mdash; '; bloginfo('name');
} else if ( is_tag() || is_category() ) {
		echo 'Currently browsing '; wp_title('',true,''); echo ' posts &mdash; '; bloginfo('name');
} else { 
		wp_title('',true,''); echo ' &mdash; '; bloginfo('name');
} 
?>" />

<?php if ( is_singular() ) echo '<link rel="canonical" href="' . get_permalink() . '" />';  //So naughty search engines won't penalize you for duplicate content ?>

<?php global $options;
foreach ($options as $value) {
    if (get_settings( $value['id'] ) === FALSE) { $$value['id'] = $value['std']; } else { $$value['id'] = get_settings( $value['id'] ); }
}?>

<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen, projection" />
<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/print.css" type="text/css" media="print" />

<link href="<?php bloginfo('template_directory'); ?>/<?php echo $bh_body_style; ?>.css" rel="stylesheet" type="text/css" />
<?php if ($bh_recent_posts == "true") { ?>
<link href="<?php bloginfo('template_directory'); ?>/style_rec_posts.css" rel="stylesheet" type="text/css" />
<?php } ?>
<meta name="keywords" content="<?php echo $bh_meta_keywords; ?>" />

<?php if (trim($bh_use_fb_link == "")) { ?>
<link rel="alternate" type="application/rss+xml" title="RDF/RSS 1.0 for: <?php bloginfo('name'); ?>" href="<?php bloginfo('rdf_url'); ?>" />
<link rel="alternate" type="application/rss+xml" title="RSS 2.0 for: <?php bloginfo('name'); ?>" href="<?php bloginfo('rss2_url'); ?>" />
<link rel="alternate" type="text/xml" title="RSS .92 for: <?php bloginfo('name'); ?>" href="<?php bloginfo('rss_url'); ?>" />
<link rel="alternate" type="application/atom+xml" title="Atom 0.3 for: <?php bloginfo('name'); ?>" href="<?php bloginfo('atom_url'); ?>" />
<link rel="alternate" type="application/rss+xml" title="All Comments (RSS) for: <?php bloginfo('name'); ?>" href="<?php bloginfo('comments_rss2_url'); ?>" />
<?php } else { ?>
<link rel="alternate"  href="http://feeds.feedburner.com/<?php echo $bh_use_fb_link; ?>" type="application/rss+xml" title="FeedBurner RSS Feed for: <?php bloginfo('name'); ?>"/>
<?php } ?>

<?php if (is_single()) { // If this is a single page, let's make the comments feed available!
  while (have_posts()) : the_post(); ?>
<link rel="alternate" type="application/rss+xml" title="Comments for: <?php the_title(); ?>" href="<?php bloginfo('url'); ?>/?feed=rss2&amp;p=<?php the_ID(); ?>" />
<?php endwhile;
  rewind_posts(); // Be kind, rewind.
} ?>

<?php if (is_category()) { // Feed for all posts in this category ?>
<link rel="alternate" type="application/atom+xml" title="All <?php single_cat_title(''); ?> posts at <?php bloginfo('name'); ?>" href="<?php echo get_category_feed_link(get_query_var('cat'), 'atom'); ?>" />
<?php } ?>

<?php if (is_tag()) { // Feed for all posts with this tag ?>
<link rel="alternate" type="application/atom+xml" title="All <?php single_tag_title(''); ?> posts at <?php bloginfo('name'); ?>" href="<?php echo get_tag_feed_link(get_query_var('tag_id'), 'atom'); ?>" />
<?php } ?>

<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

<?php wp_get_archives('type=monthly&format=link'); ?>

<?php
	if ( function_exists('wp_list_comments') ) { // WP 2.7 check
		if ( is_singular() ) wp_enqueue_script( 'comment-reply' );
	}
?>

<?php wp_head(); ?>

<!--[if IE]>
    <style type="text/css">
    #sidebar ul li ul li {
        border:1px solid #242323;
    }
    .iffy {padding-bottom:5px;}
    .related {
        border:1px solid #c4c3c3;
        background-color:#242323;
        padding:12px;
        margin-bottom: 50px;
    }
    </style>
<![endif]-->

<link rel="shortcut icon" href="<?php bloginfo('template_url'); ?>/images/favicon.ico" />
<link rel="apple-touch-icon" href="<?php bloginfo('template_url'); ?>/images/apple-touch-icon.png"/>
<script language="javascript" type="text/javascript">
	sfHover = function() {
		var sfEls = document.getElementById("menu").getElementsByTagName("LI");
		for (var i=0; i<sfEls.length; i++) {
			sfEls[i].onmouseover=function() {
				this.className+=" sfhover";
			}
			sfEls[i].onmouseout=function() {
				this.className=this.className.replace(new RegExp(" sfhover\\b"), "");
			}
		}
	}
	if (window.attachEvent) window.attachEvent("onload", sfHover);
</script>
</head>
<body class="<?php sandbox_body_class() ?>">

<div id="wrapper" class="hfeed">

	<div id="access">
		<?php // for now this is just a place holder. menu moved. ?>
	</div><!-- #access -->

	<div id="header">
		<h1 id="blog-title"><a href="<?php echo get_option('home') ?>/" title="<?php bloginfo('name') ?>" rel="home"><?php bloginfo('name') ?></a></h1>
		<div id="blog-description"><?php bloginfo('description') ?></div>
	</div><!--  #header -->

	<div id="allowed">
		<?php sandbox_globalnav() ?>
	</div><!-- #allowed -->
