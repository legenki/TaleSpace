;(function($){
	"use strict";
	jQuery.jvfrm_home_mail = function(d, a, b){
		d = $.extend( true, {}, {
			url:null
			, subejct: null
			, to: null
			, from: null
			, content: null
			, to_null_msg: "Please, to email adress."
			, from_null_msg: "Please, from email adress."
			, subject_null_msg: "Please, insert Subject(or name)"
			, content_null_msg: "Please, insert content"
			, successMsg: "Successfully !"
			, failMsg: "Sorry mail send failed"
			, confirmMsg: "Send this email ?"
			, hide:null
			, callback:null
			, item_name:null
			}, d);
		var options = {};
		options.url = d.url;
		options.type = "post";
		options.data = {
			subject: d.subject.val()
			, to: d.to
			, from: d.from.val()
			, content: "From : "+d.from.val()+"<br><br>Name : "+d.subject.val()+"<br><br>Item Name: "+d.item_name+"<br><br>Content : "+d.content.val()
			, action: "send_mail"
		};
		options.dataType = "json";
		options.error = function(e){
			$.jvfrm_home_msg({ content: 'Error : ' + e.state() });
			console.log( e.responseText );
		};
		options.success = function(data){
			if(data.result){
				$.jvfrm_home_msg({ content:d.successMsg });
				if( typeof d.callback == "function" ) d.callback();
			}else{
				$.jvfrm_home_msg({ content:d.failMsg });
			};
			if( typeof a == 'function' && typeof b == 'function' ){
				b();
			}else if( typeof a == 'function' && (typeof b == 'undefined' || b == null)){
				a();
			};
		};
		function is_rm_null(str, msg){
			if( typeof(str) != null && str.val() != "") return;
			str
				.css({
					"border":"solid 1px #f00"
					, "background":"#fee"
				})
				.focus();
			$.jvfrm_home_msg({ content:msg });
			return false;
		};
		if( is_rm_null(d.subject, d.subject_null_msg ) == false ) return false;
		if( is_rm_null(d.from, d.from_null_msg ) == false ) return false;
		if( is_rm_null(d.content, d.content_null_msg ) == false ) return false;
		if(!confirm(d.confirmMsg)) return false;
		// Before Callback
		if( typeof a == 'function' && typeof b == 'function' ){
			a();
		};
		$.ajax(options);
	};
})(jQuery);