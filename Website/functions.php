<?php
/**
 *	Javo Themes functions and definitions
 *
 * @package WordPress
 * @subpackage Javo
 * @since Javo Themes 1.0
 */

 // Path Initialize
define( 'JVFRM_HOME_APP_PATH'		, get_template_directory() );				// Get Theme Folder URL : hosting absolute path
define( 'JVFRM_HOME_THEME_DIR'		, get_template_directory_uri() );			// Get http URL : ex) http://www.abc.com/
define( 'JVFRM_HOME_SYS_DIR'		, JVFRM_HOME_APP_PATH."/library");			// Get Library path
define( 'JVFRM_HOME_TP_DIR'			, JVFRM_HOME_APP_PATH."/templates");		// Get Tempate folder
define( 'JVFRM_HOME_ADM_DIR'		, JVFRM_HOME_SYS_DIR."/admin");				// Administrator Page
define( 'JVFRM_HOME_IMG_DIR'		, JVFRM_HOME_THEME_DIR."/assets/images");	// Images folder
define( 'JVFRM_HOME_WG_DIR'			, JVFRM_HOME_SYS_DIR."/widgets");			// Widgets Folder
define( 'JVFRM_HOME_HDR_DIR'		, JVFRM_HOME_SYS_DIR."/header");			// Get Headers
define( 'JVFRM_HOME_CLS_DIR'		, JVFRM_HOME_SYS_DIR."/classes");			// Classes
define( 'JVFRM_HOME_DSB_DIR'		, JVFRM_HOME_SYS_DIR."/dashboard");			// Dash Board
define( 'JVFRM_HOME_FUC_DIR'		, JVFRM_HOME_SYS_DIR."/functions");			// Functions
define( 'JVFRM_HOME_PLG_DIR'		, JVFRM_HOME_SYS_DIR."/plugins");			// Plugin folder
define( 'JVFRM_HOME_ADO_DIR'		, JVFRM_HOME_SYS_DIR . "/addons");			// Addons folder

define( 'JVFRM_HOME_CUSTOM_HEADER', false );

// Includes : Basic or default functions and included files
require_once JVFRM_HOME_SYS_DIR	. "/define.php";								// defines
require_once JVFRM_HOME_SYS_DIR	. "/load.php";									// loading functions, classes, shotcode, widgets
require_once JVFRM_HOME_SYS_DIR	. "/enqueue.php";								// enqueue js, css
require_once JVFRM_HOME_SYS_DIR	. "/wp_init.php";								// post-types, taxonomies
require_once JVFRM_HOME_ADM_DIR	. "/class-admin-theme-settings.php";			// theme options
require_once JVFRM_HOME_DSB_DIR	. "/class-dashboard.php";						// theme screen options tab.

$jvfrm_home_core_include	= apply_filters( 'jvfrm_home_core_function_path', JVFRM_HOME_APP_PATH .'/includes/class-core.php' );

if( file_exists( $jvfrm_home_core_include ) ) require_once $jvfrm_home_core_include;

do_action( 'jvfrm_home_themes_loaded' );


add_action( 'wp_enqueue_scripts', 'wcs_dequeue_quantity' );
function wcs_dequeue_quantity() {
    wp_dequeue_style( 'wcqi-css' );
}

// update_option( 'wp_less_cached_files', '' );