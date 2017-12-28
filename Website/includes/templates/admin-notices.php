<?php
/**
 *
 *
 * @description includes / class-core.php
 * @author javoThemes
 * @param $jvfrm_home_admin_notices array
 *
 */
if( !empty( $jvfrm_home_admin_notices ) ) : foreach( $jvfrm_home_admin_notices as $strMeta ) {

	$strLevel = isset( $strMeta[ 'level' ] ) ? $strMeta[ 'level' ] : false;
	$strSubject = isset( $strMeta[ 'title' ] ) ? '<h3>' . $strMeta[ 'title' ] . '</h3>' : false;
	$strMessage = isset( $strMeta[ 'message' ] ) ? $strMeta[ 'message' ] : false;

	switch( $strLevel ) {
		case 'warning': $strClass = 'notice-warning'; break;
		case 'error': $strClass = 'notice-error'; break;
		case 'success': default: $strClass = 'notice-success'; break;
		case 'info': default: $strClass = 'notice-info'; break;
	}
	printf(
		'<div class="notice %1$s">%2$s%3$s</div>',
		$strClass,
		$strSubject,
		$strMessage
	);
} endif;