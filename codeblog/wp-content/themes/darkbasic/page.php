<?php
/*
Template Name: darkbasic-page
*/
?>

<?php get_header(); ?>

<div id="content">

<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

<div <?php post_class(); ?>>
<h3 class="the_title"><?php the_title(); ?></h3>

<span class="post-infos">Last modified: <?php the_modified_date(); ?> <?php the_modified_time(); ?> by <?php the_author_posts_link(); ?> <?php edit_post_link(); ?></span>

<?php the_content(); ?>
</div>

<?php endwhile; else: ?>
<p>Sorry, no posts matched your criteria.</p>
<?php endif; ?>

<?php if (comments_open()){ comments_template(); } ?>
</div>

<div id="links">
<?php get_sidebar(); ?>
</div>

<?php get_footer(); ?>