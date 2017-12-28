<?php
$spy_nav_font_color = isset( $spy_nav_font_color ) ? $spy_nav_font_color : NULL;
$spy_nav_background = isset( $spy_nav_background ) ? $spy_nav_background : NULL;
?>
<div id="javo-detail-item-header-wrap" class="container-fluid javo-spyscroll lava-spyscroll" <?php echo $spy_nav_background; ?>>
	<div class="container">
		<div class="row" data-spy="scroll" data-target=".navbar">
			<div id="javo-detail-item-header" class="col-md-9 navbar">
				<?php
				if( !empty( $jvfrm_home_rs_navigation ) )	{
					echo "<ul class=\"nav-tabs\">\n";
					foreach( $jvfrm_home_rs_navigation as $id => $attr ) {
						if( ! in_Array( get_post_type(), $attr[ 'type' ] ) )
							continue;
						echo "\t\t\t\t\t\t <li class=\"javo-single-nav\" title=\"{$attr['label']}\">\n";
							echo "\t\t\t\t\t\t\t <a href=\"#{$id}\" {$spy_nav_font_color}><i class=\"{$attr['class']}\"></i> {$attr['label']}</a>\n";
						echo "\t\t\t\t\t\t </li>\n";
					}
					echo "\t\t\t\t\t</ul>\n";
				} ?>
			</div>

			<div class="col-md-3 jv-scrollspy-right-wrap">
			<?php if( $this->single_type == 'type-half' ) : ?>
				<div class="dropdown">
					<button class="dropbtn"><i class="jvd-icon-envelope" <?php echo $spy_nav_font_color; ?>></i></button>
					<div class="dropdown-content e3 dropdown-menu-right">
						<?php lava_realestate_get_widget(); ?>
					</div>
				</div><!-- dropdown -->
			<?php endif; ?>
			</div> <!-- jv-scrollspy-right-wrap -->
		</div> <!-- row -->
	</div> <!--/.nav-collapse -->
</div> <!-- javo-detail-item-header-wrap -->