<?php
/**
*** User Information
***/
global
	$jvfrm_home_curUser
	, $jvfrm_home_current_user;
?>
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