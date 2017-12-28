<?php
wp_localize_script(
	jvfrm_home_core()->getHandleName( 'admin-db-update.js' ),
	'jvfrm_home_admin_db_update_args',
	Array(
		'ajaxurl' => admin_url( 'admin-ajax.php' ),
		'prefix' =>  jvfrm_home_core()->getAjaxPrefixName(),
		
		'strStart' => __( "Starting...", 'javo' ),
		'strNotfound' => __( "Not found items.", 'javo' ),
		'strFindItems' => __( "Found Items : ", 'javo' ),
		'strNotAgree' => __( "You must accept our Terms & Conditions.", 'javo' ),

		// Success
		'strPageShortcodesOK'	=> __( "Pages Shortcodes has been change successfully.", 'javo' ),
		'strPageSettingsOK'	=> __( "Pages Settings has been change successfully.", 'javo' ),
		'strThemeSettingOK'	=> __( "Theme Settings has been change successfully.", 'javo' ),
		'strCompleted'	=> __( "Completed.", 'javo' ),

		// Failed
		'strFail'	=> __( "Failed.", 'javo' ),
	)
);
wp_enqueue_script( jvfrm_home_core()->getHandleName( 'admin-db-update.js' ) );
?>
<div class="jv-db-update-wrap">
	<table class="form-table">
		<tbody>
			<tr valign="top">
				<th scope="row"><?php _e( "Agreement", 'javo' ); ?></th>
				<td>
					<table class="widefat">
						<tbody>
							<tr valign="top">
								<td width="1%"></td>
								<th>
									<label>
										<input type="checkbox" name="agree">
										<?php esc_html_e( "Yes, I agree", 'javo' ); ?>
									</label>
								</th>
								<td>
									<?php esc_html_e( "You must backup your data, files before you use this plugin. the author doesn't have any responsibility to lose your data.", 'javo' ); ?>
								</td>
							</tr>
						</tbody>
					</table>
				</td>
			</tr>
			<tr>
				<th scope="row"><?php _e( "Search Items on javo Home", 'javo' ); ?></th>
				<td>
					<table class="widefat">
						<tbody>
							<tr valign="top">
								<td width="1%"></td>
								<th></th>
								<td>
									<p>
										<button type="button" class="button button-primary jvfrm-home-db-update-trigger">
											<?php echo strtoupper( __( "Database Update", 'javo' ) ); ?>
										</button>
									</p>
									<p>
										<textarea class="widefat code hidden" readonly="readonly" rows="5"></textarea>
									</p>
								</td>
							</tr>
						</tbody>
					</table>
				</td>
			</tr>
		</tbody>
	</table>
</div>