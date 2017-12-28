<?php

if( ! function_exists( 'jvfrm_home_theme_default_support' ) ) :
	add_action( 'after_setup_theme', 'jvfrm_home_theme_default_support', 8);
	function jvfrm_home_theme_default_support()
	{
		global
			$jvfrm_home_tso
			, $wp_taxonomies;

		add_theme_support( 'title-tag' );
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'woocommerce' );
		if( JVFRM_HOME_CUSTOM_HEADER )
			add_theme_support( 'custom-header', array( 'header-text'=> false ) );
		add_theme_support( 'custom-background', array(
			'default-color'					=> '',
			'default-image'				=> '',
			'default-repeat'				=> '',
			'default-position-x'			=> '',
			'wp-head-callback'			=> '_custom_background_cb',
			'admin-head-callback'		=> '',
			'admin-preview-callback'	=> ''
		) );

		// Image size define
		add_image_size( 'jvfrm-home-tiny'				, 80, 80, true );     	// for img on widget
		add_image_size( 'jvfrm-home-avatar'			, 250, 250, true);  		// User Picture size
		add_image_size( "jvfrm-home-box"				, 288, 266, true );   	// for blog
		add_image_size( 'jvfrm-home-map-thumbnail'	, 150, 165, true); 			// Map thumbnail size
		add_image_size( 'jvfrm-home-box-v'			, 400, 219, true );  		// for long width blog
		add_image_size( 'jvfrm-home-large'			, 500, 400, true );  		// extra large
		add_image_size( 'jvfrm-medium'			, 650, 500, true );  			// the bigest blog
		add_image_size( 'jvfrm-home-huge'				, 720, 367, true );  	// the bigest blog
		add_image_size( 'jvfrm-home-item-detail'		, 823, 420, true );  	// type2 detail page
		set_post_thumbnail_size( 132, 133, true );

		$GLOBALS[ 'jvfrm_home_allow_tags' ] = jvfrm_home_allow_tags();
		$GLOBALS[ 'jvfrm_home_single_post_type' ] = jvfrm_home_single_post_type();
	}
endif;

if( !function_exists( 'jvfrm_home_allow_tags' ) ) : function jvfrm_home_allow_tags(){
	return Array(
		'a' => Array(
			'href' => Array(),
			'title' => Array(),
		),
		'b' => Array(),
		'p' => Array(),
		'em' => Array(),
		'strong' => Array(),
	);
} endif;

if( !function_exists( 'jvfrm_home_single_post_type' ) ) : function jvfrm_home_single_post_type(){
	return 1;
} endif;

	/**
	 * Register Navigation Menus
	 */

	if ( ! function_exists( 'jvfrm_home_nav_menus' ) ) :
		// Register wp_nav_menus
		function jvfrm_home_nav_menus()
		{
			register_nav_menus( array(
				'primary' => esc_html__( 'Primary', 'javohome'),
				'footer_menu' => esc_html__( 'Footer Menu', 'javohome')
				//'canvas_menu' => esc_html__('Canvas Menu','javohome'),
			) );
		}
		add_action( 'init', 'jvfrm_home_nav_menus' );
	endif;

	add_filter( 'login_redirect', 'jvfrm_home_login_redirect_callback', 10, 3);

	function jvfrm_home_login_redirect_callback( $orgin, $req, $user ){

		if( empty( $user ) || is_wp_error( $user ) ){ return; }
		$jvfrm_home_redirect = esc_url( home_url( JVFRM_HOME_DEF_LANG . JVFRM_HOME_MEMBER_SLUG.'/'.$user->user_login . '/' ) );

		switch( jvfrm_home_tso()->get('login_redirect', '') )
		{

			// Go to the Main Page
			case 'home'		: $jvfrm_home_redirect = esc_url( home_url( '/' ) ); break;

			// Everything no working
			case 'current'	:

				// This page is WP Login Page ?
				if(
					isset( $_POST['log'] ) &&
					isset( $_POST['pwd'] ) &&
					isset( $_POST['wp-submit'] )
				) {
					$jvfrm_home_redirect = admin_url();
				}else{
					$jvfrm_home_redirect = $req;
				}

			break;
			// Go to the Profile Page
			case 'admin'	: $jvfrm_home_redirect = admin_url(); break;
		}
		return $jvfrm_home_redirect;
	};

add_action( 'widgets_init', 'jvfrm_home_register_sidebars' );

function jvfrm_home_register_sidebars()
{
	$jvfrm_home_sidebars = Array(
		Array(
			'name'				=> esc_html__( 'Default Sidebar', 'javohome' ),
			'id'						=> 'sidebar-1',
			'description'		=> esc_html__( 'Widgets in this area will be shown on the default pages.', 'javohome' ),
			'before_widget'	=> '<div class="row widget widgets-wraps">',
			'after_widget'	=> '</div>',
			'before_title'		=> '<div class="widgettitle_wrap"><h2 class="widgettitle">',
			'after_title'			=> '</h2></div>',
		)		
		/*
		, Array(
			'name'					=> esc_html__( "Footer Top Area", 'javohome' ),
			'id'							=> 'footer-top-area',
			'before_widget'		=> '<div id="%1$s" class="widget widgets clearfix %2$s">',
			'after_widget'			=> '</div>',
			'before_title'			=> '<h5>',
			'after_title'				=> '</h5>',
		) */
		/*
		, Array(
			'name'					=> esc_html__( "Footer Bottom Area", 'javohome' ),
			'id'							=> 'footer-bottom-area',
			'before_widget'		=> '<div id="%1$s" class="widget widgets clearfix %2$s">',
			'after_widget'			=> '</div>',
			'before_title'			=> '<h5>',
			'after_title'				=> '</h5>',
		)
		*/
		, Array(
			'name'				=> 'Menu widget1',
			'id'				=> 'menu-widget-1',
			'before_widget'		=> '<div id="%1$s" class="widget widgets clearfix %2$s">',
			'after_widget'		=> '</div>',
			'before_title'		=> '<h5>',
			'after_title'		=> '</h5>',
		)
		/*
		, array(
			'name'				=> 'Canvas Menu',
			'id'				=> 'canvas-menu-widget',
			'before_widget'		=> '<div id="%1$s" class="widget widgets clearfix %2$s">',
			'after_widget'		=> '</div>',
			'before_title'		=> '<h5>',
			'after_title'		=> '</h5>',
		)*/
		, array(
			'name'				=> esc_html__( "Toolbar Left", 'javohome' ) ,
			'id'				=> 'toolbar-left-widget',
			'before_widget'		=> '<div id="%1$s" class="javo-toolbar-item %2$s">',
			'after_widget'		=> '</div>',
			'before_title'		=> '',
			'after_title'		=> '',
		)
			, array(
			'name'				=> esc_html__( "Toolbar Right", 'javohome' ),
			'id'				=> 'toolbar-right-widget',
			'before_widget'		=> '<div id="%1$s" class="javo-toolbar-item %2$s">',
			'after_widget'		=> '</div>',
			'before_title'		=> '',
			'after_title'		=> '',
		) 
	);

	$intFooterColumns = jvfrm_home_tso()->get( 'footer_sidebar_columns', 'column3' ) == 'column4' ? 4 : 3;
	
	for( $intCurWidget=1; $intCurWidget <= $intFooterColumns; $intCurWidget++ ) {
		$jvfrm_home_sidebars[] = Array(
			'name' => sprintf( esc_html__( 'Footer Sidebar%s', 'javohome' ), $intCurWidget ),
			'id' => 'sidebar-foot' . $intCurWidget,
			'description' => esc_html__( 'Widgets in this area will be shown on the footer side.', 'javohome' ),
			'before_widget' => '<div class="row widget widgets-wraps">',
			'after_widget' => '</div>',
			'before_title' => '<div class="widgettitle_wrap col-md-12"><h2 class="widgettitle"><span>',
			'after_title' => '</span></h2></div>',
		);
	}

	$jvfrm_home_sidebars = apply_filters( 'jvfrm_home_default_sidebars', $jvfrm_home_sidebars );
	if( !empty( $jvfrm_home_sidebars ) ) {
		foreach( $jvfrm_home_sidebars as $sidebar )
			register_sidebar( $sidebar );
	}

}


// Set up the content width value based on the theme's design and stylesheet.
if ( ! isset( $content_width ) )
	$content_width = 625;


function jvfrm_home_setup() {
	/*
	 * Makes Javo Themes available for translation.
	 *
	 * Translations can be added to the /languages/ directory.
	 * If you're building a theme based on Javo Themes, use a find and replace
	 * to change 'javohome' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'javohome', get_template_directory() . '/languages' );

	// This theme styles the visual editor with editor-style.css to match the theme style.
	add_editor_style();

	// Adds RSS feed links to <head> for posts and comments.
	add_theme_support( 'automatic-feed-links' );

	// This theme supports a variety of post formats.
	add_theme_support( 'post-formats', array( 'link', 'quote', 'video', 'audio', 'gallery' ) );
}
add_action( 'after_setup_theme', 'jvfrm_home_setup' );

/**
 * Enqueue scripts and styles for front-end.
 *
 * @since Javo Themes 1.0
 *
 * @return void
 */
function jvfrm_home_scripts_styles() {
	global $wp_styles;

	/*
	 * Adds JavaScript to pages with the comment form to support
	 * sites with threaded comments (when in use).
	 */
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) )
		wp_enqueue_script( 'comment-reply' );

	// Adds JavaScript for handling the navigation menu hide-and-show behavior.
	//wp_enqueue_script( 'javothemes-navigation', get_template_directory_uri() . '/assets/js/navigation.js', array(), '1.0', true );

	// Loads the Internet Explorer specific stylesheet.
	wp_enqueue_style( 'javothemes-ie', get_template_directory_uri() . '/css/ie.css', array( 'javothemes-style' ), '20121010' );
	$wp_styles->add_data( 'javothemes-ie', 'conditional', 'lt IE 9' );
}
add_action( 'wp_enqueue_scripts', 'jvfrm_home_scripts_styles' );

/**
 * Filter the page title.
 *
 * Creates a nicely formatted and more specific title element text
 * for output in head of document, based on current view.
 *
 * @since Javo Themes 1.0
 *
 * @param string $title Default title text for current view.
 * @param string $sep Optional separator.
 * @return string Filtered title.
 */
function jvfrm_home_wp_title( $title, $sep ) {
	global $paged, $page;

	if ( is_feed() )
		return $title;

	// Add the site name.
	$title .= get_bloginfo( 'name' );

	// Add the site description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		$title = "$title $sep $site_description";

	// Add a page number if necessary.
	if ( $paged >= 2 || $page >= 2 )
		$title = "$title $sep " . sprintf( esc_html__( 'Page %s', 'javohome' ), max( $paged, $page ) );

	return $title;
}
add_filter( 'wp_title', 'jvfrm_home_wp_title', 10, 2 );

/**
 * Filter the page menu arguments.
 *
 * Makes our wp_nav_menu() fallback -- wp_page_menu() -- show a home link.
 *
 * @since Javo Themes 1.0
 */
function jvfrm_home_page_menu_args( $args ) {
	if ( ! isset( $args['show_home'] ) )
		$args['show_home'] = true;
	return $args;
}
add_filter( 'wp_page_menu_args', 'jvfrm_home_page_menu_args' );

if ( ! function_exists( 'jvfrm_home_archive_nav' ) ) :
/**
 * Displays navigation to next/previous archives when applicable.
 *
 * @since Javo Themes 1.0
 */
function jvfrm_home_archive_nav() {
	global $wp_query;
	$big = 999999999; // need an unlikely integer
	?>
	<div class="jvfrm_home_pagination">
		<?php
		echo paginate_links( array(
			'base'			=> str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) )
			, 'format'		=> '?paged=%#%'
			, 'current'		=> max( 1, get_query_var('paged') )
			, 'total'		=> $wp_query->max_num_pages
		) ); ?>
	</div><!-- jvfrm_home_pagination -->
	<?php
}
endif;


if ( ! function_exists( 'jvfrm_home_content_nav' ) ) :
/**
 * Displays navigation to next/previous pages when applicable.
 *
 * @since Javo Themes 1.0
 */
function jvfrm_home_content_nav() {
	global $wp_query;

	if ( $wp_query->max_num_pages > 1 ) : ?>
		<nav class="navigation jv-single-post-pager">
			<ul class="pager">
				<li class="next"><?php next_posts_link( wp_kses(__( 'Older posts <i class="glyphicon glyphicon-chevron-right"></i>', 'javohome' ),jvfrm_home_allow_tags()) ); ?></li>
				<li class="previous"><?php previous_posts_link( wp_kses(__( '<i class="glyphicon glyphicon-chevron-left"></i> Newer posts', 'javohome' ),jvfrm_home_allow_tags()) ); ?></li>
			</ul><!-- /.pager -->
		</nav>
	<?php endif;
}
endif;

if ( ! function_exists( 'jvfrm_home_post_nav' ) ) :
/**
 * Displays navigation to next/previous pages when applicable.
 *
 * @since Javo Themes 1.0
 */
function jvfrm_home_post_nav( $args=Array() ) {
	global $post;

	$arrOptions		= shortcode_atts(
		Array(
			'type'				=> 'general',
			'post_thumbnail'	=> false,
			'thumbnail_size'	=> 'jvfrm-home-tiny',
			'post_title'		=> true,
			'prevClass'			=> 'glyphicon glyphicon-chevron-left',
			'nextClass'			=> 'glyphicon glyphicon-chevron-right',
		), $args
	);

	$strLinkFormat	= '<a href="%s" class="%s">';
	$strIconFormat	= '<i class="%s"></i>';

	switch( $arrOptions[ 'type' ] ) :

		case 'reavl':
		?>
			<nav class="nav-reveal">
				<?php
				if( $objPrevPost = get_previous_post( true ) ){
					printf( $strLinkFormat, get_permalink( $objPrevPost->ID ), 'prev' );
						echo '<span class="icon-wrap">';
							printf( $strIconFormat, $arrOptions[ 'prevClass' ] );
						echo '</span>';
						echo '<div class="nav-contents">';
							if( $arrOptions[ 'post_title' ] )
								printf( '<h3>%s</h3>', esc_html( $objPrevPost->post_title ) );
							if( $arrOptions[ 'post_thumbnail' ] && has_post_thumbnail( $objPrevPost->ID ) )
								echo get_the_post_thumbnail( $objPrevPost->ID, $arrOptions[ 'thumbnail_size' ] );
						echo '</div>';
					printf( '</a>' );
				}
				if( $objNextPost = get_next_post( true ) ){
					printf( $strLinkFormat, get_permalink( $objNextPost->ID ), 'next' );
						echo '<span class="icon-wrap">';
							printf( $strIconFormat, $arrOptions[ 'nextClass' ] );
						echo '</span>';
						echo '<div class="nav-contents">';
							if( $arrOptions[ 'post_title' ] )
								printf( '<h3>%s</h3>', esc_html( $objNextPost->post_title ) );
							if( $arrOptions[ 'post_thumbnail' ] && has_post_thumbnail( $objNextPost->ID ) )
								echo get_the_post_thumbnail( $objNextPost->ID, $arrOptions[ 'thumbnail_size' ] );
						echo '</div>';
					printf( '</a>' );
				} ?>
			</nav>
		<?php
		break;
		case 'general':
		default:
		?>
			<nav class="navigation jv-single-post-pager">
				<ul class="pager">
					<li class="previous" data-ss="<?php echo $arrOptions[ 'post_thumbnail' ];?>">
						<?php
						if( $objPrevPost	= get_previous_post( true ) ){
							printf( $strLinkFormat, get_permalink( $objPrevPost->ID ), 'prev' );
								printf( $strIconFormat, $arrOptions[ 'prevClass' ] );
								echo '<div class="nav-contents">';
									if( $arrOptions[ 'post_thumbnail' ] && has_post_thumbnail( $objPrevPost->ID ) )
										echo get_the_post_thumbnail( $objPrevPost->ID, $arrOptions[ 'thumbnail_size' ] );
									if( $arrOptions[ 'post_title' ] )
										printf( '<div>%s</div>', esc_html( $objPrevPost->post_title ) );
								echo '</div>';
							printf( '</a>' );
						} ?>
					</li>
					<li class="next">
						<?php
						if( $objNextPost	= get_next_post( true ) ){
							printf( $strLinkFormat, get_permalink( $objNextPost->ID ), 'next' );
								echo '<div class="nav-contents">';
									if( $arrOptions[ 'post_thumbnail' ] && has_post_thumbnail( $objPrevPost->ID ) )
										echo get_the_post_thumbnail( $objNextPost->ID );
									if( $arrOptions[ 'post_title' ] )
										echo esc_html( $objNextPost->post_title );
								echo '</div>';
								printf( $strIconFormat, $arrOptions[ 'nextClass' ] );
							printf( '</a>' );
						} ?>
					</li>
				</ul><!-- /.pager -->
			</nav>
		<?php
	endswitch;
}
endif;

if ( ! function_exists( 'jvfrm_home_comment' ) ) :
/**
 * Template for comments and pingbacks.
 *
 * To override this walker in a child theme without modifying the comments template
 * simply create your own jvfrm_home_comment(), and that function will be used instead.
 *
 * Used as a callback by wp_list_comments() for displaying the comments.
 *
 * @since Javo Themes 1.0
 *
 * @return void
 */
function jvfrm_home_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case 'pingback' :
		case 'trackback' :
		// Display trackbacks differently than normal comments.
	?>
	<li <?php comment_class( 'jv-single-post-comment-item' ); ?> id="comment-<?php comment_ID(); ?>">
		<p><?php esc_html_e( 'Pingback:', 'javohome' ); ?> <?php comment_author_link(); ?> <?php edit_comment_link( esc_html__( '(Edit)', 'javohome' ), '<span class="edit-link">', '</span>' ); ?></p>
	<?php
			break;
		default :
			// Proceed with normal comments.
			global $post;
			?>
			<li <?php comment_class( 'jv-single-post-comment-item' ); ?> id="li-comment-<?php comment_ID(); ?>">
				<div id="comment-<?php comment_ID(); ?>" class="comment media">
					<div class="media-left">
						<?php echo get_avatar( $comment, 45 ); ?>
					</div>
					<div class="media-body">
						<div class="comment-author">
							<?php
							echo join( "\n", Array(
								'<div class="author-meta pull-left">',
								sprintf( '<b class="fn">%s</b>', get_comment_author_link() ),
								sprintf( '<small>%s at %s</small>', get_comment_date(), get_comment_time() ),
								'</div>',
								'<div class="btn-edit pull-right">',
								sprintf( "<a href=\"%s\">%s</a>", get_edit_comment_link( get_comment_ID() ), esc_html__( "Edit", 'javohome' ) ),
								'</div>',
							) ); ?>
						</div><!-- /.comment-author -->
						<div class="comment-content">
							<?php comment_text(); ?>
						</div><!-- /.comment-content -->
						<?php if ( '0' == $comment->comment_approved ) : ?>
							<p class="comment-awaiting-moderation"><?php esc_html_e( 'Your comment is awaiting moderation.', 'javohome' ); ?></p>
						<?php endif; ?>
						<div class="reply">
							<?php
							comment_reply_link(
								Array_merge( $args,
									Array(
										'reply_text'	=> esc_html__( 'Reply', 'javohome' ),
										'after'			=> ' <span>&darr;</span>',
										'depth'			=> $depth,
										'max_depth'	=> $args['max_depth']
									)
								)
							); ?>
						</div><!-- .reply -->
					</div>
				</div>
			<?php
			break;
	endswitch; // end comment_type check
}
endif;

if ( ! function_exists( 'jvfrm_home_entry_meta' ) ) :
/**
 * Set up post entry meta.
 *
 * Prints HTML with meta information for current post: categories, tags, permalink, author, and date.
 *
 * Create your own jvfrm_home_entry_meta() to override in a child theme.
 *
 * @since Javo Themes 1.0
 *
 * @return void
 */
function jvfrm_home_entry_meta() {
	// Translators: used between list items, there is a space after the comma.
	$categories_list = get_the_category_list( esc_html__( ', ', 'javohome' ) );

	// Translators: used between list items, there is a space after the comma.
	$tag_list = get_the_tag_list( '', esc_html__( ', ', 'javohome' ) );

	$date = sprintf( '<a href="%1$s" title="%2$s" rel="bookmark"><time class="entry-date" datetime="%3$s">%4$s</time></a>',
		esc_url( get_permalink() ),
		esc_attr( get_the_time() ),
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() )
	);

	$author = sprintf( '<span class="author vcard"><a class="url fn n" href="%1$s" title="%2$s" rel="author">%3$s</a></span>',
		esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
		esc_attr( sprintf('%s %s', 'javohome' ), esc_html__('View all posts by', 'javohome'), get_the_author() ),
		get_the_author()
	);

	// Translators: 1 is category, 2 is tag, 3 is the date and 4 is the author's name.
	if ( $tag_list ) {
		$utility_text = sprintf('%s : %%1$s  %s: %%2$s %s : %%3$s<span class="by-author"> %s %%4$s</span>.', esc_html__('Category', 'javohome'), esc_html__('Tags', 'javohome'), esc_html__('Date', 'javohome'), esc_html__('by', 'javohome'));
	} elseif ( $categories_list ) {
		$utility_text = sprintf('%s %%1$s %s : %%3$s<span class="by-author"> %s %%4$s</span>.', esc_html__('Category', 'javohome'), esc_html__('Date', 'javohome'), esc_html__('by', 'javohome'));
	} else {
		$utility_text = sprintf('%s : %%3$s<span class="by-author"> %s %%4$s</span>.', esc_html__('Date', 'javohome'), esc_html__('by', 'javohome'));
	}

	printf(
		$utility_text,
		$categories_list,
		$tag_list,
		$date,
		$author
	);
}
endif;

/**
 * Extend the default WordPress body classes.
 *
 * Extends the default WordPress body class to denote:
 * 1. Using a full-width layout, when no active widgets in the sidebar
 *    or full-width template.
 * 2. Front Page template: thumbnail in use and number of sidebars for
 *    widget areas.
 * 3. White or empty background color to change the layout and spacing.
 * 4. Custom fonts enabled.
 * 5. Single or multiple authors.
 *
 * @since Javo Themes 1.0
 *
 * @param array $classes Existing class values.
 * @return array Filtered class values.
 */
function jvfrm_home_body_class( $classes ) {

	if ( ! is_active_sidebar( 'sidebar-1' ) || is_page_template( 'templates/full-width.php' ) )
		$classes[] = 'full-width';

	if ( is_page_template( 'templates/front-page.php' ) ) {
		$classes[] = 'template-front-page';
		if ( has_post_thumbnail() )
			$classes[] = 'has-post-thumbnail';
		if ( is_active_sidebar( 'sidebar-2' ) && is_active_sidebar( 'sidebar-3' ) )
			$classes[] = 'two-sidebars';
	}

	// Enable custom font class only if the font CSS is queued to load.
	if ( wp_style_is( 'javothemes-fonts', 'queue' ) )
		$classes[] = 'custom-font-enabled';

	if ( ! is_multi_author() )
		$classes[] = 'single-author';

	return $classes;
}
add_filter( 'body_class', 'jvfrm_home_body_class' );

/**
 * Adjust content width in certain contexts.
 *
 * Adjusts content_width value for full-width and single image attachment
 * templates, and when there are no active widgets in the sidebar.
 *
 * @since Javo Themes 1.0
 *
 * @return void
 */
function jvfrm_home_content_width() {
	if ( is_page_template( 'templates/full-width.php' ) || is_attachment() || ! is_active_sidebar( 'sidebar-1' ) ) {
		global $content_width;
		$content_width = 960;
	}
}
add_action( 'template_redirect', 'jvfrm_home_content_width' );

/**
 * Register postMessage support.
 *
 * Add postMessage support for site title and description for the Customizer.
 *
 * @since Javo Themes 1.0
 *
 * @param WP_Customize_Manager $wp_customize Customizer object.
 * @return void
 */
function jvfrm_home_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';
}
add_action( 'customize_register', 'jvfrm_home_customize_register' );

/**
 * Enqueue Javascript postMessage handlers for the Customizer.
 *
 * Binds JS handlers to make the Customizer preview reload changes asynchronously.
 *
 * @since Javo Themes 1.0
 *
 * @return void
 */
 add_action( 'customize_preview_init', 'jvfrm_home_customize_preview_js' );
function jvfrm_home_customize_preview_js() {
	wp_enqueue_script( 'javothemes-customizer', get_template_directory_uri() . '/assets/js/theme-customizer.js', array( 'customize-preview' ), '20130301', true );
}



// Recommendation for permalink
if ( '' == get_option( 'permalink_structure' ) ) {
    function wpse157069_permalink_warning() {
		printf( "
			<div id=\"permalink_warning\" class=\"error\">
				<p>
					We strongly recommend adding a
					<a href=\"%s\">permalink structure (Post Name)</a>
					to your site when using Javo Themes.
				</p>
			</div>"
			, esc_url( admin_url( 'options-permalink.php' ) )
		);
    }
    add_action( 'admin_footer', 'wpse157069_permalink_warning' );
}

//restrict authors to only being able to view media that they've uploaded
function ik_eyes_only( $wp_query ) {
	//are we looking at the Media Library or the Posts list?
	if ( strpos( $_SERVER[ 'REQUEST_URI' ], '/wp-admin/upload.php' ) !== false
	|| strpos( $_SERVER[ 'REQUEST_URI' ], '/wp-admin/edit.php' ) !== false ) {
		//user level 5 converts to Editor
		if ( !current_user_can( 'manage_options' ) ) {
			//restrict the query to current user
			global $current_user;
			$wp_query->set( 'author', $current_user->id );
		}
	}
}

//filter media library & posts list for authors
add_filter('parse_query', 'ik_eyes_only' );

add_action('init', 'jvfrm_home_adminbar_onoff_callback');
function jvfrm_home_adminbar_onoff_callback(){
	global $jvfrm_home_tso;
	if(
		$jvfrm_home_tso->get('adminbar_hidden', '') == 'use' &&
		!current_user_can('administrator')
	){
		show_admin_bar(false);
	}
}