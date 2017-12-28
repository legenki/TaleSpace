<div class="row javo-detail-item-content">

	<?php
	$GLOBALS[ 'single_addon_options' ] = isset( $single_addon_options ) ? (Array)$single_addon_options : Array();
	do_action( 'jvfrm_home_' . get_post_type() . '_single_content_body' ); ?>

	<?php do_action( 'jvfrm_home_' . get_post_type() . '_single_description_before' ); ?>

	<div class="col-md-12 col-xs-12 item-description" id="javo-item-describe-section" data-jv-detail-nav>

		<h3 class="page-header"><?php esc_html_e( "Detail", 'javohome' ); ?></h3>
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
			'container_after' => '
						</div>
					</div><!-- panel-body -->
				</div>
			</div><!-- /#javo-item-amenities-section -->'
		)
	); ?>

	<?php do_action( 'jvfrm_home_' . get_post_type() . '_single_description_after' ); ?>

	<?php do_action( 'jvfrm_home_' . get_post_type() . '_single_booking' ); ?>

	<?php if( function_exists( 'get_lava_realestate_review' ) ): ?>
		<div class="col-md-12 col-xs-12 item-description" id="javo-item-review-section" data-jv-detail-nav>

			<h3 class="page-header"><?php esc_html_e( "Review", 'javohome' ); ?></h3>
			<div class="panel panel-default">
				<div class="panel-body">
					<?php get_lava_realestate_review(); ?>
				</div><!--/.panel-body-->
			</div><!--/.panel-->
		</div><!-- /#javo-item-describe-section -->
	<?php endif; ?>

	<?php do_action( 'jvfrm_home_' . get_post_type() . '_single_map_before' ); ?>
	<?php do_action( 'jvfrm_home_' . get_post_type() . '_single_map_after' ); ?>

</div><!-- /.javo-detail-item-content -->