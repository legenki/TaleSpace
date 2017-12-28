( function( $ ) {
	"use strict";

	var jvfrm_home_single_template_script			= function( el ) {
		this.el = el;
		this.param	= jvfrm_home_custom_post_param;
		this.init();
	}

	jvfrm_home_single_template_script.prototype	= {

		constractor : jvfrm_home_single_template_script,

		init : function() {

			var
				obj = this,
				offy = $( "#wpadminbar" ).outerHeight() || 0;

			obj.featured_switcher();

			$( document )
				.on( 'click', $( '.lava-Di-share-trigger', this.el ).selector, obj.showShare() )
				.on( 'click', $( '.lava-wg-single-report-trigger', this.el ).selector, obj.showReport() )
				.on( 'click', $( '#lava-wg-url-link-copy', this.el ).selector, obj.copyLink() )
				.on( 'click', '.expandable-content-overlay', obj.readMore( obj ) )
				.on( 'click', '.jv-custom-post-content-trigger', obj.readMoreType2( obj ) )
				.on( 'click', '#javo-item-detail-image-section a.link-display', obj.imageMore() );

			$( window ).on( 'resize', obj.single_resize() );

			if( this.param.map_type != 'boxed' && this.param.single_type != 'type-grid' ){
				$( document )
					.on( 'lava:single-msp-setup-after', function(){
						$( window )
							.on( 'resize', obj.bindResize())
							.trigger( 'resize' );
					} );
			}

			if( this.param.widget_sticky != 'disable' )
				this.el.find( '.panel' ).sticky({ topSpacing : parseInt( offy ) }).css( 'zIndex', 1 );

			$( ".sidebar-inner" ).css( 'background', '' );
			$( ".lava-spyscroll" ).css({ padding:0, 'zIndex':2 }).sticky({ topSpacing : parseInt( offy ) });
		},

		showShare : function() {
			var obj = this;
			return function( e )
			{
				e.preventDefault();
				jQuery.lava_msg({
					content			: $("#lava-Di-share").html()
					, classes		: 'lava-Di-share-dialog'
					, close			: 0
					, close_trigger	: '.lava-Di-share-dialog .close'
					, blur_close	: true
				});
				if( typeof ZeroClipboard == 'function' ) {
					var objZC = new ZeroClipboard( $( '#lava-wg-url-link-copy', document ).get(0) );
					objZC.on( 'aftercopy', function( event ) {
						alert( "Copy : " + event.data[ 'text/plain' ] );
					} );
				}

				$( document ).trigger( 'jvfrm_home_sns:init' );
			}
		},

		showReport : function() {
			var obj		= this;
			return function( e ) {
				e.preventDefault();
				jQuery.lava_msg({
					content			: $( '#lava-wg-single-report-template' ).html()
					, classes		: 'lava-wg-single-report-dialog'
					, close			: 0
					, close_trigger	: '.lava-wg-single-report-dialog .close'
					, blur_close	: true
				});
			}
		},

		copyLink : function() {
			return function( e ) {
				e.preentDefault();
				// Todo : Code here.
			}
		},

		bindResize : function() {
			var
				obj = this,
				container = $( ".jv-single-map-wapper" ),
				parent = container.parent(),
				posLeft = 0;
			return function() {
				var
					is_boxed		= $( 'body' ).hasClass( 'boxed' )
					, offset			= parent.offset().left
					, dcWidth		= $( window ).width()
					, pdParent	= parseInt( parent.css( 'padding-left' ) )

				if( is_boxed )
					return;
				if( offset > 0 ) {
					posLeft		= -( offset );
				} else {
					posLeft		= 0;
				}
				container.css({
					marginLeft	: posLeft - pdParent
					, width		: dcWidth
				});
			}
		},

		single_resize : function() {
			var halfContainer = $( ".half-wrap" );
			return function() {
				// return false;
				var dcHeight = $( window ).height();
				$( '.half-left-wrap, .half-right-wrap', halfContainer ).height( dcHeight );
			}
		},

		readMore : function( obj ) {
			return function( e ) {
				e.preventDefault();
				$( this ).closest( '.expandable-content-wrap' ).addClass( 'loaded' );
			}
		},

		readMoreType2 : function( obj ) {
			return function( e ) {
				e.preventDefault();
				$( this ).closest( '.jv-custom-post-content' ).addClass( 'loaded' );
			}
		},

		imageMore : function(){
			return function(e){
				e.preventDefault();
				var
					container	= $( '#javo-item-detail-image-section' ),
					parseImage	= container.data( 'images' );
				if( typeof $.fn.lightGallery == 'undefined' )
					return;
				container.lightGallery({
					dynamic		: true,
					dynamicEl	: parseImage
				});
			}
		},

		featured_switcher : function() {
			var
				obj = this,
				lat = $( 'input[data-item-lat]' ).val() || 0,
				lng = $( 'input[data-item-lng]' ).val() || 0,
				strOn = $( 'input[data-item-street-visible]' ).val() || 1,
				strlat = $( 'input[data-item-street-lat]' ).val() || 0,
				strlng = $( 'input[data-item-street-lng]' ).val() || 0,
				strheading = parseFloat( $( 'input[data-item-street-heading]' ).val() ) || 0,
				strpitch = parseFloat( $( 'input[data-item-street-pitch]' ).val() ) || 0,
				strzoom = parseFloat( $( 'input[data-item-street-zoom]' ).val() ) || 0,
				container = $( '.javo-core-single-featured-container' ),
				mapDIV = $( '.container-map', container ),
				viewer3d = $( '.container-3dview', container ),
				videoDIV = $( '.container-video', container ),
				streetview = $( '.container-streetview', container );

			var
				btns = $( '.javo-core-single-featured-switcher' ),
				objPano = false,
				opt = {
					map: {
						options:{
							center: new google.maps.LatLng( lat, lng ),
							mapTypeControl : false,
							panControl : false,
							streetViewControl : false,
							zoomControlOptions : {
								position : google.maps.ControlPosition.LEFT_CENTER
							},
							zoom: 16
						}
					},
					marker: { latLng : new google.maps.LatLng( lat, lng ) }
				};

			obj.togglePanel( [ mapDIV, viewer3d, videoDIV, streetview ] );

			$( 'li.switch-map', btns ).on( 'click', function() {
				var isOpen = $( this ).hasClass( 'active' );
				$( 'li', btns ).removeClass( 'active' );
				if( isOpen ) {
					obj.togglePanel( [ mapDIV ], false );
				}else{
					obj.togglePanel( [ mapDIV ], true );
					obj.togglePanel( [ viewer3d, streetview, videoDIV ], false );
					$( this ).addClass( 'active' );
				}
			} );

			$( 'li.switch-streetview', btns ).on( 'click', function() {
				var isOpen = $( this ).hasClass( 'active' );
				$( 'li', btns ).removeClass( 'active' );
				if( isOpen ) {
					obj.togglePanel( [ streetview ], false );
				}else{
					obj.togglePanel( [ streetview ], true );
					obj.togglePanel( [ mapDIV, viewer3d, videoDIV ], false );
					$( this ).addClass( 'active' );
				}
			} );

			$( 'li.switch-3dview', btns ).on( 'click', function() {
				var isOpen = $( this ).hasClass( 'active' );
				$( 'li', btns ).removeClass( 'active' );
				if( isOpen ) {
					obj.togglePanel( [ viewer3d ], false );
				}else{
					obj.togglePanel( [ viewer3d ], true );
					obj.togglePanel( [ mapDIV, streetview, videoDIV ], false );
					$( this ).addClass( 'active' );
				}
			} );

			$( 'li.switch-video', btns ).on( 'click', function() {
				var isOpen = $( this ).hasClass( 'active' );
				$( 'li', btns ).removeClass( 'active' );
				if( isOpen ) {
					obj.togglePanel( [ videoDIV ], false );
				}else{
					obj.togglePanel( [ videoDIV ], true );
					obj.togglePanel( [ mapDIV, streetview, viewer3d ], false );
					$( this ).addClass( 'active' );
				}
			} );

			$( 'li.switch-get-direction', btns ).on( 'click', function() {
				var isOpen = $( 'li.switch-map', btns ).hasClass( 'active' );
				if( ! isOpen ) {
					$( 'li', btns ).removeClass( 'active' );
					$( 'li.switch-map', btns ).addClass( 'active' );
					obj.togglePanel( [ mapDIV ], true );
					obj.togglePanel( [ videoDIV, streetview, viewer3d ], false );
				}
			} );

			if( strOn && strlat && strlng && false  ) {
				opt = $.extend( true, {
					streetviewpanorama : {
						options : {
							container : streetview[0],
							opts : {
								position : new google.maps.LatLng( strlat, strlng ) ,
								pov : { heading: strheading, pitch: strpitch, zoom: 0 }
							}
						}
					}
				}, opt );
			}
			mapDIV.gmap3( opt );

			if( obj.param.map_style )
				mapDIV.gmap3( 'get' ).setOptions({ styles : JSON.parse( obj.param.map_style ) });

			container.removeClass( 'hidden' );
			mapDIV.gmap3({ trigger: 'resize' });
			mapDIV.gmap3( 'get' ).setCenter( new google.maps.LatLng( lat, lng ) );
			if( strOn && strlat && strlng ) {
				objPano = new google.maps.StreetViewPanorama(
					streetview[0], {
						position : new google.maps.LatLng( strlat, strlng ),
						pov : { heading: strheading, pitch: strpitch, zoom:0.1 }
					}
				);
				mapDIV.gmap3( 'get' ).setStreetView( objPano );
			}
			$( document ).trigger( 'lava:single-msp-setup-after', { el: mapDIV, latLng: new google.maps.LatLng( lat, lng ) } );
		},

		togglePanel : function( panels, onoff ) {
			$.each( panels, function( index, panel ) {
				if( !onoff ) {
					$( this ).removeClass( 'active' ).animate( { 'left': '-100%'}, 500 );
				}else{
					$( this ).addClass( 'active' ).animate( { 'left': '0%' }, 500 );
				}
			} );
		}

	}
	new jvfrm_home_single_template_script( $( "form.lava-wg-author-contact-form" ) );
})( jQuery );