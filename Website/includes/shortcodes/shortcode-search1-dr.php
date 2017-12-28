<?php
class jvfrm_home_search1
{

	public $loaded = false;

	public $is_keyword_active = false;

	private $sID;

	private $is_mobile = false;

	private $numCols = 1;

	public function __construct(){

		// Shortcode Resgistered
		add_filter( 'jvfrm_home_other_shortcode_array', Array( $this, 'register_shortcode' ) );  // Avoid themecheck : not allowed to create shortcodes in theme. plugin only.
		add_action( 'init', Array( $this, 'register_shortcode_with_vc' ), 11 );
		add_action( 'jvfrm_home_search1_submit_after', Array( $this, 'tags_object' ) );

		// Filters
		add_filter( 'jvfrm_home_search1_params', array( $this, 'getFieldParams' ) );
		add_filter( 'jvfrm_home_search1_shortcode_atts', array( $this, 'addColumnParam' ) );

		// Coulmn Actions
		add_action( 'jvfrm_home_search1_element_keyword'			, Array( $this, 'keyword' ) );
		add_action( 'jvfrm_home_search1_element_google_search'		, Array( $this, 'google_search' ) );
		add_action( 'jvfrm_home_search1_element_property_type'		, Array( $this, 'property_type' ) );
		add_action( 'jvfrm_home_search1_element_property_status'		, Array( $this, 'property_status' ) );
		add_action( 'jvfrm_home_search1_element_property_amenities'		, Array( $this, 'amenities' ), 10, 2);
	}

	public function register_shortcode( $shortcode )
	{
		return wp_parse_args(
			Array(
				'jvfrm_home_search1' => Array( $this, 'config' )
			)
			, $shortcode
		);
	}

	/*
	Shortcode parameter : fieldParameter for VC.
	 */
	public static function fieldParameter( $param_name, $label=false ){
		return Array(
			'type'				=> 'dropdown',
			'heading'			=> $label,
			'holder'			=> 'div',
			'group'			=> esc_html__( "Fields", 'javohome' ),
			'class'				=> '',
			'param_name'	=> $param_name,
			'value'				=> apply_filters(
				'jvfrm_home_search1_element_lists',
				Array(
					esc_html__( "None", 'javohome' )				=> '',
					esc_html__( "Keyword", 'javohome' )			=> 'keyword',
					esc_html__( "Google Search", 'javohome' )	=> 'google_search',
					esc_html__( "Category", 'javohome' )			=> 'property_type',
					esc_html__( "Location", 'javohome' )			=> 'property_status'
				)
			)
		);
	}	

	/*
	Register shortcode define details for VC
	 */
	public function register_shortcode_with_vc() {

		if( !function_exists( 'vc_map' ) )
			return;

		vc_map(
			Array(
				'base'						=> 'jvfrm_home_search1'
				, 'name'						=> esc_html__( "Search 1", 'javohome')
				, 'icon'						=> 'jv-vc-shortcode-icon shortcode-search1'
				, 'category'				=> esc_html__('Javo', 'javohome')
				, 'params'					=> $this->getParams()
			)
		);

	}

	public function getParams() {
		return apply_filters(
			'jvfrm_home_search1_params',
			Array(
				/**
				 *	@group : general
				 */
					Array(
						'type'				=> 'textfield',
						'heading'			=> esc_html__( "Title", 'javohome' ),
						'holder'			=> 'div',
						'class'				=> '',
						'param_name'	=> 'title',
						'value'				=> ''
					),
					Array(
						'type'				=> 'dropdown',
						'heading'			=> esc_html__('Please select search result page', 'javohome'),
						'holder'			=> 'div',
						'class'				=> '',
						'param_name'	=> 'query_requester',
						'value'				=> apply_filters(
							'jvfrm_home_get_map_templates',
							Array( esc_html__("Default Search Page", 'javohome') => '' ) )
					),
				/**
				 *	@group : Style
				 */
					Array(
						'type'			=> 'colorpicker'
						, 'group'		=> esc_html__( "Style", 'javohome' )
						, 'heading'		=> esc_html__( "Button Background Color", 'javohome')
						, 'holder'		=> 'div'
						, 'class'		=> ''
						, 'param_name'	=> 'button_bg_color'
						, 'value'		=> ''
					),
					Array(
						'type'			=> 'colorpicker'
						, 'group'		=> esc_html__( "Style", 'javohome' )
						, 'heading'		=> esc_html__( "Button Text Color", 'javohome')
						, 'holder'		=> 'div'
						, 'class'		=> ''
						, 'param_name'	=> 'button_text_color'
						, 'value'		=> ''
					),
				/**
				 *	@group : Fields
				 */
					Array(
						'type' => 'dropdown',
						'group' => esc_html__( "Fields", 'javohome' ),
						'heading' => esc_html__( "Keyword Autocomplete", 'javohome'),
						'holder' => 'div',
						'class' => '',
						'param_name' => 'keyword_auto',
						'value' => Array(
							__( "Enable", 'Lavacode' ) => '',
							__( 'Disable', 'Lavacode' ) => 'disable',
						)
					),
					
			)
		);
	}

	public function getFieldParams( $params=Array() ) {

		$arrColumn = $arrParam = Array();
		$intFieldCount = intVal( apply_filters( 'jvfrm_home_search1_field_count', 3 ) );
		$intFieldCount = $intFieldCount > 0 ? $intFieldCount : 1;

		for( $intCount = 1; $intCount <= $intFieldCount; $intCount++ ) {
			$arrColumn[ $intCount . ' ' . _n( "Column", "Columns", $intCount, 'javohome' ) ] = $intCount;
			$arrDepdency = Array();
			for( $intDepdency=$intCount; $intDepdency <= $intFieldCount; $intDepdency++ ) {
				$arrDepdency[] = "{$intDepdency}";
			}
			$arrParam[] = wp_parse_args(
				Array(
					'dependency'	=> Array(
						'element'	=> 'columns',
						'value'		=> $arrDepdency,
					)
				),
				self::fieldParameter( 'column' . $intCount, sprintf( esc_html__( "%d column", 'javohome'  ), $intCount ) )
			);
		}

		$params[] = Array(
			'type'				=> 'dropdown',
			'group'			=> esc_html__( "Fields", 'javohome' ),
			'heading'			=> esc_html__( "Columns", 'javohome'),
			'holder'			=> 'div',
			'class'				=> '',
			'param_name'	=> 'columns',
			'value'				=> $arrColumn
		);
		return wp_parse_args( $arrParam, $params );
	}

	public function addColumnParam( $args=Array() ) {
		$intFieldCount = intVal( apply_filters( 'jvfrm_home_search1_field_count', 3 ) );
		$intFieldCount = $intFieldCount > 0 ? $intFieldCount : 1;
		for( $intColumn=1; $intColumn <= $intFieldCount; $intColumn++ ) {
			$args[ 'column' . $intColumn ] = '';
		}
		return $args;
	}

	/*
	Shortcode call back
	 */
	public function config( $request_attr, $content="" ) {
		$attr = shortcode_atts(
			apply_filters(
				'jvfrm_home_search1_shortcode_atts',
				Array(
					'title' => false,
					'query_requester' => 0,
					'border_color' => '#000000',
					'border_width' => 1,
					'button_bg_color' => '',
					'button_text_color'	=> '',
					'keyword_auto'	=> '',
					'columns' => 1,				
					'mobile' => false,
				)
			), $request_attr
		);
		$this->loaded		= true;
		$this->sID			= 'jvfrm_home_scd' . md5( wp_rand( 0 , 500 ) .time() );
		$this->is_mobile	= (boolean) $attr[ 'mobile' ];
		$this->numCols	= intVal( $attr[ 'columns' ] );

		// Shortcode Enqueues & Scripts
		add_action( 'wp_footer', Array( $this, 'scripts' ) );

		return $this->output( $attr );
	}

	/*
	Search shortcode container class
	 */
	public function classes() {
		$arrOutput				= Array(
			'javo-shortcode',
			'shortcode-' . get_class( $this ),
			'column-' . $this->numCols,
			'active',
		);
		$arrOutput				= Array_Map( 'trim', $arrOutput );
		if( $this->is_mobile )
			$arrOutput[]		= 'is-mobile';
		$strOutput				= join( ' ', $arrOutput );
		printf( " class=\"%s\" ", $strOutput );
	}

	/*
	Keyword output
	 */

	public function keyword( $attr=Array() ) {
		$this->is_keyword_active = true;
		printf( "<input type=\"text\" name=\"%s\" placeholder=\"%s\" class=\"form-control\">"
			, 'keyword'
			, esc_html__( "Keyword", 'javohome' )
		);
	}

	public function tags_object( $attr=Array() ) {

		if( !$this->is_keyword_active )
			return false;

		$arrTerms = $attr[ 'keyword_auto' ] != 'disable' ?
			get_terms( 'listing_keyword', Array( 'fields' => 'names' ) ) : Array();


		/* printf(
			'<input type="hidden" data-tags=\'%1$s\'>',
			json_encode( $arrTerms )
		); */

		printf(
			'<script type="text/javascript">var jvfrm_home_search1_tags=%1$s;</script>',
			json_encode( $arrTerms )
		);
	}

	/*
	Google address search output
	 */
	public function google_search() {
		printf( "
			<div class=\"javo-search-form-geoloc\">
				<input type=\"text\" name=\"%s\" class=\"form-control\">
				<i class=\"fa fa-map-marker javo-geoloc-trigger\"></i>
			</div>"
			, 'radius_key'
		);
	}

	/*
	Listing category output
	 */
	public function property_type() {
		printf( "<select name=\"%s\" class=\"form-control\" data-selectize>
			<option value=''>%s</option>%s</select>"
			, 'category'
			,  esc_html__( "All Categories", 'javohome' )
			, apply_filters( 'jvfrm_home_get_selbox_child_term_lists', 'property_type', null, 'select', false, 0, 0, '-' )
		);
	}

	/*
	Listing location output
	 */
	public function property_status() {
		printf( "<select name=\"%s\" class=\"form-control\" data-selectize>
			<option value=''>%s</option>%s</select>"
			, 'location'
			,  esc_html__( "All Location", 'javohome' )
			, apply_filters( 'jvfrm_home_get_selbox_child_term_lists', 'property_status', null, 'select', false, 0, 0, '-' )
		);
	}

	/*
	Amenities output
	 */
	public static function amenities( $attr=Array(), $columns=3 )
	{
		$strColumns = 'col-md-' . intVal( 12 / $columns );

		if(  $arrAmenities	= get_terms( 'property_amenities', Array( 'fields' => 'id=>name', 'hierarchical'=>false ) ) ){
			echo "<div class=\"row search-box-block\">";
			foreach( $arrAmenities as $id => $name )
			{
				printf( "
					<div class=\"%1\$s\">
						<label>
							<input type=\"checkbox\" name=\"%2\$s[]\" value=\"{$id}\">
							{$name}
						</label>
					</div>",
					$strColumns,
					'amenity'
				);
			}
			echo "</div>";
		}else{
			esc_html_e( "Not Found Any Amenities", 'javohome' );
		}
	}

	/*
	Title for search shortcode
	 */
	public static function getHeader( $param )
	{
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

	/*
	Shortcode output
	 */
	public function output( $attr )
	{
		global $jvfrm_home_filter_prices, $jvfrm_home_tso;
		/*
		$intBorderWidth	= intVal( $attr[ 'border_width' ] );
		$strBorderCSS		= '';
		if( $intBorderWidth > 0 ) {
			$strBorderCSS	= " style=\"border:solid {$intBorderWidth}px {$attr[ 'border_color' ]};\" ";
		}
		*/
		$strRequester	= apply_filters( 'jvfrm_home_wpml_link', intVal( $attr[ 'query_requester' ] ) );

		if( !class_exists( 'Lava_RealEstate_Manager' ) )
			return sprintf(
				'<p align="center">%s</p>',
				esc_html__( "Please, active to the 'Lava Directory manager' plugin", 'javohome' )
			);

		$arrButtonStyles	= Array();
		$arrButtonClass		= Array(
			'btn',
			'btn-block',
			'jv-submit-button'
		);

		$strButtonStyles = $strButtonClass = '';

		if( $attr[ 'button_bg_color' ] != '' )
			$arrButtonStyles[ 'background-color' ] = $attr[ 'button_bg_color' ];

		if( $attr[ 'button_text_color' ] != '' )
			$arrButtonStyles[ 'color' ] = $attr[ 'button_text_color' ];

		if( empty( $arrButtonStyles ) )
			$arrButtonClass[] = 'admin-color-setting';

		$strButtonClass = join( ' ', $arrButtonClass );
		if( !empty( $arrButtonStyles ) ) : foreach( $arrButtonStyles as $strProperty => $strValue ){
			$strButtonStyles .= "{$strProperty}:{$strValue};";
		} endif;


		ob_start();?>
		<div id="<?php echo sanitize_html_class( $this->sID ); ?>" <?php $this->classes(); ?>>
			<?php self::getHeader( $attr ); ?>

			<div class="search-type-a-wrap">
				<form method="get" action="<?php echo esc_attr( $strRequester );?>" class="search-type-a-form">

					<div class="jv-search1-search-fields search-type-a-inner">
						<div class="row jv-search1-top-row">
							<?php
							$intColumnWidth = floor( 100 / intVal( $attr[ 'columns' ] ) ) . '%';
							for( $intCount=1; $intCount <= intVal( $attr[ 'columns' ] ); $intCount++ ){
								if( !empty( $attr[ 'column1' ] ) ) {
									echo "<div class=\"search-box-inline\" style=\"width:{$intColumnWidth};\">";
									if( isset( $attr[ 'column' . $intCount ] ) ) {
										do_action( 'jvfrm_home_search1_element_' . $attr[ 'column' . $intCount ], $attr );
									}
									echo "</div>";
								}
							}
							if( $this->is_mobile ) {
								printf(
									'<button type="button" class="btn btn-sm %1$s">
										<span class="more-filters">
											<i class="glyphicon glyphicon-chevron-down"></i> %2$s
										</span>
										<span class="less-filters">
											<i class="glyphicon glyphicon-chevron-up"></i> %2$s
										</span>
									</button>',
									'jv-search1-morefilter-opener',
									__( "Amenities", 'javohome' )
								);

								echo '<div class="jv-search1-morefilter-row" style="display:none;">
										<div class="col-md-8">';

								do_action( 'jvfrm_home_search1_element_property_amenities', $attr );
								echo '</div><!-- /.col-md-8 //--></div><!-- /.row //-->';
							} ?>
							<div class="search-box-inline">
								<button type="submit" class="<?php echo $strButtonClass; ?>" style="<?php echo $strButtonStyles; ?>"><?php esc_html_e( "Search", 'javohome');?></button>
							</div>
							<?php do_action( 'jvfrm_home_search1_submit_after', $attr ); ?>
						</div> <!-- rows -->
						<div class="bottom-amenities">
							<div class="bottom-amenities-content">
								<?php do_action( 'jvfrm_home_search1_element_property_amenities', $attr ); ?>
								<div class="bottom-amenities-opener">
									<div class="bottom-amenities-opener-button">
										<span class="icon"></span>
									</div>
								</div>
							</div>
						</div>
					</div> <!-- jv-search1-search-fields -->
				</form>
			</div>
		</div>
	<?php
		$arrOutput		= Array();
		$arrOutput[]	= "<script type=\"text/javascript\">";
		$arrOutput[]	= "jQuery( function($){ $.jvfrm_home_search_shortcode( '#{$this->sID}' ); });";
		$arrOutput[]	= "</script>";
		echo join( '', $arrOutput );
		return ob_get_clean();
	}

	/*
	Enqueue script
	 */
	public function scripts() {
		if( !$this->loaded )
			return;

		wp_enqueue_script( 'jQuery-nouiSlider' );
		wp_enqueue_script( 'selectize-script' );
		wp_enqueue_script( 'jquery-type-header' );
		wp_enqueue_script( sanitize_title( 'jv-jquery.javo_search_shortcode.js' ) );
	}
}

/*
Instance for shorcode class
 */

if( !function_exists( 'jvfrm_home_search1_init') ){
	function jvfrm_home_search1_init() {
		$GLOBALS[ 'jvfrm_home_search1' ] = new jvfrm_home_search1;
	}
	add_action( 'after_setup_theme', 'jvfrm_home_search1_init' );
}