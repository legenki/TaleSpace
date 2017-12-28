<?php
$arrContactInfos	= Array(
	Array(
		'label'		=> esc_html__( "Author", 'javohome' ),
		'value'		=> esc_attr( $post->display_name ),
		'link'		=> 'enable'
	),
	Array(
		'label'		=> esc_html__( "Phone", 'javohome' ),
		'value'		=> esc_attr( $post->_phone1 ),
	),
);

$author_url = jvfrm_home_getUserPage( get_the_author_meta( 'ID' ) );
add_filter( 'wp_footer', 'jvfrm_home_single_contact_modal_html' );
function jvfrm_home_single_contact_modal_html(){
	global $lava_contact_shortcode;
	?>
	<div class="modal fade lava_contact_modal" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-body">
					<button type="button" class="close" data-dismiss="modal" aria-label="<?php esc_attr_e( "Close", 'javohome' ); ?>"><span aria-hidden="true">&times;</span></button>
					<div class="contact-form-widget-wrap">
						<?php echo apply_filters( 'the_content', $lava_contact_shortcode ); ?>
					</div> <!-- contact-form-widget-wrap -->
				</div>
			</div>
		</div>
	</div>
	<?php
} ?>
<?php
add_filter( 'wp_footer', 'jvfrm_home_single_report_modal_html' );
function jvfrm_home_single_report_modal_html(){
	global $lava_contact_shortcode;
	?>
	<div class="modal fade lava_report_modal" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-body">
					<button type="button" class="close" data-dismiss="modal" aria-label="<?php esc_attr_e( "Close", 'javohome' ); ?>"><span aria-hidden="true">&times;</span></button>
					<div class="contact-form-widget-wrap">
						<?php echo apply_filters( 'the_content', jvfrm_home_get_reportShortcode() );  ?>
					</div> <!-- contact-form-widget-wrap -->
				</div>
			</div>
		</div>
	</div>
	<?php
} ?>

<?php
/** Get Widget Title, Button Labels **/
$widget_data = get_option('widget_lava_contact_single_page');
$lv_wg_title = !empty( $widget_data[3]['contact_widget_title'] ) ? $widget_data[3]['contact_widget_title'] : esc_html__( "Contact", 'javohome' );
$lv_wg_contact_btn_label = !empty( $widget_data[3]['contact_btn_label'] ) ? $widget_data[3]['contact_btn_label'] : esc_html__( "Contact", 'javohome' );
$lv_wg_report_btn_label = !empty( $widget_data[3]['report_btn_label'] ) ? $widget_data[3]['report_btn_label'] : esc_html__( "Report", 'javohome' );
?>
<form class="cart lava-wg-author-contact-form" method="post" enctype='multipart/form-data'>
	<div id="lv-single-contact" class="panel panel-default">
		<div class="panel-heading admin-color-setting">
			<div class="row">
				<div class="col-md-12">
					<h3><?php echo $lv_wg_title; ?></h3>
				</div><!-- /.col-md-12 -->
			</div><!-- /.row -->
		</div><!-- /.panel-heading -->

		<div class="panel-body">
			<div class="row">
				<div class="col-md-12">
					<ul class="list-group">
						<li class="list-group-item">

							<div class="row avatar-style">
								<div class="col-md-4 author-thumb-wrap">
										<a href="<?php echo jvfrm_home_getUserPage( get_the_author_meta( 'ID' ) ); ?>" class="header-avatar">
											<?php echo get_avatar( get_the_author_meta( 'ID' ) ); ?>
										</a>
								</div> <!-- col-md-4 author-thum-wrap -->
								<div class="col-md-8 author-meta-wrap">
									<?php
							/* Portion informations */
							if( ! empty( $arrContactInfos ) )
							{
								echo "<ul style=\"position: relative;\">\n";
								foreach( $arrContactInfos as $args )
								{
									echo "\t<li class=\"\">\n";
										//echo "\t\t<div class=\"hidden-xs hidden-sm col-lg-4\">\n";
											//echo "\t\t\t{$args['label']}\n";
										//echo "\t\t</div>\n";

										if(isset($args['link'])){
											echo "\t\t<div class=\"\"><a href=\"{$author_url}\">\n";
												echo "\t\t\t{$args['value']}\n";
											echo "\t\t</a></div>\n";
										}else{
											echo "\t\t<div class=\"\">\n";
												echo "\t\t\t{$args['value']}\n";
											echo "\t\t</div>\n";
										}

									echo "\t</li>\n";
								}
								echo "</ul>\n";
							} ?>
									<?php
									$jvfrm_home_facebook_link = esc_html(get_post_meta( get_the_ID(), '_facebook_link', true ));
									$jvfrm_home_twitter_link = esc_html(get_post_meta( get_the_ID(), '_twitter_link', true ));
									$jvfrm_home_instagram_link = esc_html(get_post_meta( get_the_ID(), '_instagram_link', true ));
									$jvfrm_home_google_link = esc_html(get_post_meta( get_the_ID(), '_google_link', true ));
									$jvfrm_home_website_link = esc_html(get_post_meta( get_the_ID(), '_website', true ));

									if(!($jvfrm_home_facebook_link =='' && $jvfrm_home_twitter_link=='' && $jvfrm_home_instagram_link=='' && $jvfrm_home_google_link=='')){
									?>
									<div id="javo-item-social-section" data-jv-detail-nav>
										<div class="jvfrm_home_single_listing_social-wrap">
											<?php if ($jvfrm_home_facebook_link!=''){ ?>
												<a href="<?php echo $jvfrm_home_facebook_link;?>" target="_blank" class="jvfrm_home_single_listing_facebook javo-tooltip" data-original-title="<?php _e('Facebook','javohome'); ?>">
													<span class="fa-stack fa-lg"><i class="fa fa-circle fa-stack-2x"></i><i class="fa fa-facebook fa-stack-1x fa-inverse"></i></span>
												</a>
											<?php }
											if ($jvfrm_home_twitter_link!=''){ ?>
												<a href="<?php echo $jvfrm_home_twitter_link;?>" target="_blank" class="jvfrm_home_single_listing_twitter javo-tooltip" data-original-title="<?php _e('Twitter','javohome'); ?>">
													<span class="fa-stack fa-lg"><i class="fa fa-circle fa-stack-2x"></i><i class="fa fa-twitter fa-stack-1x fa-inverse"></i></span>
												</a>
											<?php } 
											if ($jvfrm_home_instagram_link!=''){ ?>
												<a href="<?php echo $jvfrm_home_instagram_link;?>" target="_blank" class="jvfrm_home_single_listing_instagram javo-tooltip" data-original-title="<?php _e('Instagram','javohome'); ?>">
													<span class="fa-stack fa-lg"><i class="fa fa-circle fa-stack-2x"></i><i class="fa fa-instagram fa-stack-1x fa-inverse"></i></span>
												</a>
											<?php }
											if ($jvfrm_home_google_link!=''){ ?>
												<a href="<?php echo $jvfrm_home_google_link;?>" target="_blank" class="jvfrm_home_single_listing_google javo-tooltip" data-original-title="<?php _e('Google+','javohome'); ?>">
													<span class="fa-stack fa-lg"><i class="fa fa-circle fa-stack-2x"></i><i class="fa fa-google fa-stack-1x fa-inverse"></i></span>
												</a>
											<?php } ?>
											<?php if ($jvfrm_home_website_link!=''){?>
												<a href="<?php echo $jvfrm_home_website_link;?>" target="_blank" class="jvfrm_home_single_listing_website javo-tooltip" data-original-title="<?php _e('Website','javohome'); ?>">
													<span class="fa-stack fa-lg"><i class="fa fa-circle fa-stack-2x"></i><i class="fa fa-link fa-stack-1x fa-inverse"></i></span>
												</a>
											<?php } ?>
										</div>
									</div><!-- #javo-item-social-section -->
									<?php } ?>									
								</div> <!-- col-md-8 author-meta-wrap -->
							</div> <!-- avatar style -->

							<div class="text-style">
							<?php
							/* Portion informations */
							if( ! empty( $arrContactInfos ) )
							{
								echo "<ul style=\"position: relative;\">\n";
								foreach( $arrContactInfos as $args )
								{
									echo "\t<li class=\"row\">\n";
										echo "\t\t<div class=\"col-lg-4 col-sm-4\">\n";
											echo "\t\t\t{$args['label']}\n";
										echo "\t\t</div>\n";

										if(isset($args['link'])){
											echo "\t\t<div class=\"col-xs-11 col-lg-8 col-sm-8\"><a href=\"{$author_url}\">\n";
												echo "\t\t\t{$args['value']}\n";
											echo "\t\t</a></div>\n";
										}else{
											echo "\t\t<div class=\"col-xs-11 col-lg-8 col-sm-8\">\n";
												echo "\t\t\t{$args['value']}\n";
											echo "\t\t</div>\n";
										}

									echo "\t</li>\n";
								}
								echo "</ul>\n";
							} ?>

							<?php
								$jvfrm_home_facebook_link = esc_html(get_post_meta( get_the_ID(), '_facebook_link', true ));
								$jvfrm_home_twitter_link = esc_html(get_post_meta( get_the_ID(), '_twitter_link', true ));
								$jvfrm_home_instagram_link = esc_html(get_post_meta( get_the_ID(), '_instagram_link', true ));
								$jvfrm_home_google_link = esc_html(get_post_meta( get_the_ID(), '_google_link', true ));
								$jvfrm_home_website_link = esc_html(get_post_meta( get_the_ID(), '_website', true ));

								if(!($jvfrm_home_facebook_link =='' && $jvfrm_home_twitter_link=='' && $jvfrm_home_instagram_link=='' && $jvfrm_home_google_link=='')){
								?>
								<div id="javo-item-social-section" class="row" data-jv-detail-nav>
									<div class="jvfrm_home_single_listing_social-wrap">
										<?php if ($jvfrm_home_facebook_link!=''){ ?>
											<a href="<?php echo $jvfrm_home_facebook_link;?>" target="_blank" class="jvfrm_home_single_listing_facebook javo-tooltip" data-original-title="<?php _e('Facebook','javohome'); ?>">
												<span class="fa-stack fa-lg"><i class="fa fa-circle fa-stack-2x"></i><i class="fa fa-facebook fa-stack-1x fa-inverse"></i></span>
											</a>
										<?php }
										if ($jvfrm_home_twitter_link!=''){ ?>
											<a href="<?php echo $jvfrm_home_twitter_link;?>" target="_blank" class="jvfrm_home_single_listing_twitter javo-tooltip" data-original-title="<?php _e('Twitter','javohome'); ?>">
												<span class="fa-stack fa-lg"><i class="fa fa-circle fa-stack-2x"></i><i class="fa fa-twitter fa-stack-1x fa-inverse"></i></span>
											</a>
										<?php } 
										if ($jvfrm_home_instagram_link!=''){ ?>
											<a href="<?php echo $jvfrm_home_instagram_link;?>" target="_blank" class="jvfrm_home_single_listing_instagram javo-tooltip" data-original-title="<?php _e('Instagram','javohome'); ?>">
												<span class="fa-stack fa-lg"><i class="fa fa-circle fa-stack-2x"></i><i class="fa fa-instagram fa-stack-1x fa-inverse"></i></span>
											</a>
										<?php }
										if ($jvfrm_home_google_link!=''){ ?>
											<a href="<?php echo $jvfrm_home_google_link;?>" target="_blank" class="jvfrm_home_single_listing_google javo-tooltip" data-original-title="<?php _e('Google+','javohome'); ?>">
												<span class="fa-stack fa-lg"><i class="fa fa-circle fa-stack-2x"></i><i class="fa fa-google fa-stack-1x fa-inverse"></i></span>
											</a>
										<?php } ?>
										<?php if ($jvfrm_home_website_link!=''){?>
											<a href="<?php echo $jvfrm_home_website_link;?>" target="_blank" class="jvfrm_home_single_listing_website javo-tooltip" data-original-title="<?php _e('Website','javohome'); ?>">
												<span class="fa-stack fa-lg"><i class="fa fa-circle fa-stack-2x"></i><i class="fa fa-link fa-stack-1x fa-inverse"></i></span>
											</a>
										<?php } ?>
									</div>
								</div><!-- #javo-item-social-section -->
								<?php } ?>
							</div> <!-- text-style -->
													
						</li><!--/.list-group-item-->
					</ul>
				</div><!--/.col-md-12-->
			</div><!--/.row-->

		</div><!-- /.panel-body -->

		<div class="panel-body author-contact-button-wrap">

			<!-- Large modal -->
			<button type="button" class="btn btn-primary admin-color-setting lava_contact_modal_button" data-toggle="modal" data-target=".lava_contact_modal"><?php echo $lv_wg_contact_btn_label; ?></button>
			<!-- Add Wish List -->
			<div class="row share">
				<div class="col-md-6 text-center">

					<button type="button" class="btn admin-color-setting-hover lava-Di-share-trigger">
						<?php esc_html_e( "Share", 'javohome' ); ?>
					</button>

				</div><!-- /.col-md-6 -->
				<div class="col-md-6 text-center">

					<button type="button" class="btn btn-primary admin-color-setting-hover lava_report_modal_button" data-toggle="modal" data-target=".lava_report_modal">
						<?php echo $lv_wg_report_btn_label; ?>
					</button>
				</div><!-- /.col-md-12 -->
			</div><!-- /.row -->
			<div class="row">
				<div class="col-md-12">
					<?php
					if( function_exists( 'lava_realestate_claim_button' ) )
						lava_realestate_claim_button(
							Array(
								'class'	=> 'btn btn-block admin-color-setting-hover',
								'label'		=> esc_html__( "Claim", 'javohome' ),
								'icon'		=> false
							)
						);
					?>
					<?php
					if( function_exists( 'lava_realestate_booking_button' ) )
						lava_realestate_booking_button(
							Array(
								'class'	=> 'btn btn-block admin-color-setting-hover',
								'label'		=> esc_html__( "Booking", 'javohome' ),
								'icon'		=> false
							)
						);
					?>
				</div><!-- /.col-md-12 -->
			</div><!-- /.row -->
		</div><!-- /.panel-body -->
	</div><!-- /.panel -->
	<fieldset>
		<input type="hidden" name="ajaxurl" value="<?php echo esc_url( admin_url( 'admin-ajax.php' ) );?>">
	</fieldset>
</form>

<!-- Modal -->

<script type="text/html" id="lava-Di-share">

	<div class="row">

		<div class="col-md-12">

			<header class="modal-header">
				<?php esc_html_e( "Share", 'javohome' ); ?>
				<button type="button" class="close">
					<span aria-hidden="true">&times;</span>
				</button>
			</header>
			<div class="row">
				<div class="col-md-9">

					<div class="input-group">
						<span class="input-group-addon">
							<i class="fa fa-link"></i>
						</span><!-- /.input-group-addon -->
						<input type="text" value="<?php the_permalink(); ?>" class="form-control" readonly>

					</div>
				</div><!-- /.col-md-9 -->
				<div class="col-md-3">
					<button class="btn btn-primary btn-block" id="lava-wg-url-link-copy" data-clipboard-text="<?php the_permalink(); ?>">
						<i class="fa fa-copy"></i>
						<?php esc_html_e( "Copy URL", 'javohome' );?>
					</button>
				</div><!-- /.col-md-3 -->
			</div><!-- /,row -->

			<p>

				<div class="row">

					<div class="col-md-4">
						<button class="btn btn-info btn-block javo-share sns-facebook" data-title="<?php the_title(); ?>" data-url="<?php the_permalink(); ?>">
							<?php esc_html_e( "Facebook", 'javohome' );?>
						</button>
					</div><!-- /.col-md-4 -->

					<div class="col-md-4">
						<button class="btn btn-info btn-block javo-share sns-twitter" data-title="<?php the_title(); ?>" data-url="<?php the_permalink(); ?>">
							<?php esc_html_e( "Twitter", 'javohome' );?>
						</button>
					</div><!-- /.col-md-4 -->

					<div class="col-md-4">
						<button class="btn btn-info btn-block javo-share sns-google" data-title="<?php the_title(); ?>" data-url="<?php the_permalink(); ?>">
							<?php esc_html_e( "Google +", 'javohome' );?>
						</button>
					</div><!-- /.col-md-4 -->

				</div><!-- /,row -->
			</p>
		</div>
	</div>
</script>