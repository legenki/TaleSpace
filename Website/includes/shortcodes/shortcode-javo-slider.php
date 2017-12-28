<?php

class jvfrm_home_slider {

	public $shortcode_name = 'jvfrm_home_slider';

	public static $load_script = false;

	public function __construct() {
		add_filter( 'jvfrm_home_other_shortcode_array', Array( $this, 'register_shortcode' ) );
		add_action( 'wp_footer', Array( $this,'load_script_func' ) );
		add_action( 'admin_init' , Array( $this, 'register_shortcode_with_vc' ), 11 );
	}

	public function register_shortcode( $shortcode ) {
		return wp_parse_args(
			Array( $this->shortcode_name => Array( $this, 'output' ) ),
			$shortcode
		);
	}

	public function get_post_types( $options=Array(), $excerpt=Array() ) {
		$arrPostTypes = get_post_types( array(), 'objects' );
		$arrReturns = Array();
		foreach( $arrPostTypes as $strPostType => $objPostType ) {
			$arrReturns[ $objPostType->label ] = $strPostType;
		}
		return $arrReturns;
	}

	public function register_shortcode_with_vc() {

		if( !function_exists( 'vc_map') )
			return;

		vc_map(
			array(
				'base' => $this->shortcode_name,
				'name' => esc_html__( "Javo Slider", 'javohome' ),
				'category' => esc_html__('Javo', 'javohome'),
				'icon' => 'jv-vc-shortcode-icon shortcode-featured-properties',
				'params' => Array(
					Array(
						'type' =>'dropdown',
						'heading' => esc_html__( "Post Type", 'javohome'),
						'holder' => 'div',
						'param_name'	=> 'post_type',
						'value' => $this->get_post_types( array() ),
					),
					Array(
						'type' =>'checkbox',
						'heading' => esc_html__( "Only Featured Item", 'javohome'),
						'holder' => 'div',
						'param_name'	=> 'featured',
						'value' => Array( esc_html__( "Use", 'javohome' ) => 'true' ),
					),
					Array(
						'type' =>'textfield',
						'heading' => esc_html__( "Listing Count", 'javohome'),
						'desccription' => esc_html__( "( Blank = Unlimited )", 'javohome'),
						'holder' => 'div',
						'param_name'	=> 'count',
					),
				)
			)
		);
	}
	public function load_script_func() {
		if( !self::$load_script )
			return;

		wp_enqueue_script(
			lava_realestate()->enqueue->getHandleName( 'jquery.flexslider-min.js' )
		);
		echo "
		<script type='text/javascript'>
			jQuery( function($) {
				$( '.jvfrm-home-slider' ).each( function() {
					$( '.jvfrm-home-slider-main', this ).flexslider({
						animation : 'slide',
						controlNav : false,
						animationLoop : false,
						slideshow : false,
						sync : '.jvfrm-home-slider-thumbnail'						
					});
					$( '.jvfrm-home-slider-thumbnail', this ).flexslider({
						animation : 'slide',
						controlNav : false,						
						animationLoop : false,
						slideshow : false,
						itemWidth : 80,
						itemMargin : 5,
						asNavFor : '.jvfrm-home-slider-main'
					});
				});
			} );
		</script>";
	}

	public function output( $atts, $content="" ) {
		self::$load_script = true;
		ob_start();
		jvfrm_home_core()->template->load_template(
			'../shortcodes/html/html-javo-slider',
			'.php',
			Array(
				'jvfrm_home_slider_param' => $atts,
			)
		);
		return ob_get_clean();
	}
}

new jvfrm_home_slider;