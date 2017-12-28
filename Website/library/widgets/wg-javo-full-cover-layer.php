<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

class jvfrm_home_fullcover_search_widget extends WP_Widget
{

	public $wID			= '';

	public function __construct() {
        parent::__construct(
			'jvfrm_home_fullcover_search',
			'[JAVO]' . esc_html__( "Full Cover Layer Page", 'javohome' ),
			Array()
		);
	}

	public function widget( $args, $instance )
	{
		global $jvfrm_home_tso;
		extract( $args, EXTR_SKIP );

		$instance			= !empty( $instance ) ? $instance : Array();
		$jvfrm_home_query			= new jvfrm_home_Array( $instance );
		$jvfrm_home_this_style	= '';

		$this->wID		= 'jv-full-cover-' . rand( 0, 100 ) . rand( 0, 100 );

		if( false !== $jvfrm_home_query->get( 'button_style', false ) )
		{
			$jvfrm_home_this_style_attribute	= Array(
				'font-family'				=> 'railway'
				, 'background-color'	=> $jvfrm_home_query->get( 'btn_bg_color' )
				, 'color'						=> $jvfrm_home_query->get( 'btn_txt_color' ) . " !important"
				, 'border-radius'		=> $jvfrm_home_query->get( 'btn_radius', 0 ) . 'px'
			);
			foreach( $jvfrm_home_this_style_attribute as $option => $key ){ if( !empty( $key ) ){ $jvfrm_home_this_style .= "$option:$key;"; } }
		}

		ob_start();
		?>
		<li class="widget_top_menu">
			<a href="javascript:void(0)" style="<?php echo $jvfrm_home_this_style;?>" class="btn" data-full-cover="<?php echo $this->wID;?>">
				<?php
				if( '' !== ( $tmp = $jvfrm_home_query->get( 'btn_icon', '' ) ) ) {
					echo "<i class=\"fa {$tmp}\"></i> ";
				}
				echo esc_html($jvfrm_home_query->get( 'btn_txt' )); ?>
			</a>

			<div class="jv-full-conver-container <?php echo $this->wID; ?>" style="display:inline-block;">
				<div class="jv-fullcover-search-inner">
					<div class="container">
						<button type="button" class="close">&times;</button>
						<?php echo do_shortcode( $jvfrm_home_query->get( 'widget_cotents' ) ); ?>
					</div>
				</div><!-- /.container -->
			</div>
		</li>
		<?php
		ob_end_flush();
	}

	public function form( $instance ) {
		/* Set up some default widget settings. */
		$defaults						= array(
			'btn_txt'					=> ''
			, 'btn_icon'				=> 'fa-search'
			, 'btn_txt_color'			=> ''
			, 'btn_bg_color'			=> ''
			, 'btn_border_color'	=> ''
			, 'btn_radius'				=> ''
			, 'date'						=> true
		);
		$instance					= wp_parse_args( (array) $instance, $defaults );
		$btn_txt					= esc_attr( $instance['btn_txt'] );
		$btn_icon					= esc_attr( $instance['btn_icon'] );
		$btn_txt_color			= esc_attr( $instance['btn_txt_color'] );
		$btn_bg_color			= esc_attr( $instance['btn_bg_color'] );
		$btn_border_color	= esc_attr( $instance['btn_border_color'] );
		$btn_radius				= esc_attr( $instance['btn_radius'] );
		$jvfrm_home_var						= new jvfrm_home_ARRAY( $instance );
	?>
	<div class="javo-dtl-trigger" data-javo-dtl-el="[name='<?php echo esc_attr( $this->get_field_name( 'button_style' ) ); ?>']" data-javo-dtl-val="set" data-javo-dtl-tar=".javo-full-cover-cat-detail-style">
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'btn_txt' ) ); ?>"><?php esc_html_e( 'Label', 'javohome' ); ?> : </label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'btn_txt' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'btn_txt' ) ); ?>" type="text" value="<?php echo $btn_txt; ?>" >
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'btn_icon' ) ); ?>"><?php esc_html_e( 'Font-Awsome Code', 'javohome' ); ?> : </label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'btn_icon' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'btn_icon' ) ); ?>" type="text" value="<?php echo $btn_icon; ?>" >
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'widget_cotents' ) ); ?>"><?php esc_html_e( "Custom Contents", 'javohome' ); ?> : </label>
			<textarea id="<?php echo $this->get_field_id( 'widget_cotents' ); ?>" name="<?php echo $this->get_field_name( 'widget_cotents' ); ?>" class="widefat" cols="16" rows="20"><?php echo esc_textarea( $jvfrm_home_var->get( 'widget_cotents' ) ); ?></textarea>
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
		<div class="javo-full-cover-cat-detail-style">
			<p class="no-margin">
				<label for="<?php echo esc_attr( $this->get_field_id( 'btn_txt_color' ) ); ?>"><?php esc_html_e( 'Button text color', 'javohome' ); ?> : </label>
				<input name="<?php echo esc_attr( $this->get_field_name( 'btn_txt_color' ) ); ?>" type="text" class="wp_color_picker" data-default-color="#ffffff" value="<?php echo $btn_txt_color; ?>" >
			</p>
			<p class="no-margin">
				<label for="<?php echo esc_attr( $this->get_field_id( 'btn_bg_color' ) ); ?>"><?php esc_html_e( 'Button background color:', 'javohome' ); ?></label>
				<input name="<?php echo esc_attr( $this->get_field_name( 'btn_bg_color' ) ); ?>" type="text" class="wp_color_picker" data-default-color="#ffffff" value="<?php echo $btn_bg_color; ?>" >
			</p>
			<p class="no-margin">
				<label for="<?php echo esc_attr( $this->get_field_id( 'btn_border_color' ) ); ?>"><?php esc_html_e( 'Button border color:', 'javohome' ); ?></label>
				<input name="<?php echo esc_attr( $this->get_field_name( 'btn_border_color' ) ); ?>" type="text" class="wp_color_picker" data-default-color="#ffffff" value="<?php echo $btn_border_color; ?>" >
			</p>
			<p class="no-margin">
				<label for="<?php echo esc_attr( $this->get_field_id( 'btn_radius' ) ); ?>"><?php esc_html_e( 'Button radius (only number):', 'javohome' ); ?></label>
				<input name="<?php echo esc_attr( $this->get_field_name( 'btn_radius' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'btn_radius' ) ); ?>" type="text" value="<?php echo $btn_radius; ?>" >
			</p>
		</div><!-- /.javo-full-cover-cat-detail-style -->
	</div><!-- /.javo-dtl-trigger -->

	<?php

	}
}
/**
 * Register widget.
 *
 * @since 1.0
 */
add_action( 'widgets_init', create_function( '', 'register_widget( "jvfrm_home_fullcover_search_widget" );' ) );