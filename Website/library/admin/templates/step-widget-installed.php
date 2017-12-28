<?php if( !empty( $sectionMeta[ 'passed' ] ) ) : ?>
<h4>
	<i class="jv-helper-icon success"></i>
	<?php esc_html_e( "Widgets have been setup properly.", 'javohome' ); ?>
</h4>
<?php else: ?>
<p>
	<?php esc_html_e( "We recommend you to add some widgets for proper functionality", 'javohome' ); ?>
</p>
<p><a href="<?php echo admin_url( 'widgets.php' ); ?>" class="button button-primary"><?php esc_html_e( "Go to Widgets Settings", 'javohome'); ?></a></p>
<?php endif; ?>
<hr>
<h4><?php esc_html_e( "Widget Setting Documentation", 'javohome' ); ?></h4>
<a href="<?php echo esc_url( "www.javothemes.com/home/documentation/" ); ?>" target="_blank" class="button"><?php esc_html_e( "Documentation", 'javohome'); ?></a>
<a href="<?php echo admin_url( 'widgets.php' ); ?>" class="button button-primary"><?php esc_html_e( "Setup Again", 'javohome'); ?></a>