<?php
/*****	My Page ***/
get_header();
?>
<div class="jv-my-page jv-my-items">
	<div class="row top-row">
		<div class="col-md-12"></div> <!-- col-12 -->
	</div> <!-- top-row -->
	<div class="container secont-container-content">
		<div class="row row-offcanvas row-offcanvas-left">
			<?php get_template_part('library/dashboard/' . jvfrm_home_dashboard()->page_style . '/sidebar', 'menu');?>
			<div class="col-sm-9 main-content-right dashboard-right" id="main-content">
				<div class="row">
					<div class="col-md-12">
						<div class="panel panel-default panel-wrap">
							<div class="panel-heading">

								<div class="row">
									<div class="col-md-12 my-page-title">
										<?php esc_html_e( "New Listing", 'javohome' ); ?>
									</div> <!-- my-page-title -->
								</div> <!-- row -->
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