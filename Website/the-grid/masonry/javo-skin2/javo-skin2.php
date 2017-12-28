<?php

// Available options to retrieve and customize markup
$options = array(
	'poster' => true,  // Media poster for audio/video (if false no play buttons will be created)
	'icons' => array(  // set all icons
		'link'       => '<i class="tg-icon-link"></i>', // Button link icon
		'comment'    => '<i class="tg-icon-chat"></i>', // Button link icon
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
	'avatar'          => true     // Add author avatar
);

// If function do not exists, then return immediately
if (!function_exists('The_Grid_Item_Content')) {
	return;
}

// Main Func/Class to retrieve all necessary item content/markup
$content = The_Grid_Item_Content($options);
$jv_content = jvfrm_home_listing_meta_output( Array());

$html = null;

// background image for quote/link
$bg_img = (isset($content['media_data']['url'])) ? '<div class="tg-item-image" style="background-image: url('.$content['media_data']['url'].')"></div>' : null;

// change color of author & comments
$author = preg_replace('/(<a\b[^><]*)>/i', '$1 style="color:'.$content['colors']['content']['span'].'">', $content['author']);
$comments = preg_replace('/(<a\b[^><]*)>/i', '$1 style="color:'.$content['colors']['content']['span'].'">', $content['comments']['markup']);
$comments = preg_replace('/(<i\b[^><]*)>/i', '$1 style="color:'.$content['colors']['content']['span'].'">', $comments);

if (isset($content['quote_markup'])) {
	
	$html .= $bg_img;
	$html .= $content['content_wrapper_start'];
	$html .= '<i class="tg-quote-icon tg-icon-quote" style="color:'.$content['colors']['content']['title'].'"></i>';
	$html .= $content['date'];
	$html .= $content['quote_markup'];
	$html .= '<div class="tg-item-footer">';
	$html .= $author;
	$html .= '</div>';
	$html .= $content['content_wrapper_end'];
	
} else if (isset($content['link_markup'])) {
	
	$html .= $bg_img;
	$html .= $content['content_wrapper_start'];
	$html .= '<i class="tg-link-icon tg-icon-link" style="color:'.$content['colors']['content']['title'].'"></i>';
	$html .= $content['date'];
	$html .= $content['link_markup'];
	$html .= '<div class="tg-item-footer">';
	$html .= $author;
	$html .= '</div>';
	$html .= $content['content_wrapper_end'];
	
} else {
	
	$media_button = $content['media_button'];
	$link_button  = $content['link_button'];
		
	$html .= $content['media_wrapper_start'];
		$html .= $jv_content['lv_rating_average'];
		$html .= $content['media_markup'];
		$html .= (!empty($media_button)) ? $content['center_wrapper_start'] : null;
			$html .= (!empty($media_button)) ? '<div class="tg-item-overlay-media" style="background:'.$content['colors']['overlay']['background'].'">'.$media_button.'</div>' : null;  
			$html .= (!empty($media_button) && !empty($link_button)) ? '<div class="tg-item-overlay-link" style="background:'.$content['colors']['overlay']['background'].'">'.$link_button.'</div>' : null;
		$html .= (!empty($media_button)) ? $content['center_wrapper_end'] : null;
	$html .= $content['media_wrapper_end'];
	
	$html .= $content['content_wrapper_start'];
		$html .= $content['title'];
		$html .= '<div class="tg-item-info">';
		$html .= $content['date'];
		$html .= $jv_content['lv_category'];
		$html .= $jv_content['lv_location'];
		$html .= '</div>';
		$html .= $content['content'];
		$html .= '<div class="tg-item-footer">';
		$html .= $content['post_like'];
		$html .= $author;
		$html .= $comments;
		$html .= '</div>';
	$html .= $content['content_wrapper_end'];
	
}
		
return $html;