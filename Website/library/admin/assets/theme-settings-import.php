<?php
// Get Theme Settings Default Values.
ob_start();
require_once('default.txt');
$jvfrm_home_theme_setting_default_values = ob_get_clean(); ?>

<div class="jvfrm_home_ts_tab javo-opts-group-tab hidden" tar="import">
	<h2> <?php esc_html_e("Theme Settings Default Values", 'javohome'); ?> </h2>
	<table class="form-table">
	<tr><th>
		<?php esc_html_e('Import', 'javohome');?>
		<span class="description">
			<?php esc_html_e('Please paste your previously saved theme settings values into the adjacent box. This may help you restore any backed-up theme settings.', 'javohome');?>
		</span>
	</th><td>
		<h4><?php esc_html_e('Please paste your saved source into the box below.', 'javohome');?></h4>
		<fieldset>
			<textarea class="large-text code javo-ts-import-field" rows="15"></textarea>
		</fieldset>
		<a class="button button-primary javo-btn-ts-import"><?php esc_html_e('Import options', 'javohome');?></a>
	</td></tr><tr><th>
		<?php esc_html_e('Export', 'javohome');?>
		<span class="description">
			<?php esc_html_e('Please copy and save the text in the adjacent box as a restore point for your preferred theme settings.', 'javohome');?>
		</span>
	</th><td>
		<h4><?php esc_html_e('Please select and copy the source from the box below.', 'javohome');?></h4>
		<fieldset>
			<textarea class="large-text code jv-export-textarea" rows="5"><?php echo maybe_serialize( jvfrm_home_get_theme_settings::getAll() );?></textarea>
		</fieldset>

	</td></tr><tr><th>
		<?php esc_html_e('Reset options', 'javohome');?>
		<span class="description">
			<?php
			printf('<strong class="alert">%s</strong> %s'
				, esc_html__('Warning:', 'javohome')
				, esc_html__('All values will be removed.', 'javohome')
			);?>
		</span>
	</th><td>
		<textarea data-javo-ts-default-value class="hidden"><?php echo esc_textarea( $jvfrm_home_theme_setting_default_values );?></textarea>
		<a class="button button-primary javo-btn-ts-reset default"><?php esc_html_e('RESET DEFAULT OPTIONS', 'javohome');?></a>
		<a class="button button-primary javo-btn-ts-reset"><?php esc_html_e('RESET OPTIONS', 'javohome');?></a>
	</td></tr>
	</table>
</div>