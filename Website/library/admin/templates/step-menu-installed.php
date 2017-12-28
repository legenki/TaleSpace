<?php if( !empty( $sectionMeta[ 'passed' ] ) ) : ?>
<h4>
	<i class="jv-helper-icon success"></i>
	<?php esc_html_e( "Menu has been setup properly.", 'javohome' ); ?>
</h4>
<?php else: ?>
<p>
	<div><?php esc_html_e( "You have not added any menus.", 'javohome' ); ?></div>
	<div><?php esc_html_e( "Please setup menus", 'javohome' ); ?> <a href="<?php echo admin_url( 'nav-menus.php' ); ?>"><?php esc_html_e( "here", 'javohome' ); ?></a>.</div>
</p>
<p><a href="<?php echo admin_url( 'nav-menus.php' ); ?>" class="button button-primary"><?php esc_html_e( "Go Menu Settings", 'javohome'); ?></a></p>
<?php endif; ?>
<hr>
<h4><?php esc_html_e( "Menu Setting Documentation", 'javohome' ); ?></h4>
<a href="<?php echo esc_url( "www.javothemes.com/home/documentation/" ); ?>" target="_blank" class="button"><?php esc_html_e( "Documentation", 'javohome'); ?></a>
<a href="<?php echo admin_url( 'nav-menus.php' ); ?>" class="button button-primary"><?php esc_html_e( "Setup Again", 'javohome'); ?></a>