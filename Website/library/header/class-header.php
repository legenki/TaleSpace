<?php

if( ! class_exists( 'jvfrm_home_Header_Func' ) ) : class Jv_Header_Func
{
	public static $instance;

	private $slug;

	public $options = Array();

	public $arrNav_classes = Array();

	public function __construct() {

		add_action( 'wp_head', Array( $this, 'getOptions' ) );
		add_action( 'wp_head', Array( $this, 'toolbar_widget' ), 11 );

		add_action( 'jvfrm_home_output_header', Array( $this, 'output' ) );
		add_action( 'jvfrm_home_header_wrap_after', Array( $this, 'custom_title' ) );
		add_action( 'jvfrm_home_contact_header_nav', Array( $this, 'basic_walker' ) );
		add_action( 'jvfrm_home_header_logos', Array( $this, 'custom_logo' ) );
		add_filter( 'jvfrm_home_header_class', Array( $this, 'header_classes' ), 10, 3 );
		add_filter( 'jvfrm_home_options_header_types', Array( $this, 'header_type_options' ) );
	}

	public function getOptions(){
		global $post;

		$arrOptions		= get_post_meta( $post->ID, 'jvfrm_home_hd_post', true );
		$arrOptions		= is_array( $arrOptions ) ? $arrOptions : Array();
		$this->options	= (object) shortcode_atts(
			Array(
				'topbar'			=> '',
				'header_size_as'	=> '',
				'header_size'		=> esc_html(intVal( jvfrm_home_tso()->header->get( 'header_size', 50 ) ) ),
				'header_type'		=> '',
				'header_skin'		=> jvfrm_home_tso()->header->get( 'header_skin', '' ),
			)
			, $arrOptions
		);

		if( empty( $this->options->header_type ) )
			$this->options->header_type	=  jvfrm_home_tso()->header->get( 'header_type', '' );
	}

	public function header_type_options( $options )
	{
		return wp_parse_args(
			Array(
				esc_html__( "1 Row (inline) type", 'javohome' ) => 'inline',
			/**
				esc_html__( "Vertical type", 'javohome' ) => 'jv-vertical-nav',
				esc_html__( "2 Rows type", 'javohome' ) => 'jv-nav-row-2',
				esc_html__( "2 Rows logo center (M)", 'javohome' ) => 'jv-nav-row-2-second',
				esc_html__( "2 Rows type", 'javohome' ) => 'jv-nav-row-2-lvl',				
				esc_html__( "2 Rows type (ceter)", 'javohome' )		=> 'jv-nav-row-2-lvl center', */
				esc_html__( "2 Rows (Transparent) type", 'javohome' )	=> 'jv-nav-row-2-lvl nav-transparent'
			)
			, $options
		);
	}

	public function basic_walker( $alignType )
	{
		$strNavAlign				= 'navbar-' . $alignType;

		echo "<div id=\"javo-navibar\">";
			wp_nav_menu(
				Array(
					'menu_class'		=> 'nav navbar-nav' . ' ' . $strNavAlign
					, 'theme_location'	=> 'primary'
					, 'depth'			=> 3
					, 'container'		=> false
					, 'fallback_cb'		=> 'wp_bootstrap_navwalker::fallback'
					, 'walker'			=> new wp_bootstrap_navwalker()
				)
			);
		echo "</div>";
	}

	public function custom_logo()
	{
		global $jvfrm_home_tso;

		$strBasicLogo				= JVFRM_HOME_IMG_DIR.'/Javo_Directory_logo.png';

		$arrLogoImages				= Array(
			'dark'					=> $jvfrm_home_tso->get( 'logo_url' , $strBasicLogo )
			, 'light'				=> $jvfrm_home_tso->get( 'logo_light_url' , $strBasicLogo )
		);

		if( ! empty( $arrLogoImages ) ) foreach( $arrLogoImages as $classes => $url )
			echo "<img src=\"{$url}\" height=\"100%\" class=\"logo {$classes}\">";

	}

	public function header_classes( $classes, $post_id=0, $query=null )
	{
		if( is_object( $query ) ) :
			$classes[]		= $query->get( 'header_skin', jvfrm_home_tso()->header->get( 'header_skin', 'dark' ) );
		endif;

		if( get_post_type( $post_id ) == 'post' && get_query_var('pn')!='member' && !is_archive())
			$classes[]		= jvfrm_home_tso()->header->get( 'single_post_page_header_type' );
		else
			$classes[]		= $query->get( 'header_type', jvfrm_home_tso()->header->get( 'header_type', '' ) );

		return $classes;
	}

	public function nav_classes( $classe='' ){

		global $post;

		$strHeaderTypeOption = '';

		if( !empty( $classe ) )
			$this->arrNav_classes[] = $classe;

		if( get_post_type( $post->ID ) != 'post' ){
			$strHeaderTypeOption = $this->options->header_type;
		}else{
			$strHeaderTypeOption = jvfrm_home_tso()->header->get( 'single_post_page_header_type' );
		}

		if( false !== strpos( $strHeaderTypeOption, 'jv-nav-row-2-lvl' ) )
			$this->arrNav_classes[] = 'nav-justified';
	}

	public function get_classes( $classes='' ) {
		$this->nav_classes( $classes );
		return join( ' ', $this->arrNav_classes );
	}

	public function custom_title( $post_id ) {
		global $wp_query;

		if( !$wp_query->is_single && !$wp_query->is_page )
			return;


		get_template_part("library/header/post", "header");
	}

	public function output( $post_id )
	{
		$jvfrm_home_headerParams		= Array();
		$jvfrm_home_headerClasses		= '';

		$headerSlug				= 'general';
		$jvfrm_home_hd_options			= get_post_meta( $post_id, 'jvfrm_home_hd_post', true );
		$jvfrm_home_post_skin			= new jvfrm_home_array( $jvfrm_home_hd_options );
		$intHeaderHeight		= 0;

		if( $jvfrm_home_post_skin->get( 'header_size_as', '' ) != '' )
			$intHeaderHeight	= intVal( $jvfrm_home_post_skin->get( 'header_size', 50 ) );
		else
			$intHeaderHeight	= intVal( jvfrm_home_tso()->header->get( 'header_size', 50 ) );

		$jvfrm_home_headerParams[ 'height' ]	= $intHeaderHeight . 'px' ;

		$jvfrm_home_headerParams[ 'slug' ]		= $headerSlug;
		$jvfrm_home_headerClasses				= apply_filters(
			'jvfrm_home_header_class'
			, Array(
				'main'
				, 'header-' . $headerSlug
				, 'javo-main-prmary-header'
			)
			, $post_id
			, $jvfrm_home_post_skin
		);
		$jvfrm_home_headerParams[ 'classes']		= ' class="'. implode( ' ', $jvfrm_home_headerClasses ) . '" ';

		$GLOBALS[ 'jvfrm_home_headerParams' ]	= $jvfrm_home_headerParams;
		$strHeaderFile = JVFRM_HOME_HDR_DIR . '/header-' . $headerSlug . '.php';

		do_action( 'jvfrm_home_header_wrap_before', $post_id );
		if( file_exists( $strHeaderFile ) )
			load_template( $strHeaderFile );
		do_action( 'jvfrm_home_header_wrap_after', $post_id );
	}

	public function toolbar_widget(){
		$arrAllow = apply_filters( 'jvfrm_home_allow_type_header_toolbars_body', Array( 'inline' ) );
		if( !in_array( $this->options->header_type, $arrAllow ) ) {
			add_action( 'jvfrm_home_header_inner_logo_after', Array( $this, 'getToolbarWidgets' ) );
		}else{
			add_action( 'jvfrm_home_header_toolbars_body', Array( $this, 'getToolbarWidgets' ) );
		}
	}

	public function getToolbarWidgets(){
		$strStyle	= '';

		if( false !== ( strpos( $this->options->header_type, 'jv-nav-row-2-lvl' ) ) )
			$strStyle = sprintf(
				'style="min-height:%spx; line-height:%spx;"',
				$this->options->header_size,
				$this->options->header_size
			);
		?>
		<div class="javo-toolbar-left" <?php echo $strStyle; ?>>
			<div><?php if( is_active_sidebar( 'toolbar-left-widget' ) ) dynamic_sidebar( 'toolbar-left-widget' ); ?></div>
		</div><!-- /.javo-toolbar-left -->

		<div class="javo-toolbar-right" <?php echo $strStyle; ?>>
			<div><?php if( is_active_sidebar( 'toolbar-right-widget' ) ) dynamic_sidebar( 'toolbar-right-widget' ); ?></div>
		</div><!-- /.javo-toolbar-right -->
		<?php
	}

	public function getTopbarAllow(){
		if( !$strTopbaar = $this->options->topbar )
			$strTopbaar = jvfrm_home_tso()->get( 'topbar_use', 'enable' );
		return $strTopbaar == 'enable';
	}

	public static function getInstance(){
		if( !self::$instance )
			self::$instance = new self;
		return self::$instance;
	}

} endif;

if( !function_exists( 'jvfrm_home_header' ) ) : function jvfrm_home_header() {
	return Jv_Header_Func::getInstance();
} jvfrm_home_header(); endif;