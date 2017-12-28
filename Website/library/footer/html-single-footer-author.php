<?php
/**
 *
 *
 */
$intPostAuthor	= new WP_User( get_the_author_meta( 'ID' ) ); ?>
<div class="jv-single-footer-author">
	<div class="author-background">
		<?php echo wp_get_attachment_image(
			$intPostAuthor->describe_image,
			'jvfrm-home-huge'
		); ?>
	</div>
	<div class="author-avatar">
		<a href="<?php echo jvfrm_home_getUserPage( $intPostAuthor->ID ); ?>">
			<?php echo get_avatar( $intPostAuthor->ID ); ?>
		</a>
	</div><!-- /.author-avatar -->
	<div class="author-body">
		<header class="author-name">
			<a href="<?php echo jvfrm_home_getUserPage( $intPostAuthor->ID ); ?>">
				<?php echo $intPostAuthor->display_name; ?>
			</a>
		</header>
		<pre>
			<?php echo apply_filters(
				'the_content',
				wp_trim_words( $intPostAuthor->description, 40 )
			); ?>
		</pre>
		<a href="<?php echo jvfrm_home_getUserPage( $intPostAuthor->ID ); ?>">
			<?php esc_html_e( "More", 'javohome' ); ?>
		</a>
	</div><!-- /.author-body -->
</div><!-- /.jv-single-footer-author -->