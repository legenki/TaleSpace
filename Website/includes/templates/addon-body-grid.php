<?php 
// Single page addon option
if( class_exists( 'Javo_Home_Single_Addon' ) ){
	$single_addon_options = get_single_addon_options(get_the_ID());
}
?>
<div class="container">
	<div class="row">
		<div id="javo-single-content" class="col-md-8 col-xs-12 property-single">
			<div class="row javo-detail-item-content">
				
			<div class="col-md-12 col-xs-12 item-description" id="javo-item-describe-section" data-jv-detail-nav>

					<h3 class="page-header"><?php esc_html_e( "Description", 'javohome' ); ?></h3>
					<div class="panel panel-default">
						<div class="panel-body">

							<!-- Post Content Container -->
							<div class="jv-custom-post-content">
								<div class="jv-custom-post-content-inner">
									<?php the_content(); ?>
								</div><!-- /.jv-custom-post-content-inner -->
								<div class="jv-custom-post-content-trigger">
									<i class="fa fa-plus"></i>
									<?php esc_html_e( "Read More", 'javohome' ); ?>

								</div><!-- /.jv-custom-post-content-trigger -->
							</div><!-- /.jv-custom-post-content -->

						</div><!--/.panel-body-->
					</div><!--/.panel-->
				</div><!-- /#javo-item-describe-section -->

				
				<?php lava_realestate_amenities(
					get_the_ID(),
					Array(
						'container_before' => sprintf( '
						<div class="col-md-12 col-xs-12 item-amenities" id="javo-item-amenities-section" data-jv-detail-nav>
							<h3 class="page-header">%1$s</h3>
							<div class="panel panel-default">
								<div class="panel-body">
									<div class="expandable-content" >',
									esc_html__( "Amenities", 'javohome' )
						),
						'container_after'  => '
									</div>
								</div><!-- panel-body -->
							</div>
						</div><!-- /#javo-item-amenities-section -->'
					)
				); ?>				

				<?php if( jvfrm_home_has_attach() ) : ?>
					<div class="col-md-12 col-xs-12 item-gallery">
						<?php get_template_part( 'includes/templates/html', 'single-grid-images' ); ?>
					</div><!-- /.col-md-12.item-gallery -->
				<?php endif; ?><!-- Detail Image-->
				
				<?php do_action( 'jvfrm_home_' . get_post_type() . '_single_author_after' ); 

				if( function_exists( 'lava_realestate_booking' ) && get_post_meta( get_the_ID(), '_booking', true ) ) { 
				?>
					<div class="col-md-12 col-xs-12" id="javo-item-booking-section">
							<?php do_action( 'jvfrm_home_' . get_post_type() . '_single_booking' ); ?>
					</div>
				<?php 
				} 
				
				if( function_exists( 'get_lava_realestate_review' ) ): ?>
					<div class="col-md-12 col-xs-12 item-description" id="javo-item-review-section" data-jv-detail-nav>

						<h3 class="page-header"><?php esc_html_e( "Review", 'javohome' ); ?></h3>
						<div class="panel panel-default">
							<div class="panel-body">
								<?php get_lava_realestate_review(); ?>
							</div><!--/.panel-body-->
						</div><!--/.panel-->
					</div><!-- /#javo-item-describe-section -->
				<?php endif; ?>
				
			</div><!-- /.javo-detail-item-content -->
		</div> <!-- /#javo-single-content -->


		<div id="javo-single-sidebar" class="col-md-4 sidebar-right">
			
		<?php if( !(isset($single_addon_options['disable_detail_section']) && $single_addon_options['disable_detail_section'] =='disable')) { ?>
			<!-- Listing meta section -->
			<div class="col-md-12 col-xs-12" id="javo-item-condition-section" data-jv-detail-nav>
				<h3 class="page-header"><?php esc_html_e( "Detail", 'javohome' ); ?></h3>
			<!--<h3 class="page-header"><?php esc_html_e( "Item detail", 'javohome' ); ?></h3>-->
				<div class="panel panel-default">
					<div class="panel-body">
						<?php if(''!=(get_post_meta( get_the_ID(), '_website', true ))){ ?>
							<div class="row">
								<div class="col-md-3 col-sm-3 col-xs-12">
									<span><?php esc_html_e( "Website", 'javohome' );?></span>
								</div>
								<div class="col-md-9 col-sm-9 col-xs-12">
									<span><a href="<?php echo esc_attr(get_post_meta( get_the_ID(), '_website', true ));?>" target="_blank"><?php echo esc_html(get_post_meta( get_the_ID(), '_website', true ));?></a></span>
								</div>
							</div><!-- /.row *website -->
						<?php } 
						if(''!=(get_post_meta( get_the_ID(), '_email', true ))){?>
							<div class="row">
								<div class="col-md-3 col-sm-3 col-xs-12">
									<span><?php esc_html_e( "Email", 'javohome' );?></span>
								</div>
								<div class="col-md-9 col-sm-9 col-xs-12">
									<span><?php echo esc_html(get_post_meta( get_the_ID(), '_email', true ));?></span>
								</div>
							</div><!-- /.row *email -->
						<?php } 
						if(''!=(get_post_meta( get_the_ID(), '_address', true ))){?>
							<div class="row">
								<div class="col-md-3 col-sm-3 col-xs-12">
									<span><?php esc_html_e( "Address", 'javohome' );?></span>
								</div>
								<div class="col-md-9 col-sm-9 col-xs-12">
									<span><?php echo esc_html(get_post_meta( get_the_ID(), '_address', true ));?></span>
								</div>
							</div><!-- /.row *address -->
						<?php } 
						if(''!=(get_post_meta( get_the_ID(), '_phone1', true ))){?>
							<div class="row">
								<div class="col-md-3 col-sm-3 col-xs-12">
									<span><?php esc_html_e( "Phone 1", 'javohome' );?></span>
								</div>
								<div class="col-md-9 col-sm-9 col-xs-12">
									<span><a href="tel://<?php echo esc_html(get_post_meta( get_the_ID(), '_phone1', true ));?>"><?php echo esc_html(get_post_meta( get_the_ID(), '_phone1', true ));?></a></span>
								</div>
							</div><!-- /.row *phone1-->
						<?php } 
						if(''!=(get_post_meta( get_the_ID(), '_phone2', true ))){?>
							<div class="row">
								<div class="col-md-3 col-sm-3 col-xs-12">
									<span><?php esc_html_e( "Phone 2", 'javohome' );?></span>
								</div>
								<div class="col-md-9 col-sm-9 col-xs-12">
									<span><a href="tel://<?php echo esc_html(get_post_meta( get_the_ID(), '_phone2', true ));?>"><?php echo esc_html(get_post_meta( get_the_ID(), '_phone2', true ));?></a></span>
								</div>
							</div><!-- /.row *phone2-->
						<?php } 
						if($listing_keyword = esc_html(lava_realestate_terms( get_the_ID(), 'listing_keyword' ))){?>
							<div class="row">
								<div class="col-md-3 col-sm-3 col-xs-12">
									<span><?php esc_html_e( "Keyword", 'javohome' );?></span>
								</div>
								<div class="col-md-9 col-sm-9 col-xs-12">
									<span><i><?php echo $listing_keyword; ?></i></span>
								</div>
							</div><!-- /.row *phone2-->
					<?php } ?>
					</div><!--/.panel-body -->
				</div><!--/.panel panel-default -->
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
			</div><!-- /#javo-item-location-section --><!-- Detail-->
			<?php	} ?>

			<?php do_action( 'jvfrm_home_' . get_post_type() . '_single_map_after' ); ?> <!--  Get Direction-->
			
			<?php
			$jvfrm_home_facebook_link = esc_html(get_post_meta( get_the_ID(), '_facebook_link', true ));
			$jvfrm_home_twitter_link = esc_html(get_post_meta( get_the_ID(), '_twitter_link', true ));
			$jvfrm_home_instagram_link = esc_html(get_post_meta( get_the_ID(), '_instagram_link', true ));
			$jvfrm_home_google_link = esc_html(get_post_meta( get_the_ID(), '_google_link', true ));

			if(!($jvfrm_home_facebook_link =='' && $jvfrm_home_twitter_link=='' && $jvfrm_home_instagram_link=='' && $jvfrm_home_google_link=='')){
			?>
			<div class="col-md-12 col-xs-12" id="javo-item-social-section" data-jv-detail-nav>
				<h3 class="page-header"><?php esc_html_e( "SOCIAL", 'javohome' ); ?></h3>
				<div class="jvfrm_home_single_listing_social-wrap">
					<?php if ($jvfrm_home_facebook_link!=''){ ?>
						<a href="<?php echo $jvfrm_home_facebook_link;?>" target="_blank" class="jvfrm_home_single_listing_facebook"><i class="fa fa-facebook" aria-hidden="true"></i></a>
					<?php }
					if ($jvfrm_home_twitter_link!=''){ ?>
						<a href="<?php echo $jvfrm_home_twitter_link;?>" target="_blank" class="jvfrm_home_single_listing_twitter"><i class="fa fa-twitter" aria-hidden="true"></i></a>
					<?php } 
					if ($jvfrm_home_instagram_link!=''){ ?>
						<a href="<?php echo $jvfrm_home_instagram_link;?>" target="_blank" class="jvfrm_home_single_listing_instagram"><i class="fa fa-instagram" aria-hidden="true"></i></a>
					<?php }
					if ($jvfrm_home_google_link!=''){ ?>
						<a href="<?php echo $jvfrm_home_google_link;?>" target="_blank" class="jvfrm_home_single_listing_google"><i class="fa fa-google" aria-hidden="true"></i></a>
					<?php } ?>
				</div>
			</div><!-- #javo-item-social-section -->
			<?php } ?>

			<?php do_action( 'jvfrm_home_' . get_post_type() . '_single_description_before' ); ?> <!--Custom Field -->
			
			<?php 
				global $jvfrm_home_tso;
				if(	 (int) $jvfrm_home_tso->get( 'single_listing_contact_form_id' , 0 ) > 0 
					&& false != $jvfrm_home_tso->get( 'single_listing_contact_type', false) ){ ?>
				<div class="col-md-12 col-xs-12" id="javo-item-contact-section" data-jv-detail-nav>
					<h3 class="page-header"><?php esc_html_e( "CONTACT", 'javohome' ); ?></h3>
					<?php
						switch( $jvfrm_home_tso->get( 'single_listing_contact_type' ) ) {
							case 'contactform'	: $jvfrm_home_quick_contact_shortcode = '[contact-form-7 id=%s]'; break;
							case 'ninjaform'	: $jvfrm_home_quick_contact_shortcode = '[ninja_forms id=%s]'; break;
						}
						$jvfrm_home_contact_form_shortcode = sprintf($jvfrm_home_quick_contact_shortcode, $jvfrm_home_tso->get( 'single_listing_contact_form_id' ) );
						echo do_shortcode( $jvfrm_home_contact_form_shortcode ); 
					?>
				</div><!-- #javo-item-social-section -->
			<?php } ?>
		</div><!-- /.col-md-3 -->
	</div><!--/.row-->
</div><!-- /.container -->