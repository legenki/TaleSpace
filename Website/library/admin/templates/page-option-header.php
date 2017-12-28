<?php
$jvfrm_home_fancy_dft_opt						= Array(
	'repeat'							=> Array(
		esc_html__("no-repeat", 'javohome')		=> 'no-repeat'
		, esc_html__("repeat-x", 'javohome')		=> 'repeat-x'
		, esc_html__("repeat-y", 'javohome')		=> 'repeat-y'
	)
	, 'background-position-x'			=> Array(
		esc_html__("Left", 'javohome')			=> 'left'
		, esc_html__("Center", 'javohome')		=> 'center'
		, esc_html__("Right", 'javohome')		=> 'right'
	)
	, 'background-position-y'			=> Array(
		esc_html__("top", 'javohome')			=> 'top'
		, esc_html__("Center", 'javohome')		=> 'center'
		, esc_html__("Bottom", 'javohome')		=> 'bottom'
	)
);

// Fancy Option
$get_jvfrm_home_opt_fancy			= get_post_meta( $post->ID, 'jvfrm_home_header_fancy_type', true );
$jvfrm_home_fancy_opts				= get_post_meta( $post->ID, 'jvfrm_home_fancy_options', true );
$jvfrm_home_fancy						= new jvfrm_home_array( $jvfrm_home_fancy_opts );

// Slide Option
$jvfrm_home_slider						= maybe_unserialize( get_post_meta( $post->ID, 'jvfrm_home_slider_options', true ) );
$get_jvfrm_home_opt_slider			= maybe_unserialize( get_post_meta( $post->ID, 'jvfrm_home_slider_type', true ) );

$strOutputSliderLists			= Array();

if( class_exists( 'RevSlider' ) ) :
	$objSlideRevolution		= new RevSlider;
	$valCurrentSlider			= !empty( $jvfrm_home_slider[ 'rev_slider' ] ) ? $jvfrm_home_slider[ 'rev_slider' ] : null;
	$arrSliderItems				= ( Array ) $objSlideRevolution->getArrSliders();
	$strOutputSliderLists[]	='<select name="jvfrm_home_slide[rev_slider]">';
	$strOutputSliderLists[]	= sprintf( "<option value=''>%s</option>", esc_html__( "Select Slider", 'javohome' ) );
	if( !empty( $arrSliderItems ) ) : foreach( $arrSliderItems as $slider ) {
		$strOutputSliderLists[] = sprintf(
			'<option value="%s"%s>%s</option>',
			$slider->getAlias(),
			selected( $slider->getAlias() == $valCurrentSlider, true, false ),
			$slider->getTitle()
		);
	} else:
		$strOutputSliderLists[]	= sprintf( "<optgroup label=\"%s\"></optgroup>", esc_html__( "Empty Slider", 'javohome' ) );
	endif;
	$strOutputSliderLists[]	='</select>';
else:
	$strOutputSliderLists[]	= sprintf(
		'<label>%s</label>',
		esc_html__( "Please install revolition slider plugin or create slide item." , 'javohome' )
	);
endif;


$jvfrm_home_pageHeaderOptions	= Array(
	'op_h_title_show'				=> Array(
		'value'							=> 'default',
		'label'							=> esc_html__( "Show page title", 'javohome' ),
	),
	'op_h_title_hide'					=> Array(
		'value'							=> 'notitle',
		'label'							=> esc_html__( "Hide page title", 'javohome' ),
	),
	'op_h_title_fancy'				=> Array(
		'value'							=> 'fancy',
		'label'							=> esc_html__( "Fancy Header", 'javohome' ),
	),
	'op_h_title_slide'				=> Array(
		'value'							=> 'slider',
		'label'							=> esc_html__( "Slide Show", 'javohome' ),
	),
);


if( !$get_jvfrm_home_opt_header = get_post_meta( $post->ID, 'jvfrm_home_header_type', true ) )
	$get_jvfrm_home_opt_header = 'notitle';

if( !empty( $jvfrm_home_pageHeaderOptions )) : foreach( $jvfrm_home_pageHeaderOptions as $key => $meta ) {
	$strIsTrue		= $get_jvfrm_home_opt_header == $meta[ 'value' ];
	$strIsActive		= $strIsTrue ? ' active' : false;

	echo join( "\n",
		Array(
			"<label class=\"jvfrm_home_pmb_option header {$key}{$strIsActive}\">",
				'<span class="ico_img"></span>',
				sprintf( "<p><input type=\"radio\" name=\"jvfrm_home_opt_header\" value=\"%s\" %s>%s</p>",
					$meta[ 'value' ],
					checked( $strIsTrue, true, false ),
					$meta[ 'label' ]
				),
			'</label>',
		)
	);

} endif; ?>

<div id="jvfrm_home_post_header_fancy">
	<div class="">
		<label class="jvfrm_home_pmb_option fancy op_f_left active">
			<span class="ico_img"></span>
			<p><input name="jvfrm_home_opt_fancy" type="radio" value="left" checked="checked"> <?php esc_html_e("Title left",'javohome'); ?></p>
		</label>
		<label class="jvfrm_home_pmb_option fancy op_f_center">
			<span class="ico_img"></span>
			<p><input name="jvfrm_home_opt_fancy" type="radio" value="center"> <?php esc_html_e("Title center",'javohome'); ?></p>
		</label>
		<label class="jvfrm_home_pmb_option fancy op_f_right">
			<span class="ico_img"></span>
			<p><input name="jvfrm_home_opt_fancy" type="radio" value="right"> <?php esc_html_e("Title right",'javohome'); ?></p>
		</label>
	</div>
	<hr>
	<div class="jvfrm_home_pmb_field">
		<dl>
			<dt><label for="jvfrm_home_fancy_field_title"><?php esc_html_e("Title",'javohome'); ?></label></dt>
			<dd><input name="jvfrm_home_fancy[title]" id="jvfrm_home_fancy_field_title" type="text" value="<?php echo esc_attr($jvfrm_home_fancy->get('title') );?>"></dd>
		</dl>
		<dl>
			<dt><label for="jvfrm_home_fancy_field_title_size"><?php esc_html_e("Title Size",'javohome'); ?></label></dt>
			<dd><input name="jvfrm_home_fancy[title_size]" id="jvfrm_home_fancy_field_title_size" type="text" value="<?php echo esc_attr( $jvfrm_home_fancy->get('title_size', 17) );?>"></dd>
		</dl>
		<dl>
			<dt><label for="jvfrm_home_fancy_field_title_color"><?php esc_html_e("Title Color",'javohome'); ?></label></dt>
			<dd>
				<input name="jvfrm_home_fancy[title_color]" type="text" value="<?php echo esc_attr( $jvfrm_home_fancy->get('title_color', '#000000') );?>" id="jvfrm_home_fancy_field_title_color" class="wp_color_picker" data-default-color="#000000">
			</dd>
		</dl>
		<dl>
			<dt><label for="jvfrm_home_fancy_field_subtitle"><?php esc_html_e("Subtitle",'javohome'); ?></label></dt>
			<dd><input name="jvfrm_home_fancy[subtitle]" id="jvfrm_home_fancy_field_subtitle" type="text" value="<?php echo esc_attr( $jvfrm_home_fancy->get('subtitle') );?>"></dd>
		</dl>
		<dl>
			<dt><label for="jvfrm_home_fancy_field_subtitle_size"><?php esc_html_e("Subtitle Size",'javohome'); ?></label></dt>
			<dd><input name="jvfrm_home_fancy[subtitle_size]" id="jvfrm_home_fancy_field_subtitle_size" type="text" value="<?php echo esc_attr( $jvfrm_home_fancy->get('subtitle_size', 12) );?>"></dd>
		</dl>
		<dl>
			<dt><label for="jvfrm_home_fancy_field_subtitle_color"><?php esc_html_e("Subtitle color",'javohome'); ?></label></dt>
			<dd><input name="jvfrm_home_fancy[subtitle_color]" value="<?php echo esc_attr( $jvfrm_home_fancy->get('subtitle_color', '#000000') );?>" id="jvfrm_home_fancy_field_subtitle_color" type="text" class="wp_color_picker" data-default-color="#000000"></dd>
		</dl>
		<hr>
		<dl>
			<dt><label for="jvfrm_home_fancy_field_bg_color"><?php esc_html_e("Background color",'javohome'); ?></label></dt>
			<dd><input name="jvfrm_home_fancy[bg_color]" value="<?php echo esc_attr( $jvfrm_home_fancy->get('bg_color', '#FFFFFF') );?>" id="jvfrm_home_fancy_field_bg_color" type="text" class="wp_color_picker" data-default-color="#ffffff"></dd>
		</dl>
		<dl>
			<dt><label for="jvfrm_home_fancy_field_bg_image"><?php esc_html_e("Background Image",'javohome'); ?></label></dt>
			<dd>
				<div class="jv-uploader-wrap">
					<input type="text" name="jvfrm_home_fancy[bg_image]" value="<?php echo esc_attr( $jvfrm_home_fancy->get('bg_image'));?>" >
					<button type="button" class="button button-primary upload" data-title="<?php esc_attr_e( "Select Background Image", 'javohome' ); ?>" data-btn="<?php esc_attr_e( "Select", 'javohome' ); ?>">
						<span class="dashicons dashicons-admin-appearance"></span>
						<?php esc_html_e( "Select Background Image", 'javohome' ); ?>
					</button>
					<button type="button" class="button remove">
						<?php esc_html_e( "Delete", 'javohome' );?>
					</button>
					<h4><?php esc_html_e("Preview",'javohome'); ?></h4>
					<img src="<?php echo esc_attr( $jvfrm_home_fancy->get( 'bg_image' ) );?>" style="max-width:500px;">
				</div>
			</dd>
		</dl>
		<dl>
			<dt><label for="jvfrm_home_fancy_field_position_x"><?php esc_html_e("Position X",'javohome'); ?></label></dt>
			<dd>
				<select name="jvfrm_home_fancy[bg_position_x]" id="jvfrm_home_fancy_field_position_x">
					<?php
					foreach( $jvfrm_home_fancy_dft_opt['background-position-x'] as $label => $value ) {
						echo "<option value=\"{$value}\"".selected( $value == $jvfrm_home_fancy->get('bg_position_x') ).">{$label}</option>";
					} ?>
				</select>
			</dd>
		</dl>
		<dl>
			<dt><label for="jvfrm_home_fancy_field_position_y"><?php esc_html_e("Position Y",'javohome'); ?></label></dt>
			<dd>
				<select name="jvfrm_home_fancy[bg_position_y]" id="jvfrm_home_fancy_field_position_y">
				<?php
					foreach( $jvfrm_home_fancy_dft_opt['background-position-y'] as $label => $value ) {
						echo "<option value=\"{$value}\"".selected( $value == $jvfrm_home_fancy->get('bg_position_y') ).">{$label}</option>";
					} ?>
				</select>
			</dd>
		</dl>
		<hr>
		<dl>
			<dt><label for="jvfrm_home_fancy_field_fullscreen"><?php esc_html_e("Height(pixel)",'javohome'); ?> </label></dt
			>
			<dd><input name="jvfrm_home_fancy[height]" id="jvfrm_home_fancy_field_fullscreen" value="<?php echo (int)$jvfrm_home_fancy->get('height', 150);?>" type="text"></dd>
		</dl>

	</div>
</div><!-- /#jvfrm_home_post_header_fancy -->

<div id="jvfrm_home_post_header_slide">
	<div class="">
		<label class="jvfrm_home_pmb_option slider op_d_rev active">
			<span class="ico_img"></span>
			<p><input name="jvfrm_home_opt_slider" type="radio" value="rev" checked="checked"> <?php esc_html_e("Revolution",'javohome'); ?></p>
		</label>
	</div>

	<!-- section  -->
	<div class="jvfrm_home_pmb_tabs slider jvfrm_home_pmb_field">
		<div class="jvfrm_home_pmb_tab active" tab="rev">
			<dl>
				<dt><label><?php esc_html_e("Choose slider",'javohome'); ?></label></dt>
				<dd><?php echo join( "\n", $strOutputSliderLists ); ?></dd>
			</dl>
		</div>
	</div>
</div><!-- /#jvfrm_home_post_header_slide -->

<!-- <table class="widefat">
	<tr>
		<td valign="middle"><?php esc_html_e( "Topbar", 'javohome');?></td>
		<td valign="middle">
			<table class="javo-post-header-meta">
				<tr>
					<td width="5%" valign="middle">
						<select name="jvfrm_home_hd[topbar]">
							<?php
							foreach( $jvfrm_home_options[ 'able_disable' ] as $label => $value )
								printf(
									"<option value='{$value}' %s>{$label}</option>"
									, selected( $value == $jvfrm_home_query->get( 'topbar' ), true, false )
								);
							?>
						</select>
					</td>
					<td width="5%" valign="middle">&nbsp;</td>
				</tr>
			</table>
		</td>
	</tr>
</table> -->