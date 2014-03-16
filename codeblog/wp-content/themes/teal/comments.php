<?php
	$post;

	if ( post_password_required() ) { ?>
		<p class="nocomments"><?php _e('This post is password protected. Enter the password to view comments.', 'Teal') ?></p>
	<?php
		return;
	}
?>

<!-- You can start editing here. -->
<?php if ( !comments_open() && is_single() ) :?>
<div class="no_comm_single">

           <p><?php _e('Comments are closed.', 'Teal') ?></p>
	
</div>
<?php endif; ?>
<?php if ( have_comments() ) : ?>
	<h3 id="comments"><?php comments_number(__('Comments', 'Teal').' (0)', __('Comment', 'Teal').' (1)', __('Comments', 'Teal').' (%)'); ?></h3>

	<ol class="commentlist">
	<?php wp_list_comments('callback=Teal_comments'); ?>

	</ol>

	<?php $paginate_comments_links = paginate_comments_links('echo=0'); ?>
	<?php if(!empty($paginate_comments_links)) : ?>
	<div class="pagination2">
		<?php echo $paginate_comments_links; ?>
	</div>
	<?php endif; ?>
<?php endif; ?>

<?php 

	$fields =  array(
		
		
		'author' => '<p><input type="text" name="author" id="author" value="' . esc_attr( $commenter['comment_author'] ) . '" size="22" tabindex="1" /><label for="author"><small>'.__('Name', 'Teal') . ( $req ? __('(required)', 'Teal').'</small></label></p>':'' ),
		
		'email' => '<p><input type="text" name="email" id="email" value="' . esc_attr( $commenter['comment_author_email'] ) . '" size="22" tabindex="2" /><label for="email"><small>'.__('E-mail', 'Teal') . ( $req ? __('(required)', 'Teal').'</small></label></p>':'' ),
		
		'url'    => '<p><input type="text" name="url" id="url" value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="22" tabindex="3" /><label for="url"><small>'.__('Website', 'Teal').'</small></label></p>'
	);

	$args = array(
		'fields' => $fields,
		'comment_notes_after' => ''
	);
	comment_form( $args );
?>