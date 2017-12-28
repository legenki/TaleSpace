<?php
$plugins = TGM_Plugin_Activation::$instance->plugins;
$installed_plugins = get_plugins();
?>

<div class="wrap about-wrap" id="jv-default-setting-plugins-wrap">
	<div class="feature-section theme-browser rendered">
		<?php
			foreach( $plugins as $plugin ):
				$class = '';
				$plugin_status = '';
				$file_path = $plugin['file_path'];
				$plugin_action = $this->plugin_link( $plugin );
				//$plugin_action = jvfrm_home_admin_helper::$instance->plugin_link( $plugin );

				if( is_plugin_active( $file_path ) ) {
					$plugin_status = 'active';
					$class = 'active';
				}
			?>
			<div class="theme <?php echo sanitize_html_class( $plugin['slug'] ) . ' ' . sanitize_html_class( $class ); ?>">
				<div class="theme-screenshot">
					<img src="<?php echo esc_attr( $plugin[ 'image_url' ] );?>">
					<?php
						if( isset( $installed_plugins[$plugin['file_path']] ) ): ?>
							<div class="plugin-info">
								<?php echo sprintf('Version %s | %s', $installed_plugins[$plugin['file_path']]['Version'], $installed_plugins[$plugin['file_path']]['Author'] ); ?>
							</div>
						<?php
						endif;
						if( $plugin['required'] ): ?>
							<div class="plugin-required">
								<?php esc_html_e( 'Required', 'javohome' ); ?>
							</div>
						<?php
						endif;
					?>
				</div>
				<h3 class="theme-name"><?php echo esc_html( $plugin['name'] ); ?></h3>
				<div class="theme-actions">
					<?php foreach( $plugin_action as $action ) { echo $action; } ?>
				</div>
				<?php if( isset( $plugin_action['update'] ) && $plugin_action['update'] ): ?>
					<div class="theme-update">
						<?php esc_html_e( "Update Available:", 'javohome' ); ?>
						<?php esc_html_e( "Version", 'javohome' ); ?>
						<?php echo esc_html( $plugin['version'] ); ?>
					</div>
				<?php endif; ?>
			</div>
		<?php endforeach; ?>
	</div>
	<div class="spinner-wrap">
		<div class="spinner"></div>
		<span class="spinner-text"><?php esc_html_e( "Processing...", 'javohome' ); ?></span>
	</div>
</div>
<script type="text/javascript">
jQuery( function( $ ) {
	"use strict";
	$( ".theme-actions .button" ).on( 'click',
		function() {
		$( "div#jv-default-setting-plugins-wrap" ).addClass( "processing" );
		}
	);
} );
</script>