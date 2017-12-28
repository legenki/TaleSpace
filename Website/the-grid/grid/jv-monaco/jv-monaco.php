<?php
/**
 * @package   The_Grid
 * @author    Themeone <themeone.master@gmail.com>
 * @copyright 2015 Themeone
 *
 * Skin: JV-Monaco
 *
 */
 
// Exit if accessed directly
if (!defined('ABSPATH')) { 
	exit;
}

$tg_el = The_Grid_Elements();
$jv_el = JV_The_Grid_Elements(); // Get Javo Elements

$terms_args = array(
	'color' => 'color',
	'separator' => ', '
);

$permalink    = $tg_el->get_the_permalink();
$target       = $tg_el->get_the_permalink_target();
$media_button = $tg_el->get_media_button();
$link_button  = $tg_el->get_link_button();
// $social_buttons = $tg_el->get_social_share_links();
$social = $tg_el->get_social_share_links();

$output = $tg_el->get_media_wrapper_start();
	$output .= $tg_el->get_media();
	$output .= sprintf( '<div class="monaco-status">%s</div>', $jv_el->get_jv_status_raw() );
	$output .= sprintf(
		'<div class="monaco-meta"><div class="monaco-type">%s</div><br><div class="monaco-price">%s</div></div>', 
		$jv_el->get_jv_type_raw(), 
		$jv_el->get_jv_price_raw()
	);
	$output .= '<div class="tg-item-overlay-wrap">';
		$output .= $tg_el->get_overlay();




			if ( !empty( $social ) ) {
				$social_button = '<div class="tg-item-share-holder">';
				$social_button .= '<div class="triangle-up-left" style="border-color:'.$colors['overlay']['background'].'"></div>';
				$social_button .= '<i class="tg-icon-reply" style="color:'.$colors['overlay']['title'].'"></i>';
				$social_button .= '<div class="tg-share-icons">';
				foreach ($social as $url) {
					$social_button .= $url;
				}
				$social_button .= '</div>';
				$social_button .= '</div>';
			}


		/*
		if (! empty( $social_buttons ) ) {
			$output .= '<div class="tg-share-icons">';
			foreach ( $social_buttons as $url ) {
				$output .= $url;
			}
			$output .= '</div>';
		} */



		$output .= $social_button;
	$output .= '</div><!-- /.tg-item-overlay-wrap -->';
$output .= $tg_el->get_media_wrapper_end();
$output .= $tg_el->get_content_wrapper_start();
	$output .= '<div class="row">';
		$output .= '<div class="col-md-12">';
			$output .= sprintf( '<strong>%s</strong>', $tg_el->get_the_title() );			
		$output .= '</div><!-- /.col-md-12 -->';
	$output .= '</div><!-- /.row -->';

	$output .= '<div class="row">';
		$output .= '<div class="col-md-12">';
			$output .= sprintf( '<span>%s</span>', $tg_el->get_the_excerpt( Array( 'length' => 50 )) );			
		$output .= '</div><!-- /.col-md-12 -->';
	$output .= '</div><!-- /.row -->';

	$output .= '<div class="row monaco-meta">';
		$output .= '<div class="col-md-3 monaco-meta-field">';
			$output .= sprintf( '<span>%s</span>', $jv_el->get_jv_area_raw() );			
			$output .= esc_html__( "Area", 'javospot' );
		$output .= '</div><!-- /.col-md-3 -->';
		$output .= '<div class="col-md-3 monaco-meta-field">';
			$output .= sprintf( '<span>%s</span>', intVal( $jv_el->get_jv_bedrooms_raw() ) );			
			$output .= esc_html__( "Beds", 'javospot' );
		$output .= '</div><!-- /.col-md-3 -->';
		$output .= '<div class="col-md-3 monaco-meta-field">';
			$output .= sprintf( '<span>%s</span>', intVal( $jv_el->get_jv_bathrooms_raw() ) );			
			$output .= esc_html__( "Baths", 'javospot' );
		$output .= '</div><!-- /.col-md-3 -->';
		$output .= '<div class="col-md-3 monaco-meta-field">';
			$output .= sprintf( '<span>%s</span>', intVal( $jv_el->get_jv_garages_raw() ) );			
			$output .= esc_html__( "Garages", 'javospot' );
		$output .= '</div><!-- /.col-md-3 -->';
	$output .= '</div><!-- /.row -->';
$output .= $tg_el->get_content_wrapper_end();	
		
return $output;


