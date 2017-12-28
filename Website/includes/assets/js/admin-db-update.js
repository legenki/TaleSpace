( function( $ ){

	var jvfrm_home_admin_db_update = function(){

		this.args = jvfrm_home_admin_db_update_args;

		this.functions = new Array(
			'part_page_shortcode',
			'part_page_setting',
			'part_theme_setting'
		);

		this.init();

	}

	jvfrm_home_admin_db_update.prototype = {

		constructor : jvfrm_home_admin_db_update,

		init : function() {

			var obj = this;

			$( document )
				.on( 'click', '.jvfrm-home-db-update-trigger', function( e ){
					e.preventDefault();
					var
						container = $( '.jv-db-update-wrap' ),
						agree = $( 'input[type="checkbox"][name="agree"]', container ),
						is_accept = agree.is( ':checked' );
					if( is_accept ) {
						obj.start( this );
					}else{
						alert( obj.args.strNotAgree );
						agree.focus();
					}
				} );
		},

		start : function( button ) {

			var
				obj = this,
				parent = $( button ).closest( 'tr' ),
				output = $( 'textarea.code', parent );

			obj.output = function( strMsg ){
				output.append( strMsg + '\n' );
				output.scrollTop( output.get(0).scrollHeight );
			}

			obj.part_finish = function() {
				obj.output( obj.args.strCompleted );
				$( button ).prop( 'disabled', false ).removeClass( 'disabled' );
			}

			$( button ).prop( 'disabled', true ).addClass( 'disabled' );
			output.empty().removeClass( 'hidden' );
			obj.output( obj.args.strStart );

			obj.step = 0;
			obj.process();
		},

		process : function(){
			var
				obj = this,
				func = obj.functions;

			if( ! func.length )
				return false;

			if( obj.step >= func.length ){
				obj.part_finish();
			}else{
				this[ obj.functions[ obj.step ] ]();
				obj.step++;
			}
			return false;
		},

		ajax : function( action, callback ) {

			var obj = this;
			$.post(
				obj.args.ajaxurl,
				{ action : obj.args.prefix + action },
				callback,
				'JSON'
			)
			.fail( function( xhr ) {
				console.log( "Error", xhr );
			} )
			.always( function( xhr ){} );

		},

		part_page_shortcode : function() {
			var  obj = this;
			obj.ajax( 'part_page_shortcode', function( response ){
				if( response.result ){
					obj.output( obj.args.strPageShortcodesOK );
					obj.process();
				}else{
					obj.output( obj.args.strFail );
				}
			} );
		},

		part_page_setting : function() {
			var  obj = this;
			obj.ajax( 'part_page_setting', function( response ){
				if( response.result ){
					obj.output( obj.args.strPageSettingsOK );
					obj.process();
				}else{
					obj.output( obj.args.strFail );
				}
			} );
		},

		part_theme_setting : function() {
			var  obj = this;
			obj.ajax( 'part_theme_setting', function( response ){
				if( response.result ){
					obj.output( obj.args.strThemeSettingOK );
					obj.process();
				}else{
					obj.output( obj.args.strFail );
				}
			} );
		},

		part_widgets : function() {
			var  obj = this;
			obj.ajax( 'part_widgets', function( response ){
				if( response.result ){
					obj.output( 'Widgets 완료.' );
					obj.process();
				}else{
					obj.output( obj.args.strFail );
				}
			} );
		},

	}

	new jvfrm_home_admin_db_update;

} )( jQuery );