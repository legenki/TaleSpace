<?php
$post_id	= get_the_ID();

if( (int) $post_id > 0 )
{

	if( ! $header_type = get_post_meta( $post_id, 'jvfrm_home_header_type', true ) )
		$header_type = 'notitle';

	if( get_post_type( $post_id ) =='post' )
		$header_type	= 'notitle';

	$jvfrm_home_fancy_opts	= maybe_unserialize( get_post_meta( $post_id, 'jvfrm_home_fancy_options', true ) );
	$jvfrm_home_slider			= maybe_unserialize( get_post_meta( $post_id, 'jvfrm_home_slider_options', true ) );
	$jvfrm_home_fancy			= new jvfrm_home_array( $jvfrm_home_fancy_opts );

	switch( $header_type )
	{
	case "default":
		echo apply_filters( 'jvfrm_home_post_title_header', get_the_title(), get_post() );
	break;
	case "fancy":
		$fancy_title_type = get_post_meta($post_id, 'jvfrm_home_header_fancy_type', true);
		$header_fancy_css = sprintf("
			position:relative;
			background-color:%s;
			background-image:url('%s');
			background-repeat:%s;
			background-position:%s %s;
			height:%spx;",
			$jvfrm_home_fancy->get( 'bg_color' ),
			$jvfrm_home_fancy->get( 'bg_image' ),
			$jvfrm_home_fancy->get( 'bg_repeat' ),
			$jvfrm_home_fancy->get( 'bg_position_x' ),
			$jvfrm_home_fancy->get( 'bg_position_y' ),
			$jvfrm_home_fancy->get( 'height' )
		);
		$header_fancy_title_wrap_css = sprintf("
			left:0px;
			width:100%%;
			height:%spx;
			display:table-cell;
			vertical-align:middle;
			text-align:%s;",
			$jvfrm_home_fancy->get( 'height' ),
			$fancy_title_type
		);
		$header_fancy_title_css = sprintf("
			color:%s;
			font-size:%spt;"
			, $jvfrm_home_fancy->get( 'title_color' )
			, (int)$jvfrm_home_fancy->get( 'title_size', 17)
		);
		$header_fancy_subtitle_css = sprintf("
			color:%s;
			font-size:%spt;"
			, $jvfrm_home_fancy->get( 'subtitle_color' )
			, (int)$jvfrm_home_fancy->get( 'subtitle_size', 12)
		);?>
		<div class="jvfrm_home_post_header_fancy" style="<?php echo esc_attr( $header_fancy_css );?>">
			<div class="container" style="display:table;">
				<div style="<?php echo esc_attr( $header_fancy_title_wrap_css );?>">
					<h1 style="<?php echo esc_attr( $header_fancy_title_css );?>"><?php echo $jvfrm_home_fancy->get('title');?></h1>
					<h4 style="<?php echo esc_attr( $header_fancy_subtitle_css );?>"><?php echo $jvfrm_home_fancy->get('subtitle');?></h4>
				</div>
			</div>
		</div>
		<?php
	break; case "slider":
		$sliderType = get_post_meta($post_id, 'jvfrm_home_slider_type', true);
		switch($sliderType){
			case "rev":
				if($jvfrm_home_slider['rev_slider'] != "") echo do_shortcode("[rev_slider ".$jvfrm_home_slider['rev_slider']."]");
			break;
			default:
				esc_html_e("No select slider.", 'javohome');
		}
	break; case "notitle":
	default:
		// No Title : Do Nothing.
	}
}