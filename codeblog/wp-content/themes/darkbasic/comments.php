<div class="comments">
<?php if (have_comments()){?>
<h3>Comments <?php comments_number('(0)','(1)','(%)'); ?></h3>
<div class="page-links"><?php paginate_comments_links(); ?></div>
<div class="comment-body"><?php wp_list_comments(array('style' => 'div')); ?></div>
<div class="page-links"><?php paginate_comments_links(); ?></div>
<?php }
else {
echo 'No comments posted.';
} ?>

<?php comment_form(); ?>
</div>