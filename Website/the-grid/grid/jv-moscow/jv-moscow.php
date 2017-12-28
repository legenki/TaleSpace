<?php
/**
 * @package   The_Grid
 * @author    Themeone <themeone.master@gmail.com>
 * @copyright 2015 Themeone
 *
 * Skin: JV-Moscow
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
$social_buttons = $tg_el->get_social_share_links();

$output = '<div class="tg-item-title-holder">';
	$output .= $tg_el->get_the_title();	
$output .= '</div><!-- /.tg-item-title-holder -->';
$output .= $tg_el->get_media_wrapper_start();
	$output .= $tg_el->get_media();	
	$output .= sprintf( '<div class="moscow-status">%s</div>', $jv_el->get_jv_status_raw() );
	$output .= sprintf( '<a href="%s" target="%s">', $permalink, $target );
	$output .= $tg_el->get_overlay();
	$output .= sprintf( '</a>' );
$output .= $tg_el->get_media_wrapper_end();
$output .= $tg_el->get_content_wrapper_start();
	$output .= '<div class="moscow-detail">';
		$output .= sprintf(
			'<span class="moscow-detail-price">%s</span> - %s', 
			$jv_el->get_jv_price_raw(),
			$jv_el->get_jv_type_raw()
		);
	$output .= '</div><!-- /.moscow-detail -->';
	$output .= '<div class="row">';
		$output .= '<div class="col-md-12">';
			$output .= $tg_el->get_the_excerpt( Array( 'length' => 50 ) );
		$output .= '</div><!-- /.col-md-12 -->';
	$output .= '</div><!-- /.row -->';	
$output .= $tg_el->get_content_wrapper_end();	

$output .= '<div class="tg-item-meta-holder">';
	$output .= '<div class="moscow-meta-field-row">';
		$output .= '<div class="moscow-meta-field field-area">';
			$output .= sprintf( '<span>%s</span>', $jv_el->get_jv_area_raw() );			
			$output .= esc_html__( "Area", 'javospot' );
		$output .= '</div><!-- /.moscow-meta-field-->';
		$output .= '<div class="moscow-meta-field field-beds">';
			$output .= sprintf( '<span>%s</span>', intVal( $jv_el->get_jv_bedrooms_raw() ) );			
			$output .= esc_html__( "Beds", 'javospot' );
		$output .= '</div><!-- /.moscow-meta-field-->';
		$output .= '<div class="moscow-meta-field field-baths">';
			$output .= sprintf( '<span>%s</span>', intVal( $jv_el->get_jv_bathrooms_raw() ) );			
			$output .= esc_html__( "Baths", 'javospot' );
		$output .= '</div><!-- /.moscow-meta-field-->';
		$output .= '<div class="moscow-meta-field field-garage">';
			$output .= sprintf( '<span>%s</span>', intVal( $jv_el->get_jv_garages_raw() ) );			
			$output .= esc_html__( "Garages", 'javospot' );
		$output .= '</div><!-- /.moscow-meta-field-->';
	$output .= '</div><!-- /.moscow-meta-field-row -->';
$output .= '</div><!-- /.tg-item-meta-holder -->';
		
return $output;


