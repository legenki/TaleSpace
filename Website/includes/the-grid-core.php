<?php
if( ! function_exists( 'jvfrm_home_thegrid_custom_css' ) ) {
	function jvfrm_home_thegrid_custom_css( $rows ) {
		$rows[] = sprintf(
			'.tg-jv-meta-rating{ background-image:url(%s) !important; }',
			JVFRM_HOME_IMG_DIR . '/star-all.png'
		);
		return $rows;
	}
	add_filter( 'jvfrm_home_custom_css_rows', 'jvfrm_home_thegrid_custom_css' );
}

/**
 * Detect plugin. For use in Admin area only.
 */
function check_lava_plugin() {
	if( function_exists( 'lava_realestate' ) ) {
		add_filter('tg_register_item_skin', function($skins){
			$skins = array_merge($skins,
				array(				
					'jv-lome'=> array(
						'filter' => 'Javo', // filter button name
						'col'    => 1, // col number in preview skin mode
						'row'    => 1  // row number in preview skin mode			
					),
					'jv-tokyo'=> array(
						'filter' => 'Javo', // filter button name
						'col'    => 1, // col number in preview skin mode
						'row'    => 1  // row number in preview skin mode			
					),
					'jv-sydney'=> array(
						'filter' => 'Javo', // filter button name
						'col'    => 1, // col number in preview skin mode
						'row'    => 1  // row number in preview skin mode			
					),
					'jv-helsinki'=> array(
						'filter' => 'Javo', // filter button name
						'col'    => 1, // col number in preview skin mode
						'row'    => 1  // row number in preview skin mode			
					),
					'jv-newdelhi'=> array(
						'filter' => 'Javo', // filter button name
						'col'    => 1, // col number in preview skin mode
						'row'    => 1  // row number in preview skin mode			
					),
					'jv-nuuk'=> array(
						'filter' => 'Javo', // filter button name
						'col'    => 1, // col number in preview skin mode
						'row'    => 1  // row number in preview skin mode			
					),
					'jv-seattle'=> array(
						'filter' => 'Javo', // filter button name
						'col'    => 1, // col number in preview skin mode
						'row'    => 1  // row number in preview skin mode			
					),
					'jv-thailand'=> array(
						'filter' => 'Javo', // filter button name
						'col'    => 1, // col number in preview skin mode
						'row'    => 1  // row number in preview skin mode			
					),
					'jv-melbourne'=> array(
						'filter' => 'Javo', // filter button name
						'col'    => 1, // col number in preview skin mode
						'row'    => 1  // row number in preview skin mode			
					),
					'jv-paris'=> array(
						'filter' => 'Javo', // filter button name
						'col'    => 1, // col number in preview skin mode
						'row'    => 1  // row number in preview skin mode			
					),
					'jv-panama'=> array(
						'filter' => 'Javo', // filter button name
						'col'    => 1, // col number in preview skin mode
						'row'    => 1  // row number in preview skin mode			
					),
					'jv-kampala'=> array(
						'filter' => 'Javo', // filter button name
						'col'    => 1, // col number in preview skin mode
						'row'    => 1  // row number in preview skin mode			
					),
					/**
					'jv-seoul'=> array(
						'filter' => 'Javo', // filter button name
						'col'    => 1, // col number in preview skin mode
						'row'    => 1  // row number in preview skin mode			
					), */
					'jv-czech'=> array(
						'filter' => 'Javo', // filter button name
						'col'    => 1, // col number in preview skin mode
						'row'    => 1  // row number in preview skin mode			
					),
					'jv-belgium'=> array(
						'filter' => 'Javo', // filter button name
						'col'    => 1, // col number in preview skin mode
						'row'    => 1  // row number in preview skin mode			
					),
					'jv-france'=> array(
						'filter' => 'Javo', // filter button name
						'col'    => 1, // col number in preview skin mode
						'row'    => 1  // row number in preview skin mode			
					),
					'jv-monaco'=> array(
						'filter' => 'Javo', // filter button name
						'col'    => 1, // col number in preview skin mode
						'row'    => 1  // row number in preview skin mode			
					),
					'jv-moscow'=> array(
						'filter' => 'Javo', // filter button name
						'col'    => 1, // col number in preview skin mode
						'row'    => 1  // row number in preview skin mode			
					),
					'jv-athens'=> array(
						'filter' => 'Javo', // filter button name
						'col'    => 1, // col number in preview skin mode
						'row'    => 1  // row number in preview skin mode			
					),
					'jv-kathmandu'=> array(
						'filter' => 'Javo', // filter button name
						'col'    => 1, // col number in preview skin mode
						'row'    => 1  // row number in preview skin mode			
					),
				)
			);
			return $skins;
		});

		class JV_The_Grid_Elements {
			public $post_ID;
			public $jv_type;
			public $jv_tax;
			public $lv_rating_average;

			static private $instance = null;
			static public function getInstance() {
				if(self::$instance == null) {
					self::$instance = new self;
				}
				return self::$instance;
			}

			/**
			* To initialize a The_Grid_Elements object
			* @since 1.0.0
			*/
			public function init() {

			}

			public function get_jv_type() {	return "<span class='tg-jv-type'><i class='glyphicon glyphicon-bookmark'></i>". $this->getTermName( 'property_type' ) ."</span>";}
			public function get_jv_location() {return "<span class='tg-jv-location'><i class='glyphicon glyphicon-map-marker'></i>". $this->getTermName( 'property_city' ) ."</span>";}
			public function get_jv_status() {return "<span class='tg-jv-status'><i class='glyphicon glyphicon-map-marker'></i>". $this->getTermName( 'property_status' ) ."</span>";}

			public function get_jv_price() {return "<div class='tg-jv-meta-rating-wrap'><div class='tg-jv-meta-rating'><span>". $this->getPostMeta('_price_prefix') ."</span>". $this->getPostMeta('_price')."</div></div>";}
			//public function get_jv_price_prefix() {return "<div class='tg-jv-meta-rating-wrap'><div class='tg-jv-meta-rating'>". $this->getPostMeta('_price_prefix')."</div></div>";}
			public function get_jv_area() {return "<div class='tg-jv-meta-rating-wrap'><div class='tg-jv-meta-rating'>". $this->getPostMeta('_area')."". $this->getPostMeta('_area_prefix')."</div></div>";}
			//public function get_jv_area_prefix() {return "<div class='tg-jv-meta-rating-wrap'><div class='tg-jv-meta-rating'>". $this->getPostMeta('_area_prefix')."</div></div>";}
			public function get_jv_bedrooms() {return "<div class='tg-jv-meta-rating-wrap'><div class='tg-jv-meta-rating'>". $this->getPostMeta('_bedrooms')."</div></div>";}
			public function get_jv_bathrooms() {return "<div class='tg-jv-meta-rating-wrap'><div class='tg-jv-meta-rating'>". $this->getPostMeta('_bathrooms')."</div></div>";}
			public function get_jv_garages() {return "<div class='tg-jv-meta-rating-wrap'><div class='tg-jv-meta-rating'>". $this->getPostMeta('_garages')."</div></div>";}
			public function get_featured_item() {return "<div class='tg-jv-meta-rating-wrap'><div class='tg-jv-meta-rating'>". $this->getPostMeta('_featured_item')."</div></div>";}
			//public function get_jv_rating_ave() {return "<div class='tg-jv-meta-rating-wrap'><div class='tg-jv-meta-rating' style='width:" . floatVal( ( $this->getPostMeta('rating_average') / 5 ) * 100 )."%;'></div></div>";}
			
			/** Raw **/	
			public function get_jv_type_raw() {	return $this->getTermName( 'property_type' );}
			public function get_jv_location_raw() {return $this->getTermName( 'property_city' );}
			public function get_jv_status_raw() {return $this->getTermName( 'property_status' );}
			
			public function get_jv_price_raw() {return $this->getPostMeta('_price_prefix') ."&nbsp;". $this->getPostMeta('_price');}
			public function get_jv_area_raw() {return $this->getPostMeta('_area')."&nbsp;". $this->getPostMeta('_area_prefix');}
			public function get_jv_bedrooms_raw() {return $this->getPostMeta('_bedrooms');}
			public function get_jv_bathrooms_raw() {return $this->getPostMeta('_bathrooms');}
			public function get_jv_garages_raw() {return $this->getPostMeta('_garages');}

			public function getTermName( $strTaxonomy='' ){
				$the_item_id=The_Grid_Elements()->get_item_ID();
				$arrTerms = wp_get_object_terms( $the_item_id, $strTaxonomy, array( 'fields' => 'names', 'orderby'=>'parent' ));
				$strOutput = join( ', ', $arrTerms );
				return !empty( $arrTerms[0] ) ? $arrTerms[0] : false;
			}
			public function getPostMeta($property_postmeta){
				$the_item_id=The_Grid_Elements()->get_item_ID();
				return get_post_meta( $the_item_id, $property_postmeta, true );
			}

			public function get_meta_wrapper_start() { return '<div class="tg-item-meta-holder">'; }
			public function get_meta_wrapper_end() { return '</div><!-- /.tg-item-meta-holder -->'; }
			public function get_the_meta_table( $args=Array() ) {
				$options = wp_parse_args(
					$args,
					Array(
						'icon' => false,
					)
				);
				$output = null;
				$strIconFormat = $options[ 'icon' ] === true ? '<i class="fa %4$s" aria-hidden="true"></i>' . ' ' : null;
				$strFieldFormat = '<div class="tg-item-meta-field meta-%1$s">' . $strIconFormat . '<span class="tg-item-meta-value">%2$s</span><span class="tg-item-meta-suffix">%3$s</span></div>';
				$meta_args = array(
					'area' => Array( 'suffix' => esc_html__( "Area", 'javohome' ), 'value' => $this->get_jv_area_raw(), 'icon' => 'fa-expand' ),
					'beds' => Array( 'suffix' => esc_html__( "Beds", 'javohome' ), 'value' => $this->get_jv_bedrooms_raw(), 'icon' => 'fa-bed' ),
					'baths' => Array( 'suffix' => esc_html__( "Baths", 'javohome' ), 'value' => $this->get_jv_bathrooms_raw(), 'icon' => 'fa-child' ),
					'garages' => Array( 'suffix' => esc_html__( "Garage", 'javohome' ), 'value' => $this->get_jv_garages_raw(), 'icon' => 'fa-car' ),
				);
				foreach( $meta_args as $metaKey => $metaValue )
					$output .= sprintf( $strFieldFormat, $metaKey, $metaValue[ 'value' ], $metaValue[ 'suffix' ], $metaValue[ 'icon' ] );

				return $output;
			}

		}


		if(!function_exists('JV_The_Grid_Elements')) {
			/**
			* Tiny wrapper function
			* @since 1.0.0
			*/
			function JV_The_Grid_Elements() {
				$to_Item_Content = JV_The_Grid_Elements::getInstance();
				$to_Item_Content->init();
				return $to_Item_Content;
			}
		}
	}// checking lava plugin is activated
}
add_action( 'init', 'check_lava_plugin' );