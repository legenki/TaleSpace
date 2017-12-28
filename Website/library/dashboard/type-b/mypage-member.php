<?php
/**
***	My Review Lists
***/

global
	$jvfrm_home_curUser
	, $manage_mypage;

$jvfrm_home_dashboard_tabs	= apply_filters( 'jvfrm_home_dashboard_' . jvfrm_home_dashboard()->page_style . '_nav',
	Array(
		'my-items'		=> Array(
			'label'		=> esc_html__( "My List", 'javohome' ),
			'active'	=> true,
		),
	)
);


require_once JVFRM_HOME_DSB_DIR . '/mypage-common-header.php';
get_header(); ?>

<div class="jv-my-page">
	<div class="row top-row container">
		<h2 class="jv-my-page-user-name"><?php printf('%s', $jvfrm_home_curUser->display_name);?></h2>
		<div class="col-md-12">
			<?php get_template_part('library/dashboard/' . jvfrm_home_dashboard()->page_style . '/sidebar', 'user-info');?>
		</div> <!-- col-12 -->
	</div> <!-- top-row -->

	<div class="container second-container-content">
		<div class="row row-offcanvas row-offcanvas-left jv-mypage-home">
			<div class="col-xs-12 col-sm-12 main-content-right" id="main-content">
				<div class="row">
					<div class="col-md-12">
						<div class="panel panel-default panel-wrap">

							<div class="panel-heading">
							</div> <!-- panel-heading -->

							<div class="panel-body">
								<ul class="nav nav-tabs" role="tablist">
									<?php
									if( !empty( $jvfrm_home_dashboard_tabs ) ) : foreach( $jvfrm_home_dashboard_tabs as $tabID => $arrMeta ){
										$is_active	= isset( $arrMeta['active'] ) ? " class=\"active\" " : false;
										echo "<li role=\"presentation\"{$is_active}>
												<a href=\"#{$tabID}\" aria-controls=\"{$tabID}\" role=\"tab\" data-toggle=\"tab\">{$arrMeta['label']}</a>
											</li>";
									} endif; ?>
								 </ul>
								<?php
								$strPaymentShortcode	= 'lava_' . jvfrm_home_core()->slug . '_orders';
								$strFavoriteShortcode		= 'lava_' . jvfrm_home_core()->slug . '_favorites'; ?>
								<div class="tab-content">
									<div role="tabpanel" class="tab-pane active" id="my-items">
									<!-- Starting Content -->
										<?php do_action( 'jvfrm_home_dashboard_mylists', $jvfrm_home_curUser ); ?>
									<!-- End Content -->
									</div> <!-- #my-items -->
									<div role="tabpanel" class="tab-pane" id="jv-favorite">
										<?php
										if( shortcode_exists( $strFavoriteShortcode ) ) {
											echo do_shortcode( '[' . $strFavoriteShortcode . ']' );
										}else{
											printf( "<div class='jv-mypage-not-found-dat'>%s</div>", esc_html__( "Not found any data", 'javohome' ) );
										} ?>
									</div><!-- #jv-favorite -->
									<?php if( $jvfrm_home_curUser->ID == get_current_user_id() ){ ?>
									<div role="tabpanel" class="tab-pane" id="jv-payment">
										<?php
										if( shortcode_exists( $strPaymentShortcode ) ) {
											echo do_shortcode( '[' . $strPaymentShortcode . ']' );
										}else{
											printf( "<div class='jv-mypage-not-found-dat'>%s</div>", esc_html__( "Not found any data", 'javohome' ) );
										} ?>
									</div><!-- #jv-payment -->
									<?php } ?>
								</div><!-- tab-content -->
							</div><!-- panel-body -->
						</div> <!-- panel -->
					</div> <!-- col-md-12 -->
				</div><!--/row-->
			</div><!-- wrap-right -->
		</div><!--/row-->
	</div><!--/.container-->
</div><!--jv-my-page-->

<form method="post" id="lava-realestate-manager-myapge-form">
	<?php wp_nonce_field( 'security', 'lava_realestate_manager_mypage_delete' ); ?>
	<input type="hidden"name="post_id" value="">
</form>

<?php
$lava_output_variable	= Array();
$lava_output_variable[]	= "<script type=\"text/javascript\">";
$lava_output_variable[]	= sprintf( "var strLavaTrashConfirm = '%s'", __( "Do you want to delete this item?", 'javohome') );
$lava_output_variable[]	= "</script>";
echo @implode( "\n", $lava_output_variable );
?>
<script type="text/javascript">
jQuery( function( $ ){
	var lava_realestate_manager_mypage = function( el ) {
		this.el	= el;
		if( typeof this.instance === 'undefined' )
			this.init();
	}
	lava_realestate_manager_mypage.prototype = {
		constructor : lava_realestate_manager_mypage
		, init : function(){
			var obj			= this;
			obj.instance	= 1;
			$( document )
				.on( 'click', '[data-lava-realestate-manager-trash]', obj.trash() );
		}
		, trash : function()
		{
			var obj = this;
			return function( e )
			{
				e.preventDefault();
				var post_id		= $( this ).data( 'lava-realestate-manager-trash' );
				if( confirm( strLavaTrashConfirm ) ) {
					obj.el.find( "[name='post_id']").val( post_id );
					obj.el.submit();
				}
			}
		}
	}
	new lava_realestate_manager_mypage( $( "#lava-realestate-manager-myapge-form" ) );
} );
</script>
<?php get_footer();