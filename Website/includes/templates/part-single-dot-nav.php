<?php
if( get_post_type() == 'lv_support' && function_exists( 'jvfrm_single_support_navigation' ) )
	$jvfrm_home_rs_navigation = jvfrm_single_support_navigation();
else
	$jvfrm_home_rs_navigation = jvfrm_home_single_navigation();
?>
<div data-spy="affix" id="dot-nav">
	<?php
	if( !empty( $jvfrm_home_rs_navigation ) )	{
		echo "<ul>";
			foreach( $jvfrm_home_rs_navigation as $id => $attr )
			if( in_Array( get_post_type(), $attr[ 'type' ] ) )
			echo "<li class=\"awesome-tooltip\" title=\"{$attr['label']}\"><a href=\"#{$id}\"></a></li>";
		echo "</ul>";
	} ?>
</div> <!-- dot-nav -->