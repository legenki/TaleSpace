<!-- Tab panes -->
		<div class="tab-content clearfix">
			<div class="tab-pane jv-info-tab active" id="info">
				<div class="row javo-detail-item-content">
						<!-- Description section -->
						<div class="col-md-12 col-xs-12 item-description" id="javo-item-describe-section" data-jv-detail-nav>
							<h3 class="page-header"><?php esc_html_e( "Description", 'javohome' ); ?></h3>
							<div class="panel panel-default">
								<div class="panel-body">
									<!-- Post Content Container -->
									<div class="jv-custom-post-content">
										<div class="jv-custom-post-content-inner">
											<?php the_content(); ?>
										</div><!-- /.jv-custom-post-content-inner -->
										<div class="jv-custom-post-content-trigger">
											<i class="fa fa-plus"></i>
											<?php esc_html_e( "Read More", 'javohome' ); ?>
										</div><!-- /.jv-custom-post-content-trigger -->
									</div><!-- /.jv-custom-post-content -->
								</div><!--/.panel-body-->
							</div><!--/.panel-->
						</div><!-- /#javo-item-describe-section -->
						<!-- Description section -->

						
						<?php 
							if( $single_addon_options['disable_detail_section']=='') 
								//Listing meta section
								get_template_part( 'includes/templates/html', 'single-detail-options' ); 
						?>

						<?php lava_realestate_amenities(
							get_the_ID(),
							Array(
								'container_before' => sprintf( '
								<div class="col-md-12 col-xs-12 item-amenities" id="javo-item-amenities-section" data-jv-detail-nav>
									<h3 class="page-header">%1$s</h3>
									<div class="panel panel-default">
										<div class="panel-body">
											<div class="expandable-content" >',
											esc_html__( "Amenities", 'javohome' )
								),
								'container_after'  => '
											</div>
										</div><!-- panel-body -->
									</div>
								</div><!-- /#javo-item-amenities-section -->'
							)
						); ?>
				</div><!-- Post Content Container -->
			</div><!-- /. tab-pane #info-->

			<div class="tab-pane jv-gallery-tab" id="gallery">
				<div class="row javo-detail-item-content">
					<?php if( jvfrm_home_has_attach() ) : ?>
							<div class="col-md-12 col-xs-12 item-gallery">
								<?php get_template_part( 'includes/templates/html', 'single-grid-images' ); ?>
							</div><!-- /.col-md-12.item-gallery -->
						<?php endif; ?>
				</div>
			</div><!-- /. tab-pane #gallery-->			

			<div class="tab-pane jv-vendor-tab" id="vendor">
				<div class="row javo-detail-item-content">
					<?php do_action( 'jvfrm_home_' . get_post_type() . '_single_vendor' ); ?>
				</div>
			</div><!-- /. tab-pane #vendor-->

			<div class="tab-pane jv-booking-tab" id="booking">
				<div class="row javo-detail-item-content">
					<?php do_action( 'jvfrm_home_' . get_post_type() . '_single_booking' ); ?>
				</div>
			</div><!-- /. tab-pane #booking-->

			<div class="tab-pane jv-review-tab" id="review">
				<div class="row javo-detail-item-content">
					<h3 class="page-header"><?php esc_html_e( "Review", 'javohome' ); ?></h3>
					<?php
					if( function_exists( 'get_lava_realestate_review' ) )
						get_lava_realestate_review();
					?>
				</div>
			</div><!-- /. tab-pane #review-->

			<div class="tab-pane jv-others-tab" id="others">
				<div class="row javo-detail-item-content">
					<?php do_action( 'jvfrm_home_' . get_post_type() . '_single_description_before' ); ?>
				</div>
			</div><!-- /. tab-pane #others-->
		</div><!-- /. tab-content -->