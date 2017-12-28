<?php
/**
 * The template for displaying Comments
 *
 * @package WordPress
 * @subpackage Javo
 * @since Javo Themes 1.0
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() )
	return;
?>

<div id="comments" class="comments-area">

	<?php // You can start editing here -- including this comment! ?>

	<?php if ( have_comments() ) : ?>
	<?php
	jvfrm_home_layout()->section_title(
		get_comments_number_text(
			esc_html__('No Comments','javohome'),
			esc_html__('One Comment', 'javohome'),
			esc_html__('% Comments', 'javohome')
		), 'comments'
	); ?>

	<ul class="commentlist list-unstyled jv-single-post-comments">
		<?php wp_list_comments( array( 'callback' => 'jvfrm_home_comment', 'avatar_size' => 60 ) ); ?>
	</ul><!-- .commentlist -->

	<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through ?>
	<nav id="comment-nav-below" class="navigation">
		<h1 class="assistive-text section-heading"><?php esc_html_e( 'Comment navigation', 'javohome' ); ?></h1>
		<div class="nav-previous"><?php previous_comments_link( esc_html__( '&larr; Older Comments', 'javohome' ) ); ?></div>
		<div class="nav-next"><?php next_comments_link( esc_html__( 'Newer Comments &rarr;', 'javohome' ) ); ?></div>
	</nav>
	<?php endif; // check for comment navigation ?>

	<?php
	/* If there are no comments and comments are closed, let's leave a note.
	 * But we only want the note on posts and pages that had comments in the first place.
	 */
	if ( ! comments_open() && get_comments_number() ) : ?>
	<p class="nocomments"><?php esc_html_e( 'Comments are closed.' , 'javohome' ); ?></p>
	<?php endif; ?>

	<?php endif; // have_comments() ?>

	<?php
	if ( comments_open() ) :

	jvfrm_home_layout()->section_title(
		esc_html__( "Leave a Reply", 'javohome' ),
		'comment-form'
	);

	$required_text				= null;
	$commenter					= wp_get_current_commenter();
	$req								= get_option( 'require_name_email' );
	$aria_req						= ( $req ? " aria-required='true'" : '' );
	$html5							= current_theme_supports( 'html5', 'comment-form' ) ? 1 : 0;

	$args = array(
		'id_form'					=> 'commentform',
		'id_submit'				=> 'submit',
		'class_submit'			=> 'btn btn-primary',
		'label_submit'			=> esc_html__( "Submit", 'javohome' ),
		'title_reply'					=> esc_html__( 'Leave a Reply', 'javohome' ),
		'title_reply_to'			=> esc_html__( 'Leave a Reply to %s', 'javohome' ),
		'cancel_reply_link'		=> esc_html__( 'Cancel Reply', 'javohome' ),
		'comment_field'			=> wp_kses( '
			<div class="form-group comment-form-comment">
				<textarea class="form-control" id="comment" name="comment" cols="45" rows="8" aria-required="true" placeholder="'. esc_html__('Comment (required)', 'javohome') .'"></textarea>
			</div>'
			, Array(
				'div'						=> Array( 'class' => Array() ),
				'textarea'				=> Array(
					'class'				=> Array(),
					'id'						=> Array(),
					'name'				=> Array(),
					'cols'					=> Array(),
					'rows'				=> Array(),
					'aria-required'		=> Array(),
					'placeholder'		=> Array(),
				),
			)
		),

		'must_log_in'					=> wp_kses(
			'<p class="must-log-in">' .
			sprintf(
				__( 'You must be <a href="%s">logged in</a> to post a comment.', 'javohome' ),
				wp_login_url( apply_filters( 'the_permalink', get_permalink() ) )
			) . '</p>',
			Array(
				'p'							=> Array( 'class' => Array() ),
				'a'							=> Array( 'href' => Array() ),
			)
		),

		'logged_in_as'					=> wp_kses(
			'<p class="logged-in-as">' .
			sprintf(
				__( 'Logged in as <a href="%1$s">%2$s</a>. <a href="%3$s" title="Log out of this account">Log out?</a>', 'javohome' ),
				admin_url( 'profile.php' ),
				$user_identity,
				wp_logout_url( apply_filters( 'the_permalink', get_permalink( ) ) )
			) . '</p>',
			Array(
				'p'		=> Array(
					'class'		=> Array(),
				),
				'a'		=> Array(
					'href'			=> Array(),
					'title'			=> Array(),
				)
			)
		),

		'comment_notes_before'		=> wp_kses(
			'<p class="comment-notes">' .
			__( 'Your email address will not be published.', 'javohome' ) . ( $req ? $required_text : '' ) .
			'</p>',
			Array( 'p' => Array( 'class' => Array() ) )
		),

		'comment_notes_after' => '',

		'fields' => apply_filters( 'comment_form_default_fields', array(
			'author' => wp_kses( '<div class="jv-comment-author-fields"><div class=""><div class="form-group comment-form-author">' .
				'<input class="form-control" id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="22"' . $aria_req . ' tabindex="1" placeholder="'. esc_attr__('Name (required)', 'javohome') .'"/></div></div>',
				Array(
					'div'					=> Array(
						'class'			=> Array(),
					),
					'input'				=> Array(
						'class'			=> Array(),
						'id'					=> Array(),
						'name'			=> Array(),
						'type'				=> Array(),
						'value'			=> Array(),
						'size'				=> Array(),
						'tabindex'		=> Array(),
						'placeholder'	=> Array(),
						'aria-required'	=> Array(),
					)
				)
			),
			'email'						=> wp_kses( '<div class=""><div class="form-group comment-form-email">' .
				'<input class="form-control" id="email" name="email" ' . ( $html5 ? 'type="email"' : 'type="text"' ) . ' value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30"' . $aria_req . '  tabindex="2" placeholder="'.__('Email (required)','javohome').'" /></div></div>',
				Array(
					'div'					=> Array(
						'class'			=> Array(),
					),
					'input'				=> Array(
						'class'			=> Array(),
						'id'					=> Array(),
						'name'			=> Array(),
						'type'				=> Array(),
						'value'			=> Array(),
						'size'				=> Array(),
						'tabindex'		=> Array(),
						'placeholder'	=> Array(),
						'aria-required'	=> Array(),
					)
				)
			),
			'url'							=> wp_kses( '<div class=""><div class="form-group comment-form-url">' .
				'<input class="form-control" id="url" name="url" ' . ( $html5 ? 'type="url"' : 'type="text"' ) . ' value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30"  tabindex="3" placeholder="'.__('Site','javohome').'" /></div></div></div>',
				Array(
					'div'				=> Array(
						'class'			=> Array(),
					),
					'input'				=> Array(
						'class'			=> Array(),
						'id'			=> Array(),
						'name'			=> Array(),
						'type'			=> Array(),
						'value'			=> Array(),
						'size'			=> Array(),
						'tabindex'		=> Array(),
						'placeholder'	=> Array(),
					)
				)
			)
		) ),
	);

	comment_form($args);
	endif; ?>

</div><!-- #comments .comments-area -->