<?php if( !empty( $sectionMeta[ 'passed' ] ) ) : ?>
<h4>
	<i class="jv-helper-icon success"></i>
	<?php esc_html_e( "Permalink has been setup properly.", 'javohome' ); ?>
</h4>
<?php else: ?>
<p>
	<div><?php esc_html_e( "Our theme is compatible with permalink structure. it's also good for SEO.", 'javohome' ); ?></div>
	<div><?php esc_html_e( "Please setup permalink to 'Post name'.", 'javohome' ); ?></div>
</p>
<p>
	<a href="<?php echo admin_url( 'options-permalink.php' ); ?>" class="button button-primary">
		<?php esc_html_e( "Go Permalink Settings", 'javohome'); ?>
	</a>
</p>
<?php endif; ?>
<hr>
<h4><?php esc_html_e( "Permalink Documentation", 'javohome' ); ?></h4>
<a href="<?php echo esc_url( "www.javothemes.com/home/documentation/" ); ?>" target="_blank" class="button"><?php esc_html_e( "Documentation", 'javohome'); ?></a>
<a href="<?php echo admin_url( 'options-permalink.php' ); ?>" class="button button-primary"><?php esc_html_e( "Setup Again", 'javohome'); ?></a>