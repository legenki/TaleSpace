<?php
/**
 * The template for displaying Search Results pages
 *
 * @package WordPress
 * @subpackage Javo
 * @since Javo Themes 1.0
 */
$jvfrm_home_get_query = new jvfrm_home_array( $_GET );
// Enqueues
{
	add_action( 'wp_enqueue_scripts', 'jvfrm_home_search_page_enq' );
	function jvfrm_home_search_page_enq()
	{
		wp_enqueue_script( 'jquery-magnific-popup' );
		wp_enqueue_script( 'jQuery-chosen-autocomplete' );
	}
}
get_header(); ?>
<div class="container">
	<div class="col-md-9 main-content-wrap">

		<div class="row">
			<div class="col-md-12">
				<?php
				$jvfrm_home_this_posts_return = Array();
				if( have_posts() ){
					?>
					<header class="page-header margin-top-12">
						<h1 class="page-title">
							<?php
							printf( '<small>%s</small>', esc_html__( 'Search Results for: ', 'javohome' ) );
							printf( '%s', esc_html( get_search_query() ) ) ;?>
						</h1>
					</header>
					<div class="javo-output">
						<?php
						while( have_posts() ) {
							the_post();
							get_template_part( 'content', get_post_format() );
						} // End While
						?>
						<?php jvfrm_home_content_nav(); ?>
					</div>
					<?php
				}else{
					?>
					<h3 class="page-header margin-top-12">
						<?php esc_html_e( 'No result found. Please try again', 'javohome' ); ?>
					</h3>
					<?php get_search_form(); ?>
					<?php
				}; // End IF
					printf("<input type='hidden' name='javo-this-term-all-item' value=\"%s\">", htmlspecialchars( json_encode($jvfrm_home_this_posts_return)) );
				?>
			</div><!-- col-md-12 -->
		</div><!-- row -->

	</div><!-- col-md-9 -->
	<?php get_sidebar(); ?>
</div> <!-- contaniner -->
<?php get_footer(); ?>