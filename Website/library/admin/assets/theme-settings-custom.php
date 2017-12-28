<div class="jvfrm_home_ts_tab javo-opts-group-tab hidden" tar="custom">
	<h2> <?php esc_html_e("Javo Customization Settings", 'javohome'); ?> </h2>
	<table class="form-table">
	<tr><th>
		<?php esc_html_e( "CSS Stylesheet", 'javohome');?>
		<span class="description"><?php esc_html_e('Please Add Your Custom CSS Code Here.', 'javohome');?></span>
	</th><td>
		<h4><?php esc_html_e('Code:', 'javohome');?></h4>
		<?php esc_html_e( '<style type="text/css">', 'javohome' );?>
		<fieldset>
			<textarea name="jvfrm_home_ts[custom_css]" class='large-text code' rows='15'><?php echo stripslashes( $jvfrm_home_tso->get( 'custom_css', '' ) );?></textarea>
		</fieldset>
		<?php esc_html_e( '</style>', 'javohome' );?>
	</td></tr><tr><th>
		<?php esc_html_e('Custom Script', 'javohome');?>
		<span class="description">
			<?php esc_html_e(' If you have additional script, please add here.', 'javohome');?>
		</span>
	</th><td>
		<h4><?php esc_html_e('Code:', 'javohome');?></h4>
		<?php esc_html_e( '<script type="text/javascript">', 'javohome' );?>
		<fieldset>
			<textarea name="jvfrm_home_ts[custom_js]" class="large-text code" rows="15"><?php echo stripslashes( $jvfrm_home_tso->get('custom_js', ''));?></textarea>
		</fieldset>
		<?php esc_html_e( '</script>', 'javohome' );?>
		<div><?php esc_html_e('(Note : Please make sure that your scripts are NOT conflict with our own script or ajax core)', 'javohome');?></div>
	</td></tr>
	</table>
</div>