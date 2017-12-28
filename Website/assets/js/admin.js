/**
 *
 * Backend Script
 * @author javo Themes
 * @since 1.0.0
 * @description Backend(Admin Pages) Scripts
 *
 */
;( function( $, window, undef ) {
	"use strict";

	/**
	 *	Widget Ajax
	 *
	 */
	var jvfrm_home_dtl_func_instanct = function(){

		var elements = $( "[data-javo-dtl-el]" );
		elements.each( function( i, k )
		{
			var
				element_selector	= $( this ).data( "javo-dtl-el" )
				, target					= $( this ).find( $( this ).data( 'javo-dtl-tar' ) )
				, value					= $( this ).data( 'javo-dtl-val' );

			$( document )
				.off( 'change', element_selector )
				.on( 'change', element_selector, function( e ) {

					target.slideUp( 'fast' );
					if( $( this ).is( ":checked" ) && $( this ).val() == value ) {
						target.slideDown( 'fast' );
					}
				} )
				.find( element_selector ).trigger( 'change' );
		} );
	};
	jvfrm_home_dtl_func_instanct();
	$.ajaxSetup({ complete:function(){ jvfrm_home_dtl_func_instanct(); } });

	/**
	 *	Widget Ajax Complete after colorpicker set
	 *
	 */
	var jv_wgColorPicker = function(){
		if( $.__jvwgColorPicker__ )
			return;

		$.__jvwgColorPicker__ = true;

		$( '#wpbody', document ).ajaxComplete(
			function(){
				$( '.wp_color_picker' ).each(
					function( index, element ) {
						$( this ).wpColorPicker();
						$( this ).parent().find( '.wp-color-result' ).trigger( 'clock' );
					}
				);
			}
		);
	}
	jv_wgColorPicker();

	/*
	 *	Theme Settings : Tabs
	 *
	 */

	if( typeof jvfrm_home_ts_variable != 'undefined' ) {

		var jv_theme_settings_func = function() {
			this.args = jvfrm_home_ts_variable;
			this.init();
		};

		jv_theme_settings_func.prototype = {

			constructor : jv_theme_settings_func,
			init : function() {

				var obj = this;

				obj.container = $( 'form#jvfrm_home_ts_form' );
				obj.saveButton();

				obj.swapTab( 'general' );

				$( document ).on( 'click', $( 'a.javo-opts-group-tab-link-a', this.container ).selector, function( e ){
					e.preventDefault();
					obj.swapTab( $( this ).attr( 'tar' ) );
				} );

			},

			saveButton : function() {

				var
					obj = this,
					form = obj.container,
					exportField = $( ".jv-export-textarea", form ),
					btnSave = $( '.jvfrm_home_btn_ts_save', form ),
					args = obj.args;

				$( document ).on( 'click', btnSave.selector, function() {

					form.addClass( 'disabled process' );

					$.post(
						args.ajaxurl,
						form.serialize(),
						function( response ){

							form.removeClass( 'process' );

							if( response.state == 'OK' ){
								exportField.val( response.code );
								form.addClass( 'saved' );
							}else{
								form.addClass( 'failed' );
							}
						},
						'json'
					)
					.fail( obj.saveError );
					obj.cleanWindow( form );
				} );
				return this;
			},

			saveError : function( e ) {
				console.log(  e );
			},

			cleanWindow : function( form ) {
				var nTimeID = setInterval( function(){
					form
						.removeClass( 'disabled' )
						.removeClass( 'process' )
						.removeClass( 'saved' )
						.removeClass( 'failed' );
					clearInterval( nTimeID );
				}, 5000 );
			},

			swapTab : function( tabSlug ){
				var
					container = this.container,
					wrap = $( '#javo-opts-main', container ),
					tabs = $( '#javo-opts-group-menu', container ),
					tabs_contents = $( '.jvfrm_home_ts_tab', container );

				$( 'li', tabs ).removeClass( 'active' );
				$( 'a[tar="' + tabSlug + '"]', container ).closest( 'li' ).addClass( 'active' );
				tabs_contents.addClass( 'hidden' );

				$( ".jvfrm_home_ts_tab[tar='" + tabSlug + "']" ).removeClass( 'hidden' );
			}
		}
		new jv_theme_settings_func;


		/*
		 *	Theme Settings : Import/Export/Reset
		 *
		 */
		$("body").on("click", ".javo-btn-ts-reset", function(){
			if(!confirm( jvfrm_home_ts_variable.strReset )) return false;
			$("#javo-ts-admin-field").val('');

			if( $(this).hasClass('default') ){
				$('#javo-ts-admin-field').val( $('[data-javo-ts-default-value]').val() );
			}; // Set Default ThemeSettings Values.

			$("form#javo-ts-admin-form").submit();
		}).on("click", ".javo-btn-ts-import", function(){
			if( $('.javo-ts-import-field').val() == "") return false;
			if(!confirm( jvfrm_home_ts_variable.strImport )) return false;
			$("#javo-ts-admin-field").val( $('.javo-ts-import-field').val() );
			$("form#javo-ts-admin-form").submit();
		});


		/*
		 *	Theme Settings : Media Library Includer
		 *
		 */
		// WordPress media upload button command.
		$("body").on("click", ".fileupload", function(e){
			var attachment;
			var t = $(this).attr("tar");
			e.preventDefault();
			var file_frame;
			if(file_frame){ file_frame.open(); return; }
			file_frame = wp.media.frames.file_frame = wp.media({
				title: jQuery( this ).data( 'uploader_title' ),
				button: {
					text: jQuery( this ).data( 'uploader_button_text' ),
				},
				multiple: false
			});
			file_frame.on( 'select', function(){
				attachment = file_frame.state().get('selection').first().toJSON();
				$("input[type='text'][tar='" + t + "']").val(attachment.url);
				$("img[tar='" + t + "']").prop("src", attachment.url);
			});
			file_frame.open();
			// Upload field reset button
		}).on("click", ".fileuploadcancel", function(){
			var t = $(this).attr("tar");
			$("input[type='text'][tar='" + t + "']").val("");
			$("img[tar='" + t + "']").prop("src", "");
		});

		/*
		 *	Theme Settings : Type to only number textfield.
		 *
		 */
		$('.only_number').each( function(){
			$(this).on('keyup', function(e){
				this.value = this.value.replace(/[^0-9.]/g, '');
			});
		});

		/*
		 *	Theme Settings : Font Control slider
		 *
		 */
		$( document ).on( 'javo:theme_settings_after',
			function(){
				$(".jvfrm_home_setting_slider").each(function(){
					$(this).noUiSlider({
						start: $(this).data('val')
						, step:1
						, range:{ min:[7], max:[100] }
						, connect:'lower'
						, serialization:{
							lower:[$.Link({
								target: $($(this).data('tar'))
								, format:{decimals:0}
							})]
						}
					});
				});
				$('.jvfrm_home_setting_slider.noUi-connect').css('background', '#454545');
			}
		);
	} // Undefined != jv_ts_variable


	/*
	 *	Metabox : Scripts
	 *
	 */
	var jvfrm_home_post_meta_scripts = function(){
		if( typeof jvfrm_home_metabox_variable != 'undefined' )
			this.init();
	}

	jvfrm_home_post_meta_scripts.prototype = {

		constrcutor : jvfrm_home_post_meta_scripts
		, init:function()
		{
			var optionBox	= $( "div#jvfrm_home_page_settings" );
			//this.item_meta();

			this.others();

			$( document )
				.on( 'change', "input[name='post_format']", this.format_meta() )
				.on( 'change', 'select[data-docking]', this.opacity_docking )
				.on( 'change', 'select[name="page_template"]', this.visibilityTab() )
				.on( 'click', $( "ul.jv-page-settings-nav > li.jv-page-settings-nav-item", optionBox ).selector, this.tabOptionPanel() )
				.on( 'click', '.jv-uploader-wrap > button.upload', this.fileUploader() )
				.on( 'click', '.jv-uploader-wrap > button.remove', this.fileRemove() )

			;$( "select[name='page_template'], select[data-docking]" ).trigger('change');
			;$( "input[name='post_format']" ).trigger( 'change' );
			;$( 'input[name="jvfrm_home_map_opts[cluster]"]' ).trigger('change')
			//;$( "select[data-autocomplete]" ).chosen({ search_contains:1 });
		}

		, tabOptionPanel : function() {
			return function() {
				var
					container		= $( this ).closest( 'div.jv-page-settings-wrap' )
					, navs			= $( 'li.jv-page-settings-nav-item', container )
					, contents		= $( '.jv-page-settings-content', container )
					, tarContent	= $( 'div' + $( this ).data( 'content' ), container );

				navs.removeClass( 'active' );
				contents.removeClass( 'active' );
				tarContent.addClass( 'active' );
				$( this ).addClass( 'active' );
			}
		}

		, visibilityTab : function() {
			return function( e ){
				var
					container		= $( "div.jv-page-settings-wrap" )
					, nav			= $( "ul.jv-page-settings-nav", container )
					, items			= $( "li.jv-page-settings-nav-item.require-template" )
					, template		= $( this ).val();

				items.addClass( 'hidden' );
				$( "li[data-require='" + template + "']", nav ).removeClass( 'hidden' );
				$( "li:first-child", nav ).trigger( 'click' );
			}
		}

		, opacity_docking: function( e )
		{
			var target = $( this ).closest( 'tr' ).find( 'input[type="text"]' );

			if( $( this ).val() != "enable" )
			{
				target.prop( 'disabled', true );
			}else{
				target.prop( 'disabled', false );
			}
		}

		, format_meta : function ()
		{
			var obj			= this;
			return function (e)
			{
				e.preventDefault();

				$( "[id^='jvfrm_home_postFormat']" ).hide();
				$( "#jvfrm_home_postFormat_" + $( 'input[name="post_format"]:checked' ).val() ).show();
			}
		}

		, fileUploader : function() {
			var
				obj				= this
				, uploader		= false;
			return function( e ) {
				e.preventDefault();
				var
					container	= $( this ).closest( '.jv-uploader-wrap' )
					, input		= $( 'input[type="text"]', container )
					, preview	= $( "img", container );

				if( !uploader ) {
					uploader	= wp.media.frames.file_frame = wp.media( {
						title		: $( this ).data( 'title' ) || 'Uploader',
						button	: {
							text	: $( this ).data( 'btn' ) || 'Select',
						},
						multiple	: false
					} );
				}

				// Events
				uploader.off( 'select' ).on( 'select',
					function() {
						var response	= uploader.state().get( 'selection' ).first().toJSON();

						if( typeof input.data( 'id' ) != 'undefined' ) {
							console.log( response );
							input.val( response.id );
						}else{
							input.val( response.url );
						}
						preview.prop( 'src', response.url );
					}
				).open();
				return;
			}
		}

		, fileRemove : function()  {
			var obj				= this;
			return function( e ) {
				e.preventDefault();
				var
					container	= $( this ).closest( '.jv-uploader-wrap' )
					, input		= $( 'input[type="text"]', container )
					, preview	= $( "img", container );

				input.val( null );
				preview.prop( 'src', '' );
			}
		}


		, others: function(){
			$( document ).on("click", ".jvfrm_home_pmb_option", function(){
				if( $(this).hasClass("sidebar") ) $(".jvfrm_home_pmb_option.sidebar").removeClass("active");
				if( $(this).hasClass("header") ) $(".jvfrm_home_pmb_option.header").removeClass("active");
				if( $(this).hasClass("fancy") ) $(".jvfrm_home_pmb_option.fancy").removeClass("active");
				if( $(this).hasClass("slider") ) $(".jvfrm_home_pmb_option.slider").removeClass("active");
				$(this).addClass("active");
			}).on("change", "input[name='jvfrm_home_opt_header']", function(){
				$("#jvfrm_home_post_header_fancy, #jvfrm_home_post_header_slide").hide();
				switch( $(this).val() ){
					case "fancy": $("#jvfrm_home_post_header_fancy").show(); break;
					case "slider": $("#jvfrm_home_post_header_slide").show(); break;
				};
			});

			$("body").on("change", "input[name='jvfrm_home_opt_slider']", function(){
				$(".jvfrm_home_pmb_tabs.slider")
					.children("div")
					.removeClass("active");
				$("div[tab='" + $(this).val() + "']").addClass("active");
			});
			var t = jvfrm_home_metabox_variable.strHeaderSlider;
			if(t != "")$("input[name='jvfrm_home_opt_slider'][value='" + t + "']").trigger("click");

			var t = jvfrm_home_metabox_variable.strHeaderFancy;
			if(t != "")$("input[name='jvfrm_home_opt_fancy'][value='" + t + "']").trigger("click");

		// End Other Function
		}
	}
	new jvfrm_home_post_meta_scripts;

	/*
	 *	Helper : Scripts
	 *
	 */
	var jv_admin_helper_script = function() {
		this.init();
	}

	jv_admin_helper_script.prototype= {
		constructor : jv_admin_helper_script
		, init : function() {
			var container	= $( "table.jv-default-setting-status-table" );
			$( document ).on( 'click', $( 'thead > tr', container ).selector , this.collapseToggle );
			$( window ).on( 'load', this.progressCounter );
		}

		, collapseToggle : function()
		{
			var
				container		= $( this ).closest( 'table.jv-default-setting-status-table' )
				, wrap			= $( this ).closest( 'div.jv-default-setting-status-wrap' )

			$( 'table', wrap ).not( container ).removeClass( 'collapse' );

			if( container.hasClass( 'collapse' ) ) {
				container.removeClass( 'collapse' );
			}else{
				container.addClass( 'collapse' );
			}
		}

		, progressCounter : function()
		{
			var
				wrap				= $( 'div.jv-default-setting-status-wrap' )
				, count			= $( 'div.jv-default-setting-status-progress', wrap )
				, total			= $( 'table > thead > tr', wrap ).length
				, active			= $( 'table > thead > tr', wrap ).not( '.update' ).length
				, cur				= ( active / total  ) * 100;
			$( { progress: 0 } )
				.animate(
					{progress : cur }
					, {
						duration : 3500
						, easing: 'swing'
						, step : function() {
							$( 'span', count ).text( Math.ceil( this.progress ) + ' %' );
						}
					}
				);
		}
	}
	new jv_admin_helper_script;

} )( jQuery, window );