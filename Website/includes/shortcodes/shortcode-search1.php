<?php
class jvfrm_home_search1
{
	public $loaded = false;

	private $sID;

	public function __construct(){

		// Shortcode Resgistered
		add_filter( 'jvfrm_home_other_shortcode_array', Array( $this, 'rregister_shortcode' ) );
		add_action( 'vc_before_init', Array( $this, 'register_shortcode_with_vc' ), 11 );

		// Shortcode Enqueues & Scripts
		add_action( 'wp_footer', Array( $this, 'scripts' ) );

		// Coulmn Actions
		add_action( 'jv_search1_element_keyword',				Array( $this, 'keyword' ) );
		add_action( 'jv_search1_element_property_type',		Array( $this, 'property_type' ) );
		add_action( 'jv_search1_element_property_city',		Array( $this, 'property_city' ) );
		add_action( 'jv_search1_element_property_status',	Array( $this, 'property_status' ) );
		add_action( 'jv_search1_element_bedrooms',			Array( $this, 'bedrooms' ) );
		add_action( 'jv_search1_element_bathrooms',			Array( $this, 'bathrooms' ) );
		add_action( 'jv_search1_element_garages',				Array( $this, 'garages' ) );
		add_action( 'jv_search1_element_price',					Array( $this, 'price' ) );
		add_action( 'jv_search1_element_property_id',			Array( $this, 'property_id' ) );
	}

	public function rregister_shortcode( $shortcode )
	{
		return wp_parse_args(
			Array(
				'jvfrm_home_search1' => Array( $this, 'config' )
			)
			, $shortcode
		);
	}

	public static function fieldParameter( $param_name, $label=false ){
		return Array(
			'type'				=> 'dropdown',
			'heading'			=> $label,
			'holder'				=> 'div',
			'group'				=> __( "Fields", 'javohome' ),
			'class'				=> '',
			'param_name'	=> $param_name,
			'value'				=> Array(
				__( "None", 'javohome' )						=> '',
				__( "Keyword", 'javohome' )				=> 'keyword',
				__( "Property Type", 'javohome' )		=> 'property_type',
				__( "Property City", 'javohome' )			=> 'property_city',
				__( "Property Status", 'javohome' )	=> 'property_status',
				__( "Bedrooms", 'javohome' )				=> 'bedrooms',
				__( "Bathrooms", 'javohome' )			=> 'bathrooms',
				__( "Garages", 'javohome' )				=> 'garages',
				__( "Price", 'javohome' )						=> 'price',
				__( "Property ID", 'javohome' )			=> 'property_id',
			)
		);
	}

	public function register_shortcode_with_vc()
	{
		$strGroupFilter					= __( "Filter", 'javohome' );
		vc_map(
			Array(
				'base'						=> 'jvfrm_home_search1'
				, 'name'						=> __( "Search 1", 'javohome')
				, 'icon'						=> 'jv-vc-shortcode-icon shortcode-search1'
				, 'category'				=> __('Javo', 'javohome')
				, 'params'					=> Array(

				/**
				 *	@group : general
				 */
					 Array(
						'type'				=> 'textfield'
						, 'heading'			=> __( "Title", 'javohome' )
						, 'holder'			=> 'div'
						, 'class'				=> ''
						, 'param_name'	=> 'title'
						, 'value'				=> ''
					)

					, Array(
						'type'				=> 'dropdown'
						, 'heading'			=> __('Please select search result page', 'javohome')
						, 'holder'			=> 'div'
						, 'class'				=> ''
						, 'param_name'	=> 'query_requester'
						, 'value'				=> apply_filters(
							'jvfrm_home_get_map_templates'
							, Array( __("Default Search Page", 'javohome') => '' ) )
					)
				/**
				 *	@group : filter
				 */
					, Array(
						'type'				=> 'textfield'
						, 'heading'			=> __( "Price filter Min", 'javohome' )
						, 'holder'			=> 'div'
						, 'group'			=> $strGroupFilter
						, 'class'				=> ''
						, 'param_name'	=> 'price_min'
						, 'value'				=> ''
					)
					, Array(
						'type'				=> 'textfield'
						, 'heading'			=> __( "Price filter Max", 'javohome' )
						, 'holder'			=> 'div'
						, 'group'			=> $strGroupFilter
						, 'class'				=> ''
						, 'param_name'	=> 'price_max'
						, 'value'				=> ''
					)
					, Array(
						'type'				=> 'textfield'
						, 'heading'			=> __( "Currency", 'javohome' )
						, 'holder'			=> 'div'
						, 'group'			=> $strGroupFilter
						, 'class'				=> ''
						, 'param_name'	=> 'price_prefix'
						, 'value'				=> ''
					)

				/**
				 *	@group : Fields
				 */
					, self::fieldParameter( 'column1', __( "1 row, 1 column", 'javohome'  ) )
					, self::fieldParameter( 'column2', __( "1 row, 2 column", 'javohome'  ) )
					, self::fieldParameter( 'column3', __( "1 row, 3 column", 'javohome'  ) )
					, self::fieldParameter( 'column4', __( "1 row, 4 column", 'javohome'  ) )
					, self::fieldParameter( 'column5', __( "2 row, 1 column", 'javohome'  ) )
					, self::fieldParameter( 'column6', __( "2 row, 2 column", 'javohome'  ) )
					, self::fieldParameter( 'column7', __( "2 row, 3 column", 'javohome'  ) )
					, self::fieldParameter( 'column8', __( "2 row, 4 column", 'javohome'  ) )
				)
			)
		);
	}

	public function config( $request_attr, $content="")
	{
		$attr = shortcode_atts(
			Array(
				'title'							=> false
				, 'query_requester'	=> 0
				, 'price_min'				=> 0
				, 'price_max'				=> 15000000
				, 'price_prefix'			=> '$'
				, 'column1'				=> ''
				, 'column2'				=> ''
				, 'column3'				=> ''
				, 'column4'				=> ''
				, 'column5'				=> ''
				, 'column6'				=> ''
				, 'column7'				=> ''
				, 'column8'				=> ''
			)
			, $request_attr
		);
		$this->loaded	= true;
		$this->sID		= 'javo_scd' . md5( wp_rand( 0 , 500 ) .time() );
		return $this->output( $attr );
	}

	public static function dropdownNumberOption( $intMin=1, $intMax=10, $prefix='', $suffix='' ){
		$arrOutput	= Array();
		for( $iCurrent=$intMin; $iCurrent <= $intMax; $iCurrent++ )
			$arrOutput[]	= "<option value=\"{$iCurrent}\">{$prefix}{$iCurrent}{$suffix}</option>";
		return join( "\n", $arrOutput );
	}

	public function keyword() {
		printf( "<input type=\"text\" name=\"%s\" placeholder=\"%s\" class=\"form-control\">"
			, 'keyword'
			, __( "Keyword", 'javohome' )
		);
	}

	public function property_type() {
		printf( "<select name=\"%s\" class=\"form-control\"><option value=''>%s</option>%s</select>"
			, 'type'
			,  __( "All Type", 'javohome' )
			, apply_filters( 'jvfrm_home_get_selbox_child_term_lists', 'property_type', null, 'select', false, 0, 0, '-' )
		);
	}

	public function property_city() {
		printf( "<select name=\"%s\" class=\"form-control\"><option value=''>%s</option>%s</select>"
			, 'city'
			,  __( "All City", 'javohome' )
			, apply_filters( 'jvfrm_home_get_selbox_child_term_lists', 'property_city', null, 'select', false, 0, 0, '-' )
		);
	}

	public function property_status() {
		printf( "<select name=\"%s\" class=\"form-control\"><option value=''>%s</option>%s</select>"
			, 'status'
			,  __( "All Status", 'javohome' )
			, apply_filters( 'jvfrm_home_get_selbox_child_term_lists', 'property_status', null, 'select', false, 0, 0, '-' )
		);
	}

	public function bedrooms() {
		printf( "<select name=\"%s\" class=\"form-control\"><option value=''>%s</option>%s</select>"
			, 'beds'
			,  __( "All Bedrooms", 'javohome' )
			, self::dropdownNumberOption()
		);
	}

	public function bathrooms() {
		printf( "<select name=\"%s\" class=\"form-control\"><option value=''>%s</option>%s</select>"
			, 'baths'
			,  __( "All Bathrooms", 'javohome' )
			, self::dropdownNumberOption()
		);
	}

	public function garages() {
		printf( "<select name=\"%s\" class=\"form-control\"><option value=''>%s</option>%s</select>"
			, 'garages'
			,  __( "All Garages", 'javohome' )
			, self::dropdownNumberOption()
		);
	}

	public function price( $param ) {
		printf( "
			<div class=\"javo-price-slider-wrap\">
				<div class=\"javo-price-slider\"></div>
				<div class=\"price-tooltip-title text-center\">
					{$param['price_prefix']} <span data-min></span>
					%s  {$param['price_prefix']} <span data-max></span>
				</div>
				<input type=\"hidden\" name=\"minPrice\" value=\"{$param[ 'price_min' ]}\">
				<input type=\"hidden\" name=\"maxPrice\" value=\"{$param[ 'price_max' ]}\">
			</div>",
			__( "To", 'javohome' )
		);
	}

	public static function amenities()
	{
		if(  $arrAmenities	= get_terms( 'property_amenities', Array( 'fields' => 'id=>name' ) ) ){
			echo "<div class=\"row\">";
			foreach( $arrAmenities as $id => $name )
			{
				printf( "
					<div class=\"col-md-4\">
						<label>
							<input type=\"checkbox\" name=\"%s[]\" value=\"{$id}\">
							{$name}
						</label>
					</div>"
					, 'amenity'
				);
			}
			echo "</div>";
		}else{
			_e( "Not Found Any Amenities", 'javohome' );
		}

	}

	public function property_id() {
		printf( "<input type=\"text\" name=\"property_id\" placeholder=\"%s\" class=\"form-control\">", __( "Property ID", 'javohome' ) );
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


	public function output( $attr ) {
		global $jv_filter_prices, $jv_tso;
		$strRequester	= apply_filters( 'jvfrm_home_wpml_link', intVal( $attr[ 'query_requester' ] ) );

		if( !class_exists( 'lava_realestate_manager' ) )
			return sprintf(
				'<p align="center">%s</p>',
				__( "Please, active to the 'Lava Real Estate manager' plugin", 'javohome' )
			);

		ob_start();?>
		<div class="javo-shortcode shortcode-jvfrm_home_search1 active" id="<?php echo sanitize_html_class( $this->sID ); ?>">
			<?php self::getHeader( $attr ); ?>
			<form method="get" action="<?php echo esc_attr( $strRequester );?>">
				<div class="jv-search1-search-fields">
					<div class="row jv-search1-top-row">
						<div class="col-sm-6 col-md-3"><?php do_action( 'jv_search1_element_' . $attr['column1'], $attr ); ?></div>
						<div class="col-sm-6 col-md-3"><?php do_action( 'jv_search1_element_' . $attr['column2'], $attr ); ?></div>
						<div class="col-sm-6 col-md-3"><?php do_action( 'jv_search1_element_' . $attr['column3'], $attr ); ?></div>
						<div class="col-sm-6 col-md-3"><?php do_action( 'jv_search1_element_' . $attr['column4'], $attr ); ?></div>
					</div> <!-- rows -->
					<div class="row jv-search1-bottom-row" >
						<div class="col-sm-6 col-md-3"><?php do_action( 'jv_search1_element_' . $attr['column5'], $attr ); ?></div>
						<div class="col-sm-6 col-md-3"><?php do_action( 'jv_search1_element_' . $attr['column6'], $attr ); ?></div>
						<div class="col-sm-6 col-md-3"><?php do_action( 'jv_search1_element_' . $attr['column7'], $attr ); ?></div>
						<div class="col-sm-6 col-md-3"><?php do_action( 'jv_search1_element_' . $attr['column8'], $attr ); ?></div>
					</div> <!-- rows -->
				</div> <!-- jv-search1-search-fields -->

				<div class="row jv-search1-morefilter-row">
					<div class="col-md-3">
						<?php _e( "Amenities", 'javohome' ); ?>
					</div>
					<div class="col-md-8">
						<?php self::amenities(); ?>
					</div>
				</div>
				<div class="row jv-search1-actions-row">
					<div class="col-md-2">
						<button type="button" class="btn btn-block jv-search1-morefilter-opener">
							<span class='more-filters'>
								<i class="glyphicon glyphicon-chevron-down"></i>
								<?php _e( "More FIlters", 'javohome' ); ?>
							</span>
							<span class='less-filters'>
								<i class="glyphicon glyphicon-chevron-up"></i>
								<?php _e( "Less Filters", 'javohome' ); ?>
							</span>
						</button>
					</div>
					<div class="col-md-5 col-md-offset-5 text-right">
						<div class="row">
							<div class="col-sm-12">
								<button type="submit" class="btn btn-block admin-color-setting"><?php _e( "Search", 'javohome');?></button>
							</div>
						</div><!-- /.row -->
					</div> <!-- col-md-2 -->
				</div>
			</form>
		</div>
	<?php
		$arrOutput		= Array();
		$arrOutput[]	= "<script type=\"text/javascript\">";
		$arrOutput[]	= "jQuery( function($){ $.jvfrm_home_search_shortcode( '#{$this->sID}' ); });";
		$arrOutput[]	= "</script>";
		echo join( '', $arrOutput );
		return ob_get_clean();
	}

	public function scripts() {
		if( !$this->loaded )
			return;
		wp_enqueue_script( 'jQuery-nouiSlider' );
		wp_enqueue_script( 'jquery-type-header' );
		wp_enqueue_script( jvfrm_home_core()->getHandleName( 'jquery.javo_search_shortcode.js' ) );
	}
}
$GLOBALS[ 'jvfrm_home_search1' ] = new jvfrm_home_search1();