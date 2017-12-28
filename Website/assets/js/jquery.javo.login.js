( function( $ ){
	"use strict";

	var jvfrm_home_ajax_login = function ( el ) {
		this.form = el;
		this.param = jvfrm_home_login_param;
		this.ajaxurl = jvfrm_home_login_param.ajaxurl;

		if( el.length )
			this.init();
	}

	jvfrm_home_ajax_login.prototype = {

		constructor : jvfrm_home_ajax_login,

		init : function () {
			$( document )
				.on( 'submit', this.form.selector, this.submit() )
				.on( 'submit', '[data-javo-modal-register-form]', this.join_submit() )
				.on( 'click', 'a[data-target="#register_panel"], a[data-target="#login_panel"]', this.swap_panel() )
				.on( 'javo:loginProcessing', this.processing() );
		},

		submit : function () {
			var obj				= this;
			return function( e )
			{
				e.preventDefault();
				$.ajaxSetup({
					beforeSend	: function () {
						$( document ).trigger( 'javo:loginProcessing' );
					}
					, complete	: function () {
						$( document ).trigger( 'javo:loginProcessing', new Array( true ) );
					}
				});
				$.post(
					obj.ajaxurl
					, obj.form.serialize()
					, function ( xhr ){
						if( xhr && xhr.error ) {
							$.jvfrm_home_msg({ content: xhr.error || "Failed" });
						}else{
							if( xhr && xhr.state == 'OK' ){
								if( xhr.redirect == '#' ){
									location.reload();
								}else{
									location.href = xhr.redirect;
								}
							}
						}
					}
					, 'json'
				)
				.fail( function(xhr) {
					console.log( xhr.responseText );
				} );
			}
		},

		processing : function () {
			var obj		= this;
			return function ( event, able )
			{
				var
					selector		= obj.form.selector
					, elements		= $( selector + ' *' )
					, submit		= obj.form.find( "[type='submit']" );
				if( able ) {
					elements.prop( 'disabled', false )	.removeClass( 'disabled' );
					submit.button( 'reset' );
				}else{
					elements.prop( 'disabled', true )	.addClass( 'disabled' );
					submit.button( 'loading' );
				}
			}
		},

		join_submit : function() {

			var obj = this;

			return function( e ) {
				e.preventDefault();

				var $this = $(this);

				$( this ).find('input').each( function(){
					if( $(this).val() == '' ){
						if( ! $( this ).hasClass( 'no-require' ) )
							$(this).addClass('isNull');
					}else{
						$(this).removeClass('isNull');
					}
				});

				if( $(this).find('[name="user_pass"]').val() != $(this).find('[name="user_con_pass"]').val() ){
					$(this).find('[name="user_pass"], [name="user_con_pass"]').addClass('isNull');
					return false;
				}else{
					$(this).find('[name="user_pass"], [name="user_con_pass"]').removeClass('isNull');
				}

				if( $(this).find('[name="user_login"]').get(0).value.match(/\s/g) ){
					var str = obj.param.errUserName;
					$.jvfrm_home_msg({ content:str }, function(){ $(this).find('[name="user_login"]').focus(); });
					$(this).find('[name="user_login"]').addClass('isNull');
				}

				if( $(this).find('.isNull').length > 0 )
					return false;

				if( $( ".javo-register-agree" ).length > 0 )
					if( ! $( ".javo-register-agree" ).is( ":checked" ) ) {
						$.jvfrm_home_msg({ content: obj.param.errNotAgree });
						return false;
					}

				$( this ).find('[type="submit"]').button('loading');

				$.ajax({
					url: obj.ajaxurl,
					type:'post',
					data: $( this ).serialize(),
					dataType:'json',
					error: function(e){  },
					success: function(d){
						if( d.state == 'success'){
							$.jvfrm_home_msg({content:obj.param.strJoinComplete, delay:3000}, function(){
								document.location.href= d.link;
							});
						}else{
							if(d.comment){
								$.jvfrm_home_msg({ content:d.comment, delay:100000 });
							}else{
								$.jvfrm_home_msg({ content:obj.param.errDuplicateUser, delay:100000 });
							}
						}
						$this.find('[type="submit"]').button('reset');
					}
				});


			}
		},
		swap_panel : function() {
			return function( e ) {
				$( this ).closest( '.modal' ).modal( 'hide' );
			}
		}
	}

	$.jvfrm_home_login = function( el ){
		new jvfrm_home_ajax_login( el );
	}

} )( jQuery, window );