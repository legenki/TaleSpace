<div class="row text-left javo-map-box-advance-keyword">
	<div class="col-md-3 jv-advanced-titles javo-map-box-title">
		<?php esc_html_e( "Keyword", 'javohome' ); ?>
	</div><!-- /.col-md-3 -->
	<div class="col-md-9 jv-advanced-fields">
		<input type="text" id="javo-map-box-auto-tag" class="form-control" value="<?php echo sanitize_text_field( $post->lava_current_key ); ?>" placeholder="<?php esc_attr_e( "Keyword", 'javohome' ); ?>">
	</div><!-- /.col-md-9 -->
</div><!-- /.row -->