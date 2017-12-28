<div id="javo-item-detail-image-section" data-images="<?php echo jvfrm_home_detail_images_parse_for_lightGallery();?>">
	<div class="row">
		<div class="col-md-12">
			<h3 class="page-header"><?php _e( "Detail Images", 'javohome' ); ?></h3>
			<?php
			if( function_exists( 'lava_realestate_attach' ) ) : lava_realestate_attach(
				Array(
					'type'				=> 'ul'
					, 'title'			=> ''
					, 'size'			=> 'javo-item-detail'
					, 'container_class'	=> 'lava-detail-images flexslider hidden'
					, 'wrap_class'		=> 'slides'
					, 'featured_image'	=> true
				)
			); endif; ?>
		</div><!-- /.col-md-12 -->
	</div>
</div>