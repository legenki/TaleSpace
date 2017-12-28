<?php
$jvfrm_home_this_terms_object	= get_queried_object();
$jvfrm_home_this_taxonomy		= isset( $jvfrm_home_this_terms_object->taxonomy ) ? $jvfrm_home_this_terms_object->taxonomy : null;
$jvfrm_home_this_term				= get_queried_object_id();
$jvfrm_home_this_term_featured	= get_option( 'lava_property_type_' . $jvfrm_home_this_term . '_featured' );
$jvfrm_home_term_featured_meta	= wp_get_attachment_image_src( $jvfrm_home_this_term_featured, 'full' );
$jvfrm_home_this_term_featured_src = '';
if( isset( $jvfrm_home_term_featured_meta[0] ) ) {
	$jvfrm_home_this_term_featured_src = " background-image:url({$jvfrm_home_term_featured_meta[0] }); ";
}
?>
<div class="jv-archive-top-bg" style="<?php echo $jvfrm_home_this_term_featured_src;?>">
	<div class="jv-archive-container">
		<?php
		printf(
			wp_kses(
				__('<h3 class=\"jv-archive-header\">%s</h3>', 'javohome' ),
				Array( 'h3' => Array( 'class' => Array()) )
			),
			strtoupper( $jvfrm_home_this_terms_object->name )
		); ?>
		<i class="jv-archive-header-position">
			<a href="<?php echo esc_url( home_url( '/' ) );?>"><?php esc_html_e('HOME', 'javohome');?></a>
			<?php
			if( isset( $jvfrm_home_this_terms_object->taxonomy ) ){
				$jvfrm_home_archive_current = jvfrm_home_get_archive_current_position($jvfrm_home_this_term, $jvfrm_home_this_terms_object->taxonomy);
				foreach( $jvfrm_home_archive_current as $term_id){
					$term = get_term($term_id, $jvfrm_home_this_terms_object->taxonomy);
					printf(
						wp_kses( '&gt; <a href="%s">%s</a> ', Array( 'a' => Array( 'href' => Array() ) ) ),
						get_term_link( $term ),
						strtoupper($term->name)
					);
				}
			} ?>
		</i>
	</div> <!-- jv-archive-container -->
	<div class="jv-archive-describe">
		<?php echo get_term( $jvfrm_home_this_term, $jvfrm_home_this_taxonomy )->description;  ?>
	</div>
</div>