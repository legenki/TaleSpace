<div class="col-md-12 col-xs-12 item-condition" id="javo-item-condition-section" data-jv-detail-nav>
	<h3 class="page-header"><?php _e( "Condition", 'javohome' ); ?></h3>
	<div class="panel panel-default">
		<div class="panel-body">
			<div class="row summary_items">
				<div class="col-md-12 col-xs-12 jv-summary-detail-wrap">
					<?php if(''!=($post->_bedrooms)){?>
					<div class="row jv-meta-bedrooms">
						<div class="col-md-4 col-xs-12">
							<span><?php _e( "Bedrooms", 'javohome' );?></span>
						</div>
						<div class="col-md-8 col-xs-12">
							<span><?php echo intVal( $post->_bedrooms); ?></span>
						</div>
					</div><!-- /.row *bedrooms -->
					<?php }
					if(''!=($post->_garages)){ ?>
					<div class="row jv-meta-garages">
						<div class="col-md-4 col-xs-12">
							<span><?php _e( "Garages", 'javohome' ); ?></span>
						</div>
						<div class="col-md-8 col-xs-12">
							<span><?php echo intVal( $post->_garages); ?></span>
						</div>
					</div><!-- /.row *garages -->
					<?php } ?>
					<div class="row jv-meta-price">
						<div class="col-md-4 col-xs-12">
							<span><?php _e( "Price", 'javohome' ); ?></span>
						</div>
						<div class="col-md-8 col-xs-12">
							<span><?php echo lava_realestate_get_price(); ?></span>
						</div>
					</div><!-- /.row *price -->
					<?php if(''!=($post->_bathrooms)){ ?>
					<div class="row jv-meta-bethrooms">
						<div class="col-md-4 col-xs-12">
							<span><?php _e( "Bathrooms", 'javohome' ); ?></span>
						</div>
						<div class="col-md-8 col-xs-12">
							<span><?php echo intVal( $post->_bathrooms ); ?></span>
						</div>
					</div><!-- /.row *bathrooms -->
					<?php }
					if(0!=(lava_realestate_get_area())){  ?>
					<div class="row jv-meta-area">
						<div class="col-md-4 col-xs-12">
							<span><?php _e( "Area", 'javohome' ); ?></span>
						</div>
						<div class="col-md-8 col-xs-12">
							<span><?php echo lava_realestate_get_area(); ?></span>
						</div>
					</div><!-- /.row *area -->
					<?php } 
					if(''!=(lava_realestate_terms( get_the_ID(), 'property_city' ))){ ?>
					<div class="row jv-meta-city">
						<div class="col-md-4 col-xs-12">
							<span><?php _e( "Location", 'javohome' ); ?></span>
						</div>
						<div class="col-md-8 col-xs-12">
							<span><?php echo lava_realestate_terms( get_the_ID(), 'property_city' ); ?></span>
						</div>
					</div><!-- /.row *city(location) -->
					<?php } ?>
				</div><!--/.col-md-6.jv-summary-detail-wrap -->
			</div><!--/.summary_items -->
		</div><!--/.panel-body -->
	</div><!--/.panel panel-default -->
</div><!--/.col-md-12 -->