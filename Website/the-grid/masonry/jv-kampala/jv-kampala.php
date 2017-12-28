<?php
/**
 * @package   The_Grid
 * @author    Themeone <themeone.master@gmail.com>
 * @copyright 2015 Themeone
 *
 * Skin: JV-Kampala
 *
 */

// Exit if accessed directly
if (!defined('ABSPATH')) { 
	exit;
}

$tg_el = The_Grid_Elements();
$jv_el = JV_The_Grid_Elements(); // Get Javo Elements

$format = $tg_el->get_item_format();
$colors = $tg_el->get_colors();
$image  = $tg_el->get_attachment_url();

$terms_args = array(
	'color' => 'color',
	'separator' => ', '
);

$media_args = array(
	'icons' => array(
		'image' => '<i class="tg-icon-add"></i>'
	)
);

if ($format == 'quote' || $format == 'link') {
	
	$output  = ($image) ? '<div class="tg-item-image" style="background-image: url('.esc_url($image).')"></div>' : null;
	$output .= $tg_el->get_content_wrapper_start();
		$output .= $tg_el->get_the_date();
		$output .= ($format == 'quote') ? $tg_el->get_the_quote_format() : $tg_el->get_the_link_format();
		$output .= '<div class="tg-item-footer">';
			$output .= '<i class="tg-'.$format.'-icon tg-icon-'.$format.'" style="color:'.$colors['content']['title'].'"></i>';
			$output .= $tg_el->get_the_likes_number();
		$output .= '</div>';
	$output .= $tg_el->get_content_wrapper_end();
	
	return $output;
		
} 
else {
	
	$output = null;
	$media_content = $tg_el->get_media();
	$social = $tg_el->get_social_share_links();
	
	if ($media_content) {
		$output .= $tg_el->get_media_wrapper_start();
			$output .= $media_content;
			if ($image || in_array($format, array('gallery', 'video'))) {
				$output .= $tg_el->get_center_wrapper_start();
					$output .= '<div class="tg-item-overlay-media" style="background:'.$colors['overlay']['background'].'">';
						$output .= $tg_el->get_media_button();
					$output .= '</div>';
					$link_button = $tg_el->get_link_button();
					if ($link_button) {
						$output .= '<div class="tg-item-overlay-link" style="background:'.$colors['overlay']['background'].'">';
							$output .= $link_button;
						$output .= '</div>';
					}
				$output .= $tg_el->get_center_wrapper_end();
			}
		$output .= $tg_el->get_media_wrapper_end();
	}

	$social_button  = null;
	if (!empty($social)) {
		$social_button = '<div class="tg-item-share-holder">';
			$social_button .= '<div class="triangle-up-left" style="border-color:'.$colors['overlay']['background'].'"></div>';
			$social_button .= '<i class="tg-icon-reply" style="color:'.$colors['overlay']['title'].'"></i>';
			$social_button .= '<div class="tg-share-icons">';
				foreach ($social as $url) {
					$social_button .= $url;
				}
			$social_button .= '</div>';
		$social_button .= '</div>';
	}
	
	$decoration  = '<div class="tg-item-decoration">';
		$decoration .= '<div class="triangle-down-right" style="border-color:'.$colors['content']['background'].'"></div>';
	$decoration .= '</div>';
	
	if ($media_content) {
		$link_button = $tg_el->get_link_button();
		$output .= $tg_el->get_media_wrapper_start();
			$output .= $media_content;
			if ($image || in_array($format, array('gallery', 'video'))) {
				$output .= $tg_el->get_center_wrapper_start();
				$output .= (in_array($format, array('video', 'audio'))) ? $tg_el->get_overlay().$tg_el->get_media_button($media_args) : null;
				$output .= (!in_array($format, array('video', 'audio')) && $link_button) ? $tg_el->get_overlay().$link_button : null;
				$output .= $tg_el->get_center_wrapper_end();
				$output .= $decoration;
				$output .= $social_button;
			}
		$output .= $tg_el->get_media_wrapper_end();
	}
	
	$output .= $tg_el->get_content_wrapper_start();
		//$output .= $tg_el->get_the_date();
		$output.= "<div class='text-center'><span class='jv-term jv-type'>". $jv_el->get_jv_type_raw() ."</span>&nbsp;<span class='jv-term jv-status'>". $jv_el->get_jv_status_raw(). "</span></div>";
		$output .= $tg_el->get_the_title();
		//$output .= $tg_el->get_the_terms($terms_args);
		//$output .= $tg_el->get_the_excerpt();
		$output.= "<div class='text-center'>". $jv_el->get_jv_price_raw()."</div>"; // Jv Price

		$output.= "<div class='row jv-post-meta jv-bed'><div class='col-md-8'><i class='icon-icon-bed'></i><span class='jv-postmeta-name'> BEDS </span></div><div class='col-md-4 jv-postmeta-value'><span>". $jv_el->get_jv_bedrooms_raw()."</span></div></div>"; // Jv Garages
		$output.= "<div class='row jv-post-meta jv-bath'><div class='col-md-8'><i class='icon-icon-bath'></i><span class='jv-postmeta-name'> BATHS </span></div><div class='col-md-4 jv-postmeta-value'><span>". $jv_el->get_jv_bathrooms_raw()."</span></div></div>"; // Jv Garages
		$output.= "<div class='row jv-post-meta jv-garages'><div class='col-md-8'><i class='icon-icon-garage'></i><span class='jv-postmeta-name'> GARAGE </span></div><div class='col-md-4 jv-postmeta-value'><span>". $jv_el->get_jv_garages_raw()."</span></div></div>"; // Jv Garages


		$output .= '<div class="tg-item-footer">';
			//$output .= $tg_el->get_the_comments_number();
			$output.= $jv_el->get_jv_location(); // Jv Location	
			$output .= $tg_el->get_the_likes_number();
		$output .= '</div>';
	$output .= $tg_el->get_content_wrapper_end();

	return $output;

}