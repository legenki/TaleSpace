<?php
/**
* Custom codes for Visual Composet
* 1. Grid Builder
*/


/** [ 1. Grid Builder ] **/
/** vc grid builder - listing category **/
add_filter( 'vc_grid_item_shortcodes', 'jvfrm_home_property_type_add_grid_shortcode' );
function jvfrm_home_property_type_add_grid_shortcode( $shortcodes ) {
   $shortcodes['jvfrm_home_list_category'] = array(
     'name' => __( 'List category', 'javohome' ),
     'base' => 'jvfrm_home_list_category',
     'category' => __( 'Content', 'javohome' ),
     'description' => __( 'Show List Category. Only for Javo Listings (property).', 'javohome' ),
     'post_type' => Vc_Grid_Item_Editor::postType(),
  );

   return $shortcodes;
}

add_filter( 'vc_gitem_template_attribute_property_type', 'jvfrm_home_gitem_attr_property_type', 10, 2 );
function jvfrm_home_gitem_attr_property_type( $value, $data ){
	global $post;
	$strOutput = false;
	if( get_post_type( $post->ID ) == jvfrm_home_core()->slug ) {
		$arrTerms = wp_get_object_terms( $post->ID, 'property_type', array( 'fields' => 'names' ));
		$strOutput = join( ', ', $arrTerms );
	}
	return $strOutput;
}

// output function
add_shortcode( 'jvfrm_home_list_category', 'jvfrm_home_list_category_render' );
function jvfrm_home_list_category_render() {
	return '<div class="jv_vc_gi_property_status">{{ property_type }}</div>';
}



/** vc grid builder - listing location **/
add_filter( 'vc_grid_item_shortcodes', 'jvfrm_home_property_status_add_grid_shortcode' );
function jvfrm_home_property_status_add_grid_shortcode( $shortcodes ) {
   $shortcodes['jvfrm_home_list_location'] = array(
     'name' => __( 'List location', 'javohome' ),
     'base' => 'jvfrm_home_list_location',
     'location' => __( 'Content', 'javohome' ),
     'description' => __( 'Show List location. Only for Javo Listings (property).', 'javohome' ),
     'post_type' => Vc_Grid_Item_Editor::postType(),
  );

   return $shortcodes;
}

add_filter( 'vc_gitem_template_attribute_property_status', 'jvfrm_home_gitem_attr_property_status', 10, 2 );
function jvfrm_home_gitem_attr_property_status( $value, $data ){
	global $post;
	$strOutput = false;
	if( get_post_type( $post->ID ) == jvfrm_home_core()->slug ) {
		$arrTerms = wp_get_object_terms( $post->ID, 'property_status', array( 'fields' => 'names' ));
		$strOutput = join( ', ', $arrTerms );
	}
	return $strOutput;
}

// output function
add_shortcode( 'jvfrm_home_list_location', 'jvfrm_home_list_location_render' );
function jvfrm_home_list_location_render() {
	return '<div class="jv_vc_gi_property_status">{{ property_status }}</div>';
}