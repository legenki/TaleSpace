<?php 
// Single page addon option
if( class_exists( 'Javo_Home_Single_Addon' ) ){
	$single_addon_options = get_single_addon_options(get_the_ID());
}
?>
<div class="container">
	<div class="row">
		<div id="javo-single-content" class="col-md-9 col-xs-12 property-single">
			<?php
			//dynamic style body
			include "addon-body-dynamic.php";
			?>
		</div> <!-- /#javo-single-content -->
		<div id="javo-single-sidebar" class="col-md-3 sidebar-right">
			<?php lava_realestate_get_widget(); ?>
		</div><!-- /.col-md-3 -->
	</div><!--/.row-->
</div><!-- /.container -->