<div id="postcustomstuff">
	<table id="list-table">
		<thead>
			<tr>
				<th class="left"><?php esc_html_e('Option Name', 'javohome');?></th>
				<th><?php esc_html_e('Value', 'javohome');?></th>
			</tr>
		</thead>
		<tbody id="the-list" data-wp-lists="list:meta">
			<tr>
				<td valign="middle"><p><?php esc_html_e( "Footer Layout Type", 'javohome');?></p></td>
				<td valign="middle">
					<table class="javo-post-header-meta">
						<tr>
							<td width="5%" valign="middle">
								<select name="jvfrm_home_hd[footer_container_type]">
									<?php
									foreach( $jvfrm_home_options[ 'footer_layout' ] as $label => $value )
										printf(
											"<option value='{$value}' %s>{$label}</option>"
											, selected( $value == $jvfrm_home_query->get( 'footer_container_type' ), true, false )
										);
									?>

								</select>
							</td>
							<td width="5%" valign="middle">&nbsp;</td>
						</tr>
					</table>
				</td>
			</tr>
		</tbody>
	</table>
</div><!-- /#postcustomstuff -->
