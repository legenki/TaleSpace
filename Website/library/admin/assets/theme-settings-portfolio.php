<?php
$jvfrm_home_options = Array(
	'header_type' => apply_filters( 'jvfrm_home_options_header_types', Array() )
	, 'header_skin' => Array(
		esc_html__("Dark", 'javohome')							=> ""
		, esc_html__("Light", 'javohome')						=> "light"
	)
	, 'able_disable' => Array(
		esc_html__("Disable", 'javohome')					=> "disabled"
		,esc_html__("Able", 'javohome')							=> "enable"

	)
	, 'header_fullwidth' => Array(
		esc_html__("Center Left", 'javohome')						=> "fixed"
		, esc_html__("Center Right", 'javohome')			=> "fixed-right"
		, esc_html__("Wide", 'javohome')						=> "full"
	)
	, 'header_relation' => Array(
		esc_html__("Transparency menu", 'javohome')	=> "absolute"
		,esc_html__("Default menu", 'javohome')				=> "relative"
	)
	, 'portfolio_detail_page_head_style' => Array(
		esc_html__("Featured image with Title", 'javohome')	=> "featured_image"
		,esc_html__("Title on the top", 'javohome')	=> "title_on_top"
		,esc_html__("Title upper content ", 'javohome')				=> "title_upper_content"
	)

	, 'portfolio_detail_page_layout' => Array(
		esc_html__("Full Width - Content After", 'javohome')					=> "fullwidth-content-after"
		,esc_html__("Full Width - Content Before", 'javohome')					=> "fullwidth-content-before"
		,esc_html__("Right - Side Bar", 'javohome')					=> "right-sidebar"

	)
); ?>

<div class="jvfrm_home_ts_tab javo-opts-group-tab hidden" tar="portfolio">
	<h2><?php esc_html_e("Portfolio Page Settings", 'javohome'); ?> </h2>
	<table class="form-table">
	
	<tr><th>
		<?php esc_html_e( "Header / Menu", 'javohome');?>
		<span class="description"></span>
	</th><td>		

		<h4><?php esc_html_e( "Detail Page Menu", 'javohome'); ?></h4><hr>
		<fieldset class="inner">
			<dl>
				<dt><?php esc_html_e( "Navi Type", 'javohome');?></dt>
				<dd>
					<select name="jvfrm_home_ts[hd][portfolio_header_relation]">
						<?php
						foreach( $jvfrm_home_options['header_relation'] as $label => $value )
						{
							printf( "<option value='{$value}' %s>{$label}</option>", selected( $value == jvfrm_home_tso()->header->get("portfolio_header_relation"), true, false ) );
						} ?>
					</select>
					<div class="description"><?php esc_html_e("Caution: If you choose transparent menu type, page's main text contents ascends as much as menu's height to make menu transparent.", 'javohome');?></div>
				</dd>
			</dl>

			<dl>
				<dt><?php esc_html_e( "Background Color", 'javohome');?></dt>
				<dd>
					<input name="jvfrm_home_ts[portfolio_page_menu_bg_color]" type="text" value="<?php echo esc_attr( $jvfrm_home_tso->get( 'portfolio_page_menu_bg_color' ) );?>" class="wp_color_picker" data-default-color="#000000">
				</dd>
			</dl>

			<dl>
				<dt><?php esc_html_e( "Text Color", 'javohome');?></dt>
				<dd>
					<input name="jvfrm_home_ts[portfolio_page_menu_text_color]" type="text" value="<?php echo esc_attr( $jvfrm_home_tso->get( 'portfolio_page_menu_text_color' ) );?>" class="wp_color_picker" data-default-color="#ffffff">
				</dd>
			</dl>

			<dl>
				<dt><?php esc_html_e( "Initial Header Transparency", 'javohome');?></dt>
				<dd>
					<input type="text" name="jvfrm_home_ts[hd][portfolio_header_opacity]" value="<?php echo esc_attr( jvfrm_home_tso()->header->get("portfolio_header_opacity", 0 ) );?>">
					<div class="description"><?php esc_html_e("Please enter numerical value from 0.0 to 1.0. The higher the value you enter, the more opaque it will be. Ex. 1=opaque, 0= invisible.", 'javohome');?></div>
				</dd>
			</dl>
		</fieldset>

		<h4><?php esc_html_e( "Header Style", 'javohome'); ?></h4>
		<fieldset class="inner">
			<dl>
				<dt><?php esc_html_e("Header type", 'javohome'); ?></dt>
				<dd>
					<select name="jvfrm_home_ts[hd][portfolio_detail_page_head_style]">
						<?php
						foreach( $jvfrm_home_options['portfolio_detail_page_head_style'] as $label => $value )
						{
							printf( "<option value='{$value}' %s>{$label}</option>", selected( $value == jvfrm_home_tso()->header->get("portfolio_detail_page_head_style"), true, false ) );
						} ?>
					</select>
					<div class="description"><?php esc_html_e("Caution: If you choose transparent menu type, page's main text contents ascends as much as menu's height to make menu transparent.", 'javohome');?></div>					
				</dd>
			</dl>
		</fieldset>
	</td></tr>


	<tr>
		<th>
			<?php esc_html_e( "Default Style", 'javohome');?>
			<span class="description"></span>
		</th>
		<td>		
		<h4><?php esc_html_e( "Setup Portfolio List Page", 'javohome'); ?></h4>
		<fieldset class="inner">
			<select name="jvfrm_home_ts[portfolio_list_page]">
				<?php
				if( $pages = get_posts( "post_type=page&post_status=publish&posts_per_page=-1&suppress_filters=0" ) )
				{
					printf( "<optgroup label=\"%s\">", esc_html__( "Select a page for portfolio list", 'javohome' ) );
					foreach( $pages as $post )
						printf(
							"<option value=\"{$post->ID}\" %s>{$post->post_title}</option>"
							, selected( $post->ID == $jvfrm_home_tso->get( 'portfolio_list_page', '' ), true, false )
						);
					echo "</optgroup>";
				} ?>
			</select>
		</fieldset>

		<h4><?php esc_html_e( "Default Page Layout", 'javohome'); ?></h4>
		<fieldset class="inner">
			<select name="jvfrm_home_ts[hd][portfolio_detail_page_layout]">
						<?php
						foreach( $jvfrm_home_options['portfolio_detail_page_layout'] as $label => $value )
						{
							printf( "<option value='{$value}' %s>{$label}</option>", selected( $value == jvfrm_home_tso()->header->get("portfolio_detail_page_layout"), true, false ) );
						} ?>
					</select>
					<div class="description"><?php esc_html_e("Caution: If you choose transparent menu type, page's main text contents ascends as much as menu's height to make menu transparent.", 'javohome');?></div>		
		</fieldset>
		</td>
	</tr>
	</table>
</div>