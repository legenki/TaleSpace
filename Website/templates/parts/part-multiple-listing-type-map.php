<?php
// Get Item Tages
{
	$jvfrm_home_all_tags				= '';
	foreach( get_tags( Array( 'fields' => 'names' ) ) as $tags ) {
		$jvfrm_home_all_tags			.= "{$tags}|";
	}
	$jvfrm_home_all_tags				= substr( $jvfrm_home_all_tags, 0, -1 );
}

//
$strMapOutputClass = sprintf(
	'class="%s"', join(
		' ',
		apply_filters(
			'jvfrm_home_map_output_class',
			Array( 'list-group', 'javo-shortcode' )
		)
	)
); ?>
<div class="javo-maps-container">
	<div class="javo-maps-favorites-panel_wrap">
		<div class="javo-maps-favorites-panel hidden"></div>
	</div>
	<!-- MAP Area -->
	<div class="map_cover"></div>

	<div <?php jvfrm_home_map_class( 'javo-maps-area-wrap' ); ?>>
		<div class="javo-maps-area"></div>
	</div>

	<div class="category-menu-bar"></div>

	<?php do_action( 'jvfrm_home_' . jvfrm_home_core()->slug . '_map_wrap_after', get_the_ID() ); ?>

	<!-- Right Sidebar Content -->
	<div <?php jvfrm_home_map_class( 'javo-maps-panel-wrap' ); ?>>
		<div class="javo-maps-panel-wrap-inner">
			<div class="javo-map-box-advance-filter-wrap-fixed"></div>
			<?php do_action( 'jvfrm_home_' . jvfrm_home_core()->slug . '_map_lists_before', get_the_ID() ); ?>

			<div class="javo-map-box-advance-filter-apply">
				<div class="col-xs-8">
					<button class="btn admin-color-setting btn-block javo-map-box-btn-advance-filter-apply">
						<?php esc_html_e( "Apply Filters", 'javohome' );?>
					</button>
				</div><!-- /.col-xs-8 -->
				<div class="col-xs-4">
					<button class="btn btn-default admin-color-setting btn-block javo-map-box-advance-filter-trigger">
						<?php esc_html_e( "Cancel", 'javohome' );?>
					</button>
				</div><!-- /.col-xs-4 -->
			</div>

			<?php
			// Map list output
			if( apply_filters( 'jvfrm_home_' . jvfrm_home_core()->slug . '_map_lists_output_visible', true, get_the_ID() ) ): ?>
				<!-- Ajax Results Output Element-->
				<div class="javo-maps-panel-list-output item-list-page-wrap">
					<div class="body-content">
						<div class="col-md-12">
							<div id="products" <?php echo $strMapOutputClass;?>></div><!-- /#prodicts -->
						</div><!-- /.col-md-12 -->
					</div><!-- /.body-content -->

					<div class="col-md-12">
						<button type="button" class="btn btn-default admin-color-setting btn-block javo-map-box-morebutton" data-javo-map-load-more>
							<i class="fa fa-spinner fa-spin hidden"></i>
							<?php esc_html_e("Load More", 'javohome');?>
						</button>
					</div><!-- /.col-md-12 -->
				</div>
				<?php do_action( 'jvfrm_home_' . jvfrm_home_core()->slug . '_map_lists_after' ); ?>
			<?php endif; ?>
		</div>

	</div><!-- /.javo-maps-panel-wrap -->
	<!-- Right Sidebar Content Close -->
</div><!-- /.javo-maps-container -->

<?php

// Map Container After
do_action( 'jvfrm_home_'  . jvfrm_home_core()->slug . '_map_container_after', get_the_ID() );