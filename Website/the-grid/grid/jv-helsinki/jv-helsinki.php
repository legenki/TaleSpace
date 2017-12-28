<?php
/**
 * @package   The_Grid
 * @author    Themeone <themeone.master@gmail.com>
 * @copyright 2015 Themeone
 *
 * Skin: JV-Helsinki
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

$output = $tg_el->get_media_wrapper_start();
	$output .= "<div class='col-md-4'>". $tg_el->get_media() ."</div>";
	$output .= "<div class='col-md-8'>". $tg_el->get_the_excerpt() ."</div>";
	//$output .= $tg_el->get_overlay();
	$output .= $tg_el->get_center_wrapper_start();	
		$output .= ($link_button && $media_button) ? '<a class="tg-item-link" href="'.$permalink .'" target="'.$target.'"></a>' : null;
		$output .= $media_button;
		$output .= $link_button;		
	$output .= $tg_el->get_center_wrapper_end();
	if (!empty($social_buttons)) {
			$output .= '<div class="tg-share-icons">';
				foreach ($social_buttons as $url) {
					$output .= $url;
				}
			$output .= '</div>';
	}	
	$output.= "<div class='jv-price'>". $jv_el->get_jv_price_raw() ."</div>";
$output .= $tg_el->get_media_wrapper_end();

$output .= $tg_el->get_content_wrapper_start();
	$output .= $tg_el->get_the_title();	
	//$output .= $tg_el->get_the_terms($terms_args);
	$output.= "<div class='jv-meta-wrap row'><div class='col-md-4'><i class='icon-icon-bed'></i><span class='jv-meta jv-meta-bed'>". $jv_el->get_jv_bedrooms_raw() ."</span></div>";
	$output.= "<div class='col-md-4'><i class='icon-icon-bath'></i><span class='jv-meta jv-meta-bath'>". $jv_el->get_jv_bathrooms_raw() ."</span></div>";
	$output.= "<div class='col-md-4'><i class='icon-icon-garage'></i><span class='jv-meta jv-meta-garage'>". $jv_el->get_jv_garages_raw() ."</span></div></div>"; 
	$output .= $tg_el->get_the_likes_number();
$output .= $tg_el->get_content_wrapper_end();	
		
return $output;


