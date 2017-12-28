<?php
function jvfrm_home_single_detailImage( $image_size=Array( 400, 400 ), $images=5 ) {
	global $post, $jvfrm_home_tso;
	$arrOutput			= Array();
	$arrDetailImage		= $post->attach;
	if( !$images && is_array( $arrDetailImage ) )
		$images	= sizeof( $arrDetailImage );
	// Initialize
	for( $intCount=0; $intCount< $images; $intCount++ )
		$arrOutput[ $intCount ] = '';
	if( is_array( $arrDetailImage )){
		foreach( $arrDetailImage as $attach_index => $attach_id ){
			if( $strBuffer = wp_get_attachment_image( $attach_id, $image_size, 1, Array( 'class' => 'img-responsive' ) ) )
				$arrOutput[ $attach_index ] = $strBuffer;
		}
	}
	return $arrOutput;
}
function jvfrm_home_single_detailImagePart( $index=0 ) {
	$arrImages	= jvfrm_home_single_detailImage( 'jvfrm-home-box-v' );
	return isset( $arrImages[ $index ] ) ? $arrImages[ $index ] : '';
}
function jvfrm_home_detail_images_parse_for_lightGallery() {
	global $post;
	$arrOutput				= Array();
	$arrDetailImage			= $post->attach;
	if( !empty( $arrDetailImage ) ) : foreach( $arrDetailImage as $attach_id ) {
		$strFullSize		= wp_get_attachment_image_src( $attach_id, 'full' );
		$strThumbSize		= wp_get_attachment_image_src( $attach_id, 'jvfrm-home-tiny' );
		if( !empty( $strFullSize[0] ) ) {
			$arrOutput[]	= Array(
				'src'		=> $strFullSize[0],
				'thumb'		=> $strThumbSize[0]
			);
		}
	} endif;
	return esc_attr( json_encode( $arrOutput ) );
}
?>
<div id="javo-item-detail-image-section" data-images="<?php echo jvfrm_home_detail_images_parse_for_lightGallery();?>">
	<h3 class="page-header"><?php esc_html_e( "Gallery", 'javohome' ); ?></h3>
	<div class="row">
		<div class="col-md-4 col-xs-4">
			<a class="link-display">
				<?php echo jvfrm_home_single_detailImagePart(); ?>
				<div class="overlay"></div>
			</a>
		</div>
		<div class="col-md-4 col-xs-4">
			<a class="link-display">
				<?php echo jvfrm_home_single_detailImagePart(1); ?>
				<div class="overlay"></div>
			</a>
		</div>
		<div class="col-md-4 col-xs-4">
			<a class="link-display">
				<?php echo jvfrm_home_single_detailImagePart(2); ?>
				<div class="overlay"></div>
			</a>
		</div>
	</div>
	<div class="row">
		<div class="col-md-6 col-xs-6">
			<a class="link-display">
				<?php echo jvfrm_home_single_detailImagePart(3); ?>
				<div class="overlay"></div>
			</a>
		</div>
		<div class="col-md-6 col-xs-6">
			<a class="link-display">
				<?php echo jvfrm_home_single_detailImagePart(4); ?>
				<div class="overlay">
					<?php
					if( sizeof( $post->attach ) > 5 ) {
						printf( '<span>+ %s %s</span>', sizeof( $post->attach ) - 5, esc_html__( "More",'javohome' ));
					} ?>
				</div>
			</a>
		</div>
	</div>
</div>