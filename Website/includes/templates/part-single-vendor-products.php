<?php if( !empty( $vendor_products ) ){ ?>
<div class="col-md-12 col-xs-12 lava-wc-vendor" id="javo-item-wc-vendor-section" data-jv-detail-nav>
	<h3 class="page-header"><?php esc_html_e( "Hot Deals", 'javohome' ); ?></h3>
	<div class="panel panel-default">
		<div class="panel-body">
			<div class="javo-shortcode woocommerce woocommerce-page">
				<ul class="products">
					<?php
					if( !empty( $vendor_products ) ) : foreach( $vendor_products as $objProduct ) {
						$objModule = new moduleWC1( $objProduct );
						echo $objModule->output();
					} endif;?>
				</ul>
			</div>
		</div><!--/.panel-body-->
	</div><!--/.panel-->
</div><!-- /#javo-item-describe-section -->
<?php } ?>