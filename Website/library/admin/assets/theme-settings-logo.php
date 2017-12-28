<div class="jvfrm_home_ts_tab javo-opts-group-tab hidden" tar="logo">

<!-- Themes setting > Logo -->
	<h2><?php esc_html_e("Logo", 'javohome');?></h2>
	<table class="form-table">
	<tr><th>
		<?php esc_html_e("Header Logo Settings",'javohome'); ?>
		<span class='description'>
			<?php esc_html_e("Uploaded logos will be displayed on the header in their appropriate locations.", 'javohome');?>
		</span>
	</th>
	<td>

		<h4><?php esc_html_e("Main Logo ( Dark / Default )",'javohome'); ?></h4>
		<fieldset class="inner">
			<input type="text" name="jvfrm_home_ts[logo_url]" value="<?php echo esc_attr( $jvfrm_home_tso->get('logo_url') );?>" tar="logo_dark">
			<input type="button" class="button button-primary fileupload" value="<?php esc_attr_e('Select Image', 'javohome');?>" tar="logo_dark">
			<input class="fileuploadcancel button" tar="logo_dark" value="<?php esc_attr_e('Delete', 'javohome');?>" type="button">
			<p>
				<?php esc_html_e("Preview",'javohome'); ?><br>
				<img src="<?php echo esc_attr( $jvfrm_home_tso->get('logo_url') );?>" tar="logo_dark">
			</p>
		</fieldset>

		<h4><?php esc_html_e("Main Logo ( Light )",'javohome'); ?></h4>
		<fieldset class="inner">
			<input type="text" name="jvfrm_home_ts[logo_light_url]" value="<?php echo esc_attr( $jvfrm_home_tso->get('logo_light_url') );?>" tar="logo_light">
			<input type="button" class="button button-primary fileupload" value="<?php esc_attr_e('Select Image', 'javohome');?>" tar="logo_light">
			<input class="fileuploadcancel button" tar="logo_light" value="<?php esc_attr_e('Delete', 'javohome');?>" type="button">
			<p>
				<?php esc_html_e("Preview",'javohome'); ?><br>
				<img src="<?php echo esc_attr( $jvfrm_home_tso->get('logo_light_url') );?>" tar="logo_light">
			</p>
		</fieldset>

		<h4><?php esc_html_e("Mobile Logo",'javohome'); ?></h4>
		<fieldset class="inner">
			<input type="text" name="jvfrm_home_ts[mobile_logo_url]" value="<?php echo esc_attr( $jvfrm_home_tso->get('mobile_logo_url') );?>" tar="mobile_logo">
			<input type="button" class="button button-primary fileupload" value="<?php esc_attr_e('Select Image', 'javohome');?>" tar="mobile_logo">
			<input class="fileuploadcancel button" tar="mobile_logo" value="<?php esc_attr_e('Delete', 'javohome');?>" type="button">
			<p>
				<?php esc_html_e("Preview",'javohome'); ?><br>
				<img src="<?php echo esc_attr( $jvfrm_home_tso->get( 'mobile_logo_url' ) );?>" tar="mobile_logo">
			</p>
		</fieldset>

		<h4><?php esc_html_e("Retina Logo",'javohome'); ?></h4>
		<fieldset class="inner">
			<p>
				<input type="text" name="jvfrm_home_ts[retina_logo_url]" value="<?php echo esc_attr( $jvfrm_home_tso->get( 'retina_logo_url' ) );?>" tar="g02">
				<input type="button" class="button button-primary fileupload" value="<?php esc_html_e('Select Image', 'javohome');?>" tar="g02">
				<input class="fileuploadcancel button" tar="g02" value="<?php esc_html_e('Delete', 'javohome');?>" type="button">
			</p>
			<p>
				<?php esc_html_e("Preview",'javohome'); ?><br>
				<img src="<?php echo esc_attr( $jvfrm_home_tso->get( 'retina_logo_url' ) );?>" tar="g02">
			</p>
		</fieldset>

		<h4><?php esc_html_e('Single Listing Page Logo', 'javohome');?></h4>
		<fieldset class="inner">
			<input type="text" name="jvfrm_home_ts[single_item_logo]" value="<?php echo esc_attr( $jvfrm_home_tso->get('single_item_logo', null) );?>" tar="single_item_logo">
			<input type="button" class="button button-primary fileupload" value="<?php esc_attr_e('Select Image', 'javohome');?>" tar="single_item_logo">
			<input class="fileuploadcancel button" tar="single_item_logo" value="<?php esc_attr_e('Delete', 'javohome');?>" type="button">
			<p>
				<?php esc_html_e("Preview",'javohome'); ?><br>
				<img src="<?php echo esc_attr( $jvfrm_home_tso->get('single_item_logo', null ) );?>" tar="single_item_logo">
			</p>
		</fieldset>

	</td></tr><tr><th>
		<?php esc_html_e("Footer Logo Settings",'javohome'); ?>
		<span class='description'>
			<?php esc_html_e("Uploaded logos will be displayed on the footer in their appropriate locations.", 'javohome');?>
		</span>
	</th><td>
		<h4><?php esc_html_e("Logo",'javohome'); ?></h4>
		<fieldset class="inner">
			<p>
				<input type="text" name="jvfrm_home_ts[bottom_logo_url]" value="<?php echo esc_attr( $jvfrm_home_tso->get( 'bottom_logo_url' ) );?>" tar="g03">
				<input type="button" class="button button-primary fileupload" value="<?php esc_attr_e('Select Image', 'javohome');?>" tar="g03">
				<input class="fileuploadcancel button" tar="g03" value="<?php esc_attr_e('Delete', 'javohome');?>" type="button">
			</p>
			<p>
				<?php esc_html_e("Preview",'javohome'); ?><br>
				<img src="<?php echo esc_attr( $jvfrm_home_tso->get( 'bottom_logo_url' ) );?>" tar="g03">
			</p>
		</fieldset>

		<h4><?php esc_html_e("Retina Logo",'javohome'); ?></h4>
		<fieldset class="inner">
			<p>
				<input type="text" name="jvfrm_home_ts[bottom_retina_logo_url]" value="<?php echo esc_attr( $jvfrm_home_tso->get( 'bottom_logo_url' ) );?>" tar="g04">
				<input type="button" class="button button-primary fileupload" value="<?php esc_attr_e('Select Image', 'javohome');?>" tar="g04">
				<input class="fileuploadcancel button" tar="g04" value="<?php esc_attr_e('Delete', 'javohome');?>" type="button">
			</p>
			<p>
				<?php esc_html_e("Preview",'javohome'); ?><br>
				<img src="<?php echo esc_attr( $jvfrm_home_tso->get( 'bottom_retina_logo_url' ) );?>" tar="g04">
			</p>
		</fieldset>
	</td></tr>
	</table>
</div>