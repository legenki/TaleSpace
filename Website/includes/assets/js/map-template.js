/**
 *
 * Map Template Script
 * @author javo Themes
 * @since 1.0.0
 * @description Lava Direction Map Template Script
 *
 */

( function( $ ){
	"use strict";

	var
		BTN_OK = $( '[javo-alert-ok]' ).val(),
		ERR_LOC_ACCESS = jvfrm_home_core_map_param.strLocationAccessFail;

	window.jvfrm_home_map_box_func = {

		options:{

			// Lava Configuration
			config:{
				items_per: $('[name="javo-box-map-item-count"]').val()
			},

			// Google Map Parameter Initialize
			map_init:{
				map:{
					options:{
						mapTypeId: google.maps.MapTypeId.ROADMAP
						, mapTypeControl	: true
						, mapTypeControlOptions:{
								position:google.maps.ControlPosition.RIGHT_TOP
						}
						, panControl		: false
						, scrollwheel		: false
						, streetViewControl	: true
						, zoomControl		: true
						, zoomControlOptions: {
							position: google.maps.ControlPosition.RIGHT_BOTTOM
							, style: google.maps.ZoomControlStyle.SMALL
						 }
					}
					, events:{
						click: function(){
							var obj = window.jvfrm_home_map_box_func;
							obj.close_ib_box();
						}
					}
				}
				, panel:{
					options:{
						content:$('#javo-map-inner-control-template').html()
					}
				}
			}

			// Google Point Of Item(POI) Option
			, map_style:[
				{
					featureType: "poi",
					elementType: "labels",
					stylers: [
						{ visibility: "off" }
					]
				}
			]
		} // End Options

		,variable:{
			top_offset:
				parseInt( $('header > nav').outerHeight() || 0 ) +
				parseInt( $('#wpadminbar').outerHeight() || 0 )

			// Topbar is entered into Header Navigation.
			// + $('.javo-topbar').outerHeight()

		} // End Define Variables

		, getOptions : function()
		{
			// Ajax
			this.ajaxurl				= obj.args.ajaxurl;
			this.click_on_marker_zoom	= parseInt( obj.args.marker_zoom_level ) || false;
		}

		// Lava Maps Initialize
		, init: function()
		{

			/*
			*	Initialize Variables
			*/
			var obj					= this;

			this.args				= jvfrm_home_core_map_param;

			this.getOptions();

			// Map Element
			this.el					= $('.javo-maps-area');
			this.panel				= $( ".javo-maps-panel-wrap" );

			// Google Map Bind
			this.el					.gmap3( this.options.map_init );
			this.map				= this.el.gmap3('get');

			this.map.setOptions({ styles: this.getStyles() });

			// MouseWheel
			if( obj.args.allow_wheel )
				this.map.setOptions({ scrollwheel : true });

			//this.tags				= $('[javo-map-all-tags]').val().toLowerCase().split( '|' );
			this.tags				= new Array();

			// Layout
			this.layout();

			// Trigger Resize
			this.resize();

			// Setup Distance Bar
			this.setDistanceBar();

			// Hidden Footer
			$('.container.footer-top').remove();

			// Set Google Information Box( InfoBubble )
			this.setInfoBubble();

			var is_cross_domain = obj.args.cross_domain == '1';
			var json_ajax_url = obj.args.json_file;
			var parse_json_url = json_ajax_url;

			if( is_cross_domain )
			{
				parse_json_url = this.ajaxurl;
				parse_json_url += "?action=jvfrm_home_get_json";
				parse_json_url += "&fn=" + json_ajax_url;
				parse_json_url += "&callback=?";
			}

			// Events
			; $( document )
				.on( 'click'	, '.javo-hmap-marker-trigger', this.marker_on_list )
				//.on( 'change'	, 'select[name^="filter"]', this.filter_trigger )
				.on( 'click'	, '[data-javo-map-load-more]', this.load_more )
				// .on( 'click', 'button[name="map_order[order]"]', this.order_switcher() )
				.on( 'click', '.javo-map-filter-order > label.btn', this.order_switcher() )
				.on( 'change', 'input[name="map_order[orderby]"]', function(){ obj.filter(); })
				.on( 'keypress'	, '#javo-map-box-auto-tag', this.keyword_ )
				.on( 'click'	, '[data-map-move-allow]', this.map_locker )
				.on( 'click'	, '#javo-map-box-search-button', this.search_button )
				.on( 'click'	, '.javo-my-position', this.getMyPosition() )
				.on( 'keydown'	, '#javo-map-box-location-ac', this.setGetLocationKeyword )
				.on( 'keydown'	, '#javo-map-box-location-trigger', this.trigger_location_keyword() )
				.on( 'change'	, 'select[name^="list_filter"]', this.trigger_selectize_filter() )
				.on( 'javo:filter_reset', this.filter_reset() )
				.on( 'javo:map_refresh', function(){ obj.filter(); })
				.on( 'javo:doing', this.doing() )
				.on( 'javo:map_pre_get_lists', this.control_manager( true ) )
				.on( 'javo:map_get_lists_after', this.control_manager( false) )
				.on( 'javo:map_info_window_loaded', this.info_window_events() )

			; $( window )
				.on( 'resize', this.resize )
				.on( 'javo:init', this.setAutoComplete );

			this.moduleLink();

			$( window ).trigger( 'javo:init', obj );

			; if( typeof this.append_function == 'function' )
				this.append_function();

			// DATA
			$.getJSON( parse_json_url, function( response )
			{
				obj.items		= response;
				$.each( response, function( index, key ){
					obj.tags.push( key.post_title );
				} );

				obj.setKeywordAutoComplete();

				if( $( "#javo-map-box-location-ac" ).val() ) {
					obj.setGetLocationKeyword( { keyCode:13, preventDefault: function(){} } );
				}else{
					obj.filter();
				}

				if( $( "[name='get_pos_trigger']" ).val() )
					$( ".javo-my-position" ).trigger( 'click' );
			})
			.fail( function( xhr ) {

				console.log( xhr.responseText );
				obj.items = [];

				obj.filter();

			} );

		} // End Initialize Function

		, clear_map: function()
		{
			//
			this.el.gmap3({
				clear:{
					name:[ 'marker', 'circle' ]
				}
			});
			this.close_ib_box();

		}

		, close_ib_box: function()
		{
			if( typeof this.infoWindo != "undefined" ) {
				this.infoWindo.close();
			}
		}

		, filter_trigger: function(e) {
			var obj = window.jvfrm_home_map_box_func;
			obj.filter();
		}

		, trigger_selectize_filter : function()
		{
			var obj		= this;
			return function()
			{
				var taxonomy	= $( this ).data( 'tax' );
				if( taxonomy ) {
					var sel = $( ".javo-maps-search-wrap [name='map_filter[" + taxonomy + "]']" ).get(0);
					if( typeof sel !== 'undefined' && typeof sel.selectize !== 'undefined' )
						sel.selectize.setValue( $( this ).val() );
				}
			}
		}


		, layout: function()
		{

			var obj = window.jvfrm_home_map_box_func;

			// Initalize DOC
			$('body').css('overflow', 'hidden');

			// POI Setup
			if ( $('[name="jvfrm_home_google_map_poi"]').val() == "off" )
			{
				// Map Style
				this.map_style = new google.maps.StyledMapType( this.options.map_style, {name:'Lava Box Map'});
				this.map.mapTypes.set('map_style', this.map_style);
				this.map.setMapTypeId('map_style');
			}

			$( window ).on( 'load', function() {
				/** Disabled
				$( '.javo-maps-favorites-panel' ).removeClass('hidden')
					.css({
						marginLeft: ( -$('.javo-maps-favorites-panel').outerWidth(true)) + 'px'
						, marginTop: obj.variable.top_offset + 'px'
					}); */
			} );

		} // End Set Layout

		, resize: function()
		{

			var
				obj				= window.jvfrm_home_map_box_func
				, winX			= $(window).width()
				, winY			= 0
				, body			= $( 'html body' )
				, adminbarH	= $('#wpadminbar').outerHeight(true);

			winY += $('header.main').outerHeight(true);
			winY += $('#javo-maps-listings-switcher').outerHeight(true);
			winY += adminbarH;

			if( ! $('.javo-maps-area-wrap').hasClass( 'top-bottom-layout' ) ) {
				$('.javo-maps-area-wrap').css( 'top', winY );
				$('.javo-maps-search-wrap' ).css( 'top', winY );
				$('.javo-maps-panel-wrap').css( 'top', winY);
			}

			$( 'body' ).css( 'paddingTop' , adminbarH + 'px' );
			body.addClass( "over-flow-y-scroll" );

			if( parseInt( winX ) >= 1120 && obj.list_type == 'map' ) {
				body.addClass( "no-scrolling" );
			}else{
				body.removeClass( "no-scrolling" );
			}

			$( document ).trigger( 'javo:map_template_reisze', winX );

		} // End Responsive( Resize );

		, setDistanceBar: function()
		{
			var
				obj			= this,
				el		= $( ".javo-geoloc-slider, .javo-geoloc-slider-trigger" ),
				_unit		= obj.args.distance_unit || 'km',
				unitcon	= _unit != 'km' ? 1609.344 : 1000,
				_max		= obj.args.distance_max || 1000,
				max		= parseInt( _max ) * unitcon,
				step		= parseInt( max ) / 100,
				cur		= parseInt( $( "[name='set_radius_value']").val() * unitcon ) || ( parseInt( max ) / 2 );

			var opt		= {
				start		: cur,
				step		: step,
				connect	: 'lower',
				range		: { 'min': 0, 'max': max },
				serialization:{
					lower:[
						$.Link({
							target : '-tooltip-<div class="javo-slider-tooltip"></div>'
							, method : function(v) {
								$(this).html('<span>' + v + '&nbsp;' + _unit + '</span>');
							}
							, format : {
								decimals	: 0
								, thousand	:','
								, encoder	: function( a ){
									return a / unitcon;
								}
							}
						})
					]
				}
			};

			if( ! el.length )
				return;

			el
				.noUiSlider( opt )
				.css( 'margin', '15px 0' );

			$( el.get(0) )
				.on( 'set', function( e )
				{
					// if( ! $( '.javo-my-position' ).hasClass( 'active' ) ) return false;

					var
						distance	= parseInt( $( this ).val() ),
						_address	= $( '#javo-map-box-location-ac' ).val();

					if( ! _address ) {
						$( '.javo-my-position' ).trigger( 'click' );
						return false;
					}

					obj.el.gmap3({
						getlatlng:{
							address		: _address
							, callback	: function( results ){

								if( ! results ){
									// $.jvfrm_home_msg({content: ERR_LOC_ACCESS, button: BTN_OK });
									alert( ERR_BED_ADDRESS );
									return false;
								};

								var
									latlng			= results[0].geometry.location
									, result		= []
									, data			= obj.items
									, geo_input		= $( '.javo-location-search' );

								$.each( obj.items, function( i, k )
								{
									var c = obj.setCompareDistance( new google.maps.LatLng( k.lat, k.lng ), latlng );

									if( ( c * unitcon ) <= distance  )
									{
										result.push( data[i] );
									}
								} );

								window.__LAVA_MAP_BOX_TEMP__ = result;

								obj.filter( result );

								obj.map_clear( false );
								obj.el.gmap3({ clear:{ name: 'circle' } });

								$(this).gmap3({
									circle:{
										options:{
											center:latlng
											, radius		: distance
											, fillColor		: '#2099CD'
											, strokeColor	: '#1A759C'
										}
									}
								},
								{
									get:{
										name: 'circle'
										, callback: function(c){
											$(this).gmap3('get').fitBounds( c.getBounds() );
										}
									}
								});
							}
						}
					});
				}) // End

			$( el.get(1) )
				.on( 'set', function( e ) {
					$( el.get(0) ).val( $( this ).val() ).trigger( 'set' );

				}) //End;


		} // End Setup Distance noUISlider

		, setAutoComplete : function()
		{

			$( ".javo-location-search" ).each(
				function( i, element )
				{
					var google_ac = new google.maps.places.Autocomplete( element );
				}
			);

		} // End Setup AutoComplete  Selectize

		, map_locker: function( e )
		{
			e.preventDefault();

			var
				obj			= window.jvfrm_home_map_box_func,
				strLock	 = $( this ).data( 'lock' ),
				strUnlock = $( this ).data( 'unlock' );


			$( this ).toggleClass('active');

			if( $( this ).hasClass('active') )
			{
				// Allow
				obj.map.setOptions({ draggable: true, scrollwheel: true });
				$( this ).find('i').removeClass('fa fa-lock').addClass('fa fa-unlock');
				$( this ).prop( 'title', strLock );
			}else{
				// Not Allowed
				obj.map.setOptions({ draggable:false, scrollwheel: false });
				$( this ).find('i').removeClass('fa fa-unlock').addClass('fa fa-lock');
				$( this ).prop( 'title', strUnlock );
			}
		}

		/** GOOGLE MAP TRIGGER				*/
		, setInfoBubble: function()
		{
			this.infoWindo = new InfoBubble({
				minWidth:320
				, minHeight:190
				, overflow:true
				, shadowStyle: 1
				, padding: 0
				, borderRadius: 5
				, arrowSize: 20
				, borderWidth: 0
				, disableAutoPan: false
				, hideCloseButton: false
				, arrowPosition: 50
				, arrowStyle: 0
			});
		} // End Setup InfoBubble

		, search_button: function( e )
		{
			e.preventDefault();
			var obj			= window.jvfrm_home_map_box_func;
			if( $( "#javo-map-box-location-ac" ).val() ) {
				$( '.javo-geoloc-slider' ).trigger( 'set' );
			}else{
				obj.filter();
			}
		}

		, keywordMatchesCallback: function( tags )
		{
			return function keywordFindMatches( q, cb )
			{
				var matches, substrRegex;

				substrRegex		= new RegExp( q, 'i');
				matches			= [];

				$.each( tags, function( i, tag ){
					if( substrRegex.test( tag ) ){
						matches.push({ value : tag });
					}
				});
				cb( matches );
			}
		}
		, setKeywordAutoComplete: function()
		{
			this.el_keyword = $( '#javo-map-box-auto-tag' );

			this.el_keyword.typeahead({
				hint					: false
				, highlight			: true
				, minLength		: 1
			}, {
				name			: 'tags'
				, displayKey	: 'value'
				, source		: this.keywordMatchesCallback( this.tags )
			}).closest('span').css({ width: '100%' });
		},

		filter : function( data ) {
			var obj			= window.jvfrm_home_map_box_func;

			if( $( '.javo-my-position' ).hasClass( 'active' ) ) {
				var items	= window.__LAVA_MAP_BOX_TEMP__ || obj.items;
			}else{
				var items	= data || obj.items;
			}

			items = obj.apply_multiple_filter( $("[name='jvfrm_home_map_multiple_filter']") , items );
			items = obj.apply_meta_filter( $( "[data-metakey]", obj.panel ), items );
			items = obj.apply_keyword( items );

			if( typeof obj.extend_filter == "function" )
				items = obj.extend_filter( items );

			/* Sort */{
				items = obj.apply_order( items );
			}

			/* Featured Item Filter */{
				items = obj.featured_filter( items );
			}

			obj.setMarkers( items );

			$('.javo-maps-panel-list-output #products').empty();
			$('#javo-listings-wrapType-container').empty();
			obj.apply_item = items;
			obj.append_list_item( 0 );


			$( document ).trigger( 'javo:map_updated', [ items ] );
		},

		filter_reset : function () {
			var obj		= this;
			return function ()
			{
				var
					el_location		= $( "#javo-map-box-location-ac, #javo-map-box-location-trigger" )
					, el_terms		= $( "[name='jvfrm_home_map_multiple_filter'], [name='jvfrm_home_list_multiple_filter']" )
					, el_col_filter	= $( ".javo-map-box-filter-items [data-dismiss-filter]" );

				// Location initialize
				el_location.val( '' );

				// Other Column filter
				el_col_filter.trigger( 'click' );

				// Other filter initialize
				el_terms.prop( 'checked', false );
			}
		}

		, apply_multiple_filter: function( terms, data )
		{
			var
				obj = this,
				result = [],
				term = {},
				is_cond_and = obj.args.amenities_filter == 'and';

			terms.each(
				function()
				{
					var taxonomy = $( this ).data( 'tax' );
					if( $( this ).is( ":checked" ) )
						if( typeof term[ taxonomy ] == "undefined" ) {
							term[ taxonomy ] = new Array( $( this ).val() );
						}else{
							term[ taxonomy ].push( $( this ).val() );
						}
				}
			);

			if( Object.keys(term).length ){
				$.each(
					data,
					function( i, k ) {

						$.each(
							term,
							function( taxonomy, term_ids ) {
								var is_append = true;
								for( var j in term_ids ){
									if( typeof k[ taxonomy ] != "undefined" ){
										if( k[ taxonomy ].indexOf( term_ids[j] ) > - 1 ) {
											if( is_cond_and ){
												is_append = is_append && true;
											}else{
												result.push( data[i] );
												return false;
											}
										}else{
											is_append = false;
										}
									} // if typeof
								} // For
								if( is_cond_and && is_append ) {
									result.push( data[i] );
								}
							}
						);
					}
				);
			}else{
				result = data;
			}
			return result;
		},

		apply_meta_filter : function( filters, items ) {
			if( filters.length ) {
				$.each(
					filters
					, function( indexFilteri , element )
					{
						var
							result			= []
							, strKey		= $( this ).data( 'metakey' )
							, strValue		= $( this ).val();

						if( strValue ) {
							$.each( items, function( i, k ) {

								if( k[ strKey ].toString().indexOf( strValue ) > -1 )
									result.push( items[i] );
							} );
							items = result;
						}
					}
				);
			}
			return items;
		},

		apply_keyword: function( data ) {
			var obj			= window.jvfrm_home_map_box_func;
			var keyword		= $("#javo-map-box-auto-tag" ).val();
			var result		= [];

			if( keyword != "" && typeof keyword != "undefined" )
			{
				keyword = keyword.toLowerCase();
				$.each( data , function( i, k ){
					if(
						obj.tag_matche( k.tags, keyword ) ||
						k.post_title.toLowerCase().indexOf( keyword ) > -1
					){
						result.push( data[i] );
					}
				});
			}else{
				result = data;
			}
			return result;
		},

		tag_matche: function( str, keyword ) {
			var i = 0;
			if( str != "" )
			{
				for( i in str )
				{
					// In Tags ?
					if( str[i].toLowerCase().match( keyword ) )
					{
						return true;
					}
				}
			}
			return false;
		}

		, keyword_ : function( e )
		{
			var obj			= window.jvfrm_home_map_box_func;
			if( e.keyCode == 13 ) {
				if( $( "#javo-map-box-location-ac" ).val() ) {
					$( '.javo-geoloc-slider' ).trigger( 'set' );
				}else{
					obj.filter();
				}
			}
		},

		featured_filter : function( data ){

			var
				obj = this,
				result = new Array(),
				features = new Array(),
				others = new Array();

			if( obj.args.panel_list_featured_first != 'enable' )
				return data;

			$.each( data, function( i, k ) {
				typeof k.f != 'undefined' && k.f.toString() == '1' ? features.push( data[ i ] ) : others.push( data[ i ] );
			} );

			result = $.merge( features, others );

			return result;
		},

		setMarkers: function( response ) {

			var item_markers	= new Array();
			var obj				= window.jvfrm_home_map_box_func;
			var bounds = new google.maps.LatLngBounds();

			obj.map_clear( true );

			if( response ) {
				$.each( response, function( i, item ){

					if( typeof item != "undefined" && item.lat != "" && item.lng != "" )
					{
						var
							default_marker	= obj.args.map_marker,
							map_marker	= item.icon || default_marker;

						if( obj.args.marker_type == 'default' )
							map_marker		= default_marker;

						item_markers.push( {
							//latLng		: new google.maps.LatLng( item.lat, item.lng )
							lat			: item.lat
							, lng		: item.lng
							, options	: { icon: map_marker }
							, id		: "mid_" + item.post_id
							, data		: item
						} );
						bounds.extend( new google.maps.LatLng( item.lat, item.lng ) );
					}
				});
			}

			if( item_markers.length > 0 )
			{

				var _opt = {
					marker:{
						values:item_markers
						, events:{
							click: function( m, e, c ){

								var map = $(this).gmap3( 'get' );
								obj.infoWindo.setContent( $( "#javo-map-loading-template" ).html() );
								obj.infoWindo.open( map, m);

								if( obj.click_on_marker_zoom )
									map.setCenter( m.getPosition() );

								//obj.ajaxurl

								$.post(
									obj.ajaxurl
									, {
										action		: "jvfrm_home_map_info_window_content"
										, post_id	: c.data.post_id
									}
									, function( response )
									{
										var str = '', nstr = '';
										if( response.state == "success" )
										{
											str = $('#javo-map-box-infobx-content').html();
											str = str.replace( /{post_id}/g		, response.post_id || '' );
											str = str.replace( /{post_title}/g	, response.post_title || '' );
											str = str.replace( /{post_date}/g	, response.post_date || '' );
											str = str.replace( /{permalink}/g	, response.permalink || '' );
											str = str.replace( /{thumbnail}/g	, response.thumbnail );
											str = str.replace( /{category}/g	, response.category || nstr );
											str = str.replace( /{location}/g	, response.location );
											str = str.replace( /{phone}/g		, response.phone || nstr );
											str = str.replace( /{mobile}/g		, response.mobile || nstr );
											str = str.replace( /{website}/g		, response.website || nstr );
											str = str.replace( /{email}/g		, response.email || nstr );
											str = str.replace( /{address}/g		, response.address || nstr );
											str = str.replace( /{author_name}/g	, response.author_name || nstr );
											str = str.replace( /{featured}/g	, ( typeof response.featured != 'undefined' ? 'featured-item' : '' ) );
											str = str.replace( /{type}/g		, response.type || nstr );
											str = str.replace( /{meta}/g		, response.meta || nstr );
											str = str.replace( /{rating}/g			, response.rating || '');

										}else{
											str = "error";
										}
										$( "#javo-map-info-w-content" ).html( str );
										$( document ).trigger( 'jvfrm_home_sns:init' );
										$( document ).trigger( 'javo:map_info_window_loaded' );
									}
									, 'json'
								)
								.fail( function( response ){
									//$.jvfrm_home_msg({ content: $( "[javo-server-error]" ).val(), delay: 10000 });
									// alert( $( "[javo-server-error]" ).val() );
									console.log( response.responseText );
								} );
							} // End Click
						} // End Event
					} // End Marker
				}

				if( obj.args.cluster != "disable" ) {
					_opt.marker.cluster = {
						radius: parseInt( obj.args.cluster_level || 100 )
						, 0:{ content:'<div class="javo-map-cluster admin-color-setting">CLUSTER_COUNT</div>', width:52, height:52 }
						, events:{
							click: function( c, e, d )
							{
								var $map = $(this).gmap3('get');
								var maxZoom = new google.maps.MaxZoomService();
								var c_bound = new google.maps.LatLngBounds();

								// IF Cluster Max Zoom ?
								maxZoom.getMaxZoomAtLatLng( d.data.latLng , function( response ){
									if( response.zoom <= $map.getZoom() && d.data.markers.length > 0 )
									{
										var str = '';

										str += "<ul class='list-group'>";

										str += "<li class='list-group-item disabled text-center'>";
											str += "<strong>";
												str += obj.args.strings.multiple_cluster;
											str += "</strong>";
										str += "</li>";

										$.each( d.data.markers, function( i, k ){
											str += "<a onclick=\"window.jvfrm_home_map_box_func.marker_trigger('" + k.id +"');\" ";
												str += "class='list-group-item'>";
												str += k.data.post_title;
											str += "</a>";
										});

										str += "</ul>";
										obj.infoWindo.setContent( str );
										obj.infoWindo.setPosition( c.main.getPosition() );
										obj.infoWindo.open( $map );

									}else{
										if( d.data.markers ) {
											$.each( d.data.markers, function( i, k ) {
												c_bound.extend( new google.maps.LatLng( k.lat, k.lng ) );
											} );
										}

										$map.fitBounds( c_bound );
										/*
										$map.setCenter( c.main.getPosition() );
										$map.setZoom( $map.getZoom() + 2 );
										*/
									}
								} ); // End Get Max Zoom
							} // End Click
						} // End Event
					} // End Cluster
				} // End If

				var init_mapZoom = parseInt( obj.args.map_zoom || 0 );

				if( init_mapZoom > 0 && !obj.zoom_lvl_once ){

					_opt.map = {
						options : { zoom : init_mapZoom }
					}

					_opt.map.options.center = _opt.map.options.center || bounds.getCenter();

					obj.zoom_lvl_once = obj.disableAutofit = true;

				}

				obj.extend_mapOption = {};

				$( document ).trigger( 'javo:parse_marker', obj );

				_opt = $.extend( true, {}, _opt || {}, obj.extend_mapOption || {} );

				if( !obj.disableAutofit ) {
					this.el.gmap3( _opt , "autofit" );
				}else{
					this.el.gmap3( _opt );
					obj.disableAutofit = false;
				}
				return false;
			}
		}

		, map_clear: function( marker_with )
		{
			var elements = new Array( 'rectangle' );
			if( ! $( '.javo-my-position' ).hasClass( 'active' ) )
				elements.push( 'circle' );

			if( marker_with )
				elements.push( 'marker' );

			this.el.gmap3({ clear:{ name:elements } });
			this.iw_close();
		}

		, iw_close: function(){
			if( typeof this.infoWindo != "undefined" )
			{
				this.infoWindo.close();
			}
		}
		, load_more: function( e )
		{
			e.preventDefault();

			var obj			= window.jvfrm_home_map_box_func;
			obj.append_list_item( obj.loaded_ );
		}

		, append_list_item: function( offset )
		{
			var
				obj				= window.jvfrm_home_map_box_func
				, btn				= $( '[data-javo-map-load-more]' )
				, limit			= parseInt( obj.args.loadmore_amount || 10 )
				, panel			= $( ".javo-maps-panel-wrap" )
				, data			=  obj.apply_item
				, jv_integer	= 0;
			this.loaded_		= limit + offset;
			var ids				= new Array();

			if( data )
			{
				$.each( data, function( i, k ){
					jv_integer++;
					if( jv_integer > obj.loaded_ ){ return false; }
					if( typeof k != "undefined" && jv_integer > offset ){
						ids.push( k.post_id );
					}
				});
			}

			btn.prop( 'disabled', true ).find('i').removeClass( 'hidden' );

			$( "#javo-listings-wrapType-container .message-dismiss" ).remove();

			$( document ).trigger( 'javo:map_pre_get_lists' );

			$.post(
				obj.ajaxurl
				, {
					action		: 'jvfrm_home_map_list'
					, post_ids	: ids
					, template	: obj.args.template_id
				}
				, function( response )
				{
					var buf				= '';
					var buf_l			= '';

					var mapOutput, listOutput;

					mapOutput		= listOutput = $( "[javo-map-item-not-found]" ).val();

					if( response && response.map )
						mapOutput	= response.map;

					if( response && response.list )
						listOutput		= response.list;

					$( '.javo-maps-panel-list-output #products' ).append( mapOutput );
					$( '#javo-listings-wrapType-container' ).append( listOutput );
					$( document ).trigger( 'javo:map_get_lists_after' );
					btn.prop( 'disabled', false ).find('i').addClass('hidden');
				}
				, "json"
			)
			.fail( function( response )
			{
				console.log( response.responseText );
			} ) // Fail
			.always( function()
			{
				obj.resize();
			} ) // Complete
		}

		, list_replace : function( str, data )
		{
			var is_featured		= data.f === '1' ? 'space_featured' : false;

			str = str.replace(/{post_id}/g			, data.post_id );
			str = str.replace(/{post_title}/g		, data.post_title || '');
			str = str.replace(/{excerpt}/g			, data.post_content || '');
			str = str.replace(/{thumbnail_large}/g	, data.thumbnail_large || '');
			str = str.replace(/{permalink}/g		, data.permalink || '');
			str = str.replace(/{avatar}/g			, data.avatar || '');
			str = str.replace(/{rating}/g			, data.rating || 0);
			str = str.replace(/{favorite}/g			, data.favorite || '' );
			str = str.replace(/{location}/g			, data.location || '');
			str = str.replace(/{date}/g				, data.post_date || '');
			str = str.replace(/{author_name}/g		, data.author_name || '');
			str = str.replace(/{featured}/g			, is_featured );
			//
			str = str.replace(/{category}/g			, data.category || '');
			str = str.replace(/{type}/g				, data.type || '');
			return str;
		},

		trigger_marker: function( e ) {
			var obj = window.jvfrm_home_map_box_func;
			obj.el.gmap3({
					map:{ options:{ zoom: parseInt( $("[javo-marker-trigger-zoom]").val() ) } }
				},{
				get:{
					name:"marker"
					,		id: $( this ).data('id')
					, callback: function(m){
						google.maps.event.trigger( m, 'click' );
					}
				}
			});
		},

		order_switcher: function() {
			var obj = this;
			return function( e ) {
				e.preventDefault();

				var
					_current = $( this ).data( 'order' ) || 'desc',
					_after = _current == 'desc' ? 'asc' : 'desc';

				if( ! $( this ).hasClass( 'active' ) )
					return;

				$( 'span.desc, span.asc', this ).addClass( 'hidden' );
				$( 'span.' + _after, this ).removeClass( 'hidden' );
				$( this ).data( 'order', _after );

				obj.filter();

				/*
				var
					_cur = $( this ).data( 'order' ),
					_btn = $( 'span', this );
				_btn.addClass( 'hidden' );
				if( _cur == 'desc' ) {
					$( 'span.asc', this ).removeClass( 'hidden' );
					$( this ).data( 'order', 'asc' );
				}else{
					$( 'span.desc', this ).removeClass( 'hidden' );
					$( this ).data( 'order', 'desc' );
				}
				obj.filter();*/
			}
		},

		side_out: function() {
			var panel	= $( ".javo-maps-favorites-panel");
			var btn		= $( ".javo-mhome-sidebar-onoff" );
			var panel_x	=  -( panel.outerWidth() ) + 'px';
			var btn_x	=  0 + 'px';

			panel	.clearQueue().animate({ marginLeft: panel_x }, 300);
			btn		.clearQueue().animate({ marginLeft: btn_x }, 300);
		},

		side_move: function() {
			var panel	= $( ".javo-maps-favorites-panel");
			var btn		= $( ".javo-mhome-sidebar-onoff" );
			var panel_x	=  0 + 'px';
			var btn_x	=  panel.outerWidth() + 'px';
			panel	.clearQueue().animate({ marginLeft: panel_x }, 300);
			btn		.clearQueue().animate({ marginLeft: btn_x }, 300);
		},

		compare : function( orderBy ) {
			var obj = this;
			return function( a, b ){
				if( obj.args.panel_list_random == 'enable' )
					orderBy = 'random';

				switch( orderBy ) {
					case 'random' : return Math.floor( ( Math.random() * ( 1 +1 + 1 ) ) -1 );
					case 'name': return a.post_title < b.post_title ? -1 : a.post_title > b.post_title ? 1: 0; break;
					case 'date': default: return false; break;
				}
			}
		},

		apply_order: function( data ) {
			var
				result = [],
				o = $( "input[name='map_order[orderby]']:checked" ).closest( 'label' ).data( 'order' ),
				t = $( "input[name='map_order[orderby]']:checked" ).val();

			for( var i in data ) {
				result.push( data[i] );
			}

			result.sort( this.compare( t ) );

			if( o.toLowerCase() == 'desc' ) {
				result.reverse();
			}
			return result;
		},

		marker_on_list: function( e ){
			e.preventDefault();

			var obj = window.jvfrm_home_map_box_func;

			obj.marker_trigger( $(this).data('id') );

			if( obj.click_on_marker_zoom )
				obj.map.setZoom( obj.click_on_marker_zoom );
		},

		marker_trigger: function( marker_id ){
			this.el.gmap3({
				get:{
					name		: "marker"
					, id		: marker_id
					, callback	: function(m){
						google.maps.event.trigger(m, 'click');
					}
				}
			});
		}, // End Cluster Trigger

		trigger_location_keyword : function() {
			var obj		= this;
			return function( e ) {

				if( e.keyCode == 13 )
				{
					$( "input#javo-map-box-location-ac" ).val( $( this ).val() ) ;
					obj.setGetLocationKeyword( { keyCode:13, preventDefault: function(){} } );
				}
			}
		},

		setGetLocationKeyword: function( e ) {
			var
				obj					= window.jvfrm_home_map_box_func
				, data				= obj.items
				, el				= $("input#javo-map-box-location-ac")
				, distance_slider	= $( ".javo-geoloc-slider" );

			$( "#javo-map-box-location-trigger" ).val( el.val() );

			if( e.keyCode == 13 ){

				if( el.val() != "" ) {
					distance_slider.trigger( 'set' );
				}else{
					obj.filter( data );
				}
				e.preventDefault();
			}
		},

		setCompareDistance : function ( p1, p2 ) {
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

		, getMyPosition : function()
		{
			var
				obj					= this
				, distance_slider	= $( ".javo-geoloc-slider" );
			return function( e )
			{
				var input			= $( '.javo-location-search' );
				obj.el.gmap3({
					getgeoloc		: {
						callback	: function( latlng ) {

							if( !latlng ){
								$.jvfrm_home_msg({content: ERR_LOC_ACCESS, button: BTN_OK });
								return false;
							};

							$( this ).gmap3({
								getaddress:{
									latLng		: latlng
									, callback	: function( results ) {
										var strValue		= results && results[1].formatted_address;
										input.val( strValue );
										distance_slider.trigger( 'set' );
										$( document ).trigger( 'javo:myposUpdate', strValue );
									}
								}
							});

						}	// Callback
					}	// Get Geolocation
				});
			}
		}
		, doing : function() {
			return function( e ) {
				e.preventDefault();
			}
		}

		, control_manager : function( block ) {
			var
				obj					= this;
			return function() {
				obj.map_control( block );
				obj.list_control( block );

			}
		}

		, map_control : function( block ){
			var
				container		= $( '.javo-maps-search-wrap' ),
				distanceBar	= container.find( '.javo-geoloc-slider' ),
				input			= container.find( 'input' ),
				dropdown	= container.find( 'select' ),
				buttons		= container.find( 'button' ),
				toggleBtn	= container.find( '.javo-map-box-filter-items span' ),
				geoButton	= container.find( '.javo-my-position' ),
				elements		= new Array(
					distanceBar,
					input,
					toggleBtn,
					buttons,
					geoButton
				);

			dropdown.each( function( index, element ) {
				var objSelect	= element.selectize;

				if( typeof objSelect == 'undefined' )
					return;

				if( block ) {
					objSelect.disable();
				}else{
					objSelect.enable();
				}
			} );

			for( var element in elements ) {
				elements[ element ].attr( 'disabled', block );
				if( block ){
					elements[ element ].addClass( 'disabled' );
				}else{
					elements[ element ].removeClass( 'disabled' );
				}
			}
		}

		, list_control : function( block ){
			var
				container		= $( '.jvfrm_home_map_list_sidebar_wrap' ),
				distanceBar	= container.find( '.javo-geoloc-slider' ),
				input			= container.find( 'input' ),
				dropdown	= container.find( 'select'),
				buttons		= container.find( 'button' ),
				geoButton	= container.find( '.javo-my-position' ),
				elements		= new Array(
					distanceBar,
					input,
					dropdown,
					buttons,
					geoButton
				);

			for( var element in elements ) {
				elements[ element ].attr( 'disabled', block );
				if( block ){
					elements[ element ].addClass( 'disabled' );
				}else{
					elements[ element ].removeClass( 'disabled' );
				}
			}
		}

		, moduleLink : function() {
			var
				obj = this,
				type = obj.args.link_type,
				_marker = obj.args.map_marker_hover,
				moduleID	= 0,
				markerInfo	= {},
				callback = function( _this ) {
					return function() {

						var currentModule = _this ? $( this ).data( 'post-id' ) : $( this ).closest( '.module[data-post-id]' ).data( 'post-id' );

						if( moduleID == currentModule )
							return;

						if( moduleID ){
							obj.swapIcon( moduleID, markerInfo.icon, markerInfo.zIndex );
							$( document ).trigger( 'javo:marker_restore', { module_id : moduleID, constructor : obj } );
						}

						moduleID = currentModule;
						markerInfo	= obj.getMarker( moduleID );

						if( obj.click_on_marker_zoom )
							obj.map.setZoom( obj.click_on_marker_zoom );

						obj.swapIcon( currentModule, _marker, 9999, !_this );
						$( document ).trigger( 'javo:marker_release', { module_id : moduleID, constructor : obj } );
					}
				};

			if( type == 'type2' ) {
				$( document ).on ( 'hover', '.module[data-post-id]', callback( true ) );
			}else if( type == 'type3'  ) {
				$( document ).on( 'click', '.module[data-post-id] .move-marker', callback() );
			}
		}

		, getMarker : function( id ) {
			var strReturn		= { icon : false, zIndex : 0 };
			this.el.gmap3({
				get:{ name: 'marker', id:	'mid_' + id, callback : function( marker ) {
					if( !marker )
						return;
					strReturn.icon		= marker.getIcon();
					strReturn.zIndex	= marker.getZIndex();
				}}
			});
			return strReturn;
		}

		, swapIcon : function( id, url, posZ, popup ){
			var
				obj			= this
				, map		= obj.map;
			this.el.gmap3({
				get:{ name: 'marker', id:	'mid_' + id, callback : function( marker ) {
					if( !marker )
						return;
					marker.setIcon( url );

					if( posZ !== false )
						marker.setZIndex( posZ );

					if( ! map.getBounds().contains( marker.getPosition() ) )
						map.setCenter( marker.getPosition() );

					if( popup )
						new google.maps.event.trigger( marker, 'click' );
				}}
			});
		},

		getStyles : function() {
			var
				primary_color = obj.args.map_primary_color,
				arrStyle = obj.args.map_style_json;

			if( typeof arrStyle != 'undefined' && arrStyle != '' )
				return JSON.parse( arrStyle );

			if( !primary_color ){
				return false;
			}
			return [
				{
					featureType:"all",
					elementType:"labels.text.fill",
					stylers:[
						{saturation:36},
						{color:primary_color},
						{lightness:100}
					]
				},
				{
					featureType:"all",
					elementType:"labels.text.stroke"
					,stylers:[
						{visibility:"on"},
						{color:primary_color},
						{lightness:16}
					]
				},
				{
					featureType:"all",
					elementType:"labels.icon",
					stylers:[
						{visibility:"off"}
					]
				},
				{
					featureType:"administrative",
					elementType:"geometry.fill",
					stylers:[
						{color:primary_color},
						{lightness:20}
					]
				},
				{
					featureType:"administrative",
					elementType:"geometry.stroke",
					stylers:[
						{color:primary_color},
						{lightness:50},
						{weight:1.2}
					]
				},
				{
					featureType:"landscape",
					elementType:"geometry",
					stylers:[
						{color:primary_color},
						{lightness:20}
					]
				},
				{
					featureType:"poi",
					elementType:"geometry",
					stylers:[
						{color:primary_color},
						{lightness:21}
					]
				},
				{
					featureType:"road.highway",
					elementType:"geometry.fill",
					stylers:[
						{color:primary_color},
						{lightness:17}
					]
				},{
					featureType:"road.highway",
					elementType:"geometry.stroke",
					stylers:[
						{color:primary_color},
						{lightness:60},
						{weight:0.2}
					]
				},
				{
					featureType:"road.arterial",
					elementType:"geometry",
					stylers:[
						{color:primary_color},
						{lightness:18}
					]
				},
				{
					featureType:"road.local",
					elementType:"geometry",
					stylers:[
						{color:primary_color},
						{lightness:16}
					]
				},
				{
					featureType:"transit",
					elementType:"geometry",
					stylers:[
						{color:primary_color},
						{lightness:60}
					]
				},
				{
					featureType:"water",
					elementType:"geometry",
					stylers:[
						{color:primary_color},
						{lightness:30}
					]
				}
			];
		},

		waitButton : function( button, available ) {
			var _DISABLE = 'disabled';
			if( available ) {
				$( 'i', button ).removeClass( 'fa-spinner fa-spin' );
				button.removeClass( _DISABLE ).removeAttr( _DISABLE ).prop( _DISABLE, false );
			}else{
				$( 'i', button ).addClass( 'fa-spinner fa-spin' );
				button.addClass( _DISABLE ).attr( _DISABLE, _DISABLE ).prop( _DISABLE, true );
			}
		},

		ajax : function( _action, _param, callback, failcallback ) {
			var param = $.extend( true, {}, { action: 'jvfrm_home_' + _action }, _param );
			$.post( this.ajaxurl, param, function( data ) {
				if( typeof callback == 'function' ) {
					callback( data );
				}
			}, 'json')
			.fail( function( xhr, err ){
				if( typeof failcallback == 'function' ) {
					failcallback( xhr, err );
				}
			} );
		},

		info_window_events : function() {
			var
				obj = this,
				modal = $( '#javo-infow-brief-window' ),
				body = $( '.modal-body', modal );
			return function() {
				$( '.javo-infow-brief', obj.el ).on( 'click', function( e ) {
					var
						button = $( this ),
						item_id = button.data( 'id' );

					obj.waitButton( button, false );
					obj.ajax( 'map_brief', { post_id: item_id }, function( data ) {
						body.html( data.html );
						modal.modal( 'show' );
						obj.waitButton( button, true );
					} );
				} );
				$( '.javo-infow-contact', obj.el ).on( 'click', function( e ) {
					var button = $( this );

					obj.waitButton( button, false );
					obj.ajax( 'map_contact_form', {}, function( data ) {
						body.html( data.html );
						modal.modal( 'show' );
						obj.waitButton( button, true );
						obj.after_ajax_contactForm_rebind( body );
					} );
				} );
			}
		},

		after_ajax_contactForm_rebind : function( container ) {
			if( typeof $.fn.wpcf7InitForm == 'function' ) {
				$( 'div.wpcf7 > form', container ).wpcf7InitForm();
			}
		}
	}

	var obj = window.jvfrm_home_map_box_func || {};

	obj.append_function = function()
	{
		$( ".javo-selectize-option" )
			.selectize({ maxItems:3, plugins: ['remove_button'] })
			.each(
				function( i, element ){
					var selectized	= element.selectize;
					selectized.on( 'change', function() {
						if(  $( '#javo-map-box-location-ac' ).val() ) {
							$( '.javo-geoloc-slider' ).trigger( 'set' );
						}else{
							obj.filter();
						}
					});
					$( document ).on( 'javo:filter_reset', function() {
						selectized.clear();
					} );
				}
			);

		// $( ".javo-map-box-advance-filter-wrap" ).sticky({ topSpacing: 150 });


		// Extend Filters Trigger
		$( document )
			.on( 'javo:map_createMark', function( e ){
				var
					container		= $( ".javo-maps-advanced-filter-wrap" )
					, filters			= $( ".javo-map-box-filter-items" )
					, meta			= $( "select", container )
					, strX			= '&times;'
					, keyword		= $( "#javo-map-box-auto-tag", container )
					, taxonomy	= {}
					, output		= new Array();

					e.preventDefault();

					/* KeyWord */ {
						if( keyword.val() ) {
							output.push( "<span data-dismiss-filter='keyword'>Keyword " + strX + "</span>" );
						}
					}

					/* Meta Dropdown */ {
						$.each( meta, function( i, k ) {
							var
								name		= $( this ).data( 'name' ),
								filterID	= $( this ).data( 'metakey' );

							if( $( this ).val() )
								output.push(
									"<span data-dismiss-filter='" + filterID + "'> " +
									name + ' ' + strX + "</span>"
								);

						} );
					}

					/* Mutiple Fileter Toogle */ {
						$( "[name='jvfrm_home_map_multiple_filter']").each( function()
						{
							if( $( this).is( ':checked' ) )
								taxonomy[ $( this ).data( 'title' ) ] = $( this ).data('tax');
						});

						$.each( taxonomy, function( tax_name, tax_id ) {
							output.push( "<span data-dismiss-filter=\"" + tax_id + "\">" );
							output.push( tax_name + " &times;" );
							output.push( "</span>" );
						} );
					}

					filters.html( output.join('&nbsp;') );
			} )
			.on(
				"click"
				, "#javo-map-box-advance-filter"
				, function( e, f ) {

					var
						panel			= $( ".javo-maps-search-wrap" ),
						output		= $( ".javo-maps-panel-list-output" ),
						advanced	= $( ".javo-maps-advanced-filter-wrap" ),
						button		= $( ".javo-map-box-advance-filter-apply" );

					e.preventDefault();

					f = f || false;

					if( ! this._run ) {
						advanced.hide();
						button.hide();
						this._run = true;
					}

					if( panel.hasClass( 'collapsed' ) ) {
						button.hide( 'fast' );
						advanced.slideUp( 'fast' );
						panel.removeClass( 'collapsed' );
						output.removeClass( 'hidden' );
						if( obj.panel.hasClass( 'map-layout-top' ) ) {
							$( document ).trigger( 'javo:map_createMark' );

							if( ! f )
								obj.filter();
						}
					}else{
						advanced.slideDown(
							'fast'
							, function(){
								button.show();
							}
						);
						panel.addClass( 'collapsed'  );
						output.addClass( 'hidden' );
					}
					obj.resize();
					$( '.javo-maps-panel-wrap' ).trigger( 'scroll' );
					return;
				}
			)
			.on(
				'click'
				, '.javo-map-box-btn-advance-filter-apply'
				, function( e )
				{
					e.preventDefault();
					$( document ).trigger( 'javo:map_createMark' );
					$( "#javo-map-box-advance-filter" ).trigger( 'click' );
					if( $( "#javo-map-box-location-ac" ).val() ) {
						$( '.javo-geoloc-slider' ).trigger( 'set' );
					}else{
						obj.filter();
					}
					return;
				}
			)
			.on(
				'click'
				, '[data-dismiss-filter]'
				, function( e )
				{
					e.preventDefault();

					var
						eID				= $( this ).data( 'dismiss-filter' )
						, selector		= null
						, container	= $( ".javo-maps-advanced-filter-wrap" )

					switch( eID ) {
						case 'keyword' :
							/* Keyword */ {
								selector	= $( '#javo-map-box-auto-tag', container );
								selector.val( '' );
							}
							break;

						case 'price' :

							selector		= $( "[data-min], [data-max]", container );
							selector.val( '' );
							break;

						default:
							/* Multiple Filter Unset */ {
								selector	= $( "[name='jvfrm_home_map_multiple_filter'][data-tax='" + eID + "']" );
								selector.prop( 'checked', false );
							}
							/* Dropdown Filter Unset */ {
								selector	= $( "select[data-metakey='" + eID + "']" );
								selector.val('');
								if( typeof selector[0] != 'undefined' ) {
									var selectize = selector[0].selectize;
									selectize.clear();
								}
							}
					}

					$( this ).remove();
					if( $( "#javo-map-box-location-ac" ).val() ) {
						$( '.javo-geoloc-slider' ).trigger( 'set' );
					}else{
						obj.filter();
					}
					return;
				}
			)
			.on(
				'click'
				, '#javo-map-box-advance-filter-reset'
				, function (e)
				{
					$( "#javo-map-box-location-ac" ).val();

					$( document )
						.trigger( 'javo:map_refresh' )
						.trigger( 'javo:filter_reset');

				}
			)
			.on(
				'click'
				, '.javo-map-box-advance-filter-trigger'
				, function( e )
				{
					e.preventDefault();
					$( "#javo-map-box-advance-filter" ).trigger( 'click' );
				}
			);
	}

	obj.selectize_filter = function( data, el, taxonomy )
	{
		var
			result	= []
			, term	= {};

		if( el.val() ){
			$.each( data,
				function( i, k )
				{
					$.each( el.val(),
						function( index, term_ids )
						{
							if( typeof k[ taxonomy ] != "undefined" ) {
								if( k[ taxonomy ].indexOf( term_ids ) > - 1 ){
									result.push( data[i] );
									return false;
								}
							}
						}
					);
				}
			);
		}else{
			result = data;
		}

		return result;
	}

	obj.price_filter		= function( data )
	{
		var
			results
			, container	= $( ".javo-maps-advanced-filter-wrap" )
			, price			= $( ".javo-map-box-advance-pricefilter", container )
			, min				= parseInt( $( "[data-min]", price ).val() )
			, max			= parseInt( $( "[data-max]", price ).val() );

		if( !isNaN( min ) && min > 0 ) {
			results			= [];
			$.each( data, function( index, arrMeta ) {
				var price	= parseInt( arrMeta._price );
				if( !isNaN( price ) && ( price >= min ) )
					results.push( data[index] );
			} );
			data				= results;
		}

		if( !isNaN( max ) && max > 0 ) {
			results			= [];
			$.each( data, function( index, arrMeta ) {
				var price	= parseInt( arrMeta._price );
				if( !isNaN( price ) && ( price <= max ) )
					results.push( data[index] );
			} );
			data				= results;
		}
		return data;
	}


	obj.extend_filter	= function( items )
	{
		$.each( obj.args.selctize_terms, function( i, tax_selector ){
			items = obj.selectize_filter( items, $( "[name='map_filter[" + tax_selector + "]']" ), tax_selector );
		} );
		items	 = obj.price_filter( items );
		return items;
	}

	$( '.javo-maps-panel-wrap' ).on(
		'scroll'
		, function(){

			var
				container			= $( this )
				, container_offset	= container.offset().top
				, filter			= $( '.javo-map-box-advance-filter-wrap' )
				, filter_offset		= filter.offset().top;

		}
	);

	$( document ).on( 'javo:map_updated', function( event, items ) {
		var
			element					= $( ".javo-map-filter-result-count" )
			, output				= '';

		output						+= items.length || 0;
		output						+= ' ' + element.data( 'suffix' );
		element.html( output );
	} );

window.jvfrm_home_map_box_func.init();

var jvfrm_home_multi_listing = function(){

	if( ! window.__LAVA_MULTI_LISTINGS__ )
		this.init();
}

jvfrm_home_multi_listing.prototype = {

	constructor : jvfrm_home_multi_listing

	, init : function()
	{
		window.__LAVA_MULTI_LISTINGS__ = 1;

		this.args = jvfrm_home_core_map_param;

		this.showListings();
		this.innerSwitch();
		this.setCommonAction();

		$( document )
			.on( 'javo:apply_sticky'		, this.setStickyContainer() )
			.on( 'javo:map_updated'	, this.showResult() );

		if( $( 'body' ).hasClass( 'mobile-ajax-top' ) )
			$( document ).on( 'javo:map_template_reisze', this.mobileFilter() );

		$( '.javo-maps-panel-wrap' ).on( 'scroll', this.stickyOnPanel() );

		$( document ).ready(  this.setStickyContainer() );
	}

	, setStickyContainer : function()
	{
		return function()
		{
			if( $( "#javo-mhome-item-info-wrap" ).length ) {
				$( "#javo-mhome-item-tabs-navi" ).sticky({
					topSpacing: $( ".javo-mhome-item-info-wrap" ).offset().top
				});
			}
		}
	}

	, stickyOnPanel : function()
	{
		var
			obj								= this;
		return function()
		{
			var
				panel						= $( ".javo-maps-panel-wrap" )
				, button					= $( "#javo-map-box-advance-filter", panel )
				, container				= $( ".javo-map-box-advance-filter-wrap" )
				, sticked_container	= $( ".javo-map-box-advance-filter-wrap-fixed" )
				, container_offset		=	container.offset().top;

			sticked_container.css({
				top		: panel.offset().top
				, width	: panel.width()
			}).hide();

			if( container_offset < 0 )
			{
				if( !obj.sticked ){
					container.children().appendTo( sticked_container );
					obj.sticked	= true;
				}
				sticked_container.show();
			}else{
				if( obj.sticked ){
					sticked_container.children().appendTo( container );
					obj.sticked	= false;
				}
			}
		}
	}

	, showResult : function ()
	{
		return function ( event, items )
		{
			var
				output		= $( ".javo-maps-panel-list-output #products" )
				, template	= $( "#javo-map-not-found-data" ).html();

			if( ! items.length )
				output.html( template );
		}
	}

	, showListings : function()
	{
		var
			obj			= this
			, elements	= $( "#javo-maps-wrap, #javo-listings-wrap" )
			, switcher	= "[type='radio'][name='m']"
			, callback	= function( e ) {
				e.preventDefault();
				var type = $( switcher + ":checked" ).val();

				elements.addClass( 'hidden' );
				$( "#javo-" + type + '-wrap' ).removeClass( 'hidden' );
				obj.process( type );

				$( ".javo-maps-area" ).gmap3({ trigger: 'resize' }, 'autofit' );
				return;
			}
		callback({ preventDefault:function(){} });
		$( document ).on( 'change', switcher, callback );
	},


	innerSwitch : function() {

		var
			container = $( '#javo-maps-listings-wrap' ),
			switcher_wrap = $( '.javo-map-box-inner-switcher' ),
			map_wrap = $( '#javo-maps-wrap', container ),
			inner_switcher = $( '> button', switcher_wrap ),
			map_area = $( '.javo-maps-area-wrap', map_wrap ),
			panel_area = $( '.javo-maps-panel-wrap', map_wrap );

		inner_switcher.on( 'click', function() {

			var strType = $( '.hidden', this ).data( 'value' );

			$( this ).data( 'value', strType );
			$( 'span', this ).addClass( 'hidden' );
			$( 'span[data-value="' + strType + '"]' ).removeClass( 'hidden' );

			if( strType == 'map' ){
				map_area.addClass( 'mobile-active' ).find( '.javo-maps-area' ).gmap3({ trigger: 'resize' }, 'autofit' );
				panel_area.removeClass( 'mobile-active' );
			}else{
				map_area.removeClass( 'mobile-active' );
				panel_area.addClass( 'mobile-active' );
			}

		} ).trigger( 'click' );
	},


	mobileFilter : function() {

		var
			obj = this,
			minMoved = false,
			maxMoved = false,
			panel = $( '.javo-maps-panel-wrap' ),
			filter_wrap = $( '.javo-maps-search-wrap', panel ),
			filters = $( '> .row:not(.javo-map-box-advance-filter-wrap)', filter_wrap ),
			advance_filters = $( '.javo-maps-advanced-filter-wrap', filter_wrap );

		// Disable oneline-type
		if( panel.hasClass( 'jv-map-filter-type-bottom-oneline' ) )
			return false;

		return function( e, width ){

			if( parseInt( width ) < 767 ) {

				if( ! minMoved ){
					filters.prependTo( advance_filters );
					minMoved = true;
				}
				maxMoved = false;
			}else{
				if( ! maxMoved ){
					filters.prependTo( filter_wrap );
					maxMoved = true;
				}
				minMoved = false;
			}
		}

	}


	, setCommonAction : function()
	{
		var
			obj						= window.jvfrm_home_map_box_func
			, listing					= $( '#javo-listings-wrap' )
			, map					= $( '#javo-maps-wrap' )
			, term_elements	= "#javo-listings-wrap [name='jvfrm_home_list_multiple_filter']"
			, price_elements	= $( '#filter-price [data-min], #filter-price [data-max]', listing )
			, key_elements		= $( '#filter-keyword input.jv-keyword-trigger', listing )
			, mypos_trigger	= $( 'button.my-position-trigger', listing )
			, option_elements	= $( "#filter-options [data-metakey]", listing );


		$( document )

		// Multiple Checkbox Filter Trigger
			.on( 'click', term_elements,
				function( e )
				{
					var tax = $( this ).val();

					if( $( this ).is( ":checked" ) ){
						$( "[name='jvfrm_home_map_multiple_filter'][value='" + tax +  "'], [name='jvfrm_home_list_multiple_filter'][value='" + tax +  "']" ).prop( 'checked', true );
					}else{
						$( "[name='jvfrm_home_map_multiple_filter'][value='" + tax +  "'], [name='jvfrm_home_list_multiple_filter'][value='" + tax +  "']" ).prop( 'checked', false );
					}
					obj.filter();
				}
			);

		// Listings > My Position Trigger
		mypos_trigger.on( 'click',
			function( e ){
				e.preventDefault();
				var
					mypos			= $( ".javo-my-position", map );
				mypos.trigger( 'click' );
			}
		);

		// Listings > Keyword Filter Trigger
		key_elements.on( 'keypress',
			function( e ){
				var mapKeyword	= $( "#javo-map-box-auto-tag", map );
				if( e.keyCode ==13 ) {
					mapKeyword.val( $( this ).val() );
					obj.filter();
				}
			}
		);

		// Listings > Optional Trigger
		option_elements.on( 'change',
			function( e ) {
				var target = $( "select[data-metakey='" + $( this ).data( 'metakey' ) + "']", map );
				target.val( $( this ).val() );
				if( $( "#javo-map-box-location-ac" ).val() ) {
					$( '.javo-geoloc-slider' ).trigger( 'set' );
				}else{
					obj.filter();
				}
			}
		);

		// Listing Panel > 
		price_elements.on( 'keypress',
			function( e ) {
				var
					fieldMapMin = $( '.javo-map-box-advance-pricefilter [data-min]' ),
					fieldMapMax = $( '.javo-map-box-advance-pricefilter [data-max]' );
				if( e.keyCode == 13 ) {
					var parent = $( this ).parent();
					fieldMapMin.val( $( '[data-min]', parent ).val() );
					fieldMapMax.val( $( '[data-max]', parent ).val() );
					obj.filter();
				}
			}
		);

	}

	, process : function( type )
	{
		var obj = this;
		window.jvfrm_home_map_box_func.list_type = type;
		window.jvfrm_home_map_box_func.resize();

	} // End Initialize Function


}

new jvfrm_home_multi_listing;

} )( jQuery );