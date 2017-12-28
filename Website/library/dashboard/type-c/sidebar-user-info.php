<?php
/**
*** User Information
***/
global
	$jvfrm_home_curUser
	, $jvfrm_home_current_user;
?>

<h2 class="jv-dashbarod-section-title user-info"><?php esc_html_e( "Contact Us", 'javohome' ); ?></h2>
<div class="row jv-dashbarod-user-info-section">
	<div class="col-md-4 jv-dashbarod-user-info-avatar">
		<?php echo get_avatar( jvfrm_home_getDashboardUser()->ID, '74', '', false, Array( 'class' => 'img-responsive' ) );?>
	</div>
	<div class="col-md-8 jv-dashbarod-user-info-meta">
		<ul class="list-unstyled jv-dashbarod-user-info-item-group">
			<li class="jv-dashbarod-user-info-item name"><?php echo jvfrm_home_getDashboardUser()->display_name; ?></li>
			<li class="jv-dashbarod-user-info-item mobile"><?php echo get_user_meta( jvfrm_home_getDashboardUser()->ID, 'mobile', true ); ?></li>
			<li class="jv-dashbarod-user-info-item phone"><?php echo get_user_meta( jvfrm_home_getDashboardUser()->ID, 'phone', true ); ?></li>
			<!--<li class="jv-dashbarod-user-info-item user-email"><?php echo jvfrm_home_getDashboardUser()->user_email; ?></li>-->
		</ul>
	</div>
</div>


<?php /*
<div class="container profile-and-image-container">
	<div class="col-xs-12 col-xs-12">
		<div class="col-md-6  col-xs-12 author-img">
			<div class="col-md-12 col-xs-12">
				<div class="img_wrap">
					<?php echo get_avatar( $jvfrm_home_curUser->ID );?>
				</div>
			</div><!-- 12 Columns -->
		</div>
		<div class="col-md-6 hidden-xs author-names">
			<div class="row">
				<div class="col-md-12">
					<div class="tooltip-content">
						<p><?php echo wp_kses($jvfrm_home_current_user->description, jvfrm_home_allow_tags() ); ?></p>
					</div>
				</div>
			</div>

		</div>
	</div> <!-- col-xs-12 col-sm-12 -->

</div> <!-- container -->
<div class="profile-and-image-container-overlay">

</div>
 */ ?>