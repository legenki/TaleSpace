<?php
global
	$post,
	$jvfrm_home_tso,
	$jvfrm_home_headerParams,
	$jvfrm_home_tso_db;

/* Logo */{

	$post					= get_post();

	if( empty( $post ) ) {
		$post				= new stdClass();
		$post->ID			= 0;
		$post->post_type	= '';

	}

	$post_id				= $post->ID;

	// Default JavoThemes Logo
	$jvfrm_home_nav_logo = JVFRM_HOME_IMG_DIR.'/jv-logo2.png';
	$jvfrm_home_nav_logo_default_light = JVFRM_HOME_IMG_DIR.'/jv-logo1.png';
	$jvfrm_home_nav_logo_base = $jvfrm_home_nav_logo;
	$jvfrm_home_defulat_theme_logo = $jvfrm_home_nav_logo_base;
	$jvfrm_home_nav_logo_sticky	= $jvfrm_home_nav_logo;
	$jvfrm_home_nav_logo_single	= $jvfrm_home_tso->get( 'single_item_logo', false ) ;
	if($jvfrm_home_nav_logo_single == '' && $post->post_type=='property' ){
		$jvfrm_home_nav_logo_single = JVFRM_HOME_IMG_DIR.'/jv-logo1.png';
	}

	// ThemeSettings Logo
	$jvfrm_home_hd_options = get_post_meta( $post_id, 'jvfrm_home_hd_post', true );
	$jvfrm_home_post_skin = new jvfrm_home_array( $jvfrm_home_hd_options );

	// Dark Logo ( User Default upload logo )
	if(  false === ( $jvfrm_home_nav_logo_dark = $jvfrm_home_tso->get( 'logo_url', false ) ) || '' == $jvfrm_home_nav_logo_dark )
	{
		$jvfrm_home_nav_logo_dark = $jvfrm_home_nav_logo;
	}

	// Light Logo
	if(  false === ( $jvfrm_home_nav_logo_light = $jvfrm_home_tso->get( 'logo_light_url', false ) ) || '' == $jvfrm_home_nav_logo_light  )
	{
		$jvfrm_home_nav_logo_light = $jvfrm_home_nav_logo_default_light;
	}

	// Setup Default Logo
	switch( $jvfrm_home_post_skin->get("header_skin", jvfrm_home_tso()->header->get( 'header_skin', false ) ) )
	{
		case "light":	$jvfrm_home_nav_logo_base		= $jvfrm_home_nav_logo_light; break;
		case "dark":
		default:		$jvfrm_home_nav_logo_base		= $jvfrm_home_nav_logo_dark;
	}


	/* Single Post Fixed */
	if( $post->post_type === 'post' && is_single($post))
		$jvfrm_home_nav_logo_base = $jvfrm_home_nav_logo_light;

	// Setup Sticky Default Logo
	switch( $jvfrm_home_post_skin->get("sticky_header_skin", jvfrm_home_tso()->header->get( 'sticky_header_skin', false ) ) )
	{
		case "light":	$jvfrm_home_nav_logo_sticky	= $jvfrm_home_nav_logo_light; break;
		case "dark":
		default:		$jvfrm_home_nav_logo_sticky	= $jvfrm_home_nav_logo_dark;
	}
}


/* System Menu */{

	$jvfrm_home_nav_sys_buttons = Array();

	/* Logged Out */
	$jvfrm_home_nav_sys_buttons['logged_out']	= Array(
		'url'		=> esc_url( wp_logout_url( home_url( '/' ) ) )
		, 'label'	=> esc_html__("Logout", 'javohome')
	);
}



/* Quick Menu */ {

	$is_login				= is_user_logged_in();
	$jvfrm_home_this_user			= new WP_User( get_current_user_id() );
	$jvfrm_home_this_user_avatar_id	= $jvfrm_home_this_user->avatar;
	$jvfrm_home_this_user_avatar	= $jvfrm_home_tso->get('no_image', JVFRM_HOME_IMG_DIR.'/no-image.png');

	if( (boolean) $_META	= wp_get_attachment_image_src( $jvfrm_home_this_user_avatar_id, 'jvfrm-home-tiny') ) {
		$jvfrm_home_this_user_avatar	= $_META[0];
	}

	/* List Button */{
		ob_start();
		if( ! empty( $jvfrm_home_nav_sys_buttons ) ) :
			?>
			<ul class="dropdown-menu" role="menu">
				<?php
				foreach( $jvfrm_home_nav_sys_buttons as $button ) {
					echo "<li><a href=\"{$button['url']}\">{$button['label']}</a></li>";
				} ?>
			</ul>
			<?php
		endif;
		$jvfrm_home_featured_list_append = ob_get_clean();
	}

	/* List Button */{
		ob_start();
		echo "<ul class=\"widget_top_menu_wrap hidden-xs\">";
		if( function_exists( 'dynamic_sidebar' ) )
			dynamic_sidebar('menu-widget-1');

			?>
			<li><?php do_action( 'jvfrm_home_wpml_switcher' ); ?></li>
			<?php
		echo "</ul>";
		$jvfrm_home_menu_widget_append = ob_get_clean();
	}

	$jvfrm_home_featured_menus	= Array(
		'menu_widget'		=> Array(
			'enable'		=> true
			, 'li_class'	=> 'dropdown right-menus javo-navi-mylist-button'
			, 'append'		=> $jvfrm_home_menu_widget_append
		)
	);
	$jvfrm_home_featured_menus	= apply_filters( 'jvfrm_home_featured_menus_filter', $jvfrm_home_featured_menus );

	$jvfrm_home_query = new jvfrm_home_array( $jvfrm_home_hd_options );
} ?>

<header id="header-one-line" <?php echo $jvfrm_home_headerParams[ 'classes' ]; ?>>

<?php if( jvfrm_home_header()->getTopbarAllow() && false ){ ?>
<div class="javo-topbar" style="background:<?php echo $jvfrm_home_tso->get('topbar_bg_color');?>; color:<?php echo $jvfrm_home_tso->get('topbar_text_color'); ?>">
	<div class="container">
		<div class="pull-left javo-topbar-left">
			<div class="topbar-wpml">
				<?php if($jvfrm_home_tso->get('topbar_wpml_hidden')!='disabled') do_action('icl_language_selector'); ?>
			</div><!-- topbar-wpml -->
			<ul class="topbar-quickmenu">
				<li class="">
					<a href="javascript:" data-toggle="modal" data-target="#login_panel">
						<?php esc_html_e( "Submit", 'javohome' );?>
					</a>
				</li>
				<li class="visible-logged">
					<a href="<?php echo jvfrm_home_getCurrentUserPage( 'add-property' ); ?>">
						<?php esc_html_e( "Submit", 'javohome' );?>
					</a>
				</li>
				<li class="">
					<a href="javascript:" data-toggle="modal" data-target="#login_panel">
						<?php esc_html_e( "Login", 'javohome' );?>
					</a>
				</li>
				<li class="visible-logged">
					<a href="<?php echo esc_url( wp_logout_url( home_url( '/' ) ) ); ?>">
						<?php esc_html_e( "Logout", 'javohome' );?>
					</a>
				</li>
				<?php if( get_option( 'users_can_register' ) ) : ?>
				<li class="">
					<a href="javascript:" data-toggle="modal" data-target="#register_panel">
						<?php esc_html_e( "Sign up", 'javohome' );?>
					</a>
				</li>
				<?php endif; ?>
			</ul><!-- topbar-quickmenu -->
		</div>
		<div class="pull-right javo-topbar-right">
			<a href="#"><i class="fa fa-facebook"></i></a>
			<a href="#"><i class="fa fa-twitter"></i></a>
			<a href="#"><i class="fa fa-google-plus"></i></a>
			<a href="#"><i class="fa fa-instagram"></i></a>
			<a href="#"><i class="fa fa-pinterest"></i></a>
			<a href="#"><i class="fa fa-flickr"></i></a>

		</div><!-- javo-topbar-right -->
	</div><!-- container-->
</div><!-- javo-topbar -->
<?php } ?>

	<nav class="navbar javo-main-navbar javo-navi-bright<?php echo is_singular( jvfrm_home_core()->slug ) ? false : ' affix-top'; ?>">
		<div class="container">
			<div class="container-fluid">
				<div class="row">
					<!-- Brand and toggle get grouped for better mobile display -->
					<div class="navbar-header">
						<div class="pull-left visible-xs col-xs-2">
							<button type="button" class="navbar-toggle javo-mobile-left-menu" data-toggle="collapse" data-target="#javo-navibar">
								<i class="fa fa-bars"></i>
							</button>
							<?php do_action( 'jvfrm_home_header_brand_left_after') ;?>
						</div><!--"navbar-header-left-wrap-->
						<div class="pull-right visible-xs col-xs-3">
							<button type="button" class="btn javo-in-mobile <?php echo sanitize_html_class( $jvfrm_home_tso->get( 'btn_header_right_menu_trigger' ) );?>" data-toggle="offcanvas" data-recalc="false" data-target=".navmenu" data-canvas=".canvas">
								<i class="fa fa-bars"></i>
							</button>
							<?php do_action( 'jvfrm_home_header_brand_right_after') ;?>
						</div>
						<div class="navbar-brand-wrap col-xs-7 col-sm-3" >
							<div class="navbar-brand-inner">
								<a class="navbar-brand" href="<?php echo esc_url( home_url( '/' ) );?>" data-origin="<?php echo esc_attr( $jvfrm_home_headerParams['height'] );?>" style="height:<?php echo esc_attr(  $jvfrm_home_headerParams['height'] );?>;line-height:<?php echo esc_attr(  $jvfrm_home_headerParams['height'] );?>;">
									<?php

									$jvfrm_home_mobile_logo = $jvfrm_home_tso->get( 'mobile_logo_url', '' );
									if( $jvfrm_home_mobile_logo != '' )
									{
										$jvfrm_home_mobile_logo = " data-javo-mobile-src=\"{$jvfrm_home_mobile_logo}\"";
									}else{
										$jvfrm_home_mobile_logo = " data-javo-mobile-src=\"".JVFRM_HOME_IMG_DIR.'/jv-logo2.png'."\""; ;;
									}

									if( $jvfrm_home_nav_logo_single && is_single() && $post->post_type=='property' ) {
										printf( "<img src=\"{$jvfrm_home_nav_logo_single}\" data-javo-sticky-src=\"{$jvfrm_home_nav_logo_single}\" id=\"javo-header-logo\"{$jvfrm_home_mobile_logo} alt='%s'>", get_bloginfo('name'));
									}else{
										if($jvfrm_home_nav_logo_base!=''){
											// setting logos
											printf( "<img src=\"{$jvfrm_home_nav_logo_base}\" data-javo-sticky-src=\"{$jvfrm_home_nav_logo_sticky}\" id=\"javo-header-logo\"{$jvfrm_home_mobile_logo} alt='%s'>", get_bloginfo('name'));
										}else{
											printf( "<img src=\"{$jvfrm_home_defulat_theme_logo}\" data-javo-sticky-src=\"{$jvfrm_home_nav_logo_sticky}\" id=\"javo-header-logo\"{$jvfrm_home_mobile_logo} alt='%s'>", get_bloginfo('name'));
										}
									} ?>
								</a>
								<?php do_action( 'jvfrm_home_header_inner_logo_after'); ?>
							</div><!--navbar-brand-inner-->
						</div><!--navbar-brand-wrap-->
						<div class="hidden-xs col-sm-9 jv-contact-nav-widget" style="height:<?php echo esc_attr( $jvfrm_home_headerParams['height'] );?>;">
							<div class="javo-toolbars-wrap">
								<?php do_action( 'jvfrm_home_header_toolbars_body'); ?>
							</div><!-- /.container -->
						</div>

						<?php do_action( 'jvfrm_home_header_brand_wrap_after'); ?>

						<?php if((($post->post_type != 'post' || get_query_var('pn')=='member') &&"jv-nav-row-2" == $jvfrm_home_query->get("header_type", jvfrm_home_tso()->header->get( 'header_type', false ) ) )
						|| $post->post_type == 'post' && "jv-nav-row-2"== jvfrm_home_tso()->header->get( 'single_post_page_header_type', false ) ){ ?>
							<?php $post->post_type === 'post' ?>
							<div class="jv-header-banner hidden-xs col-sm-9">
								<img src="<?php echo $jvfrm_home_query->get('header_banner', jvfrm_home_tso()->header->get( 'header_banner' ) ); ?>">
							</div>
						<?php } ?>

					</div><!-- .navbar-header -->
					<!-- Collect the nav links, forms, and other content for toggling -->
					<div class="collapse navbar-collapse" id="javo-navibar">
						<?php

						$menu_class = 'nav navbar-nav navbar-left jv-nav-ul';
						
						if( "fixed-right" == $jvfrm_home_query->get("header_fullwidth", jvfrm_home_tso()->header->get( 'header_fullwidth', false ) ) 
							&& 'jv-vertical-nav' != $jvfrm_home_query->get("header_type", jvfrm_home_tso()->header->get( 'header_type', false ) ) ){
							$menu_class = 'nav navbar-nav navbar-right jv-nav-ul';
						?>
							<ul class="nav navbar-nav navbar-right hidden-xs" id="javo-header-featured-menu">
								<?php
								foreach( $jvfrm_home_featured_menus as $key => $option )
								{
									if( $option['enable'] )
									{
										echo "\n<li class=\"{$option['li_class']}\">";
	
										if( isset( $option['a_inner'] ) )
										{
											echo "\n\t<a href=\"{$option['url']}\"" . ' ';
											echo "class=\"{$option['a_class']}\"" . ' ';
											echo isset( $option['a_title'] ) ? "title=\"{$option[ 'a_title' ]}\" " : '';
											echo isset( $option['a_attribute'] ) ? $option[ 'a_attribute' ] : '';
											echo ">\n\t\t";
												echo $option['a_inner'];
											echo "\n\t</a>\n";
										}
	
										if( isset( $option[ 'append' ] ) )
											echo $option[ 'append' ];
	
										echo "\n</li>";
									}
								} ?>
							</ul>

						<?php
							wp_nav_menu( array(
								'menu_class'		=> jvfrm_home_header()->get_classes( $menu_class ),
								'theme_location'	=> 'primary',
								'depth'				=> 4,
								'container'			=> false,
								'fallback_cb'		=> 'wp_bootstrap_navwalker::fallback',
								'walker'			=> new wp_bootstrap_navwalker()
							));
						}else{
							wp_nav_menu( array(
								'menu_class'		=> jvfrm_home_header()->get_classes( $menu_class ),
								'theme_location'	=> 'primary',
								'depth'				=> 4,
								'container'			=> false,
								'fallback_cb'		=> 'wp_bootstrap_navwalker::fallback',
								'walker'			=> new wp_bootstrap_navwalker()
							)); ?>
	
							<?php do_action( 'jvfrm_home_header_logo_after' ); ?>
	
							<ul class="nav navbar-nav navbar-right hidden-xs" id="javo-header-featured-menu">
								<?php
								foreach( $jvfrm_home_featured_menus as $key => $option )
								{
									if( $option['enable'] )
									{
										echo "\n<li class=\"{$option['li_class']}\">";
	
										if( isset( $option['a_inner'] ) )
										{
											echo "\n\t<a href=\"{$option['url']}\"" . ' ';
											echo "class=\"{$option['a_class']}\"" . ' ';
											echo isset( $option['a_title'] ) ? "title=\"{$option[ 'a_title' ]}\" " : '';
											echo isset( $option['a_attribute'] ) ? $option[ 'a_attribute' ] : '';
											echo ">\n\t\t";
												echo $option['a_inner'];
											echo "\n\t</a>\n";
										}
	
										if( isset( $option[ 'append' ] ) )
											echo $option[ 'append' ];
	
										echo "\n</li>";
									}
								} ?>
							</ul>
						<?php } ?>
						<div class="navbar-mobile">
							<ul class="navbar-modile-nav">
								<li class="nav-item">
									<?php if( ! is_user_logged_in() ) : ?>
										<a href="javascript:" data-toggle="modal" data-target="#login_panel">
											<?php esc_html_e( "Login", 'javohome' );?>
										</a>
									<?php else: ?>
										<a href="<?php echo esc_url( wp_logout_url( home_url( '/' ) ) ); ?>">
											<?php esc_html_e( "Logout", 'javohome' );?>
										</a>
									<?php endif; ?>
								</li>
								<li class="nav-item">
									<?php if( ! is_user_logged_in() ) : ?>
										<a href="javascript:" data-toggle="modal" data-target="#login_panel">
											<?php esc_html_e( "Submit", 'javohome' );?>
										</a>
									<?php else: ?>
										<a href="<?php echo jvfrm_home_getCurrentUserPage( 'add-property' ); ?>">
											<?php esc_html_e( "Submit", 'javohome' );?>
										</a>
									<?php endif; ?>
								</li>
							</ul>
						</div>

					</div><!-- /.navbar-collapse -->
				</div><!--/.row-->
			</div><!-- /.container-fluid -->
		</div>
	</nav>
</header>