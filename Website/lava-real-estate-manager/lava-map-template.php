<?php
global
	$jvfrm_home_tso
	, $jvfrm_home_get_query
	, $jvfrm_home_post_query
	, $jvfrm_home_map_box_type;
get_header();
if( ! $jvfrm_home_this_map_opt = get_post_meta( $post->ID, 'jvfrm_home_map_page_opt', true) )
	$jvfrm_home_this_map_opt = Array();
$jvfrm_home_mopt = new jvfrm_home_array( $jvfrm_home_this_map_opt );
do_action( "lava_{$post->lava_type}_map_container_before", $post );
?>
<div id="javo-maps-listings-wrap" <?php post_class(); ?>>
	<?php do_action( "jvfrm_home_{$post->lava_type}_map_body" ); ?>
</div>
<fieldset>
	<input type="hidden" name="get_pos_trigger" value="<?php echo (boolean) esc_attr( $post->req_is_geolocation ); ?>">
	<input type="hidden" name="set_radius_value" value="<?php echo esc_attr( $post->lava_current_dis ); ?>">
</fieldset>
<script type="text/html" id="javo-map-not-found-data">
	<div class="jvfrm_home_map_not_found" data-dismiss>
		<?php esc_html_e( "Not found data", 'javohome' ); ?>
	</div>
</script>
<?php
echo stripslashes($jvfrm_home_tso->get('analytics'));
do_action( "lava_{$post->lava_type}_map_container_after", $post );
?>
</div><!-- /#page-style ( in header.php ) -->
<?php
get_template_part('includes/templates/modal', 'contact-us');
do_action( 'jvfrm_home_body_after', get_page_template_slug() );
wp_footer(); ?>
</body>
</html>