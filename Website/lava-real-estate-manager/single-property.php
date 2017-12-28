<?php
/**
 *
 *	Single Property
 *
 *	@package	Lavacode
 *	@subpackage Javo framework
 *	@author		JAVO
 */
get_header();
do_action( 'lava_' . get_post_type() . '_single_container_before' );
?>
<div id="post-<?php the_ID();?>" <?php post_class('single-item-tab'); ?>>
	<?php
	// This Theme Hook
	do_action( 'jvfrm_home_' . get_post_type() . '_single_body' );
	do_action( 'lava_' . get_post_type() . '_single_container_after' );?>
</div>
<?php
get_footer();