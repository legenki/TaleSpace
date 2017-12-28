<?php
/************************************************
**	Ajax Process
************************************************/
class jvfrm_home_ajax_propcess{


	private static $instance =null;

	public function __construct()
	{

		// lister contact mail
		add_action("wp_ajax_nopriv_send_mail", Array($this, "send_mail"));
		add_action("wp_ajax_send_mail", Array($this, "send_mail"));

		// Register
		add_action("wp_ajax_nopriv_register_login_add_user", Array($this, "add_user_callback"));
		add_action("wp_ajax_register_login_add_user", Array($this, "add_user_callback"));

		add_action("wp_ajax_nopriv_jvfrm_home_ajax_user_login"	, Array($this, "jvfrm_home_ajax_user_login"));
		add_action("wp_ajax_jvfrm_home_ajax_user_login"			, Array($this, "jvfrm_home_ajax_user_login"));
	}

	public function add_user_callback()
	{
		$jvfrm_home_query = new jvfrm_home_array( $_POST );
		$jvfrm_home_this_result = Array();
		$jvfrm_home_new_user_args = Array('user_pass'=>null);

		if( isset( $_POST['user_login'] ) ){
			$jvfrm_home_new_user_args['user_login'] = $jvfrm_home_query->get('user_login');
		}
		if( isset( $_POST['user_name'] ) ){
			$jvfrm_home_user_fullname	 = (Array) @explode(' ', $_POST['user_name']);

			$jvfrm_home_new_user_args['first_name'] = $jvfrm_home_user_fullname[0];

			if(
				!empty( $jvfrm_home_user_fullname[1] ) &&
				$jvfrm_home_user_fullname[1] != ''
			){
				$jvfrm_home_new_user_args['last_name'] = $jvfrm_home_user_fullname[1];
			}
		}

		if( isset( $_POST['first_name'] ) ){
			$jvfrm_home_new_user_args['first_name'] = $jvfrm_home_query->get('first_name');
		}
		if( isset( $_POST['last_name'] ) ){
			$jvfrm_home_new_user_args['last_name'] = $jvfrm_home_query->get('last_name');
		}
		if( isset( $_POST['user_pass'] ) ){
			$jvfrm_home_new_user_args['user_pass'] = $jvfrm_home_query->get('user_pass');

		}else{
			// Password is Empty ???
			$jvfrm_home_new_user_args['user_pass'] = wp_generate_password( 12, false );
		}
		if( isset( $_POST['user_login'] ) ){
			$jvfrm_home_new_user_args['user_email'] = $jvfrm_home_query->get('user_email');
			if( !is_email( $jvfrm_home_new_user_args['user_email'] ) )
				$jvfrm_home_this_result[ 'err' ]		= __( "Your email address is invalid. Please enter a valid address.", 'javohome' );
		}
		if(!isset($jvfrm_home_this_result[ 'err' ])){
			$user_id = wp_insert_user($jvfrm_home_new_user_args, true);
			if( !is_wp_error($user_id)){
				update_user_option( $user_id, 'default_password_nag', true, true );
				wp_new_user_notification($user_id, $jvfrm_home_new_user_args['user_pass']);
	
				// Assign Post
				if( isset( $_POST['post_id'] ) && (int)$_POST['post_id'] > 0 ){
					$origin_post_id		= (int) $_POST['post_id'];
					$parent_post_id		= (int)get_post_meta( $origin_post_id, 'parent_post_id', true);
	
					$post_id = wp_update_post(Array(
						'ID'			=> $parent_post_id
						, 'post_author'	=> $user_id
					));
	
					update_post_meta($origin_post_id	, 'approve', 'approved');
					update_post_meta($post_id			, 'claimed', 'yes');
				}else{
					wp_set_current_user( $user_id );
					wp_set_auth_cookie( $user_id );
					do_action( 'wp_login', $user_id, get_user_by( 'id', $login_state ) );
				}
	
				do_action( 'jvfrm_home_new_user_append_meta', $user_id );
				$jvfrm_home_this_result['state'] = 'success';
				$jvfrm_home_this_result['link'] = jvfrm_home_getCurrentUserPage();
	
			}else{
				$jvfrm_home_this_result['state']		= 'failed';
				$jvfrm_home_this_result['comment']	= $user_id->get_error_message();
			}
		}else{
			$jvfrm_home_this_result['state']		= 'failed';
			$jvfrm_home_this_result['comment']	= $jvfrm_home_this_result[ 'err' ];
		}
		echo json_encode($jvfrm_home_this_result);
		exit;
	}

	static function send_mail_content_type(){ return 'text/html';	}
	public function send_mail(){
		$jvfrm_home_query					= new jvfrm_home_array( $_POST );
		$jvfrm_home_this_return			= Array();
		$jvfrm_home_this_return['result'] = false;
		$meta = Array(
			'to'					=> $jvfrm_home_query->get('to', NULL)
			, 'subject'				=> $jvfrm_home_query->get('subject', esc_html__('Untitled Mail', 'javohome')).' : '.get_bloginfo('name')
			, 'from'				=> sprintf("From: %s<%s>\r\n"
										, get_bloginfo('name')
										, $jvfrm_home_query->get('from', get_option('admin_email') )
									)
			, 'content'				=> $jvfrm_home_query->get('content', NULL)
		);

		if(
			$jvfrm_home_query->get('to', NULL) != null &&
			$jvfrm_home_query->get('from', NULL) != null
		){
			add_filter( 'wp_mail_content_type', Array(__CLASS__, 'send_mail_content_type') );
			$mailer = wp_mail(
				$meta['to']
				, $meta['subject']
				, $meta['content']
				, $meta['from']
			);
			$jvfrm_home_this_return['result'] = $mailer;
			remove_filter( 'wp_mail_content_type', Array(__CLASS__, 'send_mail_content_type'));
		};

		echo json_encode($jvfrm_home_this_return);
		exit(0);
	}

	public function getLoginRedirectURL( $user_id=0 ){

		$objUser = get_user_by( 'id', $user_id );

		switch( jvfrm_home_tso()->get('login_redirect', '') ) {

			// Go to the Main Page
			case 'home' : return esc_url( home_url( '/' ) ); break;

			// Everything no working
			case 'current' : return '#'; break;

			// Go to the Profile Page
			case 'admin' : return admin_url(); break;
			default: return jvfrm_home_getCurrentUserPage();

		}
	}

	public function jvfrm_home_ajax_user_login() {

		header( 'content-type:application/json; charset=utf-8' );

		check_ajax_referer( 'user_login', 'security' );

		$response		= Array();

		$query			= new jvfrm_home_array( $_POST );

		$login_state	= wp_signon(
			Array(
				'user_login' => $query->get( 'log' ),
				'user_password'	=> $query->get( 'pwd' ),
				'remember'		=> $query->get( 'rememberme' )
			),
			false
		);

		if( is_wp_error( $login_state ) ) {
			$response[ 'error' ]	= $login_state->get_error_message();
		}else{
			wp_set_current_user( $login_state->ID );
			wp_set_auth_cookie( $login_state->ID );
			do_action( 'wp_login', $login_state->user_login, $login_state );
			$response[ 'redirect' ] = $this->getLoginRedirectURL( $login_state->ID );
			$response[ 'state' ]	= 'OK';
		}
		die( json_encode( $response ) ) ;
	}

	public static function getInstance() {
		if( is_null( self::$instance ) )
			self::$instance = new self;
		return self::$instance;
	}

}

if( !function_exists( 'jvfrm_home_process' ) ) : function jvfrm_home_process() {
	return jvfrm_home_ajax_propcess::getInstance();
} jvfrm_home_process(); endif;