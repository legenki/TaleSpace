<table class="widefat">
	<tr>
		<td valign="middle" width="30%"><p><?php esc_html_e("Page Background Color", 'javohome');?></p></td>
		<td valign="middle" width="70%">
			<table class="javo-post-header-meta">
				<tr>
					<td width="50%" valign="middle">
						<input type="text" name="jvfrm_home_hd[page_bg]" value="<?php echo esc_attr( $jvfrm_home_query->get("page_bg", null ) );?>" class="wp_color_picker">
					</td>
					<td valign="middle">
						<small class="description">
							<?php esc_html_e("If color value is not inserted, it will be replaced to color set from theme settings", 'javohome');?>
						</small>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td valign="middle"><p><?php esc_html_e( "Page Layout Type", 'javohome');?></p></td>
		<td valign="middle">
			<table class="javo-post-header-meta">
				<tr>
					<td width="5%" valign="middle">
						<select name="jvfrm_home_hd[layout_style_boxed]">
							<?php
							foreach( $jvfrm_home_options[ 'page_layout' ] as $label => $value )
								printf(
									"<option value='{$value}' %s>{$label}</option>"
									, selected( $value == $jvfrm_home_query->get( 'layout_style_boxed' ), true, false )
								);
							?>

						</select>
					</td>
					<td width="5%" valign="middle">&nbsp;</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td valign="middle"><p><?php esc_html_e( "Boxed Layout Shadow", 'javohome');?></p></td>
		<td valign="middle">
			<table class="javo-post-header-meta">
				<tr>
					<td width="5%" valign="middle">
						<label style="padding: 0 15px 0;">
							<input type="radio" name="jvfrm_home_hd[layout_boxed_shadow]" value='' <?php checked( '' == $jvfrm_home_query->get('layout_boxed_shadow') );?>>
							<?php esc_html_e( "Enable", 'javohome');?>
						</label>
						<label style="padding: 0 15px 0;">
							<input type="radio" name="jvfrm_home_hd[layout_boxed_shadow]" value='disable' <?php checked( 'disable' == $jvfrm_home_query->get('layout_boxed_shadow') );?>>
							<?php esc_html_e( "Disable", 'javohome');?>
						</label>
					</td>
					<td width="5%" valign="middle">&nbsp;</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td valign="middle"><p><?php esc_html_e("Page Background Image", 'javohome'); ?></p></td>
		<td valign="middle">
			<div class="jv-uploader-wrap">
				<input type="text" name="jvfrm_home_hd[page_background_image]" value="<?php echo esc_attr( $jvfrm_home_query->get('page_background_image'));?>" >
				<button type="button" class="button button-primary upload" data-title="<?php esc_html_e( "Select Background Image", 'javohome' ); ?>" data-btn="<?php esc_html_e( "Select", 'javohome' ); ?>">
					<span class="dashicons dashicons-admin-appearance"></span>
					<?php esc_html_e( "Select Background Image", 'javohome' ); ?>
				</button>
				<button type="button" class="button remove">
					<?php esc_html_e( "Delete", 'javohome' );?>
				</button>
				<h4><?php esc_html_e("Preview",'javohome'); ?></h4>
				<img src="<?php echo esc_attr( $jvfrm_home_query->get( 'page_background_image' ) );?>" style="max-width:500px;">
			</div>
		</td>
	</tr>
</table>