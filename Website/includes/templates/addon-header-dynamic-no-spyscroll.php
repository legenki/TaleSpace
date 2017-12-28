<?php
/** May NOT use in the future due to separated menu and header */

$arrAllowPostTypes		= apply_filters( 'jvfrm_home_single_post_types_array', Array( 'property' ) );
if( class_exists( 'lvRealestateVideo_Render' ) ) {
	$objVideo = new lvRealestateVideo_Render( get_post(), array(
		'width' => '100',
		'height' => '100',
		'unit' => '%',
	) );
	$is_has_video = $objVideo->hasVideo();
}else{
	$is_has_video = false;
}

// Single page addon option
if( class_exists( 'Javo_Home_Single_Addon' ) ){
	$single_addon_options = get_single_addon_options(get_the_ID());
	if($single_addon_options['background_transparent'] == 'disable'){ 
		$block_meta = 'extend-meta-block';
		if($single_addon_options['featured_height'] != '') $featured_height = 'style=height:'.$single_addon_options['featured_height'].'px;';
	}else{
		if($single_addon_options['featured_height'] != '') $block_meta = '"style=height:'.$single_addon_options['featured_height'].'px;min-height:'.$single_addon_options['featured_height'].'px;';
	}
}

// Right Side Navigation
$jvfrm_home_rs_navigation = jvfrm_home_single_navigation();
function jvfrm_home_custom_single_style($single_addon_options = '')
{
	if ( false === (boolean)( $large_image_url = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' ) ) )
		$large_image_url	= '';
	else
		$large_image_url	=  $large_image_url[0];

	$output_style	= Array();
	$output_style[]	= sprintf( "%s:%s;", 'background-image'			, "url({$large_image_url})" );
	$output_style[]	= sprintf( "%s:%s;", 'background-attachment'	, 'fixed' );
	$output_style[]	= sprintf( "%s:%s;", 'background-repeat'		, 'no-repeat' );
	$output_style[]	= sprintf( "%s:%s;", 'background-position'		, 'center center' );
	$output_style[]	= sprintf( "%s:%s;", 'background-size'			, 'cover' );
	$output_style[]	= sprintf( "%s:%s;", '-webkit-background-size'	, 'cover' );
	$output_style[]	= sprintf( "%s:%s;", '-moz-background-size'		, 'cover' );
	$output_style[]	= sprintf( "%s:%s;", '-ms-background-size'		, 'cover' );
	$output_style[]	= sprintf( "%s:%s;", '-o-background-size'		, 'cover' );

	if($single_addon_options['background_transparent'] != '' && $single_addon_options['featured_height'] != '' )
		$output_style[]	= sprintf( "%s:%s;", 'height'				, $single_addon_options['featured_height']. 'px' );

	$output_style	= apply_filters( 'jvfrm_home_featured_detail_header'	, $output_style, $large_image_url );
	$output_style	= esc_attr( join( ' ', $output_style ) );

	echo "style=\"{$output_style}\"";
} ?>
<div class="single-item-tab-feature-bg-wrap single-dynamic-header <?php echo isset($block_meta) ? $block_meta : ''; ?>">
	<div class="single-item-tab-feature-bg <?php echo sanitize_html_class( jvfrm_home_tso()->get( 'property_single_header_cover', null ) ); ?>" <?php jvfrm_home_custom_single_style($single_addon_options); ?> >
		<div class="jv-pallax"></div>
		<div class="single-item-tab-bg-overlay"></div>
		<div class="bg-dot-black"></div> <!-- bg-dot-black -->
	</div> <!-- single-item-tab-feature-bg -->
	<div class="single-item-tab-bg">
		<div class="container captions">
			<div class="header-inner">
				<div class="item-bg-left pull-left text-left">
					<div class="single-header-terms">
						<div class="tax-item-category"><?php lava_realestate_featured_terms( 'property_type' ); ?></div>
						<div class="tax-item-location"><?php lava_realestate_featured_terms( 'property_status' ); ?></div>
					</div>
					<h1 class="uppercase">
						<?php echo apply_filters( 'jvfrm_home_' . get_post_type() . '_single_title', get_the_title() );?>
						<a href="<?php echo jvfrm_home_getUserPage( get_the_author_meta( 'ID' ) ); ?>" class="header-avatar"  style="display:none;">
							<?php echo get_avatar( get_the_author_meta( 'ID' ) ); ?>
						</a>
					</h1>
					<div class="listing-des" style="display:none;">
						<?php
						$jvfrm_home_facebook_link = esc_html(get_post_meta( get_the_ID(), '_facebook_link', true ));
						$jvfrm_home_twitter_link = esc_html(get_post_meta( get_the_ID(), '_twitter_link', true ));
						$jvfrm_home_instagram_link = esc_html(get_post_meta( get_the_ID(), '_instagram_link', true ));
						$jvfrm_home_google_link = esc_html(get_post_meta( get_the_ID(), '_google_link', true ));
						$jvfrm_home_website_link = esc_html(get_post_meta( get_the_ID(), '_website', true ));

						if(!($jvfrm_home_facebook_link =='' && $jvfrm_home_twitter_link=='' && $jvfrm_home_instagram_link=='' && $jvfrm_home_google_link=='' && $jvfrm_home_website_link =='')){
						?>
						<div id="javo-item-social-section" data-jv-detail-nav>
							<div class="jvfrm_home_single_listing_social-wrap">
								<?php if ($jvfrm_home_facebook_link!=''){ ?>
									<a href="<?php echo $jvfrm_home_facebook_link;?>" target="_blank" class="jvfrm_home_single_listing_facebook javo-tooltip" data-original-title="<?php _e('Facebook','javohome'); ?>"><i class="fa fa-facebook" aria-hidden="true"></i></a>
								<?php }
								if ($jvfrm_home_twitter_link!=''){ ?>
									<a href="<?php echo $jvfrm_home_twitter_link;?>" target="_blank" class="jvfrm_home_single_listing_twitter javo-tooltip" data-original-title="<?php _e('Twitter','javohome'); ?>"><i class="fa fa-twitter" aria-hidden="true"></i></a>
								<?php } 
								if ($jvfrm_home_instagram_link!=''){ ?>
									<a href="<?php echo $jvfrm_home_instagram_link;?>" target="_blank" class="jvfrm_home_single_listing_instagram javo-tooltip" data-original-title="<?php _e('Instagram','javohome'); ?>"><i class="fa fa-instagram" aria-hidden="true"></i></a>
								<?php }
								if ($jvfrm_home_google_link!=''){ ?>
									<a href="<?php echo $jvfrm_home_google_link;?>" target="_blank" class="jvfrm_home_single_listing_google javo-tooltip" data-original-title="<?php _e('Google','javohome'); ?>"><i class="fa fa-google" aria-hidden="true"></i></a>
								<?php } 
								if ($jvfrm_home_website_link!=''){?>
									<a href="<?php echo $jvfrm_home_website_link;?>" target="_blank" class="jvfrm_home_single_listing_website javo-tooltip" data-original-title="<?php _e('Website','javohome'); ?>"><i class="fa fa-link" aria-hidden="true"></i></a>
								<?php } ?>
							</div>
						</div><!-- #javo-item-social-section -->
						<?php } ?>
					</div>					
				</div>
				<div class="clearfix"></div>
			</div> <!-- header-inner -->
			<ul class="javo-core-single-featured-switcher pull-right list-inline">
				<li class='switch-map'>
					<a class="javo-tooltip" data-original-title="<?php _e('Map','javohome'); ?>"><i class="fa fa-map-marker" aria-hidden="true"></i></a>
				</li>
				<li class='switch-streetview'>
					<a class="javo-tooltip" data-original-title="<?php _e('Streeview','javohome'); ?>"><i class="fa fa-street-view" aria-hidden="true"></i></a>
				</li>
				<?php if( function_exists( 'lava_realestate_3DViewer' ) ) : ?>
					<li class='switch-3dview'>
						<a class="javo-tooltip" data-original-title="<?php _e('3DView','javohome'); ?>"><i class="icon-viewer-icon-g"></i></a>
					</li>
				<?php endif; ?>
				<?php if( $is_has_video ) : ?>
					<li class='switch-video'>
						<a class="javo-tooltip" data-original-title="<?php _e('Video','javohome'); ?>"><i class="fa fa-video-camera" aria-hidden="true"></i></a>
					</li>
				<?php endif; ?>
			</ul>
		</div> <!-- container -->
	</div> <!-- single-item-tab-bg -->
	<div class="javo-core-single-featured-container hidden">
		<div class="container-map" <?php echo isset($featured_height) ? $featured_height : ''; ?>></div>
		<div class="container-streetview" <?php echo isset($featured_height) ? $featured_height : ''; ?>></div>
		<div class="container-3dview" <?php echo isset($featured_height) ? $featured_height : ''; ?>>
			<?php
			if( function_exists( 'lava_realestate_3DViewer' ) )
				lava_realestate_3DViewer()->core->append_3DViewer();
			?>
		</div>
		<div class="container-video" <?php echo isset($featured_height) ? $featured_height : ''; ?>>
			<?php
			if( $is_has_video )
				$objVideo->output();
			?>
		</div>
	</div>
</div>