( function( $ )
{
	"use strict";
	/**
	 *	Widget : Menu button
	 *
	 */
	var anchor			= $( "#javo-doc-top-level-menu li.javo-wg-menu-button-login-wrap a" );
	var original_str	= anchor.html();
	var mobile_str		= anchor.data( 'mobile-icon' );
	$( window ).on( 'resize', function()
	{
		if( $( "body" ).hasClass( "mobile" ) )
		{
			anchor.html( "<i class='" + mobile_str + "'></i>" );
		}else{
			anchor.html( original_str );
		}
	} );
	/**
	 *	Widget : WPML Selector
	 *
	 */
	var dropdown_element	= $( "#javo-wpml-switcher" );
	dropdown_element
		.on( 'mouseenter', function(){
			$( 'div > ul', this ).clearQueue().slideDown( 'fast' );
		} )
		.on( 'mouseleave', function(){
			$( 'div > ul', this ).clearQueue().slideUp( 'fast' );
		});
})( jQuery );