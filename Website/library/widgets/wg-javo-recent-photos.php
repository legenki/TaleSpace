<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

class jvfrm_home_Recent_Photos_widget extends WP_Widget {
	/**
	 * Widget setup
	 */
	function __construct() {
		$widget_ops = array(
			'description' => esc_html__( 'Recent Photos with thumbnails widget.', 'javohome' )
		);
                parent::__construct( 'jvfrm_home_recent_photos', esc_html__('[JAVO] Recent Photos','javohome'), $widget_ops );
	}
	/**
	 * Display widget
	 */
	function widget( $args, $instance ) {
		extract( $args, EXTR_SKIP );
		global $post, $jvfrm_home_tso;

		$title = apply_filters( 'widget_title', $instance['title'] );
		$limit = $instance['limit'];
		$length = (int)( $instance['length'] );
		$thumb = $instance['thumb'];
		$cat = $instance['cat'];
		$post_type = $instance['post_type'];
		echo $before_widget;
		if ( ! empty( $title ) )
			echo $before_title . $title . $after_title;

		if ( false === ( $jvfrm_home_recent_photos = get_transient( 'jvfrm_home_recent_photos_' . $widget_id ) ) ) {
			$args					= array(
				'numberposts'	=> $limit,
				'cat'					=> $cat,
				'post_type'			=> $post_type,
				'post_status'		=> 'publish',
				'post__not_in'		=> get_option( 'sticky_posts' )
			);
		    $jvfrm_home_recent_photos = query_posts( $args );
		    set_transient( 'jvfrm_home_recent_photos_' . $widget_id, $jvfrm_home_recent_photos, 60*60*12 );
		};?>

		<div class="widget_posts_wrap">
			<?php switch($post_type){
			case "post":
			default:
				?>
			<ul class='latest-posts items list-unstyled latest-posts-photo'>
				<?php

				$jvfrm_home_recent_photos_args	= Array(
					'post_status'			=>'publish',
					'post_type'				=> $post_type,
					'posts_per_page'	=> $limit,
					'cat'						=> $cat,
					'post__not_in'			=> get_option( 'sticky_posts' )
				);

				$jvfrm_home_recent_photos			= new WP_Query( $jvfrm_home_recent_photos_args );
				if( $jvfrm_home_recent_photos->have_posts() ){
					while( $jvfrm_home_recent_photos->have_posts() ){
						$jvfrm_home_recent_photos->the_post();
						$jvfrm_home_this_permalink = get_permalink();?>
						<li class="col-xs-4 col-sm-4 col-md-4">
						<?php if( $thumb == true ) : ?>
							<span class='thumb'>
								<a href="<?php echo esc_attr( $jvfrm_home_this_permalink );?>">
									<div class="img-wrap-shadow">
										<?php
										if( has_post_thumbnail() ){
											the_post_thumbnail('jvfrm-home-tiny');
										}else{
											printf('<img src="%s" class="wp-post-image" style="width:80px; height:80px;">', $jvfrm_home_tso->get('no_image', JVFRM_HOME_IMG_DIR.'/no-image.png'));
										};?>
									</div>
								</a>
							</span>
							<?php endif; ?>
						</li>
						<?php
					};		// End While
				};			// End if
				?>
			</ul>
			<?php };?>
		</div>
		<?php
		wp_reset_postdata();
		echo $after_widget;
	}
	/**
	 * Update widget
	 */
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = esc_attr( $new_instance['title'] );
		$instance['limit'] = $new_instance['limit'];
		$instance['length'] = (int)( $new_instance['length'] );
		$instance['thumb'] = $new_instance['thumb'];
		$instance['cat'] = $new_instance['cat'];
		$instance['post_type'] = $new_instance['post_type'];
		delete_transient( 'jvfrm_home_recent_photos_' . $this->id );
		return $instance;
	}
	/**
	 * Widget setting
	 */
	function form( $instance ) {
		/* Set up some default widget settings. */
        $defaults			= array(
            'title'				=> '',
            'limit'				=> 5,
            'length'			=> 10,
            'thumb'			=> true,
            'cat'				=> '',
            'post_type'		=> '',
            'date'				=> true,
        );
		$jvfrm_home_query		= new jvfrm_home_array( $instance );
		$instance = wp_parse_args( (array) $instance, $defaults );
		$title					= esc_attr( $instance['title'] );
		$limit				= $instance['limit'];
		$length = (int)($instance['length']);
		$thumb = $instance['thumb'];
		$cat = $instance['cat'];
		$post_type = $instance['post_type'];
		$post_types		= apply_filters('jvfrm_home_shortcodes_post_type_addition', Array( 'post' ) );
	?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:', 'javohome' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'limit' ) ); ?>"><?php esc_html_e( 'Limit:', 'javohome' ); ?></label>
			<select class="widefat" name="<?php echo $this->get_field_name( 'limit' ); ?>" id="<?php echo $this->get_field_id( 'limit' ); ?>">
				<?php for ( $i=1; $i<=20; $i++ ) { ?>
					<option <?php selected( $limit, $i ) ?> value="<?php echo esc_attr( $i ); ?>"><?php echo $i; ?></option>
				<?php } ?>
			</select>
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'post_type' ) ); ?>"><?php esc_html_e( 'Choose the Post Type: ' , 'javohome' ); ?></label>
			<select class="widefat" id="<?php echo $this->get_field_id( 'post_type' ); ?>" name="<?php echo $this->get_field_name( 'post_type' ); ?>">
				<?php
				if( !empty( $post_types ) ) foreach ( $post_types as $post_type_name )
					printf(
						"<option value=\"%s\" %s>%s</option>"
						, esc_attr( $post_type_name )
						, selected( $post_type_name == $post_type, true, false )
						, esc_html( $post_type_name )
					); ?>
			</select>
		</p>
		<input id="<?php echo $this->get_field_id( 'thumb' ); ?>" name="<?php echo $this->get_field_name( 'thumb' ); ?>" type="hidden" value="1" <?php checked( '1', $thumb ); ?> />
	<?php
	}
}
/**
 * Register widget.
 *
 * @since 1.0
 */
add_action( 'widgets_init', create_function( '', 'register_widget( "jvfrm_home_Recent_Photos_widget" );' ) );