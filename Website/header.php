<?php
/**
 * The Header template for Javo Theme
 *
 * @package WordPress
 * @subpackage Javo
 * @since Javo Themes 1.0
 */
// Get Options
?><!DOCTYPE html>
<!--[if IE 7]>
<html class="ie ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) | !(IE 8)  ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
<meta charset="<?php echo esc_attr( get_bloginfo( 'charset' ) ); ?>" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="pingback" href="<?php echo esc_attr( get_bloginfo( 'pingback_url' ) ); ?>" />

<!--[if lte IE 9]>
<script src="<?php echo get_template_directory_uri(); ?>/assets/js/html5.js" type="text/javascript"></script>
<![endif]-->
<?php wp_head(); ?>
</head>
<body <?php body_class();?>>

<?php do_action( 'jvfrm_home_after_body_tag' );?>
<?php if( defined('ICL_LANGUAGE_CODE') ){ ?>
	<input type="hidden" name="jvfrm_home_cur_lang" value="<?php echo esc_attr( ICL_LANGUAGE_CODE );?>">
<?php }; ?>
<div class="right_menu_inner">
	<div class="navmenu navmenu-default navmenu-fixed-right offcanvas" style="" data-placement="right">
		<div class="navmenu-fixed-right-canvas">
			<?php
			if( is_active_sidebar('canvas-menu-widget') )
				dynamic_sidebar("canvas-menu-widget"); ?>
		</div><!--navmenu-fixed-right-canvas-->
    </div> <!-- navmenu -->
</div> <!-- right_menu_inner -->
<div class="loading-page hidden <?php echo jvfrm_home_tso()->get( 'preloader_hide' ) !== 'use'? 'hidden': false;?>">
	<div id="status" class="bulat">
			<div id="dalbulat">
				<?php
				echo join( "\n", Array(
					"<span>",
					join( "</span>\n\t<span>", preg_split( '//u', strtoupper( esc_html__( "Loading", 'javohome' ) ), -1 ) ),
					'</span>',
				) ); ?>
			</div>
			<div class="luarbulat"></div>
	</div>
</div><!-- /.loading-page -->

<div><?php do_action( 'lava_navi_logo_after' ); ?></div>
<?php do_action( 'jvfrm_home_output_header', get_the_ID() ); ?>
<div id="page-style" class="canvas">