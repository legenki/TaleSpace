<?php
if( !isset( $jvfrm_home_booking_form ) )
	die;
?>
<div class="col-md-12 col-xs-12 lava-wc-booking" id="javo-item-wc-booking-section" data-jv-detail-nav>
	<h3 class="page-header"><?php esc_html_e( "Booking", 'javohome' ); ?></h3>
	<div class="panel panel-default">
		<div class="panel-body">
			<?php
			wc_get_template(
				'single-product/add-to-cart/booking.php',
				Array(
					'booking_form' => $jvfrm_home_booking_form
				),
				'woocommerce-bookings',
				WC_BOOKINGS_TEMPLATE_PATH
			); ?>
		</div><!--/.panel-body-->
	</div><!--/.panel-->
</div><!-- /#javo-item-describe-section -->