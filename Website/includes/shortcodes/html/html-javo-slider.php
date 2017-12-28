<?php
if( !isset( $jvfrm_home_slider_param ) ) {
	die;
}

$arrSliderOptions = shortcode_atts(
	Array(
		'post_type' => 'post',
		'featured' => 'false',
		'count' => '-1',
	),
	$jvfrm_home_slider_param
);

$arrGetSlideParams = Array(
	'post_type' => $arrSliderOptions[ 'post_type' ],
	'posts_per_page' => intVal( $arrSliderOptions[ 'count' ] ),
);

if( $arrSliderOptions[ 'featured' ] === 'true' ) {
	$arrGetSlideParams[ 'meta_query' ][] = Array(
		'key' => '_featured_item',
		'compare' => '=',
		'value' => '1',
	);
}

$objWPQ = new WP_Query;
$arrSliderPosts = $objWPQ->query( $arrGetSlideParams );
?>

<div class="jvfrm-home-slider">
	<div class="jvfrm-home-slider-main">
		<ul class="slides">
			<?php
			if( !empty( $arrSliderPosts ) ) : foreach( $arrSliderPosts as $objPost ) {
				$tagThumbnailFull = get_the_post_thumbnail( $objPost, 'full' );
				printf(
					'<li>%1$s<p class="flex-caption"><h3 class="flex-caption-title">%2$s</h3><span>%3$s</span></p></li>',
					$tagThumbnailFull,
					$objPost->post_title,
					wp_trim_words( $objPost->post_content, 40, '...' )
				);
			} endif; ?>
		</ul>
	</div>
	<div class="jvfrm-home-slider-thumbnail">
		<ul class="slides">
			<?php
			if( !empty( $arrSliderPosts ) ) : foreach( $arrSliderPosts as $objPost ) {
				$tagThumbnail = get_the_post_thumbnail( $objPost, 'jvfrm-home-tiny' );
				printf( '<li>%s</li>', $tagThumbnail );
			} endif; ?>
		</ul>
	</div>
</div>