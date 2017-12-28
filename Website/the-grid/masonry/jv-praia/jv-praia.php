<?php
/**
 * @package   The_Grid
 * @author    Themeone <themeone.master@gmail.com>
 * @copyright 2015 Themeone
 *
 * Skin: Praia
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

$excerpt_args = array(
	'length' => 200
);

$author_args = array(
	'prefix' => __( 'By', 'tg-text-domain' ).' ',
);

$link_arg = array(
	'icon' => '<i class="tg-icon-add"></i>'.__( 'Read More', 'tg-text-domain' )
);

$media_args = array(
	'icons' => array(
		'image' => '<i class="tg-icon-add"></i>',
		'audio' => '<i class="tg-icon-play"></i>'.__( 'Play Song', 'tg-text-domain' ),
		'video' => '<i class="tg-icon-play"></i>'.__( 'Play Video', 'tg-text-domain' ),
	)
);

$base  = new The_Grid_Base();
$color = $colors['overlay']['background'];
$gradient = null;
if (!empty($color)) {
	$color = str_replace(array('#','(',')','rgba','rgb'), array('','','','',''), $color);
	if (preg_match("/^([a-f0-9]{3}|[a-f0-9]{6})$/i",$color)) {
		$color3 = $color;
		$color  = $base->HEX2RGB($color,$alpha=1);
		$color1 = $color['red'].','.$color['green'].','.$color['blue'];
		$color2 = $color1.',1';	
	} else {
		$color = explode(',', $color);
		$alpha = (isset($color[3])) ? $color[3] : 1;
		$color1 = $color[0].','.$color[1].','.$color[2];
		$color2 = $color1.','.$alpha;
		$color3 = $base->RGB2HEX($color);	
	}
	$gradient = 'style="background:transparent;background: linear-gradient(top, rgba('.$color1.',0) 0%, rgba('.$color2.') 100%);background: -moz-linear-gradient(top, rgba('.$color1.',0) 0%, rgba('.$color2.') 100%);background: -ms-linear-gradient(top, rgba('.$color1.',0) 0%, rgba('.$color2.') 100%);background: -o-linear-gradient( top, rgba('.$color1.',0) 0%, rgba('.$color2.') 100%);background: -webkit-linear-gradient( top, rgba('.$color1.',0) 0%, rgba('.$color2.') 100%);-ms-filter: progid:DXImageTransform.Microsoft.gradient(startColorstr=#00'.$color3.', endColorstr=#ff'.$color3.');filter: progid:DXImageTransform.Microsoft.gradient(startColorstr=#00'.$color3.', endColorstr=#ff'.$color3.');"';
}


if ($format == 'quote' || $format == 'link') {
	
	$bg_img = $tg_el->get_attachement_url();

	$output  = ($bg_img) ? '<div class="tg-item-image-holder"><div class="tg-item-image" style="background-image: url('.esc_url($bg_img).')"></div></div>' : null;
	$output .= $tg_el->get_content_wrapper_start('tg-panZ');
		$output .= '<i class="tg-'.$format.'-icon tg-icon-'.$format.'" style="color:'.$colors['content']['title'].'"></i>';
		$output .= ($format == 'quote') ? $tg_el->get_the_quote_format() : $tg_el->get_the_link_format();
		$output .= preg_replace('/(<span\b[^><]*)>/i', '$1 style="color:'.$colors['content']['title'].'">', $tg_el->get_the_date());
	$output .= $tg_el->get_content_wrapper_end();
	
	return $output;
	
} else {
	
	$media_content = $tg_el->get_media();
	$media_button  = $tg_el->get_media_button($media_args);
	$link_button   = $tg_el->get_link_button($link_arg);
	$author        = $tg_el->get_the_author($author_args);
	
	$content_class = ($media_button) ? $colors['overlay']['class'] : $colors['content']['class'].' no-image';
	$author_color  = ($media_button) ? $colors['overlay']['title'] : $colors['content']['title'];

	$content_wrapper = $tg_el->get_content_wrapper_start($content_class);
	$content_wrapper = str_replace('tg-item-content-holder light', 'tg-item-content-holder', $content_wrapper);
	$content_wrapper = str_replace('tg-item-content-holder dark', 'tg-item-content-holder', $content_wrapper);

	$output = '<div class="tg-panZ">';
	
		if ($media_content) {
			$output .= $tg_el->get_media_wrapper_start();
				$output .= $media_content;
				$output .= $jv_el->get_jv_rating_ave(); // Jv rating
			$output .= $tg_el->get_media_wrapper_end();
			$output .= ($media_button) ? '<div class="tg-item-overlay" '.$gradient.'></div>' : null;
		}
		
		$output .= $content_wrapper;
			$output .= '<div class="tg-item-content-inner">';
				$output .= $tg_el->get_the_title();
				$output .= '<div class="tg-jv-tax-wrap">';
					$output .= $jv_el->get_jv_category();  // Jv Category
					$output .= $jv_el->get_jv_location();  // Jv Location
				$output .= '</div>';
				$output .= (!$media_content) ? $tg_el->get_the_excerpt($excerpt_args) : null;
				$output .= $tg_el->get_the_date();
				$output .= preg_replace('/(<a\b[^><]*)>/i', '$1 style="color:'.$author_color.'">', $author);
				$output .= ($media_content && in_array($format, array('video', 'audio'))) ? $media_button : null;
				$output .= ($media_content && $link_button && !in_array($format, array('video', 'audio'))) ? $link_button : null;
			$output .= '</div>';
		$output .= $tg_el->get_content_wrapper_end();
		
	$output .= '</div>';
	
	return $output;
}