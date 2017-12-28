<?php
class jvfrm_home_theme_settings
{
	var $pages;

	static $instance;
	static $item_refresh_message;

	public function __construct()
	{
		self::$instance = &$this;

		// Item Refresh
		$jvfrm_home_query = new jvfrm_home_array( $_POST );

		$jvfrm_home_query = new jvfrm_home_array( $_POST );
		if( 'unserial' == $jvfrm_home_query->get('jvfrm_home_items_unserial_', '' ) )
		{
			add_action( 'admin_init', Array( __CLASS__, 'item_unserial_callback' ) );
		}

		/* Option Set */
		add_action("admin_init", Array( __class__, "jvfrm_home_theme_settings_reg"));

		/* Add Admin Page and Register */
		add_action("admin_menu", Array($this, "jvfrm_home_theme_settings_page_reg"));

		/* Need script and style load */
		add_action( 'admin_enqueue_scripts', Array($this, 'enqueue_style' ));
		add_action( 'wp_before_admin_bar_render', array( $this, 'add_root_menu' ) );

		add_action( 'wp_ajax_jvfrm_home_theme_settings_save', Array( $this, 'theme_settings_update' ) );
	}

	function add_root_menu()
	{
		global $wp_admin_bar;

		if( !is_super_admin() || !is_admin_bar_showing() )
			return;

		$wp_admin_bar->add_node(
			Array(
				'id'				=> 'jvfrm_home_adminbar_theme_setting'
				, 'meta'		=> array()
				, 'title'		=> esc_html__( "Theme settings", 'javohome' )
				, 'href'		=> admin_url( 'admin.php?page=javo-theme-settings' )
			)
		);
	}

	function order_pages( $array_A, $array_B ) {
		return $array_A[ 'priority' ] - $array_B[ 'priority' ];
	}

	public static function jvfrm_home_theme_settings_reg()
	{
		/* Setting option Initialize */
		register_setting( 'jvfrm_home_settings', 'jvfrm_home_themes_settings' );
		add_option( 'jvfrm_home_themes_settings_css' );
	}
	public function enqueue_style()
	{
		wp_enqueue_style( 'bootstrap-admin-style' );
		jvfrm_home_get_asset_style('jquery.nouislider.min.css', 'jquery.nouislider');
		jvfrm_home_get_asset_style( 'javo_admin_theme_settings.css', 'javo-themes-settings-css');
	}
	public function enqueue_script()
	{
		/* Get jQuery noUISlider Plug-in Style and Script */
		wp_enqueue_script( 'bootstrap-admin-script' );
		wp_enqueue_script( 'jquery-noUISlide', get_template_directory_uri() . '/assets/js/jquery.nouislider.min.js', Array( 'jquery' ) );
	}

	public function getPages()
	{
		return apply_filters(
			'jvfrm_home_theme_setting_pages'
			, Array(
				'general'			=> Array( esc_html__( "General", 'javohome'), false , 'priority' => 0 )
				, 'logo'				=> Array( esc_html__( "Logo", 'javohome'), false , 'priority' => 10 )
				, "font"				=> Array( esc_html__( "Fonts", 'javohome'), false, 'priority' => 20 )
				, "header"			=> Array( esc_html__( "Header", 'javohome')	, false, 'priority' => 30 )
				, "portfolio"	=> Array( esc_html__( "Portfolio", 'javohome'), false, 'priority' => 39 )
				, "footer"			=> Array( esc_html__( "Footer", 'javohome'), false, 'priority' => 40 )
				, 'api'					=> Array( esc_html__( "API", 'javohome'), false, 'priority' => 50 )
				, "contact"		=> Array( esc_html__( "Contact Info", 'javohome'), false, 'priority' => 60 )
				, "custom"		=> Array( esc_html__( "Custom CSS / JS", 'javohome'), false, 'priority' => 70 )
				, "import"			=> Array( esc_html__( "Import / Export", 'javohome'), false, 'priority' => 80 )
			)
		);
	}

	public function jvfrm_home_theme_settings_page_reg() {
		// Settings page tab menus items defined
		$pages = $this->getPages();
		uasort( $pages, Array( $this, 'order_pages' ) );

		$this->pages = $pages;
		do_action( 'jvfrm_home_theme_settings_menu_init' );
	}

	/* Get to find word "head" from filename */
	public function _header() {
		// Variable Initialize
		$output = Array();

		// Get Directory string
		$dic = opendir( JVFRM_HOME_SYS_DIR."/header" );

		// Repeat find file form directory
		while($fn = readdir($dic)):
			$fn_slice = @explode("-", $fn);
			if($fn_slice[0] == "head"){
				$output[$fn] = JVFRM_HOME_SYS_DIR."/header/".$fn;
			};
		endwhile;

		// Return variable
		return $output;
	}
	// Display and create setting form
	public function settings_page_initialize()
	{
		/* Need script and style load */
		wp_enqueue_media();
		add_action( 'admin_footer', Array( $this,  'enqueue_script' ) );

		$current = explode("-", $_GET['page']);
		$pages = $this->pages;

		// Variable initialize
		$content = "";
		$add_tabs = "";

		// Repeat create tab menus items
		foreach($pages as $page=>$value){
			$active = ($page == $current)? " nav-tab-active" : "";
			$add_tabs .= sprintf("<li class='javo-opts-group-tab-link-li'>
				<a href='javascript:void(0);' class='javo-opts-group-tab-link-a' tar='%s'>
				%s %s</a></li>"
				, $page
				, $value[1]
				, strtoupper( $value[0] )
			);
		}

		$objThsFile = pathinfo( __FILE__ );
		do_action( 'jvfrm_home_admin_helper_page_header' );
		do_action( 'jvfrm_home_admin_helper_' . $objThsFile[ 'filename' ] . ' _header' ); ?>
		<!-- Theme settings options form -->

		<form id="jvfrm_home_ts_form" name="jvfrm_home_theme_settings_form" onsubmit="return false">
			<div class="jvfrm_home_ts_header_div">
				<div class="jvfrm_home_ts_header logo">
					<img src="<?php echo JVFRM_HOME_IMG_DIR;?>/jv-logo1.png">
				</div>
				<?php
					/* Get Javo Theme Information */
					$theme_data = wp_get_theme();
					echo "<div class='javo-version-info'><span>By&nbsp;&nbsp;".$theme_data['Author']."</Author></span>";
					echo "<span>&nbsp;&nbsp;V&nbsp;".$theme_data['Version']."</Author></span></div>";
				?>
				<div class="jvfrm_home_ts_header save_area">
					<a href="<?php echo esc_url( "www.javothemes.com/home/documentation//"); ?>" target="_blank" class="button button-default">
						<?php esc_html_e('Documentation', 'javohome');?>
					</a>
					<input value="Save Settings" class="button button-primary jvfrm_home_btn_ts_save" type="button">
				</div>
			</div>

			<div id="javo-opts-sidebar">
				<ul id="javo-opts-group-menu">
					<?php echo $add_tabs;?>
				</ul>
			</div>
			<div id="javo-opts-main">
			<?php
			// Tabs contents includes
			global
				$jvfrm_home_tso
				, $jvfrm_home_ts_map
				, $jvfrm_home_ts_archive
				, $jvfrm_home_ts_dashboard;
			$jvfrm_home_ts_map			= new jvfrm_home_array( (Array)$jvfrm_home_tso->get('map', Array() ) );
			$jvfrm_home_ts_archive		= new jvfrm_home_array( (Array)$jvfrm_home_tso->get('archive', Array() ) );
			$jvfrm_home_ts_dashboard	= new jvfrm_home_array( (Array)$jvfrm_home_tso->get('dashboard', Array() ) );

			ob_start();
			if( !empty( $pages ) ) : foreach( $pages as $index => $page )
			{
				$getTemplateName		= JVFRM_HOME_ADM_DIR."/assets/theme-settings"."-".$index.".php";

				if( isset( $page[ 'external' ] ) )
					$getTemplateName	= $page[ 'external' ];

				if( file_exists( $getTemplateName ) )
					require_once $getTemplateName;
			} endif;
			$content = ob_get_clean();
			echo $content;?>
			</div>
			<div class="javo-opts-footer">
				<input name="jvfrm_home_themes_update" value="<?php echo md5(date("y-m-d"));?>" type="hidden">
			</div>

			<div class="jvfrm-home-ts-message">
				<div class="message-content">

					<div class="jvfrm-home-message status-process">
						<span class="spinner"></span>
						<span><?php esc_html_e( "Processing...", 'javohome' ); ?></span>
					</div>

					<div class="jvfrm-home-message status-ok">
						<span class="icon"></span>
						<span><?php esc_html_e( "Saved", 'javohome' ); ?></span>
					</div>

					<div class="jvfrm-home-message status-fail">
						<span class="icon"></span>
						<span><?php esc_html_e( "Failed", 'javohome' ); ?></span>
					</div>

				</div>
			</div>
			<input type="hidden" name="action" value="jvfrm_home_theme_settings_save">
			<input type="hidden" name="_nonce" value="<?php echo wp_create_nonce( 'jvfrm_home_theme_settings_save' ); ?>">
		</form>

		<!-- Reset & Import Form -->
		<form method="post" action="options.php" id="javo-ts-admin-form">
			<?php settings_fields("jvfrm_home_settings");?>
			<input type="hidden" name="jvfrm_home_themes_settings" id="javo-ts-admin-field">
		</form>

		<?php
		echo join( "\n", Array(
			"\n<script type=\"text/javascript\">",
			"\tvar jvfrm_home_ts_variable=" . json_encode(
				Array(
					'ajaxurl'		=> esc_url( admin_url( 'admin-ajax.php' ) ),
					'strReset'		=> esc_html__( "Warning : All option results remove and Style initialize.\nContinue?", 'javohome' ),
					'strImport'		=> esc_html__( "Warning : Change option. can`t option restore. \nContinue?", 'javohome' ),
				)
			) . ';',
			'jQuery(function($){ $(document).trigger( "javo:theme_settings_after" ); });',
			"</script>\n",
		) ); ?>

		<!-- Item Refresh Form -->
		<form id="jvfrm_home_tso_map_item_refresh" method="post">
			<input type="hidden" name="lang">
			<input type="hidden" name="jvfrm_home_items_refresh_" value="refresh">
		</form>

		<!-- Item Unserialize Form -->
		<form id="jvfrm_home_tso_map_item_unserial" method="post">
			<input type="hidden" name="lang">
			<input type="hidden" name="jvfrm_home_items_unserial_" value="unserial">
		</form>

		<?php
		do_action( 'jvfrm_home_admin_helper_' . $objThsFile[ 'filename' ] . ' _footer' );
		do_action( 'jvfrm_home_admin_helper_page_footer' );
	}

	public static function item_unserial_callback()
	{
		global
			$jvfrm_home_tso
			, $wpdb;

		$jvfrm_home_query	= new jvfrm_home_array( $_POST );
		$lang		= $jvfrm_home_query->get('lang', '');
		/* wpml */
		{
			$wpml_join	= "";
			$wpml_where	= "";
			if( defined('ICL_LANGUAGE_CODE') && $lang != '' )
			{
				$wpml_join	= "INNER JOIN {$wpdb->prefix}icl_translations as w ON p.ID = w.element_id";
				$wpml_where	= $wpdb->prepare( "AND w.language_code=%s" , $lang);
			}
		}

		$jvfrm_home_all_posts = Array();
		$jvfrm_home_all_items = $wpdb->get_results(
			$wpdb->prepare("SELECT ID, post_title FROM $wpdb->posts as p {$wpml_join} WHERE p.post_type=%s AND p.post_status=%s {$wpml_where} ORDER BY p.post_date ASC"
				, 'property', 'publish'
			)
			, OBJECT
		);

		foreach( $jvfrm_home_all_items as $item )
		{

			// directory_meta
			if( false !== (boolean)( $_meta = get_post_meta( $item->ID, 'directory_meta', true ) ) )
			{
				$_meta = maybe_unserialize( $_meta );
				if( !empty( $_meta ) )
				{
					foreach( $_meta as $key => $value )
					{
						update_post_meta( $item->ID, "property_{$key}", $value );

					}
				}
			}

			// Lat Lng
			if( false !== (boolean)( $_meta = get_post_meta( $item->ID, 'latlng', true ) ) )
			{
				$_meta = maybe_unserialize( $_meta );
				if( !empty( $_meta ) )
				{
					foreach( $_meta as $key => $value )
					{
						update_post_meta( $item->ID, "property_{$key}", $value );

					}
				}
			}

			// Custom Field
			{
				$jvfrm_home_get_custom_field		= $jvfrm_home_tso->get('custom_field', null);
				$jvfrm_home_get_custom_variables	= get_post_meta($item->ID, 'custom_variables', true);

				if(
					!empty( $jvfrm_home_get_custom_field ) &&
					is_Array( $jvfrm_home_get_custom_field ) &&
					is_Array( $jvfrm_home_get_custom_variables )
				){
					foreach( $jvfrm_home_get_custom_field as $key => $field )
					{
						if( !empty( $jvfrm_home_get_custom_variables[$key]['value'] ) )
						{
							update_post_meta( $item->ID, $key, $jvfrm_home_get_custom_variables[$key]['value'] );
						}
					}	// End Foreach
				}	// End IF
			}	// End Custom Fields
		}
	}

	/* Coverter Serialized functions */
	public function theme_settings_update()
	{
		check_ajax_referer( 'jvfrm_home_theme_settings_save', '_nonce' );
		$arrOptions = isset( $_POST[ 'jvfrm_home_ts' ] ) ? array_map( 'stripslashes_deep', $_POST[ 'jvfrm_home_ts' ] ) : Array();
		update_option( 'jvfrm_home_themes_settings' , $arrOptions );
		update_option( 'jvfrm_home_themes_settings_css' , $this->create_css( $arrOptions ) );
		die( json_encode( Array( 'state' => 'OK', 'code' => maybe_serialize( $arrOptions ) ) ) );
	}

	public function create_css( $args=NULL )
	{
		if( is_null( $args ) )
			return;

		$args = new jvfrm_home_array($args);

		$arrCustomCSS		= Array();

		$arrCustomCSS[]		= "/* Themes settings css */"; {
			if( $css = $args->get('basic_normal_size') )
				$arrCustomCSS[]	= "html body{ font-size:{$css}px; }";

			if( $css = $args->get('basic_line_height') )
				$arrCustomCSS[]	= "html body{ line-height:{$css}px; }";

		} // Themes settings css

		$arrCustomCSS[]		= "/* Color accent */"; {
			if( $css = $args->get('accent_color') ) {
				$arrCustomCSS[]	= "
					.accent,
					.accent:hover{ background-color:{$css} !important; }";
			}
		} // Color accent

		$arrCustomCSS[]		= "/* Header tag group */"; {
			for( $jvfrm_home_integer=1; $jvfrm_home_integer<=6; $jvfrm_home_integer++ )
			{
				$jvTag = 'h' . $jvfrm_home_integer;
				$jvfrm_home_Tag='';

				if( $css = $args->get( $jvTag . '_normal_size' ) ){
					$jvfrm_home_Tag='body h'.$jvfrm_home_integer.', body h'.$jvfrm_home_integer.' a';
					$arrCustomCSS[]	= "{$jvfrm_home_Tag}{ font-size:{$css}px;}";
				}

				if( $css = $args->get( $jvTag . '_line_height' ) ){
					$jvfrm_home_Tag='body h'.$jvfrm_home_integer.', body h'.$jvfrm_home_integer.' a';
					$arrCustomCSS[]	= "{$jvfrm_home_Tag}{ line-height:{$css}px;}";
				}
			}
		} // Header tag group

		$arrCustomCSS[]		= "/* Header */"; {

			if( $css = $args->get( 'header_bg_color' ) )
				$arrCustomCSS[]	= ".navbar{ background-color:{$css};}";

			if( $css = $args->get( 'header_background_height' ) )
				$arrCustomCSS[]	= ".navbar{ height:{$css}px;}";

			if( $css = $args->get('header_font_size') )
				$arrCustomCSS[]	= ".nav>li>a{ font-size:{$css}px; }";

			if( $css = $args->get('header_line_height') )
				$arrCustomCSS[]	= ".nav>li>a{ line-height:{$css}px; }";

			if( $css = $args->get('navi_font_family') )
				$arrCustomCSS[]	= ".nav>li>a{ font-family:{$css}; }";

			if( $css = $args->get('header_line_height') )
				$arrCustomCSS[]	= ".navbar-nav>li>a{ line-height:{$css}px; }";

			if( $css = $args->get('header_layout_font_color') )
				$arrCustomCSS[]	= ".navbar-nav>li>a{ color:{$css}; }";

			if( $css = $args->get('header_font_color_current') )
				$arrCustomCSS[]	= "
					.navbar-nav>.active>a,
					.navbar-nav>.active>a:hover,
					.navbar-nav>.active>a:focus{ color:{$css}; }";

			if( $css = $args->get('header_bg_color_current') )
				$arrCustomCSS[]	= "
					.navbar-nav>.active>a,
					.navbar-nav>.active>a:hover,
					.navbar-nav>.active>a:focus{ background-color:{$css}; }";

			if( $css = $args->get('header_font_color_current') )
				$arrCustomCSS[]	= "
					.navbar-default .navbar-nav>.open>a,
					.navbar-default .navbar-nav>.open>a:hover,
					.navbar-default .navbar-nav>.open>a:focus{ color:{$css}; }";

			if( $css = $args->get('header_bg_color_current') )
				$arrCustomCSS[]	= "
					.navbar-default .navbar-nav>.open>a,
					.navbar-default .navbar-nav>.open>a:hover,
					.navbar-default .navbar-nav>.open>a:focus{ background-color:{$css}; }";

			if( $css = $args->get('header_bottom_color_current') )
				$arrCustomCSS[]	= "
					.navbar-default .navbar-nav>.open>a,
					.navbar-default .navbar-nav>.open>a:hover,
					.navbar-default .navbar-nav>.open>a:focus{ border-bottom:4px {$css} solid; }";

			if( $css = $args->get('header_submenu_bg_color') )
				$arrCustomCSS[]	= ".dropdown-menu{ background-color:{$css}; }";

			if( $css = $args->get('header_sub_font_size') )
				$arrCustomCSS[]	= ".dropdown-menu > li > a{ font-size:{$css}px; }";

			if( $css = $args->get('header_sub_font_line_height') )
				$arrCustomCSS[]	= ".dropdown-menu > li > a{ line-height:{$css}px; }";

			if( $css = $args->get('navi_font_family') )
				$arrCustomCSS[]	= ".dropdown-menu > li > a{ font-family:{$css}; }";

			if( $css = $args->get('header_submenu_font_color') )
				$arrCustomCSS[]	= ".dropdown-menu > li > a{ color:{$css}; }";
		} // Header

		$arrCustomCSS[]		= "/* dropdown css */"; {
			if( 'hide' == $args->get('panel_display') )
				$arrCustomCSS[]	= "
					.jvfrm_home_somw_panel{ display:none !important; }
					.jvfrm_home_somw_opener_type1 {display:none;}
					.map_area {margin-left:0px !important;}";
		} // dropdown css
		return join( false, $arrCustomCSS );
	}
}
new jvfrm_home_theme_settings;