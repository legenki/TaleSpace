<div class="row text-left javo-map-box-contract-type">
	<div class="col-md-3 javo-map-box-title javo-map-box-title">
		<?php esc_html_e( "City", 'javohome' ); ?>
	</div><!-- /.col-md-3 -->
	<div class="col-md-9 javo-map-box-field">
		<select name="map_filter[property_city]" class="form-control javo-selectize-option" data-tax="property_city" data-metakey="property_city" data-name="<?php esc_html_e( "City", 'javohome' ); ?>">
			<option value=""><?php esc_html_e( "Any City", 'javohome' ); ?></option>
			<?php echo apply_filters('jvfrm_home_get_selbox_child_term_lists', 'property_city', null, 'select', $post->req_property_city, 0, 0, "-");?>
		</select>
	</div><!-- /.col-md-9 -->
</div><!-- /.row -->