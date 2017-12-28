<div class="jvfrm_home_ts_tab javo-opts-group-tab hidden" tar="general">
<!-- Themes setting > General -->
	<h2><?php esc_html_e("General", 'javohome');?></h2>
	<table class="form-table">
	<tr><th>
		<?php esc_html_e("Page Layout Setting",'javohome'); ?>
	</th><td>
		<h4><?php esc_html_e('Page Layout', 'javohome');?></h4>
		<fieldset class="inner">

			<label style="padding: 0 15px 0;">
				<input type="radio" name="jvfrm_home_ts[layout_style_boxed]" value='' <?php checked( '' == jvfrm_home_tso()->get( 'layout_style_boxed', '' ) );?>>
				<?php esc_html_e( "Wide (Width : 1170px)", 'javohome');?>
			</label>

			<label style="padding: 0 15px 0;">
				<input type="radio" name="jvfrm_home_ts[layout_style_boxed]" value='wide-1400' <?php checked( 'wide-1400' == jvfrm_home_tso()->get( 'layout_style_boxed', '' ) );?>>
				<?php esc_html_e( "Wide (Width : 1400px)", 'javohome');?>
			</label>

			<label style="padding: 0 15px 0;">
				<input type="radio" name="jvfrm_home_ts[layout_style_boxed]" value='active' <?php checked( 'active' == jvfrm_home_tso()->get( 'layout_style_boxed', '' ) );?>>
				<?php esc_html_e( "Boxed (Width : 1170px)", 'javohome');?>
			</label>

			<label style="padding: 0 15px 0;">
				<input type="radio" name="jvfrm_home_ts[layout_style_boxed]" value='active-1400' <?php checked( 'active-1400' == jvfrm_home_tso()->get( 'layout_style_boxed', '' ) );?>>
				<?php esc_html_e( "Boxed (Width : 1400px)", 'javohome');?>
			</label>

		</fieldset>

		<h4><?php esc_html_e('Boxed layout shadow', 'javohome');?></h4>
		<fieldset class="inner">
			<label style="padding: 0 15px 0;">
				<input type="radio" name="jvfrm_home_ts[layout_boxed_shadow]" value='' <?php checked( '' == $jvfrm_home_tso->get('layout_boxed_shadow') );?>>
				<?php esc_html_e( "Enable", 'javohome');?>
			</label>
			<label style="padding: 0 15px 0;">
				<input type="radio" name="jvfrm_home_ts[layout_boxed_shadow]" value='disable' <?php checked( 'disable' == $jvfrm_home_tso->get('layout_boxed_shadow') );?>>
				<?php esc_html_e( "Disable", 'javohome');?>
			</label>
		</fieldset>

		<?php
		/** // Later use
		<h4><?php esc_html_e( "My Page Style", 'javohome' ); ?></h4>
		<fieldset class="inner">
			<select name="jvfrm_home_ts[mypage_style]">
				<?php

				foreach(
					Array(
						''				=> esc_html__( "Type A (default)", 'javohome' ),
						'type-b'		=> esc_html__( "Type B", 'javohome' ),
					) as $type => $label ) {
					printf(
						"<option value=\"{$type}\" %s>{$label}</option>",
						selected( $jvfrm_home_tso->get( 'mypage_style', '' ) == $type, true, false )
					);
				}
				?>
			</select>
		</fieldset>
		*/ ?>
		<h4><?php esc_html_e("Background Image",'javohome'); ?></h4>
		<fieldset class="inner">
			<p>
				<input type="text" name="jvfrm_home_ts[page_background_image]" value="<?php echo esc_attr( $jvfrm_home_tso->get('page_background_image'));?>" tar="g405">
				<input type="button" class="button button-primary fileupload" value="<?php esc_attr_e('Select Image', 'javohome');?>" tar="g405">
				<input class="fileuploadcancel button" tar="g405" value="<?php esc_attr_e('Delete', 'javohome');?>" type="button">
			</p>
			<p>
				<?php esc_html_e("Preview",'javohome'); ?><br>
				<img src="<?php echo esc_attr( $jvfrm_home_tso->get('page_background_image'));?>" tar="g405">
			</p>
		</fieldset>
	</td></tr><tr><th>
		<?php esc_html_e("Blank Image Settings",'javohome'); ?>
		<span class='description'>
			<?php esc_html_e("Blank (or white) images are shown when no images are available. The preferred dimensions are 300x300.", 'javohome');?>
		</span>
	</th><td>
		<h4><?php esc_html_e("Blank Image",'javohome'); ?></h4>
		<fieldset class="inner">
			<p>
				<input type="text" name="jvfrm_home_ts[no_image]" value="<?php echo esc_attr( $jvfrm_home_tso->get('no_image', JVFRM_HOME_IMG_DIR.'/no-image.png'));?>" tar="g404">
				<input type="button" class="button button-primary fileupload" value="<?php esc_attr_e('Select Image', 'javohome');?>" tar="g404">
				<input class="fileuploadcancel button" tar="g404" value="<?php esc_attr_e('Delete', 'javohome');?>" type="button">
			</p>
			<p>
				<?php esc_html_e("Preview",'javohome'); ?><br>
				<img src="<?php echo esc_attr( $jvfrm_home_tso->get('no_image', JVFRM_HOME_IMG_DIR.'/no-image.png'));?>" tar="g404">
			</p>
		</fieldset>
	</td></tr><tr><th>
		<?php esc_html_e("Login Settings",'javohome'); ?>
		<span class='description'>
			<?php esc_html_e("The page to redirect users to after a successful login.", 'javohome');?>
		</span>
	</th><td>
		<!--
		<h4><?php esc_html_e("Login Modal Style",'javohome'); ?> :</h4>
		<fieldset class="inner">
			<?php
			$jvfrm_home_login_modal_types = Array(
				1		=> esc_html__('Classic Style', 'javohome')
				, 2		=> esc_html__('Simple Style (Default)', 'javohome')
			);?>

			<select name="jvfrm_home_ts[login_modal_type]">
				<?php
				foreach( $jvfrm_home_login_modal_types as $key => $label )
				{
					printf('<option value="%s"%s>%s</option>', $key, selected( $key == $jvfrm_home_tso->get('login_modal_type', 2), true, false), $label );
				} ?>
			</select>
		</fieldset>
		//-->

		<h4><?php esc_html_e("Redirect to",'javohome'); ?> :</h4>
		<fieldset class="inner">
			<select name="jvfrm_home_ts[login_redirect]">
				<?php
				foreach(
					Array(
						'' => esc_html__('Profile Page (Default)', 'javohome'),
						'home' => esc_html__('Main Page', 'javohome'),
						'current' => esc_html__('Current Page', 'javohome'),
						'admin' => esc_html__('WordPress Profile Page', 'javohome')
					) as $key => $text){
					printf(
						'<option value="%1$s" %2$s>%3$s</option>',
						$key,
						selected( jvfrm_home_tso()->get( 'login_redirect' ) == $key, true, false ),
						$text
					);
				} ?>
			</select>
		</fieldset>


		<h4><?php esc_html_e( "User Agreement",'javohome'); ?> :</h4>
		<fieldset class="inner">
			<select name="jvfrm_home_ts[agree_register]">
				<option value=""><?php esc_html_e( "Disable", 'javohome' );?></option>
				<?php
				if( $pages = get_posts( "post_type=page&post_status=publish&posts_per_page=-1&suppress_filters=0" ) )
				{
					printf( "<optgroup label=\"%s\">", esc_html__( "Select a page for user agreement", 'javohome' ) );
					foreach( $pages as $post )
						printf(
							"<option value=\"{$post->ID}\" %s>{$post->post_title}</option>"
							, selected( $post->ID == $jvfrm_home_tso->get( 'agree_register', '' ), true, false )
						);
					echo "</optgroup>";
				} ?>
			</select>
		</fieldset>

	</td></tr>
	<tr><th>
		<?php esc_html_e("Color Settings",'javohome'); ?>
		<span class="description">
			<?php esc_html_e("Choose colors to match your theme.", 'javohome');?>
		</span>
	</th><td>

		<h4><?php esc_html_e("Primary Color Selection", 'javohome'); ?></h4>
		<fieldset class="inner">
			<input name="jvfrm_home_ts[total_button_color]" type="text" value="<?php echo esc_attr( $jvfrm_home_tso->get( 'total_button_color' )  );?>" class="wp_color_picker" data-default-color="#0FAF97">
		</fieldset>

		<h4><?php esc_html_e( "Primary Font Color Selection", 'javohome' ); ?></h4>
		<fieldset class="inner">
			<input name="jvfrm_home_ts[primary_font_color]" type="text" value="<?php echo esc_attr( $jvfrm_home_tso->get( 'primary_font_color' ) );?>" class="wp_color_picker" data-default-color="#fff">
		</fieldset>

		<h4><?php esc_html_e("Border Color Setup", 'javohome'); ?></h4>
		<fieldset class="inner">
			<label><input type="radio" name="jvfrm_home_ts[total_button_border_use]" value="use" <?php checked($jvfrm_home_tso->get('total_button_border_use') == "use");?>><?php esc_html_e('Use', 'javohome');?></label>
			<label><input type="radio" name="jvfrm_home_ts[total_button_border_use]" value="" <?php checked($jvfrm_home_tso->get('total_button_border_use')== "");?>><?php esc_html_e('Not Use', 'javohome');?></label>
		</fieldset>

		<h4><?php esc_html_e("Border Color Selection", 'javohome'); ?></h4>
		<fieldset class="inner">
			<input name="jvfrm_home_ts[total_button_border_color]" type="text" value="<?php echo esc_attr( $jvfrm_home_tso->get( 'total_button_border_color' ) );?>" class="wp_color_picker" data-default-color="#0FAF97">
		</fieldset>

	</td></tr><tr><th>

		<?php esc_html_e('Miscellaneous Settings','javohome'); ?>
		<span class='description'>
			<?php esc_html_e('Other settings', 'javohome');?>
		</span>
	</th><td>
		<!-- <h4><?php esc_html_e('Preloader', 'javohome');?></h4>
		<fieldset class="inner">

			<label>
				<input type="radio" name="jvfrm_home_ts[preloader_hide]" value="use" <?php checked( 'use' == $jvfrm_home_tso->get('preloader_hide') );?>>
				<?php esc_html_e( "Enable", 'javohome');?>
			</label>
			<label>
				<input type="radio" name="jvfrm_home_ts[preloader_hide]" value="" <?php checked( '' == $jvfrm_home_tso->get('preloader_hide') );?>>
				<?php esc_html_e( "Disable", 'javohome');?>
			</label>

		</fieldset> -->

		<h4><?php esc_html_e('Fixed Contact-Us Button (on Right-Bottom)', 'javohome');?></h4>
		<fieldset class="inner">

			<label>
				<input type="radio" name="jvfrm_home_ts[scroll_rb_contact_us]" value="use" <?php checked( 'use' == $jvfrm_home_tso->get('scroll_rb_contact_us') );?>>
				<?php esc_html_e( "Enable", 'javohome');?>
			</label>
			<label>
				<input type="radio" name="jvfrm_home_ts[scroll_rb_contact_us]" value="" <?php checked( '' == $jvfrm_home_tso->get('scroll_rb_contact_us') );?>>
				<?php esc_html_e( "Disable", 'javohome');?>
			</label>

		</fieldset>

		<h4><?php esc_html_e('WordPress Admin Top Bar (Except for the Admin)', 'javohome');?></h4>
		<fieldset class="inner">

			<label>
				<input type="radio" name="jvfrm_home_ts[adminbar_hidden]" value="" <?php checked( '' == $jvfrm_home_tso->get('adminbar_hidden') );?>>
				<?php esc_html_e( "Enable", 'javohome');?>
			</label>
			<label>
				<input type="radio" name="jvfrm_home_ts[adminbar_hidden]" value="use" <?php checked( 'use' == $jvfrm_home_tso->get('adminbar_hidden') );?>>
				<?php esc_html_e( "Disable", 'javohome');?>
			</label>

		</fieldset>

		<h4><?php esc_html_e( "Use Lazy Loading Images", 'javohome');?></h4>
		<fieldset class="inner">
			<label>
				<input type="radio" name="jvfrm_home_ts[lazyload]" value="" <?php checked( '' == $jvfrm_home_tso->get('lazyload') );?>>
				<?php esc_html_e( "Enable", 'javohome');?>
			</label>
			<label>
				<input type="radio" name="jvfrm_home_ts[lazyload]" value="disable" <?php checked( 'disable' == $jvfrm_home_tso->get('lazyload') );?>>
				<?php esc_html_e( "Disable", 'javohome');?>
			</label>
		</fieldset>

	</td></tr><tr><th>
		<?php esc_html_e("The contact form floating on all pages",'javohome'); ?>
	</th><td>
		<h4><?php esc_html_e('This form is for Contact Modal', 'javohome');?></h4>
		<fieldset class="inner">

			<label style="padding: 0 15px 0;">
				<input type="radio" name="jvfrm_home_ts[modal_contact_type]" value='' <?php checked( '' == $jvfrm_home_tso->get('modal_contact_type') );?>>
				<?php esc_html_e( "None", 'javohome');?>
			</label>
			<label style="padding: 0 15px 0;">
				<input type="radio" name="jvfrm_home_ts[modal_contact_type]" value='contactform' <?php checked( 'contactform' == $jvfrm_home_tso->get('modal_contact_type') );?>>
				<?php esc_html_e( "Contact Form", 'javohome');?>
			</label>
			<label style="padding: 0 15px 0;">
				<input type="radio" name="jvfrm_home_ts[modal_contact_type]" value='ninjaform' <?php checked( 'ninjaform' == $jvfrm_home_tso->get('modal_contact_type') );?>>
				<?php esc_html_e( "Ninja Form", 'javohome');?>
			</label>

		</fieldset>
		<fieldset class="inner">
			<label>
				<?php esc_html_e('Contact Form ID', 'javohome');?><br>
				<input type="text" name="jvfrm_home_ts[modal_contact_form_id]" value="<?php echo esc_attr( $jvfrm_home_tso->get('modal_contact_form_id' ) );?>">
			</label>
			<p><?php esc_html_e('To create a Contact Form ID, please go to the Contact Form Menu.', 'javohome');?></p>
		</fieldset>
	</td></tr><tr><th>
		<?php esc_html_e("My Page PM Form Settings",'javohome'); ?>
	</th><td>
		<h4><?php esc_html_e('This form is for PM', 'javohome');?></h4>
		<fieldset class="inner">

			<label style="padding: 0 15px 0;">
				<input type="radio" name="jvfrm_home_ts[pm_contact_type]" value='' <?php checked( '' == $jvfrm_home_tso->get('pm_contact_type') );?>>
				<?php esc_html_e( "None", 'javohome');?>
			</label>
			<label style="padding: 0 15px 0;">
				<input type="radio" name="jvfrm_home_ts[pm_contact_type]" value='contactform' <?php checked( 'contactform' == $jvfrm_home_tso->get('pm_contact_type') );?>>
				<?php esc_html_e( "Contact Form", 'javohome');?>
			</label>
			<label style="padding: 0 15px 0;">
				<input type="radio" name="jvfrm_home_ts[pm_contact_type]" value='ninjaform' <?php checked( 'ninjaform' == $jvfrm_home_tso->get('pm_contact_type') );?>>
				<?php esc_html_e( "Ninja Form", 'javohome');?>
			</label>

		</fieldset>
		<fieldset class="inner">
			<label>
				<?php esc_html_e('PM Form ID', 'javohome');?><br>
				<input type="text" name="jvfrm_home_ts[pm_contact_form_id]" value="<?php echo esc_attr( $jvfrm_home_tso->get('pm_contact_form_id' ) );?>">
			</label>
			<p><?php esc_html_e('To create a Contact Form ID, please go to the Contact Form Menu.', 'javohome');?></p>
		</fieldset>
	</td></tr><tr><th>
		<?php esc_html_e("Plugins Settings",'javohome'); ?>
	</th><td>

		<h4><?php esc_html_e( "Auto generation for css files from less files", 'javohome');?></h4>
		<fieldset class="inner">

			<label style="padding: 0 15px 0;">
				<input type="radio" name="jvfrm_home_ts[wp_less]" value='' <?php checked( '' == jvfrm_home_tso()->get('wp_less') );?>>
				<?php esc_html_e( "Disable ( Default )", 'javohome');?>
			</label>
			<label style="padding: 0 15px 0;">
				<input type="radio" name="jvfrm_home_ts[wp_less]" value='enable' <?php checked( 'enable' == jvfrm_home_tso()->get('wp_less') );?>>
				<?php esc_html_e( "Enable", 'javohome');?>
			</label>

			<div class="description"><?php esc_html_e( "(Recommended : disable - it's already included necessary css files )", 'javohome');?></div>

		</fieldset>

		<h4><?php esc_html_e( "Javo Home Core Module Excerpt", 'javohome');?></h4>

		<fieldset class="inner">

			<label style="padding: 0 15px 0;">
				<input type="radio" name="jvfrm_home_ts[core_module_excerpt]" value='' <?php checked( '' == jvfrm_home_tso()->get('core_module_excerpt') );?>>
				<?php esc_html_e( "wp_trim_words ( Default )", 'javohome');?>
			</label>
			<label style="padding: 0 15px 0;">
				<input type="radio" name="jvfrm_home_ts[core_module_excerpt]" value='mb_substr' <?php checked( 'mb_substr' == jvfrm_home_tso()->get('core_module_excerpt') );?>>
				<?php esc_html_e( "mb_substr", 'javohome');?>
			</label>
			<div class="description"><?php esc_html_e( "(mb_subsr is for a few languages - excerpt length. ex. Chinese)", 'javohome');?></div>

		</fieldset>

	</td></tr>
	</table>
</div>