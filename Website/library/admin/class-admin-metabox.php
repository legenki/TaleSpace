<?php
class jvfrm_home_post_meta_func
{
	private $path;
	private $template_part;
	public static $instance;

	public function __construct()
	{
		self::$instance				= &$this;
		$this->path					= JVFRM_HOME_ADM_DIR;
		$this->template_part	=$this->path . '/templates/';
		add_action('add_meta_boxes'		, Array( __CLASS__, 'post_meta_box_init'), 30);
		add_action('save_post'			, Array( __CLASS__, 'post_meta_box_save'));
	}

	public static function post_meta_box_init()
	{
		$jvfrm_home_meta_boxes = Array(
			// Post Meta ID.							MetaBox Callback				Post Type		Position	Level		Description
			// ===============================================================
			'jvfrm_home_postFormat_link'			=> Array( 'postFormat_link_func'			, 'post'		, 'normal'	, 'high' , esc_html__("Link Format Options", 'javohome') )
			, 'jvfrm_home_postFormat_quote'		=> Array( 'postFormat_quote_func'		, 'post'		, 'normal'	, 'high' , esc_html__("Quote Format Options", 'javohome') )
			, 'jvfrm_home_postFormat_video'		=> Array( 'postFormat_video_func'		, 'post'		, 'normal'	, 'high' , esc_html__("Video Format Options", 'javohome') )
			, 'jvfrm_home_postFormat_audio'		=> Array( 'postFormat_audio_func'		, 'post'		, 'normal'	, 'high' , esc_html__("Audio Format Options", 'javohome') )
		);

		$jvfrm_home_meta_boxes_post_and_page = Array(
			// Post Meta ID.							MetaBox Callback						Position	Level		Description
			// ================================================================
			'jvfrm_home_page_settings'	=> Array( 'jvfrm_home_page_settings_box'	, null , 'normal'		, 'high', esc_html__( "Page Settings", 'javohome') )
		);

		foreach( $jvfrm_home_meta_boxes as $boxID => $attribute ) {
			add_meta_box( $boxID, $attribute[4], Array( __CLASS__, $attribute[0] ), $attribute[1], $attribute[2], $attribute[3]);
		}

		foreach( Array( 'post', 'page', 'portfolio' ) as $post_type ) {
			foreach( $jvfrm_home_meta_boxes_post_and_page as $boxID => $attribute ) {
				add_meta_box( $boxID, $attribute[4], Array( __CLASS__, $attribute[0] ), $post_type, $attribute[2], $attribute[3]);
			}
		}
	}

	public static function postFormat_link_func( $post ) {
		self::postFormat_field(
			Array(
				'link_title'	=>
					Array(
						'element'	=> 'input'
						, 'type'	=> 'text'
						, 'label'	=> esc_html__( "Link", 'javohome' )
					)
			)
		);
	}

	public static function postFormat_quote_func( $post ) {
		self::postFormat_field(
			Array(
				'quote_format'	=>
					Array(
						'element'	=> 'input'
						, 'type'	=> 'text'
						, 'label'	=> esc_html__( "Quote", 'javohome' )
					)
			)
		);
	}

	public static function postFormat_video_func( $post ) {
		self::postFormat_field(
			Array(
				'video_format_choose' =>
					Array(
						'element'	=> 'select'
						, 'label'	=> esc_html__( "Choose Video Type", 'javohome' )
						, 'option'	=> Array(
							esc_html__( "Select Portal", 'javohome' )	=> ''
							, esc_html__( "Youtube", 'javohome' )		=> 'youtube'
							, esc_html__( "Vimeo", 'javohome' )			=> 'vimeo'
						)
					)
				, 'video_format_link'	=>
					Array(
						'element'	=> 'input'
						, 'type'	=> 'text'
						, 'label'	=> esc_html__( "Video ID", 'javohome' )
					)
			)
		);
	}

	public static function postFormat_audio_func( $post ) {
		self::postFormat_field(
			Array(
				'audio_link'		=>
					Array(
						'element'	=> 'input'
						, 'type'	=> 'text'
						, 'label'	=> esc_html__( "Audio Link", 'javohome' )
					)
			)
		);
	}

	public static function postFormat_field( $fields ) {

		global $post;

		if( ! empty( $fields ) ) : foreach( $fields as $name => $attr ) {

			echo "<div>";
					printf( "<label>%s</label>", $attr[ 'label' ] );

				$this_value		= get_post_meta( $post->ID, $name, true );

				switch( $attr[ 'element' ] ) {

					case 'input' :
						printf( "<input type=\"%s\" name=\"jvfrm_home_fp[%s]\" value=\"%s\">", $attr[ 'type' ], $name, $this_value );
					break;

					case 'select' :
						printf( "<select name=\"jvfrm_home_fp[%s]\">", $name );
							if( !empty( $attr[ 'option' ] ) ) : foreach( $attr[ 'option' ] as $optLabel => $optValue ) {
								printf( "<option value=\"%s\" %s>%s</option>", $optValue, selected( $this_value == $optValue ), $optLabel );
							} endif;
						echo "</select>";
					break;
				}
			echo "</div>";

		} endif;

	}

	public static function post_meta_box_save($post_id)
	{

		if(
			( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) ||
			! is_admin()
		) return;

		/*
		 *		Variables Initialize
		 *
		 *======================================================================================*
		 */
			$jvfrm_home_query				= new jvfrm_home_array($_POST);
			$propertylist_query	= new jvfrm_home_array( $jvfrm_home_query->get('jvfrm_home_il', Array()) );


		/*
		 *		Page Template Layout Setup
		 *
		 *======================================================================================*
		 */
			// Result Save
			{
				if( $value = $jvfrm_home_query->get( 'jvfrm_home_opt_header', false ) )
					update_post_meta( $post_id, 'jvfrm_home_header_type', $value );

				if( $value = $jvfrm_home_query->get( 'jvfrm_home_opt_fancy', false ) )
					update_post_meta( $post_id, 'jvfrm_home_header_fancy_type', $value );

				if( $value = $jvfrm_home_query->get( 'jvfrm_home_opt_sidebar', false ) )
					update_post_meta( $post_id, 'jvfrm_home_sidebar_type', $value );

				if( $value = $jvfrm_home_query->get( 'jvfrm_home_opt_slider', false ) )
					update_post_meta( $post_id, 'jvfrm_home_slider_type', $value );
			}

			if( false !== ( $tmp = $propertylist_query->get('type', false) ) ){
				update_post_meta($post_id, "jvfrm_home_item_listing_type", $tmp);
			}

			if( false !== ( $tmp = $propertylist_query->get('list_position', false) ) ){
				update_post_meta($post_id, "jvfrm_home_item_listing_position", $tmp);
			}

			if( false !== ( $tmp = $propertylist_query->get('content_position', false) ) ){
				update_post_meta($post_id, "jvfrm_home_item_listing_content_position", $tmp);
			}

			if( false !== ( $tmp = $jvfrm_home_query->get('jvfrm_home_hd', false) ) ){
				update_post_meta($post_id, "jvfrm_home_hd_post", $tmp );
			}

			if( false !== ( $tmp = $jvfrm_home_query->get('jvfrm_home_map_opts', false) ) ){
				update_post_meta($post_id, "jvfrm_home_map_page_opt", $tmp );
			}

			// Slide AutoPlay
			if( false !== ( $tmp = $jvfrm_home_query->get('jvfrm_home_detail_slide_autoplay', false) ) ){
				update_post_meta($post_id, "jvfrm_home_detail_slide_autoplay", $tmp );
			}

			// Fancy options
			if( $jvfrm_home_query->get('jvfrm_home_fancy', null) != null){
				update_post_meta( $post_id, "jvfrm_home_fancy_options", $jvfrm_home_query->get( 'jvfrm_home_fancy', null ) );
			}

			if( $jvfrm_home_query->get('jvfrm_home_slide', null) != null){
				update_post_meta( $post_id, "jvfrm_home_slider_options", $jvfrm_home_query->get('jvfrm_home_slide', null ) );
			}

			$jvfrm_home_controller_setup = !empty($_POST['jvfrm_home_post_control']) ? $_POST['jvfrm_home_post_control'] : '';
			update_post_meta( $post_id, "jvfrm_home_control_options", $jvfrm_home_controller_setup );

			// Post format
			$postFormat_options	= $jvfrm_home_query->get( 'jvfrm_home_fp', Array() );
			if( !empty( $postFormat_options ) ) : foreach( $postFormat_options as $key => $value ) {
				update_post_meta( $post_id, $key, $value );
			} endif;

		/*
		 *		Custom Post Types Meta Save
		 *
		 *======================================================================================*
		 */
		switch( get_post_type($post_id) ){
		case "property":
			$property_query = new jvfrm_home_array( $jvfrm_home_query->get('jvfrm_home_item_attribute', Array()) );

			if( $property_query->get( 'featured', null) != null ){
				update_post_meta( $post_id, "jvfrm_home_this_featured_item", $property_query->get( 'featured', '' ) );
			};

			// item meta
			if( isset( $_POST[ 'jvfrm_home_pt' ] ) ){

				$ppt_meta				= $_POST['jvfrm_home_pt'];

				$jvfrm_home_pt_query			= new jvfrm_home_array($ppt_meta);
				$ppt_images				= !empty($_POST['jvfrm_home_pt_detail'])? $_POST['jvfrm_home_pt_detail'] : null;

				// is Assign
				if( $jvfrm_home_query->get('item_author') == 'other' ){

					remove_action( 'save_post', Array( __CLASS__, 'post_meta_box_save' ) );

					$post_id				= wp_update_post(Array(
						'ID'					=> $post_id
						, 'post_author'	=> $jvfrm_home_query->get('item_author_id')
					));

					add_action( 'save_post', Array( __CLASS__, 'post_meta_box_save' ) );
				};

				if( false !== (boolean)( $content = $jvfrm_home_query->get( 'jvfrm_home_pt_custom_tab', false ) ) ) {
					update_post_meta( $post_id, 'property_custom_inner', $content );
				}

				// Default Meta
				if( false !== (boolean)( $meta = $jvfrm_home_pt_query->get( 'meta', false ) ) )
				{
					foreach( $meta as $key => $value ) {
						update_post_meta( $post_id, $key, $value );
					}
				}

				// Default Meta
				if( false !== (boolean)( $meta = $jvfrm_home_pt_query->get( 'map', false ) ) )
				{
					foreach( $meta as $key => $value )
					{
						update_post_meta( $post_id, "property_{$key}", $value );
					}
				}

				update_post_meta( $post_id, "detail_images", @serialize( $ppt_images ) );
				update_post_meta( $post_id, 'header_custom_frame', $jvfrm_home_pt_query->get( 'header_frame', null ) );

				do_action( 'jvfrm_home_admin_item_metabox_save', $post_id, $jvfrm_home_pt_query );
			}
		break;
		}		// End Switch
	}

	public static function jvfrm_home_page_settings_box( $post )
	{
		add_action( 'admin_footer', Array( __CLASS__, 'meta_scripts_callback'));
		$strFileName		= self::$instance->template_part . '/page-options.php';
		if( file_exists( $strFileName ) )
			require_once $strFileName;
	}

	public static function meta_scripts_callback()
	{
		global $post;

		echo join( "\n", Array(
			"\n<script type=\"text/javascript\">",
			"\tvar jvfrm_home_metabox_variable=" . json_encode(
				Array(
					'ajaxurl'				=> esc_url( admin_url( 'admin-ajax.php' ) ),
					'strAddressFindFailed'	=> esc_html__( "Sorry, find address failed", 'javohome' ),
					'strHeaderFancy'		=> get_post_meta($post->ID, "jvfrm_home_header_fancy_type", true),
					'strHeaderSlider'		=> get_post_meta($post->ID, "jvfrm_home_slider_type", true),
				)
			) . ';',
			'jQuery(function($){ $(document).trigger( "javo:metabox_after" ); });',
			"</script>\n",
		) );
	}
}

new jvfrm_home_post_meta_func();