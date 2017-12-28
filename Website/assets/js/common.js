/**
 *
 * Common Script
 * @author javo Themes
 * @since 1.0.0
 * @description Common Scripts
 *
 */

;( function( $ ){
	"use strict";

	var jvfrm_home_common_func = function(){
		if( jvfrm_home_common_args   )
			this.param = jvfrm_home_common_args ;
		this.init();
	}
	jvfrm_home_common_func.prototype = {
		constructor : jvfrm_home_common_func,

		init : function() {

			var obj = this;

			this.headerHeight = 0;

			this
				.init_pace()
				.init_canvas()
				.init_cover()
				.init_align_gridList()
				.init_main_affix()
				.init_single_scrollSpy()
				.init_single_dark_pallax();

			/* .init_sticky_sidebar() */

			$( this.init_smothScroll );

			; $( document )
				.on( 'click', 'jv-canvas-opener', this.toggleCanvas() )
				.on( 'show.bs.offcanvas', this.offcanvasChecker( true ) )
				.on( 'hide.bs.offcanvas', this.offcanvasChecker( false ) )
				.on( 'click', '[data-full-cover]', this.fullCoverOpener() )
				.on( 'click', '#googlelogin', this.login_via_google_oauth() )
				.on( 'click keyup', '.jv-full-conver-container, .jv-full-conver-container button.close', this.fullCoverCloser );

			; $( window )
				.on( 'resize', this.fullCoverResize );
		},

		init_pace: function() {
			// pace	loading

			window.paceOptions = {
				ajax						: false
				, document			: false
				, eventLag			: false
			}

			Pace.on( 'start', function(){
				$("div.loading-page").show();
			});
			Pace.on( 'done', function(){
				$('div.loading-page').fadeOut('slow');
			});

			return this;
		},

		init_canvas: function() {
			/* my page canvas for bootstrap	*/
			$( document )
				.on('click', '[data-toggle="mypage-offcanvas"]', function( e ){
					e.preventDefault();
					$('.row-offcanvas').toggleClass('active');
				});
			return this;
		},

		init_cover : function() {
			var element	= $( '.jv-full-conver-container' );
			element.appendTo( 'body' );
			return this;
		},

		init_align_gridList: function() {
			/* grid	/ list listing */
			$( document )
				.on( 'click', '#list', function( e ){
					e.preventDefault();
					$('#products .item').addClass('list-group-item');
				})
				.on( 'click', '#grid', function( e ){
					e.preventDefault();
					$('#products .item').removeClass('list-group-item');
					$('#products .item').addClass('grid-group-item');
				});
			return this;
		},

		toggleCanvas : function() {
			var obj				= this;
			return function( e ) {
				e.preventDefault();
			}
		},

		offcanvasChecker : function( onoff ) {
			var class_name = 'offcanvas-active';
			return function() {
				if( onoff ) {
					$( 'body' ).addClass( class_name );
				}else{
					$( 'body' ).removeClass( class_name );
				}
			}
		},

		fullCoverOpener : function() {
			return function ( e ) {
				e.preventDefault();
				var
					target		= $( '.jv-full-conver-container.' + $( this ).data( 'full-cover' ) ),
					nTimeID	= setInterval( function(){
						$( window ).trigger( 'scroll' );
						clearInterval( nTimeID );
					}, 300 );

				target.addClass( 'open' );
			}
		},

		fullCoverResize : function() {
			var element = $( '.jv-fullcover-search-inner' );
			element.css({
				marginLeft : -( element.outerWidth() / 2 ) + 'px',
				marginTop : -( element.outerHeight() / 2 ) + 'px',
			} );
		},

		fullCoverCloser : function ( e ) {
			if( e.target == this || e.target.className == 'close' || e.keyCode == 27 )
				$( this ).removeClass( 'open' );
		},

		init_smothScroll : function( $ ){

			var
				intInterval		= 0.6,
				intScrollSize	= 400;

			if( typeof TweenLite == 'undefined' )
				return false;

			if( $( 'body' ).hasClass( 'no-smoth-scroll' ) )
				return false;

			$( window ).on( 'mousewheel', function( e ){
				e.preventDefault();
				var
					wheelDirection	= e.originalEvent.wheelDelta / 120 || -e.originalEvent.detail / 3,
					intCurrentY		= $( this ).scrollTop(),
					intCalcY		= intCurrentY - parseInt( wheelDirection * intScrollSize );

				TweenLite.to( $( this ), intInterval,
					{
						scrollTo: {
							y: intCalcY,
							autoKill: false
						},
						autoKill: false,
						overwrite: 5
					}
				);
			} );
		},

		getHeadersHeight : function( elements ) {
			var intResult = 0;
			for( var element in elements ){
				if( elements[ element ].length ){
					intResult += elements[ element ].outerHeight( true );
				}
			}
			return intResult;
		},

		init_main_affix : function(){

			var
				obj = this,
				intHeaderHeight = 0,
				intContainerY = 0,
				header = $( 'header#header-one-line' ),
				topbar = $( '.javo-topbar', header ),
				navbar = $( '.javo-main-navbar', header ),
				adminbar = $( '#wpadminbar' ),
				content_cotainer = $( "div#page-style" );

			intContainerY = content_cotainer.length ? content_cotainer.offset().top : 0;
			intContainerY = obj.getHeadersHeight( new Array( topbar, navbar, adminbar ) );

			obj.headerHeight = obj.getHeadersHeight( new Array( navbar, adminbar ) );

			if( $( 'body' ).hasClass( 'no-sticky' ) )
				return this;

			if( typeof $.fn.affix == 'undefined' )
				return this;

			intHeaderHeight = navbar.outerHeight();

			if( navbar.length ){
				navbar.affix({ offset: intContainerY });

				// navbar.affix( 'checkPosition' );
				navbar.on( 'affixed-top.bs.affix', function(){
					$( this ).css({ marginTop : obj.getHeadersHeight( new Array( topbar, adminbar ) ) });
					header.css({ marginBottom : intHeaderHeight });
				});
				navbar.on( 'affixed.bs.affix', function(){
					if( !obj.sticky_sidebar_loaded ){
						obj.init_sticky_sidebar( obj.getHeadersHeight( new Array( navbar, adminbar ) ) );
						obj.sticky_sidebar_loaded = true;
					}
					$( this ).css({ marginTop : 0 });
					$( window ).trigger( 'scroll' );
				} );

				if( navbar.hasClass( 'affix-top' ) )
					navbar.trigger( 'affixed-top.bs.affix' );

				obj.init_single_sticky_sidebar( obj.getHeadersHeight( new Array( navbar, adminbar ) ) );

			}
			return this;
		},

		login_via_google_oauth : function(){
			var
				obj = this,
				param = obj.param,
				ajaxurl = param.ajax_url;

			return function() {
				if( !param )
					return false;

				$.post(
					ajaxurl,
					{ action:'jvfrm_home_ajax_google_login_oauth' },
					function( responseURL ){
						window.location.href = responseURL;
					}
				)
				.fail( function( e ){
					alert( "Server Error" );
					console.log( e );
				} );
			}
		},

		init_sticky_sidebar : function( sticky_offY ) {
			var
				obj = this,
				sidebar = $( '.jv-sticky-sidebar' ),
				columns = $( '>.wpb_column', sidebar );

			if( typeof $.fn.theiaStickySidebar == 'undefined' ){
				console.log( "heiaStickySlider Load fail.",$.fn.theiaStickySidebar );
				return false;
			}

			if( sidebar.hasClass( 'vc_row' ) ){
				$( document ).ready( function(){
					var
						virtualColumn,
						tempClasses;

					columns.theiaStickySidebar({ additionalMarginTop : sticky_offY || 0 });
					virtualColumn = $( '.theiaStickySidebar', columns );
					tempClasses = virtualColumn.children().attr( 'class' );
					virtualColumn.attr( 'class', tempClasses ).addClass( 'theiaStickySidebar' );
					virtualColumn.children().attr( 'class', '' );
					$( window ).trigger( 'resize' );
				});
			}
		},

		init_single_sticky_sidebar : function( sticky_offY ) {
			var
				obj = this,
				sidebar = $( '#page-style > .container > .row' ),
				columns = $( '> div', sidebar );

			if( typeof $.fn.theiaStickySidebar == 'undefined' ){
				console.log( "heiaStickySlider Load fail.",$.fn.theiaStickySidebar );
				return false;
			}

			if( $( 'body' ).hasClass( 'single-post' ) ){
				$( document ).ready( function(){

					var
						virtualColumn,
						tempClasses;

					columns.theiaStickySidebar({ additionalMarginTop : sticky_offY || 0 });
				});
			}

			if( $( 'body' ).hasClass( 'single-portfolio' ) ){
				$( document ).ready( function(){

					var
						virtualColumn,
						tempClasses;

					columns.theiaStickySidebar({ additionalMarginTop : sticky_offY || 0 });
				});
			}
		},

		init_single_dark_pallax : function(){

			var
				header = $( '.jv-single-post-layout-1' ),
				image = $( '.jv-single-post-thumbnail-holder > img', header ),
				overlay = $( '.filter-overlay', header ),
				cpHeader = $( '.single-item-tab-feature-bg' ),
				cpOverlay = $( '> .jv-pallax', cpHeader );

			$( window ).on( 'scroll', function(){

				var currentY = $( this ).scrollTop();

				if( overlay.length ){
					var
						endY = overlay.offset().top + overlay.height(),
						scrollY = parseFloat( currentY / endY );

					if( scrollY <= 1 ){
						image.css({
							'transform':
								'scale(' + parseFloat( 1 + ( scrollY * 0.12 ) ) + ')' +
								'translate3d( 0, ' + parseInt( scrollY * 10 ) + '%, 0 )'
						});

						overlay.css({
							'backgroundColor':'rgba(0,0,0, ' +  scrollY + ')',
						});
					}
				}

				if( cpOverlay.length ){
					var
						cpEndY = cpOverlay.offset().top + cpOverlay.height(),
						cpScrollY = parseFloat( currentY / cpEndY );

					if( cpScrollY <= 1 ){
						if( $( 'body' ).hasClass( 'type-half' ) ) {
							cpHeader.css({
								'backgroundPosition': '50% 50%',
								'transform': 'scale(' + parseFloat( 1 + ( cpScrollY * 0.12 ) ) + ')',
							});
						}else{
							cpHeader.css({
								'backgroundPosition': '0px ' + parseInt( 50 + ( cpScrollY * 50 ) ) + '%',
								'transform': 'scale(' + parseFloat( 1 + ( cpScrollY * 0.12 ) ) + ')',
							});
						}
						cpOverlay.css({
							'backgroundColor':'rgba(0,0,0, ' +  cpScrollY + ')',
						});
					}
				}

			});
			return this;
		},

		init_single_scrollSpy : function() {

			var
				el = $( "#page-style, [data-jv-detail-nav]" ),
				numSections = el.length;

			el.each( function( i, section ) {
				$( window ).on( 'scroll', function() {

					var
						nextTop	= 0
						, thisTop	= 0
						, docTop	= $( this ).scrollTop();

					if( typeof $( el[i +1] ).offset() != 'undefined' ) {
						nextTop	= $( el[i +1] ).offset().top;
					} else {
						nextTop	= $( document ).height();
					}

					if( typeof $( el[i] ).offset() != 'undefined' )
						thisTop	= $( el[i] ).offset().top - ( ( nextTop - $( el[i] ).offset().top ) / numSections );

					if( docTop > thisTop && ( docTop < nextTop ) ) {
						$('#dot-nav	li a').removeClass('active').parent('li').removeClass('active');
						$( "a[href='#" + $( section ).attr( 'id' ) + "']" ).parent( 'li' ).addClass( 'active' );
					}
				} );
			});
			$( window ).trigger( 'scroll' );
			return this;
		}
	}

	var javo = window.javo || {};
	javo.common = new jvfrm_home_common_func;
	window.javo = javo;
})( jQuery );


/* single spy */
jQuery( function( $ ) {
	"use strict";

	$( 'li.awesome-tooltip' ).tooltip({ placement: 'left' });
	$( document ).on(
		'click'
		, '#dot-nav li, #javo-detail-item-header li'
		, function( e )
		{
			var	id = $(this).find( 'a' ).attr( "href" )
				, posi
				, ele
				, padding =	0
				, bonusOffy	= 1
				, off_main_nav	= $( "#javo-detail-item-header-wrap").outerHeight();

			e.preventDefault();

			// if Div Element Exists then, results summary
			bonusOffy += $("#wpadminbar").outerHeight(true)	- 4;

			if( off_main_nav )
				bonusOffy += off_main_nav;

			padding	= bonusOffy;

			ele	= $(id);
			posi = ($(ele).offset()||0).top	- padding;

			$('html, body').animate({scrollTop:posi}, 'slow');
		}
	);
} );

jQuery(document).ready(function($){
	"use strict";

	var	$submenu = $(".navbar");
	// To account for the affixed submenu being	pulled out of the content flow.
	//$submenu.after('<div style="width:100%;height:'	+ $submenu.height()	+ 'px;" class="navbar	affix-placeholder"></div>');
});



jQuery( function( $ ) {
	"use strict";

	var	jvfrm_home_single_top_nav	= {
		offset:0
		, init:function(){
			this.offset	+= $("#wpadminbar").outerHeight(true);
			this.offset	+= $("#javo-detail-item-header-wrap").outerHeight(true);
			$(window).on('scroll', this.scroll);
			$(document).on('click',	'.javo-single-nav li a', {a:'b'}, this.click);
		}
		, scroll:function(){
			var	$scrTop	= $(window).scrollTop();
			$('.javo-single-nav	 a').each(function(i,	k){
				var
					$this =	$( this ),
					$tar = $( $this.attr( 'href' ) );

				if(
					$tar.length &&
					$scrTop	>= ( $tar.offset().top - jvfrm_home_single_top_nav.offset	) &&
					$scrTop	< (	$tar.offset().top +	$tar.outerHeight(true) - jvfrm_home_single_top_nav.offset	 )
				){

					$this
						.closest('ul')
						.find('li')
						.removeClass('active');
					$this
						.parent('li')
						.addClass('active');
				}
			});


		}
		, click:function(e){
			e.preventDefault();
			var
				$this =	$( this ),
				$tar = $( $this.attr( 'href' ) );

			$( 'html, body' ).animate({
				scrollTop: ( $tar.offset().top - jvfrm_home_single_top_nav.offset	+ 4	)  + 'px'
			}, 500 );
		}
	};

	jvfrm_home_single_top_nav.init();
	window.jvfrm_home_single_effect =	{
		winOffy: $(window).scrollTop()
		, bonus: $('#wpadminbar').outerHeight( true	) +	$('#javo-navibar').outerHeight(	true )
		,
		init:function(){
			$(window).on('scroll', this.scroll);
		}
		,
		scroll:	function(){
			var	$object	= window.jvfrm_home_single_effect;
			$object.winOffy	= $(this).scrollTop();

			$('.javo-animation').each(function(k, v){

				if(	$(this).hasClass('single-item-intro') ){ return; };

				if(	$(this).offset().top < $object.winOffy + $(window).height()	 ){
					$(this).addClass('loaded');
				}
			});
		}
	};
	jvfrm_home_single_effect.init();

	// Contact Us
	$('body').on('mouseup',	function(e){
		var	$this =	$(this);

		if(	$(e.target).closest('.javo-quick-contact-us-content').length ==	0 ){
			$('.javo-quick-contact-us-content').removeClass('active');
		};

		$this.on('click', '.javo-quick-contact-us',	function(){
			$('.javo-quick-contact-us-content').addClass('active');
			$('.javo-quick-contact-us-content').css({
				top: $(this).position().top	- $('.javo-quick-contact-us-content').outerHeight(true)
			});
		});
	});
});

// javo scrollspy icon
jQuery( function($){
	"use strict";
	$( '.jv-spyscroll, .javo-spyscroll-icon a' )
		.on( 'click',
			function(e) {
				var
					adminbar_height,
					header_height,
					intTotal,
					strHash			= this.hash,
					header			= $( "#header-one-line > nav.navbar"),
					adminbar		= $( "#wpadminbar");

				e.preventDefault();

				//header.removeClass( 'affix-top' ).addClass( 'affix' );

				adminbar_height	= parseInt( adminbar.outerHeight(  true ) );
				header_height	= parseInt( header.height() );
				intTotal		= $( strHash ).length ? $( strHash ).offset().top : 0;

				if( !isNaN( adminbar_height ) )
					intTotal -= adminbar_height;

				// After header affix target offset down.
				if( !isNaN( header_height ) )
					intTotal -= ( header_height );

				$('html, body')
					.animate(
						{ scrollTop: intTotal },
						700,
						function(){
							//window.location.hash = strHash;
						}
					);
				return false;
			}
		);
});