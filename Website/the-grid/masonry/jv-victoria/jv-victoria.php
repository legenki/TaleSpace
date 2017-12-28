<?php
/**
 * @package   The_Grid
 * @author    Themeone <themeone.master@gmail.com>
 * @copyright 2015 Themeone
 *
 * Skin: Victoria
 *
 */

// Exit if accessed directly
if (!defined('ABSPATH')) { 
	exit;
}

$tg_el = The_Grid_Elements();
$jv_el = JV_The_Grid_Elements(); // Get Javo Elements

$format = $tg_el->get_item_format();
$colors = $tg_el->get_colors();

$author_args = array(
	'prefix' => __( 'By', 'tg-text-domain' ).' ',
);
	
$media_args = array(
	'icons' => array(
		'image' => '<i class="tg-icon-arrows-out-2"></i>'
	)
);

$author = preg_replace('/(<a\b[^><]*)>/i', '$1 style="color:'.$colors['content']['span'].'">', $tg_el->get_the_author($author_args));

if ($format == 'quote' || $format == 'link') {
		
	$bg_img = $tg_el->get_attachement_url();
	
	$output  = ($bg_img) ? '<div class="tg-item-image" style="background-image: url('.esc_url($bg_img).')"></div>' : null;
	$output .= $tg_el->get_content_wrapper_start();
	$output .= '<i class="tg-'.$format.'-icon tg-icon-'.$format.'" style="color:'.$colors['content']['title'].'"></i>';
	$output .= ($format == 'quote') ? $tg_el->get_the_quote_format() : $tg_el->get_the_link_format();
	$output .= $tg_el->get_content_wrapper_end();
	
	return $output;
		
} else {
	
	$media_content = $tg_el->get_media();
	$media_button  = $tg_el->get_media_button($media_args);
	
	$output = null;
	
	if ($media_content) {
		
		$output .= $tg_el->get_media_wrapper_start();
			$output .= $media_content;
			$output .= ($media_button) ? $tg_el->get_center_wrapper_start() : null;
			$output .= ($media_button) ? $tg_el->get_overlay().$media_button : null;
			$output .= ($media_button) ? $tg_el->get_center_wrapper_end() : null;
			$output .= $tg_el->get_the_duration();
			$output .= $jv_el->get_jv_rating_ave(); // Jv rating
		$output .= $tg_el->get_media_wrapper_end();
	
	}
	
	$output .= $tg_el->get_content_wrapper_start();
		$output .= $tg_el->get_the_title();
		$output .= $author;
		$output .= $tg_el->get_the_date();
		$output .= '<div class="tg-jv-tax-wrap">';
			$output .= $jv_el->get_jv_category();  // Jv Category
			$output .= $jv_el->get_jv_location();  // Jv Location
		$output .= '</div>';
		$output .= $tg_el->get_the_views_number();
	$output .= $tg_el->get_content_wrapper_end();
	
	return $output;

}