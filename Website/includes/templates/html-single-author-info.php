<div class="col-md-12 col-xs-12" id="javo-item-author-section">
	<div class="row">
		<div class="col-md-12 col-xs-12">
			<h3 class="page-header"><?php esc_html_e( "Author", 'javohome' ); ?></h3> <span class="author_allpost_link"><a href="<?php echo jvfrm_home_getUserPage( get_the_author_meta( 'ID' ) ); ?>" class="admin-color-setting"><?php esc_html_e( "ALL POSTS", 'javohome' ); ?></a></span>
			<div class="item-summary-inner ">
				<div class="row">
					<div class="item-summary-author col-md-2 col-xs-2">
						<a href="<?php echo jvfrm_home_getUserPage( get_the_author_meta( 'ID' ) ); ?>">
							<?php echo get_avatar( get_the_author_meta( 'ID' ) ); ?>
						</a>
					</div>
					<div class="item-author-description col-md-10 col-xs-10">
						<div class="row">
							<div class="col-md-8 col-xs-6">
								<div class="javo-summary-author-name"><?php the_author_meta( "display_name" ); ?></div>
							</div> <!--/ .col-md-8 col-xs-6 -->
							<div class="col-md-4 col-xs-6">
							</div> <!--/ .col-md-4 col-xs-6 -->

							<div class="col-md-12 col-xs-12">
								<?php the_author_meta( "description" ); ?>
							</div> <!--/ .col-md-12 col-xs-12 -->

						</div> <!--/ .row -->
					</div>
				</div><!--/.row-->
			</div><!--/.item-summary-inner-->
		</div><!-- /.col-md-12.col-xs-12 -->
	</div><!-- /.row -->
</div><!-- /#javo-item-author-section -->