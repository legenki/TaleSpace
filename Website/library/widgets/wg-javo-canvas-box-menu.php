<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

class jvfrm_home_Canvas_Menu extends WP_Widget {
	/**
	 * Widget setup
	 */
	function __construct() {
		$widget_ops = array(
			'description' => esc_html__( 'This menu is from canvas menu on appearance.', 'javohome' )
		);
                parent::__construct( 'jvfrm_home_Canvas_Menu', esc_html__('[JAVO] Canvas Menu-Menu list','javohome'), $widget_ops );
	}
	/**
	 * Display widget
	 */
	function widget( $args, $instance ) {
		extract( $args, EXTR_SKIP );
		echo $before_widget;
		ob_start();
		?>
		<div class="container-fluid navmenu-fixed-right-canvas-fullwidth right-canvas-menu">
			<?php
			wp_nav_menu( Array(
				'theme_location'	=> 'canvas_menu'
				, 'depth'			=> 1
				, 'container'		=> false
				, 'items_wrap'		=> '<ul class="right-canvas-menu-list">%3$s</ul>'
				, 'fallback_cb'		=> 'wp_bootstrap_navwalker::fallback'
			) ); ?>
		</div><!-- /.right-canvas-menu -->
		<?php
		ob_end_flush();
		echo $after_widget;
	}

	/**
	 * Widget setting
	 */
	function form( $instance ) {}
}
/**
 * Register widget.
 *
 * @since 1.0
 */
add_action( 'widgets_init', create_function( '', 'register_widget( "jvfrm_home_Canvas_Menu" );' ) );