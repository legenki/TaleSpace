;( function( $ ) {
	"use strict";
	var jvfrm_home_wp_media = function( opt )
	{
		if( ! window.__JAVO_WP_MEDIA__ )
		{
			window.__JAVO_WP_MEDIA__ = true;
			this.attr = $.extend( true, {}, {
				template				: null
				, container				: null
				, add_button			: $( "[data-javo-wp-media-add]" )
				, delete_button			: $( "[data-javo-wp-media-del]" )
				, input_name			: "jvfrm_home_detail_images[]"
			}, opt );
			if( typeof this.attr.template === 'object' )
				this.iContainer	= this.attr.template.html();
			this.init();
		}
	}
	jvfrm_home_wp_media.prototype = {
		constructor : jvfrm_home_wp_media
		, init : function ()
		{
			var opt			= this.attr;
			$( document )
							.on( 'click', opt.add_button.selector	, this.upload() )
							.on( 'click', opt.delete_button.selector	, this.delete )
		}
		, upload : function()
		{
			var obj				= this;
			var panel_title		= this.attr.panel_title || '';
			var select_title	= this.attr.select_title || 'Select';
			return function( e ){
				e.preventDefault();
				var file_frame;
				if( file_frame ){
					file_frame.open();
					return;
				}
				file_frame = wp.media.frames.file_frame = wp.media({
					title		: panel_title
					, button	: {
						text	: select_title
					}
					, multiple	: false
				});
				file_frame
					.on( 'select', obj.add_attach( file_frame ) )
					.open();
			}
		}
		, add_attach : function( el )
		{
			var obj				= this;
			var opt				= obj.attr;
			var str				= obj.iContainer;
			var element			= obj.attr.container;
			return function(){
				var attachment		= el.state().get( 'selection' ).first().toJSON();
				var	img_url = attachment.url;
				if( attachment.sizes.thumbnail.url )
					img_url =  attachment.sizes.thumbnail.url;
				str = str.replace( /{image_src}/g			, img_url );
				str = str.replace( /{image_id}/g			, attachment.id );
				str = str.replace( /{image_input_name}/g	, opt.input_name );
				element.append( str );
			}
		}
		, delete : function( e )
		{
			e.preventDefault();
			var el			= $( this ).closest( '.item' );
			el.remove();
		}
	}
	jQuery.jvfrm_home_wp_media = function(opt){
		new jvfrm_home_wp_media(opt);
	};
} )( jQuery );