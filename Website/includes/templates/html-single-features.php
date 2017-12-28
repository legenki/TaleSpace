<div class="col-md-12 col-xs-12 item-summary">
	<div class="item-summary-inner ">
		<div class="row">
			<div class="item-summary-author col-md-2 col-xs-2">
				<a href="<?php echo jvfrm_home_getUserPage( get_the_author_meta( 'ID' ) ); ?>">
					<?php echo get_avatar( get_the_author_meta( 'ID' ) ); ?>
					<div class="javo-summary-author-name"><?php the_author_meta( 'display_name' ); ?></div>
				</a>
			</div>
			<div class="item-summary-icon col-md-2 col-xs-2">
				<i class="fa fa-home"></i>
				<p><?php _e( "Type", 'javohome' );?></p>
				<span><?php lava_realestate_featured_terms( 'property_type' ); ?></span>
			</div>
			<div class="item-summary-icon col-md-2 col-xs-2">
				<i class="fa fa-th"></i>
				<p><?php _e( "Status", 'javohome' );?></p>
				<span><?php lava_realestate_featured_terms( 'property_status' ); ?></span>
			</div>
			<div class="item-summary-icon col-md-2 col-xs-2">
				<i class="fa fa-money"></i>
				<p><?php _e( "Price", 'javohome' );?></p>
				<span><?php echo lava_realestate_get_price(); ?></span>
			</div>
			<div class="item-summary-icon col-md-2 col-xs-2">
				<i class="fa fa-expand"></i>
				<p><?php _e( "Area", 'javohome' );?></p>
				<span><?php echo lava_realestate_get_area(); ?></span>
			</div>
		</div><!--/.row-->
	</div><!--/.item-summary-inner-->
</div><!-- /.col-md-12.col-xs-12 -->