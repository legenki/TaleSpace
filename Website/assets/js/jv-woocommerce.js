/**
 *
 * WooCommerce Template Script
 * @author javo Themes
 * @since 1.0.0
 * @description WooCommerce Plugin Template Script
 *
 */
 // WooCommerce
 (function( $ ){
	 var
		container = $( ".woocommerce-page .quantity" ),
		quantity_control	= function( el, remove ) {
			var
				parent	= el.closest( '.quantity' ),
				input		= $( "input[type='number']", parent ),
				curVal	= parseInt( input.val() );

			curVal = ( remove || false ) ? --curVal : ++curVal;
			if( curVal > 0 )
				input.val( curVal );
		}
		$( "input[type='button'].plus", container )
			.on( 'click',
				function( e ) {
					e.preventDefault();
					quantity_control( $( this ) );
				}
			);
		$( "input[type='button'].minus", container )
			.on( 'click',
				function( e ) {
					e.preventDefault();
					quantity_control( $( this ), true );
				}
			);
})(jQuery);