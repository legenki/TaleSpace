( function($, window, undef ) {
	"use strict";

	var jvfrm_home_ajaxShortcode = function( el, attr ) {
		var
			exists,
			target = $( '#js-' + el ).closest( '.shortcode-container' ).attr( 'id' );

		this.ID = el;
		this.orginID	= target;
		this.el = $( '#' +	 this.orginID );
		this.attr = attr;
		exists = this.el.length;

		if( exists )
			this.init();
	}

	jvfrm_home_ajaxShortcode.prototype = {

		constructor : jvfrm_home_ajaxShortcode,
		init : function() {
			var
				obj = this,
				el = obj.el;

			obj.loadmore = false;
			obj.param = {};
			obj.param.attr = obj.attr;
			obj.param.action = 'jvfrm_home_ajaxShortcode_loader';

			$( document )
				.on( 'click.' + obj.ID	, el.find( "ul[data-tax] li:not(.flexMenu-viewMore)" ).selector, obj.category_filter() )
				.on( 'click.' + obj.ID	, el.find( "a.page-numbers" ).selector, obj.pagination() )
				.on( 'jv:sc' + obj.ID	, obj.slideShow() ).trigger( 'jv:sc' + obj.ID );

			$( window )
				.on( 'scroll.' + obj.ID, obj.lazyload() )
				.trigger( 'scroll' );

			if( ! el.hasClass( 'no-flex-menu' ) ) {
				$( window ).on( 'resize.' + obj.ID,  obj.stackable() );
			}
			obj.lazyload();
		}

		, category_filter : function() {
			var
				obj				= this
				, element		= obj.el;
			return function( e )
			{
				e.preventDefault();

				var
					term_id			= $(  this ).data( 'term' )
					, taxonomy	= $(  this ).closest( 'ul.shortcode-filter' ).data( 'tax' );

				$( "ul[data-tax].shortcode-filter li", element ).removeClass( 'current' );
				$( this ).addClass( 'current' );

				if( taxonomy && obj.param.attr !== undef ){
					obj.param.attr.term_id		= term_id;
					obj.param.attr.taxonomy	= taxonomy;
					obj.param.attr.paged			= 1;
				}
				obj.filter( true );
				return;
			}
		}

		, pagination : function() {

			var obj		= this;
			return function( e ) {
				var
					current					= 0
					, strPagination		= $( this ).attr( 'href' )
					, is_disabled			= $( this ).hasClass( 'disabeld' )
					, is_loadmore			= $( this ).hasClass( 'loadmore' );

				e.preventDefault();

				if( is_disabled )
					return;

				if( strPagination ){
					strPagination			= strPagination.split( '|' );
					if( strPagination[1]  !== 'undefined' )
						current				= strPagination[1];
				}

				if( is_loadmore ) {
					obj.loadmore						= true;
					obj.param.attr.pagination	= 'loadmore';
				}

				obj.param.attr.paged	= current;
				obj.filter();
				return;
			}
		}

		, filter : function( is_setTerm ) {
			var
				obj				= this
				, param			= obj.param
				, element		= obj.el
				, parent			= element.parent()
				, is_loadmore	= obj.loadmore
				, loading		= $( ".output-cover, .output-loading" , parent );

			$.ajaxSetup({
				beforeSend: function() {
					loading.addClass( 'active' );
				}
				, complete: function() {
					loading.removeClass( 'active' );
					$( window ).trigger( 'scroll' );
				}
			});

			$.post( document.ajaxurl, param, function( xhr )
			{
				var output = $( '> .shortcode-output', element );

				if( element.hasClass( 'exists-wrap' ) )
					output = $( '> .shortcode-content > .shortcode-output', element );


				if( is_setTerm ) {
					output.html( xhr );
				}else{
					if( is_loadmore ) {
						$( ".loadmore", element ).closest( '.jv-pagination' ).remove();
						output.append( xhr );
					}else{
						output.html( xhr );
					}
				}

				$( document )
					.off( 'click.' + obj.ID + ' jv:sc' + obj.ID );

				$( window ).off( 'resize.' + obj.ID );
				$( window ).off( 'scroll.' + obj.ID );
				delete window.__javoAjaxShortcode_instance;
			}, 'html' )
			.fail( function( xhr ) {
				console.log( xhr.responseText );
			} );
		},

		stackable : function() {
			var
				obj = this,
				element	= obj.el,
				nav = $( "ul.shortcode-filter", element ),
				divPopup = $( "ul.flexMenu-popup", nav ),
				btnMore = $( "> li.flexMenu-viewMore > a", nav );

			nav.width( obj.getHeaderMargin( element ) );

			nav.flexMenu({
				showOnHover		: false,
				//, linkText	: nav.data( 'more' )
				linkText		: '<i class="fa fa-bars"></i>',
				//, linkTextAll	: nav.data( 'mobile' )
				linkTextAll	: '<i class="fa fa-bars"></i>',
			}).removeClass( 'hidden' );

			btnMore.hover(
				function() {
					$( this ).addClass( 'active' );
					divPopup.show( 'fast' );
				},
				function() {
					$( this ).removeClass( 'active' );
					divPopup.hide( 'fast' );
				}
			);

			return function(){
				var nTimeID = false;
				nTimeID = setInterval( function() {
					nav.width( obj.getHeaderMargin( element ) );
				}, 100 );
			}
		}

		, getHeaderMargin( element ) {
			var
				cW = parseInt( $( '.shortcode-header', element ).width() ),
				tW = parseInt( $( '.shortcode-title', element ).outerWidth() );
			return cW - tW;
		}

		, flexMenu : function( nav, onoff ) {
			if( onoff ) {
				nav.flexMenu({
					showOnHover		: false,
					linkText		: '<i class="fa fa-bars"></i>',
					linkTextAll	: '<i class="fa fa-bars"></i>',
				}).removeClass( 'hidden' ).show();
			}else{
				nav.flexMenu({ undo : true }).addClass( 'hidden' ).hide();
			}

		}

		, lazyload : function(){

			var
				obj				= this,
				lazyStarted		= false,
				intWinScrollTop	= 0,
				intWinHeight	= 0,
				intSumOffset	= 0,
				intCurrentIDX	= 0,
				intInterval		= 100,
				objWindow		= $( window );

			return function(){
				intWinScrollTop	= objWindow.scrollTop();
				intWinHeight	= objWindow.height() * 0.9;
				intSumOffset	= intWinScrollTop + intWinHeight;

				if( ( intSumOffset > obj.el.offset().top ) && !lazyStarted ) {

					$( 'img.jv-lazyload, div.jv-lazyload', obj.el ).each( function( i, el ){
						var nTimeID = setInterval( function(){
							$( el ).addClass( 'loaded' );
							clearInterval( nTimeID );
						}, i * intInterval );
					});
				}
			}
		},

		slideShow : function(){
			var
				obj				= this
				, el				= obj.el
				, output		= $( "> .shortcode-output", el )
			return function(){
				if( !el.hasClass( 'is-slider' ) || !$.fn.flexslider )
					return;

				$( "> .slider-wrap", output ).flexslider({
					animation		: 'slide'
					// Note : Flexslider.css Dot nav Padding Problem...
					, controlNav	: el.hasClass( 'circle-nav' )
					, slideshow		: el.hasClass( 'slide-show' )
					, direction		: el.hasClass( 'slider-vertical' ) ? 'vertical' : 'horizontal'
					, smoothHeight: true
				});
			}
		}
	}

	$.jvfrm_home_ajaxShortcode = function( element, args ){
		window.__javoAjaxShortcode_instance = new jvfrm_home_ajaxShortcode( element, args );
	};
} )( jQuery, window );