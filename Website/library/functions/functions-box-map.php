<?php
/**
 *	Javo Map Get Inforwindow Content
 *
 * @type		filter
 *	@function	jvfrm_home_map_info_window_content
 */
add_action( 'wp_ajax_jvfrm_home_map_info_window_content'			, 'jvfrm_home_map_info_window_content' );
add_action( 'wp_ajax_nopriv_jvfrm_home_map_info_window_content'	, 'jvfrm_home_map_info_window_content' );

function jvfrm_home_map_info_window_content()
{
	global $jvfrm_home_tso;

	header( 'Content-Type: application/json; charset=utf-8' );

	$jvfrm_home_query = new jvfrm_home_array( $_POST );
	$jvfrm_home_result = Array( "state" => "fail" );

	if( false !== ( $post_id = $jvfrm_home_query->get( "post_id", false ) ) )
	{
		$post = get_post( $post_id );

		//
		if( false == ( $jvfrm_home_this_author		= get_userdata( $post->post_author ) ) ) {
			$jvfrm_home_this_author = new stdClass();
			$jvfrm_home_this_author->display_name = '';
			$jvfrm_home_this_author->user_login = '';
			$jvfrm_home_this_author->avatar = 0;
		}


		// Post Thumbnail
		if( '' !== ( $jvfrm_home_this_thumb_id = get_post_thumbnail_id( $post->ID ) ) )
		{
			$jvfrm_home_this_thumb_url = wp_get_attachment_image_src( $jvfrm_home_this_thumb_id , 'jvfrm-home-box-v' );

			if( isset( $jvfrm_home_this_thumb_url[0] ) ) {
				$jvfrm_home_this_thumb					= $jvfrm_home_this_thumb_url[0];
			}
		}


		// If not found this post a thaumbnail
		if( empty( $jvfrm_home_this_thumb ) ) {
			$jvfrm_home_this_thumb		=	$jvfrm_home_tso->get( 'no_image', JVFRM_HOME_IMG_DIR . '/no-image.png' );
		}
		$jvfrm_home_this_thumb			= apply_filters( 'jvfrm_home_map_list_thumbnail', $jvfrm_home_this_thumb, $post );
		$jvfrm_home_this_thumb			= "<div class=\"javo-thb\" style=\"background-image:url({$jvfrm_home_this_thumb});\"></div>";

		$strAddition_meta			= '';
		if( class_exists( 'Jvfrm_Home_Module' ) && class_exists( 'jvfrm_home_Directory_Shortcode') ) {
			add_filter( 'jvfrm_home_Jvfrm_Home_Module_additional_meta', Array( jvfrm_home_Directory_Shortcode::$scdInstance, 'additional_meta' ), 10, 2 );
			$objShortcode			= new Jvfrm_Home_Module( $post );
			$strAddition_meta		= "<i class='fa fa-map-marker'></i> ".$objShortcode->c( 'property_status', __( "Not Set", 'javohome' ) )." <i class='fa fa-bookmark'></i> ".$objShortcode->c( 'property_type', __( "Not Set", 'javohome' ) );
		}

		$meta_rating = '';
		if(class_exists( 'Lava_Directory_Review' )){
			$strTemplate			= '';
			$ratingScore			= floatVal( get_post_meta( $post->ID, 'rating_average', true ) );
			$ratingPercentage	= floatVal( ( $ratingScore / 5 ) * 100 ) . '%';
			$rating2x					= intVal( $ratingScore ) * 2;
			$meta_rating = "<div class='meta-rating-wrap'><div class='meta-rating' style=\"width:" . esc_html( $ratingPercentage ) .";\"></div></div>";
		}

		// Other Informations
		$jvfrm_home_result					= Array(
			'state'					=> 'success'
			, 'meta'				=> $strAddition_meta
			, 'post_id'				=> $post->ID
			, 'post_title'			=> $post->post_title
			, 'permalink'			=> get_permalink( $post->ID )
			, 'thumbnail'			=> $jvfrm_home_this_thumb
			, 'author_name'			=> $jvfrm_home_this_author->display_name
			, 'rating' => $meta_rating
		);
	}
	die( json_encode( $jvfrm_home_result ) );
}

/**
 *	Javo Map Get Lists Module
 *
 * @type		filter
 *	@function	jvfrm_home_map_list_content
 */
add_action( 'wp_ajax_nopriv_jvfrm_home_map_list'	, 'jvfrm_home_map_list_content' );
add_action( 'wp_ajax_jvfrm_home_map_list'			, 'jvfrm_home_map_list_content' );

function jvfrm_home_map_list_content()
{
	header( 'Content-Type: application/json; charset=utf-8' );

	$argsPosts						= isset( $_REQUEST[ 'post_ids' ] ) ? (Array) $_REQUEST[ 'post_ids' ] : Array();
	$argsTemplate					= isset( $_REQUEST[ 'template' ] ) ? $_REQUEST[ 'template' ] : 0;

	$clsMapName					= 'module1';

	if( !class_exists( jvfrm_home_core()->getCoreName( 'Map' ) ) )
		$clsMapName					= 'module12';

	$clsListName					= 'module1';

	$clsMapName					= apply_filters( 'jvfrm_home_template_map_module', $clsMapName, $argsTemplate );
	$clsListName					= apply_filters( 'jvfrm_home_template_list_module', $clsListName, $argsTemplate );

	$strBasicTemplate			= "<div class=\"col-md-12\">%s</div>";
	$strMapTemplate			= $strBasicTemplate;

	if( !class_exists( jvfrm_home_core()->getCoreName( 'Map' ) ) )
		$strMapTemplate	= "<div class=\"col-md-6\">%s</div>";

	$arrBasicModuleOption	= Array(
		'length_content'			=> 12,
		'length_title'					=> 10,
	);

	$strMapColumn				= apply_filters( 'jvfrm_home_template_map_module_loop', $strMapTemplate, $clsMapName, $argsTemplate );
	$strListColumn					= apply_filters( 'jvfrm_home_template_list_module_loop', $strBasicTemplate, $clsListName, $argsTemplate );
	$arrMapModuleOption		= apply_filters( 'jvfrm_home_template_map_module_options', $arrBasicModuleOption, $argsTemplate );
	$arrListModuleOption		= apply_filters( 'jvfrm_home_template_list_module_options', $arrBasicModuleOption, $argsTemplate );

	if( empty( $argsPosts ) )
		die( json_encode( array( 'state' => 'fail' ) ) );

	$arrOutput			= Array( 'map' => Array(), 'list' => Array() );
	//$arrPosts				= get_posts( Array( 'post_type' => jvfrm_home_core()->slug, 'include' => $argsPosts ) );

	do_action( 'jvfrm_home_template_all_module_loop_before', $argsTemplate );
	if( !empty( $argsPosts ) ) : foreach( $argsPosts as $post_id ) {

		if( ! $post = get_post( $post_id ) )
			continue;

		if( class_exists( $clsMapName ) && class_exists( $clsListName ) ) {
			$objModuleMap		= new $clsMapName( $post, $arrMapModuleOption );
			$objModuleList			= new $clsListName( $post, $arrListModuleOption );
			$arrOutput['map'][]	= sprintf( $strMapColumn, $objModuleMap->output() );
			$arrOutput['list'][]		= sprintf( $strListColumn, $objModuleList->output() );
		}else{
			$arrOutput['map'][] = $arrOutput['list'][] = join( '',
				Array(
					'<div class="alert alert-warning text-center">',
						$clsMapName,
						esc_html__( "You must activate Javo Core Pluign (required plugin) to work properly. please activate the plugin.", 'javohome' ),
					'</div>',
				)
			);
		}
	} endif;
	do_action( 'jvfrm_home_template_all_module_loop_after', $argsTemplate );

	die( json_encode( Array( 'list' => join( '', $arrOutput['list'] ), 'map' => join( '', $arrOutput['map'] ) ) ) );
}




/**
 *	Javo Map Get Berief Informations in Google Map InfoWindow
 *
 * @type		filter
 *	@function	jvfrm_home_map_brief_callback
 */
add_action( 'wp_ajax_nopriv_jvfrm_home_map_brief', 'jvfrm_home_map_brief_callback');
add_action( 'wp_ajax_jvfrm_home_map_brief', 'jvfrm_home_map_brief_callback');
function jvfrm_home_map_brief_callback(){
	$post = get_post( intVal( $_POST[ 'post_id' ] ) );
	$arrReturn = Array( 'html' => '' );
		$arrHTML = Array();
		$arrHTML[] = sprintf(
			'<div class="row">
				<div class="col-md-12">
					<a href="%1$s"><h1>%2$s</h1></a>
				</div>
				<div class="col-md-12">

				</div>
			</div>',
			get_permalink( $post ),
			$post->post_title
		);

		$arrHTML[] = sprintf(
			'<div class="row">
				<div class="col-md-6"><a href="%1$s">%2$s</a></div>
				<div class="col-md-6 alert alert-light-gray">
					<div class="">%3$s</div>
					%4$s
				</div>
			</div>',
			get_permalink( $post ),
			get_the_post_thumbnail( $post, 'thumbnail', Array( 'class' => 'img-circle img-inner-shadow' ) ),
			esc_html__('Description','javohome'),
			get_the_excerpt( $post )
		);

		$arrHTML[] = sprintf(
			'<div class="row"><div class="col-md-6"><ul class="list-unstyled"><li>%1$s : %2$s</li><li>%3$s : %4$s</li><li>%5$s : %6$s</li></ul></div></div>',
			esc_html__( 'Phone1', 'javohome'), get_post_meta( $post->ID, '_phone1', true ),
			//esc_html__( 'Email', 'javohome'), get_post_meta( $post->ID, '_email', true ),
			esc_html__( 'Website', 'javohome'), get_post_meta( $post->ID, '_website', true ),
			esc_html__( 'Website', 'javohome'), esc_html__( 'Website', 'javohome'),
			esc_html__( 'Website12', 'javohome'), esc_html__( 'Website12', 'javohome')
		);

		$arrHTML = apply_filters( 'jvfrm_home_map_brief_contents', $arrHTML, $post );

	$arrReturn[ 'html' ] = join( false, $arrHTML );
	die( json_encode( $arrReturn ) );
}




/**
 *
 *
 * @type		filter
 *	@function	jvfrm_home_map_brief_callback
 */
add_action("wp_ajax_nopriv_jvfrm_home_map_contact_form", 'jvfrm_home_map_contact_form');
add_action("wp_ajax_jvfrm_home_map_contact_form", 'jvfrm_home_map_contact_form');
function jvfrm_home_map_contact_form(){
	$arrReturn = Array(
		'html' => '',
		'shortcode' => jvfrm_home_tso()->get( 'map_contact_form', false ),
		'id' => jvfrm_home_tso()->get( 'map_contact_form_id', false ),
	);
	if( !empty( $arrReturn[ 'shortcode' ] ) ) {
		$arrShortcode = sprintf( '[%1$s id="%2$s"]', $arrReturn[ 'shortcode' ], $arrReturn[ 'id' ] );
		$arrReturn[ 'html' ] = do_shortcode( $arrShortcode );
	}else{
		$arrReturn[ 'html' ] = sprintf(
			'<h3>%1$s</h3><br><span>%2$s</span>',
			esc_html__( "You haven't setup a contact form. Please set it up.", 'javohome' ),
			esc_html__( "(Theme Settings > Map > Contact form plugin & Contact form ID)", 'javohome' )
		);
	}

	die( json_encode( $arrReturn ) );
}