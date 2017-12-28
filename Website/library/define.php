<?php
/*
define default functions.
*/


/* Revolution Slider - remove activation notice */
{
	if( function_exists( 'set_revslider_as_theme' ) )
	{
		add_action( 'init', 'jvfrm_home_active_revolution' );
		function jvfrm_home_active_revolution() {
			 set_revslider_as_theme();
		}
	}
}

/* Visual Composer Plugin */ {
	if( function_exists( 'vc_set_as_theme' ) )
	{
		add_action( 'vc_before_init', 'javo_active_js_composer' );
		function javo_active_js_composer() {
			 vc_set_as_theme();
		}
	}
}

/* Ultimation Plugin */ {
	# Disable new/edit page/post notice
	define('ULTIMATE_NO_EDIT_PAGE_NOTICE', true);
	define('BSF_PRODUCTS_NOTICES', false );

	# Disable plugin listing page notice
	define('ULTIMATE_NO_PLUGIN_PAGE_NOTICE', false );
}

/* WPML */ {
	if( !function_exists( 'jvfrm_home_define_wpml_slug' ) ):
		function jvfrm_home_define_wpml_slug(){
			global $sitepress;
			$jvfrm_home_def_lang = '';
			if( !empty( $sitepress ) && defined('ICL_LANGUAGE_CODE') ){
				$jvfrm_home_def_lang = $sitepress->get_default_language() != ICL_LANGUAGE_CODE ? ICL_LANGUAGE_CODE.'/' : '';
			}
			define('JVFRM_HOME_DEF_LANG', $jvfrm_home_def_lang);
		}
		add_action( 'after_setup_theme', 'jvfrm_home_define_wpml_slug' );
	endif;
}

function jvfrm_home_get_asset_script($fn=NULL, $name="javo", $ver="0.01", $bottom=true){
	wp_register_script($name, get_template_directory_uri().'/assets/js/'.$fn, Array('jquery'), $ver, $bottom);
	wp_enqueue_script($name);
}
function jvfrm_home_get_asset_style($fn=NULL, $name="javo", $ver="0.0.1", $media="all"){
	wp_register_style( $name, get_template_directory_uri().'/assets/css/'.$fn, NULL, $ver, $media );
	wp_enqueue_style($name);
}

add_filter( 'body_class', 'jvfrm_home_container_type_class' );
function jvfrm_home_container_type_class( $classes )
{
	global $post;

	$jvfrm_home_query = new jvfrm_home_array(
		get_post_meta( $post->ID, 'jvfrm_home_hd_post', true )
	);

	$strLayoutType	= $jvfrm_home_query->get( 'layout_style_boxed', jvfrm_home_tso()->get( 'layout_style_boxed' ) );
	$strShadowType	= $jvfrm_home_query->get( 'layout_boxed_shadow', jvfrm_home_tso()->get( 'layout_boxed_shadow' ) );
	$strFooterType	= $jvfrm_home_query->get( 'footer_container_type', jvfrm_home_tso()->get( 'footer_container_type' ) );

	if( 'active' == $strLayoutType )
		$classes[]	= 'boxed';

	elseif( 'active-1400' == $strLayoutType )
		$classes[]	= 'wide-boxed';

	elseif( 'wide-1400' == $strLayoutType )
		$classes[]	= 'wide-wide';

	else
		$classes[]	= 'wide-full';


	if( 'disable' != $strShadowType )
		$classes[]	= 'container-shadow';

	if( 'active' == $strFooterType )
		$classes[]	= 'footer-boxed';
	elseif( 'disable-footer' == $strFooterType )
		$classes[]	= 'disable-footer';
	elseif(''==$strFooterType)
		$classes[]	= 'footer-wide';

	return $classes;
}

//**** login and logout affix position setting
add_filter('body_class', 'jvfrm_home_mbe_body_class');
function jvfrm_home_mbe_body_class($classes){
    if(is_user_logged_in()){
        $classes[] = 'body-logged-in';
    } else{
        $classes[] = 'body-logged-out';
    }
    return $classes;
}

//add_action('wp_head', 'jvfrm_home_mbe_wp_head');
function jvfrm_home_mbe_wp_head(){
    echo '<style>'.PHP_EOL;
    //echo 'body{ padding-top: 48px !important; }'.PHP_EOL;
    // Using custom CSS class name.
    echo 'body.body-logged-in #stick-nav.affix{ top: 28px !important; }'.PHP_EOL;

	// For affix top bar
	echo 'body.body-logged-out #stick-nav.affix{ top: 0px !important; }'.PHP_EOL;

    // Using WordPress default CSS class name.
    echo 'body.logged-in #stick-nav.affix{ top: 28px !important; }'.PHP_EOL;
    echo '</style>'.PHP_EOL;
}


function jvfrm_home_map_class( $strClass='' ) {

	$arrClasses		= apply_filters( 'jvfrm_home_map_class', Array(), get_the_ID() );
	$arrClasses[]	= $strClass;

	printf( " class=\"%s\" ", @implode( ' ', $arrClasses ));
}


/**
* Add title back to images
*/
function pexeto_add_title_to_attachment( $markup, $id ){
	$att = get_post( $id );
	return str_replace('<a ', '<a title="'.$att->post_title.'" ', $markup);
}
add_filter('wp_get_attachment_link', 'pexeto_add_title_to_attachment', 10, 5);

/**
* SelectBox Get children terms
**/
function jvfrm_home_get_selbox_child_term_lists_callback(
	$taxonomy
	, $attribute=Array()
	, $el='ul'
	, $default=Array()
	, $parent=0
	, $depth=0
	, $separator='&nbsp;&nbsp;&nbsp;&nbsp;'
){

	if( !taxonomy_exists( $taxonomy ) ){
		printf( esc_html__( "%s is invalid taxonomy name.", 'javohome' ), $taxonomy );
		return;
	}

	$jvfrm_home_this_args			= Array(
		'parent'			=> $parent
		, 'hide_empty'		=> false
		, 'fields'			=> 'id=>name'
	);

	$jvfrm_home_this_terms		= (Array) get_terms( $taxonomy, $jvfrm_home_this_args );
	$jvfrm_home_this_return		= '';
	$jvfrm_home_this_attribute	= '';

	if( ! sizeof( $jvfrm_home_this_terms ) )
		return;

	if( !isset( $attribute['style'] ) )
		$attribute['style'] = '';

	if( !empty( $attribute ) ){
		foreach( $attribute as $attr => $value){
			$jvfrm_home_this_attribute .= $attr . '="'. $value .'" ';
		}
	}

	$depth++;

	if( is_wp_error( $jvfrm_home_this_terms ) )
		echo $jvfrm_home_this_terms->get_error_message();

	else
		if( !empty( $jvfrm_home_this_terms ) )
			foreach( $jvfrm_home_this_terms as $term_id => $term_name ){
				switch( $el ){
				case 'select':
					$jvfrm_home_this_return	.= sprintf('<option value="%s"%s>%s%s</option>%s'
						, $term_id
						, ( in_Array( $term_id, (Array)$default) ? ' selected':'' )
						, str_repeat( $separator, $depth-1 ).' '
						, $term_name
						, jvfrm_home_get_selbox_child_term_lists_callback($taxonomy, $attribute, $el, $default, $term_id, $depth, $separator)
					);
				break;
				case 'ul':
				default:
					$jvfrm_home_this_return	.= sprintf('<li %svalue="%s" data-filter data-origin-title="%s">%s %s</li>%s'
						, $jvfrm_home_this_attribute
						, $term_id
						, $term_name
						, str_repeat( '-', $depth-1 )
						, $term_name
						, jvfrm_home_get_selbox_child_term_lists_callback($taxonomy, $attribute, $el, $default, $term_id, $depth, $separator)
					);
				}; // End Switch
			};

	return $jvfrm_home_this_return;
};
add_filter('jvfrm_home_get_selbox_child_term_lists', 'jvfrm_home_get_selbox_child_term_lists_callback', 10, 7);

/**
* Element Get children terms
**/
function jvfrm_home_get_el_child_term_lists_callback($taxonomy, $default=null, $parent=0, $depth=0){
	global $wp_query, $jvfrm_home_tso;

	$jvfrm_home_this_args			= Array(
		'parent'			=> $parent
		, 'hide_empty'		=> false
	);
	$jvfrm_home_current_terms		= Array();
	if( !empty( $wp_query->queried_object ) ){
		$jvfrm_home_current_term		= $wp_query->queried_object;
		if( !empty( $jvfrm_home_current_term->term_id ) && !empty( $jvfrm_home_current_term->taxonomy ) )
		{
			$jvfrm_home_current_terms		= (Array)jvfrm_home_get_archive_current_position($jvfrm_home_current_term->term_id, $jvfrm_home_current_term->taxonomy);
		}
	};
	$jvfrm_home_this_terms		= (Array)get_terms($taxonomy, $jvfrm_home_this_args);
	$jvfrm_home_this_return		= '';
	$jvfrm_home_this_attribute	= '';
	if( count( $jvfrm_home_this_terms ) <= 0 ) return false;
	if( !isset( $attribute['style'] ) ){ $attribute['style'] = ''; };

	if( !empty( $attribute ) ){
		foreach( $attribute as $attr => $value){
			$jvfrm_home_this_attribute .= $attr . '="'. $value .'" ';
		}
	};
	$jvfrm_home_this_return_before = sprintf('<ul class="javo-archive-nav-primary %s">'
		, ( in_array($parent, $jvfrm_home_current_terms) ? 'is_current':'')
	);

	$depth++;
	foreach( $jvfrm_home_this_terms as $term ){
		$jvfrm_home_this_return	.= sprintf('<li class="%s %s"><a href="%s" background:"%s">%s</a> %s</li>'
			, ( $depth == 1 ? 'javo-is-top-depth':'' )
			, ( in_array($term->term_id, $jvfrm_home_current_terms) ? ' current' : '')
			, get_term_link($term)
			, ''
			, $term->name
			, jvfrm_home_get_el_child_term_lists_callback($taxonomy, $default, $term->term_id, $depth)
		);
	};
	if( $depth > 1 ){
		$jvfrm_home_this_return = $jvfrm_home_this_return_before.$jvfrm_home_this_return.'</ul>';
	};

	return $jvfrm_home_this_return;
};
add_filter('jvfrm_home_get_el_child_term_lists', 'jvfrm_home_get_el_child_term_lists_callback', 10, 5);

function jvfrm_home_array_extend($arr = Array(), $value = ''){
	$arr[] = $value; return $arr;
}

function jvfrm_home_get_archive_current_position($term_id, $taxonomy){
	$jvfrm_home_this_term				= get_term($term_id, $taxonomy);
	if( is_wp_error( $jvfrm_home_this_term ) ){ return false; };
	$jvfrm_home_this_return			= jvfrm_home_get_archive_current_position($jvfrm_home_this_term->parent, $taxonomy);
	return jvfrm_home_array_extend($jvfrm_home_this_return, $jvfrm_home_this_term->term_id);

}

{
	function jvfrm_home_filter_lazyload( $content ) {
		return preg_replace_callback('/(<\s*img[^>]+)(src\s*=\s*"[^"]+")([^>]+>)/i', 'jvfrm_home_preg_lazyload', $content);
	}
	function jvfrm_home_preg_lazyload( $img_match )
	{

		if( false !== strpos( $img_match[0], 'data-no-lazy' ) )
			return $img_match[0];

		$img_replace = $img_match[1] . 'src="' . JVFRM_HOME_IMG_DIR . '/lazy-load-img.gif" data-original' . substr($img_match[2], 3) . $img_match[3];
		$img_replace = preg_replace('/class\s*=\s*"/i', 'class="lazy ', $img_replace);
		$img_replace .= '<noscript>' . $img_match[0] . '</noscript>';
		return $img_replace;
	}
	function jvfrm_home_replace_for_lazy() {
		if( jvfrm_home_tso()->get( 'lazyload' ) != 'disable' )
			add_filter( 'the_content', 'jvfrm_home_filter_lazyload', 99);
	}
	// add_action( 'jvfrm_home_themes_loaded', 'jvfrm_home_replace_for_lazy' );
}



add_filter('widget_text', 'do_shortcode');

/*
**
** Javo Filter Callback Functions
** ==============================================
*/
class jvfrm_home_filter_function
{
	static $jvfrm_home_filter_args = Array(
		'body_class'							=> Array('current_post_header_callback', 2)
		, 'jvfrm_home_add_item_get_terms_checkbox'	=> Array('add_item_get_terms_checkbox_callback', 3)
		, 'jvfrm_home_day_code_replace'				=> Array('day_code_replace_callback', 3)
		, 'jvfrm_home_rgb'							=> Array('hex_converter_callback', 2)
		, 'jvfrm_home_wpml_link'						=> Array('wpml_transfer_permalink_func', 1)
		, 'jvfrm_home_post_excerpt'					=> Array('post_excerpt_callback', 2)
		, 'get_avatar'							=> Array('user_avatar_callback', 5 )
		, 'jvfrm_home_post_title_header'				=> Array( 'default_post_title_header_func', 2 )
	);

	public function __construct()
	{
		foreach( self::$jvfrm_home_filter_args as $filter => $callback)
		{
			add_filter( $filter, Array( __class__, $callback[0]), 10, $callback[1]);
		}
	}

	public static function user_avatar_callback( $avatar, $id_or_email, $size, $default, $alt )
	{

		$jvfrm_home_current_user		= false;
		$output					= sprintf( "<img src=\"%s\" style=\"width:{$size}px; height:{$size}px;\">", jvfrm_home_tso()->get( 'no_image' )!='' ? jvfrm_home_tso()->get('no_image') : JVFRM_HOME_IMG_DIR.'/blank-image.png' );

		if( is_numeric( $id_or_email ) ) {
			$jvfrm_home_current_user	= get_user_by( 'id', (int) $id_or_email );

		} elseif( is_object( $id_or_email ) ) {
			if( !empty( $id_or_email->user_id ) )
				$jvfrm_home_current_user	= get_user_by( 'id', (int) $id_or_email->user_id );

		} else {
			$jvfrm_home_current_user		= get_user_by( 'email', $id_or_email );
		}

		if( $jvfrm_home_current_user && is_object( $jvfrm_home_current_user ) )
			if( (boolean) ( $jvfrm_home_avatar_id = get_user_meta( $jvfrm_home_current_user->ID, 'avatar', true ) ) ) {
				$intBlogID				= intVal( get_user_meta( $jvfrm_home_current_user->ID, 'avatar_on_blog', true ) );
				if( function_exists( 'switch_to_blog' ) && intVal( $intBlogID ) > 0 )
					switch_to_blog( $intBlogID );

				if( (boolean) ( $jvfrm_home_avatar = wp_get_attachment_image( $jvfrm_home_avatar_id, Array( $size, $size ) ) ) )
					$output = $jvfrm_home_avatar;

				if( function_exists( 'restore_current_blog' ) )
					restore_current_blog();
			}

		return $output;
	}

	public static function default_post_title_header_func( $post_title=null, $post=null )
	{
		global $wp_query;

		$strOutput		= false;

		if( is_null( $post ) )
			return $strOutput;

		if( $post->post_type == 'post' ) {
			$strOutput	= join( "\n",
				Array(
					"<div class=\"text-center well\">",
					sprintf( "<h1 id=\"javo-post-title-header\">%s</h1>", esc_html( $post_title ) ),
					"</div>",
				)
			);
		}else{
			$strOutput	= join( "\n",
				Array(
					"<div class=\"container\">",
					sprintf( "<h3 class=\"custom-header text-center\">%s</h3>", esc_html( $post_title ) ),
					"</div>",
				)
			);
		}
		return $strOutput;
	}

	public static function post_excerpt_callback( $post_content, $length = -1 )
	{
		$jvfrm_home_return = strip_tags( $post_content );
		$jvfrm_home_return = strip_shortcodes( $jvfrm_home_return );
		$jvfrm_home_return = esc_attr( $jvfrm_home_return );
		if( $length > 0 )
		{
			$jvfrm_home_return = wp_trim_words( $jvfrm_home_return, (int)$length );
			$jvfrm_home_return = strip_shortcodes($jvfrm_home_return);
		}

		return $jvfrm_home_return;
	}

	public static function wpml_transfer_permalink_func( $origin_post_id )
	{
		$result_id = $origin_post_id;

		if( function_exists( 'icl_object_id' ) && (int)$origin_post_id > 0 )
		{
			$post_type	=  get_post_type( $origin_post_id );
			$result_id	= icl_object_id( $origin_post_id, $post_type );
		}
		return get_permalink( $result_id );
	}

	public static function hex_converter_callback( $hex )
	{
		$jvfrm_home_rgb = Array();
		if( strlen( $hex ) == 3 )
		{
			$jvfrm_home_rgb['r'] = hexdec( substr( $hex, 0, 1 ) . substr( $hex, 0, 1 ) );
			$jvfrm_home_rgb['g'] = hexdec( substr( $hex, 1, 1 ) . substr( $hex, 1, 1 ) );
			$jvfrm_home_rgb['b'] = hexdec( substr( $hex, 2, 1 ) . substr( $hex, 2, 1 ) );
		} else {
			$jvfrm_home_rgb['r'] = hexdec( substr( $hex, 0, 2 ) );
			$jvfrm_home_rgb['g'] = hexdec( substr( $hex, 2, 2 ) );
			$jvfrm_home_rgb['b'] = hexdec( substr( $hex, 4, 2 ) );
		}

		return $jvfrm_home_rgb;
	}

	static function day_code_replace_callback( $date_code, $before="", $uppercase = false )
	{
		$output_date = '';
		switch( $date_code )
		{
			case 'y': $output_date = "year"; break;
			case 'm': $output_date = "month"; break;
			case 'd': $output_date = "day"; break;
			case 'w': $output_date = "week"; break;
			case 'h': $output_date = "hour"; break;
			case 'i': $output_date = "minute"; break;
			case 's': $output_date = "secound"; break;
		}
		return sprintf('%s %s'
			, ($output_date !=  ''? $before : '')
			, ( $uppercase ? strtoupper( $output_date ) : $output_date )
		);
	}

	static function current_post_header_callback($classes)
	{
		global $post;
		if( empty( $post ) ){ return; };
		$header_type	= get_post_meta($post->ID, "jvfrm_home_header_type", true);
		$jvfrm_home_fancy			= maybe_unserialize( get_post_meta( $post->ID, "jvfrm_home_fancy_options", true ) );
		$classes[]			= 'javo-header-type-'.$header_type;
		if( !empty( $jvfrm_home_fancy['bg_image'] ) ){
			$classes[]		= 'header-image-exists';
		};
		return $classes;
	}

	public static function add_item_get_terms_checkbox_callback(
		$taxonomy
		, $post_id = 0
		, $input_name=""
		, $parent = 0
	){
		$jvfrm_home_has_terms = wp_get_post_terms( $post_id, $taxonomy , Array( 'fields' => 'ids') );
		$jvfrm_home_all_terms = get_terms( $taxonomy, Array( 'hide_empty' => false, 'parent' => $parent ));


		if( is_wp_error( $jvfrm_home_has_terms ) || is_wp_error( $jvfrm_home_all_terms ) )
		{
			return false;
		}

		ob_start();

		echo "<ul class=''>";

		foreach( $jvfrm_home_all_terms as $term )
		{
			printf( "<li><label><input type='checkbox' name='{$input_name}' value='{$term->term_id}' %s>&nbsp;{$term->name}</label>%s</li>"
				, checked( in_Array( $term->term_id, $jvfrm_home_has_terms), true, false)
				, self::add_item_get_terms_checkbox_callback( $taxonomy, $post_id, $input_name, $term->term_id )
			);
		}
		echo "</ul>";


		return ob_get_clean();


	}
}
new jvfrm_home_filter_function();


/*
**
** Javo Action Callback Functions
** ==============================================
*/
class jvfrm_home_action_function
{
	static $jvfrm_home_action_args = Array(
		'switch_theme_callback'						=> Array( 'switch_theme', 2 )
		, 'current_user_upload_role_callback'	=> Array( 'admin_init', 2 )
		, 'user_media_upload'							=> Array( 'pre_get_posts', 2 )
		//, 'tags_add_parameter_callback'			=> Array( 'pre_get_posts', 2 )
		, 'load_attach_image_callback'				=> Array( 'jvfrm_home_load_attach_image', 3 )
	);

	public function __construct()
	{
		foreach( self::$jvfrm_home_action_args as $callback => $action )
		{
			add_action( $action[0], Array( __class__, $callback), 10, $action[1]);
		}
	}

	public static function archive_add_parameter_callback( $query )
	{
		if( $query->is_main_query() && $query->is_date )
		{
			$query->set('post_type', Array( 'post', 'property') );
		}
	}

	public static function tags_add_parameter_callback( $query )
	{
		if(
			$query->is_main_query() &&
			$query->is_tag == true
		){
			$query->set( 'post_type', apply_filters( 'jvfrm_home_single_post_types_array', Array( 'post' ) ) );
		}
		return $query;
	}

	public static function current_user_upload_role_callback()
	{
		$jvfrm_home_get_cur_role = wp_get_current_user()->add_cap('upload_files');
	}

	public static function user_media_upload( $query )
	{
		global $jvfrm_home_tso, $post, $wp_query;

		if( $query->is_main_query() ) return;
		if( current_user_can('administrator') ){ return; }

		if( $query->get('post_type') == 'attachment'){
			if( isset( $_REQUEST['action'] ) && $_REQUEST['action'] != 'query-attachments' ) return;
			$query->set( 'author', get_current_user_ID() );
		}
	}

	static function switch_theme_callback()
	{
		delete_option( 'jvfrm_home_notice_dismiss' );
	}

	public static function load_attach_image_callback( $attach_id, $size='jvfrm-home-avatar', $meta_key = 0 )
	{
		global $jvfrm_home_tso;

		$__return = $jvfrm_home_tso->get( 'no_image', JVFRM_HOME_IMG_DIR.'/no-image.png' );

		if( (int) $attach_id > 0 ) {
			if( false !== (boolean)( $__avatar = wp_get_attachment_image_src( $attach_id, $size ) ) ) {
				if( '' !== $__avatar[ $meta_key ] )
					$__return = $__avatar[ $meta_key ];
			}
		}

		return $__return;
	}

}
new jvfrm_home_action_function();