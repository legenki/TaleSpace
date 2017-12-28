<div class="row text-left javo-map-box-category">

	<div class="col-md-3 javo-map-box-title">
		<?php esc_html_e( "Category", 'javohome' ); ?>
	</div><!-- /.col-md-3 -->
	<div class="col-md-9 javo-map-box-field">
		<select name="map_filter[property_type]" class="form-control javo-selectize-option" data-tax="property_type" data-metakey="property_type" data-name="<?php esc_html_e( "Category", 'javohome' ); ?>">
			<option value=""><?php esc_html_e( "Any Categories", 'javohome' ); ?></option>
			<?php echo apply_filters('jvfrm_home_get_selbox_child_term_lists', 'property_type', null, 'select', $post->req_property_type, 0, 0, "-");?>
		</select>
	</div><!-- /.col-md-9 -->

</div><!-- /.row -->