<?php
/* Map Switcher */{
	$jvfrm_home_listing_switcher =
		Array(
			'maps'	=>
				Array(
					'label'		=> esc_html__( "Map", 'javohome' )
					, 'icon'	=> 'fa fa-globe'
				)
			, 'listings'	=>
				Array(
					'label'		=> esc_html__( "List", 'javohome' )
					, 'icon'	=> 'fa fa-bars'
				)
		);
} ?>
<div id="javo-maps-listings-switcher" <?php jvfrm_home_map_class( 'text-right'); ?>>
	<div class="col-sm-8 switcher-left">
		<?php do_action( 'jvfrm_home_'. jvfrm_home_core()->slug . '_map_switcher_before' ); ?>
	</div><!-- /.col-xs-8 -->
	<div class="col-sm-4 switcher-right">
		<div class="btn-group" data-toggle="buttons">
			<?php
			foreach( $jvfrm_home_listing_switcher as $type => $attr )
			{
				$this_listing_type	= apply_filters(
					'jvfrm_home_' . jvfrm_home_core()->slug . '_map_switcher_value',
					get_post_meta(get_the_ID(), '_page_listing', true )
				);
				$jvfrm_home_listing_type		= $this_listing_type != '1' ? 'maps' : 'listings';
				$is_active				= $this_listing_type == '1';
				$is_active				= $jvfrm_home_listing_type === $type ? ' active' : $is_active;
				echo "<label class=\"btn btn-default {$is_active}\">";
					echo "<input type=\"radio\" name=\"m\" value=\"{$type}\"" . checked( (boolean)$is_active, true, false ) . ">";
					echo "<i class=\"{$attr['icon']}\"></i>" . ' ';
					echo "<span>".esc_html( $attr['label'] )."</span>";
				echo "</label>";
			} ?>
		</div><!--/.btn-group-->
	</div>
</div>
<div id="javo-maps-wrap" class="hidden">
	<div class="row">
		<?php get_template_part( 'templates/parts/part-multiple-listing-type', 'map' ); ?>
	</div><!-- /.row -->
</div>
<div id="javo-listings-wrap" class="hidden">
	<div class="row">
		<?php get_template_part( 'templates/parts/part-multiple-listing-type', 'list' ); ?>
	</div><!-- /.row -->
</div>

<div id="javo-infow-brief-window" class="modal fade" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-body"></div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default btn-block admin-color-setting" data-dismiss="modal"><?php esc_html_e( "Close", 'javohome' ); ?></button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->