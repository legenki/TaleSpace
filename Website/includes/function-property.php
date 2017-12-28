<?php

function jvfrm_home_single_navigation(){
	return apply_filters(
		'jvfrm_home_detail_item_nav'
		, Array(
			'page-style'				=> Array(
				'label'					=> esc_html__( "Top", 'javohome' )
				, 'class'				=> 'glyphicon glyphicon-home'
				, 'type'				=> Array( get_post_type() )
			)
		)
	);
}

/**
 *
 */
function jvfrm_home_single_map_switcher()
{
	$arrOptions					= Array(
		'option-map'				=> Array(
			'label'					=> esc_html__( "Map", 'javohome' )
			,'target'					=> '#lava-single-map-area'
			, 'comment'			=> ''
			, 'active'				=> true
		)
		, 'option-streetview'	=> Array(
			'label'					=> esc_html__( "StreetView", 'javohome' )
			,'target'					=> '#lava-single-streetview-area'
			, 'comment'			=> esc_html__( "This location is not supported by google StreetView or the location did not add.", 'javohome' )
		)
	);
	echo "<ul class=\"jv-single-property-map-switcher hidden\">";
	if( !empty( $arrOptions ) ) foreach( $arrOptions as $optionName => $optionMeta ) {
		$isActive			= isset( $optionMeta[ 'active' ] );
		$strListActive	= $isActive ? ' active' : null;
		echo "<li class=\"switch-option-item {$optionName}{$strListActive}\"" . ' ';
		echo "data-target=\"{$optionMeta['target']}\" data-comment=\"{$optionMeta['comment']}\">";
		echo "{$optionMeta['label']}</li>";
	}
	echo "</ul>";
	?>

	<script type="text/javascript">
	jQuery( function( $ ){
		"use strict";
		$( document ).on( 'lava:single-msp-setup-after',
			function( e, obj ) {
				var
					switcher_wrap = $( ".jv-single-property-map-switcher" ),
					switcher = $( ".switch-option-item", switcher_wrap ),
					btnStreetView = $( ".option-streetview", switcher_wrap );

				switcher_wrap.removeClass( 'hidden' );

				if( !obj.panoramaAllow ){
					btnStreetView.tooltip({ title:btnStreetView.data( 'comment' ) });
						return false;
				}
				switcher.on( 'click', function( e ) {
					var
						map				= obj.map.gmap3( 'get' )
						, pano			= map.getStreetView();

					if( $( this ).hasClass( 'active' ) )
						return;

					$( "#lava-single-map-area, #lava-single-streetview-area" ).addClass( 'hidden' ).hide();
					switcher.removeClass( 'active' );
					$( this ).addClass( 'active' );
					$( $( this ).data( 'target' ) ).removeClass( 'hidden' ).fadeIn();
					obj.map.gmap3({ trigger:'resize' });
					pano.setVisible( true );
				} );
			}
		);
	} );
	</script>

	<?php
}

function get_single_addon_options($post_id = 0){
	if($post_id == 0){
		return false;
	}else{
		$single_addon_options = (array)get_post_meta( $post_id, 'javo_property_single_field', true );
		if(!isset($single_addon_options['featured_height'])) $single_addon_options['featured_height'] = '';
		if(!isset($single_addon_options['disable_detail_section'])) $single_addon_options['disable_detail_section'] = '';
		if(!isset($single_addon_options['background_transparent'])) $single_addon_options['background_transparent'] = '';
		if(!isset($single_addon_options['spy_nav_background'])) $single_addon_options['spy_nav_background'] = '';
		if(!isset($single_addon_options['spy_nav_font_color'])) $single_addon_options['spy_nav_font_color'] = '';
		if(!isset($single_addon_options['header_background'])) $single_addon_options['header_background'] = '';
		return $single_addon_options;
	}
}

if( !function_exists( 'jvfrm_home_has_attach' ) ) : function jvfrm_home_has_attach(){
	global $post;
	return !empty( $post->attach );
} endif;

if( !function_exists( 'jvfrm_home_get_reportShortcode' ) ) : function jvfrm_home_get_reportShortcode(){
	global $lava_report_shortcode;
	return $lava_report_shortcode;
} endif;

if( !function_exists( 'jvfrm_home_getSearch1_Shortcode' ) ) : function jvfrm_home_getSearch1_Shortcode(){
	global $jvfrm_home_search1;
	return $jvfrm_home_search1;
} endif;