<div class="row text-left javo-map-box-advance-pricefilter">
	<div class="col-md-3 jv-advanced-titles">
		<?php _e( "Price", 'javohome' ); ?>
	</div><!-- /.col-md-3 -->
	<div class="col-md-9 jv-advanced-fields">

		<div class="input-group">
			<input type="number" class="form-control" data-min placeholder="<?php _e( "No Min", 'javohome' ); ?>"  value="<?php echo sanitize_text_field( $post->req_price_min ); ?>">
			<span class="input-group-addon"><?php _e( "To", 'javohome' );?></span>
			<input type="number" class="form-control" data-max placeholder="<?php _e( "No Max", 'javohome' ); ?>"  value="<?php echo sanitize_text_field( $post->req_price_max ); ?>">
		</div>

	</div><!-- /.col-md-9 -->
</div><!-- /.row -->