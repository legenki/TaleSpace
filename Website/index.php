<?php
/**
 * The main template file
 *
 * @package WordPress
 * @subpackage Javo
 * @since Javo Themes 1.0
 */
get_header(); ?>
<div class="container">
	<div class="row">
		<div class="col-md-9 main-content-wrap">
		<?php if ( have_posts() ) : ?>

			<?php /* Start the Loop */ ?>
			<?php while ( have_posts() ) : the_post(); ?>
				<?php get_template_part( 'content', get_post_format() ); ?>
			<?php endwhile; ?>

			<?php jvfrm_home_content_nav( 'nav-below' ); ?>

		<?php else : ?>

			<article id="post-<?php the_ID();?>" <?php post_class();?>>

			<?php if ( current_user_can( 'edit_posts' ) ) :
				// Show a different message to a logged-in user who can add posts.
			?>
				<header class="entry-header">
					<h1 class="entry-title"><?php esc_html_e( 'No posts to display', 'javohome' ); ?></h1>
				</header>

				<div class="entry-content">
					<p><?php printf( wp_kses(__( 'Ready to publish your first post? <a href="%s">Get started here</a>.', 'javohome' ),jvfrm_home_allow_tags() ), esc_url( admin_url( 'post-new.php' ) ) ); ?></p>
				</div><!-- .entry-content -->

			<?php else :
				// Show the default message to everyone else.
			?>
				<header class="entry-header">
					<h1 class="entry-title">
						<?php esc_html_e( 'Nothing Found', 'javohome' ); ?>
					</h1>
				</header>

				<div class="entry-content">
					<p><?php esc_html_e( 'Apologies, but no results were found. Perhaps searching will help find a related post.', 'javohome' ); ?></p>
					<?php get_search_form(); ?>
				</div><!-- .entry-content -->
			<?php endif; // end current_user_can() check ?>

			</article><!-- #post-0 -->

		<?php endif; // end have_posts() check ?>
	</div><!-- #primary -->
			<?php
			wp_reset_query();
			get_sidebar(); ?>
	</div><!-- row -->
</div><!-- container -->
<?php get_footer();?>