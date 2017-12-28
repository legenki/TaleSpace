<div class="jv-welcome-wrap">

<?php
		printf( "<h1>%s <span class='welcome-msg-version'>Version %s</span></h1>", $this->name, $this->theme->get( 'Version' ) );
?>

<div class="welcome-des jv-float-left">
	<?php esc_html_e('Are you first time to use our theme?If you are new to use this theme, please check your status.', 'javohome'); ?>

	<ul>
		<li><?php esc_html_e('1.If you are new to use this theme, please check your status.', 'javohome'); ?></li>
		<li><?php esc_html_e('2.Install and ative plugins.', 'javohome'); ?></li>
		<li><?php esc_html_e('3.Import demo data. (optional)', 'javohome'); ?></li>
		<li><?php esc_html_e('4.Check theme settings and setup.', 'javohome'); ?></li>
	</ul>

</div> <!-- jv-welcome-wrap-left -->
<div class="welcome-image jv-float-left"><img src="<?php echo get_template_directory_uri(); ?>/screenshot.png" width="300"></div> <!-- jv-welcome-wrap-left -->
<div class="clear"></div>


</div> <!-- jv-welcome-wrap -->