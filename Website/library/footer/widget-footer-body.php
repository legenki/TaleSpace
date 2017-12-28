<?php
$intFooterColumns = jvfrm_home_tso()->get( 'footer_sidebar_columns', 'column3' ) == 'column4' ? 4 : 3;
$arrFooterClasses = Array( 'container', 'footer-sidebar-wrap' );
$arrFooterClasses[] = 'columns-' . $intFooterColumns;
?>

<div class="footer-background-wrap">
	<footer class="footer-wrap">
		<div class="<?php echo join( ' ', $arrFooterClasses ); ?>">
			<div class="row">
				<?php
				for( $intCurWidget=1; $intCurWidget <= $intFooterColumns; $intCurWidget++ ) {
					$strItemColumnClasses = $intFooterColumns == 4 ? 'col-md-3' : 'col-md-4';
					$strItemSidebarName = 'sidebar-foot' . $intCurWidget;
					echo '<div class="' . $strItemColumnClasses . '">';
					if( is_active_sidebar( $strItemSidebarName ) ) {
						dynamic_sidebar( $strItemSidebarName );
					}
					echo '</div>';
				} ?>
			</div> <!-- row -->
			<?php if($jvfrm_home_tso->get('footer_info_use') == 'active'){ ?>

			<div class="jv-footer-separator"></div>

			<div class="row jv-footer-info">
				<div class="col-sm-3 jv-footer-info-logo-wrap">
					<div class="jv-footer-logo-text-title">
						<?php esc_html_e( "Contact", 'javohome' ); ?>
					</div>
					<div class="jv-footer-info-logo">
					<?php
					printf('<p class="contact_us_detail"><a href="%s"><img src="%s" data-at2x="%s" alt="javo-footer-info-logo"></a></p>'
						, get_site_url()
						, ($jvfrm_home_tso->get( 'bottom_logo_url' ) != "" ?  $jvfrm_home_tso->get('bottom_logo_url') : JVFRM_HOME_IMG_DIR."/jv-logo1.png")
						, ($jvfrm_home_tso->get( 'bottom_retina_logo_url' ) != "" ?  $jvfrm_home_tso->get('bottom_retina_logo_url') : "")
					);
					?>
					</div>

					<?php if($jvfrm_home_tso->get( 'email' )!=='') ?><div class="jv-footer-info-email"><i class="fa fa-envelope"></i> <a href="mailto:<?php echo  esc_attr($jvfrm_home_tso->get( 'email' )); ?>"><?php echo esc_html($jvfrm_home_tso->get( 'email' )); ?></a></div>
					<?php if($jvfrm_home_tso->get("working_hours")!=='') ?><div class="jv-footer-info-working-hour"><i class="fa fa-clock-o"></i> <?php echo esc_html($jvfrm_home_tso->get("working_hours")); ?></div>

					<?php if($jvfrm_home_tso->get('footer_social_use') == 'active'){ ?>
					<div class="jv-footer-info-social-icon-wrap">
						<?php
							if($jvfrm_home_tso->get( 'facebook' )!=='') printf("<div class='jv-footer-info-social'><a href='%s' target='_blank'><i class='fa fa-facebook'></i></a></div>", esc_html($jvfrm_home_tso->get("facebook")) );
							if($jvfrm_home_tso->get( 'twitter' )!=='') printf("<div class='jv-footer-info-social'><a href='%s' target='_blank'><i class='fa fa-twitter'></i></a></div>", esc_html($jvfrm_home_tso->get("twitter")) );
							if($jvfrm_home_tso->get( 'google' )!=='') printf("<div class='jv-footer-info-social'><a href='%s' target='_blank'><i class='fa fa-google-plus'></i></a></div>", esc_html($jvfrm_home_tso->get("google")) );
							if($jvfrm_home_tso->get( 'dribbble' )!=='') printf("<div class='jv-footer-info-social'><a href='%s' target='_blank'><i class='fa fa-dribbble'></i></a></div>", esc_html($jvfrm_home_tso->get("dribbble")) );
							if($jvfrm_home_tso->get( 'pinterest' )!=='') printf("<div class='jv-footer-info-social'><a href='%s' target='_blank'><i class='fa fa-pinterest'></i></a></div>", esc_html($jvfrm_home_tso->get("pinterest")) );
							if($jvfrm_home_tso->get( 'instagram' )!=='') printf("<div class='jv-footer-info-social'><a href='%s' target='_blank'><i class='fa fa-instagram'></i></a></div>", esc_html($jvfrm_home_tso->get("instagram")) );
						} ?>
					</div>
				</div>

				<div class="col-sm-6 jv-footer-info-text-wrap">
					<div class="jv-footer-info-text-title">
						<?php echo $jvfrm_home_tso->get('footer_info_text_title') !== '' ? esc_html($jvfrm_home_tso->get('footer_info_text_title')) : ''; ?>
					</div>

					<div class="jv-footer-info-text">
						<?php echo $jvfrm_home_tso->get('footer_text') !== '' ?  stripslashes($jvfrm_home_tso->get('footer_text', '')) : ''; ?>
					</div>
				</div>

				<div class="col-sm-3 jv-footer-info-image-wrap">
					<div class="jv-footer-info-image-title">
						<?php echo $jvfrm_home_tso->get('footer_info_image_title') !== '' ? esc_html($jvfrm_home_tso->get('footer_info_image_title')) : ''; ?>
					</div>
					<?php if(esc_html($jvfrm_home_tso->get('footer_info_image_url')) != ''){ ?>
					<div class="jv-footer-info-image">
						<img src="<?php echo esc_html($jvfrm_home_tso->get('footer_info_image_url')) ; ?>" alt="javo-footer-info-image">
					</div>
					<?php } ?>
				</div>

			</div><!-- row jv-footer-info -->
			<?php } ?>

			<?php if( has_nav_menu( 'footer_menu' ) ){ ?>
			<div class="pull-left" style="padding-left:15px;">
				<div class="row footer-copyright">
					<div class="text-center">
						<?php echo stripslashes($jvfrm_home_tso->get('copyright', null));?>
					</div>
				</div> <!-- footer-copyright -->
			</div>
			<div class="pull-right">
					<?php
					if( has_nav_menu( 'footer_menu' ) )
					{
						wp_nav_menu( array(
							'menu_class'		=> 'list-unstyled'
							, 'theme_location'	=> "footer_menu"
							, 'depth'			=> 1
							, 'container'		=> false
							, 'fallback_cb'		=> "wp_page_menu"
							, 'walker'			=> new wp_bootstrap_navwalker()
						) );
					} ?>
					</div>
			</div>
			<?php }else{ ?>
				<div class="row footer-copyright">
					<div class="text-center">
						<?php echo stripslashes($jvfrm_home_tso->get('copyright', null));?>
					</div>
				</div> <!-- footer-copyright -->
			<?php } ?>

		</div> <!-- container-->
	</footer>
</div>