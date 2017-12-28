<div class="row text-left order-filter">
	<div class="col-md-3 javo-map-box-title javo-map-box-title">
		<?php esc_html_e( "Order", 'javohome' ); ?>
	</div><!-- /.col-md-3 -->
	<div class="col-md-6 javo-map-box-field">
		<div class="row">
			<div class="col-md-12 col-xs-12 jv-map-order-type">
				<div class="btn-group javo-map-filter-order" data-toggle="buttons">
					<label class="btn btn-primary btn-xs active" data-order="desc">
						
						<input type="radio" name="map_order[orderby]" value="date" autocomplete="off" checked>
						<?php esc_html_e( "Date", 'javohome' ); ?>
						<!--<span class="order-title icon glyphicon glyphicon-time"></span>-->
						
						<span class="glyphicon glyphicon-arrow-up asc hidden"></span>
						<span class="glyphicon glyphicon-arrow-down desc"></span>
					</label>
					<label class="btn btn-primary btn-xs" data-order="desc">
						
						<input type="radio" name="map_order[orderby]" value="name" autocomplete="off">
						<?php esc_html_e( "Name", 'javohome' ); ?>
						<!--<span class="order-title icon glyphicon glyphicon-list-alt"></span>-->
						
						<span class="glyphicon glyphicon-arrow-up asc hidden"></span>
						<span class="glyphicon glyphicon-arrow-down desc"></span>
					</label>
				</div>
			</div>
		</div><!-- /.row -->
	</div><!-- /.col-md-9 -->
</div><!-- /.row -->