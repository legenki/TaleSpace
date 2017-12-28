<?php

class jvfrm_home_basic_shortcode
{
	public static $instance = null;

	public $is_logged = false;

	public $shortcodes = Array();

	public function __construct(){ $this->init();	 }

	public function init() {
		$this->is_logged = is_user_logged_in();

		$this->addBasicScodes();
		add_filter( 'jvfrm_home_other_shortcode_array', Array( $this, 'createShortcode' ) );
	}

	public function add( $scodeName='', $func=Array() ){
		$this->shortcodes[ $scodeName ] = $func;
	}

	public function createShortcode( $shortcodes=Array() ) {
		$this->shortcodes = (array) apply_filters( 'jvfrm_home_basic_shortcode_array', $this->shortcodes );
		return wp_parse_args( $this->shortcodes, $shortcodes );
	}

	public function addBasicScodes() {
		$this->add( 'jvfrm_home_mypage_button', Array( $this, 'mypage_button' ) );
		$this->add( 'jvfrm_home_submit_button', Array( $this, 'submit_button' ) );
		$this->add( 'jvfrm_home_join_button', Array( $this, 'join_button' ) );
		$this->add( 'jvfrm_home_join_form', Array( $this, 'join_form' ) );
	}

	public function mypage_button( $atts, $content='' ) {

		$options = shortcode_atts(
			Array(
				'before' => __( "Login", 'javohome' ),
				'after' => __( "My Page", 'javohome' ),
			), $atts
		);
		return $this->createLinkButton(
			Array(
				'label' => !$this->is_logged ? $options[ 'before' ] : $options[ 'after' ],
				'modal' => !$this->is_logged ? '#login_panel' : false,
				'link' => !$this->is_logged ? 'javascript:' : jvfrm_home_getCurrentUserPage()
			)
		);
	}

	public function submit_button( $atts, $content='' ){
		$options = shortcode_atts(
			Array(
				'before' => __( "Login", 'javohome' ),
				'after' => __( "Submit", 'javohome' ),
			), $atts
		);

		$strSlug = 'add-' . jvfrm_home_core()->slug;

		return $this->createLinkButton(
			Array(
				'label' => !$this->is_logged ? $options[ 'before' ] : $options[ 'after' ],
				'modal' => !$this->is_logged ? '#login_panel' : false,
				'link' => !$this->is_logged ? 'javascript:' : jvfrm_home_getCurrentUserPage( $strSlug )
			)
		);
	}

	public function join_button( $atts, $content='' ){
		$options = shortcode_atts(
			Array(
				'before' => __( "Register", 'javohome' ),
				'after' => __( "Submit", 'javohome' ),
			), $atts
		);

		$strSlug = 'add-' . jvfrm_home_core()->slug;

		return $this->createLinkButton(
			Array(
				'label' => !$this->is_logged ? $options[ 'before' ] : $options[ 'after' ],
				'class' => !$this->is_logged ? false : 'hidden',
				'modal' => !$this->is_logged ? '#register_panel' : false,
			)
		);
	}

	public function createLinkButton( $args=Array() ) {

		$args = shortcode_atts(
			Array(
				'button' => true,
				'class' => false,
				'label' => __( "Login", 'javohome' ),
				'link' => '',
				'modal' => false,
			), $args
		);

		$classes = $append = Array();

		$classes[] = $args[ 'button' ] ? 'btn btn-primary' : false;

		if( $args[ 'class' ] )
			$classes[] = $args[ 'class' ];

		if( $args[ 'modal' ] ) {
			$append[] = 'data-toggle="modal"';
			$append[] = sprintf( 'data-target="%s"', $args[ 'modal' ] );
		}

		return sprintf(
			'<a href="%1$s" class="%2$s" %3$s>%4$s</a>',
			$args[ 'link' ],
			join( ' ', $classes ),
			join( ' ', $append ),
			$args[ 'label' ]
		);
	}

	public function join_form( $args, $content='' ) {
		$options = shortcode_atts(
			Array(
				'close_button' => false,
			), $args
		);

		return $this->createJoinForm( $options );
	}

	public function createJoinForm( $options=Array() ) {
		ob_start();
			?>
			<form data-javo-modal-register-form>
				
				<div class="modal-body">
					<?php do_action( 'jvfrm_home_register_form_before' ); ?>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label class="" for="reg-username"><?php esc_html_e('Username', 'javohome');?></label>
								<input type="text" id="reg-username" name="user_login" class="form-control" required="" placeholder="<?php esc_attr_e( 'Username', 'javohome' );?>">
							</div>
						</div><!-- /.col-md-6 -->
						<div class="col-md-6">
							<div class="form-group">
								<label class="" for="reg-email"><?php esc_html_e('Email Address', 'javohome');?></label>
								<input type="text" id="reg-email" name="user_email" class="form-control" required="" placeholder="<?php esc_attr_e( 'Your email', 'javohome' );?>">
							</div>
						</div><!-- /.col-md-6 -->
					</div><!-- /.row -->
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label class="" for="firstname"><?php esc_html_e('First Name', 'javohome');?></label>
								<input type="text" id="firstname" name="first_name" class="form-control" required="" placeholder="<?php esc_attr_e( 'Your first name', 'javohome' );?>">

							</div>
						</div><!-- /.col-md-6 -->
						<div class="col-md-6">
							<div class="form-group">
								<label class="" for="lastname"><?php esc_html_e('Last Name', 'javohome');?></label>
								<input type="text" id="lastname" name="last_name" class="form-control" required="" placeholder="<?php esc_attr_e( 'Your last name', 'javohome' );?>">

							</div>
						</div><!-- /.col-md-6 -->
					</div><!-- /.row -->
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label class="" for="reg-password"><?php esc_html_e('Password', 'javohome');?></label>
								<input type="password" id="reg-password" name="user_pass" class="form-control" required="" placeholder="<?php esc_attr_e( 'Desired Password', 'javohome' );?>">

							</div>
						</div><!-- /.col-md-6 -->
						<div class="col-md-6">
							<div class="form-group">
								<label class="" for="reg-con-password"><?php esc_html_e('Confirm Password', 'javohome');?></label>
								<input type="password" id="reg-con-password" name="user_con_pass" class="form-control" required="" placeholder="<?php esc_attr_e( 'Confirm Password', 'javohome' );?>">

							</div>
						</div><!-- /.col-md-6 -->
					</div><!-- /.row -->
					<?php do_action( 'jvfrm_home_register_form_after' ); ?>
				</div>

				<div class="modal-footer">

					<?php
					if( $agree_page = jvfrm_home_tso()->get( 'agree_register', 0 ) )
					{
						echo "<div class=\"row\">";
							echo "<div class=\"col-md-12\">";
								echo "<div class=\"checkbox\">";
									echo "<label>";
										echo "<input type=\"checkbox\" class=\"javo-register-agree\">";
										printf(
											"<a href=\"%s\">%s</a>"
											, apply_filters( 'jvfrm_home_wpml_link', $agree_page )
											, esc_html__( "I agree with the terms and conditions.", 'javohome' )
										);
									echo "</label>";
								echo "</div>";
							echo "</div>";
						echo "</div>";
					} ?>

					<div class="row">
						<div class="col-md-4 hidden-xs col-xs-4 text-left">
							<?php echo $this->submit_button( Array(), null ); ?>
							<!-- a href="#" data-toggle="modal" data-target="#login_panel" class="btn btn-default javo-tooltip" title="" data-original-title="Log-In"><?php esc_html_e('LOG IN', 'javohome' ); ?></a -->

						</div><!-- /.col-md-4 -->
						<div class="col-md-8 text-right">
							<input type="hidden" name="action" value="register_login_add_user">
							<button type="submit" id="signup" name="submit" class="btn btn-primary"><?php esc_html_e('Create My Account', 'javohome');?></button> &nbsp;
							<?php
							if( $options[ 'close_button' ] )
								printf( '<button type="button" class="btn btn-default" data-dismiss="modal">%1$s</button>', esc_html__('Close', 'javohome') );
							?>
						</div><!-- /.col-md-8 -->
					</div><!-- /.row -->
				</div>
			</form>
		<?php
		return ob_get_clean();
	}


	public static function getInstance(){
		if( is_null( self::$instance ) )
			self::$instance = new self;
		return self::$instance;
	}
}

if( !function_exists( 'jvfrm_home_basic_scode' ) ) : function jvfrm_home_basic_scode(){
	return jvfrm_home_basic_shortcode::getInstance();
} jvfrm_home_basic_scode(); endif;