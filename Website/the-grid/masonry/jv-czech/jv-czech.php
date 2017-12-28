<?php
/**
 * @package   The_Grid
 * @author    Themeone <themeone.master@gmail.com>
 * @copyright 2015 Themeone
 *
 * Skin: JV-Czech
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

$com_args = array(
	'icon' => '<i class="tg-icon-chat"></i>'
);

$author_args = array(
	'prefix' => __( 'By', 'tg-text-domain' ).' ',
	'avatar' => true
);

$terms_args = array(
	'color'     => 'color',
	'separator' => ', '
);

$com_args = array(
	'icon' => '<i class="tg-icon-chat"></i>'
);

$media_args = array(
	'icons' => array(
		'image' => '<i class="tg-icon-add"></i>',
		'audio' => __( 'Play Song', 'tg-text-domain' ),
		'video' => __( 'Play Video', 'tg-text-domain' ),
	)
);

$author = preg_replace('/(<a\b[^><]*)>/i', '$1 style="color:'.$colors['content']['span'].'">', $tg_el->get_the_author($author_args));

if ($format == 'quote' || $format == 'link') {

	$output  = ($image) ? '<div class="tg-item-image" style="background-image: url('.esc_url($image).')"></div>' : null;
	$output .= $tg_el->get_content_wrapper_start();
		$output .= '<i class="tg-'.$format.'-icon tg-icon-'.$format.'" style="color:'.$colors['content']['title'].'"></i>';
		$output .= $tg_el->get_the_date();
		$output .= ($format == 'quote') ? $tg_el->get_the_quote_format() : $tg_el->get_the_link_format();
		$output .= '<div class="tg-item-footer">';
			$output .= $author;
		$output .= '</div>';
	$output .= $tg_el->get_content_wrapper_end();
	
	return $output;
		
} else {

	$output = null;
	$media_content = $tg_el->get_media();
	
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
	
	$output .= $tg_el->get_content_wrapper_start();
		$output .= $tg_el->get_the_title();
		$output.= "<div class='jv-price'>". $jv_el->get_jv_price_raw() ."</div>"; // Jv Price
		$output.= "<div class='row jv-post-meta jv-bed'><div class='col-md-8'><i class='icon-icon-bed'></i><span class='jv-postmeta-name'> BEDS </span></div><div class='col-md-4 jv-postmeta-value'><span>". $jv_el->get_jv_bedrooms_raw()."</span></div></div>"; // Jv Beds
		$output.= "<div class='row jv-post-meta jv-bath'><div class='col-md-8'><i class='icon-icon-bath'></i><span class='jv-postmeta-name'> BATHS </span></div><div class='col-md-4 jv-postmeta-value'><span>".	$jv_el->get_jv_bathrooms_raw()."</span></div></div>"; // Jv Baths
		$output.= "<div class='row jv-post-meta jv-garages'><div class='col-md-8'><i class='icon-icon-garage'></i><span class='jv-postmeta-name'> GARAGE </span></div><div class='col-md-4 jv-postmeta-value'><span>". $jv_el->get_jv_garages_raw()."</span></div></div>"; // Jv Garages
		$output .= '<div class="tg-item-info">';
			//$output .= $tg_el->get_the_date();
			//$output .= $tg_el->get_the_terms($terms_args);
		$output .= '</div>';
		//$output .= $tg_el->get_the_excerpt();
		$output .= '<div class="tg-item-footer">';
			$output .= $tg_el->get_the_likes_number();
			//$output .= $author;
			//$output .= $tg_el->get_the_comments_number($com_args);
		$output .= '</div>';
	$output .= $tg_el->get_content_wrapper_end();
	
	return $output;

}