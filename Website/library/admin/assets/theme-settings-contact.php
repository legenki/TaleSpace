<div class="jvfrm_home_ts_tab javo-opts-group-tab hidden" tar="contact">
	<h2> <?php esc_html_e('Contact Information Settings', 'javohome'); ?> </h2>
	<table class="form-table">
	<tr><th>
		<?php esc_html_e('Contact Information', 'javohome');?>
		<span class="description">
			<?php esc_html_e('Add Your Contact Information', 'javohome');?>
		</span>
	</th><td>
		<h4><?php esc_html_e('Address', 'javohome');?></h4>
		<fieldset class="inner">
			<input name="jvfrm_home_ts[address]" type="text" value="<?php echo sanitize_text_field( $jvfrm_home_tso->get("address") );?>" class="large-text">
		</fieldset>

		<h4><?php esc_html_e('Phone', 'javohome');?></h4>
		<fieldset class="inner">
			<input name="jvfrm_home_ts[phone]" type="text" value="<?php echo sanitize_text_field( $jvfrm_home_tso->get("phone") );?>" class="large-text">
		</fieldset>

		<h4><?php esc_html_e('Mobile', 'javohome');?></h4>
		<fieldset class="inner">
			<input name="jvfrm_home_ts[mobile]" type="text" value="<?php echo sanitize_text_field( $jvfrm_home_tso->get("mobile") );?>" class="large-text">
		</fieldset>

		<h4><?php esc_html_e('Fax', 'javohome');?></h4>
		<fieldset class="inner">
			<input name="jvfrm_home_ts[fax]" type="text" value="<?php echo sanitize_text_field( $jvfrm_home_tso->get("fax") );?>" class="large-text">
		</fieldset>

		<h4><?php esc_html_e('Email', 'javohome');?></h4>
		<fieldset class="inner">
			<input name="jvfrm_home_ts[email]" type="text" value="<?php echo sanitize_text_field( $jvfrm_home_tso->get("email") );?>" class="large-text">
		</fieldset>

		<h4><?php esc_html_e('Working Hours', 'javohome');?></h4>
		<fieldset class="inner">
			<input name="jvfrm_home_ts[working_hours]" type="text" value="<?php echo sanitize_text_field( $jvfrm_home_tso->get("working_hours") );?>" class="large-text">
		</fieldset>

		<h4><?php esc_html_e('Additional Information', 'javohome');?></h4>
		<fieldset class="inner">
			<input name="jvfrm_home_ts[additional_info]" type="text" value="<?php echo sanitize_text_field( $jvfrm_home_tso->get("additional_info") );?>" class="large-text">
		</fieldset>
	</td></tr><tr><th>
		<?php esc_html_e('Social Network Service IDs', 'javohome');?>
		<span class="description">
			<?php esc_html_e('Add your SSN information.', 'javohome');?>
		</span>
	</th><td>
		<h4><?php esc_html_e("Facebook  ex) https://facebook.com/your_name",'javohome'); ?></h4>
		<fieldset class="inner">
			<input name="jvfrm_home_ts[facebook]" type="text" value="<?php echo sanitize_text_field( $jvfrm_home_tso->get("facebook") );?>" class="large-text">
		</fieldset>

		<h4><?php esc_html_e("Twitter",'javohome'); ?></h4>
		<fieldset class="inner">
			<input name="jvfrm_home_ts[twitter]" type="text" value="<?php echo sanitize_text_field( $jvfrm_home_tso->get("twitter") );?>" class="large-text">
		</fieldset>

		<h4><?php esc_html_e("Google+",'javohome'); ?></h4>
		<fieldset class="inner">
			<input name="jvfrm_home_ts[google]" type="text" value="<?php echo sanitize_text_field( $jvfrm_home_tso->get("google" ) );?>" class="large-text">
		</fieldset>

		<h4><?php esc_html_e("Dribbble",'javohome'); ?></h4>
		<fieldset class="inner">
			<input name="jvfrm_home_ts[dribbble]" type="text" value="<?php echo sanitize_text_field( $jvfrm_home_tso->get("dribbble") );?>" class="large-text">
		</fieldset>

		<h4><?php esc_html_e("Forrst",'javohome'); ?></h4>
		<fieldset class="inner">
			<input name="jvfrm_home_ts[forrst]" type="text" value="<?php echo sanitize_text_field( $jvfrm_home_tso->get("forrst") );?>" class="large-text">
		</fieldset>

		<h4><?php esc_html_e("Pinterest",'javohome'); ?></h4>
		<fieldset class="inner">
			<input name="jvfrm_home_ts[pinterest]" type="text" value="<?php echo sanitize_text_field( $jvfrm_home_tso->get("pinterest") );?>" class="large-text">
		</fieldset>

		<h4><?php esc_html_e("Instagram",'javohome'); ?></h4>
		<fieldset class="inner">
			<input name="jvfrm_home_ts[instagram]" type="text" value="<?php echo sanitize_text_field( $jvfrm_home_tso->get("instagram") );?>" class="large-text">
		</fieldset>

		<h4><?php esc_html_e("Website",'javohome'); ?></h4>
		<fieldset class="inner">
			<input name="jvfrm_home_ts[website]" type="text" value="<?php echo sanitize_text_field( $jvfrm_home_tso->get("website") );?>" class="large-text">
		</fieldset>

	</td></tr>
	</table>
</div>