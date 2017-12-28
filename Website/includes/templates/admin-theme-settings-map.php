<div class="jvfrm_home_ts_tab javo-opts-group-tab hidden" tar="map">
	<!--------------------------------------------
	:: Map Common
	---------------------------------------------->
	<h2> <?php esc_html_e("Map Settings", 'javohome'); ?> </h2>
	<table class="form-table">
	<tr><th>
		<?php esc_html_e( "Common", 'javohome' );?>
		<span class="description"></span>
	</th><td>

		<h4><?php esc_html_e( "Contact form plugin", 'javohome');?>: </h4>
		<fieldset  class="inner">
			<select name="jvfrm_home_ts[map_contact_form]">
				<?php
				foreach(
					Array(
						''						=> esc_html__( "Disable (default)", 'javohome' ),
						'contact-form-7'	=> esc_html__( "Contact Form7", 'javohome' ),
						'ninja_forms'		=> esc_html__( "Ninja Form", 'javohome' ),
					) as $value => $label
				) printf( "<option value=\"{$value}\"%s>{$label}</option>", selected( jvfrm_home_tso()->get( 'map_contact_form' ) == $value, true, false ) );
				?>
			</select>
		</fieldset>

		<h4><?php esc_html_e( "Contact form ID", 'javohome');?>: </h4>
		<fieldset  class="inner">
			<input type="number" name="jvfrm_home_ts[map_contact_form_id]" value="<?php echo esc_attr( jvfrm_home_tso()->get('map_contact_form_id', null));?>">
		</fieldset>

	</td></tr><tr><th>
		<?php esc_html_e( "Map Template Page( Map )", 'javohome' );?>
		<span class="description"></span>
	</th><td>
		<h4><?php esc_html_e( "Default Map Marker", 'javohome');?>: </h4>
		<fieldset  class="inner">
			<input type="text" name="jvfrm_home_ts[map_marker]" value="<?php echo esc_attr( jvfrm_home_tso()->get('map_marker', null));?>" tar="map_marker">
			<input type="button" class="button button-primary fileupload" value="<?php esc_html_e('Select Image', 'javohome');?>" tar="map_marker">
			<input class="fileuploadcancel button" tar="map_marker" value="<?php esc_html_e('Delete', 'javohome');?>" type="button">
			<p>
				<?php esc_html_e( "Preview", 'javohome' ); ?><br>
				<img src="<?php echo jvfrm_home_tso()->get( 'map_marker', null );?>" tar="map_marker">
			</p>
		</fieldset>

		<h4><?php esc_html_e( "Allow to use mouse wheel on map", 'javohome');?>: </h4>
		<fieldset  class="inner">
			<select name="jvfrm_home_ts[map_allow_mousewheel]">
				<?php
				foreach(
					Array(
						''				=> esc_html__( "Disable (default)", 'javohome' ),
						'enable'		=> esc_html__( "Enable", 'javohome' )
					) as $value => $label
				) printf( "<option value=\"{$value}\"%s>{$label}</option>", selected( jvfrm_home_tso()->get( 'map_allow_mousewheel' ) == $value, true, false ) );
				?>
			</select>
		</fieldset>
	</td></tr><tr><th>

		<?php esc_html_e( "Map Template Page( Listing )", 'javohome' );?>
		<span class="description"></span>
		</th><td>
			<h4><?php esc_html_e("Background color", 'javohome');?>: </h4>
			<fieldset  class="inner">
				<input name="jvfrm_home_ts[map_page_listing_part_bg]" type="text" value="<?php echo esc_attr( $jvfrm_home_tso->get('map_page_listing_part_bg','') );?>" class="wp_color_picker" data-default-color="">
			</fieldset>
			<h4><?php esc_html_e("Background image", 'javohome');?>: </h4>
			<fieldset  class="inner">
				<input type="text" name="jvfrm_home_ts[map_page_listing_part_bg_image]" value="<?php echo esc_attr( $jvfrm_home_tso->get('map_page_listing_part_bg_image') );?>" tar="map_listing_bg_image">
				<input type="button" class="button button-primary fileupload" value="<?php esc_attr_e('Select Image', 'javohome');?>" tar="map_listing_bg_image">
				<input class="fileuploadcancel button" tar="map_listing_bg_image" value="<?php esc_attr_e('Delete', 'javohome');?>" type="button">
				<p>
					<?php esc_html_e("Preview",'javohome'); ?><br>
					<img src="<?php echo esc_attr( jvfrm_home_tso()->get('map_page_listing_part_bg_image' ) );?>" tar="map_listing_bg_image" style="max-width:60%;">
				</p>
			</fieldset>
		</td></tr>
	</table>
</div>