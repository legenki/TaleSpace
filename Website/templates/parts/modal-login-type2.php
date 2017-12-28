<?php
/*****************************************
*
*	Login Modal Type 2
*
*****************************************/
?>

<!-- Modal -->
<div class="modal fade login-type2" id="login_panel" tabindex="-1" role="dialog" aria-labelledby="login_panelLabel" aria-hidden="true">
	<div class="modal-dialog modal-sm">
		<div class="modal-content no-padding">

			<!-- Modal Header -->
			<div class="modal-header text-center">
				<h4 class="modal-title" id="login_panelLabel">
					<?php echo strtoupper( esc_html__( 'Sign Into Your Account', 'javohome' ) ); ?>
				</h4><!-- /.modal-title -->
			</div><!-- /.modal-header -->

			<!-- Modal body -->
			<div class="modal-body">
				<form action="<?php echo wp_login_url(apply_filters('jvfrm_home_modal_login_redirect', '')  ); ?>" id="login_form" name="login_form" method="post">
					<div class="row">
						<div class="col-md-12 lava_login_wrap">

							<!-- User Name -->
							<div class="form-group">
								<input type="text" name="log" id="username"  value="" class="form-control" placeholder="<?php esc_html_e("Username",'javohome');?>" required>
							</div>

							<!-- User Password -->
							<div class="form-group">
								<input type="password" name="pwd" id="password" value="" class="form-control" placeholder="<?php esc_html_e("Password",'javohome');?>" required>
							</div>

							<!-- Descriptions -->
							<div class="form-group">
								<label class="control-label">
									<input name="rememberme" value="forever" type="checkbox">
									<small><?php esc_html_e("Remember Me", 'javohome');?></small>
								</label><!-- /.control-label -->
								<a href="<?php echo wp_lostpassword_url();?>">
									<small class="required"><?php esc_html_e('Forgot Your Password?', 'javohome' ); ?></small>
								</a>
							</div>

							<!-- Login Button -->
							<div class="form-group">
								<div class="row lava_login">
									<div class="col-md-12 col-xs-12">
										<input type="hidden" name="redirect_to" value="<?php echo esc_attr( $_SERVER['REQUEST_URI'] );?>">
										<button type="submit" class="btn btn-block btn-danger ">
											<strong><?php esc_html_e('Login', 'javohome');?></strong>
										</button>
										<?php do_action( 'jvfrm_home_login2_modal_login_after' ); ?>
									</div><!-- /.col-md-12 -->
								</div><!-- /.row -->
							</div>

						</div>
					</div><!--/.row-->

					<div class="row bottom_row">
						<hr class="padding-5px">
						<div class="col-md-12 col-xs-12">
							<?php if( get_option( 'users_can_register' ) ) : ?>
								<small>
									<?php esc_html_e("Don't have an account?", 'javohome');?>
									<a href="#" data-toggle="modal" data-target="#register_panel" class="required"><?php esc_html_e('Sign Up', 'javohome');?></a>
								</small>
							<?php else: ?>
								<div class="well well-sm">
									<small><?php esc_html_e("This site is not allowed new members. please contact administrator.", 'javohome');?></small>
								</div>
							<?php endif; ?>
						</div>
						<div class="col-md-12 col-xs-12">
							<small class="description"><?php esc_html_e("Your privacy is important to us and we will never rent or sell your information.", 'javohome');?></small>
						</div>
					</div>

					<fieldset>
						<input type="hidden" name="ajaxurl" value="<?php echo admin_url( 'admin-ajax.php' ); ?>">
						<input type="hidden" name="action" value="jvfrm_home_ajax_user_login">
						<input type="hidden" name="security" value="<?php echo wp_create_nonce( 'user_login' ); ?>">

					</fieldset>
				</form>
			</div><!-- /.modal-body -->

		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script type="text/javascript">
jQuery( function( $ ){
	$.jvfrm_home_login( $( "#login_form" ) );
} );
</script>