<?php
/**
 * @package   The_Grid
 * @author    Themeone <themeone.master@gmail.com>
 * @copyright 2015 Themeone
 *
 * Skin: Suva
 *
 */

// Exit if accessed directly
if (!defined('ABSPATH')) { 
	exit;
}

$tg_el = The_Grid_Elements();
$jv_el = JV_The_Grid_Elements(); // Get Javo Elements

$colors      = $tg_el->get_colors();
$link_button = $tg_el->get_link_button();
$permalink   = $tg_el->get_the_permalink();
$target      = $tg_el->get_the_permalink_target();
$price       = $tg_el->get_product_price();
$margin      = (empty($price)) ? ' no-margin' : null;

$output = $tg_el->get_media_wrapper_start();
	$output .= $tg_el->get_media();
	$output .= $tg_el->get_product_on_sale();
$output .= $tg_el->get_media_wrapper_end();
$output .= '<div class="tg-item-content-inner '.$colors['overlay']['class'].$margin.'">';	
	$output .= $tg_el->get_overlay();
	$output .= $jv_el->get_jv_rating_ave(); // Jv rating
	$output .= $tg_el->get_center_wrapper_start();
		$output .= ($permalink) ? '<a class="tg-item-link" href="'.$permalink .'" target="'.$target.'"></a>' : null;
		$output .= preg_replace('/(<span\b[^><]*)>/i', '$1 style="color:'.$colors['overlay']['title'].'">', $price);
		$output .= $tg_el->get_the_title();
		$output .= preg_replace('/(<a\b[^><]*)>/i', '$1 style="color:'.$colors['overlay']['title'].'">', $tg_el->get_product_cart_button());
		$output .= $jv_el->get_jv_category();  // Jv Category
		$output .= $jv_el->get_jv_location();  // Jv Location
	$output .= $tg_el->get_center_wrapper_end();
	$output .= $tg_el->get_product_rating();
	$output .= $tg_el->get_product_wishlist();
$output .= '</div>';

return $output;