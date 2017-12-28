<?php
$arrAllowPostTypes		= apply_filters( 'jvfrm_support_single_post_types_array', Array( 'property' ) );

// Single page addon option
if( class_exists( 'Javo_Home_Single_Addon' ) ) 
	$single_addon_options = get_single_addon_options(get_the_ID());

// Right Side Navigation
$jvfrm_support_rs_navigation = jvfrm_single_support_navigation();

function jvfrm_support_custom_single_style()
{
	if ( false === (boolean)( $large_image_url = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' ) ) )
		$large_image_url	= '';
	else
		$large_image_url	=  $large_image_url[0];

	$output_style	= Array();
	$output_style[]	= sprintf( "%s:%s;", 'background-image'			, "url({$large_image_url})" );
	$output_style[]	= sprintf( "%s:%s;", 'background-attachment'	, 'fixed' );
	$output_style[]	= sprintf( "%s:%s;", 'background-repeat'		, 'no-repeat' );
	$output_style[]	= sprintf( "%s:%s;", 'background-position'		, 'center center' );
	$output_style[]	= sprintf( "%s:%s;", 'background-size'			, 'cover' );
	$output_style[]	= sprintf( "%s:%s;", '-webkit-background-size'	, 'cover' );
	$output_style[]	= sprintf( "%s:%s;", '-moz-background-size'		, 'cover' );
	$output_style[]	= sprintf( "%s:%s;", '-ms-background-size'		, 'cover' );
	$output_style[]	= sprintf( "%s:%s;", '-o-background-size'		, 'cover' );

	if( jvfrm_home_tso()->get( 'topmap_height' ) )
		$output_style[]	= sprintf( "%s:%s;", 'height'				, jvfrm_home_tso()->get('topmap_height') . 'px' );

	$output_style	= apply_filters( 'jvfrm_support_featured_detail_header'	, $output_style, $large_image_url );
	$output_style	= esc_attr( join( ' ', $output_style ) );

	echo "style=\"{$output_style}\"";
} ?>
<div class="single-item-tab-feature-bg <?php echo sanitize_html_class( jvfrm_home_tso()->get( 'property_single_header_cover', null ) );  ?>" <?php //jvfrm_support_custom_single_style();  ?>>
	<div class="single-item-tab-bg">
		<div class="single-featured-img-wrap">
			<div class="single-featured-img">
			   <?php the_post_thumbnail( 'full' );  ?>
			</div>
			<div class="single-img-gradient"></div>
		</div>
		<div class="container captions">
			<div class="header-inner">

				<div class="header-author">
					<span class="author-avatar"><?php echo get_avatar( get_the_author_meta( 'ID' ), 18 );  ?></span>
					<span class="author-name"><?php echo get_the_author_meta( 'display_name' );  ?></span>
				</div>

				<h2 class="header-title"><?php the_title();  ?></h2>

				<div class="header-content">
					<?php the_content();  ?>
				</div>
				<div class="header-date">
					<span class="header-inner-date"><?php the_date();  ?></span>
					<span class="header-inner-time"><?php the_time();  ?></span>
				</div>
				<?php /*
				<div class="item-bg-left pull-left text-left">
					<div class="taxonomy-wrap">
						<span class="item_cate admin-color-setting"><?php lava_realestate_featured_terms( 'property_type' );  ?></span>
						<span class="property_status"><?php lava_realestate_featured_terms( 'property_status' );  ?></span>
					</div> <!-- /.taxonomy-wrap -->
					<h1 class="uppercase">
						<?php echo apply_filters( 'jvfrm_support_' . get_post_type() . '_single_title', get_the_title() ); ?>
					</h1>
				</div>
				<div class="clearfix"></div>
				*/ ?>
			</div> <!-- header-inner -->
		</div> <!-- container -->
	</div> <!-- single-item-tab-bg -->
	<div class="single-item-tab-bg-overlay"></div>
	<div class="bg-dot-black"></div> <!-- bg-dot-black -->
</div> <!-- single-item-tab-feature-bg -->
<div id="javo-detail-item-header-wrap" class="container-fluid javo-spyscroll lava-spyscroll">
	<div class="container">
		<div data-spy="scroll" data-target=".navbar">
			<div id="javo-detail-item-header" class="navbar">
				<?php
				if( !empty( $jvfrm_support_rs_navigation ) )	{
					echo "<ul class=\"nav-tabs\">\n";
					foreach( $jvfrm_support_rs_navigation as $id => $attr )
					{
						if( ! in_Array( get_post_type(), $attr[ 'type' ] ) )
							continue;
						echo "\t\t\t\t\t\t <li class=\"javo-single-nav\" title=\"{$attr['label']}\">\n";
							echo "\t\t\t\t\t\t\t <a href=\"#{$id}\"><i class=\"{$attr['class']}\"></i> {$attr['label']}</a>\n";
						echo "\t\t\t\t\t\t </li>\n";
					}
					echo "\t\t\t\t\t</ul>\n";
				} ?>
			</div>
		</div>
	</div><!--/.nav-collapse -->
</div>