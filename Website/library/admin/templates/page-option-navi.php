
<table class="widefat">
	<tr>
		<td valign="middle"><p><?php esc_html_e("Header Type", 'javohome');?></p></td>
		<td valign="middle">
			<table class="javo-post-header-meta">
				<tr>
					<td width="50%" valign="middle">

						<select name="jvfrm_home_hd[header_type]" data-docking>
							<?php
							foreach( $jvfrm_home_options[ 'header_type' ] as $label => $value )
							{
								printf(
									"<option value='{$value}' %s>{$label}</option>"
									, selected( $value == $jvfrm_home_query->get("header_type"), true, false)
								);
							} ?>
						</select>
					</td>
					<td width="50%" valign="middle">
						<small class="description">
							<?php esc_html_e("If color value is not inserted, it will be replaced to color set from theme settings", 'javohome');?>
						</small>
					</td>
				</tr>
			</table>
		</td>
	</tr>

	<tr>
		<td valign="middle"><p><?php esc_html_e("Header Banner", 'javohome');?></p></td>
		<td valign="middle">
			<div class="jv-uploader-wrap" style="padding-left:12px;">
				<input type="text" name="jvfrm_home_hd[header_banner]" value="<?php echo esc_attr( $jvfrm_home_query->get('header_banner'));?>" >
				<button type="button" class="button button-primary upload" data-title="<?php esc_html_e( "Select Background Image", 'javohome' ); ?>" data-btn="<?php esc_html_e( "Select", 'javohome' ); ?>">
					<span class="dashicons dashicons-admin-appearance"></span>
					<?php esc_html_e( "Select Background Image", 'javohome' ); ?>
				</button>
				<button type="button" class="button remove">
					<?php esc_html_e( "Delete", 'javohome' );?>
				</button>
				<h4><?php esc_html_e("Preview",'javohome'); ?></h4>
				<img src="<?php echo esc_attr( $jvfrm_home_query->get( 'header_banner' ) );?>" style="max-width:500px;">
			</div>
		</td>
	</tr>

	<tr>
		<td valign="middle"><p><?php esc_html_e("Header Menu Skin", 'javohome');?></p></td>
		<td valign="middle">
			<table class="javo-post-header-meta">
				<tr>
					<td width="50%" valign="middle">
						<select name="jvfrm_home_hd[header_skin]">
							<?php
							foreach( $jvfrm_home_options['header_skin'] as $label => $value )
							{
								printf( "<option value='{$value}' %s>{$label}</option>", selected( $value == $jvfrm_home_query->get("header_skin"), true, false ) );
							} ?>
						</select>
					</td>
					<td width="50%" valign="middle">
						<small class="description">
							<?php esc_html_e("Depends on this option, logo changes to the color appropriate to the skin and if selected logo of skin option is not uploaded, theme's basic logo will be shown.", 'javohome');?>
						</small>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr class="alternate">
		<td valign="middle"><p><?php esc_html_e("Initial Header Background Color", 'javohome');?></p></td>
		<td valign="middle">
			<table class="javo-post-header-meta">
				<tr>
					<td width="50%" valign="middle">
						<input type="text" name="jvfrm_home_hd[header_bg]" value="<?php echo esc_attr( $jvfrm_home_query->get("header_bg", null));?>" class="wp_color_picker">
					</td>
					<td width="50%" valign="middle">
						<small class="description">
							<?php esc_html_e("If color value is not inserted, it will be replaced to color set from theme settings", 'javohome');?>
						</small>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td valign="middle"><p><?php esc_html_e("Initial Header Transparency", 'javohome');?></p></td>
		<td valign="middle">
			<table class="javo-post-header-meta">
				<tr>
					<td width="25%" valign="middle">
						<select name="jvfrm_home_hd[header_opacity_as]" data-docking>
							<?php
							foreach( $jvfrm_home_options['default_able'] as $label => $value )
							{
								printf(
									"<option value='{$value}' %s>{$label}</option>"
									, selected( $value == $jvfrm_home_query->get("header_opacity_as"), true, false)
								);
							} ?>
						</select>
					</td>
					<td width="25%" valign="middle">
						<?php
						if( false === ( $jvfrm_home_options['opacity'] = $jvfrm_home_query->get("header_opacity") ) )
						{
								$jvfrm_home_options['opacity'] = 1;
						} ?>
						<input type="text" name="jvfrm_home_hd[header_opacity]" value="<?php echo (float)$jvfrm_home_options['opacity'];?>">
					</td>
					<td width="50%" valign="middle">
						<small class="description">
							<?php esc_html_e("Please enter numerical value from 0.0 to 1.0. The higher the value you enter, the more opaque it will be. Ex. 1=opaque, 0= invisible.", 'javohome');?>
						</small>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td valign="middle"><p><?php esc_html_e("Header Height", 'javohome');?></p></td>
		<td valign="middle">
			<table class="javo-post-header-meta">
				<tr>
					<td width="25%" valign="middle">
						<select name="jvfrm_home_hd[header_size_as]" data-docking>
							<?php
							foreach( $jvfrm_home_options['default_able'] as $label => $value )
							{
								printf(
									"<option value='{$value}' %s>{$label}</option>"
									, selected( $value == $jvfrm_home_query->get( 'header_size_as' ), true, false)
								);
							} ?>
						</select>
					</td>
					<td width="25%" valign="middle">
						<input type="text" name="jvfrm_home_hd[header_size]" value="<?php echo intVal( $jvfrm_home_query->get( 'header_size', 40  ) );?>">
					</td>
					<td width="50%" valign="middle">
						<small class="description"><?php esc_html_e( "Pixcel", 'javohome' ); ?></small>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td valign="middle"><p><?php esc_html_e("Navi Shadow", 'javohome');?></p></td>
		<td valign="middle">
			<table class="javo-post-header-meta">
				<tr>
					<td width="50%" valign="middle">
						<select name="jvfrm_home_hd[header_shadow]">
							<?php
							foreach( $jvfrm_home_options['able_disable'] as $label => $value )
							{
								printf( "<option value='{$value}' %s>{$label}</option>", selected( $value == $jvfrm_home_query->get("header_shadow"), true, false ) );
							} ?>
						</select>
					</td>
					<td width="50%" valign="middle">
						<small class="description"></small>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td valign="middle"><p><?php esc_html_e("Navi Position", 'javohome');?></p></td>
		<td valign="middle">
			<table class="javo-post-header-meta">
				<tr>
					<td width="50%" valign="middle">
						<select name="jvfrm_home_hd[header_fullwidth]">
							<?php
							foreach( $jvfrm_home_options['header_fullwidth'] as $label => $value )
							{
								printf( "<option value='{$value}' %s>{$label}</option>", selected( $value == $jvfrm_home_query->get("header_fullwidth"), true, false ) );
							} ?>
						</select>
					</td>
					<td width="50%" valign="middle">
						<small class="description"></small>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td valign="middle"><p><?php esc_html_e("Navi Type", 'javohome');?></p></td>
		<td valign="middle">
			<table class="javo-post-header-meta">
				<tr>
					<td width="50%" valign="middle">
						<select name="jvfrm_home_hd[header_relation]">
							<?php
							foreach( $jvfrm_home_options['header_relation'] as $label => $value )
							{
								printf( "<option value='{$value}' %s>{$label}</option>", selected( $value == $jvfrm_home_query->get("header_relation"), true, false ) );
							} ?>
						</select>
					</td>
					<td width="50%" valign="middle">
						<small class="description"><?php esc_html_e("Caution: If you choose transparent menu type, page's main text contents ascends as much as menu's height to make menu transparent.", 'javohome');?></small>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>

<br/>

<table class="widefat">
	<tr>
		<td colspan="2">
			<h2><?php esc_html_e("Sticky Menu Options", 'javohome');?></h2>
		</td>
	</tr>
	<tr>
		<td valign="middle"><p><?php esc_html_e("Sticky Navi on / off", 'javohome');?></p></td>
		<td valign="middle">
			<table class="javo-post-header-meta">
				<tr>
					<td width="50%" valign="middle">
						<select name="jvfrm_home_hd[header_sticky]">
							<?php
							foreach( $jvfrm_home_options['able_disable'] as $label => $value )
							{
								printf( "<option value='{$value}' %s>{$label}</option>", selected( $value == $jvfrm_home_query->get("header_sticky"), true, false ) );
							} ?>
						</select>
					</td>
					<td width="50%" valign="middle">
						<small class="description"></small>
					</td>
				</tr>
			</table>

		</td>
	</tr>
	<tr>
		<td valign="middle"><p><?php esc_html_e("Sticky Header Menu Skin", 'javohome');?></p></td>
		<td valign="middle">
			<table class="javo-post-header-meta">
				<tr>
					<td width="50%" valign="middle">
						<select name="jvfrm_home_hd[sticky_header_skin]">
							<?php
							foreach( $jvfrm_home_options['header_skin'] as $label => $value )
							{
								printf( "<option value='{$value}' %s>{$label}</option>", selected( $value == $jvfrm_home_query->get("sticky_header_skin"), true, false ) );
							} ?>
						</select>
					</td>
					<td width="50%" valign="middle">
						<small class="description">
							<?php esc_html_e("Depends on this option, logo changes to the color appropriate to the skin and if selected logo of skin option is not uploaded, theme's basic logo will be shown. ", 'javohome');?>
						</small>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr class="alternate">
		<td valign="middle"><p><?php esc_html_e("Initial Sticky Header Background Color", 'javohome');?></p></td>
		<td valign="middle">
			<table class="javo-post-header-meta">
				<tr>
					<td width="50%" valign="middle">
						<input type="text" name="jvfrm_home_hd[sticky_header_bg]" value="<?php echo esc_attr( $jvfrm_home_query->get("sticky_header_bg", null));?>" class="wp_color_picker">
					</td>
					<td width="50%" valign="middle">
						<small class="description">
							<?php esc_html_e("If color value is not inserted, it will be replaced to color set from theme settings", 'javohome');?>
						</small>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td valign="middle"><p><?php esc_html_e("Initial Sticky Header Transparency", 'javohome');?></p></td>
		<td valign="middle">
			<table class="javo-post-header-meta">
				<tr>
					<td width="25%">
						<select name="jvfrm_home_hd[sticky_header_opacity_as]" data-docking>
							<?php
							foreach( $jvfrm_home_options['default_able'] as $label => $value )
							{
								printf(
									"<option value='{$value}' %s>{$label}</option>"
									, selected( $value == $jvfrm_home_query->get("sticky_header_opacity_as"), true, false)
								);
							} ?>
						</select>
					</td>
					<td width="25%">
						<?php
						if( false === ( $jvfrm_home_options['sticky_opacity'] = $jvfrm_home_query->get("sticky_header_opacity") ) )
						{
							$jvfrm_home_options['sticky_opacity'] = 1;
						} ?>
						<input type="text" name="jvfrm_home_hd[sticky_header_opacity]" value="<?php echo (float)$jvfrm_home_options['sticky_opacity'];?>">
					</td>
					<td width="50%" valign="middle">
						<small class="description">
							<?php esc_html_e("Please enter numerical value from 0.0 to 1.0. The higher the value you enter, the more opaque it will be. Ex. 1=opaque, 0= invisible.", 'javohome');?>
						</small>
					</td>
				</tr>
			</table>
		</td>
	</tr>

	<tr>
		<td valign="middle"><p><?php esc_html_e("Sticky Navi Shadow", 'javohome');?></p></td>
		<td valign="middle">
			<table class="javo-post-header-meta">
				<tr>
					<td width="50%" valign="middle">
						<select name="jvfrm_home_hd[sticky_menu_shadow]">
							<?php
							foreach( $jvfrm_home_options['able_disable'] as $label => $value )
							{
								printf( "<option value='{$value}' %s>{$label}</option>", selected( $value == $jvfrm_home_query->get("sticky_menu_shadow"), true, false ) );
							} ?>
						</select>
					</td>
					<td width="50%" valign="middle">
						<small class="description"></small>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>