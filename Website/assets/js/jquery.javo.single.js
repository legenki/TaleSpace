( function( window, $, undef ) {
	"use strict";
	var jvfrm_home_detail_item = function( options )
	{
		var
			opt = $.extend(
				true
				, {
					map			: null
					, param		: null
					, street	: null
				}
				, options
			)
			, param			= opt.param
			, lat			= parseFloat( param.find( "[data-item-lat]" ).val() ) || 0
			, lng			= parseFloat( param.find( "[data-item-lng]" ).val() ) || 0
			, radius		= parseInt( param.find( "[data-latlng-radius]" ).val() ) || 0
			, panel			= param.find( "[data-cummute-panel]" ).val()
			, marker_icon	= param.find( "[data-marker-icon]" ).val() || '';
		this.el				= opt.map;
		this.param			= param;
		this.latLng			= new google.maps.LatLng( lat, lng );
		this.radius			= radius;
		this.panel			= panel;
		this.marker_icon	= marker_icon;
		if( ! window.__JAVO_Di__ )
			this.init();
	}
	$.jvfrm_home_single = function( options ) {
		new jvfrm_home_detail_item( options );
	}
	jvfrm_home_detail_item.prototype = {
		constructor: jvfrm_home_detail_item
		, init : function()
		{
			window.__JAVO_Di__	= true;
			//this.setCoreMapContainer();
			$( window ).on( 'load',  this.document_loaded() );
		}
		, setCoreMapContainer : function()
		{
			var
				obj								= this
				, el							= obj.el
				, latLng						= obj.latLng;
			var options		= {
				map : {
					options : {
						center					: latLng
						, mapTypeId				: google.maps.MapTypeId.ROADMAP
						, mapTypeControl		: true
						, panControl			: false
						, scrollwheel			: false
						, draggable				: true
						, streetViewControl		: true
						, zoomControl			: true
					}
				}
				, panel							: {
					options						: { content: "<div id=\"javo-Di-map-panel\"></div>" }
					, top						: true
					, left						: true
				}
			};
			if( obj.radius )
			{
				options.map.options.zoom		= 16;
				options.circle					= {
					options						: { center : latLng, radius : obj.radius, fillColor : "#008BB2", strokeColor : "#005BB7" }
				}
			}else{
				options.map.options.zoom		= 16;
				options.marker					= {
					latLng						: latLng
					, options					: { icon : obj.marker_icon }
				}
			}
			$( window ).on(
				'resize'
				, function(){
					console.log( el );
					if( el.hasClass( 'no-marked' ) ) {
						console.log(el);
						return;
					}
					el.css({
						height					: 700
						, marginLeft			: -( Math.abs( el.closest( '.row' ).offset().left ) )
						, width					: $( window ).width()
					});
				}
			).trigger( 'resize' );
			if( this.panel )
				options.panel					= false;
			this.map							= el.gmap3( options );
			if( ! this.panel )
				$( "#javo-Di-map-panel-inner" )	.appendTo( '#javo-Di-map-panel' );
			this.getPlaceService(
				$( ".javo-Di-locality" )
				, "restaurant|movie_theater|bar"
				, $( '.javo-Di-map-filter' )
			);
			this.getPlaceService(
				$( ".javo-Di-commutes" )
				, "airport|bus_station|train_station"
			);
			return this;
		}
		, getPlaceService : function( el, filterKeyword, trigger )
		{
			var
				results
				, places		= {}
				, obj			= this
				, filters		= filterKeyword.split( "|" );
			var callback = function( response )
			{
				if( "OK" === response.result.status )
				{
					results = response.result.results;
					$.each(
						results
						, function( place_index, place_meta )
						{
						if( filters )
							for( var j = 0 in filters )
								if( place_meta.types.indexOf( filters[ j ] ) > -1 )
									if( typeof places[ filters[ j ] ] == "undefined" ) {
										places[ filters[ j ] ] = new Array( place_meta );
									}else{
										places[ filters[ j ] ].push( place_meta );
									}
						}
					); // End results each
					$.each(
						places
						, function( type_name, types )
						{
							var str = "";
							$.each(
								types
								, function( item_index, place_item )
								{
									var parseDistance = function( index, length ){
										return function( result, STATUS )
										{
											if( STATUS === "OK" )
											{
												var meta = result.rows[0].elements[0];
												if( meta.status === "OK" ) {
													str += "<li>";
														str += "<div class=\"row\">";
															str += "<div class=\"col-md-8\">";
																str += place_item.name;
															str += "</div>";
															str += "<div class=\"col-md-4 text-right\">";
																str += meta.distance.text + "/" + meta.duration.text;
															str += "</div>";
														str += "</div>";
													str += "</li>";
												}
												if( index == length )
													$( el.selector + "[data-type='" + type_name + "']" ).html( str );
											}
										}
									}
									obj.map.gmap3({
										getdistance:{
											options:{
												origins			: [ obj.latLng ]
												, destinations	: [ place_item.geometry.location ]
												, travelMode	: google.maps.TravelMode.DRIVING
											}
											, callback : parseDistance( item_index, ( types.length -1) )
										}
									});	// End Gmap3
								}
							); // End place item each
						}
					); // End Types each
				}
			}
		}
		, setCompareDistance : function ( p1, p2 )
		{
			// Google Radius API
			var R = 6371;
			var dLat = (p2.lat() - p1.lat()) * Math.PI / 180;
			var dLon = (p2.lng() - p1.lng()) * Math.PI / 180;
			var a = Math.sin(dLat / 2) * Math.sin(dLat / 2) +
			Math.cos(p1.lat() * Math.PI / 180) * Math.cos(p2.lat() * Math.PI / 180) *
			Math.sin(dLon / 2) * Math.sin(dLon / 2);
			var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
			var d = R * c;
			return d;
		}
		, availableStreeview : function()
		{
			var
				obj					= this
				, pano				= new google.maps.StreetViewService
				, params			= obj.param
				, streetPosition	= new google.maps.LatLng(
					parseFloat( params.find( "[data-street-lat]" ).val() || 0 )
					, parseFloat( params.find( "[data-street-lng]" ).val() || 0 )
				)
			// param1: Position, param2: Round, param3: callback
			pano.getPanoramaByLocation(
				streetPosition
				, 50
				, function( e ){
					if( e != null )
						$('[data-javo-single-streetview]').removeClass('hidden');
				}
			);
			return this;
		}
		, document_loaded : function()
		{
			var obj = this;
			return function()
			{
				if( obj.el.length )
					obj
						.setCoreMapContainer()
						.availableStreeview();
			}
		}
	}
} )( window, jQuery );