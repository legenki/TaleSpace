<?php 
// Single page addon option
if( class_exists( 'Javo_Home_Single_Addon' ) ){
	$single_addon_options = get_single_addon_options(get_the_ID());
}
?>
<div class="container tab-singles">
	<div id="javo-single-content" class="col-xs-12">
		<div id="javo-single-sidebar" class="col-md-3 col-xs-3 sidebar-left">
			<ul class="nav nav-tabs tabs-left nav-stacked visible-lg visible-md visible-sm" role="tablist">
			<?php
			//tab menu
			include "addon-body-tab-menus.php";
			?>
			</ul>
			<div class="jv-widgets">
				<?php lava_realestate_get_widget(); ?>
			</div><!-- /.col-md-3 -->
		</div>
		
		<div class="col-md-9 col-xs-9 jv-left-tab-content">
			<ul class="nav nav-tabs nav-justified visible-xs" role="tablist">
				<?php
					//tab menu
					include "addon-body-tab-menus.php";
				?>
			</ul>
			<?php	
			//tab content
			include "addon-body-tab-content.php";
			?>			
		</div><!-- col-md-9 -->
	</div><!-- #javo-single-content. -->
</div><!-- /.container -->