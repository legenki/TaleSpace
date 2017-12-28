<?php
function jvfrm_home_getUserPage( $user_id, $slug='', $closechar='/' ) {

	$arrDashboard	= Array();

	$arrDashboard[]	= defined( 'JVFRM_HOME_DEF_LANG' ) ?
		JVFRM_HOME_DEF_LANG . JVFRM_HOME_MEMBER_SLUG :
		JVFRM_HOME_MEMBER_SLUG;

	$arrDashboard[]	= get_user_by( 'id', intVal( $user_id ) )->user_login;

	if( !empty( $slug ) )
		$arrDashboard[] = strtolower( $slug );

	$strDashboard	= @implode( '/', $arrDashboard );

	return esc_url( home_url( $strDashboard . $closechar ) );
}

function jvfrm_home_getDashboardUser() {
	return get_user_by('login', str_replace("%20", " ", get_query_var('user')));
}

function jvfrm_home_getCurrentUserPage( $slug='', $closechar='/' ){
	return jvfrm_home_getUserPage( get_current_user_id(), $slug, $closechar );
}
function jvfrm_home_getMypageSidebar() {

	$arrMyMenus		= apply_filters(
		'jvfrm_home_mypage_sidebar_args'
		, Array(
			Array(
				'li_class'		=> 'side-menu home'
				, 'url'			=> jvfrm_home_getCurrentUserPage()
				, 'icon'		=> 'fa fa-tachometer'
				, 'label'		=> esc_html__("DASHBOARD", 'javohome')
			)
			, Array(
				'li_class'		=> 'side-menu home'
				, 'url'			=> jvfrm_home_getCurrentUserPage( JVFRM_HOME_PROFILE_SLUG )
				, 'icon'		=> 'fa fa-user'
				, 'label'		=> esc_html__("Edit Profile", 'javohome')
			)
		)
	);

	$strNavItemClass = jvfrm_home_dashboard()->page_style != 'type-c' ? 'admin-color-setting' : NULL;

	echo "<ul class=\"nav nav-sidebar\">";
	if( !empty( $arrMyMenus ) ) foreach( $arrMyMenus as $menuMeta )
		echo "
			<li class=\"nav-item {$menuMeta['li_class']}\">
				<a href=\"{$menuMeta['url']}\" class=\"{$strNavItemClass}\">
					<i class=\"{$menuMeta['icon']}\"></i> &nbsp;
					{$menuMeta['label']}
				</a>
			</li>";
	echo "</ul>";
}

if( !function_exists( 'jvfrm_home_dashboard_msg' ) ) : function jvfrm_home_dashboard_msg(){
	return $GLOBALS[ 'jvfrm_home_change_message' ];
} endif;