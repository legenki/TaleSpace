<?php
/**
 * @package   The_Grid
 * @author    Themeone <themeone.master@gmail.com>
 * @copyright 2015 Themeone
 *
 * Skin: JV-Melbourne
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
$social_buttons = $tg_el->get_social_share_links();

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
			$output .= $tg_el->get_center_wrapper_start();	
				$output .= $tg_el->get_the_title();
				$output.= "<div class='jv-meta-wrap row'><div class='col-md-4'><i class='icon-icon-bed'></i><span class='jv-meta jv-meta-bed'>". $jv_el->get_jv_bedrooms_raw() ."</span></div>";
				$output.= "<div class='col-md-4'><i class='icon-icon-bath'></i><span class='jv-meta jv-meta-bath'>". $jv_el->get_jv_bathrooms_raw() ."</span></div>";
				$output.= "<div class='col-md-4'><i class='icon-icon-garage'></i><span class='jv-meta jv-meta-garage'>". $jv_el->get_jv_garages_raw() ."</span></div></div>"; 
				$output.= "<div class='jv-price'>". $jv_el->get_jv_price_raw() ."</div>";
				//$output .= $tg_el->get_the_terms($terms_args);
			$output .= $tg_el->get_center_wrapper_end();
			if (!empty($social_buttons)) {
						$output .= '<div class="tg-share-icons">';
							foreach ($social_buttons as $url) {
						$output .= $url;
							}
						$output .= '</div>';
				}
		$output .= '</div>';
	$output .= '</div>';
	$output .= $tg_el->get_media_button($media_args);
	$output .= ($permalink) ? '<a class="tg-item-link" href="'.$permalink .'" target="'.$target.'"></a>' : null;
$output .= '</div>';
		
return $output;