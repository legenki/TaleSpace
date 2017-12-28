<?php
function jvfrm_home_get_demoStatus(){
	global $wpdb;
	return $wpdb->get_var(
		$wpdb->prepare(
			"select ID from $wpdb->posts where post_type='%s' and post_status='%s'",
			jvfrm_home_core()->slug,
			'publish'
		)
	);
}

$arrGuideSections	= Array(
	'plugin-actived'		=> Array(
		'label'				=> esc_html__( "Active Requested Plugins", 'javohome' ),
		'active'			=> true,
		'passed'			=> apply_filters(
			'jvfrm_home_helper_require_plugins_pass',
			class_exists( 'Vc_Manager' ) &&
			class_exists( 'Ultimate_VC_Addons' )
			),
		'plugins' => apply_filters(
			'jvfrm_home_helper_require_plugins',
			Array(
				'Vc_Manager' => esc_html__( "WPBakery Visual Composer", 'javohome' ),
				'Ultimate_VC_Addons' => esc_html__( "Ultimate Addons for Visual Composer", 'javohome' )
			)
		)
	),
	'demo-installed'	=> Array(
		'label'				=> esc_html__( "Demo Installation", 'javohome' )
		, 'passed'			=> jvfrm_home_get_demoStatus()
	),
	'permalink'			=> Array(
		'label'				=> esc_html__( "Permalink Setup", 'javohome' )
		, 'passed'			=> strstr( get_option( 'permalink_structure' ), 'postname' )
	),
	'widget-installed'	=> Array(
		'label'				=> esc_html__( "Widget Installation", 'javohome' )
		, 'passed'			=> is_active_sidebar( 'lava-property-single-sidebar' )
	),
	'menu-installed'	=> Array(
		'label'				=> esc_html__( "Menu Setup", 'javohome' )
		, 'passed'			=> has_nav_menu( 'primary' )
	),
	'static-installed'	=> Array(
		'label'				=> esc_html__( "Front Page Setup", 'javohome' )
		, 'passed'			=> get_option( 'page_on_front' )
	),
	'setting-updated'	=> Array(
		'label'				=> esc_html__( "Theme Settings Setup", 'javohome' )
		, 'passed'			=> get_option( 'jvfrm_home_themes_settings' )
	),
); ?>

<div class="about-wrap jv-admin-wrap">
    <h1><?php echo$objTheme->name; ?> <?php esc_html_e( "Default Setting / System Status", 'javohome' ); ?></h1>
    <div class="about-text" style="margin-bottom: 32px;">

        <p>
			<?php esc_html_e( "Please have a look at default settings and system status. default settings is for you should complete (100%) to use our theme properly.", 'javohome' ); ?>
        </p>
    </div>

	<div class=" jv-default-setting-status-wrap">
		<h3 class="jv-default-setting-status-title">
			<?php esc_html_e( "Default Settings Status", 'javohome' ); ?>
			<div class="jv-default-setting-status-progress">
				<span><?php esc_html_e( "Loading", 'javohome' ); ?></span> <?php esc_html_e( "Completed", 'javohome' ); ?>
			</div>
		</h3>
		<div><?php esc_html_e( "These default settings should be installed or actived to make this theme work properly.", 'javohome' ); ?></div>
		<?php
		if( !empty( $arrGuideSections ) ) : foreach( $arrGuideSections as $section => $sectionMeta ) {
			$strFileName	= JVFRM_HOME_ADM_DIR . "/templates/step-{$section}.php";
			$isComplete		= $sectionMeta[ 'passed' ] ? esc_html__( "Completed", 'javohome' ) : esc_html__( "Incompleted", 'javohome' );
			$actived_class	= $sectionMeta[ 'passed' ] ? 'active' : 'active update';
			$isActived			= isset( $sectionMeta[ 'active' ] ) ? ' collapse' : null;
			echo "
				<table class=\"widefat plugins jv-default-setting-status-table{$isActived}\">
					<thead>
						<tr class='{$actived_class}'>
							<th width=\"80%\" class='check-column'><i></i>{$sectionMeta[ 'label' ]}</th>
							<th width=\"20%\" class='action-links'><i></i>{$isComplete}</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td colspan='2'>";
							if( file_exists( $strFileName ) )
								require_once $strFileName;
							echo "
							</td>
						</tr>
					</tbody>
				</table>";
		} endif;
		?>
	</div>




	<?php
    /*  ----------------------------------------------------------------------------
        Theme config
     */

    // Theme name
    default_settings_status::add('Theme config', array(
        'check_name' => 'Theme name',
        'tooltip' => '',
        'value' =>  $objTheme->get( 'Name' ),
        'status' => 'info'
    ));

    // Theme version
    default_settings_status::add('Theme config', array(
        'check_name' => 'Theme version',
        'tooltip' => '',
        'value' =>  $objTheme->get( 'Version' ),
        'status' => 'info'
    ));

    // speed booster
    if (defined('TD_SPEED_BOOSTER')) {
        if (defined('TD_SPEED_BOOSTER_INCOMPATIBLE')) {
            default_settings_status::add('Theme config', array(
                'check_name' => 'Speed Booster',
                'tooltip' => '',
                'value' =>  TD_SPEED_BOOSTER . ' - Disabled - incompatible plugin detected: <strong>' . TD_SPEED_BOOSTER_INCOMPATIBLE . '</strong>',
                'status' => 'yellow'
            ));
        } else {
            if (version_compare(TD_SPEED_BOOSTER, 'v4.0', '<')) {
                default_settings_status::add('Theme config', array(
                    'check_name' => 'Speed Booster',
                    'tooltip' => '',
                    'value' =>  TD_SPEED_BOOSTER . ' - Old version of speed booster detected. Please uninstall it!',
                    'status' => 'red'
                ));
            } else {
                default_settings_status::add('Theme config', array(
                    'check_name' => 'Speed Booster',
                    'tooltip' => '',
                    'value' =>  TD_SPEED_BOOSTER . ' - Active',
                    'status' => 'info'
                ));
            }


        }


    }



    /*  ----------------------------------------------------------------------------
        Server status
     */

    // server info
    default_settings_status::add('php.ini configuration', array(
        'check_name' => 'Server software',
        'tooltip' => '',
        'value' =>  esc_html( $_SERVER['SERVER_SOFTWARE'] ),
        'status' => 'info'
    ));

    // php version
    default_settings_status::add('php.ini configuration', array(
        'check_name' => 'PHP Version',
        'tooltip' => '',
        'value' => phpversion(),
        'status' => 'info'
    ));

    // post_max_size
    default_settings_status::add('php.ini configuration', array(
        'check_name' => 'post_max_size',
        'tooltip' => '',
        'value' =>  ini_get('post_max_size') . '<span class="jv-status-small-text"> - You cannot upload images, themes and plugins that have a size bigger than this value.</span>',
        'status' => 'info'
    ));

    // php time limit
    $max_execution_time = ini_get('max_execution_time');
    if ($max_execution_time == 0 or $max_execution_time >= 60) {
        default_settings_status::add('php.ini configuration', array(
            'check_name' => 'max_execution_time',
            'tooltip' => '',
            'value' =>  $max_execution_time,
            'status' => 'green'
        ));
    } else {
        default_settings_status::add('php.ini configuration', array(
            'check_name' => 'max_execution_time',
            'tooltip' => '',
            'value' =>  $max_execution_time . '<span class="jv-status-small-text"> - the execution time should be bigger than 60 if you plan to use the demos</span>',
            'status' => 'yellow'
        ));
    }


    // php max input vars
    $max_input_vars = ini_get('max_input_vars');
    if ($max_input_vars == 0 or $max_input_vars >= 2000) {
        default_settings_status::add('php.ini configuration', array(
            'check_name' => 'max_input_vars',
            'tooltip' => '',
            'value' =>  $max_input_vars,
            'status' => 'green'
        ));
    } else {
        default_settings_status::add('php.ini configuration', array(
            'check_name' => 'max_input_vars',
            'tooltip' => '',
            'value' =>  $max_input_vars . '<span class="jv-status-small-text"> - the max_input_vars should be bigger than 2000, otherwise it can cause incomplete saves in the menu panel in WordPress</span>',
            'status' => 'yellow'
        ));
    }

    // suhosin
    if (extension_loaded('suhosin') !== true) {
        default_settings_status::add('php.ini configuration', array(
            'check_name' => 'SUHOSIN Installed',
            'tooltip' => '',
            'value' => 'False',
            'status' => 'green'
        ));
    } else {
        default_settings_status::add('php.ini configuration', array(
            'check_name' => 'SUHOSIN Installed',
            'tooltip' => '',
            'value' =>  'SUHOSIN is installed <span class="jv-status-small-text"> - it may cause problems with saving the theme panel if it\'s not properly configured</span>',
            'status' => 'yellow'
        ));
    }







    /*  ----------------------------------------------------------------------------
        WordPress
    */
    // home url
    default_settings_status::add('WordPress and plugins', array(
        'check_name' => 'WP Home URL',
        'tooltip' => 'test tooltip',
        'value' => esc_url( home_url( '/' ) ),
        'status' => 'info'
    ));

    // site url
    default_settings_status::add('WordPress and plugins', array(
        'check_name' => 'WP Site URL',
        'tooltip' => 'test tooltip',
        'value' => site_url(),
        'status' => 'info'
    ));

    // home_url == site_url
    if (home_url() != site_url()) {
        default_settings_status::add('WordPress and plugins', array(
            'check_name' => 'Home URL - Site URL',
            'tooltip' => 'Home URL not equal to Site URL, this may indicate a problem with your WordPress configuration.',
            'value' => 'Home URL != Site URL <span class="jv-status-small-text">Home URL not equal to Site URL, this may indicate a problem with your WordPress configuration.</span>',
            'status' => 'yellow'
        ));
    }

    // version
    default_settings_status::add('WordPress and plugins', array(
        'check_name' => 'WP version',
        'tooltip' => '',
        'value' => get_bloginfo('version'),
        'status' => 'info'
    ));


    // is_multisite
    default_settings_status::add('WordPress and plugins', array(
        'check_name' => 'WP multisite enabled',
        'tooltip' => '',
        'value' => is_multisite() ? 'Yes' : 'No',
        'status' => 'info'
    ));


    // language
    default_settings_status::add('WordPress and plugins', array(
        'check_name' => 'WP Language',
        'tooltip' => '',
        'value' => get_locale(),
        'status' => 'info'
    ));



    // memory limit
    $memory_limit = default_settings_status::wp_memory_notation_to_number(WP_MEMORY_LIMIT);
    if ( $memory_limit < 67108864 ) {
        default_settings_status::add('WordPress and plugins', array(
            'check_name' => 'WP Memory Limit',
            'tooltip' => '',
            'value' => size_format( $memory_limit ) . '/request <span class="jv-status-small-text">- We recommend setting memory to at least 64MB. The theme is well tested with a 40MB/request limit, but if you are using multiple plugins that may not be enough. See: <a href="http://codex.wordpress.org/Editing_wp-config.php#Increasing_memory_allocated_to_PHP" target="_blank">Increasing memory allocated to PHP</a></span>',
            'status' => 'yellow'
        ));
    } else {
        default_settings_status::add('WordPress and plugins', array(
            'check_name' => 'WP Memory Limit',
            'tooltip' => '',
            'value' => size_format( $memory_limit ) . '/request',
            'status' => 'green'
        ));
    }


    // wp debug
    if (defined('WP_DEBUG') and WP_DEBUG === true) {
        default_settings_status::add('WordPress and plugins', array(
            'check_name' => 'WP_DEBUG',
            'tooltip' => '',
            'value' => 'WP_DEBUG is enabled',
            'status' => 'yellow'
        ));
    } else {
        default_settings_status::add('WordPress and plugins', array(
            'check_name' => 'WP_DEBUG',
            'tooltip' => '',
            'value' => 'False',
            'status' => 'green'
        ));
    }






    // caching
    $caching_plugin_list = array(
        'wp-super-cache/wp-cache.php' => array(
            'name' => 'WP super cache',
            'status' => 'green',
        ),
        'w3-total-cache/w3-total-cache.php' => array(
            'name' => 'W3 total cache (we recommend WP super cache)',
            'status' => 'yellow',
        ),
        'wp-fastest-cache/wpFastestCache.php' => array(
            'name' => 'WP Fastest Cache (we recommend WP super cache)',
            'status' => 'yellow',
        ),
    );
    $active_plugins = get_option('active_plugins');
    $caching_plugin = 'No caching plugin detected';
    $caching_plugin_status = 'yellow';
    foreach ($active_plugins as $active_plugin) {
        if (isset($caching_plugin_list[$active_plugin])) {
            $caching_plugin = $caching_plugin_list[$active_plugin]['name'];
            $caching_plugin_status = $caching_plugin_list[$active_plugin]['status'];
            break;
        }
    }
    default_settings_status::add('WordPress and plugins', array(
        'check_name' => 'Caching plugin',
        'tooltip' => '',
        'value' =>  $caching_plugin,
        'status' => $caching_plugin_status
    ));

    default_settings_status::render_tables();
    ?>




</div>



<?php
   class default_settings_status {
       static $system_status = array();
       static function add($section, $status_array) {
           self::$system_status[$section] []= $status_array;
       }


       static function render_tables() {
           foreach (self::$system_status as $section_name => $section_statuses) {
                ?>
                <table class="widefat jv-system-status-table" cellspacing="0">
                    <thead>
                        <tr>
                           <th colspan="4"><?php echo $section_name; ?></th>
                        </tr>
                    </thead>
                    <tbody>
                <?php

                    foreach ($section_statuses as $status_params) {
                        ?>
                        <tr>
                            <td class="jv-system-status-name"><?php echo $status_params['check_name']; ?></td>
                            <td class="jv-system-status-help"><!--<a href="#" class="help_tip">[?]</a>--></td>
                            <td class="jv-system-status-status">
                                <?php
                                    switch ($status_params['status']) {
                                        case 'green':
                                            echo '<div class="jv-system-status-led jv-system-status-green jv-tooltip" data-position="right" title="Green status: this check passed our system status test!"></div>';
                                            break;
                                        case 'yellow':
                                            echo '<div class="jv-system-status-led jv-system-status-yellow jv-tooltip" data-position="right" title="Yellow status: this setting may affect the backend of the site. The front end should still run as expected. We recommend that you fix this."></div>';
                                            break;
                                        case 'red' :
                                            echo '<div class="jv-system-status-led jv-system-status-red jv-tooltip" data-position="right" title="Red status: the site may not work as expected with this option."></div>';
                                            break;
                                        case 'info':
                                            echo '<div class="jv-system-status-led jv-system-status-info jv-tooltip" data-position="right" title="Info status: this is just for information purposes and easier debug if a problem appears">i</div>';
                                            break;

                                    }


                                ?>
                            </td>
                            <td class="jv-system-status-value"><?php echo ent2ncr( $status_params['value'] ); ?></td>
                        </tr>
                        <?php
                    }

                ?>
                    </tbody>
                </table>
                <?php
           }
       }
       static function wp_memory_notation_to_number( $size ) {
           $l   = substr( $size, -1 );
           $ret = substr( $size, 0, -1 );
           switch ( strtoupper( $l ) ) {
               case 'P':
                   $ret *= 1024;
               case 'T':
                   $ret *= 1024;
               case 'G':
                   $ret *= 1024;
               case 'M':
                   $ret *= 1024;
               case 'K':
                   $ret *= 1024;
           }
           return $ret;
       }
   }
?>