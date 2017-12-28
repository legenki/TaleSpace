<?php
/**
*** User Information
***/
global
	$jvfrm_home_tso
	, $jvfrm_home_curUser
	, $jvfrm_home_current_user;
function jv_contact_pm_form(){
	global $jvfrm_home_curUser;
	return $jvfrm_home_curUser->user_email;
}
add_shortcode('JV_CONTACT_PM_FORM', 'jv_contact_pm_form');
?>
<div class="profile-and-image-container" style="position:relative; z-index:1;">
	<ul class="nav nav-tabs" role="tablist">
		<li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab"><?php esc_html_e('Summary','javohome');?></a></li>
		<li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab"><?php esc_html_e('About','javohome'); ?></a></li>
		<li role="presentation"><a href="#sendpm" aria-controls="sendpm" role="tab" data-toggle="tab"><?php esc_html_e('Send PM','javohome'); ?></a></li>
		<?php if( $jvfrm_home_curUser->ID == get_current_user_id() ){ ?>
		<li class="jv-mypage-topmenu-button"><a href="<?php echo jvfrm_home_getCurrentUserPage( JVFRM_HOME_ADDITEM_SLUG );?>" class="btn btn-danger pull-right admin-color-setting"><?php esc_html_e( "Submit Item", 'javohome' );?></a></li>
		<li class="jv-mypage-topmenu-button"><a href="<?php echo jvfrm_home_getCurrentUserPage( JVFRM_HOME_PROFILE_SLUG );?>" class="btn btn-danger pull-right admin-color-setting"><?php esc_html_e( "Edit Profile", 'javohome' );?></a></li>
		<li class="jv-mypage-topmenu-button"><a href="<?php echo esc_url( home_url( JVFRM_HOME_DEF_LANG.JVFRM_HOME_MEMBER_SLUG . '/' . wp_get_current_user()->user_login . '/' ) . JVFRM_HOME_MEMBER_SLUG );?>" class="btn btn-danger pull-right admin-color-setting"><?php esc_html_e( "My Page", 'javohome' );?></a></li>
		<?php } ?>
	 </ul>
	<div class="col-xs-12">
		<div class="col-md-3  col-sm-3 col-xs-12 author-img">
			<div class="col-md-12 col-xs-12">
				<div class="img_wrap">
					<?php echo get_avatar( $jvfrm_home_curUser->ID , 250 );?>
				</div>
			</div><!-- 12 Columns -->
		</div>
		<div class="col-sm-9 col-sm-9 col-xs-12 author-names">
			<div class="tab-content">
				<div role="tabpanel" class="tab-pane active" id="home">
					<div class="col-sm-6 col-xs-6 my-profile-home-details">
						<ul class="list-group">
							<li class="list-group-item">
								<div class="col-md-2 col-sm-2 col-xs-4 my-home-label"><?php esc_html_e( "Name" ,'javohome' );?></div>
								<div class="col-md-10 col-sm-10 col-xs-8 my-home-content"></div>&nbsp;<?php printf('%s %s', $jvfrm_home_curUser->first_name, $jvfrm_home_curUser->last_name);?>
							</li> <!-- list-group-item -->

							<li class="list-group-item">
								<div class="col-md-2 col-sm-2 col-xs-4 my-home-label"><?php esc_html_e( "Email" ,'javohome' );?></div>
								<div class="col-md-10 col-sm-10 col-xs-8 my-home-content"></div>&nbsp;<?php echo esc_attr( $jvfrm_home_curUser->user_email );?>
							</li> <!-- list-group-item -->

							<li class="list-group-item">
								<div class="col-md-2 col-sm-2 col-xs-4 my-home-label"><?php esc_html_e( "Phone" ,'javohome' );?></div>
								<div class="col-md-10 col-sm-10 col-xs-8 my-home-content"></div>&nbsp;<?php echo esc_attr( $jvfrm_home_curUser->phone );?>
							</li> <!-- list-group-item -->

							<li class="list-group-item">
								<div class="col-md-2 col-sm-2 col-xs-4 my-home-label"><?php esc_html_e( "Mobile" ,'javohome' );?></div>
								<div class="col-md-10 col-sm-10 col-xs-8 my-home-content"></div>&nbsp;<?php echo esc_attr( $jvfrm_home_curUser->mobile );?>
							</li> <!-- list-group-item -->

							<li class="list-group-item">
								<div class="col-md-2 col-sm-2 col-xs-4 my-home-label"><?php esc_html_e( "Fax" ,'javohome' );?></div>
								<div class="col-md-10 col-sm-10 col-xs-8 my-home-content"></div>&nbsp;<?php echo esc_attr( $jvfrm_home_curUser->fax );?>
							</li> <!-- list-group-item -->

							<li class="list-group-item">
								<div class="col-md-2 col-sm-2 col-xs-4 my-home-label"><?php esc_html_e( "Twitter" ,'javohome' );?></div>
								<div class="col-md-10 col-sm-10 col-xs-8 my-home-content"></div>&nbsp;<?php echo esc_attr( $jvfrm_home_curUser->twitter );?>
							</li> <!-- list-group-item -->

							<li class="list-group-item">
								<div class="col-md-2 col-sm-2 col-xs-4 my-home-label"><?php esc_html_e( "Facebook" ,'javohome' );?></div>
								<div class="col-md-10 col-sm-10 col-xs-8 my-home-content"></div>&nbsp;<?php echo esc_attr( $jvfrm_home_curUser->facebook );?>
							</li> <!-- list-group-item -->
						</ul>
					</div> <!-- col-md-12 -->
				</div><!-- #home -->
				<div role="tabpanel" class="tab-pane" id="profile">
					<div class="row">
						<div class="col-md-12">
							<div class="tooltip-content">
								 <div class="tab-content">
									<p><?php echo $jvfrm_home_current_user->description; ?></p>
								</div>
							</div><!-- tooltip-content -->
						</div><!-- col-md-12 -->
					</div><!-- row -->
				</div>
				<div role="tabpanel" class="tab-pane" id="sendpm">


				<?php
				$pm_form = '';
				$pm_form_id = $jvfrm_home_tso->get('pm_contact_form_id');
				$pm_form_type = $jvfrm_home_tso->get('pm_contact_type');
				if($pm_form_type != ''){
					if($pm_form_type == 'contactform'){ // pm type = contact form
						$pm_form = '[contact-form-7 id=%s title="%s"]';
					}else{ // pm type = ninja form
						$pm_form = '[ninja_forms id=%s title="%s"]';
					}
					echo do_shortcode(sprintf($pm_form, $pm_form_id, 'mikes form'));
				}else{
					echo 'not setup pm form';
				}
				?>







				</div>
			</div>
		</div><!-- col-md-6 hidden-xs author-names -->
		<div class="col-md-4 jv-dashboard-menu">
			<?php //get_template_part('library/dashboard/' . jvfrm_home_dashboard()->page_style . '/sidebar', 'menu'); ?>
		</div>
	</div> <!-- col-xs-12 col-sm-12 -->

</div> <!-- container -->