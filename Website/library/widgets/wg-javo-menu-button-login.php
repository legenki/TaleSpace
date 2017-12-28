<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

class jvfrm_home_Menu_button_login extends WP_Widget
{
	/**
	 * Widget setup
	 */
	function __construct() {
		$widget_ops = array(
			'description' => esc_html__( 'Login button (only for menu).', 'javohome' )
		);
                parent::__construct( 'jvfrm_home_menu_btn_login', esc_html__('[JAVO] Menu button - LOGIN','javohome'), $widget_ops );
	}

	/**
	 * Display widget
	 */
	function widget( $args, $instance )
	{
		add_action( 'wp_footer', Array( $this, 'load_script' ) );
		extract( $args, EXTR_SKIP );
		$instance					= !empty( $instance ) ? $instance : Array();
		$jvfrm_home_query					= new jvfrm_home_array( $instance );

		$jvfrm_home_this_style			= "";

		if( false !== $jvfrm_home_query->get( 'button_style', false ) )
		{

			$jvfrm_home_this_style_attribute	= Array(
				'background-color'	=> $jvfrm_home_query->get("btn_bg_color")
				, 'border-color'		=> $jvfrm_home_query->get("btn_bg_color")
				, 'color'				=> $jvfrm_home_query->get("btn_txt_color")
				, 'border-radius'		=> $jvfrm_home_query->get("btn_radius", 0).'px'
			);
			foreach( $jvfrm_home_this_style_attribute as $option => $key ){ $jvfrm_home_this_style .= "{$option}:{$key};"; }
		}

		ob_start();
		?>

		<li class="dropdown widget_top_menu javo-wg-menu-button-login-wrap javo-in-mobile x-<?php echo sanitize_html_class( $jvfrm_home_query->get( 'btn_visible', '') );?>">
			<?php
			if( is_user_logged_in() )
			{
				$jvfrm_home_redirect		= esc_url( home_url( JVFRM_HOME_DEF_LANG.JVFRM_HOME_MEMBER_SLUG . '/' . wp_get_current_user()->user_login . '/' ) . JVFRM_HOME_MEMBER_SLUG );
				$jvfrm_home_logout_redirect = esc_url( wp_logout_url( home_url( '/' ) ) );

				printf( "
					<a
					href=\"{$jvfrm_home_redirect}\"
					class=\"btn dropdown-toggle\"
					style=\"{$jvfrm_home_this_style}\"
					data-mobile-icon=\"{$jvfrm_home_query->get('after_log_icon')}\">%s</a>
					<li class=\"widget_top_menu javo-wg-menu-button-logout-wrap\"><a href= \"%s\" class=\"btn\" style=\"{$jvfrm_home_this_style}\">%s</a>",
					esc_attr( $jvfrm_home_query->get('btn_txt_after', esc_html__('My Page', 'javohome') ) ),
					$jvfrm_home_logout_redirect,
					esc_attr( $jvfrm_home_query->get('btn_txt_logout', esc_html__('Logout', 'javohome') ) )
				);

			}else{
				$jvfrm_home_redirect		= "data-toggle=\"modal\" data-target=\"#login_panel\"";
				printf( "<a
					href=\"javascript:\"
					class=\"btn\"
					style=\"{$jvfrm_home_this_style}\"
					{$jvfrm_home_redirect}>%s</a>",
					esc_attr( $jvfrm_home_query->get('btn_txt', esc_html__('Login', 'javohome') ) )
				);
			} ?>
		</li>
		<?php
		ob_end_flush();
	}

	public function load_script()
	{
		wp_enqueue_script( 'javo-widget-script' );
	}


	/**
	 * Widget setting
	 */
	function form( $instance ) {
		/* Set up some default widget settings. */
        $defaults = array(
            'btn_txt'				=> ''
			, 'btn_txt_logout' => ''
			, 'btn_txt_after'		=> ''
			, 'btn_txt_color'		=> ''
			, 'btn_bg_color'		=> ''
			, 'btn_border_color'	=> ''
			, 'btn_radius'			=> ''
			, 'btn_visible'			=> ''
			, 'date'				=> true
        );

		$instance				= wp_parse_args( (array) $instance, $defaults );
		$jvfrm_home_var				= new jvfrm_home_array( $instance );


		$btn_txt				= esc_attr( $instance['btn_txt'] );
		$btn_txt_logout = esc_attr( $instance['btn_txt_logout']);
		$btn_txt_after			= esc_attr( $instance['btn_txt_after'] );
		$btn_txt_color			= esc_attr( $instance['btn_txt_color'] );
		$btn_bg_color			= esc_attr( $instance['btn_bg_color'] );
		$btn_border_color		= esc_attr( $instance['btn_border_color'] );
		$btn_radius				= esc_attr( $instance['btn_radius'] );
		$btn_visible			= esc_attr( $instance['btn_visible'] );
	?>
	<div class="javo-dtl-trigger" data-javo-dtl-el="[name='<?php echo esc_attr( $this->get_field_name( 'button_style' ) ); ?>']" data-javo-dtl-val="set" data-javo-dtl-tar=".javo-button-login-detail-style">
		<p>
			<label><?php esc_html_e( "Show on mobile", 'javohome'); ?></label>
			<label>
				<input
					name="<?php echo esc_attr( $this->get_field_name( 'btn_visible' ) ); ?>"
					type="radio"
					value=""
					<?php checked( '' == $btn_visible );?>
				>
				<?php esc_html_e( "Enable", 'javohome' );?>
			</label>

			<label>
				<input
					name="<?php echo esc_attr( $this->get_field_name( 'btn_visible' ) ); ?>"
					type="radio"
					value="hide"
					<?php checked( 'hide' == $btn_visible );?>
				>
				<?php esc_html_e( "Hide", 'javohome' );?>
			</label>
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'btn_txt' ) ); ?>"><?php esc_html_e( 'Logged in Button Text:', 'javohome' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'btn_txt' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'btn_txt' ) ); ?>" type="text" value="<?php echo esc_attr( $btn_txt ); ?>" >
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'btn_txt_logout' ) ); ?>"><?php esc_html_e( 'Logged out Button Text:', 'javohome' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'btn_txt_logout' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'btn_txt_logout' ) ); ?>" type="text" value="<?php echo esc_attr( $btn_txt_logout ); ?>" >
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'btn_txt_after' ) ); ?>"><?php esc_html_e( 'My page Button Text:', 'javohome' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'btn_txt_after' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'btn_txt_after' ) ); ?>" type="text" value="<?php echo esc_attr( $btn_txt_after ); ?>" >
		</p>
		<dl>
			<dt>
				<label><?php esc_html_e( "Style Setting", 'javohome'); ?></label>
			</dt>
			<dd>
				<label>
					<input
						name="<?php echo esc_attr( $this->get_field_name( 'button_style' ) ); ?>"
						type="radio"
						value=""
						<?php checked( '' == $jvfrm_home_var->get('button_style') );?>>
					<?php esc_html_e( "Same as navi menu color", 'javohome' );?>
				</label>
				<br>
				<label>
					<input
						name="<?php echo esc_attr( $this->get_field_name( 'button_style' ) ); ?>"
						type="radio"
						value="set"
						<?php checked( 'set' == $jvfrm_home_var->get('button_style') );?>>
					<?php esc_html_e( "Setup own custom color", 'javohome' );?>
				</label>
			</dd>
		</dl>
		<div class="javo-button-login-detail-style">
			<p class="no-margin">
				<label for="<?php echo esc_attr( $this->get_field_id( 'btn_txt_color' ) ); ?>"><?php esc_html_e( 'Button text color:', 'javohome' ); ?></label>
				<input name="<?php echo esc_attr( $this->get_field_name( 'btn_txt_color' ) ); ?>" type="text" class="wp_color_picker" data-default-color="#ffffff" value="<?php echo esc_attr( $btn_txt_color ); ?>" >
			</p>
			<p class="no-margin">
				<label for="<?php echo esc_attr( $this->get_field_id( 'btn_bg_color' ) ); ?>"><?php esc_html_e( 'Button background color:', 'javohome' ); ?></label>
				<input name="<?php echo esc_attr( $this->get_field_name( 'btn_bg_color' ) ); ?>" type="text" class="wp_color_picker" data-default-color="#ffffff" value="<?php echo esc_attr( $btn_bg_color ); ?>" >
			</p>
			<p class="no-margin">
				<label for="<?php echo esc_attr( $this->get_field_id( 'btn_border_color' ) ); ?>"><?php esc_html_e( 'Button border color:', 'javohome' ); ?></label>
				<input name="<?php echo esc_attr( $this->get_field_name( 'btn_border_color' ) ); ?>" type="text" class="wp_color_picker" data-default-color="#ffffff" value="<?php echo esc_attr( $btn_border_color ); ?>" >
			</p>
			<p class="no-margin">
				<label for="<?php echo esc_attr( $this->get_field_id( 'btn_radius' ) ); ?>"><?php esc_html_e( 'Button radius (only number):', 'javohome' ); ?></label>
				<input name="<?php echo esc_attr( $this->get_field_name( 'btn_radius' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'btn_radius' ) ); ?>" type="text" value="<?php echo esc_attr( $btn_radius ); ?>" >
			</p>
		</div><!-- /.javo-button-login-detail-style -->
	</div><!-- /.javo-dtl-trigger -->

	<?php
	}
}
/**
 * Register widget.
 *
 * @since 1.0
 */
add_action( 'widgets_init', create_function( '', 'register_widget( "jvfrm_home_Menu_button_login" );' ) );