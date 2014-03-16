<?php get_header(); ?>

<div id="content">

<h2 class="error404">Error 404 Page Not Found :(</h2>
<br />
Sorry! If you ended up here either:<br />
-An URL was mistyped<br />
-I don't know what I'm doing<br />
-Another website gave a bad link.<br /><br />

Options:<br />
-Check the URL and try again<br />
-Go back to <a href="<?php echo home_url(); ?>" title="<?php bloginfo('name'); ?>"><?php bloginfo('name'); ?></a>
</div>

<div id="links">
<?php get_sidebar(); ?>
</div>

<?php get_footer(); ?>