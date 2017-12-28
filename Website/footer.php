<?php
/**
 * The template for displaying the footer
 *
 * @package WordPress
 * @subpackage Javo
 * @since Javo Themes 1.0
 */
?>
	</div> <!-- / #page-style -->
	<a id="back-to-top" href="#" class="btn btn-primary btn-lg back-to-top javo-dark admin-color-setting" role="button" title="<?php esc_attr_e('Go to top', 'javohome');?>">
		<span class="fa fa-arrow-up"></span>
	</a>
	<?php
	do_action( 'jvfrm_home_body_after', get_page_template_slug() );
	wp_footer(); ?>
	</body>
</html>