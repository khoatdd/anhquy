<?php
/**
 * The template for displaying comments
 *
 * The area of the page that contains both current comments
 * and the comment form.
 *
 * @package WordPress
 * @subpackage Twenty_Fifteen
 * @since Twenty Fifteen 1.0
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}
?>

<div id="comments">

	<?php if ( have_comments() ) : ?>
		<h3>
			<?php
				printf( _nx( 'One thought on &ldquo;%2$s&rdquo;', '%1$s thoughts on &ldquo;%2$s&rdquo;', get_comments_number(), 'comments title', 'twentyfifteen' ),
					number_format_i18n( get_comments_number() ), get_the_title() );
			?>
		</h3>

		<?php mechanic_comment_nav(); ?>

			<?php
				wp_list_comments( array(
					'walker' => new mechanic_custom_walker_comment,
					'style'       => 'div',
					'type' => 'all',
					'short_ping'  => true,
					'avatar_size' => 50,
				) );
			?>
		<?php mechanic_comment_nav(); ?>

	<?php endif; // have_comments() ?>

	<?php
		// If comments are closed and there are comments, let's leave a little note, shall we?
		if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) :
	?>
		<p class="no-comments"><?php _e( 'Comments are closed.', 'twentyfifteen' ); ?></p>
	<?php endif; ?>
	<?php
		$commenter = wp_get_current_commenter();
		$req = get_option( 'require_name_email' );
		$aria_req = ( $req ? " aria-required='true'" : '' );
		$fields =  array(

			'author' =>
				'<p class="comment-form-author"><label for="author">' . __( 'Name', 'domainreference' ) . '</label> ' .
				( $req ? '<span class="required">*</span>' : '' ) .
				'<input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) .
				'" size="30"' . $aria_req . ' /></p>',

			'email' =>
				'<p class="comment-form-email"><label for="email">' . __( 'Email', 'domainreference' ) . '</label> ' .
				( $req ? '<span class="required">*</span>' : '' ) .
				'<input id="email" name="email" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) .
				'" size="30"' . $aria_req . ' /></p>',

			'url' =>
				'<p class="comment-form-url"><label for="url">' . __( 'Website', 'domainreference' ) . '</label>' .
				'<input id="url" name="url" type="text" value="' . esc_attr( $commenter['comment_author_url'] ) .
				'" size="30" /></p>',
		);
		$required_text = sprintf( ' ' . __('Required fields are marked %s'), '<span class="required">*</span>' );
		$args = array(
			'id_form'           => '',
			'class_form'      => 'form-horizontal',
			'id_submit'         => 'submit',
			'class_submit'      => 'submit btn btn-danger btn-lg',
			'name_submit'       => 'submit',
			'title_reply'       => __( 'Leave a Reply' ),
			'title_reply_to'    => __( 'Leave a Reply to %s' ),
			'cancel_reply_link' => __( 'Cancel Reply' ),
			'label_submit'      => __( 'Submit Comment' ),
			'format'            => 'xhtml',

			'comment_field' =>  '<div class="form-group"><div class="col-sm-12"><textarea id="comment" class="form-control" name="comment" cols="45" rows="8" aria-required="true" olaceholder="Comment">' .
				'</textarea></div></div>',

			'must_log_in' => '<p class="must-log-in">' .
				sprintf(
					__( 'You must be <a href="%s">logged in</a> to post a comment.' ),
					wp_login_url( apply_filters( 'the_permalink', get_permalink() ) )
				) . '</p>',

			'logged_in_as' => '<p class="logged-in-as">' .
				sprintf(
					__( 'Logged in as <a href="%1$s">%2$s</a>. <a href="%3$s" title="Log out of this account">Log out?</a>' ),
					admin_url( 'profile.php' ),
					$user_identity,
					wp_logout_url( apply_filters( 'the_permalink', get_permalink( ) ) )
				) . '</p>',

			'comment_notes_before' => '<p class="comment-notes">' .
				__( 'Your email address will not be published.' ) . ( $req ? $required_text : '' ) .
				'</p>',

			'comment_notes_after' => '<div class="form-allowed-tags form-group"><div class="col-sm-12"><p class="form-control-static"> ' .
				sprintf(
					__( 'You may use these <abbr title="HyperText Markup Language">HTML</abbr> tags and attributes: %s' ),
					' <code>' . allowed_tags() . '</code>'
				) . '</p></div></div>',

			'fields' => apply_filters( 'comment_form_default_fields', $fields ),
		);
	?>
	<?php comment_form($args); ?>

</div><!-- .comments-area -->
