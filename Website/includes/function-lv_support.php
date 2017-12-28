<?php

function jvfrm_single_support_navigation(){
	return apply_filters(
		'jvfrm_home_detail_support_nav'
		, Array(
			'page-style'				=> Array(
				'label'					=> esc_html__( "Top", 'javohome' )
				, 'class'				=> 'glyphicon glyphicon-home'
				, 'type'				=> Array( get_post_type() )
			)
		)
	);
}


// when the init hook fires
add_action( 'init', 'sillo_remove_that_filter' );
function sillo_remove_that_filter() {
    remove_filter( 'comments_template', 'lava_support_ticket_comment_template' );
}


function lava_support_ticket_comment_template_in_spot( $comment_template ) 
	{	
		global $post;
		 global $lava_support_desk;

		 if ( !( is_singular() && ( have_comments() || 'open' == $post->comment_status ) ) ) {
			return;
		 }
		 if($post->post_type == 'lv_support'){ 			
				$lava_comment_template	= get_template_directory() . "/lava-support-desk/lava-support-desk-comments.php";				
			return $lava_comment_template;
		}
	}
//remove_filter( "comments_template", 'lava_support_ticket_comment_template');
add_filter( "comments_template", 'lava_support_ticket_comment_template_in_spot');
