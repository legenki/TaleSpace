<?php
/**
 * @package   The_Grid
 * @author    Themeone <themeone.master@gmail.com>
 * @copyright 2015 Themeone
 *
 * Skin: Lusaka
 *
 */

// Exit if accessed directly
if (!defined('ABSPATH')) { 
	exit;
}

$tg_el = The_Grid_Elements();
$jv_el = JV_The_Grid_Elements(); // Get Javo Elements

$permalink  = $tg_el->get_the_permalink();
$url_target = $tg_el->get_the_permalink_target();
$media      = $tg_el->get_media();


$output  = $tg_el->get_media_wrapper_start();
	$output .= $media;
	$output .= '<div class="tg-jv-tax-wrap">';
		$output .= $jv_el->get_jv_category();  // Jv Category
		$output .= $jv_el->get_jv_location();  // Jv Location
	$output .= '</div>';
	$output .= $jv_el->get_jv_rating_ave(); // Jv rating
	$output .= ($media) ? '<a class="tg-item-link" href="'.$permalink.'" target="'.$url_target.'"></a>' : null;
	
$output .= $tg_el->get_media_wrapper_end();
		
return $output;