<?php

if( !defined( 'ABSPATH' ) )
	die;

class jvfrm_home_Directory_Template extends jvfrm_home_Directory
{

	const CORE_PREFIX_FORMAT = 'jvfrm_home_%s_';

	public $prefix = 'jvfrm_home_';

	public $core_prefix = '';

	public $is_archive = false;

	private $map_slug = '';

	private $filter_position = false;

	private $single_type = 'type-a';

	private $support_type = 'type-c';

	private static $instance = false;

	public $is_review_plugin_active = false;

	public $is_cross_domain = false;

	public $json_file = '';

	public function __construct() {

		$this->map_slug = 'multipleBox';
		self::$instance = &$this;

		$this->core_prefix = sprintf( self::CORE_PREFIX_FORMAT, self::SLUG );

		// Get Json File Name
		add_action( 'init', Array( $this, 'active_hooks' ), 11 );
		add_action( 'wp_head', Array( $this, 'active_hooks' ) );
		// add_action( 'wp_head', Array( $this, 'single_hooks' ) );
		add_action( 'wp_enqueue_scripts', Array( $this, 'single_hooks' ) );
		add_action( 'init', Array( $this, 'get_lava_jsonfile' ), 99 );

		// $this->active_hooks();
		$this->checkRequirePlugins();
	}

	public function setCoreSingleType() {
		$arrTypes = Array(
			'type-a',
			'type-b',
			//'type-c',
			'type-half',
			//'type-three-blocks',
			'type-grid',
			'type-left-tab',
			'type-top-tab'
		);

		$strType = jvfrm_home_tso()->get( 'property_single_type', 'type-a' );
		//die( 'jvfrm_home_' . self::SLUG . '_single_type' );
		$dynamic_options = array();
		$dynamic_options = apply_filters( 'jvfrm_home_' . self::SLUG . '_single_type', $strType, jvfrm_home_tso() );
		if( isset( $dynamic_options['newType'] ) && in_array( $dynamic_options['newType'], $arrTypes ) ) {
			$this->single_type = $dynamic_options['newType'];
		}
	}

	public function active_hooks() {
		/* Common */

			// Mobile Menu
			add_action( 'jvfrm_home_body_after', Array( $this, 'custom_mobile_menul' ), 9 );
			add_filter( 'jvfrm_home_core_post_type', Array( $this, 'getSlug' ) );
			add_filter( 'jvfrm_home_allow_type_header_toolbars_body', Array( $this, 'toolbar_widget_position' ) );

		/* Single */ {

			// Header
			// add_filter( 'body_class' , Array( $this, 'custom_single_body_class' ) );

			add_filter( 'jvfrm_home_' . self::SLUG . '_single_listing_rating', Array( $this, 'listing_rating_load' ) );
			///add_filter( 'get_header' , Array( $this, 'single_template_remove_margin' ) );
			add_filter( 'jvfrm_home_post_title_header', Array( $this, 'hidden_sintle_title' ), 10, 2 );
			add_filter( 'jvfrm_home_single_post_types_array', Array( $this, 'custom_single_transparent' ) );
			/*
			add_action( 'lava_' . self::SLUG . '_single_container_before', Array( $this, 'custom_single_header' ) );
			add_action( 'jvfrm_home_' . self::SLUG . '_single_body', Array( $this, 'custom_single_body' ) );
			add_action( 'lava_' . self::SLUG . '_manager_single_enqueues', Array( $this, 'custom_single_enqueues' ) );

			if($this->single_type != 'type-grid'){
				add_action( 'jvfrm_home_' . self::SLUG . '_single_description_before', Array( $this, 'append_video' ) );
				add_action( 'jvfrm_home_' . self::SLUG . '_single_description_before', Array( $this, 'append_3DViewer' ) );
				add_action( 'jvfrm_home_' . self::SLUG . '_single_description_before', Array( $this, 'append_vendor_produce' ) );
			}else if($this->single_type=='type-grid'){
				add_action( 'jvfrm_home_' . self::SLUG . '_single_author_after', Array( $this, 'append_vendor_produce' ) );
				add_action( 'jvfrm_home_' . self::SLUG . '_single_author_after', Array( $this, 'append_video' ) );
				add_action( 'jvfrm_home_' . self::SLUG . '_single_author_after', Array( $this, 'append_3DViewer' ) );
			} */

			// Custom CSS
			add_filter( 'jvfrm_home_custom_css_rows', Array( $this, 'custom_single_template_css_row' ), 20 );

			// Get Direction
			// add_action( 'jvfrm_home_' . self::SLUG . '_single_map_after', Array( $this, 'append_get_direction' ) );
			add_action( $this->core_prefix . 'single_body', Array( $this, 'append_get_direction' ) );

			// Navigation
			add_filter( 'jvfrm_home_detail_item_nav', Array( $this, 'custom_single_header_nav' ) );

			// Footer
			add_action( 'lava_' . self::SLUG . '_single_container_after', Array( $this, 'custom_single_dot_nav' ) );
		}

		/* Single Support */ {

			// Header
			add_filter( 'body_class' , Array( $this, 'custom_single_body_class' ) );
			///add_filter( 'get_header' , Array( $this, 'single_template_remove_margin' ) );
			add_filter( 'jvfrm_home_post_title_header', Array( $this, 'hidden_sintle_title' ), 10, 2 );
			add_action( 'lava_' . self::SUPPORT . '_single_container_before', Array( $this, 'custom_single_support_header' ) );

			add_action( 'jvfrm_home_' . self::SUPPORT . '_single_body', Array( $this, 'custom_single_support_body' ) );
			add_action( 'lava_' . self::SUPPORT . '_manager_single_enqueues', Array( $this, 'custom_single_enqueues' ) );

			// Navigation
			add_filter( 'jvfrm_home_detail_support_nav', Array( $this, 'custom_single_support_header_nav' ) );

			// Footer
			add_action( 'lava_' . self::SUPPORT . '_single_container_after', Array( $this, 'custom_single_dot_nav' ) );
		}

		/* Map */ {

			// Map Data
			add_action( 'lava_' . self::SLUG . '_setup_mapdata', Array( $this, 'custom_map_parameter' ), 10, 3 );

			add_action( 'jvfrm_home_map_brief_contents', Array( $this, 'map_brief_contents' ), 10, 3 );

			// Map Template Hooks
			add_action( 'lava_' . self::SLUG . '_map_wp_head', Array( $this, 'custom_map_hooks' ) );

			// Custom CSS
			add_filter( 'jvfrm_home_custom_css_rows', Array( $this, 'custom_map_template_css_row' ), 30 );

			// Header
			add_action( 'lava_' . self::SLUG . '_map_box_enqueue_scripts', Array( $this, 'custom_map_enqueues' ) );
			add_action( 'lava_' . self::SLUG . '_map_container_before', Array( $this, 'custom_before_setup' ) );

			// Body
			add_action( 'jvfrm_home_' . self::SLUG . '_map_body', Array( $this, 'custom_load_map' ) );

			// Body Class
			add_filter( 'lava_' . self::SLUG . '_map_classes', Array( $this, 'custom_map_classes' ) );

			// Footer
			add_action( 'lava_' . self::SLUG . '_map_container_after', Array( $this, 'custom_map_scripts' ) );

			// Map List Type
			add_filter( 'jvfrm_home_' . self::SLUG . '_map_list_filters', Array( $this, 'custom_mapList_filters' ) );
			// add_filter( 'jvfrm_home_' . self::SLUG . '_map_list_wrap_before', Array( $this, 'listing_mobile_filter' ) );

			// Load Templates
			add_filter( 'lava_' . self::SLUG . '_map_htmls' , Array( $this, 'custom_map_htmls' ), 10, 2 );

			add_filter( 'jvfrm_home_template_map_module_options', Array( $this, 'map_no_lazyload' ) );
			add_filter( 'jvfrm_home_template_list_module_options', Array( $this, 'map_no_lazyload' ) );

			//Filter
			$this->setFilterFields();

			add_action( 'jvfrm_home_map_output_class', Array( $this, 'mapOutput_class' ) );
			add_action( 'jvfrm_home_map_list_output_class', Array( $this, 'listOutput_class' ) );

			// Option
			add_action( 'jvfrm_home_core_map_template_layout_setting_after', Array( $this, 'layout_setting' ), 10, 2 );
		}

		/* Archive */
		{
			add_filter( 'jvfrm_home_template_list_module', Array( $this, 'archive_map_list_module' ), 10, 2 );
			add_filter( 'jvfrm_home_template_list_module_loop', Array( $this, 'archive_map_list_module_loop' ), 10, 3 );
			add_filter( 'jvfrm_home_template_map_module', Array( $this, 'archive_map_module' ), 10, 2 );
			add_filter( 'jvfrm_home_template_map_module_loop', Array( $this, 'archive_map_module_loop' ), 10, 3 );

			add_filter( 'lava_' . self::SLUG . '_get_template' , Array( $this, 'custom_archive_page' ), 10, 3 );
			add_filter( 'jvfrm_home_map_class', Array( $this, 'custom_map_class' ), 30, 2 );
			add_filter( 'jvfrm_home_' . self::SLUG . '_map_list_content_column_class', Array( $this, 'custom_list_content_column' ), 10, 3 );
			add_action( 'jvfrm_home_' . self::SLUG . '_map_list_container_before', Array( $this, 'map_list_container_before' ), 15 );
			add_action( 'jvfrm_home_' . self::SLUG . '_map_list_container_after', Array( $this, '_map_list_container_after' ) );
		}

		/* My Page */ {
			add_action( 'template_redirect', Array( $this, 'price_table_redirect' ), 9 );
			// add_filter( 'jvfrm_home_dashboard_slugs' , Array( $this, 'custom_register_slug' ) );
			add_filter( 'jvfrm_home_mypage_sidebar_args', Array( $this, 'custom_mypage_sidebar' ) );
			add_filter( 'jvfrm_home_dashboard_custom_template_url', Array( $this, 'append_properties' ), 50, 2 );
			add_filter( 'jvfrm_home_dashboard_type-b_nav', Array( $this, 'custom_type_b_mypage_nav' ) );
			add_filter( 'jvfrm_home_dashboard_mylists', Array( $this, 'dashboard_mylists' ) );
			add_action( 'jvfrm_home_module_html_after', Array( $this, 'dashboard_mylists_edit_button' ), 10, 2);
			add_action( 'jvfrm_home_module_html_after', Array( $this, 'dashboard_mylists_payment_button' ), 10, 2);
		}


		/* Widget */{
			add_filter( 'jvfrm_home_recent_posts_widget_excerpt', Array( $this, 'core_recentPostsWidget' ), 10, 4 );
			add_filter( 'jvfrm_home_recent_posts_widget_describe_type_options', Array( $this, 'core_recentPostsWidgetOption' ), 10, 1 );
		}
	}

	public function single_hooks() {
		$this->setCoreSingleType();

		add_filter( 'body_class' , Array( $this, 'custom_single_body_class' ) );
		add_action( 'lava_' . self::SLUG . '_single_container_before', Array( $this, 'custom_single_header' ) );
		add_action( 'jvfrm_home_' . self::SLUG . '_single_body', Array( $this, 'custom_single_body' ) );
		add_action( 'lava_' . self::SLUG . '_manager_single_enqueues', Array( $this, 'custom_single_enqueues' ) );
		add_action( 'jvfrm_home_' . self::SLUG . '_single_content_body', Array( $this, 'append_detail_option' ) );
		add_action( 'jvfrm_home_' . self::SLUG . '_single_content_body', Array( $this, 'append_attach_images' ) );
		add_action( 'jvfrm_home_' . self::SLUG . '_single_content_body', Array( $this, 'append_condition' ) );
		add_action( 'jvfrm_home_' . self::SLUG . '_single_map_after', Array( $this, 'append_author_info' ) );

		/*
		if($this->single_type != 'type-grid'){
			add_action( 'jvfrm_home_' . self::SLUG . '_single_description_before', Array( $this, 'append_video' ) );
			add_action( 'jvfrm_home_' . self::SLUG . '_single_description_before', Array( $this, 'append_3DViewer' ) );
			add_action( 'jvfrm_home_' . self::SLUG . '_single_description_before', Array( $this, 'append_vendor_produce' ) );

		}else if($this->single_type=='type-grid'){
			add_action( 'jvfrm_home_' . self::SLUG . '_single_author_after', Array( $this, 'append_vendor_produce' ) );
			add_action( 'jvfrm_home_' . self::SLUG . '_single_author_after', Array( $this, 'append_video' ) );
			add_action( 'jvfrm_home_' . self::SLUG . '_single_author_after', Array( $this, 'append_3DViewer' ) );
		}*/

		add_filter( 'jvfrm_home_' . self::SLUG . '_single_tab_menus', Array( $this, 'single_tab_menus' ) );

		switch ($this->single_type) {
		case 'type-a':
			add_action( 'jvfrm_home_' . self::SLUG . '_single_description_before', Array( $this, 'append_vendor_produce' ) );
			add_action( $this->core_prefix . 'single_booking', Array( $this, 'append_booking_form' ), 9 );
			break;
		case 'type-b':
			add_action( 'jvfrm_home_' . self::SLUG . '_single_description_before', Array( $this, 'append_vendor_produce' ) );
		    add_action( $this->core_prefix . 'single_booking', Array( $this, 'append_booking_form' ), 9 );
			break;
		case 'type-c':
			add_action( 'jvfrm_home_' . self::SLUG . '_single_description_before', Array( $this, 'append_vendor_produce' ) );
			break;
		case 'type-half':
			add_action( 'jvfrm_home_' . self::SLUG . '_single_description_before', Array( $this, 'append_vendor_produce' ) );
			add_action( $this->core_prefix . 'single_booking', Array( $this, 'append_booking_form' ), 9 );
			break;
		case 'type-grid':
			add_action( 'jvfrm_home_' . self::SLUG . '_single_author_after', Array( $this, 'append_vendor_produce' ) );
			add_action( $this->core_prefix . 'single_booking', Array( $this, 'append_booking_form' ), 9 );
			break;
		case 'type-top-tab':
			//add_action( 'jvfrm_home_' . self::SLUG . '_single_description_before', Array( $this, 'append_vendor_produce' ) );
			add_action( 'jvfrm_home_' . self::SLUG . '_single_vendor', Array( $this, 'append_vendor_produce' ) );
			//add_action( 'jvfrm_home_' . self::SLUG . '_single_others', Array( $this, 'append_to_single_page' ) );
			// add_action( 'jvfrm_home_' . self::SLUG . '_single_others', Array( $this, 'append_to_single_page' ) );
			add_action( $this->core_prefix . 'single_booking', Array( $this, 'append_booking_form' ), 9 );
			break;
		case 'type-left-tab':
			add_action( 'jvfrm_home_' . self::SLUG . '_single_vendor', Array( $this, 'append_vendor_produce' ) );
			add_action( $this->core_prefix . 'single_booking', Array( $this, 'append_booking_form' ), 9 );
			break;
		}
	}

	public function checkRequirePlugins() {
		$this->is_review_plugin_active = class_exists( 'Lava_Directory_Review' );
	}

	public function get_lava_jsonfile(){

		if( !function_exists( 'lava_realestate' ) )
			return;

		if( method_exists( lava_realestate()->core, 'getJsonFileName' ) )
			$this->json_file = lava_realestate()->core->getJsonFileName();

		if( method_exists( lava_realestate()->core, 'is_crossdomain' ) )
			$this->is_cross_domain = lava_realestate()->core->is_crossdomain();
	}


	public function load_template( $template_name, $extension='.php' , $params=Array(), $_once=true ) {

		if( !empty( $params ) )
			extract( $params );

		$strFileName = jvfrm_home_core()->template_path . '/' . $template_name . $extension;
		$strFileName = apply_filters( 'jvfrm_home_core_load_template', $strFileName, $template_name );

		if( file_exists( $strFileName ) ) {
			if( $_once ) {
				require_once $strFileName;
			}else{
				require $strFileName;
			}
			return true;
		}

		return false;
	}

	public function toolbar_widget_position( $allow=Array() ) {
		return array( 'jv-nav-row-2-lvl nav-transparent' );
	}

	public function custom_single_body_class( $body_classes=Array() ) {

		$arrSinglePostType = Array( self::SLUG, self::SUPPORT );
		$body_classes[] = $this->single_type;

		if( in_array( get_post_type(), $arrSinglePostType ) )
			$body_classes[]	= 'no-sticky';

		return $body_classes;
	}

	public function listing_rating_load()
	{
		global $post;
		$listing_rating = '';
		if( ! $this->is_review_plugin_active )
			return  $listing_rating;

		if( is_singular( self::SLUG ) ) {
			$listing_rating = $this->get_header_rating( $post->ID );
		}

		return $listing_rating;
	}

	public function get_header_rating( $post_id ){

		$intRatingScore	= $intReviewers = 0;
		$strRatingStars	= '';
		if( $this->is_review_plugin_active ) {
			$intRatingScore		= call_user_func( Array( lv_directoryReview()->core, 'get' ), 'average' );
			$intReviewers		= call_user_func( Array( lv_directoryReview()->core, 'get' ), 'count'  );
			$strRatingStars		= call_user_func( Array( lv_directoryReview()->core, 'fa_get' ) );
		}
		return join(
			"\n",
			Array(
				'<a href="#javo-item-review-section" class="link-review">',
					$strRatingStars,
					'<span class="review-score">',
						$intRatingScore,
					'</span>',
					'<span class="review-count">',
						$intReviewers . ' ',
						_n( "Vote", "Votes", intVal( $intReviewers ), 'javohome' ),
					'</span>',
				'</a>',
			)
		);
	}

	public function hidden_sintle_title( $post_title='', $post=null )
	{
		if( is_null( $post ) || get_post_type( $post ) === self::SLUG )
			$post_title = null;

		return $post_title;
	}

	public function custom_single_transparent( $post_types=Array() ){
		$post_types[]	= self::SLUG;
		return $post_types;
	}

	public function custom_single_enqueues(){
		wp_enqueue_style( jvfrm_home_core()->getHandleName( 'single.css' ) );
		wp_enqueue_script( 'jquery-sticky' );
		wp_enqueue_script( 'ZeroClipboard-min' );
		wp_enqueue_script( 'light-gallery' );

		wp_localize_script(
			jvfrm_home_core()->getHandleName( 'single.js' ),
			'jvfrm_home_custom_post_param',
			Array(
				'widget_sticky' => jvfrm_home_tso()->get( jvfrm_home_core()->slug . '_single_sticky_widget' ),
				'map_type' => jvfrm_home_tso()->get( jvfrm_home_core()->slug . '_map_width_type' ),
				'single_type' => $this->single_type,
				'map_style' => stripslashes( htmlspecialchars_decode( jvfrm_home_tso()->get( 'map_style_json' ) ) ),
			)
		);

		wp_enqueue_script( jvfrm_home_core()->getHandleName( 'single.js' ) );
	}

	public function append_detail_option() {
		$this->load_template( 'html-single-features', '.php', Array( 'post' => $GLOBALS[ 'post' ] ) );
	}

	public function append_attach_images() {
		if( ! jvfrm_home_has_attach() )
			return;

		echo '<div class="col-md-12 col-xs-12 item-gallery">';
		get_template_part( 'includes/templates/html', 'single-grid-images' );
		echo '</div>';
	}

	public function append_condition() {
		$arrSingleOption = isset( $GLOBALS[ 'single_addon_options' ] ) ? (array) $GLOBALS[ 'single_addon_options' ] : Array();
		if( isset( $arrSingleOption[ 'disable_detail_section' ] ) && $arrSingleOption[ 'disable_detail_section' ] != '' ) {
			return false;
		}
		get_template_part( 'includes/templates/html', 'single-detail-options' );
	}

	public function append_author_info() {
		$this->load_template( 'html-single-author-info', '.php', Array( 'post' => $GLOBALS[ 'post' ] ) );
	}

	public function custom_single_header() {
		$this->load_template( 'part-single-header-' . $this->single_type );
		//$this->load_template( 'part-single-header-type-dynamic' );
	}

	public function custom_single_body() {
		$this->load_template( 'template-single-' . $this->single_type );
		//$this->load_template( 'template-single-type-top-tab' );
	}

	public function custom_single_support_header() {
		$this->load_template( 'part-single-header-' . $this->support_type );
	}

	public function custom_single_support_body() {
		$this->load_template( 'template-single-' . $this->support_type );
	}

	public function single_tab_menus( $menus=Array() ) {

		if( function_exists( 'lv_directoryReview' ) ) {
			$menus[ 'review' ] = Array(
				'label' => esc_html__( "Review", 'javohome' ),
				'icon' => "jvd-icon-dialogue_think"
			);
		}

		if( function_exists( 'lava_realestate_vendor' ) && get_post_meta( get_the_ID(), '_vendor', true )  ) {
			$menus[ 'vendor' ] = Array(
				'label' => esc_html__( "Deals", 'javohome' ),
				'icon' => "jvd-icon-shopping_cart"
			);
		}

		if( function_exists( 'lava_realestate_booking' ) && get_post_meta( get_the_ID(), '_booking', true ) ) {
			$menus[ 'booking' ] = Array(
				'label' => esc_html__( "Booking", 'javohome' ),
				'icon' => "jvd-icon-calendar"
			);
		}
		$menus[ 'others' ] = Array(
			'label' => esc_html__( "Others", 'javohome' ),
			'icon' => "jvd-icon-website_1"
		);
		return $menus;
	}

	public function append_video() {
		if( !function_exists( 'lava_realestate_video' ) )
			return;
		lava_realestate_video()->core->append_video();
	}

	public function append_3DViewer() {
		if( !function_exists( 'lava_realestate_3DViewer' ) )
			return;
		lava_realestate_3DViewer()->core->append_3DViewer();
	}

	public function append_vendor_produce() {
		if( !function_exists( 'lava_realestate_vendor' ) )
			return;

		if( ! $intVendorID = intVal( lava_realestate_vendor()->core->getVendorID() ) )
			return;

		$this->load_template(
			'part-single-vendor-products',
			'.php',
			Array(
				'vendor_products' => lava_realestate_vendor()->core->getProducts(
					Array(
						'vendor'	=> $intVendorID,
						'exclude_booking' => true,
					)
				)
			)
		);
	}

	public function append_booking_form() {

		if( !function_exists( 'lava_realestate_booking' ) || !function_exists( 'wc_get_template') || !class_exists( 'WC_Booking_Form' ) )
			return;

		$bookingProductID = lava_realestate_booking()->core->getProductID();
		$GLOBALS[ 'product' ] = $bookingProduct = get_product( $bookingProductID );

		if( !$bookingProduct )
			return;

		if( $bookingProduct->product_type != 'booking' )
			return;

		$objForm = new WC_Booking_Form( $bookingProduct );

		$this->load_template(
			'part-single-booking-form',
			'.php',
			Array(
				'jvfrm_home_booking_form' => $objForm
			)
		);
	}

	public function custom_single_template_css_row( $rows=Array() ){
		$strPrefix = 'html body.single.single-' . jvfrm_home_core()->slug . ' ';

		$rows[] = $strPrefix . 'header#header-one-line nav.javo-main-navbar';
		$rows[] = '{ top:auto; position:relative; left:auto; right:auto; }';

		return $rows;
	}

	public function custom_single_support_template_css_row( $rows=Array() ){
		$strPrefix = 'html body.single.single-' . self::SUPPORT . ' ';

		$rows[] = $strPrefix . 'header#header-one-line nav.javo-main-navbar';
		$rows[] = '{ top:auto; position:relative; left:auto; right:auto; }';

		return $rows;
	}

	public function append_get_direction(){
		if( !function_exists( 'lava_realestate_direction'  ) )
			return;

		$this->load_template(
			'part-single-get-direction',
			'.php',
			Array(
				'objGetDirection' => lava_realestate_direction()->template
			)
		);
	}

	public function custom_single_header_nav( $args=Array() ) {

		$arrAllowPostTypes						= apply_filters( 'jvfrm_home_single_post_types_array', Array( 'property' ) );
		$append_args								= Array();
		$append_args[ 'javo-item-condition-section'	 ]	= Array(
			'label'									=> esc_html__( "Detail", 'javohome' )
			, 'class'									=> 'glyphicon glyphicon-tasks'
			, 'type'									=> $arrAllowPostTypes
		);
		$append_args[ 'javo-item-describe-section' ]	= Array(
			'label'									=> esc_html__( "Description", 'javohome' )
			, 'class'									=> 'glyphicon glyphicon-align-left'
			, 'type'									=> $arrAllowPostTypes
		);
		$append_args[ 'javo-item-amenities-section'	 ]	= Array(
			'label'									=> esc_html__( "Amenities", 'javohome' )
			, 'class'									=> 'glyphicon glyphicon-ok-circle'
			, 'type'									=> $arrAllowPostTypes
		);
		if( class_exists( 'Lava_Directory_Review' ) ) :
			$append_args[ 'javo-item-review-section' ]	= Array(
				'label'									=> esc_html__( "Review", 'javohome' )
				, 'class'									=> 'glyphicon glyphicon-comment'
				, 'type'									=> $arrAllowPostTypes
			);
		endif;
		/*$append_args[ 'javo-item-location-section' ]		= Array(
			'label'									=> esc_html__( "Location", 'javohome' )
			, 'class'									=> 'glyphicon glyphicon-map-marker'
			, 'type'									=> $arrAllowPostTypes
		);*/

		return wp_parse_args( $append_args, $args );
	}

	public function custom_single_support_header_nav( $args=Array() ) {

		$arrAllowPostTypes						= Array( self::SUPPORT );
		$append_args								= Array();
		$append_args[ 'jvfrm-support-last-answer'	 ]	= Array(
			'label'									=> esc_html__( "Last Answer", 'javohome' )
			, 'class'									=> 'glyphicon glyphicon-tasks'
			, 'type'									=> $arrAllowPostTypes
		);
		$append_args[ 'jvfrm-support-update-ticket' ]	= Array(
				'label'									=> esc_html__( "Update Ticket", 'javohome' )
				, 'class'									=> 'glyphicon glyphicon-comment'
				, 'type'									=> $arrAllowPostTypes
		);
		$append_args[ 'jvfrm-support-policy' ]	= Array(
			'label'									=> esc_html__( "Support Policy", 'javohome' )
			, 'class'									=> 'glyphicon glyphicon-ok-circle'
			, 'type'									=> $arrAllowPostTypes
		);
		$append_args[ 'jvfrm-support-hour' ]	= Array(
			'label'									=> esc_html__( "Support Hours", 'javohome' )
			, 'class'									=> 'glyphicon glyphicon-align-left'
			, 'type'									=> $arrAllowPostTypes
		);
		//if( class_exists( 'Lava_Directory_Review' ) ) :
		$append_args[ 'jvfrm-support-watch' ]		= Array(
			'label'									=> esc_html__( "Save This Ticket", 'javohome' )
			, 'class'									=> 'glyphicon glyphicon-map-marker'
			, 'type'									=> $arrAllowPostTypes
		);
		//endif;

		return wp_parse_args( $append_args, $args );
	}

	public function custom_mobile_menul( $slug='' ) {
		if( $slug === 'lava_' . $this->getSlug() . '_map' ) {
			$this->load_template( 'html-mobile-menu' );
			$this->load_template( 'html-modal-mobile-search' );
			remove_action( 'jvfrm_home_body_after', array( jvfrm_home_layout(), 'footer' ) );
		}
	}

	public function custom_single_dot_nav() {
		$this->load_template( 'part-single-dot-nav' );
	}

	public function custom_map_parameter( $obj, $get=false, $post=false )
	{
		global $wp_query;

		$objQueried					= $wp_query->queried_object;
		$objQueried->term_id	= isset( $objQueried->term_id ) ? $objQueried->term_id : 0;

		if( !is_a( $obj, 'WP_Post' )  || !$get | !$post )
			return;

		$obj->req_property_type	= $get->get( 'type', $post->get( 'type', $objQueried->term_id ) );
		$obj->req_property_city			= $get->get( 'city', $post->get( 'city', $objQueried->term_id ) );
		$obj->req_property_status		= $get->get( 'status', $post->get( 'status', $objQueried->term_id ) );
		$obj->req_property_amenities	= $get->get( 'amenity', $post->get( 'amenity', $objQueried->term_id ) );

		// Meta
		$obj->req_bedrooms				= $get->get( 'beds', $post->get( 'beds', false ) );
		$obj->req_bathrooms				= $get->get( 'baths', $post->get( 'baths', false ) );
		$obj->req_garages					= $get->get( 'garages', $post->get( 'garages', false ) );
		$obj->req_price_min				= $get->get( 'minPrice', $post->get( 'minPrice', false ) );
		$obj->req_price_max				= $get->get( 'maxPrice', $post->get( 'maxPrice', false ) );

		$obj->req_is_geolocation		= $get->get( 'geolocation', $post->get( 'geolocation', false ) );

		// Header Hidden
		add_filter( 'jvfrm_home_post_title_header', '__return_false' );
	}

	public function map_brief_contents( $html=Array(), $post ) {
		ob_start();
		$this->load_template( 'template-brief-contents', '.php', array( 'jvfrm_home_post' => $post ) );
		$html = Array( ob_get_clean() );
		return $html;
	}

	public function custom_map_hooks() {

		$options = (Array) get_post_meta( get_the_ID(), 'jvfrm_home_map_page_opt', true );
		$strOptionName = 'mobile_type';

		if(
			is_array( $options ) &&
			!empty( $options[ $strOptionName ] )  &&
			$options[ $strOptionName ] == 'ajax-top'
		){
			add_action( 'jvfrm_home_header_brand_right_after', Array( $this, 'addition_inner_switcher' ), 15 );
		}

	}

	public function custom_map_template_css_row( $rows ){
		$strPrefix		= 'html body.page-template.page-template-lava_' . jvfrm_home_core()->slug . '_map' . ' ';
		$strPrimary		= jvfrm_home_tso()->get( 'total_button_color', false );
		$strPrimary_text = jvfrm_home_tso()->get( 'primary_font_color', false );
		$strPrimary_border = 'none';
		if(jvfrm_home_tso()->get('total_button_border_use', false) == 'use' && jvfrm_home_tso()->get( 'total_button_border_color')!='' ){
			$strPrimary_border = '1px solid '.jvfrm_home_tso()->get( 'total_button_border_color', false );
		}
		$strPrimaryRGB	= apply_filters( 'jvfrm_home_rgb', substr( $strPrimary, 1) );

		if( $strPrimary ){
			$rows[] = $strPrefix . ".javo-shortcode .module .meta-category:not(.no-background),";
			$rows[] = $strPrefix . ".javo-shortcode .module .media-left .meta-category:not(.no-background)";
			/** ----------------------------  */
			$rows[] = "{ background-color:{$strPrimary}; color:{$strPrimary_text}; border:{$strPrimary_border}; }";

			$rows[] = $strPrefix . ".javo-shortcode .module.javo-module12 .thumb-wrap:hover .javo-thb:after";
			/** ----------------------------  */
			$rows[] = "{ background-color:rgba({$strPrimaryRGB['r']}, {$strPrimaryRGB['g']}, {$strPrimaryRGB['b']}, .92); }";
		}

		return apply_filters( 'jvfrm_home_' . self::SLUG . '_custom_map_css_rows', $rows, $strPrefix );
	}

	public function custom_map_enqueues() {
		global $post;

		$is_empty_post = false;

		wp_enqueue_script( 'jQuery-nouiSlider' );
		wp_enqueue_script( 'jquery-type-header' );
		wp_enqueue_script( 'selectize-script' );
		wp_enqueue_script( 'jquery-sticky' );
		wp_enqueue_script( 'jQuery-chosen-autocomplete' );

		if( !is_object( $post ) ){
			$is_empty_post = true;
			$post = new stdClass();
			$post->lava_type = $this->slug;
			$post->ID = 0;
		}

		$objOptions = new jvfrm_home_Array( (Array)get_post_meta( $post->ID, 'jvfrm_home_map_page_opt', true ) );

		wp_localize_script(
			jvfrm_home_core()->getHandleName( 'map-template.js' ),
			'jvfrm_home_core_map_param',
			apply_filters(
				'jvfrm_home_' . self::SLUG . '_map_params',
				Array(
					'ajaxurl' => admin_url( 'admin-ajax.php' ),
					'cross_domain' => $this->is_cross_domain,
					'json_file' => $this->json_file,
					'template_id' => $post->ID,
					'selctize_terms' => Array( 'property_type', 'property_status' ),
					'strLocationAccessFail' => esc_html__( "Your position access failed.", 'javohome' ),
					'amenities_filter' => $objOptions->get( 'amenities_filter' ),
					'allow_wheel' => jvfrm_home_tso()->get( 'map_allow_mousewheel', 'a' ),
					'map_marker' => $objOptions->get( 'map_marker', jvfrm_home_tso()->get( 'map_marker' ) ),
					'strings' => Array(
						'multiple_cluster' => esc_html__( "This place contains multiple places. please select one.", 'javohome' )
					),
				),
				jvfrm_home_tso(), $objOptions
			)
		);

		if( $is_empty_post )
			$post=  null;

		wp_enqueue_script( jvfrm_home_core()->getHandleName( 'map-template.js' ) );
	}

	public function custom_before_setup( $post )
	{
		$is_core_map_actived = class_exists( 'Javo_Home_Core_Map' );
		if( get_post_meta( get_post()->ID, '_map_filter_position', true ) == 'map-layout-search-top' && $is_core_map_actived )
			add_action( 'jvfrm_home_' . self::SLUG . '_map_switcher_before', Array( $this, 'custom_map_listing_filter' ) );
		else
			add_action( 'jvfrm_home_' . self::SLUG . '_map_lists_before', Array( $this, 'custom_map_listing_filter' ) );

	}

	public function addition_inner_switcher(){
		$this->load_template( 'part-map-filter-inner-switcher', '.php', Array( 'post' => $GLOBALS[ 'post' ] ), false );
	}

	public function custom_load_map() {

		$strFileName	= jvfrm_home_core()->template_path .'/template-map-multipleBox.php';
		if( ! file_exists( $strFileName ) ) {
			esc_html_e( "Not found template type", 'javohome' );
			return;
		}
		require_once $strFileName;
	}

	public function custom_map_classes( $classes=Array() ){

		$classes[] = 'no-sticky';
		$classes[] = 'no-smoth-scroll';

		$options = (Array) get_post_meta( get_the_ID(), 'jvfrm_home_map_page_opt', true );
		$strOptionName = 'mobile_type';

		if( is_array( $options ) && !empty( $options[ $strOptionName ] ) )
			$classes[] = 'mobile-' . $options[ $strOptionName ];

		return $classes;
	}

	public function custom_map_scripts() {
		global $jvfrm_home_Directory;

		$strFileName		= Array();
		$strFileName[]		= $jvfrm_home_Directory->template_path;
		$strFileName[]		= 'scripts-map-'. $this->map_slug . '.php';
		$strFileName		= @implode( '/', $strFileName );

		if( !file_exists( $strFileName ) ){
			echo $strFileName;
			return;
		}

		require_once $strFileName;
	}

	public function custom_mapList_filters( $filters=Array() ){
		global $post;
		return Array(
			wp_parse_args(
				Array(
					'geo-location'	=>
						Array(
							'label'		=> esc_html__( "Location", 'javohome' )
							, 'inner'		=> Array(
								Array(
									'ID'					=> 'javo-map-box-location-trigger'
									, 'type'				=> 'location'
									, 'class'				=> 'form-control javo-location-search'
									, 'value'				=> $post->jvfrm_home_current_rad
									, 'placeholder'	=> esc_html__( "Location", 'javohome' )
								)
								, Array( 'type'		=> 'separator' )
								, Array(
									'type'				=> 'division'
									, 'class'				=> 'javo-geoloc-slider-trigger'
								)
							)
						)
					, 'filter-keyword'				=>
						Array(
							'label'						=> esc_html__( "Keyword", 'javohome' )
							, 'inner'						=> Array(
								Array(
									'ID'					=> 'jv-map-listing-keyword-filter'
									, 'type'				=> 'text'
									, 'class'				=> 'form-control jv-keyword-trigger'
									, 'value'				=> $post->lava_current_key
									, 'placeholder'	=> esc_html__( "Keyword", 'javohome' )
								)
							)
						)
					, 'filter-price'				=>
						Array(
							'label'						=> __( "Price", 'javohome' )
							, 'inner'						=> Array(
								Array(
									'ID'					=> ''
									, 'type'				=> 'price'
									, 'class'				=> Array(
										'min'				=> 'form-control'
										, 'max'			=> 'form-control'
									)
									, 'placeholder'	=> Array(
										'min'				=> __( "No Min", 'javohome' )
										, 'max'			=> __( "No Max", 'javohome' )
									)
									, 'value'				=> Array(
										'min'				=> $post->req_price_min
										, 'max'			=> $post->req_price_max
									)
								)
							)
						)
					, 'filter-types'						=>
						Array(
							'label'						=> __( "Types", 'javohome' )
							, 'inner'						=> Array(
								Array(
									'type'				=> 'select',
									'class'				=> 'form-control',
									'taxonomy'		=> 'property_type',
									'value'				=> $post->req_property_type	,
									'placeholder'	=> __( "All Types", 'javohome' )
								),
								Array(
									'type'				=> 'select',
									'class'				=> 'form-control',
									'taxonomy'		=> 'property_city',
									'value'				=> $post->req_property_city,
									'placeholder'	=> __( "All City", 'javohome' )
								),
								Array(
									'type'				=> 'select'
									, 'class'				=> 'form-control'
									, 'taxonomy'		=> 'property_status'
									, 'value'				=> $post->req_property_status
									, 'placeholder'	=> __( "All Status", 'javohome' )
								)
							)
						)

					, 'filter-options'					=>
						Array(
							'label'						=> __( "Option", 'javohome' )
							, 'inner'						=> Array(
								Array(
									'type'				=> 'select'
									, 'class'				=> 'form-control'
									, 'meta'				=> '_bedrooms'
									, 'range'			=> Array( 1, 10 )
									, 'value'				=> $post->req_bedrooms
									, 'placeholder'	=> __( "All Bedrooms", 'javohome' )
								)
								, Array(
									'type'				=> 'select'
									, 'class'				=> 'form-control'
									, 'meta'				=> '_bathrooms'
									, 'range'			=> Array( 1, 10 )
									, 'value'				=> $post->req_bathrooms
									, 'placeholder'	=> __( "All Bathrooms", 'javohome' )
								)
								, Array(
									'type'				=> 'select'
									, 'class'				=> 'form-control'
									, 'meta'				=> '_garages'
									, 'range'			=> Array( 1, 10 )
									, 'value'				=> $post->req_garages
									, 'placeholder'	=> __( "All Garages", 'javohome' )
								)
							)
						)

					, 'filter-amenities'				=>
						Array(
							'label'						=> __( "Amenities", 'javohome' )
							, 'inner'						=> Array(
								Array(
									'type'				=> 'checkbox'
									, 'class'				=> 'form-control'
									, 'taxonomy'		=> 'property_amenities'
									, 'value'				=> (Array) $post->req_property_amenities
								)
							)
						)
				)
			), $filters
		);
	}

	public function listing_mobile_filter( $post ) {
		$this->load_template( 'html-map-mobile-listing-menu', '.php', Array( 'post' => $post )  );
	}

	public function custom_map_htmls( $args, $plug_dir ) {
		global $jvfrm_home_Directory;
		$tmpDir		= $jvfrm_home_Directory->template_path . '/';
		return Array(
			'javo-map-loading-template'				=> $tmpDir . 'html-map-loading.php'
			, 'javo-map-box-panel-content'			=> $tmpDir . 'html-map-grid-template.php'
			, 'javo-map-box-infobx-content'		=> $tmpDir . 'html-map-popup-contents.php'
			, 'javo-list-box-content'						=> $tmpDir . 'html-list-box-contents.php'
			, 'javo-map-inner-control-template'	=> $tmpDir . 'html-map-inner-controls.php'
		);
	}

	public function map_no_lazyload( $args=Array() ){ return wp_parse_args( Array( 'no_lazy' => true ), $args ); }

	public function mapOutput_class( $classes=Array() ){

		$classes[] = 'module-hover-zoom-in';
		/* $classes[] = 'module-hover-dark-fade-in'; */
		return $classes;

	}

	public function listOutput_class( $classes=Array() ){

		$classes[] = 'module-hover-zoom-in';
		/* $classes[] = 'module-hover-dark-fade-in'; */
		return $classes;
	}

	public function layout_setting( $post, $objOption ) {

		$strOptionName = 'mobile_type';
		$strOptionBuffer = '';
		foreach(
			Array(
				'' => __( "Default", 'javohome' ),
				'ajax-top' => __( "Ajax Top", 'javohome' ),
			) as $value => $label
		) $strOptionBuffer .= sprintf(
			"<option value=\"{$value}\"%s>{$label}</option>",
			selected( $value == $objOption->get( $strOptionName, '' ), true, false )
		);

		printf(
			'<tr><th> <label>%1$s</label> </th><td>
				<select name="jvfrm_home_map_opts[%2$s]">%3$s</select>
				<div><small>%4$s</small></div>
			</td></tr>',
			__( "Mobile Map Search Type", 'javohome' ),
			$strOptionName,
			$strOptionBuffer,
			__( 'Note : if you choose ajax top option, "Initial display - MAP or LIST first" option will be disabled on mobile version ( lower than width 768px)', 'javohome' )
		);

	}

	public function setFilterFields() {
		$orderFields		= Array(
			Array(
				'position'	=> 'outer',
				'callback'	=> 'fieldAddress'
			),
			Array(
				'position'	=> 'outer',
				'callback'	=> 'fieldType'
			),
			Array(
				'position'	=> 'outer',
				'callback'	=> 'fieldStatus'
			),
			Array(
				'position'	=> 'outer',
				'callback'	=> 'fieldOrder'
			),
			Array(
				'position'	=> 'inner',
				'callback'	=> 'fieldCity'
			),
			Array(
				'position'	=> 'inner',
				'callback'	=> 'fieldKeyword'
			),
			Array(
				'position'	=> 'inner',
				'callback'	=> 'fieldPrice'
			),
			Array(
				'position'	=> 'inner',
				'callback'	=> 'fieldTax'
			),
			Array(
				'position'	=> 'inner',
				'callback'	=> 'fieldMeta'
			),
		);
		$arrFilters			= apply_filters( 'jvfrm_home_' . self::SLUG . '_map_filter_orders', $orderFields );

		if( !empty( $arrFilters ) ) : foreach( $arrFilters as $index => $filter ) {
			if( is_array( $filter[ 'callback' ] ) ) {
				add_action( 'jvfrm_home_map_template_filter_' . $filter[ 'position' ], $filter[ 'callback' ], intVal( $index + 10 ) );
			} elseif( method_exists( $this, $filter[ 'callback' ] ) ) {
				add_action( 'jvfrm_home_map_template_filter_' . $filter[ 'position' ], Array( $this, $filter[ 'callback' ] ), intVal( $index + 10 ) );
			}
		} endif;
	}

	public function fieldAddress(){
		$this->load_template( 'part-map-filter-address', '.php', Array( 'post' => $GLOBALS[ 'post' ] ), false );
	}

	public function fieldKeyword(){
		$this->load_template( 'part-map-filter-keyword', '.php', Array( 'post' => $GLOBALS[ 'post' ] ), false );
	}

	public function fieldOrder() {
		$this->load_template( 'part-map-filter-order', '.php', Array( 'post' => $GLOBALS[ 'post' ] ), false );
	}

	public function fieldPrice(){
		$this->load_template( 'part-map-filter-price', '.php', Array( 'post' => $GLOBALS[ 'post' ] ), false  );
	}

	public function fieldCity(){
		$this->load_template( 'part-map-filter-city', '.php', Array( 'post' => $GLOBALS[ 'post' ] ), false  );
	}

	public function fieldType(){
		$this->load_template( 'part-map-filter-type', '.php', Array( 'post' => $GLOBALS[ 'post' ] ), false  );
	}

	public function fieldStatus(){
		$this->load_template( 'part-map-filter-status', '.php', Array( 'post' => $GLOBALS[ 'post' ] ), false  );
	}

	public function fieldMeta(){
		$this->load_template( 'part-map-filter-meta', '.php', Array( 'post' => $GLOBALS[ 'post' ] ), false  );
	}

	public function fieldTax(){
		$this->load_template( 'part-map-filter-taxonomy', '.php', Array( 'post' => $GLOBALS[ 'post' ] ), false  );
	}


	public function custom_archive_page( $template, $query=false, $obj=false ) {
		$taxonomy			= empty( $query->queried_object->taxonomy ) ?
			Array() : get_taxonomy( $query->queried_object->taxonomy )->object_type;

		if(
			!empty( $query->queried_object->taxonomy ) &&
			!in_Array( $query->queried_object->taxonomy,
				Array( 'listing_keyword' )
			)
		) if( !empty( $query ) && !empty( $obj ) )
			if( $query->is_archive && in_array( self::SLUG, $taxonomy ) ) {
				$this->is_archive	= true;
				$template				= $obj->get_map_template();
			}

		return $template;
	}

	public function custom_map_class( $classes ) {
		if( $this->is_archive ) {
			// hide-switcher
			$classes	= wp_parse_args(
				Array( 'hide-listing-filter' )
				, $classes
			);
		}
		return $classes;
	}

	public function custom_list_content_column( $class_name ) {
		if( $this->is_archive )
			$class_name	= 'col-sm-12';
		return $class_name;
	}

	public function archive_map_list_module( $module_name, $post_id ) {
		if( ! $post_id )
			$module_name		= 'module12';
		return $module_name;
	}

	public function archive_map_list_module_loop( $template, $class_name, $post_id ) {
		if( ! $post_id )
			$template				= "<div class=\"col-md-4\">%s</div>";
		return$template;
	}

	public function archive_map_module( $module_name, $post_id ) {
		if( ! $post_id )
			$module_name		= 'module12';
		return $module_name;
	}

	public function archive_map_module_loop( $template, $class_name, $post_id ) {
		if( ! $post_id )
			$template				= "<div class=\"col-md-6\">%s</div>";
		return$template;
	}

	public function map_list_container_before( $post ) {
		if( $this->is_archive ){
			$this->load_template( 'part-archive-container-header' );
		}
	}

	public function _map_list_container_after( $post ) {
		if( $this->is_archive ){
			$this->load_template( 'part-archive-container-footer' );
		}
	}

	/**
	public function custom_register_slug( $args ) {
		return wp_parse_args(
			Array('JVFRM_HOME_ADDITEM_SLUG'			=> 'add-'.self::SLUG )
			, $args
		);
	}
	*/

	public function is_dashboard_page( $slug=false ) {

		$is_dashboard = false;
		if( get_query_var( 'pn' ) == 'member' ){
			$is_dashboard = true;
			if( $slug && get_query_var( 'sub_page' ) != $slug )
				$is_dashboard = false;
		}

		return $is_dashboard;
	}

	public function price_table_redirect(){
		if( $this->is_dashboard_page( 'add-' . self::SLUG ) )
			add_filter( 'lava_' . self::SLUG . '_payment_price_table_redirect', Array( $this, 'is_dashboard_writePage' ) );
	}

	public function is_dashboard_writePage( $oldValue ){
		/**
		 * true : is not write form
		 * false : is directory manager write form
		 */
		return false;
	}

	public function custom_mypage_sidebar( $args ) {

		return wp_parse_args(
			Array(

				Array(
					'li_class'		=> 'side-menu add-property'
					, 'url'			=> jvfrm_home_getCurrentUserPage( 'add-' . self::SLUG )
					, 'icon'		=> 'fa fa-home'
					, 'label'		=> esc_html__("New Property", 'javohome')
				)
				, Array(
					'li_class'		=> 'side-menu my-properties'
					, 'url'			=> jvfrm_home_getCurrentUserPage( 'my-' . self::SLUG )
					, 'icon'		=> 'fa fa-folder'
					, 'label'		=> esc_html__("My Properties", 'javohome')
				)
			), $args
		);
	}

	public function append_properties( $strFilename, $query ) {
		global $jvfrm_home_Directory;

		if( $query === 'my-' . self::SLUG )
			$strFilename	= $jvfrm_home_Directory->template_path . '/mypage-my-item-' . jvfrm_home_dashboard()->page_style . '.php';

		elseif( $query === 'add-' . self::SLUG )
			$strFilename	= $jvfrm_home_Directory->template_path . '/mypage-add-item-' . jvfrm_home_dashboard()->page_style . '.php';

		return $strFilename;
	}

	public function custom_map_listing_filter( ) {
		global $jvfrm_home_Directory, $post;

		$strFileName		= $jvfrm_home_Directory->template_path . '/html-map-mainFilter.php';

		if( !file_exists( $strFileName ) ){
			echo $strFileName;
			return;
		}

		require_once $strFileName;
	}

	public function single_template_remove_margin() {
		echo "
			<style type='text/css'>
				html{
					overflow:hidden !important;
				}
				body{
					margin-top:32px !important;
				}
			</style>";
		remove_action('wp_head', '_admin_bar_bump_cb');
	}

	public function custom_type_b_mypage_nav( $nav_args ) {
		global $jvfrm_home_curUser;
		if( function_exists( 'lv_realestate_favorite' ) && $jvfrm_home_curUser->ID == get_current_user_id() )
			$nav_args[ 'jv-favorite' ]	= Array(
				'label'		=> esc_html__( "Favorites", 'javohome' ),
			);

		if( class_exists( 'Lava_Directory_Payment' ) && $jvfrm_home_curUser->ID == get_current_user_id())
			$nav_args[ 'jv-payment' ]	= Array(
				'label'		=> esc_html__( "Payment", 'javohome' ),
			);

		return $nav_args;
	}

	public function dashboard_mylists( $user ){

		if( is_object( $user ) && class_exists( 'jvfrm_home_block12' ) )  {
			$objShortcode	= new jvfrm_home_block12();
			echo $objShortcode->output(
				Array(
					'title'					=> strtoupper( sprintf( esc_html__( "%s's Items", 'javohome' ), $user->display_name ) ),
					'count'				=> 6,
					'author'				=> $user->ID,
					'columns'			=> 3,
					'post_type'		=> jvfrm_home_core()->slug,
					'filter_by'			=> 'property_type',
					'pagination'		=> 'number',
					'is_dashboard'	=> 'true',
					'module_contents_length' => 8,
				)
			);

		}
	}

	public function dashboard_mylists_edit_button( $module_name, $obj ){

		if( $obj->getArgs( 'is_dashboard' ) != 'true' )
			return;

		if( $obj->authorID != get_current_user_id() )
			return;

		$strEditLink = esc_url(
			add_query_arg(
				Array( 'edit' => $obj->post_id ),
				jvfrm_home_getCurrentUserPage( 'add-' . jvfrm_home_core()->slug )
			)
		);
		printf( '<a href="%1$s" target="_self">%2$s</a>&nbsp;', $strEditLink, esc_html__( "Edit", 'javohome' ) );
		printf( '<span>/</span> <a href="javascript:" data-lava-realestate-manager-trash="%1$d">%2$s</a>&nbsp;', $obj->post_id ,esc_html__( "Delete", 'javohome' ) );
	}

	public function dashboard_mylists_payment_button(  $module_name, $obj ){

		if( ! function_exists( 'lv_realestate_payment' ) )
			return;

		if( $obj->getArgs( 'is_dashboard' ) != 'true' )
			return;

		if( $obj->authorID != get_current_user_id() )
			return;

		$strEditLink = esc_url(
			add_query_arg(
				Array( 'pay' => $obj->post_id ),
				jvfrm_home_getCurrentUserPage( 'add-' . jvfrm_home_core()->slug )
			)
		);
		printf( '<span>/</span> <a href="%1$s" target="_self">%2$s</a>&nbsp;', $strEditLink, esc_html__( "Payment", 'javohome' ) );
	}

	public function core_recentPostsWidget( $excerpt='', $length=0, $post=false, $args=null ){

		$isMoreMeta = is_array( $args ) &&
			!empty( $args[ 'describe_type' ] ) &&
			$args[ 'describe_type' ] == 'rating_category';

		if(
			$isMoreMeta &&
			class_exists( 'Jvfrm_Home_Module' ) &&
			is_object( $post ) &&
			$post->post_type == jvfrm_home_core()->slug
		) {

			$objModule = new Jvfrm_Home_Module( $post );
			$excerpt = join( false, Array(
				'<div class="javo-shortcode">',
					'<div class="module">',
						sprintf( jvfrm_home_core()->shortcode->contents_with_raty_star( '', $objModule ) ),
						'<div class="meta-moreinfo">',
							sprintf(
								'<span class="meta-category">%s</span>',
								$objModule->c( 'property_type', esc_html__( "No Category", 'javohome'	 ) )
							),
							' / ',
							sprintf(
								'<span class="meta-location">%s</span>',
								$objModule->c( 'property_status', esc_html__( "No Location", 'javohome'	 ) )
							),
						'</div>',
					'</div>',
				'</div>',
			) );
		}
		return $excerpt;
	}

	public function core_recentPostsWidgetOption( $options=Array() ){
		if( class_exists( 'Lava_Directory_Review' ) )
			$options[ 'rating_category' ] = esc_html__( "Rating & Category ( only 'listing' )", 'javohome' );

		return $options;
	}
}