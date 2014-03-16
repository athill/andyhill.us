<?php get_header(); ?>

<div id="content">

<?php get_search_form(); ?>

<?php
global $wp_query;
$total_results = $wp_query->found_posts;
?>
</div>

<div id="links">
<?php get_sidebar(); ?>
</div>

<?php get_footer(); ?>