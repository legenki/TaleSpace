<?php
if( ! isset( $jvfrm_home_post ) )
	die;
$tempPost = $GLOBALS[ 'post' ];
$GLOBALS[ 'post' ] = $post = get_post( $jvfrm_home_post );
$strFeaturedImageSrc = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' );
$isActivateReview = function_exists( 'lv_directoryReview' );
$isActivateFavorite = function_exists( 'lv_realestate_favorite' ); ?>

<div class="jv-brief-info-wrap" style="position:relative; left: auto;">
	<div class="lava-mhome-item-info-loading-cover hidden"></div>
	<div class="jv-brief-info-inner">

		<div class="row">
			<div class=" col-md-12 jv-brief-info-header-img-wrap" style="background-repeat:no-repeat;background-size:cover;background-image:url('<?php echo $strFeaturedImageSrc[0]; ?>');">
				<i class="fa fa-times jv-brief-info-close-btn"></i>
				<div id="jv-brief-info-author-thumb"><div class="lava-thb" style="background-image:url(http://korea4home.com/wp-content/blogs.dir/2/files/2016/08/Screen-Shot-2016-08-02-at-2.22.06-PM-150x115.png);"></div></div>
				<div class="jv-brief-info-heading-des">
					<div class="jv-brief-info-heading-cates"><?php echo function_exists( 'lava_realestate_featured_terms' ) ? lava_realestate_featured_terms( 'property_type', $post->ID, false ) . ', ' . lava_realestate_featured_terms( 'property_status', $post->ID, false )  : false;  ?></div>
					<div class="jv-brief-info-heading-title"><?php echo $post->post_title; ?></div>
					<?php
					if( $isActivateReview ){
						$ratingScore			= floatVal( get_post_meta( $post->ID, 'rating_average', true ) );
						$ratingPercentage	= floatVal( ( $ratingScore / 5 ) * 100 ) . '%';
						printf(
							'<div class="jv-brief-info-heading-reviews javo-shortcode inline-block"><div class="module"><div class="meta-rating-wrap"><div class="meta-rating" style="width:%1$s"></div></div></div></div>',
							// lv_directoryReview()->core->fa_get()
							$ratingPercentage
						);
					}
					if( $isActivateFavorite ){
						echo '<div class="jv-brief-info-heading-favorites inline-block">';
						lv_realestate_favorite()->core->appned_favorite( $post );
						echo '</div>';
					} ?>
				</div>
				<div class="meta-rating-wrap"><div class="meta-rating" style="width:0%;"></div></div>
				<div class="jv-brief-info-header-bg-overlay"></div>
			</div><!--/jv-brief-info-header-img-wrap-->
		</div><!-- /.row -->

		<div class="jv-brief-content-wrap">
			<div class="row" id="jv-brief-info-tabs-navi affix"  data-spy="affix" data-offset-top="197">
				<div class="col-md-12 jv-brief-info-tabs-wrap">
					<div class="header-tabs">
						<ul class="nav tabs-container">
							<a class="detail-tab scroll-spy force-active col-md-3" data-href="#detail-section" href="#detail-section">
								<h4 class="text-center"><?php esc_html_e( 'Detail', 'javohome' ); ?></h4>
							</a>
							<a class="detail-tab scroll-spy col-md-3" data-href="#amenities-section" href="#amenities-section">
								<h4 class="text-center"><?php esc_html_e( 'Amenities', 'javohome' ); ?></h4>
							</a>
							<a class="detail-tab scroll-spy col-md-3" data-href="#des-section" href="#des-section">
								<h4 class="text-center"><?php esc_html_e( 'Description', 'javohome' ); ?></h4>
							</a>
						</ul><!-- /.tabs-container -->
					</div><!-- /.header-tabs -->
				</div><!--/jv-brief-info-tabs-wrap-->
			</div><!-- /.row -->

			<div class="jv-brief-info-content-wrap">
				<div class="jv-brief-info-content-section" id="detail-section">
					<div class="row jv-brief-info-content-section-wrap">
						<div class="col-md-12 heading-wrap">
							<h2><?php esc_html_e( 'Detail', 'javohome' ); ?></h2>
						</div><!-- /.col-md-12 -->
						<div class="col-md-12 panel jv-brief-info-content-section-panel-wrap">
							<div class="panel-body">
								<div class="row summary_items">
									<div class="col-md-12 col-xs-12">
										<div class="row">
											<div class="col-md-5 col-xs-12"><span><?php esc_html_e( 'Website', 'javohome' ); ?></span></div>
											<div class="col-md-7 col-xs-12"><span><span class="lava-detail-panel-salary"><?php echo get_post_meta( $post->ID, '_website', true ); ?></span></span></div>
										</div>
										<div class="row">
											<div class="col-md-5 col-xs-12"><span><?php esc_html_e( 'Email', 'javohome' ); ?></span></div>
											<div class="col-md-7 col-xs-12"><span id="lava-detail-panel-startday"><?php echo get_post_meta( $post->ID, '_email', true ); ?></span></div>
										</div>
										<div class="row">
											<div class="col-md-5 col-xs-12"><span><?php esc_html_e( 'Phone', 'javohome' ); ?></span></div>
											<div class="col-md-7 col-xs-12"><span id="lava-detail-panel-howmany"><?php echo get_post_meta( $post->ID, '_phone1', true ); ?></span></div>
										</div>
										<div class="row">
											<div class="col-md-5 col-xs-12"><span><?php esc_html_e( 'Address', 'javohome' ); ?></span></div>
											<div class="col-md-7 col-xs-12"><span id="lava-detail-panel-howmany"><?php echo get_post_meta( $post->ID, '_address', true ); ?></span></div>
										</div>
									</div>
								</div><!--/.summary_items-->
							</div><!--/.panel-body-->
						</div> <!-- jv-brief-info-content-section-panel-wrap -->
					</div><!-- /.jv-brief-info-content-section-wrap -->
				</div> <!-- /. jv-brief-info-content-section #detail-section -->


				<div class="jv-brief-info-content-section" id="amenities-section">
					<div class="row jv-brief-info-content-section-wrap">
						<div class="col-md-12 heading-wrap">
							<h2><?php esc_html_e( 'Amenities', 'javohome' ); ?></h2>
						</div><!-- /.col-md-12 -->
						<div class="col-md-12 panel jv-brief-info-content-section-panel-wrap">
							<div class="panel-body">
								<div class="row summary_items">
									<div class="col-md-12 col-xs-12">
										<?php lava_realestate_amenities( $post->ID ); ?>
									</div>
								</div><!--/.summary_items-->
							</div><!--/.panel-body-->
						</div> <!-- jv-brief-info-content-section-panel-wrap -->
					</div><!-- /.jv-brief-info-content-section-wrap -->
				</div> <!-- /. jv-brief-info-content-section #detail-section -->

				<div class="jv-brief-info-content-section" id="des-section">
					<div class="row jv-brief-info-content-section-wrap">
						<div class="col-md-12 heading-wrap">
							<h2><?php esc_html_e( 'Description', 'javohome' ); ?></h2>
						</div><!-- /.col-md-12 -->
						<div class="col-md-12 panel jv-brief-info-content-section-panel-wrap">
							<div class="panel-body">
								<div class="row summary_items">
									<div class="col-md-12 col-xs-12">
										<?php echo $post->post_content; ?>
									</div>
								</div><!--/.summary_items-->
							</div><!--/.panel-body-->
						</div> <!-- jv-brief-info-content-section-panel-wrap -->
					</div><!-- /.jv-brief-info-content-section-wrap -->
				</div> <!-- /. jv-brief-info-content-section #detail-section -->

			</div><!-- /.jv-brief-info-content-wrap -->

		</div> <!-- .aaa -->
	</div><!-- /.jv-brief-info-inner -->
</div><!--/ .jv-brief-info-wrap -->
<?php
// Restore post object
$GLOBLAS[ 'post' ] = $tempPost;