<?php get_header(); ?>

<div id="content">

<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

<div <?php post_class(); ?>>
<h3 class="the_title"><?php the_title(); ?></h3>

<span class="post-infos">
Posted by <?php the_author_posts_link(); ?> on <?php the_date(); ?> at <?php the_time(); ?> | Last modified: <?php the_modified_date(); ?> <?php the_modified_time(); ?> <?php edit_post_link('Edit Post'); ?>
</span>

<?php the_content(); ?>
</div>

<?php wp_link_pages('before=<div class="page-links">Pages:&after=</div>'); ?>

<?php
if (comments_open()){ comments_template(); }
else {echo 'Comments Off';}
?>

<div class="page-navs">
<span class="prev-link"><?php previous_post_link(); ?></span>
<span class="next-link"><?php next_post_link(); ?></span>
</div>

<?php endwhile; else: ?>
<p>Sorry, no posts matched your criteria.</p>
<?php endif; ?>
</div>

<div id="links">
<?php get_sidebar(); ?>
</div>

<?php get_footer(); ?>