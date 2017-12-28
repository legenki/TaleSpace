<?php
/**
 * @package   The_Grid
 * @author    Themeone <themeone.master@gmail.com>
 * @copyright 2015 Themeone
 *
 * Skin: Maputo
 *
 */

// Exit if accessed directly
if (!defined('ABSPATH')) { 
	exit;
}

$tg_el = The_Grid_Elements();
$jv_el = JV_The_Grid_Elements(); // Get Javo Elements

$media_args = array(
	'icons' => array(
		'image' => '<i class="tg-icon-search3"></i>',
		'audio' => '<i class="tg-icon-play-2"></i>',
		'video' => '<i class="tg-icon-play-2"></i>'
	)
);

$link_args = array(
	'icon' => '<i></i>'
);

$permalink = $tg_el->get_the_permalink();
$target    = $tg_el->get_the_permalink_target();
$colors    = $tg_el->get_colors();

$media_button = preg_replace('/(<div\b[^><]*)>/i', '$1 style="background-color:'.$colors['overlay']['background'].'">', $tg_el->get_media_button($media_args));
$like_button  = preg_replace('/(<span\b[^><]*)>/i', '$1 style="background-color:'.$colors['overlay']['background'].';color:'.$colors['overlay']['title'].'">', $tg_el->get_the_likes_number());
$like_button  = preg_replace('/(<path\b[^><]*)>/i', '$1 style="stroke:'.$colors['overlay']['title'].' !important">', $like_button);

$comment      = '<div class="tg-item-comment" style="background-color:'.$colors['overlay']['background'].'">';
$comment_link = '<a class="tg-item-comment" href="'.$permalink .'" target="'.$target.'" style="background-color:'.$colors['overlay']['background'].'">';

$output = $tg_el->get_media_wrapper_start();
	$output .= $tg_el->get_media();
	$output .= $tg_el->get_overlay();
	$output .= $jv_el->get_jv_rating_ave(); // Jv rating
	$output .= '<div class="tg-jv-tax-wrap">';
		$output .= $jv_el->get_jv_category();  // Jv Category
		$output .= $jv_el->get_jv_location();  // Jv Location
	$output .= '</div>';
	$output .= $tg_el->get_center_wrapper_start();
		$output .= $media_button;
		$output .= ($permalink) ? $comment_link : $comment;
		$output .= '<i class="tg-icon-chat-2"></i>';
		$output .= '<span style="color:'.$colors['overlay']['title'].'">'.$tg_el->the_comments_number().'</span>';
		$output .= ($permalink) ? '</a>' : '</div>';
		$output .= $like_button;
	$output .= $tg_el->get_center_wrapper_end();
$output .= $tg_el->get_media_wrapper_end();
		
return $output;