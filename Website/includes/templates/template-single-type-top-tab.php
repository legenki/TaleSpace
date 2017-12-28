<?php 
// Single page addon option
if( class_exists( 'Javo_Home_Single_Addon' ) ){
	$single_addon_options = get_single_addon_options(get_the_ID());
}
?>
<div class="container tab-singles">
	<div id="javo-single-content" class="col-md-9 col-xs-12">
		<ul class="nav nav-tabs nav-justified" role="tablist">
		<?php
			//tab menu
			include "addon-body-tab-menus.php";
		?>
		</ul>

		<?php	
			//tab content
			include "addon-body-tab-content.php";
		?>			
	</div><!-- #javo-single-content.col-md-9 -->

	<div id="javo-single-sidebar" class="col-md-3 sidebar-right">
		<?php lava_realestate_get_widget(); ?>
	</div><!-- /.col-md-3 -->
</div><!-- /.container -->