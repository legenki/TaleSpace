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

$jvfrm_home_author				= new WP_User( get_the_author_meta( 'ID' ) );

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

// Get page options from theme settings
$ts_portfolio_detail_page_layout = jvfrm_home_tso()->header->get("portfolio_detail_page_layout");
$portfolio_detail_page_head_style = jvfrm_home_tso()->header->get("portfolio_detail_page_head_style");
//echo "ts-layout=". $ts_portfolio_detail_page_layout ."<br/>";
//echo "ts-header-style=". $portfolio_detail_page_head_style ."<br/>";


//Get Page Layout Style From Page Setting.
$portfolio_detail_page_layout = get_post_meta( get_the_ID(), '_jvfrm_portfolio_detail_page_layout', true);
//echo 'portfolio_detail_page_layout='. $portfolio_detail_page_layout ."<br/>";
//$portfolio_detail_page_head_style='fullwidth-content-after';
if (empty($portfolio_detail_page_layout)) { 
	$portfolio_detail_page_layout = jvfrm_home_tso()->header->get("portfolio_detail_page_layout"); 
}

	switch( $portfolio_detail_page_layout ) :
		case 'fullwidth-content-after' :
			$portfolio_meta_content_col = "col-md-9";				
			$portfolio_meta_extra_info_col = "col-md-3";
			add_action( 'jvfrm_home_post_content_inner_after', 'jvfrm_portfolio_meta', 10, 3);		
		break;
		case 'fullwidth-content-before' :
			$portfolio_meta_content_col = "col-md-9";
			$portfolio_meta_extra_info_col = "col-md-3";
			add_action( 'jvfrm_home_post_content_inner_before', 'jvfrm_portfolio_meta', 10, 3);
		break;

		case 'right-sidebar' :
		default :
			$portfolio_meta_content_col = "col-md-12";
			$portfolio_meta_extra_info_col = "col-md-12";
			add_action( 'jvfrm_home_post_content_inner_right_sider', 'jvfrm_portfolio_meta', 10, 3);			
			wp_reset_postdata();				
	endswitch;


	
//Get Portfolio Header Style
$portfolio_detail_page_head_style = get_post_meta( get_the_ID(), '_jvfrm_portfolio_detail_page_head_style', true);
//echo 'page-head-style='. $portfolio_detail_page_head_style ."<br/>";
//$portfolio_detail_page_head_style='featured_image';
//If no setting on page, get from theme setting.
if (empty($portfolio_detail_page_head_style)) { 
	$portfolio_detail_page_head_style = jvfrm_home_tso()->header->get("portfolio_detail_page_head_style"); 
}
	//echo 'page-head-style='. $portfolio_detail_page_head_style ."<br/>";
	switch( $portfolio_detail_page_head_style ) :
		case 'featured_image' :
			//$portfolio_header = the_title();
			$portfolio_about_sentence = "About This Project";
		break;

		case 'title_on_top' :
			//$portfolio_header = the_title();
			$portfolio_about_sentence = "About This Project";
			//echo "okkkkk";
		break;

		case 'title_upper_content' :
		default :
			//$portfolio_header = the_title();
			//$portfolio_about_sentence = the_title();		
			wp_reset_postdata();				
	endswitch;


// Get Terms
function jvfrm_portpolio_cate($portfolio_tax='') {	
	$terms = get_the_terms( get_the_ID(), $portfolio_tax );                   
	if ( $terms && ! is_wp_error( $terms ) ) : 
     $portfolio_categories = array(); 
	    foreach ( $terms as $term ) {
		    $portfolio_categories[] = $term->name;
	    }
                         
		$portfolio_terms = join( ", ", $portfolio_categories );    
	 return $portfolio_terms;
	 endif;
}

function jvfrm_portfolio_meta(){
	global $portfolio_meta_content_col;
	global $portfolio_meta_extra_info_col;
	global $portfolio_detail_page_head_style;
	$portfolio_meta = get_post_meta(get_the_ID());
	
	// To get all of meta value for debug 
	foreach($portfolio_meta as $key=>$val){
		//echo $key . ' : ' . $val[0] . '<br/>';
	}

	// Get each meta value for this portfolio 	
	$jvfrm_creation_date = get_post_meta( get_the_ID(), '_jvfrm_creation-date', true );
	$jvfrm_short_description = get_post_meta( get_the_ID(), '_jvfrm_short-description', true );
	$jvfrm_link_to = get_post_meta( get_the_ID(), '_jvfrm_link-to', true );
	$jvfrm_link_to = get_post_meta( get_the_ID(), '_jvfrm_link-to', true );
	if (false === strpos($jvfrm_link_to, '://')) {
		$jvfrm_link_to = 'http://' . $jvfrm_link_to;
	}


	echo '<div class="row portfolio-meta">';
	echo '<div class="' . $portfolio_meta_content_col .' portfolio-left">';	
	// Description

	//echo "aa=".$portfolio_detail_page_head_style;
	
	if ($portfolio_detail_page_head_style=='title_upper_content'):	
		echo the_title('<h3>', '</h3>');
	else:
		echo '<h3>' .esc_html__( "About this project", 'javohome' ). '</h3>';
	endif;


	if ( ! empty( $jvfrm_short_description ) ) echo '<p>' . $jvfrm_short_description. '</p>';
	echo '</div>';

	echo '<div class="'. $portfolio_meta_extra_info_col .'" portfolio-right">';
	
	// Date
	echo '<h4>' .esc_html__( "Date", 'javohome' ). '</h4>';
	if ( ! empty( $jvfrm_creation_date ) ) echo '<p>' . $jvfrm_creation_date. '</p>';
	
	// Link 
	echo '<h4>' .esc_html__( "Link", 'javohome' ). '</h4>';
	if ( ! empty( $jvfrm_link_to ) ) echo '<p><a href="'. $jvfrm_link_to .'" target="_blank">' . $jvfrm_link_to. '</a></p>';
	
	// Categories
	echo '<h4>' .esc_html__( "Category", 'javohome' ). '</h4>';
		 echo '<p>'. jvfrm_portpolio_cate('portfolio_category') .'</p>';

	// Tags
	echo '<h4>' .esc_html__( "Tag", 'javohome' ). '</h4>';
		 echo '<p>'. jvfrm_portpolio_cate('portfolio_tag') .'</p>';
	
	echo '</div>';
	echo '</div>';
}

//add_action( 'jvfrm_home_post_content_inner_after', 'jvfrm_portfolio_meta', 10, 3);
//add_action( 'jvfrm_home_post_content_inner_right_sider', 'jvfrm_portfolio_meta', 10, 3);


function jvfrm_arrow_pagenation(){ ?>
	<div class="container">
	<div class="row pagenation-inline-wrap">
		<div class="col-xs-4 next-posts text-left"><?php next_post_link('%link', '<span class="glyphicon glyphicon-chevron-left"></span>'); ?></div>
		<div class="col-xs-4 list-posts text-center"><a href="/portfolio/"><span class="glyphicon glyphicon-th-large"></span></a></div>
		<div class="col-xs-4 prev-posts text-right"><?php previous_post_link('%link', '<span class="glyphicon glyphicon-chevron-right"></span>'); ?></div>
	</div>
</div>
<?php
}
add_action( 'jvfrm_home_single_page_after', 'jvfrm_arrow_pagenation', 10, 3);
do_action( 'jvfrm_home_single_page_before' ); ?>

	<?php
		//$jvfrm_home_single_post_head_type='right-sidebar';
		switch( $portfolio_detail_page_head_style ) :
		//switch( get_post_meta( get_the_ID(), '_jvfrm_portfolio_detail_page_head_style', true) ) :
			case 'featured_image' : ?>
			<div class="jv-single-post-layout-1">
				<a href="<?php the_permalink(); ?>" class="jv-single-post-thumbnail-holder">
					<?php the_post_thumbnail( 'full', Array( 'class' => 'img-responsive' ) ); ?>
				</a>
				<div class="filter-overlay"></div>
				<div class="jv-single-post-title-container">
					<div class="jv-single-post-title-wrap">
						<div class="jv-single-post-title-category admin-color-setting"><?php	echo jvfrm_portpolio_cate('portfolio_category'); ?></div>
						<h1 class="jv-single-post-title"><?php the_title(); ?></h1>
						<div class="jv-single-post-scroll-trigger-wrap javo-spyscroll-icon">
							<a href="#post-<?php the_ID();?>" class="jv-single-post-scroll-trigger"><i class="fa fa-angle-down"></i></a>
						</div>
					</div>
				</div>
			</div>	
			<?php
			break;
	
			case 'title_on_top' : ?>
			<div class="jv-single-post-head-title-only container">
				<div class="row">
					<div class="col-md-12">
					<h1 class="jv-single-post-title" style="color: #303030; padding: 10px 30px; text-transform: uppercase; letter-spacing: 1px; font-weight: 600; font-size: 26px; line-height: 40px;"><?php the_title(); ?></h1>
					</div>
				</div>						
			</div>
			<?php
			break;
	
			case 'title_upper_content' : 
			default :?>
			
			<?php
				
		endswitch; ?>



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
		//$portfolio_detail_page_head_style='fullwidth-content-after';
		$portfolio_detail_page_layout = get_post_meta( get_the_ID(), '_jvfrm_portfolio_detail_page_layout', true );
		if (empty($portfolio_detail_page_layout)) { 
			$portfolio_detail_page_layout = jvfrm_home_tso()->header->get("portfolio_detail_page_layout"); 
		}
		switch( $portfolio_detail_page_layout ) :
			case 'fullwidth-content-after' :
				echo '<div class="col-md-12 main-content-wrap">';
					jvfrm_home_single_post_content();					
				echo '</div>';
			break;

			case 'fullwidth-content-before' :
				echo '<div class="col-md-12 main-content-wrap">';
					jvfrm_home_single_post_content();
				echo '</div>';
			break;
	
			case 'right-sidebar' :
			default :
				echo '<div class="col-md-9 main-content-wrap">';
					jvfrm_home_single_post_content();
				echo '</div>';
				wp_reset_postdata();
				echo '<div class="col-md-3"><div class="theiaStickySidebar">';
					do_action( 'jvfrm_home_post_content_inner_right_sider' );
				echo '</div></div>';
				//get_sidebar();
		endswitch; ?>
	</div>	
</div> <!-- container -->


<?php
do_action( 'jvfrm_home_single_page_after' );
get_footer();