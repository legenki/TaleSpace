<?php
/**
***	Edit My Profile Page
***/

require_once JVFRM_HOME_DSB_DIR . '/mypage-common-header.php';
$error = "";
$edit = (is_user_logged_in()) ? get_userdata(get_current_user_id()) : NULL;
if(isset($_POST['jvfrm_home_r'])){
	$fields = $_POST['jvfrm_home_r'];
	$errors = Array();

	$jvfrm_home_ut = !empty($fields['user_type'])? trim($fields['user_type']):null;

	if($fields['user_login'] == "")										$errors[] = esc_html__(" Login ID", 'javohome');
	if($fields['first_name'] == "")										$errors[] = esc_html__(" First Name", 'javohome');
	if($fields['last_name'] == "")										$errors[] = esc_html__(" Last Name", 'javohome');

	if(!$edit && $fields['user_pass'] == "")							$errors[] = esc_html__(" Password", 'javohome');
	if(!$edit && $fields['user_pass_re'] == "")							$errors[] = esc_html__(" Re-enter Password", 'javohome');
	if($fields['user_email'] == "")										$errors[] = esc_html__(" Email Address", 'javohome');
	if(!$edit && ($fields['user_pass'] != $fields['user_pass_re']))		$errors[] = esc_html__(" Passwords do not match.", 'javohome');
	if(!$edit && (strlen($fields['user_pass']) < 4))					$errors[] = esc_html__(" Password must be a minimum of 4 characters.", 'javohome');
	if(!$edit){
		$get_user = get_user_by("login", $fields['user_login']);
		if(!empty($get_user)){
			if( $get_user->user_login != ""){
																		$errors[] = esc_html__(" That Login ID already exists.", 'javohome');
			};
		};
		$get_user = get_user_by("email", $fields['user_email']);
		if(!empty($get_user)){
			if( $get_user->user_email != ""){
																		$errors[] = esc_html__(" The email address you entered has already been used.", 'javohome');
			};
		};
	};

	if(count($errors) == 0){
		$args = Array(
			"user_login"			=> $fields['user_login']
			, "first_name"			=> $fields['first_name']
			, "last_name"			=> $fields['last_name']
			, "user_email"			=> $fields['user_email']
		);

		if(!$edit){
			$args["role"]			= $jvfrm_home_ut;
			$args["user_pass"]		= $fields['user_pass'];
		};

		if($edit) $args["ID"] = $edit->ID;
		$user_id = ($edit) ? wp_update_user($args) : wp_insert_user($args);

		if($user_id){
			update_user_meta($user_id, "description"	, $fields['description'] );
			update_user_meta($user_id, "describe_image"	, ( isset( $_POST['describe_image'] ) ? $_POST['describe_image'] : null ) );
			update_user_meta($user_id, "phone"			, $fields['phone']);
			update_user_meta($user_id, "mobile"			, $fields['mobile']);
			update_user_meta($user_id, "fax"			, $fields['fax']);
			update_user_meta($user_id, "twitter"		, $fields['twitter']);
			update_user_meta($user_id, "facebook"		, $fields['facebook']);
			update_user_meta($user_id, "avatar"			, (!empty($_POST['avatar'])?$_POST['avatar']:""));
			update_user_meta($user_id, "avatar_on_blog"	, get_current_blog_id() );
			update_user_meta($user_id, "mypage_header"	, (!empty($_POST['mypage_header'])?$_POST['mypage_header']:""));

			do_action('jvfrm_home_mypage_add_user_info_process', $user_id , $fields );

			printf("<script>alert('%s');location.href='%s';</script>"
				, ( $edit ? esc_html__("You have successfully changed your information!", 'javohome') : esc_html__("You have successfully created an account! Please log in.", 'javohome') )
				, ( $edit ? esc_url( home_url( JVFRM_HOME_DEF_LANG.JVFRM_HOME_MEMBER_SLUG.'/'.get_userdata($user_id)->user_login . '/' ) ) : esc_url( home_url( '/' ) ) )
			);
			exit;
		}else{
			$errors[] = esc_html__("Sorry. Could not create a Login ID.", 'javohome');
		}
	}
};
function jvfrm_home_input_str($fdnm, $default){
	global $fields, $edit;
	echo $edit != NULL ? $default : (!empty($fields) ? $fields[$fdnm] : "") ;
};

get_header(); ?>
<div class="jv-my-page">
	<div class="row top-row container jv-edit-profile">
		<h2 class="jv-my-page-user-name"><?php printf('%s %s', esc_attr($jvfrm_home_curUser->first_name), esc_attr($jvfrm_home_curUser->last_name));?></h2>
		<div class="col-md-12">
		<div class="row">
			<div class="col-md-12 my-page-title">
				<?php esc_html_e('Edit My Profile', 'javohome');?>
			</div> <!-- my-page-title -->
		</div> <!-- row -->
			<?php get_template_part('library/dashboard/' . jvfrm_home_dashboard()->page_style . '/sidebar', 'user-info');?>
		</div> <!-- col-12 -->
	</div> <!-- top-row -->

	<div class="container second-container-content jv-edit-profile-form">
		<div class="row row-offcanvas row-offcanvas-left">
			<div class="col-xs-12 col-sm-12 main-content-right edit_my_profile" id="main-content">
				<div class="row">
					<div class="col-md-12">
						<div class="panel panel-default panel-wrap">
							<div class="panel-heading">
							</div> <!-- panel-heading -->

							<div class="panel-body">
							<!-- Starting Content -->

								<div class="row">
									<div class="col-md-12 main-content-box">
										<form method="post" enctype="multipart/form-data">
											<?php
											// Error Output
											if(!empty($errors)){
												?>
												<div class="alert alert-danger alert-dismissable">
													<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
													<?php
													foreach($errors as $err=>$message){
														?>
														<p>
															<strong><?php esc_html_e("Required",'javohome'); ?></strong>
															<?php echo $message;?>
														</p>
														<?php
													};?>
												</div>
												<?php
											};?>



											<div class="javo-form-div <?php echo empty($edit)?"hidden":"";?>">

												<div class="row">
													<div class="col-xs-12 col-md-3"><div class="well well-sm"><?php esc_html_e('Username', 'javohome') ?></div></div>
													<div class="col-xs-12 col-md-9"><input type="text" class="form-control" name="jvfrm_home_r[user_login]" value="<?php jvfrm_home_input_str("user_login", (!empty($edit)? $edit->user_login : NULL));?>" data-required placeholder="<?php esc_html_e('Username', 'javohome');?>" <?php echo (($edit)?"readonly" : "");?>></div>
												</div>

												<div class="row">
													<div class="col-xs-12 col-md-3"><div class="well well-sm"><?php esc_html_e('Name', 'javohome') ?></div></div>
													<div class="col-xs-12 col-md-9">
														<div class="row">
															<div class="col-xs-6 col-md-6">
																<input type="text" class="form-control" name="jvfrm_home_r[first_name]" value="<?php jvfrm_home_input_str("first_name", (!empty($edit)?$edit->first_name:null));?>" data-required placeholder="<?php esc_attr_e('First Name', 'javohome');?>">
															</div><!-- col-xs-6 -->
															<div class="col-xs-6 col-md-6">
																<input type="text" class="form-control" name="jvfrm_home_r[last_name]" value="<?php jvfrm_home_input_str("last_name", (!empty($edit)?$edit->last_name:null));?>" data-required placeholder="<?php esc_attr_e('Last Name', 'javohome');?>">
															</div><!-- col-xs-6 -->
														</div><!-- row -->
													</div><!-- col-xs-9 -->
												</div><!-- row -->

												<?php if(!$edit):?>
													<div class="row">
														<div class="col-xs-12 col-md-3"><div class="well well-sm"><?php esc_html_e('Password', 'javohome') ?></div></div>
														<div class="col-xs-12 col-md-9"><input type="password" class="form-control" name="jvfrm_home_r[user_pass]" data-required></div>
													</div>
													<div class="row">
														<div class="col-xs-12 col-md-3"><div class="well well-sm"><?php esc_html_e('Re-enter Password', 'javohome') ?></div></div>
														<div class="col-xs-12 col-md-9"><input type="password" class="form-control" name="jvfrm_home_r[user_pass_re]" data-required></div>
													</div>
												<?php endif; ?>
												<div class="row">
													<div class="col-xs-12 col-md-3"><div class="well well-sm"><?php esc_html_e('Email', 'javohome') ?></div></div>
													<div class="col-xs-12 col-md-9"><input type="text" class="form-control" name="jvfrm_home_r[user_email]" value="<?php jvfrm_home_input_str("user_email", (!empty($edit)?$edit->user_email:null));?>" data-required></div>
												</div>

												<?php do_action('jvfrm_home_edit_user_type'); ?>

												<div class="javo-register advanced">
													<hr>
													<div class="row">
														<div class="col-xs-12 col-md-3"><div class="well well-sm"><?php esc_html_e('Telephone', 'javohome') ?></div></div>
														<div class="col-xs-12 col-md-9"><input type="text" class="form-control" name="jvfrm_home_r[phone]" value="<?php jvfrm_home_input_str("phone", (!empty($edit)?get_user_meta($edit->ID, "phone", true):null));?>"></div>
													</div>
													<div class="row">
														<div class="col-xs-12 col-md-3"><div class="well well-sm"><?php esc_html_e('Mobile', 'javohome') ?></div></div>
														<div class="col-xs-12 col-md-9"><input type="text" class="form-control" name="jvfrm_home_r[mobile]" value="<?php jvfrm_home_input_str("mobile", (!empty($edit)?get_user_meta($edit->ID, "mobile", true):null));?>"></div>
													</div>
													<div class="row">
														<div class="col-xs-12 col-md-3"><div class="well well-sm"><?php esc_html_e('Fax', 'javohome') ?></div></div>
														<div class="col-xs-12 col-md-9"><input type="text" class="form-control" name="jvfrm_home_r[fax]" value="<?php jvfrm_home_input_str("fax", (!empty($edit)?get_user_meta($edit->ID, "fax", true):null));?>"></div>
													</div>
													<hr>
													<div class="row picture-upload-wrap">
														<div class="col-xs-12 col-md-3">
															<div class="well well-sm"><?php esc_html_e('Picture', 'javohome') ?></div>
														</div>
														<div class="col-xs-12 col-md-9">
															<div class="row">
																<div class="col-md-3 col-xs-12">
																	<div class="jvfrm_home_avatar_preview">
																		<?php
																		if(!empty($edit)){
																			$jvfrm_home_user_avatar_meta	= wp_get_attachment_image_src(get_user_meta($edit->ID, "avatar", true));
																			$jvfrm_home_user_header_meta	= wp_get_attachment_image_src(get_user_meta($edit->ID, "mypage_header", true));
																		};?>
																		<img src='<?php echo esc_attr( $jvfrm_home_user_avatar_meta[0] );?>' width='100' class='javo-upload-review'>
																	</div>
																	<input name="avatar" type="hidden" value="<?php echo !empty($edit)?get_user_meta($edit->ID, "avatar", true):null;?>">
																	<a class="btn btn-primary javo-fileupload admin-color-setting" data-title="<?php esc_attr_e('My Profile Featured Image', 'javohome');?>" data-input="input[name='avatar']" data-preview=".javo-upload-review"><?php esc_html_e('Upload', 'javohome');?></a>
																</div>
																<div class="col-md-9 col-xs-12">
																	<div class="jvfrm_home_background-img_preview">
																		<img src='<?php echo esc_attr( $jvfrm_home_user_header_meta[0] );?>' width='100%' height='100' class='javo-background-img-review'>
																	</div>
																	<input name="mypage_header" type="hidden" value="<?php echo !empty($edit)?get_user_meta($edit->ID, 'mypage_header', true):null;?>">
																	<a class="btn btn-primary javo-fileupload admin-color-setting" data-title="<?php esc_attr_e('Mypage heander Image', 'javohome');?>" data-input="input[name='mypage_header']" data-preview=".javo-background-img-review"><?php esc_html_e( "Background-Image Upload", 'javohome');?></a>
																</div>
															</div>
														</div>
													</div>
													<hr>
													<div class="row picture-upload-wrap">
														<div class="col-xs-12 col-md-3">
															<div class="well well-sm"><?php esc_html_e( "Author Box Background", 'javohome') ?></div>
														</div>
														<div class="col-xs-12 col-md-9">
															<div class="row">
																<div class="col-md-12">
																	<?php
																	if(!empty($edit)){
																		$jvfrm_home_user_describe = wp_get_attachment_image_src(get_user_meta($edit->ID, 'describe_image', true));
																	} ?>
																	<div class="jvfrm_home_describe_img_preview">
																		<img src='<?php echo esc_attr( $jvfrm_home_user_describe[0] );?>' class='javo-describe-img-preview img-responsive'>
																	</div>
																	<input name="describe_image" type="hidden" value="<?php echo !empty($edit)?get_user_meta($edit->ID, 'describe_image', true):null;?>">
																	<a class="btn btn-primary javo-fileupload admin-color-setting" data-title="<?php esc_attr_e( "Description Box Background", 'javohome');?>" data-input="input[name='describe_image']" data-preview=".javo-describe-img-preview"><?php esc_html_e( "Upload", 'javohome');?></a>
																</div>
															</div>
														</div>
													</div>
													<hr>
													<div class="row">
														<div class="col-xs-12 col-md-3"><div class="well well-sm"><?php esc_html_e('Description', 'javohome') ?></div></div>
														<div class="col-xs-12 col-md-9">
															<?php //wp_editor((($edit)? get_user_meta($edit->ID, "description", true) : ""), "javo-propfile-textarea", Array("textarea_name"=>"jvfrm_home_r[description]", "editor_class"=>"form-control", 'media_buttons' => 0));?>
															<textarea name="jvfrm_home_r[description]" class="form-control" rows="10"><?php echo esc_textarea( get_user_meta($edit->ID, "description", true) );?></textarea>
														</div>
													</div>

													<!--<h5><?php esc_html_e("Social Network IDs",'javohome'); ?></h5>-->
													<hr>
													<div class="row">
														<div class="col-xs-12 col-md-3"><div class="well well-sm"><?php esc_html_e('Twitter', 'javohome') ?></div></div>
														<div class="col-xs-12 col-md-9"><input type="text" class="form-control" name="jvfrm_home_r[twitter]" value="<?php jvfrm_home_input_str("twitter", (!empty($edit)?get_user_meta($edit->ID, "twitter", true):null));?>" placeholder="<?php esc_attr_e('Twitter', 'javohome');?>"></div>
													</div>
													<div class="row">
														<div class="col-xs-12 col-md-3"><div class="well well-sm"><?php esc_html_e('Facebook', 'javohome') ?></div></div>
														<div class="col-xs-12 col-md-9"><input type="text" class="form-control" name="jvfrm_home_r[facebook]" value="<?php jvfrm_home_input_str("facebook", (!empty($edit)?get_user_meta($edit->ID, "facebook", true):null));?>" placeholder="<?php esc_attr_e('Facebook', 'javohome');?>"></div>
													</div>
												</div><!-- javo Advanced information -->
												<div class="row">
													<div class="col-md-12 text-center">
														<input id="btn_save" class="btn btn-primary admin-color-setting" value="<?php esc_attr_e( "Save", 'javohome' )?>" type="button">
													</div>
												</div>
											</div><!-- Hidden -->
											<div class="javo-need-user-type <?php echo !empty($edit)?'hidden':'';?>">
												<div class="alert alert-warning alert-dismissable text-center">
													<?php esc_html_e("Please select your user type.",'javohome');?>
												</div>
												<br><br><br><br><br>
											</div>
										</form>
									</div><!-- main-content-box -->
								</div><!-- Row End -->


								<script type="text/javascript">
								(function($){
									"use strict";
									jQuery.fn.formcheck = function(type){
									var i=0;

									// Field Null Check
									$(this).each(function(){
										if( $(this).val() == "" && typeof($(this).data("Required")) != "undefined" ){
											$(this).addClass("isNull");
											i++;
										}else{
											$(this).removeClass("isNull");
										}
									});

									// Move Top Animation
									if(i > 0){
										$("html, body").animate({scrollTop:0}, 500);
										return false;
									};
										$(this).parents("form").ajaxFormUnbind().submit();
									}

									// Send Edit My Profile
									$("body").on("click", "#btn_save", function(){
										$('input[name^=jvfrm_home_r]').on("keyup", function(){$(this).removeClass("isNull");}).formcheck("select");
									});
								})(jQuery);
								</script>

							<!-- End Content -->
							</div> <!-- panel-body -->
						</div> <!-- panel -->
					</div> <!-- col-md-12 -->
				</div><!--/row-->
			</div><!-- wrap-right -->
		</div><!--/row-->
	</div><!--/.container-->
</div><!--jv-my-page-->
<?php
get_template_part('library/dashboard/mypage', 'common-script');
get_footer();