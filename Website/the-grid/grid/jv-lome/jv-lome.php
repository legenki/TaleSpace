<?php
/**
 * @package   The_Grid
 * @author    Themeone <themeone.master@gmail.com>
 * @copyright 2015 Themeone
 *
 * Skin: JV-Lome
 *
 */

// Exit if accessed directly
if (!defined('ABSPATH')) { 
	exit;
}

$tg_el = The_Grid_Elements();
$jv_el = JV_The_Grid_Elements(); // Get Javo Elements

$format    = $tg_el->get_item_format();
$permalink = $tg_el->get_the_permalink();
$target    = $tg_el->get_the_permalink_target();

$output = $tg_el->get_media_wrapper_start();
	$output .= $tg_el->get_media();
	$output .= $tg_el->get_overlay();
	$output .= '<div class="tg-item-content">';
		$output .= $tg_el->get_center_wrapper_start();	
			$output .= ($permalink && !in_array($format, array('audio', 'video'))) ? '<a class="tg-item-link" href="'.$permalink .'" target="'.$target.'"></a>' : null;	
			//$output .= $tg_el->get_the_date();	
			$output.= $jv_el->get_jv_type(); // Jv type
			$output.= $jv_el->get_jv_location(); // Jv Location	
			$output .= $tg_el->get_the_title();
		$output .= $tg_el->get_center_wrapper_end();
		$output .= ($permalink && in_array($format, array('audio', 'video'))) ? $tg_el->get_media_button() : null;	
	$output .= '</div>';	
$output .= $tg_el->get_media_wrapper_end();
		
return $output;