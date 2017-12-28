<?php
/**
 * @package   The_Grid
 * @author    Themeone <themeone.master@gmail.com>
 * @copyright 2015 Themeone
 *
 * Skin: Maren
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

$com_args = array(
	'icon' => '<i class="tg-icon-chat"></i>'
);

$author_args = array(
	'prefix' => __( 'By', 'tg-text-domain' ).' ',
);

$readmore_args = array(
	'text' => __( 'Read More', 'tg-text-domain' ).'<i class="tg-icon-arrow-next-thin"></i>',
);

$terms_args = array(
	'color' => 'color',
	'separator' => ', '
);

$comments = preg_replace('/(<a\b[^><]*)>/i', '$1 style="color:'.$colors['content']['span'].'">', $tg_el->get_the_comments_number($com_args));
$comments = preg_replace('/(<i\b[^><]*)>/i', '$1 style="color:'.$colors['content']['span'].'">', $comments);
$author   = preg_replace('/(<a\b[^><]*)>/i', '$1 style="color:'.$colors['content']['span'].'">', $tg_el->get_the_author($author_args));

if ($format == 'quote' || $format == 'link') {
		
	$bg_img = $tg_el->get_attachement_url();
	
	$output  = ($bg_img) ? '<div class="tg-item-image" style="background-image: url('.esc_url($bg_img).')"></div>' : null;
	$output .= $tg_el->get_content_wrapper_start();
		$output .= '<i class="tg-'.$format.'-icon tg-icon-'.$format.'" style="color:'.$colors['content']['title'].'"></i>';
		$output .= $tg_el->get_the_date();
		$output .= ($format == 'quote') ? $tg_el->get_the_quote_format() : $tg_el->get_the_link_format();
		$output .= '<div class="tg-item-footer">';
			$output .= $author;
			$output .= $comments;
		$output .= '</div>';
	$output .= $tg_el->get_content_wrapper_end();
	
	return $output;
		
} else {
	
	$output = null;

	$media_content = $tg_el->get_media();
	$media_button  = $tg_el->get_media_button();
	$link_button   = $tg_el->get_link_button();
	
	if ($media_content) {
		$output .= $tg_el->get_media_wrapper_start();
			$output .= $media_content;
			$output .= ($media_button) ? $tg_el->get_overlay() : null;
			$output .= ($media_button) ? $tg_el->get_center_wrapper_start() : null;
				$output .= ($media_button) ? $media_button : null;
				$output .= ($media_button) ? $link_button : null;
			$output .= ($media_button) ? $tg_el->get_center_wrapper_end() : null;
		$output .= $tg_el->get_media_wrapper_end();
	}
	
	$output .= $tg_el->get_content_wrapper_start();
		$output .= $tg_el->get_the_date();
		//$output .= $tg_el->get_the_terms($terms_args);
		$output .= $tg_el->get_the_title();
		$output .= '<div class="tg-jv-tax-wrap">';
			$output .= $jv_el->get_jv_category();  // Jv Category
			$output .= $jv_el->get_jv_location();  // Jv Location
		$output .= '</div>';
		$output .= $jv_el->get_jv_rating_ave(); // Jv rating
		$output .= $tg_el->get_the_excerpt();
		$output .= $tg_el->get_read_more_button($readmore_args);
		$output .= '<div class="tg-item-footer">';
			$output .= $author;
			$output .= $comments;
		$output .= '</div>';
	$output .= $tg_el->get_content_wrapper_end();
	
	return $output;

}