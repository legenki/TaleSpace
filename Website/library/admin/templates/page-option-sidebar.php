<?php
if( ! $get_jvfrm_home_opt_sidebar = get_post_meta( $post->ID, 'jvfrm_home_sidebar_type', true ) )
	$get_jvfrm_home_opt_sidebar		= 'full';
?>

<label class="jvfrm_home_pmb_option sidebar op_s_left <?php echo sanitize_html_class( $get_jvfrm_home_opt_sidebar == 'left'? ' active':'' );?>">
	<span class="ico_img"></span>
	<p><input name="jvfrm_home_opt_sidebar" value="left" type="radio" <?php checked($get_jvfrm_home_opt_sidebar == 'left');?>> <?php esc_html_e("Left",'javohome'); ?></p>
</label>
<label class="jvfrm_home_pmb_option sidebar op_s_right <?php echo sanitize_html_class( $get_jvfrm_home_opt_sidebar == 'right'? ' active':'' );?>">
	<span class="ico_img"></span>
	<p><input name="jvfrm_home_opt_sidebar" value="right" type="radio" <?php checked($get_jvfrm_home_opt_sidebar == 'right');?>> <?php esc_html_e("Right",'javohome'); ?></p>
</label>
<label class="jvfrm_home_pmb_option sidebar op_s_full <?php echo sanitize_html_class( $get_jvfrm_home_opt_sidebar == 'full' || $get_jvfrm_home_opt_sidebar == ''? ' active':'' );?>">
	<span class="ico_img"></span>
	<p><input name="jvfrm_home_opt_sidebar" value="full" type="radio" <?php checked( $get_jvfrm_home_opt_sidebar == 'full' || $get_jvfrm_home_opt_sidebar == '');?>> <?php esc_html_e("Fullwidth",'javohome'); ?></p>
</label>