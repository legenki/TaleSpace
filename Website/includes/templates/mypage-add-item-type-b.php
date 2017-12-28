<?php
/*****
My Page
***/
get_header();
?>
<div class="jv-my-page jv-my-items">
	<div class="row top-row container jv-submit-item">
		<h2 class="jv-my-page-user-name"><?php printf('%s %s', esc_html( $jvfrm_home_curUser->first_name ), esc_html( $jvfrm_home_curUser->last_name) );?></h2>
		<div class="col-md-12">
			<div class="row">
				<div class="col-md-12 my-page-title">
					<?php esc_html_e( "New Item", 'javohome' ); ?>
				</div> <!-- my-page-title -->
			</div> <!-- row -->
			<?php get_template_part('library/dashboard/' . jvfrm_home_dashboard()->page_style . '/sidebar', 'user-info');?>
		</div> <!-- col-12 -->
	</div> <!-- top-row -->

	<div class="container second-container-content jv-submit-item-form">
		<div class="row row-offcanvas row-offcanvas-left">
			<div class="col-xs-12 col-sm-12 main-content-right" id="main-content">
				<div class="row">
					<div class="col-md-12">
						<div class="panel panel-default panel-wrap">
							<div class="panel-heading">
							</div>
							<div class="panel-body">
								<?php echo do_shortcode( "[lava_realestate_form]" ); ?>
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