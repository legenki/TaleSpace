<?php
class Jv_WPML_func
{
	static $__SWITCH_LOADED__;

	public function __construct()
	{
		add_action( 'jvfrm_home_wpml_switcher'		, Array( __CLASS__, 'switcher' ) );
		add_action( 'wp_footer'					, Array( __CLASS__, 'scripts' ) );
	}

	public static function switcher()
	{

		self::$__SWITCH_LOADED__ = true;

		if( ! function_exists('icl_get_languages' )  )
			return;

		if( ! defined( 'ICL_LANGUAGE_CODE' ) )
			return;

		if( false === (boolean)( $jvfrm_home_wpml_langs = icl_get_languages('skip_missing=0') ) )
			return;

		if( false === (boolean)( $jvfrm_home_cur_flag_url = $jvfrm_home_wpml_langs[ ICL_LANGUAGE_CODE ]['country_flag_url'] ) )
			return;

		ob_start();
		?>
		<div id="javo-wpml-switcher" class="inline-block">
			<button class="btn btn-primary admin-color-setting">
				<img src="<?php echo esc_attr( $jvfrm_home_cur_flag_url );?>">
			</button>
			<div>
				<ul class="javo-wpml-switcher-languages">
					<?php
					if( !empty( $jvfrm_home_wpml_langs ) )
						foreach( $jvfrm_home_wpml_langs as $lang )
						{
							echo "\t<li class=\"btn btn-default\" style=\"display:block;\">\n
									\t<a href=\"{$lang['url']}\">\n
										\t<img src=\"{$lang['country_flag_url']}\">\n
									\t</a>\n
								\t</li>\n";
						}
					?>
				</ul>
			</div>
		</div>
		<?php

		ob_end_flush();
	}

	public static function scripts()
	{
		if( ! self::$__SWITCH_LOADED__ )
			return;

		wp_enqueue_script( 'javo-widget-script' );
	}
}
new Jv_WPML_func();