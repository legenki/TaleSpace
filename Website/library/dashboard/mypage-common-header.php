<?php
$jvfrm_home_this_user = wp_get_current_user();

if( isset( $_POST[ 'jvfrm_home_dashboard_changepw_nonce' ] ) && wp_verify_nonce( $_POST[ 'jvfrm_home_dashboard_changepw_nonce' ], 'security' ) )
	jvfrm_home_dashboard_change_pw();

function jvfrm_home_dashboard_change_pw()
{
	try{

		$query						= new jvfrm_home_array( $_POST );
		$current_password			= $query->get( 'current_pass' );
		$new_password				= $query->get( 'new_pass' );
		$new_password_confirm		= $query->get( 'new_pass_confirm' );

		$current_user			= wp_signon(
			Array(
				'user_login'		=> wp_get_current_user()->user_login
				, 'user_password'	=> $current_password
			)
		);

		if( is_wp_error( $current_user ) )
			throw new Exception( $current_user->get_error_message() );

		if( $new_password == '' || $new_password_confirm == '' )
			throw new Exception( esc_html__( "Please check your password or password confirm.", 'javohome' ) );


		if( $new_password != $new_password_confirm )
			throw new Exception( esc_html__( "The new password and password confirm does not match.", 'javohome' ) );

		if( $result = wp_update_user( Array( 'ID' => $current_user->ID, 'user_pass' => $new_password ) ) )
			if( is_wp_error( $result ) )
				throw new Exception( $result->get_error_message() );

	} catch( Exception $e ) {
		$GLOBALS[ 'jvfrm_home_change_message' ]	= Array( 'e', $e->getMessage() );
		return;
	}

	$GLOBALS[ 'jvfrm_home_change_message' ]		= Array( 'o',esc_html__( "It has been successfully changed,", 'javohome' ) );
}