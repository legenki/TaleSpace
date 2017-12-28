<?php
class jvfrm_home_featured_properties extends jvfrm_home_Directory
{
	private static $load_script = false;
	public function __construct()
	{
		if( ! class_exists( 'JvfrmHome_ShortcodeParse' ) )
			return;

		add_filter( 'jvfrm_home_other_shortcode_array', Array( $this, 'register_shortcode' ) );
		add_action( 'wp_footer', Array( __CLASS__ ,'load_script_func' ) );
		add_action( 'vc_before_init' , Array( __CLASS__, 'register_shortcode_with_vc' ), 11 );
	}
	public function register_shortcode( $shortcode )
	{
		return wp_parse_args(
			Array( 'jvfrm_home_featured_properties' => Array( $this, '_output' ) )
			, $shortcode
		);
	}
	public static function register_shortcode_with_vc()
	{
		if( !function_exists( 'vc_map') )
			return;
		// Javo Featured Items
		/*vc_map(array(
			'base'						=> 'jvfrm_home_featured_properties'
			, 'name'						=> esc_html__( "Featured Item 1", 'javohome' )
			, 'category'				=> esc_html__('Javo', 'javohome')
			, 'icon'						=> 'jv-vc-shortcode-icon shortcode-featured-properties'
			, 'params'					=> Array(
				Array(
					'type'					=>'textfield'
					, 'heading'			=> esc_html__( "Title", 'javohome')
					, 'holder'			=> 'div'
					, 'class'				=> ''
					, 'param_name'	=> 'title'
					, 'value'				=> ''
				)
				, Array(
					'type'				=>'checkbox'
					, 'heading'			=> esc_html__( "Random Ordering", 'javohome' )
					, 'holder'			=> 'div'
					, 'param_name'	=> 'order_by'
					, 'value'				=> array(
						esc_html__( "Able to order randomly", 'javohome' ) => 'rand'
					)
				)
			)
		));*/
	}
	public static function load_script_func()
	{
		if( !self::$load_script )
			return;
		wp_enqueue_script( 'jQuery-Rating' );
	}
	public function _output( $atts, $content="" )
	{
		global $jvfrm_home_tso;
		$this->obj							= new JvfrmHome_ShortcodeParse( $atts );
		self::$load_script					= true;
		$param								= shortcode_atts(
			Array(
				'title'								=> ''
				, 'random'						=> ''
			), $atts
		);
		$jvfrm_home_featuredProperty_query = Array(
			'post_type'						=> self::SLUG
			, 'post_status'					=> 'publish'
			, 'posts_per_page'			=> 1
			, 'orderby'							=> $this->obj->order_by
			, 'meta_query'					=> Array(
				Array(
					'key'							=> '_featured_item'
					, 'compare'				=> '='
					, 'value'						=> '1'
				)
			)
		);
		$jvfrm_home_featuredProperty		= get_posts( $jvfrm_home_featuredProperty_query );
		ob_start();
		printf( "
			<div %s>
				<div id=\"%s\" class=\"shortcode-container fadein\">
					<div class=\"shortcode-header\">
						<div class=\"shortcode-title\">%s</div>
					</div>"
			, $this->obj->classes( 'shoetcode-' . get_class( $this ) , true )
			, $this->obj->getID()
			, $this->obj->title
		);
		if( !empty( $jvfrm_home_featuredProperty ) ){
			foreach( $jvfrm_home_featuredProperty as $post ) {
				$objModule13 = new module13( $post );
				echo $objModule13->output();
			}
		}else{
			printf( "<div class=\"row text-center\">%s</div>", esc_html__( "Not found featured listings.", 'javohome' ) );
		}
		echo "
				</div><!-- /.shortcode-container -->
			</div>";
		return ob_get_clean();
	}
}
new jvfrm_home_featured_properties;