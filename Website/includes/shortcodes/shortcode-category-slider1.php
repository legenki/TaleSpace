<?php
class jvfrm_home_category_slider1
{
	
	public $loaded		= false;

	public $attr			= Array();

	private $sID			= false;

	public function __construct(){

		add_action( 'vc_before_init', Array( $this, 'register_shortcode_with_vc' ), 11 );

		// Shortcode Resgistered
		add_filter( 'jvfrm_home_other_shortcode_array', Array( $this, 'register_shortcode' ) );

		// Shortcode Enqueues & Scripts
		add_action( 'wp_footer', Array( $this, 'scripts' ) );
	}
	
	public function scripts()
	{
		if( !$this->loaded )
			return;
		$attr				= $this->attr;

		wp_enqueue_script( 'owl-carousel-script' );
		wp_enqueue_script('javo-shortcode-script' );

	}
	public function register_shortcode( $shortcode )
	{
		return wp_parse_args(
			Array(
				'jvfrm_home_category_slider1' => Array( $this, 'config' )
			)
			, $shortcode
		);
	}

	public function register_shortcode_with_vc()
	{

		$strGroupFilter					= esc_html__( "Filter", 'javohome' );
		$strGroupAdvanced			= esc_html__( "Advanced", 'javohome' );
		$strGroupStyle					= esc_html__( "Style", 'javohome' );

		if( !function_exists( 'vc_map' ) )
			return;

		vc_map(
			Array(
				'base'						=> 'jvfrm_home_category_slider1'
				, 'name'						=> esc_html__( "Type Slider 1", 'javohome')
				, 'icon'						=> 'jv-vc-shortcode-icon shortcode-slide1'
				, 'category'				=> esc_html__('Javo', 'javohome')
				, 'params'					=> Array(


				 //@group : general

					 Array(
						'type'					=> 'textfield'
						, 'heading'			=> esc_html__( "Title", 'javohome' )
						, 'holder'			=> 'div'
						, 'class'				=> ''
						, 'param_name'	=> 'title'
						, 'value'				=> ''
					),

					Array(
						'type'					=> 'dropdown'
						, 'heading'			=> esc_html__('Landing map ( Result page)', 'javohome')
						, 'holder'			=> 'div'
						, 'class'				=> ''
						, 'param_name'	=> 'query_requester'
						, 'value'				=> apply_filters(
							'jvfrm_home_get_map_templates'
							, Array( esc_html__("Default Search Page", 'javohome') => '' )
						)
					),


				 // @group : filter

					Array(
						'type'					=> 'dropdown'
						, 'heading'			=> esc_html__( "Display Taxonomy Type", 'javohome')
						, 'holder'			=> 'div'
						, 'group'				=> $strGroupFilter
						, 'class'				=> ''
						, 'param_name'	=> 'display_type'
						, 'value'				=> Array(
							esc_html__('Parent Only', 'javohome')		=> 'parent'
							, esc_html__('Parent + Child', 'javohome')	=> 'child'
						)
					),

					Array(
						'type'					=>'checkbox'
						, 'heading'			=> esc_html__( "Parents", 'javohome')
						, 'holder'			=> 'div'
						, 'group'				=> $strGroupFilter
						, 'class'				=> ''
						, 'param_name'	=> 'have_terms'
						, 'description'		=> esc_html__('Default : All Parents', 'javohome')
						, 'value'				=> $this->get_term_ids( 'property_type' )
					),

					Array(
						'type'					=> 'checkbox'
						, 'heading'			=> esc_html__('Random Ordering', 'javohome')
						, 'holder'			=> 'div'
						, 'group'				=> $strGroupFilter
						, 'class'				=> ''
						, 'param_name'	=> 'rand_order'
						, 'value'				=> Array(esc_html__('Enabled', 'javohome') =>'use')
					),

				 //@group : Style

					 Array(
						'type'					=> 'textfield'
						, 'heading'			=> esc_html__('Radius', 'javohome')
						, 'holder'			=> 'div'
						, 'group'				=> $strGroupStyle
						, 'class'				=> ''
						, 'param_name'	=> 'radius'
						, 'description'		=> esc_html__('Type image radius', 'javohome')
						, 'value'				=> intVal( 0 )
					),

					Array(
						'type'					=>'colorpicker'
						, 'heading'			=> esc_html__('Type Name Color', 'javohome')
						, 'holder'			=> 'div'
						, 'group'				=> $strGroupStyle
						, 'param_name'	=> 'inline_cat_text_color'
						, 'value'				=> ''
					),

					Array(
						'type'					=>'colorpicker'
						, 'heading'			=> esc_html__('Name Hover Color', 'javohome')
						, 'holder'			=> 'div'
						, 'group'				=> $strGroupStyle
						, 'param_name'	=> 'inline_cat_text_hover_color'
						, 'value'				=> ''
					),

					Array(
						'type'					=>'colorpicker'
						, 'heading'			=> esc_html__('Arrow Color', 'javohome')
						, 'holder'			=> 'div'
						, 'group'				=> $strGroupStyle
						, 'param_name'	=> 'inline_cat_arrow_color'
						, 'value'				=> ''
					),


				 // @group : Advanced

					Array(
						'type'					=> 'textfield'
						, 'heading'			=> esc_html__('Display amount of items.', 'javohome')
						, 'holder'			=> 'div'
						, 'group'				=> $strGroupAdvanced
						, 'class'				=> ''
						, 'param_name'	=> 'max_amount'
						, 'description'		=> esc_html__('(Only Number. recomend around 8)', 'javohome')
						, 'value'				=> intVal( 0 )
					)
				)
			)
		);
	}

	public function config( $request_attr, $content="")
	{
		$this->attr = shortcode_atts(
			Array(
				'title'										=> false,
				'query_requester'					=> '',
				'display_type'							=> 'parent',
				'have_terms'							=> '',
				'max_amount'						=> 8,
				'rand_order'							=> null,
				'radius'									=> 50,
				'inline_cat_text_color'				=> '',
				'inline_cat_text_hover_color'	=> '',
				'inline_cat_arrow_color'			=> '',
			), $request_attr
		);

		$this->loaded	= true;
		$this->sID		= 'jvfrm_home_scd' . md5( wp_rand( 0 , 500 ) .time() );
		return $this->output( $this->attr );
	}

	public static function getHeader( $param ) {

		if( empty( $param[ 'title' ] ) )
			return;

		$strHeader	= $param[ 'title' ];
		?>

		<div class="row jv-search1-header-row">
			<div class="col-xs-12">
				<div class="static-label admin-color-setting">
					<?php echo $strHeader; ?>
				</div>
			</div>
		</div>
		<?php
	}

	public function get_term_ids( $taxonomy ){
		$jvfrm_home_this_return		= Array();
		$jvfrm_home_this_terms		= get_terms( $taxonomy, Array('hide_empty'=>false, 'parent'=>0) );
		if( !is_wp_error( $jvfrm_home_this_terms ) && !empty( $jvfrm_home_this_terms ) ){
			foreach( $jvfrm_home_this_terms as $term ) {
				$jvfrm_home_this_return[$term->name]		= $term->term_id;
			};
		};
		return $jvfrm_home_this_return;
	}


	public function output( $attr )
	{
		global $jvfrm_home_filter_prices, $jvfrm_home_tso;
		$strRequester	= apply_filters( 'jvfrm_home_wpml_link', intVal( $attr[ 'query_requester' ] ) );

		if( !class_exists( 'Lava_RealEstate_Manager' ) )
			return sprintf(
				'<p align="center">%s</p>',
				esc_html__( "Please, active to the 'Lava Real Estate manager' plugin", 'javohome' )
			);

		ob_start();?>
		
		<?php self::getHeader( $attr ); ?>
		<?php
		$have_terms = @explode(',', $attr[ 'have_terms' ] );
		$jvfrm_home_have_terms = Array();
		if( !empty($have_terms) ){
			foreach( $have_terms as $term){
				if( (int)$term <= 0 ){
					continue;
				};
				$jvfrm_home_have_terms[] = get_term( $term, 'property_type' );

				// IF NOT ONLY PARENTS
				if( $attr[ 'display_type' ] != 'parent' )
				{
					$jvfrm_home_sub_cat = get_terms( 'property_type', Array( 'parent' => $term , 'hide_empty'=> false ) );
					foreach( $jvfrm_home_sub_cat as $cat )
					{
						$jvfrm_home_have_terms[] = $cat;
					}
				}
			};
		};
		if( $attr[ 'max_amount' ]<=0 || $attr[ 'max_amount' ]>8) $attr[ 'max_amount' ]=8;
		if( $attr[ 'radius' ] >50 || $attr[ 'radius' ]<0) $attr[ 'radius' ]=50;
		$jvfrm_home_this_get_term_args				= Array();
		$jvfrm_home_this_get_term_args['hide_empty']	= false;

		if( $attr[ 'display_type' ] == 'parent' || $attr[ 'display_type' ] == '' )
		{
			$jvfrm_home_this_get_term_args['parent']	= 0;
		}

		$jvfrm_home_inline_category_terms = !empty( $jvfrm_home_have_terms )? $jvfrm_home_have_terms : get_terms("property_type", $jvfrm_home_this_get_term_args);
		$jvfrm_home_get_terms_ids = Array();

		if($attr[ 'rand_order' ] != null) shuffle($jvfrm_home_inline_category_terms); //random ordering

		ob_start();?>
		<?php if($attr[ 'inline_cat_text_hover_color' ] !=''){
			?>
			<style>
			#javo-inline-category-slider-wrap .javo-inline-category:hover .javo-inline-cat-title{color:<?php echo $attr[ 'inline_cat_text_hover_color' ]; ?> !important;}
			</style>
			<?php
		}

		?>
		<div class="javo-shortcode shortcode-jvfrm_home_category_slider1 active" id="<?php echo sanitize_html_class( $this->sID ); ?>">
			<div id="javo-inline-category-slider-wrap" class="jv-inline-category-slider">
				<div id="javo-inline-category-slider-inner">
					<div id="javo-inline-category-slider" class="owl-carousel owl-theme" style="display:block;" data-max="<?php echo intVal(  $attr[ 'max_amount' ] ); ?>">
						<?php
						if( !empty( $jvfrm_home_inline_category_terms ) )
						{
							foreach( $jvfrm_home_inline_category_terms as $terms )
							{
								$featured = get_option( 'lava_property_type_'.$terms->term_id.'_featured', '' );
								$featured = wp_get_attachment_image_src( $featured, 'thumbnail' );
								$featured = $featured[0];
								$featured = $featured != ''? $featured : $jvfrm_home_tso->get('no_image', JVFRM_HOME_IMG_DIR.'/no-image.png');
								?>
								<div class="item javo-inline-category">
									<a href="<?php echo esc_url( add_query_arg( Array( 'type' => $terms->term_id ), $strRequester ) ); ?>">
										<img src="<?php echo $featured; ?>"style="width:111px; height:111px; border-radius:<?php echo $attr[ 'radius'];?>%;">
										<div class="javo-inline-cat-title" style="	<?php if($attr[ 'inline_cat_text_color' ] !='') echo 'color:'.$attr [' inline_cat_text_color' ] . ';' ?>">
											<?php echo $terms->name; ?>
										</div>
									</a>
								</div>
							<?php
							}
						} ?>
					</div>
					<div class="customNavigation">
					  <a class="btn prev" <?php if($attr[ 'inline_cat_arrow_color' ] !='') echo 'style="color:'.$attr[ 'inline_cat_arrow_color' ].';"'?>><i class="fa fa-angle-left"></i></a>
					  <a class="btn next" <?php if($attr[ 'inline_cat_arrow_color' ] !='') echo 'style="color:'.$attr[ 'inline_cat_arrow_color' ].';"'?>><i class="fa fa-angle-right"></i></a>
					</div><!--javo-inline-category-slider-->
				</div><!--javo-inline-category-slider-inner-->
			</div><!--javo-inline-category-slider-wrap-->
		</div><!-- /.shortcode-jvfrm_home_category_slider1 -->
	<?php
		$arrOutput		= Array();
		$arrOutput[]	= "<script type=\"text/javascript\">";
		$arrOutput[]	= "jQuery( function($){ $.jvfrm_home_search_shortcode( '#{$this->sID}' ); });";
		$arrOutput[]	= "</script>";
		//echo join( '', $arrOutput );
		return ob_get_clean();
	}

	
}

if( !function_exists( 'jvfrm_home_category_slider1_init') ){
	function jvfrm_home_category_slider1_init() {
		$GLOBALS[ 'jvfrm_home_category_slider1' ] = new jvfrm_home_category_slider1;
	}
	add_action( 'after_setup_theme', 'jvfrm_home_category_slider1_init' );
}