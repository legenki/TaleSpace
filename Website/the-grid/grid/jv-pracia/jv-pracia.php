<?php
/**
 * @package   The_Grid
 * @author    Themeone <themeone.master@gmail.com>
 * @copyright 2015 Themeone
 *
 * Skin: Pracia
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

$output = $tg_el->get_media_wrapper_start();
	$output .= $tg_el->get_media();
	$output .= $tg_el->get_overlay();
	$output .= $tg_el->get_center_wrapper_start();	
		$output .= ($link_button && $media_button) ? '<a class="tg-item-link" href="'.$permalink .'" target="'.$target.'"></a>' : null;
		$output .= $media_button;
		$output .= $link_button;
		$output .= $jv_el->get_jv_rating_ave(); // Jv rating
	$output .= $tg_el->get_center_wrapper_end();
$output .= $tg_el->get_media_wrapper_end();
$output .= $tg_el->get_content_wrapper_start();
	$output .= $tg_el->get_the_title();	
	$output .= $jv_el->get_jv_category();  // Jv Category
	$output .= $jv_el->get_jv_location();  // Jv Location
	//$output .= $tg_el->get_the_terms($terms_args);
	$output .= $tg_el->get_the_likes_number();
$output .= $tg_el->get_content_wrapper_end();	
		
return $output;