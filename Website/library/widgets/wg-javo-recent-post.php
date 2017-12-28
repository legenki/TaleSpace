<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

class jvfrm_home_Recent_Posts_widget extends WP_Widget
{
	public function __construct() {
		$widget_ops = array(
			'description' => esc_html__( 'Recent posts with thumbnails widget.', 'javohome' )
		);
		parent::__construct( 'jvfrm_home_recent_posts', esc_html__('[JAVO] Recent posts','javohome'), $widget_ops );
	}

	public function widget( $args, $instance ) {

		global $jvfrm_home_tso;

		extract( $args, EXTR_SKIP );

		$jvfrm_home_query								= new jvfrm_home_array( $instance );
		$jvfrm_home_this_post_type					= $jvfrm_home_query->get( 'post_type', 'post' );
		$jvfrm_home_this_post_excerpt_limit		= intVal( $jvfrm_home_query->get( 'excerpt_length', 20 ) );
		$jvfrm_home_this_widget_title				= apply_filters( 'widget_title', $jvfrm_home_query->get( 'title', null) );

		$jvfrm_home_this_posts_args	= Array(
			'post_type'			=> $jvfrm_home_this_post_type,
			'posts_per_page'	=> intVal( $jvfrm_home_query->get( 'post_count', 3 ) ),
			'post_status'			=> 'publish',
			'post__not_in'		=> get_option( 'sticky_posts' ),
			'meta_query'			=> Array()
		);

		// Exclude Sticky Posts
		if( 'post' === $jvfrm_home_this_post_type )
			$jvfrm_home_this_posts_args['post__not_in'] = get_option( 'sticky_posts' );

		if( jvfrm_home_core()->slug == $jvfrm_home_this_post_type && $jvfrm_home_query->get( 'featured_item' ) == 'use' )
			$jvfrm_home_this_posts_args[ 'meta_query' ][] = Array(
				'key' => '_featured_item',
				'value' => '1'
			);

		$jvfrm_home_this_posts						= new WP_Query( $jvfrm_home_this_posts_args );

		ob_start();
		echo $before_widget;
		echo $before_title.$jvfrm_home_this_widget_title.$after_title;
		?>
		<div class="widget_posts_wrap type-<?php echo sanitize_html_class( $jvfrm_home_this_post_type ); ?>">
			<?php
			if( $jvfrm_home_this_posts->have_posts() )
			{
				while( $jvfrm_home_this_posts->have_posts() )
				{
					$jvfrm_home_this_posts->the_post();
					$jvfrm_home_this_permalink	= get_permalink();
					?>
					<div class="latest-posts posts row">
						<div class="col-md-12">
							<span class='thumb'>
								<a href="<?php echo esc_url( $jvfrm_home_this_permalink ); ?>">
									<?php
									if( has_post_thumbnail() )
									{
										$thumbnail_id = get_post_thumbnail_id();
										$thumbnail_url = wp_get_attachment_image_src($thumbnail_id, 'jvfrm-home-box-v');
										echo '<div class="jv-recent-posts-thumbnail" style="background-image:url('.$thumbnail_url[0].');"></div>';
									}
									else
									{
										printf('<img src="%s" width="100" height="52" class="wp-post-image" style="width:100px; height:52px;" alt="no image">', $jvfrm_home_tso->get('no_image')!='' ?  $jvfrm_home_tso->get('no_image') : JVFRM_HOME_IMG_DIR.'/blank-image.png');
									} ?>
								</a>
							</span>
							<?php
							printf('<h3><a href="%s">%s</a></h3><a href="%s"><div class="jv-post-des">%s</div></a>'
								, $jvfrm_home_this_permalink
								, wp_trim_words( get_the_title(), 20)
								, $jvfrm_home_this_permalink
								, $this->getContents( get_the_excerpt(), $jvfrm_home_this_post_excerpt_limit, get_post(), $instance )
							); ?>
						</div><!-- /.col-md-12 -->
					</div><!-- /.row -->
					<?php
				}
			}else{
				esc_html_e('Not Found Posts.', 'javohome');
			} ?>
		</div><!-- /.widget_posts_wrap -->
		<?php
		 wp_reset_postdata();
		echo $after_widget;
		ob_end_flush();
	}

	public function getContents( $strExcerpt='', $intLength=20, $post=false, $instance=null ){
		$strTrimExcerpt = wp_trim_words( strip_tags( $strExcerpt ), $intLength );
		$strExcerpt = apply_filters( 'jvfrm_home_recent_posts_widget_excerpt', $strTrimExcerpt, $intLength=20, $post, $instance );
		return $strExcerpt;
	}

	function form( $instance )
	{
		$jvfrm_home_query		= new jvfrm_home_array( $instance );
		$post_types		= apply_filters('jvfrm_home_shortcodes_post_type_addition', Array( 'post' ) );

		ob_start();

		printf('<p><label for="%s">%s :</label><input type="text" class="widefat" id="%s" name="%s" value="%s"></p>'
			, esc_attr( $this->get_field_id( 'title' ) )
			, esc_html__('Title', 'javohome')
			, esc_attr( $this->get_field_id( 'title' ) )
			, esc_attr( $this->get_field_name( 'title' ) )
			, $jvfrm_home_query->get('title')
		);

		printf('<p><label for="%s">%s :</label><input type="text" class="widefat" id="%s" name="%s" value="%s"></p>'
			, esc_attr( $this->get_field_id( 'excerpt_length' ) )
			, esc_html__('Excerpt Length', 'javohome')
			, esc_attr( $this->get_field_id( 'excerpt_length' ) )
			, esc_attr( $this->get_field_name( 'excerpt_length' ) )
			, $jvfrm_home_query->get('excerpt_length', 20)
		);
		?>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'post_count' ) ); ?>"><?php esc_html_e( 'Limit:', 'javohome' ); ?></label>
			<select class="widefat" name="<?php echo $this->get_field_name( 'post_count' ); ?>" id="<?php echo $this->get_field_id( 'post_count' ); ?>">
				<?php for ( $i=1; $i<=20; $i++ ) { ?>
					<option <?php selected( (int)$jvfrm_home_query->get('post_count', 3) , $i ) ?> value="<?php echo $i; ?>"><?php echo $i; ?></option>
				<?php } ?>
			</select>
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'post_type' ) ); ?>"><?php esc_html_e( 'Choose the Post Type: ' , 'javohome' ); ?></label>
			<select class="widefat" id="<?php echo $this->get_field_id( 'post_type' ); ?>" name="<?php echo $this->get_field_name( 'post_type' ); ?>">
				<?php
				if( !empty( $post_types ) ) foreach ( $post_types as $post_type )
					printf(
						"<option value=\"%s\" %s>%s</option>"
						, esc_attr( $post_type )
						, selected( $jvfrm_home_query->get( 'post_type', 'post' ) == $post_type, true, false )
						, esc_html( $post_type )
					); ?>
			</select>
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'featured_item' ) ); ?>">
				<input type="checkbox" id="<?php echo $this->get_field_id( 'featured_item' ); ?>" name="<?php echo $this->get_field_name( 'featured_item' ); ?>" value="use" <?php checked( 'use' == $jvfrm_home_query->get('featured_item' ) ); ?>>
				<?php esc_html_e( 'Show only featured items: ' , 'javohome' ); ?>
			</label>
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'describe_type' ) ); ?>"><?php esc_html_e( 'Description Type: ' , 'javohome' ); ?></label>
			<select class="widefat" id="<?php echo $this->get_field_id( 'describe_type' ); ?>" name="<?php echo $this->get_field_name( 'describe_type' ); ?>">
				<?php
				$arrDescribeType = apply_filters( 'jvfrm_home_recent_posts_widget_describe_type_options', Array( '' => esc_html__( 'Post Excerpt', 'javohome' ) ) );
				if( ! empty( $arrDescribeType ) ) : foreach( $arrDescribeType as $strOption => $strLabel ){
					printf(
						"<option value=\"%s\" %s>%s</option>",
						esc_attr( $strOption ),
						selected( $jvfrm_home_query->get( 'describe_type', '' ) == $strOption, true, false ),
						esc_html( $strLabel )
					);
				} endif; ?>
			</select>
		</p>
		<?php
		ob_end_flush();
	}
}
/**
* Register widget.

* @since 1.0
*/
add_action( 'widgets_init', create_function( '', 'register_widget( "jvfrm_home_Recent_Posts_widget" );' ) );