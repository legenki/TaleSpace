<?php if( !empty( $sectionMeta[ 'passed' ] ) ) : ?>
<h4>
	<i class="jv-helper-icon success"></i>
	<?php esc_html_e( "Static front page (Main page) has been setup properly", 'javohome' ); ?>
</h4>
<?php else: ?>
<p>
<?php esc_html_e( "This is for your front page ( main page ). you may need to select a page for your front page. ex) Home", 'javohome' ); ?>
</p>
<p><a href="<?php echo admin_url( 'options-reading.php' ); ?>" class="button button-primary"><?php esc_html_e( "Go to Reading Settings", 'javohome'); ?></a></p>
<?php endif; ?>
<hr>
<h4><?php esc_html_e( "Static Page Documentation", 'javohome' ); ?></h4>
<a href="<?php echo esc_url( "www.javothemes.com/home/documentation/" ); ?>" target="_blank" class="button"><?php esc_html_e( "Documentation", 'javohome'); ?></a>
<a href="<?php echo admin_url( 'options-reading.php' ); ?>" class="button button-primary"><?php esc_html_e( "Go to Reading Settings", 'javohome'); ?></a>