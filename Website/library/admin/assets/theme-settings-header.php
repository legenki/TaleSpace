<?php
$jvfrm_home_options = Array(
	'header_type' => apply_filters( 'jvfrm_home_options_header_types', Array() )
	, 'header_skin' => Array(
		esc_html__("Dark", 'javohome')							=> ""
		, esc_html__("Light", 'javohome')						=> "light"
	)
	, 'able_disable' => Array(
		esc_html__("Disable", 'javohome')					=> "disabled"
		,esc_html__("Able", 'javohome')							=> "enable"
	)
	, 'sticky_able_disable' => Array(
		esc_html__("Able", 'javohome')							=> "enable"
		,esc_html__("Disable", 'javohome')					=> "disabled"
	)
	, 'header_fullwidth' => Array(
		esc_html__("Center Left", 'javohome')						=> "fixed"
		, esc_html__("Center Right", 'javohome')			=> "fixed-right"
		, esc_html__("Wide", 'javohome')						=> "full"
	)
	, 'header_relation' => Array(
		esc_html__("Transparency menu", 'javohome')	=> "absolute"
		,esc_html__("Default menu", 'javohome')				=> "relative"
	)
	, 'default_header_relation' => Array(
		esc_html__("Default menu", 'javohome')				=> "relative"
		,esc_html__("Transparency menu", 'javohome')	=> "absolute"
	)
); ?>

<div class="jvfrm_home_ts_tab javo-opts-group-tab hidden" tar="header">
	<h2><?php esc_html_e("Heading Settings", 'javohome'); ?> </h2>
	<table class="form-table">

	<!-- <tr><th>
		<?php esc_html_e('My Page Menu Settings','javohome'); ?>
		<span class='description'>
			<?php esc_html_e('My page menu settings', 'javohome');?>
		</span>
	</th><td>
		<h4><?php esc_html_e('Display My Page Menu in the Navigation Bar', 'javohome');?></h4>
	
		<fieldset class="inner">
			<label><input type="checkbox" name="jvfrm_home_ts[nav_show_mypage]" value="use" <?php checked($jvfrm_home_tso->get('nav_show_mypage')== "use");?>><?php esc_html_e('Enabled', 'javohome');?></label>
		</fieldset>
		<div><?php esc_html_e('Please make sure to create a permarlink.', 'javohome');?></div>
		<div><a href='<?php echo admin_url('options-permalink.php');?>'><?php esc_html_e('Please select "POST NAME" in the permarlink list', 'javohome');?></a></div>
	</td></tr> -->
	
	<tr><th>
		<?php esc_html_e( "Default Style", 'javohome');?>
		<span class="description"></span>
	</th><td>

		<?php /**
		<h4><?php esc_html_e( "Topbar", 'javohome');?></h4>
		<fieldset class="inner">
			<?php
			foreach(
				Array(
					'enable'	=> esc_html__( "Enable", 'javohome' ),
					'disable'	=> esc_html__( "Disable", 'javohome' ),
				)
				as $strValue	=> $strLabel
			) printf( "
				<label>
					<input type=\"radio\" name=\"jvfrm_home_ts[topbar_use]\" value=\"{$strValue}\" clss=\"inner\"%s>
						{$strLabel}
				</label>",
				checked( $strValue == $jvfrm_home_tso->get( 'topbar_use', 'enable' ), true, false )
			); ?>
		</fieldset>
		*/ ?>

		<h4><?php esc_html_e( "General", 'javohome');?></h4><hr>
		<fieldset>
			<dl>
				<dt><?php esc_html_e( "Header Menu Type", 'javohome');?></dt>
				<dd>
					<select name="jvfrm_home_ts[hd][header_type]">
						<?php
						foreach( $jvfrm_home_options['header_type'] as $label => $value )
						{
							printf( "<option value='{$value}' %s>{$label}</option>", selected( $value == jvfrm_home_tso()->header->get( 'header_type' ), true, false ) );
						} ?>
					</select>
				</dd>
			</dl>

			<dl>
				<dt><?php esc_html_e( "Header Banner", 'javohome');?></dt>
				<dd style="width:70%;">
					<fieldset>
						<input type="text" name="jvfrm_home_ts[hd][header_banner]" value="<?php echo esc_attr( jvfrm_home_tso()->header->get( 'header_banner' ) );?>" tar="header_banner">
						<input type="button" class="button button-primary fileupload" value="<?php esc_attr_e('Select Image', 'javohome');?>" tar="header_banner">
						<input class="fileuploadcancel button" tar="header_banner" value="<?php esc_attr_e('Delete', 'javohome');?>" type="button">
						<p>
							<?php esc_html_e("Preview",'javohome'); ?><br>
							<img src="<?php echo esc_attr( jvfrm_home_tso()->header->get( 'header_banner' ) ); ?>" tar="header_banner">
						</p>
					</fieldset>
				</dd>
			</dl>

			<dl>
				<dt><?php esc_html_e("2 Rows Type Navigation Transparency",'javohome'); ?></dt>
				<dd>
					<input type="text" name="jvfrm_home_ts[hd][header_opacity_row_2]" value="<?php echo (float)jvfrm_home_tso()->header->get("header_opacity_row_2", 0); ?>">
					<div class="description"><?php esc_html_e("Please enter numerical value from 0.0 to 1.0. The higher the value you enter, the more opaque it will be. Ex. 1=opaque, 0= invisible.", 'javohome');?></div>
				</dd>
			</dl>

			<dl>
				<dt><?php esc_html_e( "Header Menu Skin", 'javohome');?></dt>
				<dd>
					<select name="jvfrm_home_ts[hd][header_skin]">
						<?php
						foreach( $jvfrm_home_options['header_skin'] as $label => $value )
						{
							printf( "<option value='{$value}' %s>{$label}</option>", selected( $value == jvfrm_home_tso()->header->get("header_skin"), true, false ) );
						} ?>
					</select>
					<div class="description"><?php esc_html_e("Depends on this option, logo changes to the color appropriate to the skin and if selected logo of skin option is not uploaded, theme's basic logo will be shown.", 'javohome');?></div>
				</dd>
			</dl>
			<dl>
				<dt><?php esc_html_e( "Initial Header Background Color", 'javohome');?></dt>
				<dd><input type="text" name="jvfrm_home_ts[hd][header_bg]" value="<?php echo esc_attr( jvfrm_home_tso()->header->get("header_bg", "#ffffff"));?>" class="wp_color_picker" data-default-color="#ffffff"></dd>
			</dl>
			<dl>
				<dt><?php esc_html_e( "Initial Header Transparency", 'javohome');?></dt>
				<dd>
					<input type="text" name="jvfrm_home_ts[hd][header_opacity]" value="<?php echo (float)jvfrm_home_tso()->header->get("header_opacity", 1); ?>">
					<div class="description"><?php esc_html_e("Please enter numerical value from 0.0 to 1.0. The higher the value you enter, the more opaque it will be. Ex. 1=opaque, 0= invisible.", 'javohome');?></div>
				</dd>
			</dl>


			<dl>
				<dt><?php esc_html_e( "Dropdown Menu - Background Color", 'javohome');?></dt>
				<dd><input type="text" name="jvfrm_home_ts[hd][header_dropdown_bg]" value="<?php echo esc_attr( jvfrm_home_tso()->header->get("header_dropdown_bg", "#262626"));?>" class="wp_color_picker" data-default-color="#262626"></dd>
			</dl>
			<dl>
			<dl>
				<dt><?php esc_html_e( "Dropdown Menu - Background Hover Color", 'javohome');?></dt>
				<dd><input type="text" name="jvfrm_home_ts[hd][header_dropdown_hover_bg]" value="<?php echo esc_attr( jvfrm_home_tso()->header->get("header_dropdown_hover_bg", "#333333"));?>" class="wp_color_picker" data-default-color="#333333"></dd>
			</dl>
			<dl>
			<dl>
				<dt><?php esc_html_e( "Dropdown Menu - Text Color", 'javohome');?></dt>
				<dd><input type="text" name="jvfrm_home_ts[hd][header_dropdown_text]" value="<?php echo esc_attr( jvfrm_home_tso()->header->get("header_dropdown_text", "#eeeeee"));?>" class="wp_color_picker" data-default-color="#eeeeee"></dd>
			</dl>
			<dl>

			<dl>
				<dt><?php esc_html_e( "Header Size", 'javohome');?></dt>
				<dd>
					<input type="text" name="jvfrm_home_ts[hd][header_size]" value="<?php echo intVal ( jvfrm_home_tso()->header->get( 'header_size' , 50 ) ); ?>">
					<?php esc_html_e( "Pixcel", 'javohome' ); ?>
				</dd>
			</dl>
			<dl>
				<dt><?php esc_html_e( "Navi Shadow", 'javohome');?></dt>
				<dd>
					<select name="jvfrm_home_ts[hd][header_shadow]">
						<?php
						foreach( $jvfrm_home_options['able_disable'] as $label => $value )
						{
							printf( "<option value='{$value}' %s>{$label}</option>", selected( $value == jvfrm_home_tso()->header->get("header_shadow"), true, false ) );
						} ?>
					</select>
				</dd>
			</dl>
			<dl>
				<dt><?php esc_html_e( "Navi Position", 'javohome');?></dt>
				<dd>
					<select name="jvfrm_home_ts[hd][header_fullwidth]">
						<?php
						foreach( $jvfrm_home_options['header_fullwidth'] as $label => $value )
						{
							printf( "<option value='{$value}' %s>{$label}</option>", selected( $value == jvfrm_home_tso()->header->get("header_fullwidth"), true, false ) );
						} ?>
					</select>
				</dd>
			</dl>
			<dl>
				<dt><?php esc_html_e( "Navi Type", 'javohome');?></dt>
				<dd>
					<select name="jvfrm_home_ts[hd][header_relation]">
						<?php
						foreach( $jvfrm_home_options['default_header_relation'] as $label => $value )
						{
							printf( "<option value='{$value}' %s>{$label}</option>", selected( $value == jvfrm_home_tso()->header->get("header_relation"), true, false ) );
						} ?>
					</select>
					<div class="description"><?php esc_html_e("Caution: If you choose transparent menu type, page's main text contents ascends as much as menu's height to make menu transparent.", 'javohome');?></div>
				</dd>
			</dl>
		</fieldset>
		<h4><?php esc_html_e("Sticky Menu", 'javohome'); ?></h4><hr>
		<fieldset>
			<dl>
				<dt><?php esc_html_e( "Sticky Navi on / off", 'javohome');?></dt>
				<dd>
					<select name="jvfrm_home_ts[hd][header_sticky]">
						<?php
						foreach( $jvfrm_home_options['sticky_able_disable'] as $label => $value )
						{
							printf( "<option value='{$value}' %s>{$label}</option>", selected( $value == jvfrm_home_tso()->header->get("header_sticky"), true, false ) );
						} ?>
					</select>
				</dd>
			</dl>
			<dl>
				<dt><?php esc_html_e( "Initial Sticky Header Background Color", 'javohome');?></dt>
				<dd>
					<input type="text" name="jvfrm_home_ts[hd][sticky_header_bg]" value="<?php echo esc_attr( jvfrm_home_tso()->header->get("sticky_header_bg", "#ffffff"));?>" class="wp_color_picker" data-default-color="#ffffff">
				</dd>
			</dl>
			<dl>
				<dt><?php esc_html_e( "Initial Sticky Header Transparency", 'javohome');?></dt>
				<dd>
					<input type="text" name="jvfrm_home_ts[hd][sticky_header_opacity]" value="<?php echo esc_attr( jvfrm_home_tso()->header->get("sticky_header_opacity", 1));?>">
					<div class="description"><?php esc_html_e("Please enter numerical value from 0.0 to 1.0. The higher the value you enter, the more opaque it will be. Ex. 1=opaque, 0= invisible.", 'javohome');?></div>
				</dd>
			</dl>
			<dl>
				<dt><?php esc_html_e( "Sticky Menu Skin", 'javohome');?></dt>
				<dd>
					<select name="jvfrm_home_ts[hd][sticky_header_skin]">
						<?php
						foreach( $jvfrm_home_options['header_skin'] as $label => $value )
						{
							printf( "<option value='{$value}' %s>{$label}</option>", selected( $value == jvfrm_home_tso()->header->get("sticky_header_skin"), true, false ) );
						} ?>
					</select>
					<div class="description"><?php esc_html_e("Depends on this option, logo changes to the color appropriate to the skin and if selected logo of skin option is not uploaded, theme's basic logo will be shown.", 'javohome');?></div>
				</dd>
			</dl>

			<dl>
				<dt><?php esc_html_e( "Sticky Menu Shadow", 'javohome');?></dt>
				<dd>
					<select name="jvfrm_home_ts[hd][sticky_menu_shadow]">
						<?php
						foreach( $jvfrm_home_options['able_disable'] as $label => $value )
						{
							printf( "<option value='{$value}' %s>{$label}</option>", selected( $value == jvfrm_home_tso()->header->get("sticky_menu_shadow"), true, false ) );
						} ?>
					</select>
				</dd>
			</dl>
		</fieldset>

		<h4><?php esc_html_e("Navi on mobile setting", 'javohome'); ?></h4><hr>
		<fieldset>
			<dl>
				<dt><?php esc_html_e( "Initial Mobile Header Background Color", 'javohome');?></dt>
				<dd>
					<input type="text" name="jvfrm_home_ts[hd][mobile_header_bg]" value="<?php echo esc_attr( jvfrm_home_tso()->header->get("mobile_header_bg", "#ffffff"));?>" class="wp_color_picker" data-default-color="#ffffff">
				</dd>
			</dl>
			<dl>
				<dt><?php esc_html_e( "Initial Mobile Header Transparency", 'javohome');?></dt>
				<dd>
					<input type="text" name="jvfrm_home_ts[hd][mobile_header_opacity]" value="<?php echo esc_attr( jvfrm_home_tso()->header->get("mobile_header_opacity", 1));?>">
					<div class="description"><?php esc_html_e("Please enter numerical value from 0.0 to 1.0. The higher the value you enter, the more opaque it will be. Ex. 1=opaque, 0= invisible.", 'javohome');?></div>
				</dd>
			</dl>
			<dl>
				<dt><?php esc_html_e( "Header Menu Skin", 'javohome');?></dt>
				<dd>
					<select name="jvfrm_home_ts[hd][mobile_header_skin]">
						<?php
						foreach( $jvfrm_home_options['header_skin'] as $label => $value )
						{
							printf( "<option value='{$value}' %s>{$label}</option>", selected( $value == jvfrm_home_tso()->header->get("mobile_header_skin"), true, false ) );
						} ?>
					</select>
					<div class="description"><?php esc_html_e("Depends on this option, logo changes to the color appropriate to the skin and if selected logo of skin option is not uploaded, theme's basic logo will be shown.", 'javohome');?></div>
				</dd>
			</dl>
			<!--
			<dl>
				<dt><?php esc_html_e( "Canvas Menu Button", 'javohome');?></dt>
				<dd>
					<label>
						<input
							type="radio"
							name="jvfrm_home_ts[btn_header_right_menu_trigger]"
							value="enable"
							<?php checked($jvfrm_home_tso->get('btn_header_right_menu_trigger') == 'enable' );?>
						>
							<?php esc_html_e('Enable', 'javohome');?>
					</label>
					<label>
						<input
							type="radio"
							name="jvfrm_home_ts[btn_header_right_menu_trigger]"
							value="x-hide"
							<?php checked($jvfrm_home_tso->get('btn_header_right_menu_trigger') == 'x-hide', '' );?>
						>
							<?php esc_html_e('Hide', 'javohome');?>
					</label>
				</dd>
			</dl>
			<dl>
				<dt><?php esc_html_e( "Responsive Menu Button", 'javohome');?></dt>
				<dd>
					<label>
						<input
							type="radio"
							name="jvfrm_home_ts[btn_header_top_level_trigger]"
							value="enable"
							<?php checked($jvfrm_home_tso->get('btn_header_top_level_trigger') == 'enable' );?>
						>
							<?php esc_html_e('Enable', 'javohome');?>
					</label>
					<label>
						<input
							type="radio"
							name="jvfrm_home_ts[btn_header_top_level_trigger]"
							value="x-hide"
							<?php checked($jvfrm_home_tso->get('btn_header_top_level_trigger') == 'x-hide','' );?>
						>
							<?php esc_html_e('Hide', 'javohome');?>
					</label>
				</dd>
			</dl>
			-->
		</fieldset>

		<h4><?php esc_html_e( "Single Post Page Menu", 'javohome'); ?></h4><hr>
		<fieldset class="inner">
			<dl>
				<dt><?php esc_html_e( "Single Post Page Menu Type", 'javohome');?></dt>
				<dd>
					<select name="jvfrm_home_ts[hd][single_post_page_header_type]">
						<?php
						foreach( $jvfrm_home_options['header_type'] as $label => $value )
						{
							printf( "<option value='{$value}' %s>{$label}</option>", selected( $value == jvfrm_home_tso()->header->get( 'single_post_page_header_type' ), true, false ) );
						} ?>
					</select>
				</dd>
			</dl>

			<dl>
				<dt><?php esc_html_e( "Navi Type", 'javohome');?></dt>
				<dd>
					<select name="jvfrm_home_ts[hd][single_post_header_relation]">
						<?php
						foreach( $jvfrm_home_options['header_relation'] as $label => $value )
						{
							printf( "<option value='{$value}' %s>{$label}</option>", selected( $value == jvfrm_home_tso()->header->get("single_post_header_relation"), true, false ) );
						} ?>
					</select>
					<div class="description"><?php esc_html_e("Caution: If you choose transparent menu type, page's main text contents ascends as much as menu's height to make menu transparent.", 'javohome');?></div>
				</dd>
			</dl>

			<dl>
				<dt><?php esc_html_e( "Background Color", 'javohome');?></dt>
				<dd>
					<input name="jvfrm_home_ts[hd][single_post_page_menu_bg_color]" type="text" value="<?php echo esc_attr( jvfrm_home_tso()->header->get( 'single_post_page_menu_bg_color' ) );?>" class="wp_color_picker" data-default-color="#000000">
				</dd>
			</dl>

			<dl>
				<dt><?php esc_html_e( "Text Color", 'javohome');?></dt>
				<dd>
					<input name="jvfrm_home_ts[hd][single_post_page_menu_text_color]" type="text" value="<?php echo esc_attr( jvfrm_home_tso()->header->get( 'single_post_page_menu_text_color' ) );?>" class="wp_color_picker" data-default-color="#ffffff">
				</dd>
			</dl>

			<dl>
				<dt><?php esc_html_e( "Initial Header Transparency", 'javohome');?></dt>
				<dd>
					<input type="text" name="jvfrm_home_ts[hd][single_post_header_opacity]" value="<?php echo esc_attr( jvfrm_home_tso()->header->get("single_post_header_opacity", 0 ) );?>">
					<div class="description"><?php esc_html_e("Please enter numerical value from 0.0 to 1.0. The higher the value you enter, the more opaque it will be. Ex. 1=opaque, 0= invisible.", 'javohome');?></div>
				</dd>
			</dl>
		</fieldset>

		<h4><?php esc_html_e( "Single Property Page Menu", 'javohome'); ?></h4><hr>
		<fieldset class="inner">

			<dl>
				<dt><?php esc_html_e( "Navi Type", 'javohome');?></dt>
				<dd>
					<select name="jvfrm_home_ts[hd][single_header_relation]">
						<?php
						foreach( $jvfrm_home_options['header_relation'] as $label => $value )
						{
							printf( "<option value='{$value}' %s>{$label}</option>", selected( $value == jvfrm_home_tso()->header->get("single_header_relation"), true, false ) );
						} ?>
					</select>
					<div class="description"><?php esc_html_e("Caution: If you choose transparent menu type, page's main text contents ascends as much as menu's height to make menu transparent.", 'javohome');?></div>
				</dd>
			</dl>

			<dl>
				<dt><?php esc_html_e( "Background Color", 'javohome');?></dt>
				<dd>
					<input name="jvfrm_home_ts[single_page_menu_bg_color]" type="text" value="<?php echo esc_attr( $jvfrm_home_tso->get( 'single_page_menu_bg_color' ) );?>" class="wp_color_picker" data-default-color="#000000">
				</dd>
			</dl>

			<dl>
				<dt><?php esc_html_e( "Text Color", 'javohome');?></dt>
				<dd>
					<input name="jvfrm_home_ts[single_page_menu_text_color]" type="text" value="<?php echo esc_attr( $jvfrm_home_tso->get( 'single_page_menu_text_color' ) );?>" class="wp_color_picker" data-default-color="#ffffff">
				</dd>
			</dl>

			<dl>
				<dt><?php esc_html_e( "Initial Header Transparency", 'javohome');?></dt>
				<dd>
					<input type="text" name="jvfrm_home_ts[hd][single_header_opacity]" value="<?php echo esc_attr( jvfrm_home_tso()->header->get("single_header_opacity", 0 ) );?>">
					<div class="description"><?php esc_html_e("Please enter numerical value from 0.0 to 1.0. The higher the value you enter, the more opaque it will be. Ex. 1=opaque, 0= invisible.", 'javohome');?></div>
				</dd>
			</dl>
		</fieldset>

		<h4><?php esc_html_e("Navi Space Setting", 'javohome'); ?></h4><hr>
		<fieldset>
			<dl>
				<dt><?php esc_html_e( "Navi Height", 'javohome');?></dt>
				<dd>
					<input type="text" name="jvfrm_home_ts[hd][jvfrm_home_header_height]" value="<?php echo esc_attr( jvfrm_home_tso()->header->get("jvfrm_home_header_height") );?>">px
				</dd>
			</dl>

			<dl>
				<dt><?php esc_html_e( "Navi Padding Left", 'javohome');?></dt>
				<dd>
					<input type="text" name="jvfrm_home_ts[hd][jvfrm_home_header_padding_left]" value="<?php echo esc_attr( jvfrm_home_tso()->header->get("jvfrm_home_header_padding_left") );?>">px
				</dd>
			</dl>

			<dl>
				<dt><?php esc_html_e( "Navi Padding Right", 'javohome');?></dt>
				<dd>
					<input type="text" name="jvfrm_home_ts[hd][jvfrm_home_header_padding_right]" value="<?php echo esc_attr( jvfrm_home_tso()->header->get("jvfrm_home_header_padding_right") );?>">px
				</dd>
			</dl>

			<dl>
				<dt><?php esc_html_e( "Navi Padding Top", 'javohome');?></dt>
				<dd>
					<input type="text" name="jvfrm_home_ts[hd][jvfrm_home_header_padding_top]" value="<?php echo esc_attr( jvfrm_home_tso()->header->get("jvfrm_home_header_padding_top") );?>">px
				</dd>
			</dl>

			<dl>
				<dt><?php esc_html_e( "Navi Padding Bottom", 'javohome');?></dt>
				<dd>
					<input type="text" name="jvfrm_home_ts[hd][jvfrm_home_header_padding_bottom]" value="<?php echo esc_attr( jvfrm_home_tso()->header->get("jvfrm_home_header_padding_bottom") );?>">px
				</dd>
			</dl>
		</fieldset>
	</td></tr>
	</table>
</div>