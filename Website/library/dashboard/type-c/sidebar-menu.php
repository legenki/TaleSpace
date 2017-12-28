<?php
/**
 *	Userm mypage sidebar menus
 *
 */
$strContactType = jvfrm_home_tso()->get( 'pm_contact_type', false );
$strContactID = jvfrm_home_tso()->get( 'pm_contact_form_id', false );
$hasContractOption = $strContactType && $strContactID;
$strShortcodeFormat = $strContactType == 'contactform' ? '[contact-form-7 id="%1$s" title="%2$s"]' : '[ninja_forms id="%1$s" title="%2$s"]';
?>

<div class="col-sm-3 dashboard-left">
	<?php get_template_part('library/dashboard/' . jvfrm_home_dashboard()->page_style . '/sidebar', 'user-info'); ?>
	<div class="sidebar-nav mypage-left-menu jv-dashbarod-sidebar-nav-section">
		<?php jvfrm_home_getMypageSidebar() ; ?>
	</div><!--/.well -->
	<h2 class="jv-dashbarod-section-title send-message"><?php esc_html_e( "Send Message", 'javohome' ); ?></h2>
	<div class="jv-dashbarod-contact-section">
		<?php
		if( $hasContractOption ) {
			echo do_shortcode( sprintf( $strShortcodeFormat, $strContactID, esc_html__( "Mikes Form", 'javohome' ) ) );
		}else{
			printf( '<div class="well">%s</div>', esc_html__( "Not setup a pm form", 'javohome' ) );
		} ?>
	</div>
</div><!--/col-xs-->