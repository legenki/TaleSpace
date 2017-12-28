<!--moblie menu-->
<div class="navbar-mobile-wrap">
	<?php if( is_singular( self::SLUG ) ) : ?>
		<div class="row visible-xs">
			<div class="col-md-12">
				<button type="button" class="btn btn-pirmary btn-block admin-color-setting" data-toggle="modal" data-target=".lava_contact_modal">
					<?php esc_html_e( "CONTACT", 'javohome' ); ?>
				</button>
			</div>
		</div>
	<?php endif; ?>
	<!-- Brand and toggle get grouped for better mobile display -->
	<div class="row navbar-moblie visible-xs">
		<!-- Button trigger modal -->
		<div class="col-xs-4 col-xs-offset-4 text-center">
			<button type="button" class="btn btn-primary btn-lg javo-mobile-modal-button admin-color-setting" data-toggle="modal" data-target="#jv-mobile-search-form">
			  <i class="fa fa-search"></i>
			</button>
		</div>
	</div><!--/.navbar-header-->
</div><!--/.row-->
<!--/.moblie menu-->