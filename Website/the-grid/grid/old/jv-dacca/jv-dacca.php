<?php
/**
 * @package   The_Grid
 * @author    Themeone <themeone.master@gmail.com>
 * @copyright 2015 Themeone
 *
 * Skin: Dacca
 *
 */

// Exit if accessed directly
if (!defined('ABSPATH')) { 
	exit;
}

$tg_el = The_Grid_Elements();
$jv_el = JV_The_Grid_Elements(); // Get Javo Elements

$colors    = $tg_el->get_colors();
$permalink = $tg_el->get_the_permalink();
$target    = $tg_el->get_the_permalink_target();

$media_args = array(
	'icons' => array(
		'image' => ' ',
		'audio' => ' ',
		'video' => ' ',
	)
);

$terms_args = array(
	'color' => 'color',
	'separator' => ', '
);


$output = '<div class="tg-atv-anim">';
	$output .= '<div class="tg-atv-shadow"></div>';
	$output .= $tg_el->get_media_wrapper_start();
		$output .= $tg_el->get_media();
	$output .= $tg_el->get_media_wrapper_end();
	$output .= $tg_el->get_overlay();
	$output .= '<div class="tg-item-content-holder tg-item-atv-layer '.$colors['overlay']['class'].'">';
		$output .= '<div class="tg-item-content-inner">';
			$output .= $jv_el->get_jv_rating_ave(); // Jv rating
			$output .= $tg_el->get_center_wrapper_start();	
				$output .= $tg_el->get_the_title();
				//$output .= $tg_el->get_the_terms($terms_args);
				$output .= $jv_el->get_jv_category();  // Jv Category
				$output .= $jv_el->get_jv_location();  // Jv Location
				
			$output .= $tg_el->get_center_wrapper_end();
		$output .= '</div>';
	$output .= '</div>';
	$output .= $tg_el->get_media_button($media_args);
	$output .= ($permalink) ? '<a class="tg-item-link" href="'.$permalink .'" target="'.$target.'"></a>' : null;
$output .= '</div>';
		
return $output;