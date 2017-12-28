<!-- Right Sidebar Inner -->
<!-- Control & Filter Area -->
<div class="javo-maps-search-wrap">
	<!-- row -->
	<?php do_action( 'jvfrm_home_map_template_filter_outer' ); ?>

	<div class="javo-maps-advanced-filter-wrap">
		<div class="filter-close">
			<div class="filter-close-inner">
				<span class="glyphicon glyphicon-remove"></span>
			</div>
		</div>
		<?php do_action( 'jvfrm_home_map_template_filter_inner' ); ?>
		<div class="filter-footer">
			<button class="btn btn-warning admin-color-setting btn-block javo-map-box-btn-advance-filter-apply">
				<?php esc_html_e( "Apply Filters", 'javohome' );?>
			</button>
		</div>
	</div><!-- /.javo-maps-advanced-filter-wrap -->

	<div class="row javo-map-box-advance-filter-wrap">
		<div class="col-md-3 col-sm-6">
			<button class="btn btn-warning admin-color-setting btn-block" id="javo-map-box-advance-filter">
				<i class="txt-icon glyphicon glyphicon-tasks"></i>
				<span class="txt-advanced"><?php esc_html_e( "Advanced", 'javohome' );?></span>
				<span class="txt-filter"><?php esc_html_e( "Filter", 'javohome' ); ?></span>
			</button>
		</div><!-- /.col-md-3 -->
		<div class="col-md-2 col-sm-6">
			<button class="btn btn-block" id="javo-map-box-advance-filter-reset">
				<i class="txt-icon glyphicon glyphicon-refresh"></i>
				<span class="txt-reset"><?php esc_html_e( "Reset", 'javohome' );?></span>
			</button>
		</div><!-- /.col-md-2 -->
		<div class="col-md-7 col-sm-12">
			<div class="row">
				<div class="col-md-7 text-left javo-map-box-filter-items"></div>
				<div class="col-md-5 col-sm-12 text-right">
					<span class="javo-map-filter-result-count" data-suffix="<?php esc_attr_e( "Listing(s)", 'javohome' ); ?>"></span>
				</div>
			</div>
		</div>
	</div>
	<?php do_action( 'jvfrm_home_map_box_append_filter_after' ); ?>
	<!-- /.row -->
</div>
<!-- javo-maps-search-wrap -->
<!-- Control & Filter Area Close -->
<input type="hidden" name="jvfrm_home_is_search" value="<?php echo isset( $_POST['filter'] );?>">