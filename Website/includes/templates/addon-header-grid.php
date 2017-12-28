<?php
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
if( class_exists( 'lvRealestate3DViewer_Render' ) ) {
	$obj3DViewer = new lvRealestate3DViewer_Render( get_post() );
	$is_has_3d = $obj3DViewer->viewer;
}else{
	$is_has_3d = false;
}
// Single page addon option
if( class_exists( 'Javo_Home_Single_Addon' ) ){
	$single_addon_options = get_single_addon_options(get_the_ID());
	if($single_addon_options['background_transparent'] == 'disable'){
		$block_meta = 'extend-meta-block-wrap';
		if($single_addon_options['featured_height'] != '') $featured_height = 'style=height:'.$single_addon_options['featured_height'].'px;';
	}else{
		if($single_addon_options['featured_height'] != ''){
			$block_meta = '"style=height:auto;min-height:auto;';
			$featured_height = 'style=height:'.$single_addon_options['featured_height'].'px;';
		}
	}
}

// Right Side Navigation
$jvfrm_home_rs_navigation = jvfrm_home_single_navigation();
 ?>
<div class="single-item-tab-feature-bg-wrap <?php echo isset($block_meta) ? $block_meta : ''; ?>">	
	<link rel="stylesheet" href="<?php echo get_template_directory_uri().'/assets/css/swiper.min.css'; ?>">
	<style>
		.swiper-container{width: 100%;height: 100%;}
		.swiper-slide{text-align: center;font-size: 18px;background:#fff;overflow:hidden;display:-webkit-box;display: -ms-flexbox;display: -webkit-flex;display: flex;-webkit-box-pack: center;-ms-flex-pack: center;-webkit-justify-content:center;justify-content:center;-webkit-box-align:center;-ms-flex-align:center;-webkit-align-items:center;align-items: center;}
		.swiper-slide img{height:100%;}
		.swiper-button-prev,
		.swiper-button-next{background-image:none;color:#fff;font-size:40px;width:auto;height:auto;max-width:40px;max-height:40px;opacity:0.85;}
		.swiper-button-prev:hover,
		.swiper-button-next:hover{opacity:1;}
		.swiper-container-horizontal>.swiper-pagination-bullets{bottom:5px;}
		.swiper-pagination-bullet{background:#fff;opacity:0.3;}
		.swiper-pagination-bullet-active{background:#fff;opacity:1;}
    </style>
	<div class="swiper-container" <?php echo isset($featured_height) ? $featured_height : ''; ?>>
        <div class="swiper-wrapper">
			<?php
			$arrImages = Array();
			if( is_object( $GLOBALS[ 'post' ] ) && !empty( $GLOBALS[ 'post' ]->attach ) )
				$arrImages = $GLOBALS[ 'post' ]->attach;

			if( !empty( $arrImages ) ) : foreach( $arrImages as $intImageID ) {
				if( $strSRC = wp_get_attachment_image_src( $intImageID, 'jvfrm-medium' ) ) {
					printf( '<div class="swiper-slide"><img src="%s"></div>', $strSRC[0] );
				}
			} endif; ?>
        </div> <!-- swiper-wrapper -->
        <!-- Add Pagination -->
        <div class="swiper-pagination"></div>
		<!-- Arrow -->
		<div class="swiper-button-next"><span class="glyphicon glyphicon-menu-right" aria-hidden="true"></span></div>
        <div class="swiper-button-prev"><span class="glyphicon glyphicon-menu-left" aria-hidden="true"></span></div>
		<div class="jvfrm_home-single-header-gradient <?php echo sanitize_html_class( jvfrm_home_tso()->get( 'property_single_header_cover', null ) ); ?>"></div>
	</div><!-- swiper-container -->
	
	<div class="single-item-tab-bg" <?php echo isset($single_addon_options['background_transparent']) && $single_addon_options['background_transparent'] == 'disable' ? 'style="bottom:0 !important;"' : ''; ?>>
		<div class="container captions">
			<div class="header-inner <?php if(class_exists( 'Lava_Directory_Review' )) echo 'jv-header-rating'; ?>">
				<div class="item-bg-left pull-left text-left">
					<div class="single-header-terms">
						<div class="tax-item-category"><?php lava_realestate_featured_terms( 'property_type' ); ?></div><span>/</span>
						<div class="tax-item-location"><?php lava_realestate_featured_terms( 'property_status' ); ?></div>
						<?php
						if( function_exists( 'pvc_post_views' ) )
							pvc_post_views( $post_id = 0, $echo = true );
						?>
					</div>
					<h1 class="uppercase">
						<span class="jv-listing-title"><?php  echo get_the_title(); ?></span>
						<a href="<?php echo jvfrm_home_getUserPage( get_the_author_meta( 'ID' ) ); ?>" class="header-avatar" style="display:none;">
							<?php echo get_avatar( get_the_author_meta( 'ID' ) ); ?>
						</a>
					</h1>
					<div class="jv-addons-meta-wrap">
						<?php echo apply_filters( 'jvfrm_home_' . get_post_type() . '_single_listing_rating', '' );?>
						<?php if( $this->single_type == 'type-grid' ) : ?>
							<?php if( class_exists( 'lvRealestateFavorite_button' ) ) {
								$objFavorite = new lvRealestateFavorite_button(
									Array(
										'post_id' => get_the_ID(),
										'show_count' => true,
										'show_add_text' => "<span>".__('Add to Favorites','javohome')."</span>",
										'save' => "<i class='fa fa-heart-o'></i>",
										'unsave' => "<i class='fa fa-heart'></i>",
										'class' => Array( 'btn', 'lava-single-page-favorite' ),
									)
								);
								$objFavorite->output();
							} ?>
						<?php endif; ?>
					</div>
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
					<a class="javo-tooltip" data-original-title="<?php _e('Map','javohome'); ?>"><i class="jvd-icon-geolocalizator" aria-hidden="true"></i></a>
				</li>
				<?php if( 0 != get_post_meta( get_the_ID(), "lv_item_street_visible", true ) ) : ?>
					<li class='switch-streetview'>
						<a class="javo-tooltip" data-original-title="<?php _e('Streeview','javohome'); ?>"><i class="jvd-icon-user" aria-hidden="true"></i></a>
					</li>
				<?php endif; ?>
				<?php if( $is_has_3d ) : ?>
					<li class='switch-3dview'>
						<a class="javo-tooltip" data-original-title="<?php _e('3DView','javohome'); ?>"><i class="icon-viewer-icon-g"></i></a>
					</li>
				<?php endif; ?>
				<?php if( $is_has_video ) : ?>
					<li class='switch-video'>
						<a class="javo-tooltip" data-original-title="<?php _e('Video','javohome'); ?>"><i class="jvd-icon-camera-video" aria-hidden="true"></i></a>
					</li>
				<?php endif; ?>
				<?php if( function_exists( 'lava_realestate_direction' ) ) : ?>
							<li class='switch-get-direction' data-toggle="modal" data-target="#jvlv-single-get-direction">
								<a class="javo-tooltip" data-original-title="<?php _e('Get Direction','javohome'); ?>"><i class="jvd-icon-train"></i></a>
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
			if( $is_has_3d )
				$obj3DViewer->output();
			?>
		</div>
		<div class="container-video" <?php echo isset($featured_height) ? $featured_height : ''; ?>>
			<?php
			if( $is_has_video )
				$objVideo->output();
			?>
		</div>
	</div>

	 <!-- Swiper JS -->
     <script src="<?php echo get_template_directory_uri().'/assets/js/swiper.min.js'; ?>"></script>

    <!-- Initialize Swiper -->
    <script>
    var swiper = new Swiper('.swiper-container', {
        pagination: '.swiper-pagination',
        slidesPerView: 3,
        paginationClickable: true,
        spaceBetween: 10,
		nextButton: '.swiper-button-next',
        prevButton: '.swiper-button-prev',
		breakpoints: {
            1024: {
                slidesPerView: 2,
                spaceBetween: 10
            },
            768: {
                slidesPerView: 2,
				spaceBetween: 10
            },
            640: {
                slidesPerView: 2,
				spaceBetween: 5
            },
            380: {
                slidesPerView: 1,
				spaceBetween: 0
            }
        }
    });
    </script>
</div>