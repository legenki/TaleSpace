;(function($){
	"use strict";
	// WordPress media upload button command.
	// Required: library/enqueue.php:  wp_media_enqueue();
	$("body").on("click", ".javo-fileupload", function(e){
		e.preventDefault();
		var $this = $(this);
		var file_frame;
		if(file_frame){ file_frame.open(); return; }
		file_frame = wp.media.frames.file_frame = wp.media({
			title: $this.data('title'),
			multiple: $this.data('multiple')
		});
		file_frame.on( 'select', function(){
			var attachment;
			if( $this.data('multiple') ){
				var selection = file_frame.state().get('selection');
				selection.map(function(attachment){
					var output = "";
					attachment = attachment.toJSON();

					if( $this.hasClass( 'other' ) ){
						output += "<li class=\"list-group-item jvfrm_home_dim_div\">";
						output += attachment.filename
						output += "<input type='hidden' name='jvfrm_home_attach_other[]' value='" + attachment.id + "'>";
						output += "<input type='button' value='Delete' class='btn btn-danger btn-sm jvfrm_home_detail_image_del'>";
						output += "</li>";
						$( $this.data('preview') ).append( output );

					}else{
						output += "<div class='col-md-3 jvfrm_home_dim_div'>";
						output += "		<div class='col-md-12' style='overflow:hidden;'><img src='" + attachment.url + "' style='height:120px;'></div>";
						output += "		<div class='row'><div class='col-md-12' align='center'>";
						output += "			<input type='hidden' name='jvfrm_home_dim_detail[]' value='" + attachment.id + "'>";
						output += "			<input type='button' value='Delete' class='btn btn-danger btn-xs jvfrm_home_detail_image_del'>";
						output += "		</div>";
						output += "</div>";
						$( $this.data('preview') ).append( output );
					}
				});

				$( window ).trigger( 'update_detail_image' );

			}else{
				attachment = file_frame.state().get('selection').first().toJSON();
				$( $this.data('input')).val(attachment.id);
				$( $this.data('preview') ).prop("src", attachment.url );

				$( window ).trigger( 'update_featured_image' );
			};
		});
		file_frame.open();
		// Upload field reset button
	}).on('click', '.javo-fileupload-cancel', function(){
		$($(this).data('preview')).prop('src', '');
		$($(this).data('input')).prop('value', '');
	}).on("click", ".jvfrm_home_detail_image_del", function(){
		var tar = $(this).data("id");
		$(this).parents(".jvfrm_home_dim_div").remove();
		$("input[name^='jvfrm_home_dim_detail'][value='" + tar + "']").remove();
		$( window ).trigger( 'update_detail_image' );
	});
	jQuery('.javo-color-picker').each(function(i, v){
		$(this).spectrum({
			clickoutFiresChange:true
			, showInitial: true
			, preferredFormat:'hex'
			, showInput: true
			, chooseText: 'Select'
		});
	});

	var jvfrm_home_share_func = function( selector ) {
		this.selector = selector;
		this.init();
	};

	jvfrm_home_share_func.prototype = {

		constructor : jvfrm_home_share_func

		, init : function () {

			var obj = this;

			$( document ).on( 'jvfrm_home_sns:init', function(){
				$( obj.selector ).off( 'click', obj.share() );
				$( obj.selector ).on( 'click', obj.share() );
			} ).trigger( 'jvfrm_home_sns:init' );

		}

		, share : function () {

			var obj			= this;

			return function ( e ) {

				e.preventDefault();

				var output_link		= new Array();

				if( $( this ).hasClass( 'sns-twitter' ) ) {
					output_link.push( "http://twitter.com/share" );
					output_link.push( "?url=" + $( this ).data( 'url' ) );
					output_link.push( "&text=" + $( this ).data( 'title' ) );
				}

				if( $( this ).hasClass( 'sns-facebook' ) ) {
					output_link.push( "http://www.facebook.com/sharer.php" );
					output_link.push( "?u=" + $( this ).data( 'url' ) );
					output_link.push( "&t=" + $( this ).data( 'title' ) );
				}

				if( $( this ).hasClass( 'sns-google' ) ) {
					output_link.push( "https://plus.google.com/share" );
					output_link.push( "?url=" + $( this ).data( 'url' ) );
				}
				window.open( output_link.join( '' ), '' );
			}
		}
	}
	new jvfrm_home_share_func( 'i.sns-facebook, i.sns-twitter, i.sns-google, .javo-share' );


	$('.javo-tooltip').each(function(i, e){
		var options = {};
		if( typeof( $(this).data('direction') ) != 'undefined' ){
			options.placement = $(this).data('direction');
		};
		$(this).tooltip(options);
	});

	$(window).scroll(function () {
		if ($(this).scrollTop() > 50) {
			$('#back-to-top').fadeIn();
			$('.javo-quick-contact-us').fadeIn();
		} else {
			$('#back-to-top').fadeOut();
			$('.javo-quick-contact-us').fadeOut();
		}
		});
		// scroll body to 0px on click
		$('#back-to-top').click(function () {
			$('#back-to-top').tooltip('hide');
			$('body,html').animate({
			scrollTop: 0
		}, 800);
		return false;
	});


	$(window).load(function(){
		$(this).trigger('resize');
	});
})(jQuery);