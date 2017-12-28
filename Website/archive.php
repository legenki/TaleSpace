<?php
/**
 * The template for displaying Archive pages
 *
 * @package WordPress
 * @subpackage Javo
 * @since Javo Themes 1.0
 */

$jvfrm_home_query						= new jvfrm_home_array( $_GET );
$jvfrm_home_this_terms_object		= get_queried_object();
$jvfrm_home_this_taxonomy			= isset( $jvfrm_home_this_terms_object->taxonomy ) ? $jvfrm_home_this_terms_object->taxonomy : null;
$jvfrm_home_this_term					= get_queried_object_id();

/*
$jvfrm_home_get_sub_terms_args	= Array(
	'hide_empty'			=> 0
	, 'parent'				=> $jvfrm_home_this_term
);
// $jvfrm_home_get_sub_terms			= get_terms( $jvfrm_home_this_taxonomy, $jvfrm_home_get_sub_terms_args);
*/

/* *jvfrm_home_tso_archive->get('primary_type', ''); */
$jvfrm_home_ts_default_primary_type = '';
// Enqueues
{
	add_action( 'wp_enqueue_scripts', 'jvfrm_home_archive_page_enq' );
	function jvfrm_home_archive_page_enq()
	{
		wp_enqueue_script( 'jquery-magnific-popup' );
		wp_enqueue_script( 'jQuery-flex-Slider' );
	}
}
get_header(); ?>


<header class="archive-header">
<h3 class="archive-title">
	<?php
	if ( is_day() ) :
		printf( wp_kses( __( 'Daily Archives: %s', 'javohome' ), jvfrm_home_allow_tags()), '<span>' . get_the_date() . '</span>' );
	elseif ( is_month() ) :
		printf( wp_kses( __( 'Monthly Archives: %s', 'javohome' ), jvfrm_home_allow_tags()), '<span>' . get_the_date( _x( 'F Y', 'monthly archives date format', 'javohome' ) ) . '</span>' );
	elseif ( is_year() ) :
		printf( wp_kses( __( 'Yearly Archives: %s', 'javohome' ),jvfrm_home_allow_tags()), '<span>' . get_the_date( _x( 'Y', 'yearly archives date format', 'javohome' ) ) . '</span>' );
	elseif( is_author() ) :
		printf( "%s <small>%s</small><i></i>",
			esc_html( get_userdata( get_queried_object_id() )->display_name ),
			esc_html__( "Author", 'javohome' )
		);
	else:
		printf(
			wp_kses(
				__('%s <small>Archive</small>', 'javohome' ),
				Array( 'small' => Array() )
			),
			strtoupper( $jvfrm_home_this_terms_object->name )
		); ?>
		<i>
			<a href="<?php echo esc_url( home_url( '/' ) );?>"><?php esc_html_e('HOME', 'javohome');?></a>
			<?php
			if( isset( $jvfrm_home_this_terms_object->taxonomy ) ){
				$jvfrm_home_archive_current = jvfrm_home_get_archive_current_position($jvfrm_home_this_term, $jvfrm_home_this_terms_object->taxonomy);
				foreach( $jvfrm_home_archive_current as $term_id){
					$term = get_term($term_id, $jvfrm_home_this_terms_object->taxonomy);
					printf(
						wp_kses( '&gt; <a href="%s">%s</a> ', Array( 'a' => Array( 'href' => Array() ) ) ),
						get_term_link( $term ),
						strtoupper($term->name)
					);
				}
			} ?>
		</i>
	<?php
	endif; ?>
</h3>
</header>


<!-- Main Container -->
<div class="container archive-main-container">
	<div class="col-md-9 main-content-wrap">
		<div class="javo-output padding-top-10 javo-archive-list-wrap">
			<!-- Items List -->
			<div class="javo-archive-items-content row">
			
				<?php
				$jvfrm_home_this_term_all_item = Array();
				if( have_posts() ){
					while( have_posts() ){
						the_post();
						get_template_part( 'content', get_post_format() );
					}; // End While
				}else{
					get_template_part( 'content', 'none' );
				}; // End If				
				?>
			</div><!-- /.javo-archive-items-content -->
			<?php jvfrm_home_archive_nav(); ?>			
		</div><!-- /.javo-output -->
	</div><!-- /.col-md-9 -->

	<?php get_sidebar(); ?>
</div><!-- /.container -->

<script type="text/html" id="javo-map-loading-template">
	<div class="text-center" id="javo-map-info-w-content">
		<img src="<?php echo JVFRM_HOME_IMG_DIR;?>/loading.gif" width="50" height="50">
	</div>
</script>

<fieldset>
	<input type='hidden' class='jvfrm_home_map_visible' value='.javo-archive-header-map'>
	<input type="hidden" javo-map-distance-unit value="<?php echo esc_attr( jvfrm_home_tso()->map->get('distance_unit', esc_html__( 'km', 'javohome' ) ) );?>">
	<input type="hidden" javo-map-distance-max value="<?php echo esc_attr( (float)jvfrm_home_tso()->map->get( 'distance_max', '500' ) );?>">
	<input type="hidden" name="jvfrm_home_google_map_poi" value="<?php echo esc_attr( jvfrm_home_tso()->map->get( 'poi', 'on' ) );?>">
	<input type="hidden" javo-cluster-multiple value="<?php esc_attr_e("This place contains multiple places. please select one.", 'javohome');?>">
	<input type="hidden" value="<?php echo esc_attr( admin_url( 'admin-ajax.php' ) ); ?>" data-admin-ajax-url>
</fieldset>


<?php
get_footer();