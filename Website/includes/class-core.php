<?php
if( !defined( 'ABSPATH' ) )
	die;

class jvfrm_home_Directory
{
	/**
	 *	Required Initialize Settings
	 */
	const SLUG			= 'property';
	const SUPPORT		= 'lv_support';
	const NAME			= 'property';
	const CORE			= 'Javo_Home_Core';
	const FEATURED_CAT	= '_type';
	const MAINPLUG		= 'Lava_RealEstate_Manager';

	/**
	 *	Additional Initialize Settings
	 */
	const REVIEW				= 'Lava_Realestate_Review';
	private static $instance;

	public $slug;
	protected $template_path	= false;


	public static function get_instance( $file ) {
		if( !self::$instance )
			self::$instance = new self( $file );

		return self::$instance;
	}

	public function __construct( $file ) {
		$this->initialize( $file );
		$this->load_files();
		$this->register_hoook();
		$this->update_hooks();

		$this->shortcode = new jvfrm_home_Directory_Shortcode;
	}

	public function initialize( $file ) {
		$this->file				= $file;
		$this->folder			= ( dirname( $this->file ) );
		$this->dir				= trailingslashit( JVFRM_HOME_THEME_DIR . '/includes' );
		$this->assets_dir		= trailingslashit( $this->dir . 'assets' );
		$this->path				= dirname( $this->file );
		$this->template_path	= trailingslashit( $this->path ) . 'templates';

		$this->slug				= self::SLUG;
	}

	public function load_files() {
		require_once "class-template.php";
		require_once "class-shortcode.php";
		require_once "function-property.php";
		require_once "function-lv_support.php";
		require_once "vc-core.php";
		require_once "the-grid-core.php";
	}

	public function getAjaxPrefixName() {
		return 'jv_' . $this->slug . '_db_update_';
	}

	public function register_hoook()
	{
		add_action( 'init', array( $this, 'load_templateClass' ) );
		// Require Plugins
		add_action( 'jvfrm_home_tgmpa_plugins', Array( $this, 'tgmpa_plugins' ) );
		add_action( 'jvfrm_home_helper_require_plugins', Array( $this, 'helper_require_plugins' ) );
		add_action( 'jvfrm_home_helper_require_plugins_pass', Array( $this, 'helper_require_plugins_bool' ) );

		add_action( 'wp_enqueue_scripts', Array( $this, 'register_resources' ) );
		add_action( 'init', Array( $this, 'custom_object' ), 100 );
		add_filter( 'lava_' . self::SLUG . '_json_addition', Array( $this, 'json_append' ), 10, 3 );

		add_filter( 'jvfrm_home_theme_setting_pages', Array( $this, 'main_slug_page' ) );
		add_filter( 'jvfrm_home_theme_setting_pages', Array( $this, 'map_page' ) );

		// Enqueue Css
		add_filter( 'jvfrm_home_enqueue_css_array', Array( $this, 'enqueue_php_css_array' ) );

		// Enqueue Less
		add_filter( 'jvfrm_home_enqueue_less_array', Array( $this, 'enqueue_php_less_array' ) );

		// Dashbaord
		add_filter( 'lava_' . self::SLUG . '_new_item_redirect' , Array( $this, 'new_item_redirect' ), 15, 2 );
		add_filter( 'jvfrm_home_dashboard_slugs' , Array( $this, 'custom_register_slug' ) );

		// Database Update for Old Javo-Home
		add_filter( 'admin_enqueue_scripts', Array( $this, 'admin_enqueue' ), 10, 2 );
		add_filter( 'jvfrm_home_admin_helper_register_menu', Array( $this, 'admin_helper_db_update_page' ), 10, 2 );
	}

	public function load_templateClass() {
		$this->template = new jvfrm_home_Directory_Template;
	}

	public function getSlug() {
		return self::SLUG;
	}

	public function getCoreName( $suffix=false ){
		$strSuffix = $suffix ? '_' . $suffix : false;
		return self::CORE . $strSuffix;
	}

	public function getHandleName( $strName='' ){ return sanitize_title( 'jv-' . $strName ); }

	public function tgmpa_plugins( $plugins=Array() ) {
		return wp_parse_args(
			Array(
				// Contact Form
				array(
					'name'						=> 'Contact Form 7',
					'slug'						=> 'contact-form-7',
					'required'					=> false,
					'image_url'					=> JVFRM_HOME_IMG_DIR . '/icon/jv-default-setting-plugin-contact-form-7.png',
				),

				// Lava Real Estate Manager
				Array(
					'name'						=> 'Lava Real Estate Manager',
					'slug'						=> 'lava-real-estate-manager',
					'required'					=> true,
					'image_url'					=> JVFRM_HOME_IMG_DIR . '/icon/jv-default-setting-plugin-lava-real-estate-manager.png',
				),

				// Javo Home Core
				Array(
					'name' => 'Javo Home Core',
					'slug' => 'javo-home-core',
					'version' => '2.0.3',
					'required' => true,
					'force_activation' => false,
					'force_deactivation' => false,
					'external_url' => '',
					'source' => get_template_directory() . '/library/plugins/javo-home-core.zip',
					'image_url' => JVFRM_HOME_IMG_DIR . '/icon/jv-default-setting-plugin-javo-map-framework-core-logo.png',
				),

				// Slider Revolution
				Array(
					'name'						=> 'Revolution Slider',
					'slug'						=> 'revslider',
					'version'					=> '5.4.6.2',
					'required'					=> true,
					'force_activation'			=> false,
					'force_deactivation'		=> false,
					'external_url'				=> '',
					'source'					=> get_template_directory() . '/library/plugins/revslider.zip',
					'image_url'					=> JVFRM_HOME_IMG_DIR . '/icon/jv-default-setting-plugin-revslider.png',
				),

				// NinjaForms
				Array(
					'name'						=> 'Ninja Forms',
					'slug'						=> 'ninja-forms',
					'required'					=> false,
					'image_url'					=> JVFRM_HOME_IMG_DIR . '/icon/jv-default-setting-plugin-ninja-forms.png',
				),

				// Visual Composer
				array(
					'name'						=> 'WPBakery Visual Composer', // The plugin name
					'slug'						=> 'js_composer', // The plugin slug (typically the folder name)
					'source'					=> get_template_directory() . '/library/plugins/js_composer.zip', // The plugin source
					'required'					=> true, // If false, the plugin is only 'recommended' instead of required
					'version'					=> '5.4.2', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
					'force_activation'			=> false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
					'force_deactivation'		=> false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
					'external_url'				=> '', // If set, overrides default API URL and points to an external URL
					'image_url'					=> JVFRM_HOME_IMG_DIR . '/icon/jv-default-setting-plugin-js_composer.png',
				),

				// Ultimate Addons
				array(
					'name'						=> 'Ultimate Addons for Visual Composer', // The plugin name
					'slug'						=> 'Ultimate_VC_Addons', // The plugin slug (typically the folder name)
					'source'					=> get_template_directory() . '/library/plugins/Ultimate_VC_Addons.zip', // The plugin source
					'required'					=> true, // If false, the plugin is only 'recommended' instead of required
					'version'					=> '3.16.19', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
					'force_activation'			=> false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
					'force_deactivation'		=> false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
					'external_url'				=> '', // If set, overrides default API URL and points to an external URL
					'image_url'					=> JVFRM_HOME_IMG_DIR . '/icon/jv-default-setting-plugin-Ultimate_VC_Addons.png',
				),
				// The Grid
				array(
					'name'						=> 'The Grid', // The plugin name
					'slug'						=> 'the-grid', // The plugin slug (typically the folder name)
					'source'					=> get_template_directory() . '/library/plugins/the-grid.zip', // The plugin source
					'required'					=> true, // If false, the plugin is only 'recommended' instead of required
					'version'					=> '2.5.0', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
					'force_activation'			=> false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
					'force_deactivation'		=> false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
					'external_url'				=> '', // If set, overrides default API URL and points to an external URL
					'image_url'					=> JVFRM_HOME_IMG_DIR . '/icon/jv-default-setting-plugin-javo-the-grid-core-logo.png',
				),
			), $plugins
		);
	}

	public function register_resources() {
		$jvfrm_home_load_styles =
		Array(
			'single.css'									=> '0.1.0',
		);

		$jvfrm_home_load_scripts =
		Array(
			'single.js' => '1.0.0',
			'map-template.js' => '1.0.0',
			'jquery.javo_search_shortcode.js'	=> '0.1.0',
		);


		if( !empty( $jvfrm_home_load_styles ) ) : foreach( $jvfrm_home_load_styles as $filename => $version ) {
			wp_register_style(
				$this->getHandleName( $filename ),
				$this->assets_dir . "css/{$filename}",
				Array(),
				$version
			);
		} endif;

		if( !empty( $jvfrm_home_load_scripts ) ) : foreach( $jvfrm_home_load_scripts as $filename => $version ) {
			wp_register_script(
				$this->getHandleName( $filename ),
				$this->assets_dir . "js/{$filename}",
				Array( 'jquery' ),
				$version,
				true
			);
		} endif;
	}

	public function json_append( $args, $post_id, $objTerm ) {
		global $lava_realestate_manager_func;
		$arrResult			= Array();
		$arrAllMeta		= Array_Keys( apply_filters( 'lava_' . self::SLUG . '_more_meta', Array() ) );
		$arrExcludes		= Array( '_phone1', '_phone2', '_address', '_email', '_website' );

		$arrAllMeta		= array_diff( $arrAllMeta, $arrExcludes );

		if( !empty( $arrAllMeta ) )  foreach( $arrAllMeta as $metaKey )
			$arrResult[ $metaKey ] = get_post_meta( $post_id, $metaKey, true );

		$arrResult[ 'f' ] = get_post_meta( $post_id, '_featured_item', true );

		return wp_parse_args( $arrResult, $args );
	}

	public function main_slug_page( $pages ){
		return wp_parse_args(
			Array(
				'property'			=> Array(
					esc_html__( "Property", 'javohome' ), false
					, 'priority'		=> 35
					, 'external'		=> $this->template_path . '/admin-theme-settings-item.php'
				)
			)
			, $pages
		);
	}

	public function map_page( $pages ) {
		return wp_parse_args(
			Array(
				'map'			=> Array(
					esc_html__( "Map", 'javohome' ), false
					, 'priority'		=> 32
					, 'external'		=> $this->template_path . '/admin-theme-settings-map.php'
				)
			)
			, $pages
		);
	}

	public function enqueue_php_css_array( $csses=Array() ){
		return wp_parse_args(
			Array(
				'includes-assets-extra' => Array(
					'dir' => $this->assets_dir . 'css',
					'file' => 'extra.css',
				)
			),
			$csses
		);
	}

	public function enqueue_php_less_array( $lesses=Array() ) {
		return wp_parse_args(
			Array(
				'includes-assets-extra' => Array(
					'dir' => $this->assets_dir . 'css',
					'file' => 'extra.less',
				)
			),
			$lesses
		);
	}

	public function helper_require_plugins( $plugins=Array() ) {
		return wp_parse_args(
			Array(
				'Javo_Home_Core'				=> esc_html__( "Javo Home Core", 'javohome' ),
				'Lava_RealEstate_Manager'	=> esc_html__( "Lava Real Estate Manager", 'javohome' )
			), $plugins
		);
	}

	public function helper_require_plugins_bool( $boolPass=false ) {
		return $boolPass && class_exists( 'Javo_Home_Core' ) && function_exists( 'lava_realestate' );
	}

	public function new_item_redirect( $URL, $post_id ){
		
		$is_update = isset( $_POST[ 'post_id' ] ) && intVal( $_POST[ 'post_id' ] ) > 0;

		if( $is_update )
			return $URL;

		if( function_exists( 'lv_realestate_payment' ) ) {
			$strSLUG = 'add-' . self::SLUG;
			if( lv_realestate_payment()->core->is_using )
				$URL = esc_url( add_query_arg( Array( 'pay' => $post_id ), jvfrm_home_getCurrentUserPage( $strSLUG ) ) );
		}
		return $URL;
	}

	public function custom_register_slug( $args ) {
		return wp_parse_args(
			Array('JVFRM_HOME_ADDITEM_SLUG'			=> 'add-'.self::SLUG )
			, $args
		);
	}

	public function custom_object() {
		// Exclude Search
		$objPostType = get_post_type_object( self::SLUG );

		if( is_object( $objPostType ) )
			$objPostType->exclude_from_search = true;
	}

	public function admin_enqueue() {
		wp_register_script(
			$this->getHandleName( 'admin-db-update.js' ),
			$this->assets_dir . 'js/admin-db-update.js',
			Array( 'jquery' ),
			'1.0.0',
			true
		);
	}
	public function admin_helper_db_update_page( $helper, $strMenuName ){

		$prefix = 'add_';

		call_user_func_array(
			$prefix . 'submenu_page',
			Array(
				$strMenuName
				, sprintf( esc_html__( "%s Status", 'javo' ), $helper->name )
				, esc_html__( "Data Update", 'javo' )
				, 'manage_options'
				, $strMenuName . '_db_update'
				, Array( $this, 'helper_db_update' )
			)
		);
	}

	public function helper_db_update() {
		do_action( 'jvfrm_home_admin_helper_page_header' );
		$this->template->load_template( 'admin-db-update' );
		do_action( 'jvfrm_home_admin_helper_page_footer' );
	}

	public function update_hooks(){

		// Get Wordpress Database Class
		$this->GetWPDB();

		// Prefix Action Hooks
		$this->ajax_prefix = sprintf( 'wp_ajax_%s', $this->getAjaxPrefixName() );

		add_action( $this->ajax_prefix . 'part_page_shortcode', Array( $this, 'part_page_shortcode_callback' ) );
		add_action( $this->ajax_prefix . 'part_page_setting', Array( $this, 'part_page_setting_callback' ) );
		add_action( $this->ajax_prefix . 'part_theme_setting', Array( $this, 'part_theme_setting_callback' ) );

	}

	public function GetWPDB(){ $this->wpdb = $GLOBALS[ 'wpdb' ]; }

	public function part_page_shortcode_callback() {

		$strResult = $this->wpdb->query(
			$this->wpdb->prepare( "
				UPDATE {$this->wpdb->posts}
				SET post_content=replace( post_content, %s, %s )
				WHERE post_type=%s",
				'[jv_', '[jvfrm_home_', 'page'
			)
		);

		$this->output(
			Array(
				'state'	=> 'OK',
				'result'	=> 1,
			)
		);

	}

	public function part_page_setting_callback() {

		$strResult = $this->wpdb->query(
			$this->wpdb->prepare( "
				UPDATE {$this->wpdb->postmeta}
				SET meta_key=replace( meta_key, %s, %s )",
				'javo_', 'jvfrm_home_'
			)
		);

		$strResult = $this->wpdb->query(
			$this->wpdb->prepare( "
				UPDATE {$this->wpdb->postmeta}
				SET meta_key=replace( meta_key, %s, %s )",
				'jv_', 'jvfrm_home_'
			)
		);

		$this->output(
			Array(
				'state'	=> 'OK',
				'result'	=> 1,
			)
		);
	}

	public function part_theme_setting_callback() {

		$strResult = $this->wpdb->query(
			$this->wpdb->prepare( "
				UPDATE {$this->wpdb->options} SET option_name=%s WHERE option_name=%s",
				'jvfrm_home_themes_settings', 'javo_themes_settings'
			)
		);

		$this->output(
			Array(
				'state'	=> 'OK',
				'result'	=> 1,
			)
		);
	}

	public function output( $args=Array() ){ die( json_encode( $args ) ); }

}

if( !function_exists( 'jvfrm_home_core' ) ) {
	function jvfrm_home_core() {
		$objInstance				= jvfrm_home_Directory::get_instance( __FILE__ );
		$GLOBALS[ 'jvfrm_home_Directory' ]	= $objInstance;
		return $objInstance;
	}
	jvfrm_home_core();
}