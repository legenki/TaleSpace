<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

class jvfrm_home_Categories_opener_wg extends WP_Widget
{

	/**
	 * Widget setup
	 */
	function __construct() {
		$widget_ops = array(
			'description' => esc_html__( 'Category button on Navi Menu', 'javohome' )
		);
        parent::__construct( 'jvfrm_home_canvas_category', esc_html__('[JAVO] Full cover category button','javohome'), $widget_ops );
	}

	/**
	 * Display widget
	 */
	function widget( $args, $instance ) {

		extract( $args, EXTR_SKIP );

		global $jvfrm_home_tso;

		$instance					= !empty( $instance ) ? $instance : Array();
		$jvfrm_home_query					= new jvfrm_home_Array( $instance );
		$jvfrm_home_categories			= get_terms( 'property_type', Array( 'parent' => 0, 'hide_empty' => 0 ) );
		$jvfrm_home_this_style			= "";

		if( false !== $jvfrm_home_query->get( 'button_style', false ) )
		{
			$jvfrm_home_this_style_attribute	= Array(
				'font-family'			=> 'railway'
				, 'background-color'	=> $jvfrm_home_query->get("btn_bg_color")
				, 'color'				=> $jvfrm_home_query->get("btn_txt_color") . " !important"
				, 'border-radius'		=> $jvfrm_home_query->get("btn_radius", 0).'px'
			);
			foreach( $jvfrm_home_this_style_attribute as $option => $key ){ if( !empty( $key ) ){ $jvfrm_home_this_style .= "$option:$key;"; } }
		}

		if( 'hide' === ( $jvfrm_home_this_scroll = $jvfrm_home_query->get('use_scroll', '' ) ) ) {
			$jvfrm_home_this_scroll = "style='overflow:hidden; overflow-y:scroll; height:100%;'";
		}

		ob_start();
		?>
		<li class="widget_top_menu">
			<a href="#javo-sitemap" style="<?php echo $jvfrm_home_this_style;?>" class="btn">
				<?php
				if( '' !== ( $tmp = $jvfrm_home_query->get('btn_icon', '') ) ) {
					echo "<i class=\"fa {$tmp}\"></i> ";
				}
				echo $jvfrm_home_query->get("btn_txt", esc_html__( "Categories", 'javohome' ) ); ?>
			</a>

			<div id="javo-sitemap" style="display:inline-block;">
				<button type="button" class="close">&times;</button>
				<div class="container" <?php echo $jvfrm_home_this_scroll; ?>>
					<form role="form" class="javo-sitemap-form">

						<div class="row javo-terms">
							<?php
							foreach( $jvfrm_home_categories as $cat )
							{
								$jvfrm_home_this_cat_url = get_term_link( $cat );
								$jvfrm_home_this_cat_url = $jvfrm_home_tso->get('page_item_result', 0);
								$jvfrm_home_this_cat_url = apply_filters( 'jvfrm_home_wpml_link', $jvfrm_home_this_cat_url );
								$jvfrm_home_this_depth_1_terms = get_terms( 'property_type', Array(
									'parent'			=> $cat->term_id
									, 'hide_empty'		=> 0
								) );
								echo "<div class='pull-left javo-terms-item'>";
									echo "<a class='javo-terms-item-title'  href='{$jvfrm_home_this_cat_url}?category={$cat->term_id}'><strong>{$cat->name}</strong></a>";
										echo "<ul class='list-unstyled'>";
											if(
												!is_wp_error( $jvfrm_home_this_depth_1_terms ) &&
												!empty( $jvfrm_home_this_depth_1_terms ) &&
												'hide' !== $jvfrm_home_query->get( 'sub_cate' , false )
											){
												foreach( $jvfrm_home_this_depth_1_terms as $sub_cat )
												{
													$jvfrm_home_this_sub_cat_url = get_term_link( $sub_cat );
													$jvfrm_home_this_sub_cat_url = $jvfrm_home_tso->get('page_item_result', 0);
													$jvfrm_home_this_sub_cat_url = apply_filters( 'jvfrm_home_wpml_link', $jvfrm_home_this_sub_cat_url );

													echo "<li><a href='{$jvfrm_home_this_sub_cat_url}?category={$sub_cat->term_id}'>{$sub_cat->name} </a></li>";
												}
											}
										echo "</ul>";
								echo "</div>";
							} ?>
						</div><!-- /.row -->
					</form>
				</div><!-- /.container -->
			</div>
		</li>

		<script type="text/javascript">
		//** Sitemap **//
		jQuery(function($){

			$( "#javo-sitemap" ).appendTo( "body" );

			$('a[href="#javo-sitemap"]').on('click', function(event) {
				event.preventDefault();

				$('#javo-sitemap').addClass('open');
				$('#javo-sitemap > form	> input[type="search"]').focus();
			});

			$('#javo-sitemap, #javo-sitemap	button.close').on('click keyup', function(event) {
				if (event.target ==	this ||	event.target.className == 'close' || event.keyCode == 27) {
					$(this).removeClass('open');
				}
			});
		});
		</script>

		<?php
		ob_end_flush();
	}


	/**
	 * Widget setting
	 */
	function form( $instance ) {
		/* Set up some default widget settings. */
		$defaults = array(
			'btn_txt'				=> ''
			, 'btn_icon'			=> 'fa-folder'
			, 'btn_txt_color'		=> ''
			, 'btn_bg_color'		=> ''
			, 'btn_border_color'	=> ''
			, 'btn_radius'			=> ''
			, 'date'				=> true
		);
		$instance				= wp_parse_args( (array) $instance, $defaults );
		$btn_txt				= esc_attr( $instance['btn_txt'] );
		$btn_icon				= esc_attr( $instance['btn_icon'] );
		$btn_txt_color			= esc_attr( $instance['btn_txt_color'] );
		$btn_bg_color			= esc_attr( $instance['btn_bg_color'] );
		$btn_border_color		= esc_attr( $instance['btn_border_color'] );
		$btn_radius				= esc_attr( $instance['btn_radius'] );
		$jvfrm_home_var				= new jvfrm_home_ARRAY( $instance );
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
		<dl>
			<dt>
				<label><?php esc_html_e( "Display Sub Category", 'javohome'); ?></label>
			</dt>
			<dd>
				<label>
					<input
						name="<?php echo esc_attr( $this->get_field_name( 'sub_cate' ) ); ?>"
						type="radio"
						value=""
						<?php checked( '' == $jvfrm_home_var->get('sub_cate') );?>>
					<?php esc_html_e( "Show", 'javohome' );?>
				</label>
				<br>
				<label>
					<input
						name="<?php echo esc_attr( $this->get_field_name( 'sub_cate' ) ); ?>"
						type="radio"
						value="hide"
						<?php checked( 'hide' == $jvfrm_home_var->get('sub_cate') );?>>
					<?php esc_html_e( "Hide", 'javohome' );?>
				</label>
			</dd>
		</dl>
		<dl>
			<dt>
				<label><?php esc_html_e( "Scroll enable (if you have long categories)", 'javohome'); ?></label>
			</dt>
			<dd>
				<label>
					<input
						name="<?php echo esc_attr( $this->get_field_name( 'use_scroll' ) ); ?>"
						type="radio"
						value="hide"
						<?php checked( 'hide' == $jvfrm_home_var->get('use_scroll') );?>>
					<?php esc_html_e( "Enable", 'javohome' );?>
				</label>
				<br>
				<label>
					<input
						name="<?php echo esc_attr( $this->get_field_name( 'use_scroll' ) ); ?>"
						type="radio"
						value=""
						<?php checked( '' == $jvfrm_home_var->get('use_scroll') );?>>
					<?php esc_html_e( "Disabled", 'javohome' );?>
				</label>
			</dd>
		</dl>
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
add_action( 'widgets_init', create_function( '', 'register_widget( "jvfrm_home_Categories_opener_wg" );' ) );