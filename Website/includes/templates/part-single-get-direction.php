<!-- div class="col-md-12 col-xs-12 lava-get-direction" id="javo-item-wc-get-direction-section" data-jv-detail-na1v>
	<h3 class="page-header"><?php esc_html_e( "Get Direction", 'javohome' ); ?></h3>
	<div class="panel panel-default">
		<div class="panel-body">
			<?php
			$objGetDirection->add_class( 'button', 'admin-color-setting btn btn-primary' );
			$objGetDirection->load_template(
				'single-get-direction.php',
				$objGetDirection->getParams()
			); ?>
		</div><!--/.panel-body-- >
	</div><!--/.panel-- >
</div --><!-- /#javo-item-describe-section -->
<div id="jvlv-single-get-direction" class="modal fade" tabindex="-1" role="dialog">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-body" style="position:relative;">
				<?php
				$objGetDirection->add_class( 'button', 'admin-color-setting btn btn-primary' );
				$objGetDirection->load_template(
					'single-get-direction.php',
					$objGetDirection->getParams()
				); ?>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default btn-block" data-dismiss="modal"><?php esc_html_e( "Close", 'javohome' ); ?></button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->