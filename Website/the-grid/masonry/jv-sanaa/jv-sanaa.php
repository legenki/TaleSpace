<?php
/**
 * @package   The_Grid
 * @author    Themeone <themeone.master@gmail.com>
 * @copyright 2015 Themeone
 *
 * Skin: Sanaa
 *
 */

// Exit if accessed directly
if (!defined('ABSPATH')) { 
	exit;
}

$tg_el = The_Grid_Elements();
$jv_el = JV_The_Grid_Elements(); // Get Javo Elements

// main data
$colors       = $tg_el->get_colors();
$media_image  = $tg_el->get_attachement_url();
$link_button  = $tg_el->get_link_button();
$permalink    = $tg_el->get_the_permalink();
$target       = $tg_el->get_the_permalink_target();
$background   = 'style="background:'.$colors['overlay']['title'].'"';
$cart_loader  = '<div class="tg-woo-loading"><span class="dot1" '.$background.'></span><span class="dot2" '.$background.'></span></div>';
// product data
$product_cart     = str_replace('</div>',$cart_loader.'</div>',$tg_el->get_product_cart_button());
$product_price    = $tg_el->get_product_price();
$product_wishlist = $tg_el->get_product_wishlist();

$media_content = $tg_el->get_media();

$output = null;

if ($media_content) {
	
	$output .= $tg_el->get_media_wrapper_start();
		$output .= $media_content;
		$output .= ($media_image && $permalink ) ? '<a class="tg-woo-link" href="'.$permalink .'" target="'.$target.'"></a>' : null;
		$output .= ($media_image) ? $tg_el->get_product_on_sale() : null;
		$output .= ($media_image) ? $tg_el->get_product_rating() : null;
		$output .= ($media_image && $product_cart) ? '<div class="tg-item-cart-holder">' : null;
			$output .= ($media_image && $product_cart) ? $tg_el->get_overlay() : null;
			$output .= ($media_image && $product_cart) ? preg_replace('/(<a\b[^><]*)>/i', '$1 style="color:'.$colors['overlay']['title'].'">', $product_cart) : null;
		$output .= ($media_image && $product_cart) ? '</div>' : null;
		$output .= $jv_el->get_jv_rating_ave(); // Jv rating
	$output .= $tg_el->get_media_wrapper_end();

}
	
$output .= $tg_el->get_content_wrapper_start();
	$output .= $tg_el->get_the_title();
	$output .= preg_replace('/(<span\b[^><]*)>/i', '$1 style="color:'.$colors['content']['title'].'">', $product_price);	
	$output .= $jv_el->get_jv_category();  // Jv Category
	$output .= $jv_el->get_jv_location();  // Jv Location
	
	$output .= preg_replace('/(<a\b[^><]*)>/i', '$1 style="color:'.$colors['content']['span'].'">', $product_wishlist);
$output .= $tg_el->get_content_wrapper_end();

return $output;