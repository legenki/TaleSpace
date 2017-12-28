<?php
/**
***	My Review Lists
***/

global
	$jvfrm_home_curUser
	, $manage_mypage;

require_once JVFRM_HOME_DSB_DIR . '/mypage-common-header.php';
get_header(); ?>

<div class="jv-my-page">
	<div class="row top-row">
		<div class="col-md-12">
			<?php get_template_part('library/dashboard/' . jvfrm_home_dashboard()->page_style . '/sidebar', 'user-info');?>
		</div> <!-- col-12 -->
	</div> <!-- top-row -->

	<div class="container secont-container-content">
		<div class="row row-offcanvas row-offcanvas-left">
			<?php
			$jvfrm_home_mypage_area			= 'col-sm-12';
			if( $manage_mypage ) {
				get_template_part('library/dashboard/' . jvfrm_home_dashboard()->page_style . '/sidebar', 'menu');
				$jvfrm_home_mypage_area		= 'col-sm-10';
			}
			?>
			<div class="col-xs-12 <?php echo sanitize_html_class( $jvfrm_home_mypage_area ); ?> main-content-right" id="main-content">
				<div class="row">
					<div class="col-md-12">
						<div class="panel panel-default panel-wrap">
							<div class="panel-heading">
								<p class="pull-left hidden">
									<button class="btn btn-primary btn-xs admin-color-setting" data-toggle="mypage-offcanvas"><?php esc_html_e('My Page Menu', 'javohome'); ?></button>
								</p> <!-- offcanvas button -->
								<div class="row">
									<div class="col-md-12 col-xs-12 my-page-title">
										<?php

										esc_html_e( "Home", 'javohome');
										if( $manage_mypage ) : ?>
											<div class="visible-xs">

												<a href="<?php echo jvfrm_home_getCurrentUserPage( JVFRM_HOME_ADDITEM_SLUG );?>" class="btn btn-danger pull-right admin-color-setting">
													<i class="fa fa-pencil"></i>
												</a>
												<a href="<?php echo jvfrm_home_getCurrentUserPage( JVFRM_HOME_CHNGPW_SLUG );?>" class="btn btn-danger pull-right admin-color-setting">
													<i class="fa fa-cogs"></i>
												</a>
												<a href="<?php echo jvfrm_home_getCurrentUserPage( JVFRM_HOME_PROFILE_SLUG );?>" class="btn btn-danger pull-right admin-color-setting">
													<i class="fa fa-cog"></i>
												</a>
											</div>

											<a href="<?php echo jvfrm_home_getCurrentUserPage( JVFRM_HOME_ADDITEM_SLUG );?>" class="hidden-xs btn btn-danger pull-right admin-color-setting">
												<?php esc_html_e( "Submit Item", 'javohome' );?>
											</a>
											<a href="<?php echo jvfrm_home_getCurrentUserPage( JVFRM_HOME_CHNGPW_SLUG );?>" class="hidden-xs btn btn-danger pull-right admin-color-setting">
												<?php esc_html_e( "Edit Password", 'javohome' );?>
											</a>
											<a href="<?php echo jvfrm_home_getCurrentUserPage( JVFRM_HOME_PROFILE_SLUG );?>" class="hidden-xs btn btn-danger pull-right admin-color-setting">
												<?php esc_html_e( "Edit Profile", 'javohome' );?>
											</a>
										<?php endif; ?>
									</div> <!-- my-page-title -->

								</div> <!-- row -->
							</div> <!-- panel-heading -->

							<div class="panel-body">
							<!-- Starting Content -->

								<div class="row">
									<div class="col-md-12 col-xs-12">
										<div class="my-profile-home-pic">	</div> <!-- my-profile-home-pic -->
									</div> <!-- col-md-3 -->
									<div class="col-md-12 col-xs-12 my-profile-home-details">
										<!--<h2><?php echo $jvfrm_home_this_user->user_login;?></h2>-->
										<ul class="list-group">

											<li class="list-group-item">
												<div class="my-home-label"><?php esc_html_e( "Name" ,'javohome' );?></div>
												<div class="my-home-content"></div>&nbsp;<?php printf('%s %s', $jvfrm_home_curUser->first_name, $jvfrm_home_curUser->last_name);?>
											</li> <!-- list-group-item -->

											<li class="list-group-item">
												<div class="my-home-label"><?php esc_html_e( "Email" ,'javohome' );?></div>
												<div class="my-home-content"></div>&nbsp;<?php echo esc_attr( $jvfrm_home_curUser->user_email );?>
											</li> <!-- list-group-item -->

											<li class="list-group-item">
												<div class="my-home-label"><?php esc_html_e( "Phone" ,'javohome' );?></div>
												<div class="my-home-content"></div>&nbsp;<?php echo esc_attr( $jvfrm_home_curUser->phone );?>
											</li> <!-- list-group-item -->

											<li class="list-group-item">
												<div class="my-home-label"><?php esc_html_e( "Mobile" ,'javohome' );?></div>
												<div class="my-home-content"></div>&nbsp;<?php echo esc_attr( $jvfrm_home_curUser->mobile );?>
											</li> <!-- list-group-item -->

											<li class="list-group-item">
												<div class="my-home-label"><?php esc_html_e( "Fax" ,'javohome' );?></div>
												<div class="my-home-content"></div>&nbsp;<?php echo esc_attr( $jvfrm_home_curUser->fax );?>
											</li> <!-- list-group-item -->

											<li class="list-group-item">
												<div class="my-home-label"><?php esc_html_e( "Twitter" ,'javohome' );?></div>
												<div class="my-home-content"></div>&nbsp;<?php echo esc_attr( $jvfrm_home_curUser->twitter );?>
											</li> <!-- list-group-item -->

											<li class="list-group-item">
												<div class="my-home-label"><?php esc_html_e( "Facebook" ,'javohome' );?></div>
												<div class="my-home-content"></div>&nbsp;<?php echo esc_attr( $jvfrm_home_curUser->facebook );?>
											</li> <!-- list-group-item -->

											<li class="list-group-item"><?php echo get_user_meta($jvfrm_home_curUser->ID, 'description', true);?></li> <!-- list-group-item -->
										</ul>

									</div> <!-- col-md-9 -->
								</div> <!-- row -->

								<?php
								if( class_exists( 'jvfrm_home_block3' ) )  {
									$objShortcode	= new jvfrm_home_block3();
									echo $objShortcode->output(
										Array(
											'title'						=> strtoupper( sprintf( esc_html__( "%s's Properties", 'javohome' ), $jvfrm_home_curUser->display_name ) )
											, 'count'					=> 6
											, 'author'				=> $jvfrm_home_curUser->ID
											, 'columns'				=> 3
											, 'post_type'			=> 'property'
											, 'filter_by'				=> 'property_type'
											, 'pagination'			=> 'number'
										)
									);
								} ?>

							<!-- End Content -->
							</div> <!-- panel-body -->
						</div> <!-- panel -->
					</div> <!-- col-md-12 -->
				</div><!--/row-->
			</div><!-- wrap-right -->
		</div><!--/row-->
	</div><!--/.container-->
</div><!--jv-my-page-->
<?php get_footer();
