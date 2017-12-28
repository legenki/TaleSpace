<?php
$jvfrm_home_multi_filters			= Array(
	'property_amenities' => (Array) $post->req_property_amenities
);
if( !empty( $jvfrm_home_multi_filters  ) ) :  foreach( $jvfrm_home_multi_filters as $filter => $currentvalue ) {
	?>
	<div class="row text-left javo-map-box-advance-term">
		<div class="col-md-3 jv-advanced-titles javo-map-box-title">
			<?php echo get_taxonomy( $filter )->label; ?>
		</div><!-- /.col-md-3 -->
		<div class="col-md-9 jv-advanced-fields">
			<?php
			if( $jvfrm_home_this_term = get_terms( $filter, Array( 'hierarchical' => false, 'hide_empty' => false) ) )
				foreach( $jvfrm_home_this_term as $term )
				{
					echo "<div class=\"col-md-4 col-sm-6 filter-terms\">";
						echo "<label>";
							echo "<input type=\"checkbox\" name=\"jvfrm_home_map_multiple_filter\"" . ' ';
							echo "value=\"{$term->term_id}\" data-tax=\"{$filter}\" data-title=\"" . get_taxonomy( $filter )->label . "\"";
							checked( in_Array( $term->term_id, $currentvalue ) );
							echo ">";
							echo esc_html( $term->name );
						echo "</label>";

					echo "</div>";
				}
			else
				printf(
					"<div class=\"col-md-12\"><div class=\"alert alert-danger\">%s</div></div>"
					, sprintf( esc_html__( "Not Found %s", 'javohome' ) , $filter )
				);
			?>
		</div><!-- /.col-md-9 -->
	</div>
	<?php
} endif;