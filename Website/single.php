<?php
/**
 * The Template for displaying all single posts
 *
 * @package WordPress
 * @subpackage Javo
 * @since Javo Themes 1.0
 */

if( ! defined( 'ABSPATH' ) )
	die( -1 );

$jvfrm_home_author				= new WP_User( get_the_author_meta( 'ID', $post->post_author ) );

get_header();

function jvfrm_home_single_post_content(){
	global $post;
	do_action( 'jvfrm_home_post_content_before' );
	while ( have_posts() ) : the_post();
		get_template_part(
			apply_filters(
				'jvfrm_home_single_template'
				, ( false !== get_post_format() ? 'content-' : 'content' ) . get_post_format()
				, get_the_ID()
			)
		);
	endwhile;
	do_action( 'jvfrm_home_post_content_after' );

	// Only  Post type for "post"
	comments_template( '', true );
	jvfrm_home_post_nav();
}

do_action( 'jvfrm_home_single_page_before' ); ?>
<?php
if( jvfrm_home_single_post_type() == 1){ ?>
	<div class="jv-single-post-layout-1">
		<a href="<?php the_permalink(); ?>" class="jv-single-post-thumbnail-holder">
			<?php the_post_thumbnail( 'full', Array( 'class' => 'img-responsive' ) ); ?>
		</a>
		<div class="filter-overlay"></div>
		<div class="jv-single-post-title-container">
			<div class="jv-single-post-title-wrap">
				<div class="jv-single-post-title-category admin-color-setting"><?php the_category( ', ' ); ?></div>
				<h1 class="jv-single-post-title"><?php the_title(); ?></h1>

				<div class="jv-single-post-meta-wrap">
					<div class="jv-single-post-meta-avatar javo-spyscroll-icon">
						<a href="#jv-single-author-title">
							<?php echo get_avatar( $jvfrm_home_author->ID, 40 ); ?>
						</a>
					</div>

					<ul class="jv-single-post-author-info-wrap">
						<li class="meta-author-name">
							<i class='fa fa-user'></i>
							<?php esc_html_e( 'by', 'javohome' ); ?>
							<a href="<?php echo esc_url( home_url('member/'.$jvfrm_home_author->user_login ) ); ?>">
								<?php echo esc_html( $jvfrm_home_author->display_name ); ?></a> -
							<?php echo esc_html( get_the_date( get_option( 'date_format') ) ); ?>
						</li>
						<li class="meta-comments-count">
							<i class="fa fa-comment"></i>
							<?php comments_popup_link( 0, 1, '%' ); ?>
						</li>
					</ul>
				</div>
				<div class="jv-single-post-scroll-trigger-wrap javo-spyscroll-icon">
					<a href="#post-<?php the_ID();?>" class="jv-single-post-scroll-trigger"><i class="fa fa-angle-down"></i></a>
				</div>
			</div>
		</div>
	</div>
<?php } ?>

<div id="jv-single-fixed-navigations">
	<?php
	jvfrm_home_post_nav(
		Array(
			'post_thumbnail'	=> true,
			'type'				=> 'reavl',
		)
	); ?>
</div>

<div class="container">
	<div class="row">
		<?php
		switch( get_post_meta( get_the_ID(), 'jvfrm_home_sidebar_type', true ) ) :
			case 'full' :
				echo '<div class="col-md-12 main-content-wrap">';
					jvfrm_home_single_post_content();
				echo '</div>';
			break;
			case 'left' :
				get_sidebar();
				echo '<div class="col-md-9 main-content-wrap">';
					jvfrm_home_single_post_content();
				echo '</div>';
			break;

			case 'right' :
			default :
				echo '<div class="col-md-9 main-content-wrap">';
					jvfrm_home_single_post_content();
				echo '</div>';
				wp_reset_postdata();
				get_sidebar();
		endswitch; ?>
	</div>
</div> <!-- container -->

<?php
do_action( 'jvfrm_home_single_page_after' );
get_footer();