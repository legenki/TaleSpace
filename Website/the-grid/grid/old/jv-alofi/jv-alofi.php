<?php
/**
 * @package   The_Grid
 * @author    Themeone <themeone.master@gmail.com>
 * @copyright 2015 Themeone
 *
 * Skin: Alofi
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

$output  = $tg_el->get_media_wrapper_start();
	//$output .= $jv_el->get_jv_category();
	//$output .= $jv_el->get_jv_location();
	//$output .= $jv_el->get_jv_rating_ave();	
	$output .= $tg_el->get_media();
	$output .= ($permalink) ? '<a class="tg-item-link" href="'.$permalink .'" target="'.$target.'"></a>' : null;
	
$output .= $tg_el->get_media_wrapper_end();
		
return $output;