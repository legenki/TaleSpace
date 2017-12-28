<?php
/**
 * @package   The_Grid
 * @author    Themeone <themeone.master@gmail.com>
 * @copyright 2015 Themeone
 *
 * Skin: Male
 *
 */

// Exit if accessed directly
if (!defined('ABSPATH')) { 
	exit;
}

$tg_el = The_Grid_Elements();
$jv_el = JV_The_Grid_Elements(); // Get Javo Elements

$permalink = $tg_el->get_the_permalink();
$target    = $tg_el->get_the_permalink_target();
$colors    = $tg_el->get_colors();

$media_args = array(
	'icons' => array(
		'image' => '<i class="tg-icon-arrows-out-2"></i>'
	)
);

$terms_args = array(
	'color' => 'color',
	'separator' => ', '
);

$media_button = $tg_el->get_media_button($media_args);

$output = $tg_el->get_media_wrapper_start('tg-item-front');
	$output .= '<div class="tg-item-front-inner">'; 
		$output .= $tg_el->get_media();
	$output .= '</div>';
$output .= $tg_el->get_media_wrapper_end();
$output .= $tg_el->get_content_wrapper_start('tg-item-back '.$colors['overlay']['class']);	
	$output .= '<div class="tg-item-back-inner">';
		$output .= $tg_el->get_overlay();
		$output .= $jv_el->get_jv_rating_ave(); // Jv rating
		$output .= $tg_el->get_center_wrapper_start();	
			$output .= ($permalink && $media_button) ? '<a class="tg-item-link" href="'.$permalink .'" target="'.$target.'"></a>' : null;
			$output .= $tg_el->get_the_title();	
			$output .= $jv_el->get_jv_category();  // Jv Category
			$output .= $jv_el->get_jv_location();  // Jv Location
			//$output .= $tg_el->get_the_terms($terms_args);
		$output .= $tg_el->get_center_wrapper_end();
		$output .= $media_button;
	$output .= '</div>';
$output .= $tg_el->get_content_wrapper_end();	
		
return $output;