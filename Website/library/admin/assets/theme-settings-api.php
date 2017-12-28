<div class="jvfrm_home_ts_tab javo-opts-group-tab hidden" tar="api">
	<h2> <?php esc_html_e("APIs Settings", 'javohome'); ?> </h2>
	<table class="form-table">
	<tr><th>
		<?php esc_html_e('Google API', 'javohome');?>
		<span class="description">
			<?php esc_html_e('Paste your Google Analytic tracking codes here.', 'javohome');?>
		</span>
	</th><td>
		<h4><?php esc_html_e('Google Analystics Code', 'javohome');?></h4>
		<fieldset>
			<textarea name="jvfrm_home_ts[analytics]" class="large-text code" rows="15"><?php echo stripslashes($jvfrm_home_tso->get('analytics', ''));?></textarea>
		</fieldset>
	</td></tr><tr><th>
		<?php esc_html_e( 'MailChimp API', 'javohome');?>
	</th><td>
		<h4><?php esc_html_e('Mail-Chimp API Key', 'javohome');?></h4>
		<fieldset class="inner">
			<label>
				<?php esc_html_e('API KEY', 'javohome');?><br>
				<input type="text" name="jvfrm_home_ts[mailchimp_api]" value="<?php echo esc_attr( $jvfrm_home_tso->get( 'mailchimp_api' ) );?>">
			</label>
		</fieldset>
	</td></tr>
	</table>
</div>