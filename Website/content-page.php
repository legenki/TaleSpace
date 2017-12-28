<?php
/**
 * The template used for displaying page content in page.php
 *
 * @package WordPress
 * @subpackage Javo
 * @since Javo Themes 1.0
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<h3 class="hidden"><?php the_title();?></h3>
		<div class="row">
			<div class="col-md-12">
				<?php the_content(); ?>
			</div><!-- /.col-md-12 -->
		</div><!-- /.row -->
		<?php if( current_user_can( 'manage_options' ) ) : ?>
			<div class="row">
				<div class="col-md-12">
					<?php edit_post_link( esc_html__( 'Edit', 'javohome' ), '<span class="edit-link">', '</span>' ); ?>
				</div><!-- /.col-md-12 -->
			</div><!-- /.row -->
		<?php endif; ?>
</article><!-- #post-ID -->
