<div class="row text-left filter-address">
	<div class="col-md-3 javo-map-box-title">
		<?php esc_html_e( "Address", 'javohome' ); ?>
	</div><!-- /.col-md-3 -->
	<div class="col-md-9">
		<div class="row">
			<div class="col-md-5">
				<input id="javo-map-box-location-ac" type="text" class="form-control javo-location-search" value="<?php echo sanitize_text_field( $post->lava_current_rad ); ?>">
			</div>
			<div class="col-md-7 javo-my-position-geoloc">
				<div class="row">
					<div class="col-md-2 col-sm-2">
						<div class="btn btn-primary admin-color-setting btn-block javo-my-position">
							<i class="fa fa-compass"></i>
						</div>
					</div>
					<div class="col-md-10 col-sm-10">
						<div class='javo-radius-slider-label hidden'><?php esc_html_e( "Radius", 'javohome' ); ?></div>
						<div class="close">&times;</div>
						<div class="javo-geoloc-slider" ></div>
					</div>
				</div>
			</div>
		</div>
	</div><!-- /.col-md-9 -->
</div><!-- /.row -->