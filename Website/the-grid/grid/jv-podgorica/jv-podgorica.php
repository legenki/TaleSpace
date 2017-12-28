<?php
/**
 * @package   The_Grid
 * @author    Themeone <themeone.master@gmail.com>
 * @copyright 2015 Themeone
 *
 * Skin: Podgorica
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
		'image' => '<i class="tg-icon-arrows-out"></i>'
	)
);

$colors = $tg_el->get_colors();
$media_button = preg_replace('/(<i\b[^><]*)>/i', '$1 style="color:'.$colors['overlay']['background'].'">', $tg_el->get_media_button($media_args));

$output = $tg_el->get_media_wrapper_start();
	$output .= $tg_el->get_media();
	//$output .= $jv_el->get_jv_rating_ave(); // Jv rating
	//$output .= '<div class="tg-jv-tax-wrap">';
		//$output .= $jv_el->get_jv_category();  // Jv Category
		//$output .= $jv_el->get_jv_location();  // Jv Location
	//$output .= '</div>';
	$output .= $media_button;
	$output .= $tg_el->get_the_duration();
$output .= $tg_el->get_media_wrapper_end();

return $output;