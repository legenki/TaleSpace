<div class="modal fade" id="jv-mobile-search-form" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-body">
				<?php
				$jvfrm_home_search1 = jvfrm_home_getSearch1_Shortcode();
				if( method_exists ( $jvfrm_home_search1, 'config' ) )
					echo $jvfrm_home_search1->config(
						Array(
							'query_requester'	=> intVal( jvfrm_home_tso()->get( 'property_mobile_search_requester' ) )
							, 'columns'			=> jvfrm_home_tso()->get( 'property_mobile_search_columns' )
							, 'column1'			=> jvfrm_home_tso()->get( 'property_mobile_search_column1' )
							, 'column2'			=> jvfrm_home_tso()->get( 'property_mobile_search_column2' )
							, 'column3'			=> jvfrm_home_tso()->get( 'property_mobile_search_column3' )
							, 'mobile'			=> '1'
						)
					);
				?>
			</div><!--/.modal-body-->
		</div><!--/.modal-content-->
	</div><!--/.modal-dialog-->
</div><!--/.modal fade-->
<script type="text/javascript">
jQuery( function( $ ) {
	"use strict";
	$( '#jv-mobile-search-form' ).on( 'show.bs.modal',
		function() {
			var
				offset			= 0,
				modalDialog		= $( 'div.modal-dialog', this ),
				headerHeight	= $( "header#header-one-line" ).outerHeight() || 0,
				adminHeight		= $( "#wpadminbar" ).outerHeight() || 0;
			offset					+= parseInt( headerHeight );
			offset					+= parseInt( adminHeight );
			modalDialog.css( 'top', offset + 'px' );
		}
	);
} );
</script>