<?php get_header(); ?>

<div id="content">

<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

<div <?php post_class(); ?>>
<h3 class="the_title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>

<span class="post-infos">
Posted by <?php the_author_posts_link(); ?> on <?php the_date(); ?> at <?php the_time(); ?> | Last modified: <?php the_modified_date(); ?> <?php the_modified_time(); ?>
</span>

<?php the_post_thumbnail(); ?>

<?php the_content(); ?>
<?php wp_link_pages('before=<div class="page-links">Pages:&after=</div>'); ?>

<span class="post-infos">
<?php the_tags('Tags: ',', ', ' |'); ?> Categories: <?php the_category(', '); ?> | <?php comments_popup_link('Comments (0)', 'Comments (1)', 'Comments (%)', 'Comments Off'); ?> | <a href="<?php the_permalink(); ?>">Permalink</a><?php edit_post_link('Edit', ' | '); ?>
</span>
</div>

<?php endwhile; else: ?>
<p>Sorry, no posts matched your criteria.</p>
<?php endif; ?>

<div class="page-navs">
<span class="next-link"><?php next_posts_link('Older Entries', 0); ?></span>
<span class="prev-link"><?php previous_posts_link('Newer Entries', 0) ?></span>
</div>

</div>

<div id="links">
<?php get_sidebar(); ?>
</div>

<?php get_footer(); ?>