<?php

// Available options to retrieve and customize markup
$options = array(
	'poster' => true,  // Media poster for audio/video (if false no play buttons will be created)
	'icons' => array(  // set all icons
		'link'       => '<i class="tg-icon-link"></i>', // Button link icon
		'comment'    => '',                             // Comment icon
		'image'      => '<i class="tg-icon-add"></i>',  // Ligthbox icon
		'audio'      => '<i class="tg-icon-play"></i>', // Audio icon
		'video'      => '<i class="tg-icon-play"></i>', // HTML Video icon
		'vimeo'      => '<i class="tg-icon-play"></i>', // Vimeo icon
		'wistia'     => '<i class="tg-icon-play"></i>', // Wistia icon
		'youtube'    => '<i class="tg-icon-play"></i>', // Youtube icon
		'soundcloud' => '<i class="tg-icon-play"></i>', // SoundCloud icon
	),
	'excerpt_length'  => 240,     // Excerpt character length
	'excerpt_tag'     => '...',   // Excerpt more tag
	'read_more'       => '',      // Read more text
	'date_format'     => '' ,     // Date format (https://codex.wordpress.org/Formatting_Date_and_Time)
	'get_terms'       => true,    // Get all post terms (if false $content['terms'] will be empty)
	'term_color'      => 'color', // Get terms color (option: 'color', 'background', 'none'); default 'none'
	'term_link'       => true,    // Add link to term
	'term_separator'  => ', ',    // Term separator
	'author_prefix'   => '',      // Author prefix like 'By',...
	'avatar'          => false    // Add author avatar
);

// If function do not exists, then return immediately
if (!function_exists('The_Grid_Item_Content')) {
	return;
}

// Main Func/Class to retrieve all necessary item content/markup
$content = The_Grid_Item_Content($options);
$jv_content = jvfrm_home_listing_meta_output( Array());

				
$html  = null;

// background image for quote/link
$bg_img = (isset($content['media_data']['url'])) ? '<div class="tg-item-image" style="background-image: url('.$content['media_data']['url'].')"></div>' : null;

if (isset($content['quote_markup'])) {
	
	$html .= $bg_img;
	$html .= $content['content_wrapper_start']; // add content wrapper start (to apply color scheme and contains main info
	$html .= $content['date'];           // get the date markup
	$html .= $content['quote_markup'];   // get the quote markup
	$html .= '<div class="tg-item-footer">';
	$html .= '<i class="tg-quote-icon tg-icon-quote" style="color:'.$content['colors']['content']['title'].'"></i>';
	$html .= $content['post_like'];	     // get the post like markup
	$html .= '</div>';
	$html .= $content['content_wrapper_end'];  // add content wrapper end
	
} else if (isset($content['link_markup'])) {
	
	$html .= $bg_img;
	$html .= $content['content_wrapper_start']; // add content wrapper start (to apply color scheme and contains main info
	$html .= $content['date'];           // get the date markup
	$html .= $content['link_markup'];    // get the link markup
	$html .= '<div class="tg-item-footer">';
	$html .= '<i class="tg-link-icon tg-icon-link" style="color:'.$content['colors']['content']['title'].'"></i>';
	$html .= $content['post_like'];    	 // get the post like markup
	$html .= '</div>';
	$html .= $content['content_wrapper_end'];  // add content wrapper end
	
} else {
	
	$media_button = $content['media_button']; // Lightbox/Play button (depends of the post format)
	$link_button  = $content['link_button'];  // button link
	
	$triangle_bot  = '<div class="tg-item-decoration">';
		$triangle_bot .= '<div class="triangle-down-right" style="border-color:'.$content['colors']['content']['background'].'"></div>';
	$triangle_bot .= '</div>';
	
	if (!empty($content['social_links'])) {
		$triangle_top  = '<div class="tg-item-share-holder">';
			$triangle_top .= '<div class="triangle-up-left" style="border-color:'.$content['colors']['overlay']['background'].'"></div>'; // get overlay background color
			$triangle_top .= '<i class="tg-icon-reply" style="color:'.$content['colors']['overlay']['title'].'"></i>'; // get overlay title color
			$triangle_top .= '<div class="tg-share-icons">';
				$triangle_top .= $content['social_links']['facebook'];  // get facebook share button
				$triangle_top .= $content['social_links']['twitter'];   // get twitter share button
				$triangle_top .= $content['social_links']['google+'];   // get google+ share button
				$triangle_top .= $content['social_links']['pinterest']; // get pinterest share button
			$triangle_top .= '</div>';
		$triangle_top .= '</div>';
	} else {
		$triangle_top  = null;
	}
	
	$html .= $jv_content['lv_rating_average'];

	$html .= $content['media_wrapper_start']; // Media wrapper start markup (no included in media markup to allow custom position of media and link buttons)
		$html .= $content['media_markup'];    // Media markup with all html to build audio/video/image/galley media
		$html .= (!empty($media_button)) ? $content['center_wrapper_start'] : null; // Wrapper Start to center content inside
			$html .= ($content['media_type'] != 'image' && $content['media_type'] != 'gallery' && !empty($media_button)) ? $content['overlay'].$media_button : null;  // Lightbox/Play button
			$html .= (($content['media_type']  == 'image' || $content['media_type']  == 'gallery') && !empty($link_button)) ? $content['overlay'].$link_button  : null;  // button link if image or gallery
		$html .= (!empty($media_button)) ? $content['center_wrapper_end'] : null;   // Wrapper End to center content inside
		$html .= (!empty($media_button)) ? $triangle_bot : null;
		$html .= (!empty($media_button)) ? $triangle_top: null;
	$html .= $content['media_wrapper_end'];   // Media wrapper markup end
	
	$html .= $content['content_wrapper_start']; // add content wrapper start (to apply color scheme and contains main info
		$html .= $content['date'];       // get the date markup
		$html .= $content['title'];      // get the title markup
		//$html .= $content['terms'];      // get terms list markup
		$html .= $jv_content['lv_category'];
		$html .= $jv_content['lv_location'];
		$html .= $content['content'];    // get the content/excerpt markup
		$html .= '<div class="tg-item-footer">';
			$html .=  preg_replace('/(<a\b[^><]*)>/i', '$1 style="color:'.$content['colors']['content']['title'].'">', $content['comments']['markup']); // get the comments markup
			$html .= $content['post_like'];	 // get the post like markup
		$html .= '</div>';
	$html .= $content['content_wrapper_end']; // add content wrapper end
	
}
		
return $html;