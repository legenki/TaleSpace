<?php
/**
*** Adds jvfrm_home_Contact_Us widget.
**/
class jvfrm_home_Contact_Us extends WP_Widget {
	/**
	 * Register widget with WordPress.
	 */
	function __construct() {
		parent::__construct(
			'jvfrm_home_Contact_Us', // Base ID
			esc_html__('[JAVO] Contact Us', 'javohome'), // Name
			array( 'description' => esc_html__( 'Javo contact information display widget.', 'javohome' ), ) // Args
		);
	}
	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget( $args, $instance ) {
		global $jvfrm_home_tso;
		$title = apply_filters( 'widget_title', $instance['title'] );
		echo $args['before_widget'];
		if ( ! empty( $title ) ){
			echo $args['before_title'] . $title . $args['after_title'];
		};
		printf('<p class="contact_us_detail"><a href="%s"><img src="%s" data-at2x="%s"></a></p>'
			, get_site_url()
			, ($jvfrm_home_tso->get( 'bottom_logo_url' ) != "" ?  $jvfrm_home_tso->get('bottom_logo_url') : JVFRM_HOME_IMG_DIR."/jv-logo1.png")
			, ($jvfrm_home_tso->get( 'bottom_retina_logo_url' ) != "" ?  $jvfrm_home_tso->get('bottom_retina_logo_url') : "")
		);
		echo '<ul>';
			if($jvfrm_home_tso->get( 'address' )) printf('<li><i class="fa fa-home"></i> %s</li>', $jvfrm_home_tso->get("address"));
			if($jvfrm_home_tso->get( 'phone' )) printf('<li><i class="fa fa-phone-square"></i> %s</li>', $jvfrm_home_tso->get("phone"));
			if($jvfrm_home_tso->get( 'mobile' )) printf('<li><i class="fa fa-mobile" style="font-size:20px; margin-left:1px;"></i> %s</li>', $jvfrm_home_tso->get("mobile"));
			if($jvfrm_home_tso->get( 'fax' )) printf('<li><i class="fa fa-fax" style="margin-right:3px;"></i> %s</li>', $jvfrm_home_tso->get("fax"));
			if($jvfrm_home_tso->get( 'email' )) printf('<li><i class="fa fa-envelope"></i> <a href="mailto:%s">%s</a></li>', $jvfrm_home_tso->get("email"), $jvfrm_home_tso->get("email"));
			if($jvfrm_home_tso->get( 'working_hours' )) printf('<li><i class="fa fa-clock-o"></i> %s</li>', $jvfrm_home_tso->get("working_hours"));
			if($jvfrm_home_tso->get( 'additional_info' )) printf('<li><i class="fa fa-plus-square"></i> %s</li>', $jvfrm_home_tso->get("additional_info"));
			if($jvfrm_home_tso->get( 'website' )) printf('<li><i class="fa fa-exclamation-circle"></i> <a href="%s">%s</a></li>', $jvfrm_home_tso->get("website"), $jvfrm_home_tso->get("website"));
		echo '</ul>';
		echo '<div class="foot-sns-icons">';
			$this->add_sns( 'facebook' );
			$this->add_sns( 'twitter' );
			$this->add_sns( 'forrst' );
			$this->add_sns( 'google' );
			$this->add_sns( 'pinterest' );
			$this->add_sns( 'dribbble' );
			$this->add_sns( 'instagram' );
		echo '</div>';
		echo $args['after_widget'];
	}
	public function add_sns( $social_name )
	{
		global $jvfrm_home_tso;

		if( '' != $jvfrm_home_tso->get( $social_name ) ){
			printf(
				"<a href=\"%s\" target=\"_blank\">
					<i class=\"jv-contact-widget-icon {$social_name}\"></i>
				</a>",
				esc_url( $jvfrm_home_tso->get( $social_name ) )
			);
		};
	}
	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {
		if ( isset( $instance[ 'title' ] ) ) {
			$title = $instance[ 'title' ];
		}
		else {
			$title = esc_html__( 'Contact info', 'javohome' );
		}
		?>
		<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php esc_html_e( 'Title:', 'javohome' ); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>
		<?php
	}
	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		return $instance;
	}
} // class jvfrm_home_Contact_Us

// register jvfrm_home_Contact_Us widget
add_action( 'widgets_init', create_function( '', 'register_widget( "jvfrm_home_Contact_Us" );' ) );