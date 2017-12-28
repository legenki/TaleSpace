<?php
if( !defined( 'ABSPATH' ) )
	die;

class jvfrm_home_admin_helper
{

	const PLUGIN_URL_FORMAT = 'admin.php?page=%1$s_plugins';

	static $instance;

	public	$name;
	public $slug;

	private $theme;
	private $path;
	private $template_part;

	public function __construct() {
		self::$instance				= &$this;
		$this->theme				= wp_get_theme();
		$this->name					= $this->theme->get( 'Name' );
		$this->path					= JVFRM_HOME_ADM_DIR;
		$this->template_part	=$this->path . '/templates/';

		if( $this->theme->get( 'Template' ) ) {
			$this->parent			= wp_get_theme(  $this->theme->get( 'Template' ) );
			$this->name			= $this->parent->get( 'Name' );
		}

		$this->slug = sanitize_title( $this->name );

		// Plugin Install
		add_action( 'admin_init', Array( $this, 'plugin_actions' ) );

		add_action( 'admin_menu', Array( $this, 'register_helper_menu' ) );
		add_action( 'jvfrm_home_admin_helper_page_header', Array( $this, 'helper_page_header' ) );
		add_action( 'jvfrm_home_admin_helper_page_footer', Array( $this, 'helper_page_footer' ) );

		// Banner
		add_action( 'jvfrm_home_admin_helper_header_before', array( $this, 'helper_page_innerBanner' ), 15 );

		add_filter( 'jvfrm_home_tgmpa_return_link', Array( $this, 'tgmpa_return_link' ) );


	}

	/**
	 *
	 * Common Function
	 */

	 function plugin_link( $item ) {
		$installed_plugins = get_plugins();

		$item['sanitized_plugin'] = $item['name'];

		// We have a repo plugin
		if ( ! $item['version'] ) {
			$item['version'] = TGM_Plugin_Activation::$instance->does_plugin_have_update( $item['slug'] );
		}

		/** We need to display the 'Install' hover link */
		if ( ! isset( $installed_plugins[$item['file_path']] ) ) {
			$actions = array(
				'install' => sprintf(
					'<a href="%1$s" class="button button-primary" title="Install %2$s">Install</a>',
					esc_url( wp_nonce_url(
						add_query_arg(
							array(
								'page'          => urlencode( TGM_Plugin_Activation::$instance->menu ),
								'plugin'        => urlencode( $item['slug'] ),
								'plugin_name'   => urlencode( $item['sanitized_plugin'] ),
								'plugin_source' => urlencode( $item['source'] ),
								'tgmpa-install' => 'install-plugin',
								'return_url'    => sprintf( '%1$s_plugins', $this->slug )
							),
							TGM_Plugin_Activation::$instance->get_tgmpa_url()
						),
						'tgmpa-install',
						'tgmpa-nonce'
					) ),
					$item['sanitized_plugin']
				),
			);
		}
		/** We need to display the 'Activate' hover link */
		elseif ( is_plugin_inactive( $item['file_path'] ) ) {
			$actions = array(
				'activate' => sprintf(
					'<a href="%1$s" class="button button-primary" title="Activate %2$s">Activate</a>',
					esc_url( add_query_arg(
						array(
							'plugin'               => urlencode( $item['slug'] ),
							'plugin_name'          => urlencode( $item['sanitized_plugin'] ),
							'plugin_source'        => urlencode( $item['source'] ),
							'jvfrm-activate'       => 'activate-plugin',
							'jvfrm-activate-nonce' => wp_create_nonce( 'jvfrm-activate' ),
						),
						admin_url( sprintf( self::PLUGIN_URL_FORMAT, $this->slug ) )
					) ),
					$item['sanitized_plugin']
				),
			);
		}
		/** We need to display the 'Update' hover link */
		elseif ( version_compare( $installed_plugins[$item['file_path']]['Version'], $item['version'], '<' ) ) {
			$actions = array(
				'update' => sprintf(
					'<a href="%1$s" class="button button-primary" title="Install %2$s">Update</a>',
					wp_nonce_url(
						add_query_arg(
							array(
								'page'          => urlencode( TGM_Plugin_Activation::$instance->menu ),
								'plugin'        => urlencode( $item['slug'] ),

								'tgmpa-update'  => 'update-plugin',
								'plugin_source' => urlencode( $item['source'] ),
								'version'       => urlencode( $item['version'] ),
								'return_url'    => sprintf( '%1$s_plugins', $this->slug )
							),
							TGM_Plugin_Activation::$instance->get_tgmpa_url()
						),
						'tgmpa-update',
						'tgmpa-nonce'
					),
					$item['sanitized_plugin']
				),
			);
		} elseif ( is_plugin_active( $item['file_path'] ) ) {
			$actions = array(
				'deactivate' => sprintf(
					'<a href="%1$s" class="button button-primary" title="Deactivate %2$s">Deactivate</a>',
					esc_url( add_query_arg(
						array(
							'plugin'                 => urlencode( $item['slug'] ),
							'plugin_name'            => urlencode( $item['sanitized_plugin'] ),
							'plugin_source'          => urlencode( $item['source'] ),
							'jvfrm-deactivate'       => 'deactivate-plugin',
							'jvfrm-deactivate-nonce' => wp_create_nonce( 'jvfrm-deactivate' ),
						),
						admin_url( sprintf( self::PLUGIN_URL_FORMAT, $this->slug ) )
					) ),
					$item['sanitized_plugin']
				),
			);
		}

		return $actions;
	}



	public function plugin_actions()
	{
		if ( isset( $_GET['jvfrm-deactivate'] ) && $_GET['jvfrm-deactivate'] == 'deactivate-plugin' ) {
				check_admin_referer( 'jvfrm-deactivate', 'jvfrm-deactivate-nonce' );

				$plugins = TGM_Plugin_Activation::$instance->plugins;

				foreach( $plugins as $plugin ) {
					if ( $plugin['slug'] == $_GET['plugin'] ) {
						deactivate_plugins( $plugin['file_path'] );
					}
				}
			} if ( isset( $_GET['jvfrm-activate'] ) && $_GET['jvfrm-activate'] == 'activate-plugin' ) {
				check_admin_referer( 'jvfrm-activate', 'jvfrm-activate-nonce' );

				$plugins = TGM_Plugin_Activation::$instance->plugins;

				foreach( $plugins as $plugin ) {
					if ( $plugin['slug'] == $_GET['plugin'] ) {
						activate_plugin( $plugin['file_path'] );

						wp_redirect( admin_url( sprintf( self::PLUGIN_URL_FORMAT, $this->slug ) ) );
						exit;
					}
				}
			}
	}

	public function register_helper_menu()
	{
		global $submenu;

		$prefix					= 'add_';
		$strMenuName		= sanitize_title( $this->name );

		call_user_func_array(
			$prefix . 'menu_page',
			Array(
				$this->name
				, $this->name
				, 'manage_options'
				, $strMenuName
				, Array( $this, 'helper_main' )
				, ''
				, 3
			)
		);

		call_user_func_array(
			$prefix . 'submenu_page',
			Array(
				$strMenuName
				, sprintf( esc_html__( "%s Status", 'javohome' ), $this->name )
				, esc_html__( "Status", 'javohome' )
				, 'manage_options'
				, $strMenuName . '_status'
				, Array( $this, 'helper_staus' )
			)
		);

		call_user_func_array(
			$prefix . 'submenu_page',
			Array(
				$strMenuName
				, sprintf( esc_html__( "%s Status", 'javohome' ), $this->name )
				, esc_html__( "Plugins", 'javohome' )
				, 'manage_options'
				, $strMenuName . '_plugins'
				, Array( $this, 'helper_plugins' )
			)
		);

		if( class_exists( 'jvfrm_home_theme_settings' ) )
			call_user_func_array(
				$prefix . 'submenu_page',
				Array(
					$strMenuName
					, sprintf( esc_html__( "%s Status", 'javohome' ), $this->name )
					, esc_html__( "Theme Settings", 'javohome' )
					, 'manage_options'
					, 'javo-theme-settings'
					, Array( jvfrm_home_theme_settings::$instance, 'settings_page_initialize' )
				)
			);

		do_action( 'jvfrm_home_admin_helper_register_menu', $this, $strMenuName );

		if( isset( $submenu[ $strMenuName ][0][0] ) )
			$submenu[ $strMenuName ][0][0] = esc_html__( "Welcome", 'javohome' );
	}

	public function helper_main() { $this->get_template( 'welcome' ); }
	public function helper_staus() {$this->get_template( 'status' ); }
	public function helper_plugins() {$this->get_template( 'plugins' ); }

	public function get_template( $template_name )  {
		$objTheme		= $this->theme;
		$strFileName	= $this->template_part . $template_name . '.php';

		do_action( 'jvfrm_home_admin_helper_page_header' );
		do_action( 'jvfrm_home_admin_helper_' . $template_name . ' _header' );
		if( file_exists( $strFileName ) )
			require_once $strFileName;

		do_action( 'jvfrm_home_admin_helper_' . $template_name . '_footer' );
		do_action( 'jvfrm_home_admin_helper_page_footer' );
	}

	public function helper_page_header()
	{
		global $submenu;
		if( isset( $submenu[ sanitize_title( $this->name ) ] ) ) {
			$td_welcome_menu_items = $submenu[ sanitize_title( $this->name ) ];
		}

		do_action( 'jvfrm_home_admin_helper_header_before' );

		if (is_array($td_welcome_menu_items)) {
			?>
			<div class="wrap about-wrap">
				<h2 class="nav-tab-wrapper">

					<?php
						foreach ($td_welcome_menu_items as $td_welcome_menu_item) {
							?>
								<a href="<?php echo esc_url( add_query_arg( Array( 'page' => $td_welcome_menu_item[2] ), admin_url( 'admin.php' ) ) ); ?>" class="nav-tab <?php if(isset($_GET['page']) and $_GET['page'] == $td_welcome_menu_item[2]) { echo sanitize_html_class( 'nav-tab-active' ); }?> "><?php  echo $td_welcome_menu_item[0]; ?></a>
							<?php
						}
					?>
				</h2>
			</div>
			<?php
		}

		do_action( 'jvfrm_home_admin_helper_header_after' );
	}

	public function helper_page_footer(){}

	public function helper_page_innerBanner(){
		printf(
			'<p><a href="%3$s" target="_blank"><img src="%1$s/%2$s"></a></p>',
			JVFRM_HOME_IMG_DIR,
			'theme-settings-banner.png',
			esc_url( 'javothemes.com/forum/free-installation/' )
		);
	}

	/**
	 *
	 * ## TGMPA UPDATE REQUIRED ACTION ##
	 *
	 * library / functions / class-tgm-plugin-activation.php
	 * function : do_plugin_install()
	 * Line : 915
	 *
	 *	echo apply_filters( 'jvfrm_home_tgmpa_return_link', '<p><a href="'. esc_url( $this->get_tgmpa_url() ). '" target="_parent">'. esc_html( $this->strings['return'] ). '</a></p>' );
	 *
	 */
	public function tgmpa_return_link( $link='' ) {
		if(
			( 
				isset( $_GET[ 'tgmpa-install' ] ) && $_GET[ 'tgmpa-install' ] =='install-plugin' ||
				isset( $_GET[ 'tgmpa-update' ] ) && $_GET[ 'tgmpa-update' ] =='update-plugin'
			) &&
			( isset( $_GET[ 'return_url' ] ) && $_GET[ 'return_url' ] == sprintf( '%1$s_plugins', $this->slug ) )
		){
			$url = add_query_arg(
				array(
					'page' => $_GET[ 'return_url' ],
				),
				admin_url( 'admin.php' )
			);
			$link = sprintf(
				'<a href="%1$s">%2$s</a>',
				esc_url( $url ),
				esc_html__( 'Return Javo Core Plugin Page', 'javohome' )
			);
		}
		return $link;
	}
}


if( !function_exists( 'jvfrm_home_admin_helper_init') ){
	function jvfrm_home_admin_helper_init() {
		$GLOBALS[ 'jvfrm_home_admin_helper' ] = new jvfrm_home_admin_helper;
	}
	jvfrm_home_admin_helper_init();
}