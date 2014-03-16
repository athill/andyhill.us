			<div id="comments">
<?php

// Do not delete these lines
	if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
		die ('Please do not load this page directly. Thanks!');
		
	if (function_exists('post_password_required')) {
		if ( post_password_required() ) {
			echo '<p class="nocomments">This post is password protected. Enter the password to view comments.</p>';
			return;
		}
	} else {
		if (!empty($post->post_password)) { 
			// if there's a password
			if ($_COOKIE['wp-postpass_' . COOKIEHASH] != $post->post_password) {
				// and it doesn't match the cookie  ?>
				<p class="nocomments">This post is password protected. Enter the password to view comments.</p></div><!-- .comments -->
				<?php return;
			}
		}
	}
?>

<!-- You can start editing here. -->
<?php /*?><div id="comments"><?php */?>
<?php if ( have_comments() ) : ?>

    <div id="comments-list" class="comments">
	<?php if ( ! empty($comments_by_type['comment']) ) : ?>
        <h3><?php comments_number('No Comments', 'One Comment', '% Comments' );?></h3>
        <div class="navigation" style="clear:both">
            <div class="alignleft"><?php previous_comments_link() ?></div>
            <div class="alignright"><?php next_comments_link() ?></div>
        </div>
        <div style="clear:both"></div>
        <ol><?php /*?><ol class="commentlist"><?php */?>
			<?php wp_list_comments('type=comment&avatar_size=48&reply_text=Reply to this comment'); ?>
        </ol>
	<?php endif; ?>
    <?php if ( ! empty($comments_by_type['pings']) ) : ?>
    	<br />
        <h3 id="pings">Trackbacks/Pingbacks</h3>
        <ol class="pinglist">
		<?php wp_list_comments('type=pings&callback=list_pings'); ?>
        </ol>
    <?php endif; ?>

        <div class="navigation" style="clear:both">
            <div class="alignleft"><?php previous_comments_link() ?></div>
            <div class="alignright"><?php next_comments_link() ?></div>
        </div>
        <div style="clear:both"></div>
	</div>
 <?php else : // this is displayed if there are no comments so far ?>
	<?php if (comments_open()) : ?>
		<!-- If comments are open, but there are no comments. -->
	 <?php else : // comments are closed ?>
		<!-- If comments are closed. -->
        <p class="nocomments">Comments are closed.</p>
	<?php endif; ?>
<?php endif; ?>


<?php if (comments_open()) : ?>

	<div id="respond">

	<h3><?php comment_form_title( 'Post a Comment', 'Post a Reply to %s' ); ?></h3>

	<div class="cancel-comment-reply">
		<small><?php cancel_comment_reply_link(); ?></small>
	</div>

	<?php if ( get_option('comment_registration') && !( is_user_logged_in() ) ) : ?>
	<p id="login-req">You must be <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?redirect_to=<?php echo urlencode(get_permalink()); ?>">logged in</a> to post a comment.</p>
	<?php else : ?>

	<div class="formcontainer">	
		<form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform">

		<?php if ( is_user_logged_in() ) : ?>

			<p id="login">Logged in as <a href="<?php echo get_option('siteurl'); ?>/wp-admin/profile.php"><?php echo $user_identity; ?></a>. <a href="<?php echo wp_logout_url(get_permalink()); ?>" title="Log out of this account">Log out &raquo;</a></p>

		<?php else : ?>

			<p id="comment-notes"><?php _e('Your email is <em>never</em> published nor shared.', 'sandbox') ?> <?php if ($req) _e('Required fields are marked <span class="required">*</span>', 'sandbox') ?></p>
            
            <div class="form-label"><label for="author"><?php _e('Name', 'sandbox') ?></label> <?php if ($req) _e('<span class="required">*</span>', 'sandbox') ?></div>
            <div class="form-input"><input id="author" name="author" type="text" value="<?php echo $comment_author ?>" maxlength="20" tabindex="3" /></div>

            <div class="form-label"><label for="email"><?php _e('Email', 'sandbox') ?></label> <?php if ($req) _e('<span class="required">*</span>', 'sandbox') ?></div>
            <div class="form-input"><input id="email" name="email" type="text" value="<?php echo $comment_author_email ?>" maxlength="50" tabindex="4" /></div>

            <div class="form-label"><label for="url"><?php _e('Website', 'sandbox') ?></label></div>
            <div class="form-input"><input id="url" name="url" type="text" value="<?php echo $comment_author_url ?>" maxlength="50" tabindex="5" /></div>

		<?php endif /* if ( is_user_logged_in() ) */ ?>

		<!--<p><small><strong>XHTML:</strong> You can use these tags: <code><?php echo allowed_tags(); ?></code></small></p>-->

        <div class="form-label"><label for="comment"><?php _e('Comment', 'sandbox') ?></label></div>
        <div class="form-textarea"><textarea id="comment" name="comment" tabindex="6"></textarea></div>
        
        <div class="form-submit">
            <input id="submit" name="submit" type="submit" value="<?php _e('Post Comment', 'sandbox') ?>" tabindex="7" />
            <?php comment_id_fields(); ?>
        </div>

        <?php do_action('comment_form', $post->ID); ?>

		</form><!-- #commentform -->
	</div><!-- .formcontainer -->
	<?php endif; // If registration required and not logged in ?>
	</div>
<?php endif; // if you delete this the sky will fall on your head ?>
<?php /*?></div><?php */?>
			</div><!-- #comments -->
