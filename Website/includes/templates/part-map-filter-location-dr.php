<div class="row text-left javo-map-box-contract-type">
	<div class="col-md-3 javo-map-box-title javo-map-box-title">
		<?php esc_html_e( "Location", 'javohome' ); ?>
	</div><!-- /.col-md-3 -->
	<div class="col-md-9 javo-map-box-field">
		<select name="map_filter[property_status]" class="form-control javo-selectize-option" data-tax="property_status" data-metakey="property_status"  data-name="<?php esc_html_e( "Location", 'javohome' ); ?>">
			<option value=""><?php esc_html_e( "Any Location", 'javohome' ); ?></option>
			<?php echo apply_filters('jvfrm_home_get_selbox_child_term_lists', 'property_status', null, 'select', $post->req_property_status, 0, 0, "-");?>
		</select>
	</div><!-- /.col-md-9 -->
</div><!-- /.row -->