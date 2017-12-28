<?php
/**
 * @package   The_Grid
 * @author    Themeone <themeone.master@gmail.com>
 * @copyright 2015 Themeone
 *
 * Skin: JV-Tokyo
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

$media_args = array(
	'icons' => array(
		'image' => '<i class="tg-icon-arrows-diagonal"></i>'
	)
);

$permalink = $tg_el->get_the_permalink();
$target    = $tg_el->get_the_permalink_target();
$colors    = $tg_el->get_colors();
$media_button = $tg_el->get_media_button($media_args);
$social_buttons = $tg_el->get_social_share_links();


$output = $tg_el->get_media_wrapper_start();
	$output .= $tg_el->get_media();				
$output .= $tg_el->get_media_wrapper_end();

$output .= '<div class="tg-item-content-holder '.$colors['overlay']['class'].'">';	
	$output .= $tg_el->get_overlay();
	$output .= $tg_el->get_center_wrapper_start();	
		$output .= ($permalink && $media_button) ? '<a class="tg-item-link" href="'.$permalink.'" target="'.$target.'"></a>' : null;
		$output .= $tg_el->get_the_title();	
		//$output .= $tg_el->get_the_terms($terms_args);
		$output.= "<div class='jv-meta-holder'>";
			$output.= "<div class=''>". $jv_el->get_jv_price_raw() ."</div>"; // Jv Price
			$output.= "<div class='row jv-post-meta jv-bed'><div class='col-md-8'><i class='icon-icon-bed'></i><span class='jv-postmeta-name'>". esc_html_e('Bed','javohome') ."</span></div><div class='col-md-4 jv-postmeta-value'><span>". $jv_el->get_jv_bedrooms_raw()."</span></div></div>"; // Jv Bed
			$output.= "<div class='row jv-post-meta jv-bath'><div class='col-md-8'><i class='icon-icon-bath'></i><span class='jv-postmeta-name'>". esc_html_e('Bath','javohome') ."</span></div><div class='col-md-4 jv-postmeta-value'><span>". $jv_el->get_jv_bathrooms_raw()."</span></div></div>"; // Jv Bath
			$output.= "<div class='row jv-post-meta jv-garages'><div class='col-md-8'><i class='icon-icon-garage'></i><span class='jv-postmeta-name'>". esc_html_e('Garage','javohome') ."</span></div><div class='col-md-4 jv-postmeta-value'><span>". $jv_el->get_jv_garages_raw()."</span></div></div>"; // Jv Garages
		$output.= "</div>";		
	$output .= $tg_el->get_center_wrapper_end();
	$output .= $media_button;
	$output .= $tg_el->get_the_likes_number();				
	if (!empty($social_buttons)) {
		$output .= '<div class="tg-share-icons">';
			foreach ($social_buttons as $url) {
				$output .= $url;
			}
		$output .= '</div>';
	}
$output .= '</div>';
		
return $output;